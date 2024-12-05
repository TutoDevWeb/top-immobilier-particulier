<?PHP

define('ROOT_PHOTO',"../images_fiches/");

// Cette routine peut faire la première photo d'une taille et les autres d'une autre
define ('PHOTO_X1',400);      // Valeur X pour la première photo
define ('PHOTO_X',400);       // Valeur X d'une photo normale

define ('WEIGTH_MAX',4000000); // Poids maxi d'une photo
define ('DEBUG_UPLOAD',0);

//--------------------------------------------------------------------------------------------
function upload_photo() {

  $err = false;

  if (DEBUG_UPLOAD) echo "Upload<br/>\n";

  // Compter le nombre de photo dans le but de savoir quel est le rang de la photo en cours
  $ip = nbp($_SESSION['my_session']);
  if ( $ip >= 5 ) {
    $err = true;
    $message = "<p class=text12cgr>Echec : Le nombre maximal de photo est de 5</p>";

    tracking_session_annonce(CODE_CTA,'OK',"Upload:max photo atteint",__FILE__,__LINE__);

  } else {

	  // Si il y a ip photo le rang de la photo en cours sera de ip+1
		$ip++;
    while (list($k, $v) = each($_FILES)) {
      while (list($kk, $vv) = each ($v)) {
        if (DEBUG_UPLOAD) echo "$kk => $vv<br/>";
        if ( $kk == 'name') {
          $file_src = $vv;
          if (DEBUG_UPLOAD) echo "file_src = $file_src<br/>";
        }
        if ( $kk == 'tmp_name') {
          $file_tmp = $vv;
          if (DEBUG_UPLOAD) echo "file_tmp = $file_tmp<br/>";
        }
        if ( $kk == 'size') {
          $file_size = $vv;
          if (DEBUG_UPLOAD) echo "file_size = $file_size<br/>";
        }
        if ( $kk == 'error') {
          $file_error = $vv;
          if (DEBUG_UPLOAD) echo "file_error = $file_error<br/>";
        }
      } // Fin while sur $v

      if ( $file_size > WEIGTH_MAX ) {

        $err = true;
        $message = "<p class=text12>Echec : La photo dépasse les ".WEIGTH_MAX." octets</p>";
        tracking_session_annonce(CODE_CTA,'OK',"La photo dépasse les".WEIGTH_MAX." octets",__FILE__,__LINE__);

      }

      // Si il n'y a pas de flag d'erreur et que la taille max n'est pas dépassée
      if ( !$file_error && $file_size < WEIGTH_MAX ) {

        $dst = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_photo.jpg";

        if (move_uploaded_file($file_tmp,$dst)) {
          if (DEBUG_UPLOAD) { echo "Transfert de $file_tmp vers $dst<br/>\n"; } else {;}

          // Si téléchergement réussi
          tracking_session_annonce(CODE_CTA,'OK',"Téléchargement réussi de $dst",__FILE__,__LINE__);

          // Si c'est la première il faut prendre la taille PHOTO_X1
				  if ( $ip == 1 ) make_frame($dst,$ip,PHOTO_X1,'photo');
          else make_frame($dst,$ip,PHOTO_X,'photo');
          make_frame($dst,$ip,THUMB_X,'thumb');

        } else {
          $err = true ;
          $message = "<p class=text12>Echec : Impossible de déplacer le fichier: $file_tmp vers $dst</p>";
          tracking_session_annonce(CODE_CTA,'OK',"Echec du move_upload",__FILE__,__LINE__);
        }
      }
    } // Fin while sur $FILES    
  } // Fin Else

  if ( $err == true ) {
    echo "<table width=550 border=1 align=center cellpadding=10 cellspacing=0 bordercolor=#336699>\n";
    echo "  <tr>\n";
    echo "    <td>$message</td>";
    echo "  </tr>\n";
    echo "</table>\n";
  }
}
//--------------------------------------------------------------------------------------------
// On compte les photos pour pouvoir ajouter la nouvelle en dernier
function nbp($my_session) {
  $nb = 0;
  for (  $ip = 1 ; $ip <= 5 ; $ip++ ) {
    $src = ROOT_PHOTO."${my_session}_".$ip."_photo.jpg";
    if (DEBUG_UPLOAD) echo "Test sur : $src<br/>";
    if ( file_exists($src)) $nb++;
  }
  if (DEBUG_UPLOAD) echo "Nombre de photo = $nb<br/>\n";
  return $nb;
}
//--------------------------------------------------------------------------------------------
// Fabrique les images
// $src  : fichier source
// $ip   : index de la photo
// $xmax : Taille maxi en X
// $type : 'photo' ou 'thumb'
// Retourne le nom du fichier fabriqué
//--------------------------------------------------------------------------------------------
function make_frame($src,$ip,$xmax,$type) {

  $size = getimagesize($src);

  if (DEBUG_UPLOAD) {
    echo "-------------------------------------<br/>\n";
    echo "Make_frame de type '$type' numéro $ip<br/>\n";
    echo "src=$src<br/>\n";
    echo "Largeur -> $size[0]<br/>\n";
    echo "Longeur -> $size[1]<br/>\n";
    echo "Type    -> $size[2]<br/>\n";
  }
    
  tracking_session_annonce(CODE_CTA,'OK',"make_frame type=$type ip=$ip<br/>src=$src<br/>Taille de l'image source => size_0=$size[0]:size_1=$size[1]",__FILE__,__LINE__);

  $X_src = $size[0];
  $Y_src = $size[1];

  // On ne réduit que si nécessaire
  if ( $X_src > $xmax ) { 

    // Nom de l'image à fabriquer
    $dst = ROOT_PHOTO.$_SESSION['my_session']."_${ip}_${type}.jpg";
    if (DEBUG_UPLOAD) echo "Réduction d'image  : $dst<br/>\n";
  
    // Rapport L / H
    $r = $X_src / $Y_src ;
    $X_dst = $xmax;
    $Y_dst = $xmax / $r;

    if ( DEBUG_UPLOAD ) echo "GD 2.0<br/>\n";
    $fp_src = imagecreatefromjpeg($src);  // creation de l'image
    $fp_dst = imagecreatetruecolor($X_dst,$Y_dst);
    imagecopyresized($fp_dst,$fp_src,0,0,0,0,$X_dst,$Y_dst,$X_src,$Y_src);
    imagejpeg($fp_dst,$dst);

  } else {

    // Si il s'agit d'un thumb qui n'a pas besoin de réduction il faut le crée par copie
    if ( $type == 'thumb' ) {
      if ( DEBUG_UPLOAD ) echo "Création du thumb par Copy<br/>\n";
      $src = ROOT_PHOTO.$_SESSION['my_session']."_${ip}_photo.jpg"; 
      $dst = ROOT_PHOTO.$_SESSION['my_session']."_${ip}_thumb.jpg"; 
      copy($src,$dst);
    }
  }

  return $dst;
}
//--------------------------------------------------------------------------------------------
function aff_thumb() {

  $photo_tmp = array();
  $thumb_tmp = array();

  // Rechercher les photos de session existantes
  for (  $ip = 1 ; $ip <= 5 ; $ip++ ) {
     
    // Si la photo de session existe
    $src_ph = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_photo.jpg";
    $src_th = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_thumb.jpg";
    if ( file_exists($src_ph)) {
    
      // tester si le thumb n'existe pas le faire
      if ( !file_exists($src_th) ) {
        // Faire le thumb de session
        $dst_th = make_frame($src_ph,$ip,THUMB_X,'thumb');
        if (DEBUG_UPLOAD) echo "Faire ce thumb qui n'existe pas : $src_th<br/>\n";
        array_push($thumb_tmp,$dst_th);
      } else array_push($thumb_tmp,$src_th);
      array_push($photo_tmp,$src_ph);
    }
  }
  

  // Si il y a des photos il y a les thumbs
  if ( count($thumb_tmp) > 0 ) {
    echo "                  <br/>\n";
    echo "                  <!-- Formulaire d'affichage des photos -->\n";
    echo "                  <form name='supp' action='".$_SERVER['PHP_SELF']."' method='get'>\n";
    echo "                    <table width=550 border=1 align=center cellpadding=10 cellspacing=0 bordercolor=#336699>\n";
    echo "                      <tr>\n";
    echo "                        <td colspan=2 class=text12>Les photos sont ici dans un format miniature.<br/>\n";
    echo "                        Vous les retrouverez au format normal sur vos fiches.</td>\n";
    echo "                      </tr>\n";

    for (  $it = 0 ; $it < count($thumb_tmp) ; $it++ ) {
      $ip = $it + 1;
      echo "                    <tr>\n"; 
      if ( $ip == 1 ) echo "      <td align=center><p>Photo numéro $ip<br/><img src='/images/photo-paysage.gif' alt='Photo au format paysage' />&nbsp;&nbsp;<img src='$thumb_tmp[$it]'><br/><em>(* Vérifier que cette photo est au format paysage.<br /> C'est la condition pour qu'elle apparaisse sur la page d'accueil)</em></td>\n";
      else echo "                 <td align=center><p>Photo numéro $ip<br/><img src='$thumb_tmp[$it]'></td>\n";
			echo "                      <td align=center><input name='ph${ip}' type='checkbox' value='$ip'></td>\n";
      echo "                    </tr>\n"; 
    }
    echo "                  </table>\n";
    echo "                  <br/>\n";
    echo "                  <!-- Formulaire de suppression des photos -->\n";
    echo "                  <table width=550 border=1 align=center cellpadding=10 cellspacing=0 bordercolor=#336699>\n";
    echo "                    <tr>\n";  
    echo "                      <td class=text12>\n";
    echo "                        Cochez les photos que vous voulez supprimer\n";
    echo "                        <img src='../images/spacer.gif' width='44' height='1' hspace='30'>\n";
    echo "                        <input class='but_input' name='Sub_Supp' type='submit' value='Supprimer'>\n";
    echo "                      </td>\n";
    echo "                    </tr>\n"; 
    echo "                  </table>\n";
    echo "                </form>\n";    
  }

  return count($thumb_tmp);
}
//--------------------------------------------------------------------------------------------
function supprimer() {

  // Supprimer les photos cochées
  if ( isset($_GET['ph1'])) sup_images($_GET['ph1']);
  if ( isset($_GET['ph2'])) sup_images($_GET['ph2']);
  if ( isset($_GET['ph3'])) sup_images($_GET['ph3']);
  if ( isset($_GET['ph4'])) sup_images($_GET['ph4']);
  if ( isset($_GET['ph5'])) sup_images($_GET['ph5']);

  // Faire le tableau des photos restantes après suppression
  $photo_tmp = array();
  for (  $ip = 1 ; $ip <= 5 ; $ip++ ) {
    $src = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_photo.jpg";
    if ( file_exists($src)) array_push($photo_tmp,$src);
  }


  if (DEBUG_UPLOAD) {
    echo "Liste des photos restantes après suppression<br/>\n";
	  foreach ( $photo_tmp as $src ) echo "$src<br/>\n";
    echo "--------------------------------------------<br/>\n";
  }

  // Faire le tableau des thumb restantes après suppression
  $thumb_tmp = array();
  for (  $ip = 1 ; $ip <= 5 ; $ip++ ) {
    $src = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_thumb.jpg";
    if ( file_exists($src)) array_push($thumb_tmp,$src);
  }

  if (DEBUG_UPLOAD) {
    echo "Liste des thumbs restants après suppression<br/>\n";
	  foreach ( $photo_tmp as $src ) echo "$src<br/>\n";
    echo "--------------------------------------------<br/>\n";
  }

	creation_prefixe();

  // Renomage des photos si nécessaires
  foreach ( $photo_tmp as $it => $photo ) {
    $ip = $it+1;
    $old_name = $photo;
    $new_name = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_photo.jpg";
    if ( $old_name != $new_name ) {
      if (DEBUG_UPLOAD) echo "Copy $old_name en $new_name<br/>\n";
      if (DEBUG_UPLOAD) echo "Unlink $old_name<br/>\n";
      if ( !copy($old_name,$new_name)) if (DEBUG_UPLOAD) echo "ECHEC:Copy $old_name en $new_name<br/>\n";
      if ( !unlink($old_name)) if (DEBUG_UPLOAD) echo "ECHEC:Unlink $old_name<br/>\n";
    }
  }

  // Renomage des thumbs si nécessaires
  foreach ( $thumb_tmp as $it => $thumb ) {
    $ip = $it+1;
    $old_name = $thumb;
    $new_name = ROOT_PHOTO.$_SESSION['my_session']."_".$ip."_thumb.jpg";
    if ( $old_name != $new_name ) {
      if (DEBUG_UPLOAD) echo "Copy $old_name en $new_name<br/>\n";
      if (DEBUG_UPLOAD) echo "Unlink $old_name<br/>\n";
      if ( !copy($old_name,$new_name)) if (DEBUG_UPLOAD) echo "ECHEC:Copy $old_name en $new_name<br/>\n";
      if ( !unlink($old_name)) if (DEBUG_UPLOAD) echo "ECHEC:Unlink $old_name<br/>\n";
    }
  }

}
//--------------------------------------------------------------------------------------------
// Suppression d'une image de session photo et thumb
// $ip   : indice des images
function sup_images($ip) {

  tracking_session_annonce(CODE_CTA,'OK',"Suppression Image:$ip",__FILE__,__LINE__);

  $src = ROOT_PHOTO.$_SESSION['my_session']."_${ip}_photo.jpg";
  if ( file_exists($src)) {
    if (DEBUG_UPLOAD) echo "Suppression de $src <br/>\n";
    if ( !unlink($src)) if (DEBUG_UPLOAD) echo "ECHEC:Suppression de $src <br/>\n";
  }
  $src = ROOT_PHOTO.$_SESSION['my_session']."_${ip}_thumb.jpg";
  if ( file_exists($src)) {
    if (DEBUG_UPLOAD) echo "Suppression de $src <br/>\n";
    if ( !unlink($src)) if (DEBUG_UPLOAD) echo "ECHEC:Suppression de $src <br/>\n";
  }
}
//--------------------------------------------------------------------------------------------
function creation_prefixe() {

  $_SESSION['my_session'] = "tmp_".key_generator(10);

  if ( DEBUG_UPLOAD ) echo "Création du préfixe : ",$_SESSION['my_session']," <br/>\n";    

  tracking_session_annonce(CODE_CTA,'OK',"Création prefixe:".$_SESSION['my_session'],__FILE__,__LINE__);


}
?>
