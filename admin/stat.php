<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Stat du site</title>
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

	$nb_total = get_nb_ano($connexion);
	echo "<p>Nombre total d'annonce en ligne => $nb_total</p>";

	print_nb_ano_by_zone($connexion, 'france');
	print_nb_ano_by_zone($connexion, 'domtom');
	print_nb_ano_by_zone($connexion, 'etranger');

	separate();

	echo "<p>Ca c'est du virtuel</p>";
	$email = 'silver_immo@yahoo.fr';
	$nb_silver = get_nb_ano_by_mail($connexion, $email);
	echo "<p>$email => $nb_silver</p>";

	$nb_reste = $nb_total - $nb_silver;

	echo "<p>Il nous reste $nb_reste annonce réélle</p>";

	separate();

	get_nb_ano_by_typp_france($connexion, false, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
	echo "<p>Valeurs non simulées sur la france</p>";
	echo "<p>nb_appartement => $nb_appartement,nb_maison => $nb_maison,nb_loft => $nb_loft,nb_chalet => $nb_chalet</p>";

	get_nb_ano_by_typp_france($connexion, true, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
	echo "<p>Valeurs simulées sur la france</p>";
	echo "<p>nb_appartement => $nb_appartement,nb_maison => $nb_maison,nb_loft => $nb_loft,nb_chalet => $nb_chalet</p>";

	separate();

	echo "<p>Nombre de clicks moyens sur le mail de simul<br/>";


	$val = get_nb_hits_by_email($connexion, 'silver_immo@yahoo.fr');
	echo "'silver_immo@yahoo.fr' => $val</p>";

	separate();

	$val = get_nb_hits($connexion,);
	echo "<p>Nombre de click moyen pour les annonces non simul�es $val</p>";


	//-----------------------------------------------------------------------------
	function separate() {
		echo "<p>&nbsp;</p>";
		echo "<p>------------------------------------------------------------------</p>";
		echo "<p>&nbsp;</p>";
	}


	//--------------------------------------------------------------------------------------------------------
	// 
	function print_nb_ano_by_zone($connexion, $zone) {

		echo "<p>zone => $zone <br/>";
		$select = "SELECT typp,count(*) FROM ano WHERE etat='ligne' AND zone='$zone' GROUP BY typp";
		$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
		while (list($typp, $nb) = mysqli_fetch_row($result)) {

			echo "$typp => $nb<br/>";
		}
		echo "</p>";
	}
	//--------------------------------------------------------------------------------------------------------
	// 
	function get_nb_ano_by_mail($connexion, $email) {

		$select = "SELECT count(*) FROM ano WHERE etat='ligne' AND email='$email'";
		$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
		list($nb) = mysqli_fetch_row($result);
		return ($nb);
	}
	//--------------------------------------------------------------------------------------------------------
	// Nombre de clicks moyen sur mes emails de simulation 
	function get_nb_hits_by_email($connexion, $email) {

		$select = "SELECT SUM(hits),count(*) FROM ano WHERE etat='ligne' AND email='$email'";
		$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
		list($sum, $nb) = mysqli_fetch_row($result);
		if ($nb != 0) return ($sum / $nb);
		else return 'Pas de valeur';
	}
	//--------------------------------------------------------------------------------------------------------
	// Nombre de clicks moyen sur les emails des annonces non valid�es 
	function get_nb_hits($connexion) {

		$select = "SELECT SUM(hits),count(*) FROM ano WHERE etat='ligne' AND email != 'silver_immo@yahoo.fr'";
		$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
		list($sum, $nb) = mysqli_fetch_row($result);
		echo "<p>Il y a $nb annonces free</p>";
		if ($nb != 0) return ($sum / $nb);
		else return 'Pas de valeur';
	}


	?>
</body>

</html>