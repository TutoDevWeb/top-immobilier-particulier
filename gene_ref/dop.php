<?PHP
include("../data/data.php");
include("../include/inc_base.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Document sans titre</title>
	<meta charset="UTF-8">
</head>

<body>
	<?PHP
	dtb_connection();

	$query = "SELECT ville FROM ref_ville";
	$result_list_ville = dtb_query($query, __FILE__, __LINE__, 0);

	while (list($ville) = mysqli_fetch_row($result_list_ville)) {

		$ville_url = strtolower($ville);
		$ville_url = str_replace(' ', '-', $ville_url);

		$ville_lieu = "� " . $ville;

		$query = "UPDATE ref_ville SET ville_url='$ville_url',ville_lieu='$ville_lieu' WHERE ville='$ville' LIMIT 1";
		dtb_query($query, __FILE__, __LINE__, 0);
		//echo "$query<br/>\n";

	}

	?>
</body>

</html>