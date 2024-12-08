<title>PURGE PHOTOS ORPHELINES</title>
<?PHP
include("/home/web/tip/tip-fr/data/data.php");
include("/home/web/tip/tip-fr/include/inc_base.php");
include("/home/web/tip/tip-fr/include/inc_conf.php");
include("/home/web/tip/tip-fr/include/inc_tracking.php");
include("/home/web/tip/tip-fr/include/inc_photo.php");

define('DEBUG_PHOTO_ORPHELINE', 0);

$connexion = dtb_connection(__FILE__, __LINE__);

$fp_dir = opendir(ABS_ROOT_PHOTO);
$i_supp = 0;
$i_ok = 0;
while ($file = readdir($fp_dir)) {

	//echo "<p>file : $file</p>";

	// On teste sur la photo numéro 1  
	if (ereg("^a([0-9]*)_1_photo.jpg", $file, $regs)) {

		$fic_tmp = $regs[0];
		$ida_tmp = $regs[1];
		echo "---------------------------------------<br>";
		echo "Photo $fic_tmp<br>";
		echo "Annonce numéro $ida_tmp<br>";

		if (test_annonce_existe($connexion, $ida_tmp)) {
			echo "L'annonce $ida existe il n'y a rien a faire<br/>";
			$i_ok++;
		} else {
			echo "L'annonce $ida n'existe pas il faut supprimer les photos<br/>";
			supprimer_photos($ida_tmp, __FILE__, __LINE__, 1);
			$i_supp++;
		}
	}
}
closedir($fp_dir);

echo "Il y a $i_ok annonce avec photos<br/>";
echo "Il y a $i_supp photo à supprimer<br/>";

//-------------------------------------------------------------------------------------
// On teste si il y a une annonce pour cette photo
function test_annonce_existe($connexion, $ida) {

	$query = "SELECT * FROM ano WHERE ida='$ida'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_PHOTO_ORPHELINE);

	if (mysqli_num_rows($result)) return true;
	else return false;
}

?>