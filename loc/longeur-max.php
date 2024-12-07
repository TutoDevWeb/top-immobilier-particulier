<?PHP
include("data.php");
include("../include/inc_base.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>R�cup�rer la longueur max des champs r�gion / d�partement / ville</title>
	<meta charset="UTF-8">
</head>

<body>
	<?PHP

	set_time_limit(0);

	dtb_connection();

	// Dans cahque table le but est de r�cup�rer la longeur maw pour cahque champ.

	//--------------------------------------------------------------*/
	$query = "SELECT ville FROM loc_ville WHERE maps_code=1";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$longeur_ville_max  = 0;
	while (list($ville) = mysqli_fetch_row($result)) {
		if (strlen($ville) > $longeur_ville_max) {
			$longeur_ville_max = strlen($ville);
			$ville_max = $ville;
		}
	}

	//--------------------------------------------------------------*/
	$query = "SELECT dept FROM loc_departement";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$longeur_dept_max  = 0;
	while (list($dept) = mysqli_fetch_row($result)) {
		if (strlen($dept) > $longeur_dept_max) {
			$longeur_dept_max = strlen($dept);
			$dept_max = $dept;
		}
	}

	//--------------------------------------------------------------*/
	$query = "SELECT region FROM loc_region";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$longeur_region_max  = 0;
	while (list($region) = mysqli_fetch_row($result)) {
		if (strlen($region) > $longeur_region_max) {
			$longeur_region_max = strlen($region);
			$region_max = $region;
		}
	}

	echo "-------------------------------------------------------<br>\n";
	echo "R�sultats :<br>\n";
	echo "ville_max  :$ville_max  => $longeur_ville_max  caract�res<br>\n";
	echo "dept_max   :$dept_max   => $longeur_dept_max   caract�res<br>\n";
	echo "region_max :$region_max => $longeur_region_max caract�res<br>\n";
	echo "-------------------------------------------------------<br>\n";

	?>
</body>

</html>