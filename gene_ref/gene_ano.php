<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_random.php");
include("../include/inc_conf.php");
include("gen_ano_maison.php");
include("gen_ano_appartement.php");
include("gen_ano_studio.php");
include("gen_random_produit.php");
include("gen_random_ville.php");
include("gen_target_ville.php");
include("gen_commodite.php");
dtb_connection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>G�n�ration tranche d'annonces</title>
	<meta charset="UTF-8">
</head>

<body>
	<?PHP

	gene_ano_target(3);

	//-----------------------------------------------------------------------
	function gene_ano_target($nb_ano) {

		for ($i = 0; $i < $nb_ano; $i++) {

			$rep = target_ville($ref_ville, $ref_dept, $produit);

			if ($rep == false) {
				echo "<p>Il ne manque pas d'annonce</p>";
				break;
			} else {

				if ($produit == 'Maison') make_maison($ref_ville, $ref_dept);
				if ($produit == 'Appartement') make_appartement($ref_ville, $ref_dept);
				if ($produit == 'Studio') make_studio($ref_ville, $ref_dept);
			}
		}
	}
	//-----------------------------------------------------------------------
	function gene_ano_random($nb_ano) {

		for ($i = 0; $i < $nb_ano; $i++) {

			random_ville($ref_ville, $ref_dept);
			$produit = random_produit();

			if ($produit == 'Maison') make_maison($ref_ville, $ref_dept);
			if ($produit == 'Appartement') make_appartement($ref_ville, $ref_dept);
			if ($produit == 'Studio') make_studio($ref_ville, $ref_dept);
		}
	}
	//--------------------------------------------------------------------------------------------------------
	function make_prix($ville, $ard, $surf) {

		$query  = "SELECT prix FROM ref_prix WHERE ville='$ville' AND ard='$ard'";
		$result = dtb_query($query, __FILE__, __LINE__, 0);

		list($prix) = mysqli_fetch_row($result);

		// Il faut faire un arrondi  
		$prix_total = $prix * $surf;
		$prix_total = substr($prix_total, 0, -3) . "000";

		return ($prix_total);
	}
	//--------------------------------------------------------------------------------------------------------
	// Tire au sort un num�ro de t�l�phone
	function get_telephone() {

		$code_g = "";
		$number = "00123456789";

		for ($cnt = 0; $cnt < 8; $cnt++) $code_g .= (string)$number[mt_rand(0, strlen($number) - 1)];

		$telephone = "06" . $code_g;

		return ($telephone);
	}
	//--------------------------------------------------------------------------------------------------------
	// Tire au sort un arrondissement si Paris / Marseille / Lyon
	function get_ard($ville) {

		if ($ville == 'Paris') $ard = mt_rand(1, 20);
		else if ($ville == 'Marseille') $ard = mt_rand(1, 16);
		else if ($ville == 'Lyon') $ard = mt_rand(1, 9);
		else $ard = 0;

		return $ard;
	}
	//--------------------------------------------------------------------------------------------------------
	// R�cup�re le d�partement
	function get_dept($ville) {

		$query = "SELECT dept FROM ref_ville WHERE ville='$ville'";
		$result = dtb_query($query, __FILE__, __LINE__, 0);
		list($dept) = mysqli_fetch_row($result);
		return ($dept);
	}
	//--------------------------------------------------------------------------------------------------------
	// Retourne false si on est pas en Ile de france et sinon
	// Retourne le num�ro du d�partement d'Idf
	function ville_en_idf($ville) {

		$query = "SELECT dept FROM ref_ville WHERE ville='$ville'";
		$result = dtb_query($query, __FILE__, __LINE__, 0);
		list($dept) = mysqli_fetch_row($result);

		if ($dept == 77 ||  $dept == 78 ||  $dept == 91 ||  $dept == 92 ||  $dept == 93 ||  $dept == 94 || $dept == 95) return ($dept);
		else return (false);
	}
	//--------------------------------------------------------------------------------------------------------
	// Les arguments d'entr�e sont la vile et le departement issu de la table ref_ville.
	function make_zone($ref_ville, $ref_dept, &$zone, &$zone_pays, &$zone_region, &$zone_dept, &$zone_ville, &$zone_ard, &$num_dept) {


		// On est s�r de �a
		$zone      = 'france';
		$zone_pays = 'France';
		$zone_dom  = '';

		$zone_ville = $ref_ville;
		$ref_ville  = addslashes($ref_ville);

		$query = "SELECT d.dept_num,d.dept,r.region FROM loc_ville as v, loc_departement as d, loc_region as r WHERE v.ville='$ref_ville' AND v.idd=d.idd AND d.dept_num='$ref_dept' AND v.idr=r.idr";
		$result = dtb_query($query, __FILE__, __LINE__, 1);
		list($num_dept, $zone_dept, $zone_region) = mysqli_fetch_row($result);

		if ($ref_ville == 'Paris' || $ref_ville == 'Marseille' || $ref_ville == 'Lyon') $zone_ard = get_ard($ref_ville);

		echo "---------------------------------<br/>\n";
		echo "zone => $zone<br/>\n";
		echo "zone_pays => $zone_pays<br/>\n";
		echo "zone_region => $zone_region<br/>\n";
		echo "zone_dept => $zone_dept<br/>\n";
		echo "zone_ville => $zone_ville<br/>\n";
		echo "zone_ard => $zone_ard<br/>\n";
		echo "num_dept => $num_dept<br/>\n";
	}


	?>
</body>

</html>