<?PHP
//------------------------------------------------------------------------
function goto($page) {

    // Rediriger vers le tableau de bord
    echo "<script language=\"JavaScript\">\n";
    echo "window.location.href = '$page';";
    echo  "</script>\n";

}
//------------------------------------------------------------------------
function history_back() {

    // Rediriger vers le tableau de bord
    echo "<script language=\"JavaScript\">\n";
    echo "history.back();";
    echo  "</script>\n";

}
//------------------------------------------------------------------------
function is_modif() {

  if ( isset($_SESSION['modifier']) && $_SESSION['modifier'] == 1 ) return true;
  else return false;

}
//------------------------------------------------------------------------
// On revient sur le formulaire d'édition d'une annonce.
// On peut être dans le cas d'une modif ou dans le cas d'une simple reprise.
function is_reprise() {

  if ( isset($_SESSION['zone']) ) return true;
  else return false;
  
}
//------------------------------------------------------------------------
function is_connexion_admin() {

  if ( isset($_SESSION['user']) && ($_SESSION['user'] == 'adminsag') ) return true;
  else return false;

}
//------------------------------------------------------------------------
function print_deconnexion() {

  echo "<p><a href='/compte-annonce/deconex.php' class='home' title='Retour Accueil'>Retour Accueil</a></p>\n";

}
//------------------------------------------------------------------------
function print_modifier() {
  echo "<p><a href='modifier.php' title='Modifier votre Annonce'><img src='/images/btn_modifier.gif' alt='Modifier votre Annonce' /></a></p>\n";
}
//------------------------------------------------------------------------
function print_voir_modifier_supprimer($tel_ins) {
  echo "<p><a href='/annonce-${tel_ins}.htm' target='_blank' title='Voir votre Annonce'><img src='/images/btn_voir.gif' alt='Voir votre Annonce' /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='modifier.php' title='Modifier votre Annonce'><img src='/images/btn_modifier.gif' alt='Modifier votre Annonce' /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:confirm_delete('supprimer.php','votre annonce');\" title='Supprimer votre Annonce'><img src='/images/btn_supprimer.gif' alt='Supprimer votre Annonce' /></a></p>\n";
}
//------------------------------------------------------------------------
function data_en_session_ok() {

  // Si il y a celle là il y aura les autres
  if ( isset($_SESSION['zone']) && trim($_SESSION['zone']) != '' && isset($_SESSION['typp']) ) return true;
  else return false;

}
//------------------------------------------------------------------------
function print_if_no_data() {
?>
  <table id='annonce'>
    <tr>
      <td class='cell_b'> <?PHP  print_cibleclick_120_600();  ?> </td>
      <td class='cell_c'>
        <?PHP
        print_deconnexion();
        echo "<p>&nbsp;</p>"; 
        echo "<p>&nbsp;</p>"; 
        echo "<p>&nbsp;</p>"; 
        print_cible_unifinance_300_250();
	      tracking_session_annonce(CODE_CTA,'OK',"Pas de données en Session",__FILE__,__LINE__);
	      echo "<p>&nbsp;</p>";
        ?>
      </td>
      <td class='cell_b'><?PHP  print_cibleclick_120_600();  ?></td>
    </tr>
  </table>
<?PHP
}
//------------------------------------------------------------------------
function purger_session() {

  $tmp_tel_ins = $_SESSION['tel_ins'];
  $tmp_ida     = $_SESSION['ida'];
  $tmp_email   = $_SESSION['email'];
	$tmp_user    = $_SESSION['user'];  // Pour le tracking des connexion ADMIN

  // Clear de la session
  unset($_SESSION);
  $_SESSION = array();
  
  $_SESSION['tel_ins'] = $tmp_tel_ins;
  $_SESSION['ida']     = $tmp_ida;
  $_SESSION['email']   = $tmp_email;
  $_SESSION['user']    = $tmp_user;

}
//------------------------------------------------------------------------
function print_info_attente_paiement($tel_ins) {

  $duree_annonce  = DUREE_ANNONCE;
  $prix_annonce   = PRIX_ANNONCE;

  $cheque_ordre   = CHEQUE_ORDRE;
  $cheque_adresse = CHEQUE_ADRESSE;
  $cheque_legal   = CHEQUE_LEGAL;
	$duree_attente  = DUREE_RELANCER_ATTENTE_PAIEMENT;

  echo "<div class='make'>\n";
  echo "<p><img src='/images/hp3.gif' align='absmiddle' alt='' />&nbsp;&nbsp;&nbsp;Nous sommes en attente de votre chèque de paiement</p>";
  echo "</div>\n";
  echo "<div id='zone_paiement'>\n";
	echo "<table id='cheque'>";
  echo "<tr><td>Montant du chèque</td><td>$prix_annonce Euros</td></tr>";
  echo "<tr><td>Durée de parution</td><td>$duree_annonce mois à compter de la réception du chèque</td></tr>";
  echo "<tr><td>Chèque à l'ordre de</td><td>$cheque_ordre</td></tr>";
  echo "<tr><td>Expédier à l'adresse</td><td>$cheque_adresse</td></tr>";
  echo "<tr><td colspan='2'><em>(* $cheque_legal)</em></td></tr>";
	echo "</table>";
  echo "<p>&nbsp;</p>\n";
  echo "<p class='text12cgr'>Mettre le numéro de téléphone de l'inscription au dos du chèque : $tel_ins</p>\n";
  echo "<p class='text12cgr'>Votre chèque doit nous parvenir dans les $duree_attente jours</p>\n";
  echo "</div>\n";
  echo "<div class='make'>\n";
  echo "<p><img src='/images/hp3.gif' align='absmiddle' alt='' />&nbsp;&nbsp;&nbsp;Vous pouvez voir, modifier ou supprimer votre annonce</p>\n";
  print_voir_modifier_supprimer($tel_ins);
  echo "</div>\n";
  echo "<p><em>Pour toutes modifications de votre email ou de votre numéro de téléphone,<br />";
  echo "<a href='/noref/contact-equipe.php?action=print_form' title='Contacter Nous' rel='nofollow' class='navsearch11' target='_blank'>Contacter Nous</a>&nbsp;(*Service gratuit)</em></p>";
  print_cible_unifinance_300_250();

}
?>