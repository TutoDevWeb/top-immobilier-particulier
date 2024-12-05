<?PHP
include("../../data/data.php");
include("../../include/inc_base.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Remplir table d�partement</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP

	dtb_connection();

	$query  = "SELECT dept_num FROM loc_departement ORDER BY dept_num ASC";
	$result = dtb_query($query, __FILE__, __LINE__, 1);

	while (list($dept_num) = mysqli_fetch_row($result)) {
		echo "$dept_num<br>\n";
	}

	?>
</body>

</html>