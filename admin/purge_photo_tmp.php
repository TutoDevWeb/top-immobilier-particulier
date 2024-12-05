<title>purge_photo_tmp.php</title>
<?PHP
include("/home/web/tip/tip-fr/data/data.php");
include("/home/web/tip/tip-fr/include/inc_base.php");
include("/home/web/tip/tip-fr/include/inc_conf.php");
include("/home/web/tip/tip-fr/include/inc_tracking.php");
include("/home/web/tip/tip-fr/include/inc_photo.php");

$fp_dir = opendir(ABS_ROOT_PHOTO);

echo "<p>Début du traitement</p>";

while ( $file = readdir($fp_dir) ) {
    
  
  if ( ereg("^tmp_([a-zA-Z0-9]*)_[1-5]_(photo|thumb).jpg",$file,$regs) ) {

    echo "<p>file : $file</p>";
      
    $fic_tmp = $regs[0];
    echo "---------------------------------------<br>";
    echo "$fic_tmp<br>";

    $file_abs_path = ABS_ROOT_PHOTO.$file;
    $time_fic = filemtime($file_abs_path);

    echo "time_fic:$time_fic<br>";

    $time_act = mktime();

    echo "time_act:$time_act<br>";
    
    $age       = $time_act - $time_fic;
    $age_heure = $age/3600;
    
    echo "age en secondes :$age<br>";
    echo "age en heures   :$age_heure<br>";

    if ( $age > 3600 * 12 ) {
      echo "Attention encore en TEST => Effacer $file_abs_path<br>";
      //if ( !unlink($file_abs_path) ) echo "<p>Echec suppression $file_abs_path</p>\n";

    }
    echo "---------------------------------------<br>";

  }

}
closedir($fp_dir);
?>