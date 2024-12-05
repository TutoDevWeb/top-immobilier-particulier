<?PHP
function print_keyword_search() {
?>
	<div id="keyword">
		<h2>Recherche Paris<br />par Produits</h2>
		<div class="box"><a href='/vente-appartement-entre-particuliers-paris.htm' title='Vente appartements entre particuliers � Paris'>vente appartement<br />particuliers paris</a></div>
		<div class="box"><a href='/vente-studio-entre-particuliers-paris.htm' title='Vente studio entre particuliers � Paris'>vente studio<br />particuliers paris</a></div>
		<div class="boxlast"><a href='/vente-loft-entre-particuliers-paris.htm' title='Vente loft entre particuliers � Paris'>vente loft<br />particuliers paris</a></div>
	</div>
<?PHP
}
// ----------------------------------------------------------------------------------
// Affiche les liens avec la r�-�criture d'URLs
// Il y a un lien d'�crit pour chaque arrondisement
// $keywords : les mots cl�s cibl�s sur la page
// $ard_stat : le tableau qui contient le nombre de produit par arrondissement
// $stat     : le flag qui dit si on doit afficher ou pas les stats
function print_keyword_link_rewriting($xiti, $keywords, $ard_stat, $number_size, $stat) {

	$url_site = URL_SITE;

	for ($ard = 1; $ard <= 20; $ard++) {

		$suf = to_str_ard($ard);

		$link = "${url_site}$xiti-${ard}.htm";
		$nb = format_stat_number_size($ard_stat[$ard], $number_size);

		if ($ard_stat[$ard] == 0) echo "<a href='$link' rel='nofollow' title='$keywords $suf arrondissement'>( $nb ) $keywords $suf arrondissement</a>\n";
		else echo "<a href='$link' title='$keywords $suf arrondissement'>( $nb ) $keywords $suf arrondissement</a>\n";
	}
}
// ----------------------------------------------------------------------------------
// Retourne un tableau avec pour chague arrondissement le nombre de produit
function get_query_stat($query) {

	$where_condition = "WHERE etat='ligne' AND zone_ville='Paris' ";

	// On r�cup�re la liste des arguments
	$arg_tab = explode('&', $query);


	// On parcours cette liste
	foreach ($arg_tab as $arg) {

		if (DEBUG_SEARCH_KEYWORDS) echo "<p>$arg</p>";

		// Pour chaqu'un d'entre eux on s�pare le nom de la valeur
		$arg_item  = explode('=', $arg);
		$arg_name  = $arg_item[0];
		$arg_value = $arg_item[1];

		if (DEBUG_SEARCH_KEYWORDS) echo "<p>arg_name => $arg_name : arg_value => $arg_value</p>";

		if ($arg_name == 'typp') {

			if ($arg_value == '1') $where_condition .= " AND typp='appartement'";
			if ($arg_value == '2') $where_condition .= " AND typp='pavillon'";
			if ($arg_value == '3') $where_condition .= " AND typp='loft'";
			if ($arg_value == '4') $where_condition .= " AND typp='autres'";
		}
	}


	// Il y en a au moins 1 nombre de pi�ce de cocher
	// Et on met le compteur � 0
	$nbc = 0;
	$where_condition .= " AND ( ";
	// On parcours cette liste
	foreach ($arg_tab as $arg) {

		// Pour chaqu'un d'entre eux on s�pare le nom de la valeur
		$arg_item  = explode('=', $arg);
		$arg_name  = $arg_item[0];
		$arg_value = $arg_item[1];

		if (DEBUG_SEARCH_KEYWORDS) echo "<p>arg_name => $arg_name : arg_value => $arg_value</p>";

		if ($arg_name == 'P1' || $arg_name == 'P2' || $arg_name == 'P3' || $arg_name == 'P4' || $arg_name == 'P5') {

			if ($nbc == 1) $where_condition .= " OR nbpi=$arg_value";
			else {
				$where_condition .= "nbpi=$arg_value";
				$nbc = 1;
			}
		}
	}
	$where_condition .= " )";

	if (DEBUG_SEARCH_KEYWORDS) echo "<p>$where_condition</p>";

	$select = "SELECT zone_ard,COUNT(ida) FROM ano $where_condition GROUP BY zone_ard ASC";
	$result = dtb_query($select, __FILE__, __LINE__, DEBUG_SEARCH_KEYWORDS);

	// On initialise un tableau � 21 case.
	// L'arrondissement correspondra � l'indice
	$ard_stat = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

	// Il suffit d'affecter toutes les valeurs trouv�es		  
	while (list($ard, $nba) = mysqli_fetch_row($result)) {
		$ard_stat[$ard] = $nba;
	}

	return $ard_stat;
}
// ----------------------------------------------------------------------------------
// Retourne le nombre de chiffre max dans lequel est exprim� le nombre de produit
function get_stat_number_size($ard_stat) {

	$number_size = 1;
	for ($ard = 1; $ard <= 20; $ard++) {
		if ($ard_stat[$ard] >= 10) $number_size = 2;
		if ($ard_stat[$ard] >= 100) $number_size = 3;
	}
	return $number_size;
}
// ----------------------------------------------------------------------------------
// L'affichage de la valeur de nb doit �tre fair sur $number_size caract�res 
// La procedure fonctionne jusqu'� un nombre de 999 produit par arrondissement
function format_stat_number_size($nb, $number_size) {

	//echo "nb => $nb : number_size => $number_size<br/>";

	// Taille de la valeur de $nb
	if ($nb < 10) $nb_size = 1;
	else if ($nb < 100) $nb_size = 2;
	else if ($nb < 1000) $nb_size = 3;

	// Le nombre de caract�re � ajouter devant
	$nb_car = $number_size - $nb_size;

	// On ajoute de 0 � 2 caract�re
	if ($nb_car == 0) return ($nb);
	else if ($nb_car == 1) return ("&nbsp;" . $nb);
	else if ($nb_car == 2) return ("&nbsp;&nbsp;" . $nb);
}
?>