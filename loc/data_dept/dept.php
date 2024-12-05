<?PHP
include("../../data/data.php");
include(".../../include/inc_base.php");
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

	$fp = fopen('departement.txt', 'r');

	if ($fp != '') {

		while (1) {

			// Lire une ligne
			$buffer = fgets($fp, 4096);

			// Si il y a des donn�es
			if (!feof($fp)) {

				echo "--------------------<br>";
				echo "$buffer<br>";

				// On �clate par le s�parateur TAB
				$tab = explode("|", $buffer);

				$idr       = trim($tab[0]);
				$dept      = mysqli_real_escape_string(trim($tab[1]));
				$dept_url  = mysqli_real_escape_string(trim($tab[2]));
				$dept_num  = trim($tab[3]);


				$query = "INSERT INTO loc_departement (idr,dept,dept_url,dept_num) VALUES ('$idr','$dept','$dept_url','$dept_num')";
				dtb_query($query, __FILE__, __LINE__, 1);
			} else break;
		}
	}
	?>
</body>

</html>