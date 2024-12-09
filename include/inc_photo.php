<?PHP
//--------------------------------------------------------------------------------------------
function get_photo_from_dir($ida) {

	$photo_tmp = array();

	for ($ip = 1; $ip <= 5; $ip++) {
		$src = "../images_fiches/" . "a{$ida}_" . $ip . "_photo.jpg";
		if (file_exists($src)) array_push($photo_tmp, $src);
	}

	if (DEBUG_PHOTO) print_r($photo_tmp);

	return $photo_tmp;
}
//--------------------------------------------------------------------------------------------
function get_photo_from_session() {

	$photo_tmp = array();
	$root_image = "../images_fiches/";
	for ($ip = 1; $ip <= 5; $ip++) {
		$src = $root_image . $_SESSION['my_session'] . "_" . $ip . "_photo.jpg";
		//echo "<img src=$src><br/>\n";
		//echo "Mise en session de la photo src = $src<br/>\n";
		if (file_exists($src)) array_push($photo_tmp, $src);
	}

	return $photo_tmp;
}
//--------------------------------------------------------------------------------------------
// Appel dans le cas d'une modification d'annonce
// 1. On crée un identificateur de session
// 2. On copie les photos fiches pour en faire des photos session.
// ( On ne traite que les photos la procedure d'upload créera les thumbs )
//--------------------------------------------------------------------------------------------
function restore_photo_session($ida) {

	// Si il n'y a pas d'identificateur photos
	if (!isset($_SESSION['my_session'])) {

		$_SESSION['my_session'] = "tmp_" . key_generator(10);
		if (DEBUG_PHOTO) echo "<p>Création de my_session : ", $_SESSION['my_session'], "</p>\n";
	}

	// Dans tout les cas on restaure par copie des photos de session
	for ($ip = 1; $ip <= 5; $ip++) {
		// Restaurer les photos par copie
		$src_ph = '../images_fiches/' . "a{$ida}_" . $ip . "_photo.jpg";
		if (DEBUG_PHOTO) echo "<p>Test si $src_ph existe ?</p>\n";
		if (file_exists($src_ph)) {
			$dst_ph = '../images_fiches/' . $_SESSION['my_session'] . "_" . $ip . "_photo.jpg";
			copy($src_ph, $dst_ph);
			if (DEBUG_PHOTO) echo "<p>Restaure : $dst_ph</p>\n";
		}
	}

	// Si le thumb_1 fiche existe il faut également le restaurer
	if (DEBUG_PHOTO) echo "<p>On teste si le thumb_1 fiche existe</p>\n";

	$src_th = '../images_fiches/a' . $ida . '_1_thumb.jpg';
	if (DEBUG_PHOTO) echo "<p>Test file_exists : $src_th</p>\n";

	if (file_exists($src_th)) {

		if (DEBUG_PHOTO) echo "<p>Le thumb_1 fiche existe</p>\n";
		$dst_th = '../images_fiches/' . $_SESSION['my_session'] . '_1_thumb.jpg';
		copy($src_th, $dst_th);
		if (DEBUG_PHOTO) echo "<p>Restaure $src_th en $dst_th</p>\n";
	}
}
//----------------------------------------------------------------------------------------
// Appelle de cette fonction pour passer des photos session aux photos fiches
// 1. On efface tout l'existant
// 2. On renome les photos session en photos fiches.
// 3. On efface tous les thumbs.
//----------------------------------------------------------------------------------------
function renomage_photo($ida, $file, $line) {

	// --------------------------------------------------------
	// On efface tout

	if (DEBUG_PHOTO) echo "<p>Renomage des photos de session en photos fiches</p>\n";

	if (DEBUG_PHOTO) echo "<p>On efface les photos fiches actuelles</p>\n";
	for ($ip = 1; $ip <= 5; $ip++) {

		// Photo
		$src_ph = '../images_fiches/' . 'a' . $ida . "_" . $ip . "_photo.jpg";

		if (DEBUG_PHOTO) echo "<p>Test file_exists : $src_ph</p>\n";
		if (file_exists($src_ph)) {
			if (DEBUG_PHOTO) echo "<p>Suppression de $src_ph</p>\n";
			unlink($src_ph);
		}
	}

	// On efface le thumb fiche actuel si il existe
	$src_th = '../images_fiches/' . 'a' . $ida . "_1_thumb.jpg";
	if (DEBUG_PHOTO) echo "<p> On teste si le thumb_1 fiche existe: $src_th</p>\n";

	if (file_exists($src_th)) {
		unlink($src_th);
		if (DEBUG_PHOTO) echo "<p>Suppression de $src_th</p>\n";
	}

	if (DEBUG_PHOTO) echo "<p>On efface les thumbs de session sauf le premier</p>\n";
	for ($ip = 2; $ip <= 5; $ip++) {

		$src_th = '../images_fiches/' . $_SESSION['my_session'] . "_" . $ip . "_thumb.jpg";
		if (DEBUG_PHOTO) echo "<p>Test file_exists : $src_th</p>\n";
		if (file_exists($src_th)) {
			if (DEBUG_PHOTO) echo "<p>Suppression de $src_th</p>\n";
			unlink($src_th);
		}
	}

	if (DEBUG_PHOTO) echo "<p>Renomage des photos de session en photo fiche</p>\n";
	for ($ip = 1; $ip <= 5; $ip++) {

		// Si les photos sont transmisses par courrier il n'y a rien a transférer
		$src = '../images_fiches/' . $_SESSION['my_session'] . "_" . $ip . "_photo.jpg";
		$dst = '../images_fiches/' . 'a' . $ida . '_' . $ip . '_photo.jpg';

		if (file_exists($src)) {
			rename($src, $dst);
			if (DEBUG_PHOTO) echo "<p>Rename $src en $dst</p>\n";
		}
	}

	// Renommage du thumb 1 de session. 
	if (DEBUG_PHOTO) echo "<p>On teste si le thumb_1 de session existe</p>\n";

	$src_th = '../images_fiches/' . $_SESSION['my_session'] . "_1_thumb.jpg";
	if (DEBUG_PHOTO) echo "<p>Test file_exists : $src_th</p>\n";

	if (file_exists($src_th)) {
		if (DEBUG_PHOTO) echo "<p>Le thumb_1 de session existe</p>\n";
		$dst_th = '../images_fiches/' . 'a' . $ida . "_1_thumb.jpg";
		rename($src_th, $dst_th);
		if (DEBUG_PHOTO) echo "<p>Rename $src_th en $dst_th</p>\n";
	}
}
//----------------------------------------------------------------------------------------
// Appel de cette fonction pour effacer les photos fiches.
// L'emplacement des photos est ici donné en absolu ce qui permet d'appeler cette fonction dans des taches cron.
//----------------------------------------------------------------------------------------
function supprimer_photos($ida, $file, $line, $trace) {

	// --------------------------------------------------------
	// On efface tout

	if ($trace) echo "<p>Efface les photos fiches</p>\n";

	for ($ip = 1; $ip <= 5; $ip++) {

		// Photo
		$src_ph = ABS_ROOT_PHOTO . 'a' . $ida . "_" . $ip . "_photo.jpg";

		if ($trace) echo "<p>Test file_exists : $src_ph</p>\n";
		if (file_exists($src_ph)) {
			if ($trace) echo "<p><strong>Suppression de $src_ph</strong></p>\n";
			unlink($src_ph);
		}

		// Thumb
		$src_th = ABS_ROOT_PHOTO . 'a' . $ida . "_" . $ip . "_thumb.jpg";

		if ($trace) echo "<p>Test file_exists : $src_th</p>\n";
		if (file_exists($src_th)) {
			if ($trace) echo "<p><strong>Suppression de $src_th</strong></p>\n";
			unlink($src_th);
		}
	}
}
// -------------------------------------------------------------------------------------------     
function print_galerie_photo($photo) {

	// Il faut compter les photos
	$nb_ph = count($photo);

	// Il en faut au moins une pour faire la galerie
	if ($nb_ph >= 1) echo "<div id='galerie'>\n";

	// Il en faut au moins deux pour un menu
	if ($nb_ph >= 2) {

		echo "<ul id='galerie_mini'>\n";
		foreach ($photo as $ip => $src_ph) {
			$ip = $ip + 1;
			echo "<li><a href='$src_ph' title='Photo num�ro $ip'>$ip</a></li>\n";
		}
		echo "</ul>\n";
	}

	// Si il y en a au moins une on initialise avec celle là
	if ($nb_ph >= 1) {
		$src_ph = $photo[0];
		echo "<div id='photo'>\n";
		echo "<img id='big_pict' src='$src_ph' alt='Photo en cours' />\n";
		echo "</div>\n";
	}


	// On ferme le conteneur de la galerie
	if ($nb_ph >= 1) echo "</div>\n";
}
