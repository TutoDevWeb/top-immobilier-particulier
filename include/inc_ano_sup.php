<?PHP
//--------------------------------------------------------------------------------------
function ano_sup($tel_ins, $file, $line, $trace) {

	// Tester si l'annonce existe
	$query = "SELECT ida FROM ano WHERE tel_ins = '$tel_ins'";
	$result = dtb_query($query, $file, $line, $trace);

	if (mysqli_num_rows($result)) {

		list($ida) = mysqli_fetch_row($result);

		if ($trace) echo "<p class=text12cg>Annonce existe : Supprimer l'annonce $tel_ins</p>";

		// supprimer l'annonce
		$query = "DELETE FROM ano WHERE tel_ins = '$tel_ins' LIMIT 1";
		$result = dtb_query($query, $file, $line, $trace);

		// Effacer les photos
		supprimer_photos($ida, $file, $line, $trace);

		return true;
	} else {

		if ($trace) echo "<p class=text12cg>Annonce n'existe pas $tel_ins</p>";
		return false;
	}
}
