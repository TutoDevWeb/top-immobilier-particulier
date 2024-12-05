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

	// Il y a un BUG ici car si il n'y a pas de fichier fopen ne retourne pas false. 
	$fp = fopen('prix.txt', 'r');

	if ($fp != '') {

		while (1) {

			// Lire une ligne
			$buffer = fgets($fp, 4096);

			// Si il y a des donn�es
			if (!feof($fp)) {

				echo "--------------------<br/>";
				echo "$buffer<br/>";

				// On �clate par le s�parateur TAB
				$tab = explode("\t", $buffer);

				$ville = mysqli_real_escape_string(trim($tab[0]));
				$ard   = mysqli_real_escape_string($tab[1]);
				$prix  = str_replace(' ', '', $tab[2]);

				$query = "INSERT INTO ref_prix (ville,ard,prix) VALUES ('$ville','$ard','$prix')";
				dtb_query($query, __FILE__, __LINE__, 0);
			} else break;
		}
	}
	?>
</body>

</html>