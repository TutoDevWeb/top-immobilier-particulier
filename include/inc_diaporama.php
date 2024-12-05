<?PHP

//-----------------------------------------------------------------------------------------
// Sélection d'une tranche d'annonce parmi les dernières mise en ligne.
// Les annonces doivent être dotées de photos.
// $first l'index de la première annonce ( 0 pour la toute première )
function select_annnonce($connexion, $first, $last) {

	$debug = 0;

	$select = "SELECT ida,tel_ins,zone_ville,zone_region,typp,prix,dat_ins FROM ano WHERE etat='ligne' ORDER BY dat_ins DESC";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DIAPORAMA);

	$i = 0;
	$ida_array = array();
	while (list($ida, $tel_ins, $zone_ville, $zone_region, $typp, $prix, $dat_ins) = mysqli_fetch_row($result)) {

		if (DEBUG_DIAPORAMA) echo "Traitement de :: ida => $ida :: tel_ins => $tel_ins :: $dat_ins<br/>\n";

		if (thumb_exists($ida)) {

			if (DEBUG_DIAPORAMA) echo "ida => $ida :: tel_ins : Le thumb est OK<br/>";

			if ($i >= $first && $i <= $last) {
				$ida_item = array('ida' => $ida, 'tel_ins' => $tel_ins, 'zone_ville' => $zone_ville, 'zone_region' => $zone_region, 'typp' => $typp, 'prix' => $prix, 'dat_ins' => $dat_ins);
				array_push($ida_array, $ida_item);
				if (DEBUG_DIAPORAMA) echo "Selection de :: ida => $ida :: tel_ins<br/>";
			}

			if ($i == $last) break;
			else $i++;
		} else if (DEBUG_DIAPORAMA) echo "ida => $ida :: tel_ins : Le thumb n'existe pas<br/>";
	}

	return $ida_array;
}
//-----------------------------------------------------------------------------------------
// Teste si un thumb existe pour une annonce de référence $refa
// Teste également si ce thumb à un format standard THUMB_X et THUMB_Y
// Ne retourne vrai que si ces deux conditions sont remplies.
function thumb_exists($ida) {

	// Tester si le thumb existe
	$src = $_SERVER['DOCUMENT_ROOT'] . "/images_fiches/{$ida}_1_thumb.jpg";

	if (file_exists($src)) {

		if (DEBUG_DIAPORAMA) echo "src OK => $src<br/>";

		$size = getimagesize($src);

		if (DEBUG_DIAPORAMA) {
			echo "-------------------------------------<br/>\n";
			echo "src=$src<br/>\n";
			echo "Largeur -> $size[0]<br/>\n";
			echo "Longeur -> $size[1]<br/>\n";
			echo "Type    -> $size[2]<br/>\n";
		}

		// Il a fallu prendre une petite marge sur THUMB_Y car la valeur n'est pas toujours bonne pile poil. 
		if ($size[0] == THUMB_X && ($size[1] >= (THUMB_Y - 20) && $size[1] <= (THUMB_Y + 20))) {
			if (DEBUG_DIAPORAMA) echo "Le thumb a la bonne taille<br/>";
			return true;
		} else {
			if (DEBUG_DIAPORAMA) echo "Le thumb n'a pas la bonne taille<br/>";
			return false;
		}
	} else {
		if (DEBUG_DIAPORAMA) echo "src KO => $src<br/>";
		return false;
	}
}
//-----------------------------------------------------------------------------------------
function print_selection_annonce($ida_array) {

	$nb_ano = count($ida_array);

	if (DEBUG_DIAPORAMA) echo "$nb_ano<br/>\n";

	echo "<table id='diaporama'><tr>\n";
	foreach ($ida_array as $ida_item) {

		// Préparer les données
		$ida         = $ida_item['ida'];
		$tel_ins     = $ida_item['tel_ins'];
		$dat_ins     = to_datm($ida_item['dat_ins']);
		$zone_region = $ida_item['zone_region'];
		$zone_ville  = $ida_item['zone_ville'];
		$prix  = format_prix($ida_item['prix']);
		$typp  = ucfirst($ida_item['typp']);
		$site  = $_SERVER['HTTP_HOST'];
		$src = "https://{$site}/images_fiches/a{$ida}_1_thumb.jpg";
		$hrf = "https://{$site}/annonce-{$tel_ins}.htm";

		if ($zone_ville != $zone_region) {
			$alt   = "$typp $zone_region $zone_ville";
			$title = "$typp $zone_region $zone_ville";
		} else {
			$alt   = "$typp $zone_ville";
			$title = "$typp $zone_ville";
		}

		// Ecriture du thumb
		echo "<td>\n";
		echo "$dat_ins<br />\n";
		echo "<a href='$hrf' rel='nofollow' title=\"$title\"><img src='$src' alt=\"$alt\" /></a><br />\n";
		echo "$zone_ville $prix €";
		echo "</td>\n";
	}
	echo "</tr></table>\n";
}
