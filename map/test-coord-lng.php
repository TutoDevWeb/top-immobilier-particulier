<?PHP
include("../data/data.php");
include("../include/inc_base.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Document sans titre</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP
	dtb_connection();

	$query = "SELECT ville FROM loc_test ORDER BY maps_lng ASC";
	$result = dtb_query($query, __FILE__, __LINE__, 1);

	while (list($ville) = mysqli_fetch_row($result)) {
		echo "$ville<br>\n";
	}

	?>
</body>

</html>