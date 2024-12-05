<?PHP

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");

dtb_connection();

define('DEBUG_MAKE_THUMB', 1);

$select = "SELECT ida FROM ano WHERE etat='ligne' ORDER BY dat_ins DESC";
$result = dtb_query($select, __FILE__, __LINE__, 1);

while (list($ida) = mysqli_fetch_row($result)) {

	$src_photo = $_SERVER['DOCUMENT_ROOT'] . "/images_fiches/a" . $ida . "_1_photo.jpg";
	$src_thumb = $_SERVER['DOCUMENT_ROOT'] . "/images_fiches/a" . $ida . "_1_thumb.jpg";

	if (file_exists($src_thumb)) unlink($src_thumb);
	if (file_exists($src_photo)) make_thumb($src_photo, $ida, THUMB_X);
}

//--------------------------------------------------------------------------------------------
// Fabrique les images
// $src  : fichier source
// $ida  : le num�ro de l'annonce
// $xmax : Taille maxi en X
//--------------------------------------------------------------------------------------------
function make_thumb($src, $ida, $xmax) {

	$size = getimagesize($src);

	if (DEBUG_MAKE_THUMB) {
		echo "-------------------------------------<br/>\n";
		echo "Make_frame ida => $ida<br/>\n";
		echo "src=$src<br/>\n";
		echo "Largeur -> $size[0]<br/>\n";
		echo "Longeur -> $size[1]<br/>\n";
		echo "Type    -> $size[2]<br/>\n";
	}

	$X_src = $size[0];
	$Y_src = $size[1];

	// On ne r�duit que si n�cessaire
	if ($X_src > $xmax) {

		// Nom de l'image � fabriquer
		$dst = $_SERVER['DOCUMENT_ROOT'] . "/images_fiches/a" . $ida . "_1_thumb.jpg";
		if (DEBUG_MAKE_THUMB) echo "R�duction d'image  : $dst<br/>\n";

		// Rapport L / H
		$r = $X_src / $Y_src;
		$X_dst = $xmax;
		$Y_dst = $xmax / $r;

		if (DEBUG_MAKE_THUMB) echo "GD 2.0<br/>\n";
		$fp_src = imagecreatefromjpeg($src);  // creation de l'image
		$fp_dst = imagecreatetruecolor($X_dst, $Y_dst);
		imagecopyresized($fp_dst, $fp_src, 0, 0, 0, 0, $X_dst, $Y_dst, $X_src, $Y_src);
		imagejpeg($fp_dst, $dst);
	} else {

		// Si il s'agit d'un thumb qui n'a pas besoin de r�duction il faut le cr�e par copie
		if (DEBUG_MAKE_THUMB) echo "Cr�ation du thumb par Copy<br/>\n";
		$src = $_SERVER['DOCUMENT_ROOT'] . "/images_fiches/a" . $ida . "_1_photo.jpg";
		$dst = $_SERVER['DOCUMENT_ROOT'] . "/images_fiches/a" . $ida . "_1_thumb.jpg";

		copy($src, $dst);
	}

	return $dst;
}
