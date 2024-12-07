<?PHP
include("../data/data.php");
include("../include/inc_base.php");

dtb_connection();
?>
<!DOCTYPE html>
<html>

<head>
	<title>V�rification de la table ano</title>
	<meta charset="UTF-8">
</head>

<body>
	<?PHP

	/* On v�rifie la coh�rence des combinaisons zone_ville / zone_dept / zone_region / num_dept */

	echo "<strong>On v�rifie la coh�rence des combinaisons zone_ville / zone_dept / zone_region / num_dept</strong><br/>\n";

	/* S�lection des combinaisons � v�rifier */
	$query = "SELECT tel_ins,zone_ville,zone_dept,zone_region,num_dept FROM ano WHERE zone='france'";
	$result = dtb_query($query, __FILE__, __LINE__, 1);

	$ko = 0;
	$ano = 0;
	while (list($tel_ins, $zone_ville, $zone_dept, $zone_region, $num_dept) = mysqli_fetch_row($result)) {

		$zone_ville_s   = addslashes($zone_ville);
		$zone_dept_s    = addslashes($zone_dept);
		$zone_region_s  = addslashes($zone_region);

		$query = "SELECT v.ville,d.dept,d.dept_num,r.region FROM  loc_ville as v,
		                                                          loc_departement as d,
																														  loc_region as r
						  WHERE v.idd = d.idd AND v.idr=r.idr 
							AND v.ville='$zone_ville_s' AND d.dept='$zone_dept_s' AND d.dept_num='$num_dept' AND r.region='$zone_region_s'";

		$result_ano = dtb_query($query, __FILE__, __LINE__, 0);

		if (mysqli_num_rows($result_ano) == 0) {
			echo "KO:::$tel_ins => $zone_ville :: $zone_dept :: $zone_region :: $num_dept<br/>\n";
			$ko++;
		}
		$ano++;
	}

	echo "<strong>$ano annonces v�rifi�es et $ko erreur(s)</strong><br/>\n";

	?>
</body>

</html>