<?PHP
//-----------------------------------------------------------------------
// Tirage au sort de la ville pond�r� par le nombre d'habitant par villes
function random_ville(&$ville, &$dept) {

	// Tableau contenant les minimums et les maximums des tranches d'habitants
	$T_min = array();
	$T_max = array();

	// 64 villes de 48.000 � 100.000 habitants
	$T_min[0] = 48000;
	$T_max[0] = 100000;

	// 26 villes de 100.000 � 200.000
	$T_min[1] = 100000;
	$T_max[1] = 200000;

	// 5 villes de 200.000 � 350.000
	$T_min[2] = 200000;
	$T_max[2] = 350000;

	// 5 villes de 350.000 � 2.200.000
	$T_min[3] = 350000;
	$T_max[3] = 2200000;

	// Table de pond�ration du tirage du num�ro de tranches
	$num_T = array(0, 0, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3);

	// Tirage de l'index dans la table
	$ind_num   = mt_rand(0, count($num_T) - 1);

	// R�cup�rer la tranche
	$ind_T = $num_T[$ind_num];

	$habt_min = $T_min[$ind_T];
	$habt_max = $T_max[$ind_T];

	//echo "---------------------------------------------------------------<br/>\n";
	//echo "Ville � choisir dans la tranche $ind_T de $habt_min � $habt_max<br/><br/><br/>\n";

	$query  = "SELECT ville,dept FROM ref_ville WHERE habt > $habt_min AND habt < $habt_max ORDER BY RAND()";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	list($ville, $dept) = mysqli_fetch_row($result);
	//echo "$ville<br/>";

}
