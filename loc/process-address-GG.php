<?PHP
include("data.php");
include("../include/inc_base.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>R�cup�rer et traiter la ville contenu dans Address_GG</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP

	set_time_limit(0);

	dtb_connection();

	isset($_GET['action']) ? $action = $_GET['action'] : $action = '';

	// Le but est de r�cup�rer le champ address_GG et de r�cup�rer la ville.
	$query = "SELECT v.idv,v.idd,v.idr,r.region,d.dept,v.ville_CDIP,v.ville,v.address_GG FROM loc_ville as v, loc_departement as d, loc_region as r WHERE v.idd=d.idd AND v.idr=r.idr AND v.maps_code=1";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	// Tableau pour �clater address_GG
	$res = array();
	// Nombre de r�sultats
	$nbr = 0;
	// Longeur maximale d'une r�ponse
	$longeur_max  = 0;
	// Nombre de cas ou address_GG conteint plus de 2 champs
	$part_over2 = 0;

	// Tableau des mots-cl� � traiter de mani�re NON case sensitive
	$key_process_tab     = array('Saintes-', 'Sainte-', 'Saints-', 'Saint-', 'saintes-', 'sainte-', 'saints-', 'saint-');
	$new_key_process_tab = array('Stes-', 'Ste-', 'Sts-', 'St-', 'Stes-', 'Ste-', 'Sts-', 'St-');
	$key_counter_tab     = array(0, 0, 0, 0, 0, 0, 0, 0);

	while (list($idv, $idd, $idr, $region, $dept, $ville_CDIP, $ville, $address_GG) = mysqli_fetch_row($result)) {

		// On explose la chaine en tableau
		$res = explode(',', $address_GG);
		$ville_GG = $res[0];

		// Si il y a max 2 champs dans address_GG => on prend ville_GG
		if (count($res) <= 2) $ville_process = trim($ville_GG);
		else {
			$ville_process = trim($ville_CDIP);
			//echo "$idv : $region,$dept | ville_CDIP => $ville_CDIP | ville_GG => $ville_GG | address_GG => $address_GG<br>";
			$part_over2++;
		}

		// On traite tous les Saints et les Anges
		for ($i = 0; $i < count($key_process_tab); $i++) {
			// Si on a trouver un mot-cl� � traiter
			if (strstr($ville_process, $key_process_tab[$i]) != false) {
				$ville_process = str_replace($key_process_tab[$i], $new_key_process_tab[$i], $ville_GG);
				$key_counter_tab[$i]++;
			}
		}

		if (strlen($ville_process) > $longeur_max) {
			$longeur_max = strlen($ville_process);
			$ville_max = $ville_process;
		}

		$ville_process = process_special_char($ville_process);
		//echo "$ville_process<br>";

		// Si on demande le traitement
		if ($action == 'process') {
			$ville_process = mysqli_real_escape_string($ville_process);
			$query = "UPDATE loc_ville SET ville='$ville_process' WHERE idv=$idv AND idd=$idd AND idr=$idr LIMIT 1";
			dtb_query($query, __FILE__, __LINE__, 0);
		}

		$nbr++;
	}


	echo "----------------------------------------------------------------------------------<br>\n";
	echo "Il y a : $nbr : communes dans la database qui seront trait�es car le champ maps_code = 1<br>\n";
	echo "Parmi elles, il y a : $part_over2 : qui ont un champ adresse fait de plus de 2 parties et qui ne sont pas trait�s<br>\n";

	for ($i = 0; $i < count($key_process_tab); $i++) {
		echo $key_process_tab[$i], ' => ', $key_counter_tab[$i], " traitements<br>\n";
	}

	echo "Ville_max $ville_max de $longeur_max caract�res<br>\n";

	/*-----------------------------------------------*/
	function process_special_char($word) {

		$word = str_replace('�', 'e', $word);
		$word = str_replace('�', 'E', $word);
		$word = str_replace('�', 'e', $word);
		$word = str_replace('�', 'e', $word);
		$word = str_replace('�', 'e', $word);
		$word = str_replace('�', 'o', $word);
		$word = str_replace('�', 'o', $word);
		$word = str_replace('�', 'a', $word);
		$word = str_replace('�', 'a', $word);
		$word = str_replace('�', 'u', $word);
		$word = str_replace('�', 'u', $word);
		$word = str_replace('�', 'u', $word);
		$word = str_replace('�', 'i', $word);
		$word = str_replace('�', 'i', $word);
		$word = str_replace('�', 'c', $word);
		$word = str_replace('-', ' ', $word);

		return $word;
	}
	/*-----------------------------------------------*/

	?>
</body>

</html>