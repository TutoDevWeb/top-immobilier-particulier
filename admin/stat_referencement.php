<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Stat de r�f�rencement du site</title>
	<meta charset="UTF-8">
	<link href="/styles/styles.css" rel="stylesheet" type="text/css">
	<STYLE type="text/css">
		<!--
		body {
			background-color: #FFFFFF;
		}
		-->
	</STYLE>
</head>

<body>
	<?PHP
	include("../data/data.php");
	include("../include/inc_base.php");
	include("../include/inc_conf.php");
	include("../include/inc_dtb_compte_annonce.php");

	$connexion = dtb_connection(__FILE__, __LINE__);

	//---------------------------------------------------------------------------------------
	separate();

	print_ref_ville_a_faire($connexion, VAL_DTB_APPARTEMENT);

	separate();

	print_ref_ville_a_faire($connexion, VAL_DTB_MAISON);



	//-----------------------------------------------------------------------------
	function separate() {
		echo "<p>&nbsp;</p>";
		echo "<p>------------------------------------------------------------------</p>";
		echo "<p>&nbsp;</p>";
	}


	//--------------------------------------------------------------------------------------------------------
	// Chercher dans la liste des villes de ref_ville ou des produits doivent �tre plac�s 
	function print_ref_ville_a_faire($connexion, $typp_dtb) {

		$nb_to_add = 0;
		$query = "SELECT ville,dept FROM ref_ville";
		$result_ref_ville = dtb_query($connexion, $query, __FILE__, __LINE__, 1);

		echo "<p>\n";
		while (list($ref_ville, $ref_dept) = mysqli_fetch_row($result_ref_ville)) {

			// Dans chaque ville on va regarder si il y a un produit
			// Si il n'y a pas il faut le signaler
			$ref_ville_s = addslashes($ref_ville);
			$query = "SELECT count(*) FROM ano WHERE etat='ligne' AND typp='$typp_dtb' AND zone_ville='$ref_ville_s' AND num_dept='$ref_dept'";
			$result_ano = dtb_query($connexion, $query, __FILE__, __LINE__, 0);
			list($nb) = mysqli_fetch_row($result_ano);
			if ($nb == 0) {
				echo "Faire :: $typp_dtb  :: ref_ville => $ref_ville :: ref_dept => $ref_dept<br/>\n";
				$nb_to_add++;
			}
		}
		echo "</p>\n";
		echo "<p>Il faut faire $nb_to_add :: $typp_dtb</p>\n";
	}
	?>
</body>

</html>