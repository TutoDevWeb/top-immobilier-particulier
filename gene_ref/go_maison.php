<?PHP
include("../data/data.php");
include("../include/inc_base.php");
dtb_connection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Document sans titre</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP

	$query = "SELECT tel_ins FROM ano WHERE typp='villa' OR typp='pavillon' OR typp='maison_de_village'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$i = 0;
	while (list($tel_ins) = mysqli_fetch_row($result)) {

		$query = "UPDATE ano SET typp='maison' WHERE tel_ins='$tel_ins' LIMIT 1";
		dtb_query($query, __FILE__, __LINE__, 1);
		$i++;
	}
	echo "$i correction<br/>\n";

	?>
</body>

</html>