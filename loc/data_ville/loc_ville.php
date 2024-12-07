<?PHP
include("../../data/data.php");
include("../../include/inc_base.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Faire la table des villes</title>
	<meta charset="UTF-8">
</head>

<body>
	<?PHP

	set_time_limit(0);

	dtb_connection();

	$lg_ville_max     = 0;
	$lg_ville_url_max = 0;

	$file_list = array();

	// R�gion Alsace 
	// D�partements : Bas-Rhin (67) , Haut-Rhin (68) 
	array_push($file_list, 'region_01_dept_67.txt');
	array_push($file_list, 'region_01_dept_68.txt');


	// R�gion Aquitaine 
	// D�partements : Dordogne (24) , Gironde (33) , Landes (40) , Lot-et-Garonne (47) , Pyr�n�es-Atlantiques (64) 
	array_push($file_list, 'region_02_dept_24.txt');
	array_push($file_list, 'region_02_dept_33.txt');
	array_push($file_list, 'region_02_dept_40.txt');
	array_push($file_list, 'region_02_dept_47.txt');
	array_push($file_list, 'region_02_dept_64.txt');

	// R�gion Auvergne 
	// D�partements : Allier (03) , Cantal (15) , Haute-Loire (43) , Puy-de-D�me (63) 
	array_push($file_list, 'region_03_dept_03.txt');
	array_push($file_list, 'region_03_dept_15.txt');
	array_push($file_list, 'region_03_dept_43.txt');
	array_push($file_list, 'region_03_dept_63.txt');


	// R�gion Basse Normandie 
	// D�partements : Calvados (14) , Manche (50) , Orne (61) 
	array_push($file_list, 'region_04_dept_14.txt');
	array_push($file_list, 'region_04_dept_50.txt');
	array_push($file_list, 'region_04_dept_61.txt');

	// R�gion Bourgogne 
	// D�partements : C�te-d'Or (21) , Ni�vre (58) , Sa�ne-et-Loire (71) , Yonne (89) 
	array_push($file_list, 'region_05_dept_21.txt');
	array_push($file_list, 'region_05_dept_58.txt');
	array_push($file_list, 'region_05_dept_71.txt');
	array_push($file_list, 'region_05_dept_89.txt');

	// R�gion Bretagne 
	// D�partements : C�tes-d'Armor (22) , Finist�re (29) , Ille-et-Vilaine (35) , Morbihan (56) 
	array_push($file_list, 'region_06_dept_22.txt');
	array_push($file_list, 'region_06_dept_29.txt');
	array_push($file_list, 'region_06_dept_35.txt');
	array_push($file_list, 'region_06_dept_56.txt');


	// R�gion Centre 
	// D�partements : Cher (18) , Eure-et-Loir (28) , Indre (36) , Indre-et-Loire (37) , Loir-et-Cher (41) , Loiret (45) 
	array_push($file_list, 'region_07_dept_18.txt');
	array_push($file_list, 'region_07_dept_28.txt');
	array_push($file_list, 'region_07_dept_36.txt');
	array_push($file_list, 'region_07_dept_37.txt');
	array_push($file_list, 'region_07_dept_41.txt');
	array_push($file_list, 'region_07_dept_45.txt');

	// R�gion Champagne Ardenne 
	// D�partements : Ardennes (08) , Aube (10) , Marne (51) , Haute-Marne (52)
	array_push($file_list, 'region_08_dept_08.txt');
	array_push($file_list, 'region_08_dept_10.txt');
	array_push($file_list, 'region_08_dept_51.txt');
	array_push($file_list, 'region_08_dept_52.txt');

	// R�gion Corse 
	// D�partements : Corse-du-Sud (2A) , Haute-Corse (2B)
	// Modifier en 20 
	array_push($file_list, 'region_09_dept_20.txt');


	// R�gion Franche Comt� 
	// D�partements : Doubs (25) , Jura (39) , Haute-Sa�ne (70) , Territoire de Belfort (90) 
	array_push($file_list, 'region_10_dept_25.txt');
	array_push($file_list, 'region_10_dept_39.txt');
	array_push($file_list, 'region_10_dept_70.txt');
	array_push($file_list, 'region_10_dept_90.txt');

	// R�gion Haute Normandie 
	// D�partements : Eure (27) , Seine-Maritime (76) 
	array_push($file_list, 'region_11_dept_27.txt');
	array_push($file_list, 'region_11_dept_76.txt');

	// R�gion Ile de France 
	// D�partements : Paris (75) , Seine-et-Marne (77) , Yvelines (78) , Essonne (91) , Hauts-de-Seine (92) , Seine-Saint-Denis (93) , Val-de-Marne (94) , Val-d'Oise (95) 
	array_push($file_list, 'region_12_dept_75.txt');
	array_push($file_list, 'region_12_dept_77.txt');
	array_push($file_list, 'region_12_dept_78.txt');
	array_push($file_list, 'region_12_dept_91.txt');
	array_push($file_list, 'region_12_dept_92.txt');
	array_push($file_list, 'region_12_dept_93.txt');
	array_push($file_list, 'region_12_dept_94.txt');
	array_push($file_list, 'region_12_dept_95.txt');


	// R�gion Languedoc Roussilon 
	// D�partements : Aude (11) , Gard (30) , H�rault (34) , Loz�re (48) , Pyr�n�es-Orientales (66) 
	array_push($file_list, 'region_13_dept_11.txt');
	array_push($file_list, 'region_13_dept_30.txt');
	array_push($file_list, 'region_13_dept_34.txt');
	array_push($file_list, 'region_13_dept_48.txt');
	array_push($file_list, 'region_13_dept_66.txt');

	// R�gion Limousin 
	// D�partements : Corr�ze (19) , Creuse (23) , Haute-Vienne (87)
	array_push($file_list, 'region_14_dept_19.txt');
	array_push($file_list, 'region_14_dept_23.txt');
	array_push($file_list, 'region_14_dept_87.txt');

	// R�gion Lorraine 
	// D�partements : Meurthe-et-Moselle (54) , Meuse (55) , Moselle (57) , Vosges (88) 
	array_push($file_list, 'region_15_dept_54.txt');
	array_push($file_list, 'region_15_dept_55.txt');
	array_push($file_list, 'region_15_dept_57.txt');
	array_push($file_list, 'region_15_dept_88.txt');

	// R�gion Midi Pyr�n�es 
	// D�partements : Ari�ge (09) , Aveyron (12) , Haute-Garonne (31) , Gers (32) , 
	// Lot (46) , Hautes-Pyr�n�es (65) , Tarn (81) , Tarn-et-Garonne (82) 
	array_push($file_list, 'region_16_dept_09.txt');
	array_push($file_list, 'region_16_dept_12.txt');
	array_push($file_list, 'region_16_dept_31.txt');
	array_push($file_list, 'region_16_dept_32.txt');
	array_push($file_list, 'region_16_dept_46.txt');
	array_push($file_list, 'region_16_dept_65.txt');
	array_push($file_list, 'region_16_dept_81.txt');
	array_push($file_list, 'region_16_dept_82.txt');

	// R�gion Nord Pas de Calais 
	// D�partements : Nord (59) , Pas-de-Calais (62) 
	array_push($file_list, 'region_17_dept_59.txt');
	array_push($file_list, 'region_17_dept_62.txt');

	// R�gion Pays de la Loire 
	// D�partements : Loire-Atlantique (44) , Maine-et-Loire (49) , Mayenne (53) , Sarthe (72) , Vend�e (85) 
	array_push($file_list, 'region_18_dept_44.txt');
	array_push($file_list, 'region_18_dept_49.txt');
	array_push($file_list, 'region_18_dept_53.txt');
	array_push($file_list, 'region_18_dept_72.txt');
	array_push($file_list, 'region_18_dept_85.txt');

	// R�gion Picardie 
	// D�partements : Aisne (02) , Oise (60) , Somme (80) 
	array_push($file_list, 'region_19_dept_02.txt');
	array_push($file_list, 'region_19_dept_60.txt');
	array_push($file_list, 'region_19_dept_80.txt');

	// R�gion Poitou Charentes 
	// D�partements : Charente (16) , Charente-Maritime (17) , Deux-S�vres (79) , Vienne (86) 
	array_push($file_list, 'region_20_dept_16.txt');
	array_push($file_list, 'region_20_dept_17.txt');
	array_push($file_list, 'region_20_dept_79.txt');
	array_push($file_list, 'region_20_dept_86.txt');

	// R�gion Provence Alpes C�te d'Azur 
	// D�partements : Alpes-de-Haute-Provence (04) , Hautes-Alpes (05) , Alpes-Maritimes (06) , 
	// Bouches-du-Rh�ne (13) , Var (83) , Vaucluse (84) 
	array_push($file_list, 'region_21_dept_04.txt');
	array_push($file_list, 'region_21_dept_05.txt');
	array_push($file_list, 'region_21_dept_06.txt');
	array_push($file_list, 'region_21_dept_13.txt');
	array_push($file_list, 'region_21_dept_83.txt');
	array_push($file_list, 'region_21_dept_84.txt');

	// R�gion Rh�ne Alpes 
	// D�partements : Ain (01) , Ard�che (07) , Dr�me (26) , Is�re (38) ,
	// Loire (42) , Rh�ne (69) , Savoie (73) , Haute-Savoie (74) 
	array_push($file_list, 'region_22_dept_01.txt');
	array_push($file_list, 'region_22_dept_07.txt');
	array_push($file_list, 'region_22_dept_26.txt');
	array_push($file_list, 'region_22_dept_38.txt');
	array_push($file_list, 'region_22_dept_42.txt');
	array_push($file_list, 'region_22_dept_69.txt');
	array_push($file_list, 'region_22_dept_73.txt');
	array_push($file_list, 'region_22_dept_74.txt');

	foreach ($file_list as $file_name) {

		$idr = get_idr($file_name);
		$idd = get_idd($file_name);

		echo "---------------------------------<br>";
		echo "Num�ro de r�gion idr      => $idr<br>\n";
		echo "Num�ro de d�partement idd => $idd<br>\n";

		traiter_fichier_ville($file_name, $idr, $idd, $lg_ville_max, $lg_ville_url_max);
	}

	echo "-----------------------------------------------<br>\n";
	echo "lg_ville_max     => $lg_ville_max<br>";
	echo "lg_ville_url_max => $lg_ville_url_max<br>";


	?>
</body>

</html>
<?PHP

//-------------------------------------------------------------
function get_idr($file_name) {

	// La cl� de la region est contenu dans le nom du fichier
	$idr = substr($file_name, 7, 2);
	return ((int)$idr);
}
//-------------------------------------------------------------
function get_idd($file_name) {

	// Le num�ro du d�partement est contenu dans le nom du fichier
	$dept_num = substr($file_name, 15, 2);

	// Il faut retrouver la cl�
	$query  = "SELECT idd FROM loc_departement WHERE dept_num='$dept_num'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	if (mysqli_num_rows($result)) {
		list($idd) = mysqli_fetch_row($result);
		return ($idd);
	} else return false;
}
//-------------------------------------------------------------
// Traite le fichier texte d'un d�partement
// idr est la cl� dans la table des r�gions
// idd est la cl� dans la table des villes
function traiter_fichier_ville($file_name, $idr, $idd, &$lg_ville_max, &$lg_ville_url_max) {

	$fp = fopen($file_name, 'r');

	if ($fp != '') {

		// On cr�er une table temporaire pour pouvoir faire un tri par ordre alphab�tique.
		$query = "CREATE TEMPORARY TABLE tmp (
                                         `ville` varchar(50) NOT NULL default '',
                                         `ville_url` varchar(50) NOT NULL default ''
                                          )";

		dtb_query($query, __FILE__, __LINE__, 1);

		while (1) {

			// Lire une ligne
			$buffer = fgets($fp, 4096);

			// Si il y a des donn�es
			if (!feof($fp)) {

				echo "--------------------<br>";
				echo "$buffer<br>";

				if (trim($buffer) == '') continue;

				$buffer = str_replace('SAINTE', 'STE', $buffer);
				$buffer = str_replace('SAINT', 'ST', $buffer);


				// Mettre en forme la ville
				$ville  = trim(str_replace('-', ' ', $buffer));
				$ville = ucwords(strtolower($ville));

				// Mettre en forme ville_url
				$ville_url = trim(strtolower($buffer));

				if (strlen($ville)     >= 42) echo "WARNING<br>";
				if (strlen($ville_url) >= 42) echo "WARNING<br>";

				$ville      = mysqli_real_escape_string($ville);
				$ville_url  = mysqli_real_escape_string($ville_url);

				if (strlen($ville)     > $lg_ville_max) $lg_ville_max     = strlen($ville);
				if (strlen($ville_url) > $lg_ville_url_max) $lg_ville_url_max = strlen($ville_url);

				$query = "INSERT INTO tmp (ville,ville_url) VALUES ('$ville','$ville_url')";
				dtb_query($query, __FILE__, __LINE__, 1);
				//echo "$query<br>\n";

			} else break;
		} // Fin while

		$query  = "SELECT ville,ville_url FROM tmp ORDER BY ville ASC";
		$result = dtb_query($query, __FILE__, __LINE__, 1);

		while (list($ville, $ville_url) = mysqli_fetch_row($result)) {

			$ville      = mysqli_real_escape_string($ville);
			$ville_url  = mysqli_real_escape_string($ville_url);

			$query = "INSERT INTO loc_ville (idr,idd,ville,ville_url) VALUES ('$idr','$idd','$ville','$ville_url')";
			dtb_query($query, __FILE__, __LINE__, 1);
		}

		$query = "DROP TABLE tmp";
		$result = dtb_query($query, __FILE__, __LINE__, 1);
	} // Fin if fp
}
?>