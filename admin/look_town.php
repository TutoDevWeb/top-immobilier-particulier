<?PHP
include("../data/data.php");
include("../include/inc_base.php");

dtb_connection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Look Town</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP

	//---------------------------------------------------------------------------------------------------
	$query = "SELECT ville FROM ref_ville";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	while (list($ville) = mysqli_fetch_row($result)) {

		echo "$ville<br/>\n";

		$ville = addslashes($ville);

		$query = "SELECT * FROM loc_ville WHERE ville='$ville'";
		$result_loc = dtb_query($query, __FILE__, __LINE__, 0);

		if (mysqli_num_rows($result_loc) == 0)   echo "KO >>> ville :: $ville<br/>\n";
	}


	?>
</body>

</html>