<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_filter.php");
include("../include/inc_format.php");
include("../include/inc_flux_ano.php");
include("../include/inc_mail_compte_annonce.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_dtb_compte_recherche.php");
include("../include/inc_hits.php");
include("../include/inc_photo.php");
include("../include/inc_nav.php");
include("../include/inc_adsense.php");
include("../include/inc_tracking.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_tools.php");

if (!filtrer_les_entrees_get(__FILE__,__LINE__)) die;

dtb_connection();
count_cnx();

/* V�rifier qu'il y a l'arguement d'entr�e obligatoire */
isset($_GET['tel_ins']) ? $tel_ins = mysqli_real_escape_string($_GET['tel_ins']) : die;
make_hits($tel_ins);

// Savoir d'ou l'on vient / recherche carte / recherche liste / recherche directe / mail
isset($_REQUEST['from']) ? $rec_from = mysqli_real_escape_string($_REQUEST['from']) : $rec_from = '' ; 

// Si on vient de recherche carte on recoit les param�tres concernant la zone g�ographique
isset($_REQUEST['zone'])        ? $rec_zone          = trim($_REQUEST['zone'])        : $rec_zone        = '' ; 
isset($_REQUEST['zone_pays'])   ? $rec_zone_pays     = trim($_REQUEST['zone_pays'])   : $rec_zone_pays   = '' ; 
isset($_REQUEST['zone_dom'])    ? $rec_zone_dom      = trim($_REQUEST['zone_dom'])    : $rec_zone_dom    = '' ; 
isset($_REQUEST['zone_region']) ? $rec_zone_region   = trim($_REQUEST['zone_region']) : $rec_zone_region = '' ; 
isset($_REQUEST['zone_dept'])   ? $rec_zone_dept     = trim($_REQUEST['zone_dept'])   : $rec_zone_dept   = '' ; 
isset($_REQUEST['zone_ville'])  ? $rec_zone_ville    = trim($_REQUEST['zone_ville'])  : $rec_zone_ville  = '' ; 
isset($_REQUEST['zone_ard'])    ? $rec_zone_ard      = trim($_REQUEST['zone_ard'])    : $rec_zone_ard    = '' ; 
isset($_REQUEST['dept_voisin']) ? $rec_dept_voisin   = trim($_REQUEST['dept_voisin']) : $rec_dept_voisin = '' ; 

// Param�tres optionnel du filtrage
isset($_REQUEST['typp'])      ? $rec_typp     = trim($_REQUEST['typp'])     : $rec_typp     = '0' ;
isset($_REQUEST['P1'])        ? $rec_P1       = trim($_REQUEST['P1'])       : $rec_P1       = '0';
isset($_REQUEST['P2'])        ? $rec_P2       = trim($_REQUEST['P2'])       : $rec_P2       = '0' ;
isset($_REQUEST['P3'])        ? $rec_P3       = trim($_REQUEST['P3'])       : $rec_P3       = '0' ;
isset($_REQUEST['P4'])        ? $rec_P4       = trim($_REQUEST['P4'])       : $rec_P4       = '0' ;
isset($_REQUEST['P5'])        ? $rec_P5       = trim($_REQUEST['P5'])       : $rec_P5       = '0' ;
isset($_REQUEST['sur_min'])   ? $rec_sur_min  = trim($_REQUEST['sur_min'])  : $rec_sur_min  = '0' ;
isset($_REQUEST['prix_max'])  ? $rec_prix_max = trim($_REQUEST['prix_max']) : $rec_prix_max = '0';
isset($_REQUEST['ids'])       ? $rec_ids      = trim($_REQUEST['ids'])      : $rec_ids      = '1' ;

$query = "SELECT ida,tel_ins,zone,zone_pays,zone_dept,zone_ville,zone_ard,zone_dom,email,ok_email,tel_bis,typp,nbpi,surf,prix,quart,blabla,hits,maps_lat,maps_lng,quart,maps_actif,wwwblog FROM ano WHERE ( etat='ligne' OR etat='attente_paiement' OR etat='attente_validation' ) AND tel_ins='$tel_ins'";
$result = dtb_query($query,__FILE__,__LINE__,DEBUG_DETAILS);

// L� il va falloir am�liorer les choses.
if ( mysqli_num_rows($result) == 0 ) { echo "<p>Cette anonce n'est pas en ligne</p>"; die; }

list($ida,$tel_ins,$zone,$zone_pays,$zone_dept,$zone_ville,$zone_ard,$zone_dom,$email,$ok_email,$tel_bis,$typp,$nbpi,$surf,$prix,$quart,$blabla,$hits,$maps_lat,$maps_lng,$quart,$maps_actif,$wwwblog) = mysqli_fetch_row($result);

/* Voir si on ne peut pas enlever */
if ( $maps_actif == 0 ) {
  $maps_lng = 0.0;
  $maps_lat = 0.0;
}

/* Si le visiteur a un compte de recherche on aura les valeurs du compte sinon des valeurs par defaut */
$idc = get_idc(&$compte_email,&$compte_pass);
get_financement($idc,&$finance_actif,&$fixe,&$credit,&$apport,&$taux_annuel,&$nb_annee,__FILE__,__LINE__);

$titre = get_titre($zone_ville,$zone_ard,$typp,$nbpi,$surf,$prix);
$description = substr($blabla,0,140)."...";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title><?PHP echo $titre ?></title>
<meta name="Description" content="<?PHP echo $description ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="robots" content="<?PHP  echo_content($rec_from); ?>" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css"/>
<link href="/styles/styles-details.css" rel="stylesheet" type="text/css" />
<link href="/styles/lib-ph.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/jvscript/browser.js"></script>
<script type='text/javascript' src='/jvscript/popup.js'></script>
<script type='text/javascript' src='/jvscript/photo.js'></script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script>
<script type='text/javascript' src='/cons/jvscript/details.js'></script>
<script type='text/javascript' src='/cons/jvscript/calculette.js'></script>
<script type='text/javascript' src='/compte-recherche/jvscript/services.js'></script>
<script type='text/javascript'>
var browser = new Browser();
var map;
var maps_lat   = <?PHP echo "$maps_lat"; ?>;
var maps_lng   = <?PHP echo "$maps_lng"; ?>;
var maps_actif = <?PHP echo "$maps_actif"; ?>;
var quart = "<?PHP echo "$quart"; ?>";

var finance_actif = <?PHP echo "$finance_actif"; ?>;
var fixe = "<?PHP echo "$fixe"; ?>";
var credit = <?PHP echo "$credit"; ?>;
var apport = <?PHP echo "$apport"; ?>;
var taux_annuel = <?PHP echo "$taux_annuel"; ?>;
var nb_annee = <?PHP echo "$nb_annee"; ?>;

</script>
</head>
<body onload="load_map(); displayPics(); load_calculette(finance_actif,fixe,apport,credit,nb_annee,taux_annuel); calculette ();" onunload="GUnload()">
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='userpan'>
    <div id='header'> 
      <div id='logosag'><a href='/' title='WWW.TOP-IMMOBILIER-PARTICULIERS.FR'><img src="/images/pdm-120x60.gif" alt="WWW.TOP-IMMOBILIER-PARTICULIERS.FR"/></a></div>
      <h1><?PHP print_titre($prix,$typp,$nbpi,$surf); ?></h1>
      <div id='onglet'> 
        <?PHP make_ariane_details($rec_from,$rec_zone,$rec_zone_pays,$rec_zone_dom,$rec_zone_region,$rec_zone_dept,$rec_zone_ville,$rec_zone_ard,$rec_dept_voisin,$rec_typp,$rec_P1,$rec_P2,$rec_P3,$rec_P4,$rec_P5,$rec_sur_min,$rec_prix_max,$rec_ids); ?>
      </div>
    </div>
      <div id='centre'>
        <table id='tab_haut'>
          <tr>
            <td class='cell_g'>
              <div id='resume'><?PHP print_resume_produit($zone,$zone_pays,$zone_dept,$zone_ville,$zone_ard,$zone_dom,$prix,$quart,$typp,$nbpi,$surf,$hits); ?></div>
              <div id='blabla'><?PHP echo "$blabla"; ?> </div>
              <div id='contact'><?PHP print_contact_annonceur($tel_ins,$tel_bis,$ok_email,$wwwblog); ?></div>
            </td>
            <td class='cell_d'>
              <?PHP
              if ( $maps_actif == 1 ) echo "<div id='map'></div>";
              else echo "<img src='/images-pub/vendre-sans-agences-300x250.jpg' title='20 Euros pour 6 mois sur WWW.TOP-IMMOBILIER-PARTICULIERS.FR' alt='20 Euros pour 6 mois sur WWW.TOP-IMMOBILIER-PARTICULIERS.FR' />";
              ?>
            </td>
          </tr>
        </table>
        <table id='tab_centre'>
          <tr>
            <td id='cell_gauche'><?PHP print_bouton_alerte_baisse($idc,$compte_email,$compte_pass,$tel_ins,$prix); ?></td>
            <td id='cell_droite'><?PHP print_xiti_code('details'); ?></td>
          </tr>
        </table>
        <table id='tab_bas'>
          <tr>
            <td class='cell_g'>
              <div id='photo'>
                <?PHP
                $photo = get_photo_from_dir($ida);
                if ( count($photo) > 0 ) print_galerie_photo($photo);
                else print_adsense_336_280();
                ?>
              </div>
            </td>
            <td class='cell_d'>
              <?PHP 
              computer($idc,$prix);
					    print_bouton_memoriser_financement($idc,$compte_email,$compte_pass);
              tracking(CODE_RED,'OK',"Consultation fiche detail�e de $tel_ins",__FILE__,__LINE__);
              ?>
            </td>
          </tr>
        </table>
      </div>  <!-- end centre -->
    </div> <!-- end userpan -->
  </div> <!-- end mainpan -->
  <div id='footerpan'>&nbsp;</div><!-- end footerpan -->
</body>
</html>

<?PHP
//------------------------------------------------------------------------------------------------------------
function details($tel_ins) {

  $select = "SELECT ida,tel_ins,zone,zone_pays,zone_dept,zone_ville,zone_ard,zone_dom,email,ok_email,tel_bis,typp,nbpi,surf,prix,quart,blabla FROM ano WHERE etat='ligne' AND tel_ins='$tel_ins'";
  $result = dtb_query($select,__FILE__,__LINE__,DEBUG_DETAILS);

  if ( mysqli_num_rows($result) ) {

    list($ida,$tel_ins,$zone,$zone_pays,$zone_dept,$zone_ville,$zone_ard,$zone_dom,$email,$ok_email,$tel_bis,$typp,$nbpi,$surf,$prix,$quart,$blabla) = mysqli_fetch_row($result);

    print_resume_produit($zone,$zone_pays,$zone_dept,$zone_ville,$zone_ard,$zone_dom,$prix,$quart,$typp,$nbpi,$surf);
    print_blabla($blabla);
    print_contact_annonceur($tel_ins,$tel_bis,$ok_email);
    $photo = get_photo_from_dir($ida);
    if ( count($photo) > 0 ) print_galerie_photo($photo);

  } else {

    $etat = get_etat($tel_ins,__FILE__,__LINE__);
    if ( $etat == 'attente_validation' ) echo "<p>&nbsp;</p><p>&nbsp;</p><p class=text12cg>Cette annonce est en cours de v�rification</p>\n";
    else echo "<p>&nbsp;</p><p>&nbsp;</p><p class=text12cg>Il n'y a pas d'annonce au num�ro que vous demandez</p>\n";
  }
}
//------------------------------------------------------------------------------------------------------------
// Affichage du r�sum� des caract�ristiques du produit
function print_resume_produit($zone,$zone_pays,$zone_dept,$zone_ville,$zone_ard,$zone_dom,$prix,$quart,$typp,$nbpi,$surf,$hits) {
  $prix_euro_str = format_prix($prix);
  $prix_fran_str = format_prix(ceil($prix*6.55957));
  
  $prix_m2 = ceil($prix / $surf);

  $zone_ard_str  = format_ard($zone_ard);
  $quart = ucwords(strtolower($quart));
  $typp_str = ucfirst($typp); 
    echo "<p>\n";
      if ( $zone == 'paris' || $zone == 'region' ) echo "$zone_ville - $zone_ard_str"; 
      if ( $zone == 'france'   ) echo "$zone_ville - ( $zone_dept )";  
      if ( $zone == 'domtom'   ) echo "$zone_ville - ( $zone_dom )";  
      if ( $zone == 'etranger' ) echo "$zone_pays - ( $zone_ville )";  
    echo "</p>\n";
    if ( $zone_ard != 0 )     echo "<p>Arrondissement : $zone_ard</p>";
    if ( $quart != '' )echo "<p>Quartier : $quart</p>\n";
    echo "<p>Prix : $prix_euro_str Euros /  $prix_fran_str Francs</p>";
    echo "<p>Prix du m�tre carr� : $prix_m2 Euros</p>";
    echo "<p>Nombre de visites : $hits</p>\n";
}
//------------------------------------------------------------------------------------------------------------
// Affichage du contact annonceur
function print_contact_annonceur($tel_ins,$tel_bis,$ok_email,$wwwblog) {
  if ( $ok_email )
    echo "Contacter l'annonceur par mail <a href='/noref/contact-annonceur.php?action=print_form&tel_ins=$tel_ins' title=\"Contacter l'annonceur\" target='popup1' onclick='popup_contact(430,390);' rel='nofollow'><img src='/images/email_ano.jpg' alt=\"Contacter l'annonceur par mail\" /></a><br />\n";


  echo "<p>T�l�phone</p>";
  $tel_ins_str = format_telephone($tel_ins); 
  echo "<p>$tel_ins_str</p>";
  if ( $tel_bis != '0000000000' ) {
    $tel_bis_str = format_telephone($tel_bis); 
    echo "<p>$tel_bis_str</p>"; 
  }

  if ( $wwwblog != '' ) {
    echo "<p>Plus d'infos sur ce blog&nbsp;&nbsp;<a href='/compte-annonce/goto.php?tel_ins=$tel_ins&wwwblog=$wwwblog' target='_blank'>$wwwblog</a></p>\n";
  }

}
//------------------------------------------------------------------------------------------------------------
// Ici on passe les arguments de la derni�re recherche
function make_ariane_details($from,$zone,$zone_pays,$zone_dom,$zone_region,$zone_dept,$zone_ville,$zone_ard,$dept_voisin,$typp,$P1,$P2,$P3,$P4,$P5,$sur_min,$prix_max,$ids) {

  echo "<a href='/'>Accueil</a>";

  if ( $from == 'carte' && $zone == 'france' ) {

    $zone_arg = "zone=$zone&amp;zone_pays=$zone_pays&amp;zone_dom=$zone_dom&amp;zone_region=$zone_region&amp;zone_dept=$zone_dept&amp;zone_ville=$zone_ville&amp;zone_ard=$zone_ard";
    $filter   = "typp=$typp&amp;P1=$P1&amp;P2=$P2&amp;P3=$P3&amp;P4=$P4&amp;P5=$P5&amp;sur_min=$sur_min&amp;prix_max=$prix_max";   

    echo "&nbsp;&raquo;&nbsp;<a href=\"/cons/recherche-carte.php?${zone_arg}&amp;${filter}\" title='Retour aux r�sultats des recherches' rel='nofollow'>Retour aux cartes</a>";

  } else if ( $from == 'liste' ) {

    $zone_arg = "zone=$zone&amp;zone_pays=$zone_pays&amp;zone_dom=$zone_dom&amp;zone_region=$zone_region&amp;zone_dept=$zone_dept&amp;zone_ville=$zone_ville&amp;zone_ard=$zone_ard&amp;dept_voisin=$dept_voisin";
    $filter   = "typp=$typp&amp;P1=$P1&amp;P2=$P2&amp;P3=$P3&amp;P4=$P4&amp;P5=$P5&amp;sur_min=$sur_min&amp;prix_max=$prix_max&amp;ids=$ids";   

    echo "&nbsp;&raquo;&nbsp;<a href=\"/cons/recherche-liste.php?${zone_arg}&amp;${filter}\" title='Retour aux r�sultats des recherches' rel='nofollow'>Retour aux listes</a>";

  }

}
//------------------------------------------------------------------------------------------------------------
// Affichage du r�sum� des caract�ristiques du produit
function print_titre($prix,$typp,$nbpi,$surf) {
  $prix_str = format_prix($prix);
  $typp_str = ucfirst($typp); 
  echo "$typp_str de $nbpi Pi�ces de $surf m� environ\n";
}
//------------------------------------------------------------------------------------------------------------
// Affichage du content de robot selon from
function echo_content($from) {

  if ( $from == '' ) echo "index,follow";
	else echo "noindex,nofollow";

}
/*-----------------------------------------------------------------------------------------------*/
/*---*/
function computer($idc,$prix) {

  $frais_notaire      = calcul_frais($prix);
  $montant_a_financer = $prix + $frais_notaire; 

?>
<div id='computer'>
<div id='presentation'><p>Calcul de votre financement</p></div>
<div id='somme'>
      <table>
        <tr>
          <td>Prix de vente</td>
          <td><?PHP echo "$prix �"; ?><input type="hidden" id="prix" name="prix" value="<?PHP echo "$prix"; ?>" /></td>
        </tr>
        <tr>
          <td>Estimation des frais de notaire</td>
          <td><?PHP echo "$frais_notaire �"; ?><input type="hidden" id="frais" name="frais" value="<?PHP echo "$frais_notaire"; ?>" /></td>
        </tr>
        <tr>
          <td>Montant &agrave; financer</td>
          <td><?PHP echo "$montant_a_financer �"; ?><input type="hidden" id="montant_a_financer" name="montant_a_financer" value="<?PHP echo "$montant_a_financer"; ?>" /></td>
        </tr>
      </table>
</div>
<div id='switch'>
      <table>
        <tr> 
          <td>Je fixe le montant de mon apport</td>
          <td><input name="fixe" id="apport_radio" type="radio" value="apport_radio" checked="checked" onchange="clear_result();" /></td>
          <td><input name="apport" id="apport_montant" type="text" value="0" size="7" maxlength="7" /></td>
        </tr>
        <tr> 
          <td>Je fixe le montant de mon cr&eacute;dit</td>
          <td><input name="fixe" id="credit_radio" type="radio" value="credit_radio" onchange="clear_result();" /></td>
          <td><input name="credit" id="credit_montant" type="text" value="0" size="7" maxlength="7"/></td>
        </tr>
      </table>
</div>
<div id='credit'>

      <table>
        <tr> 
          <td>Dur&eacute;e</td>
          <td>
          <select id="nb_annee" name="nb_annee">
            <option value="3">3 Ans</option>
            <option value="4">4 Ans</option>
            <option value="5">5 Ans</option>
            <option value="6">6 Ans</option>
            <option value="7">7 Ans</option>
            <option value="8">8 Ans</option>
            <option value="9">9 Ans</option>
            <option value="10">10 Ans</option>
            <option value="11">11 Ans</option>
            <option value="12">12 Ans</option>
            <option value="13">13 Ans</option>
            <option value="14">14 Ans</option>
            <option value="15" selected="selected">15 Ans</option>
            <option value="16">16 Ans</option>
            <option value="17">17 Ans</option>
            <option value="18">18 Ans</option>
            <option value="19">19 Ans</option>
            <option value="20">20 Ans</option>
            <option value="21">21 Ans</option>
            <option value="22">22 Ans</option>
            <option value="23">23 Ans</option>
            <option value="24">24 Ans</option>
            <option value="25">25 Ans</option>
            <option value="26">26 Ans</option>
            <option value="27">27 Ans</option>
            <option value="28">28 Ans</option>
            <option value="29">29 Ans</option>
            <option value="30">30 Ans</option>
          </select>
          </td>
          <td rowspan="2"><input class="but_input" type='button' onclick='calculette();' value='Calculer' /></td>
        </tr>
        <tr> 
          <td>Taux</td>
          <td><input id="taux_annuel" name='taux_annuel' type='text' value='4.0' size="5" maxlength="5" /> en %</td>
        </tr>
      </table>
</div>
<div id='resultats'>
  <div id='res_mensualite'></div>
  <div id='res_apport'></div>
</div>
</div>
<?PHP
}
/*-----------------------------------------------------------------------------------------------*/
/*---*/
function calcul_frais($prix) { 

  $prix_vente = array(10000.0,20000.0,30000.0,40000.0,50000.0,60000.0,70000.0,80000.0,90000.0,100000.0,200000.0,300000.0,400000.0,500000.0,600000.0,700000.0,800000.0,900000.0,1000000.0,1200000.0,1400000.0,1600000.0,1800000.0,2000000.0,2250000.0,2500000.0,2750000.0,3000000.0,3500000.0,4000000.0,4500000.0,5000000);
  $frais_notaire =array(2000.0,2700.0,3300.0,3900.0,4500.0,5200.0,5800.0,6400.0,7000.0,7600.0,13800.0,20000.0,26200.0,32300.0,38500.0,44700.0,50900.0,57000.0,63200.0,75600.0,87900.0,100300.0,112600.0,125000.0,140400.0,155900.0,171300.0,186800.0,217600.0,248500.0,279400.0,310300);

  if ( $prix < $prix_vente[0] ) return false;
  if ( $prix >= $prix_vente[count($prix_vente)-1] ) return false;

  /* Rechercher la tranche */
  for ( $i=0 ; $i < (count($prix_vente)-1) ; $i++ ) {
  
    if ( $prix >= $prix_vente[$i] && $prix < $prix_vente[$i+1] ) {
    
      $prix_a = $prix_vente[$i];
      $prix_b = $prix_vente[$i+1];

      $frais_a = $frais_notaire[$i];
      $frais_b = $frais_notaire[$i+1];

      break; 
    
    }
  
  }

  /*
  echo "prix_a => $prix_a<br/>";
  echo "prix_b => $prix_b<br/>";
  echo "frais_a => $frais_a<br/>";
  echo "frais_b => $frais_b<br/>";
  */
  
  // On fait une interpol lin�aire
  $A = ( $frais_a - $frais_b ) / ( $prix_a - $prix_b );
  $B = $frais_a - ( $A * $prix_a ) ;
  $frais = ( $A * $prix ) + $B;

  /*
  echo "A => $A<br/>";
  echo "B => $B<br/>";
  echo "frais => $frais<br/>";
  */
  
  return $frais;

}
/*-----------------------------------------------------------------------------------------------*/
/*---*/
function print_bouton_alerte_baisse($idc,$compte_email,$compte_pass,$tel_ins,$prix) {

  echo "<div id='alerte_baisse'>\n";
  echo "<table>\n";
  // Ligne 1
  if ( $idc !== false ) echo "<tr><td colspan='2'><strong>Soyez inform� d�s la baisse du prix de ce produit <em>(*service Email gratuit)</em></strong></td></tr>\n";
  else  echo "<tr><td><strong>Soyez inform� d�s la baisse du prix de ce produit <em>(*service Email gratuit)</em></strong></td></tr>\n"; 

  // Ligne 2
  echo "<tr>\n";

  // Si on a autentifier un utilisateur
	if ( $idc !== false ) {

    // CELLULE DE GAUCHE.
		if ( get_deja_alerte_baisse($idc,$tel_ins,__FILE__,__LINE__) === true ) {

	    // Si il y a d�j� une alerte
      echo "<td class='cell_c'>Vous avez d�j� positionn�<br />une alerte sur cette annonce</td>\n";

    } else if ( get_max_alerte_baisse($idc,__FILE__,__LINE__) === true ) {

      $compte_recherche_max_alerte_baisse = COMPTE_RECHERCHE_MAX_ALERTE_BAISSE;

      // Si on a d�j� atteint le maximum d'alertes
      echo "<td class='cell_c'>Vous avez $compte_recherche_max_alerte_baisse alertes � la baisse<br />de positionn�es et c'est le maximum</td>\n";

    } else { 

      // Si tout est OK pour d�clencher une alerte
      echo "<td class='cell_c'>\n";
      echo "<span id='alerte_baisse_bouton'><input class='but_input' type='button' onclick=\"send_creer_alerte_baisse('$tel_ins','$prix');\" value='Cr�er une alerte' /></span>\n";
      echo "<span id='ok_alerte_baisse' style='display: none;'><p>Votre alerte a �t�<br />positionn�e avec succ�s</p></span>\n";
      echo "</td>\n";
		
	  }	
	
    // CELLULE DE DROITE.
    echo "<td class='cell_c'>\n";
    if ( $compte_email != '' ) echo "<span class='compte_email'>$compte_email</span><br />\n";
    echo "<form action='/compte-recherche/gestion-connexion-recherche.php' method='get' >\n"; 
    echo "<input type='hidden' name='action' value='demande_connexion' />\n";
    echo "<input type='hidden' name='from' value='details' />\n";
    echo "<input  class='but_input' type='submit' value='Votre compte' />\n";
    echo "</form>\n";
    echo "</td>\n";
	
	} else {
	  // Une seule cellule avec un lien vers l'accueil du compte recherche
    echo "<td class='cell_c'><a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche' title='Vous devez Cr�er ou Acc�der � votre compte recherche' class='navsearch11'>Cr�er ou Acc�der � votre compte recherche</a></td>\n";
	}

  // Fin ligne 2	
  echo "</tr>\n";
  echo "</table>\n";
  echo "</div>\n";

}
/*-----------------------------------------------------------------------------------------------*/
function print_bouton_memoriser_financement($idc,$compte_email,$compte_pass) {

  if ( $idc !== false ) {
?>
    <div id='compte_financement'>
		  <table>
        <tr><td colspan='2'><p><strong>Retrouver votre capacit� de financement sur toutes les fiches produits de ce site.</strong></p></td></tr>
        <tr>
			    <td class='cell_c'>
					  <span id='memoriser_financement_bouton'>Cliquer sur ce bouton<br/>pour m�moriser vos valeurs</span>
            <span id='ok_memoriser_financement' style='display: none;'>Vos valeurs ont �t�<br />m�moris�es avec succ�s</span>
					</td>
			    <td class='cell_c'><input  class='but_input' type='button' onclick='send_memoriser_financement();' value='M�moriser'/></td>
				</tr>
			</table>
	  </div>
<?PHP
  } else {
?>
    <div id='compte_financement'>
		  <table>
      <tr><td><p><strong>Retrouver votre capacit� de financement sur toutes les fiches produits de ce site.</strong></p></td></tr>
      <tr><td class='cell_c'><p><a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche' title='Vous devez Cr�er ou Acc�der � votre compte recherche' class='navsearch11'>Cr�er ou Acc�der � votre compte recherche</a></p></td></tr>
			</table>
    </div>
<?PHP
  }	
}
/*-----------------------------------------------------------------------------------------------*/
?>


