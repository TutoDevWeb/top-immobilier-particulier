<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_count_cnx.php");
include("../include/inc_tracking.php");
include("../include/inc_xiti.php");
include("../include/inc_tools.php");

dtb_connection();
count_cnx();

// Param�tres concernant la zone g�ographique
isset($_REQUEST['zone'])        ? $zone          = trim($_REQUEST['zone'])        : $zone        = '' ; 
isset($_REQUEST['zone_pays'])   ? $zone_pays     = trim($_REQUEST['zone_pays'])   : $zone_pays   = '' ; 
isset($_REQUEST['zone_dom'])    ? $zone_dom      = trim($_REQUEST['zone_dom'])    : $zone_dom    = '' ; 
isset($_REQUEST['zone_region']) ? $zone_region   = trim($_REQUEST['zone_region']) : $zone_region = '' ; 
isset($_REQUEST['zone_dept'])   ? $zone_dept     = trim($_REQUEST['zone_dept'])   : $zone_dept   = '' ; 
isset($_REQUEST['zone_ville'])  ? $zone_ville    = trim($_REQUEST['zone_ville'])  : $zone_ville  = '' ; 
isset($_REQUEST['zone_ard'])    ? $zone_ard      = trim($_REQUEST['zone_ard'])    : $zone_ard    = '' ; 
isset($_REQUEST['dept_voisin']) ? $dept_voisin   = trim($_REQUEST['dept_voisin']) : $dept_voisin    = '' ; 

// Param�tres optionnel du filtrage
isset($_REQUEST['typp'])      ? $typp     = mysqli_real_escape_string(trim($_REQUEST['typp'])) : $typp     = '0' ;
isset($_REQUEST['P1'])        ? $P1       = mysqli_real_escape_string(trim($_REQUEST['P1']))   : $P1       = '0' ;
isset($_REQUEST['P2'])        ? $P2       = mysqli_real_escape_string(trim($_REQUEST['P2']))   : $P2       = '0' ;
isset($_REQUEST['P3'])        ? $P3       = mysqli_real_escape_string(trim($_REQUEST['P3']))   : $P3       = '0' ;
isset($_REQUEST['P4'])        ? $P4       = mysqli_real_escape_string(trim($_REQUEST['P4']))   : $P4       = '0' ;
isset($_REQUEST['P5'])        ? $P5       = mysqli_real_escape_string(trim($_REQUEST['P5']))   : $P5       = '0' ;
isset($_REQUEST['sur_min'])   ? $sur_min  = mysqli_real_escape_string($_REQUEST['sur_min'])    : $sur_min  = '0' ;
isset($_REQUEST['prix_max'])  ? $prix_max = mysqli_real_escape_string($_REQUEST['prix_max'])   : $prix_max = '0' ;

check_nbpi(&$P1,&$P2,&$P3,&$P4,&$P5);

if ( $zone == 'france' ) {

  if ( $zone_ville != '' ) {

    $zone_ville_s = mysqli_real_escape_string($zone_ville);
    $zone_dept_s  = mysqli_real_escape_string($zone_dept);
    $query   = "SELECT v.ville,v.ville_url,v.ville_lat,v.ville_lng  FROM loc_ville as v, loc_departement as d  WHERE v.idd=d.idd AND v.ville='$zone_ville_s' AND d.dept='$zone_dept_s'";
    $result  = dtb_query($query,__FILE__,__LINE__,0);
    list($lieu,$lieu_url,$map_lat,$map_lng) = mysqli_fetch_row($result);
    $zoom = 11;

  } else if ( $zone_dept != '' ) {

    $zone_dept_s = mysqli_real_escape_string($zone_dept);
    $query   = "SELECT dept,dept_url,dept_lat,dept_lng  FROM  loc_departement WHERE dept='$zone_dept_s'";
    $result  = dtb_query($query,__FILE__,__LINE__,0);
    list($lieu,$lieu_url,$map_lat,$map_lng) = mysqli_fetch_row($result);
    $zoom = 9; 

  } else if ( $zone_region != '' ) {

    $zone_region_s = mysqli_real_escape_string($zone_region);
    $query   = "SELECT region,region_url,region_lat,region_lng  FROM  loc_region WHERE region='$zone_region_s'";
    $result  = dtb_query($query,__FILE__,__LINE__,0);
    list($lieu,$lieu_url,$map_lat,$map_lng) = mysqli_fetch_row($result);
    $zoom = 8; 

  } else {

    $lieu     = "France";
    $lieu_url = "france";
    $map_lat  = 46.255847;
    $map_lng  = 2.197266;
    $zoom     = 6;
  
  }

  $title        = "Immobilier entre particuliers : $lieu";
  $h1           = "Carte : $lieu";
  $keywords_url = "carte-$lieu_url";

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<title><?PHP echo "$title"  ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="robots" content="noindex,nofollow" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css"/>
<link href="/styles/styles-recherche-carte.css" rel="stylesheet" type="text/css" />
<link href="/styles/lib-filter.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/jvscript/popup.js"></script>
<script type="text/javascript" src="/jvscript/browser.js"></script>
<script type="text/javascript" src="/cons/jvscript/estate.js"></script>
<script type="text/javascript" src="/cons/jvscript/switchzone.js"></script>
<script type="text/javascript" src="/cons/jvscript/localization.js"></script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
var map;
var markerList   = new Array();
var browser      = new Browser();
var estate       = new Estate();
var switchzone   = new Switchzone();
var localization = new Localization();

//------------------------------------------------------------------------------------------------
function load_map() {

  if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById("map"));
    map.setCenter(new GLatLng(<?PHP echo "$map_lat,$map_lng"; ?>),<?PHP echo "$zoom";?>);
    map.addControl(new GSmallMapControl());
    GEvent.addListener(map,'moveend',update); 

    localization.show();
		estate.update();
    
  } // Fin if GBrowser
} // Fin load_map
//------------------------------------------------------------------------------------------------
function update() {
  localization.show();
  estate.update();
}
//------------------------------------------------------------------------------------------------
//]]>
</script>
</head>
<body onload="load_map();" onunload="GUnload()">
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='userpan'>
    <div id='header'> 
      <div id='logosag'><a href='/' title='WWW.TOP-IMMOBILIER-PARTICULIERS.FR'><img src="/images/pdm-120x60.gif" alt="WWW.TOP-IMMOBILIER-PARTICULIERS.FR"/></a></div>
      <h1>R�sultats des recherches sous formes de cartes</h1>
      <div id='navigation'><img src='/images/btn-navigation-120x20.gif' alt='Naviguer dans les zones g�ographiques'/></div>
      <div id='localization'></div>
    </div>
      <div id='gauche'>
        <?PHP 
        print_offre_zone();
        print_filter_zone($zone,$zone_pays,$zone_dom,$zone_region,$zone_dept,$zone_ville,$zone_ard,$dept_voisin,$typp,$P1,$P2,$P3,$P4,$P5,$sur_min,$prix_max);
        print_selection_zone();
        tracking(CODE_RCC,'OK',"Recherche Carte : $zone_region :: $zone_dept :: $zone_ville",__FILE__,__LINE__);
        print_xiti_code("recherche-carte"); 
        ?>
      </div>
      <div id='message'>
	      <div id='gg'><strong>Zoom</strong> : Double click sur la zone. Bouton de zoom <img src="/images/btn_zoom_plus.gif" alt="Zoom Augmenter"/>&nbsp;<img src="/images/btn_zoom_moins.gif" alt="Zoom Diminuer"/> <br/><strong>Navigation</strong> : Souris bouton gauche enfonc�. Bouton de navigation <img src="/images/btn_map_nav.gif" alt="Boutons de d�placement"/>. Ou lien de navigation.</div>
	      <div id='dd'><a href='#' title='Voir les r�sultats des recherches sous forme de listes' onclick='estate.backList();' rel='nofollow'><img id='bnt_liste' src='/images/btn_liste2.gif' alt='Voir les r�sultats des recherches sous forme de listes'/></a></div>
	    </div>
      <div id='map'></div>
      <div id='clearboth'>&nbsp;</div>
    </div> <!-- end userpan -->
  </div> <!-- end mainpan -->
  <div id='footerpan'>&nbsp;</div><!-- end footerpan -->
</body>
</html>
<?PHP
//--------------------------------------------------------------------------------
function print_offre_zone() {
?>
<div class='filter_box'>
  <h2>Offres de vente</h2>
  <div class="box_last">        
    <div id="nbr_ano_total"></div>
  </div>
</div>
<div class="arrow3"></div>
<?PHP
}
//--------------------------------------------------------------------------------
function print_filter_zone($zone,$zone_pays,$zone_dom,$zone_region,$zone_dept,$zone_ville,$zone_ard,$dept_voisin,$typp,$P1,$P2,$P3,$P4,$P5,$sur_min,$prix_max) {
?>
<div class='filter_box'>
  <form method="get" action="#">
  <h2>Filtrer par Crit�res</h2>
  <div class="box_dashed"><h3>Type</h3>
    <select id="typp" name="typp"  onchange="update();">
      <option value="<?PHP echo VAL_NUM_TOUS_PRODUITS; ?>" <?PHP if ( $typp ==  VAL_NUM_TOUS_PRODUITS) echo "selected='selected'";?>>Tous Produits&nbsp;&nbsp;</option>
      <option value="<?PHP echo VAL_NUM_APPARTEMENT; ?>"   <?PHP if ( $typp ==  VAL_NUM_APPARTEMENT )  echo "selected='selected'";?>>Appartement</option>
      <option value="<?PHP echo VAL_NUM_MAISON; ?>"        <?PHP if ( $typp ==  VAL_NUM_MAISON )       echo "selected='selected'";?>>Maison</option>
      <option value="<?PHP echo VAL_NUM_LOFT; ?>"          <?PHP if ( $typp ==  VAL_NUM_LOFT )         echo "selected='selected'";?>>Loft</option>
      <option value="<?PHP echo VAL_NUM_CHALET; ?>"        <?PHP if ( $typp ==  VAL_NUM_CHALET )       echo "selected='selected'";?>>Chalet</option>
    </select>
  </div>    
  <div class="box_dashed">
    <h3>Nombre de Pi�ces</h3><br/>
    <input type="checkbox" class="num_nbpi" id="P1" name="P1" value="1" <?PHP if ( $P1 == '1' ) echo "checked='checked'"; ?> onclick="update();" /> 1P&nbsp; 
    <input type="checkbox" class="num_nbpi" id="P2" name="P2" value="2" <?PHP if ( $P2 == '2' ) echo "checked='checked'"; ?> onclick="update();" /> 2P&nbsp; 
    <input type="checkbox" class="num_nbpi" id="P3" name="P3" value="3" <?PHP if ( $P3 == '3' ) echo "checked='checked'"; ?> onclick="update();" />&nbsp;3P<br /> 
    <input type="checkbox" class="num_nbpi" id="P4" name="P4" value="4" <?PHP if ( $P4 == '4' ) echo "checked='checked'"; ?> onclick="update();" /> 4P&nbsp; 
    <input type="checkbox" class="num_nbpi" id="P5" name="P5" value="5" <?PHP if ( $P5 == '5' ) echo "checked='checked'"; ?> onclick="update();" /> &nbsp;5P ou +</div>
  <div class="box_dashed">
    <h3>Surface min</h3><br />
    <select id="sur_min" name="sur_min"  onchange="update();">
    <option value="0">Surface&nbsp;&nbsp;</option>
    <option value="10"  <?PHP if ( $sur_min ==  '10') echo "selected='selected'";?>>10</option>
    <option value="20"  <?PHP if ( $sur_min ==  '20') echo "selected='selected'";?>>20</option>
    <option value="30"  <?PHP if ( $sur_min ==  '30') echo "selected='selected'";?>>30</option>
    <option value="40"  <?PHP if ( $sur_min ==  '40') echo "selected='selected'";?>>40</option>
    <option value="50"  <?PHP if ( $sur_min ==  '50') echo "selected='selected'";?>>50</option>
    <option value="60"  <?PHP if ( $sur_min ==  '60') echo "selected='selected'";?>>60</option>
    <option value="70"  <?PHP if ( $sur_min ==  '70') echo "selected='selected'";?>>70</option>
    <option value="80"  <?PHP if ( $sur_min ==  '80') echo "selected='selected'";?>>80</option>
    <option value="90"  <?PHP if ( $sur_min ==  '90') echo "selected='selected'";?>>90</option>
    <option value="100" <?PHP if ( $sur_min == '100') echo "selected='selected'";?>>100</option>
    </select>
  </div>
  <div class="box_last">
    <h3>Prix max</h3><br />
    <select id="prix_max" name="prix_max"  onchange="update();">
    <option value="0">Prix Max&nbsp;&nbsp;</option>
    <option value="100000"  <?PHP if ( $prix_max ==  '100000') echo "selected='selected'";?> >100000</option>
    <option value="200000"  <?PHP if ( $prix_max ==  '200000') echo "selected='selected'";?> >200000</option>
    <option value="300000"  <?PHP if ( $prix_max ==  '300000') echo "selected='selected'";?> >300000</option>
    <option value="400000"  <?PHP if ( $prix_max ==  '400000') echo "selected='selected'";?> >400000</option>
    <option value="500000"  <?PHP if ( $prix_max ==  '500000') echo "selected='selected'";?> >500000</option>
    <option value="600000"  <?PHP if ( $prix_max ==  '600000') echo "selected='selected'";?> >600000</option>
    <option value="700000"  <?PHP if ( $prix_max ==  '700000') echo "selected='selected'";?> >700000</option>
    <option value="800000"  <?PHP if ( $prix_max ==  '800000') echo "selected='selected'";?> >800000</option>
    <option value="900000"  <?PHP if ( $prix_max ==  '900000') echo "selected='selected'";?> >900000</option>
    <option value="1000000" <?PHP if ( $prix_max == '1000000') echo "selected='selected'";?> >1000000</option>
    </select>
    <input type='hidden' id='zone'        name='zone'        value="<?PHP echo "$zone"; ?>" />
    <input type='hidden' id='zone_pays'   name='zone_pays'   value="<?PHP echo "$zone_pays"; ?>" />
    <input type='hidden' id='zone_dom'    name='zone_dom'    value="<?PHP echo "$zone_dom"; ?>" />
    <input type='hidden' id='zone_region' name='zone_region' value="<?PHP echo "$zone_region"; ?>" />
    <input type='hidden' id='zone_dept'   name='zone_dept'   value="<?PHP echo "$zone_dept"; ?>" />
    <input type='hidden' id='zone_ville'  name='zone_ville'  value="<?PHP echo "$zone_ville"; ?>" />
    <input type='hidden' id='zone_ard'    name='zone_ard'    value="<?PHP echo "$zone_ard"; ?>" />
    <input type='hidden' id='dept_voisin' name='dept_voisin' value="<?PHP echo "$dept_voisin"; ?>" />
  </div>
</form> 
</div>
<?PHP
}
//--------------------------------------------------------------------------------
function print_selection_zone() {
?>
<div class="arrow3"></div>
<div class='filter_box'>
  <h2>Votre s�lection</h2>
  <div class="box">        
    <div id="nbr_ano_select"></div>
  </div>
  <div class="box_last">        
    <div id="stat_filtrage"></div>
  </div>
</div>
<?PHP
}
//--------------------------------------------------------------------------------
function check_nbpi(&$P1,&$P2,&$P3,&$P4,&$P5) {

  if ( $P1 == '0' && $P2 == '0' && $P3 == '0' && $P4 == '0' && $P5 == '0' ) { 
    $P1 = '1'; $P2 = '2'; $P3 = '3'; $P4 = '4'; $P5 = '5';
  }

}
?>

