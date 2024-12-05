<?PHP
//------------------------------------------------------------------------------------------------
function print_result($result) {

	$i = 1;
	while (list($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $typp, $prix, $quart, $nbpi, $surf, $tel_ins, $hits) = mysqli_fetch_row($result)) {

		$prix_str     = format_prix($prix);
		$zone_ard_str = format_ard($zone_ard);
		$typp_str     = ucfirst($typp);
		$quart        = ucwords(strtolower($quart));
		$zone_ville   = ucwords(strtolower($zone_ville));
		echo "<table summary='Annonce num�ro $i' width='468' border='0' cellspacing='0' cellpadding='5'>\n";
		echo "<tr>\n";
		if ($zone == 'france') echo "<td class='paris'>$zone_ville ($zone_dept) $zone_ard_str</td>\n";
		if ($zone == 'domtom') echo "<td class='paris'>$zone_ville $zone_dom</td>\n";
		if ($zone == 'etranger') echo "<td class='paris'>$zone_pays $zone_ville</td>\n";
		echo "<td class='prix'>$prix_str �</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class='quart'>$quart</td>\n";
		echo "<td class='text10'>( $hits hits )</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class='summary'>$typp_str de $nbpi Pi�ces de $surf m� environ</td>\n";
		echo "<td class='textr'><a href='#' class='details'  onclick=\"to('/annonce-${tel_ins}.htm')\"><img src='/images/details.gif' alt=\"D�tails de l'annonce\" /></a></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br/>\n";
		$i++;
	}
}
//------------------------------------------------------------------------------------------------
function print_result_table($result, $rec_zone, $rec_zone_pays, $rec_zone_dom, $rec_zone_region, $rec_zone_dept, $rec_zone_ville, $rec_zone_ard, $rec_dept_voisin, $rec_typp, $rec_P1, $rec_P2, $rec_P3, $rec_P4, $rec_P5, $rec_sur_min, $rec_prix_max, $rec_ids) {

	$rec_zone_pays   = urlencode($rec_zone_pays);
	$rec_zone_dom    = urlencode($rec_zone_dom);
	$rec_zone_region = urlencode($rec_zone_region);
	$rec_zone_dept   = urlencode($rec_zone_dept);
	$rec_zone_ville  = urlencode($rec_zone_ville);
	$rec_zone_ard    = urlencode($rec_zone_ard);
	$rec_dept_voisin = urlencode($rec_dept_voisin);

	$i = 1;
	while (list($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $num_dept, $zone_ville, $zone_ard, $typp, $prix, $quart, $nbpi, $surf, $tel_ins, $hits) = mysqli_fetch_row($result)) {

		$zone_ville = strtolower($zone_ville);
		$prix_str     = format_prix($prix);
		if ($zone_ville == 'paris' ||  $zone_ville == 'marseille' || $zone_ville == 'lyon') $zone_ard_str = format_ard($zone_ard);
		else $zone_ard_str = '';
		$typp_str     = ucfirst($typp);
		$quart        = ucwords(strtolower($quart));
		$zone_ville   = ucwords($zone_ville);
		echo "<table summary='Annonce num�ro $i'>\n";
		echo "<tr>\n";
		if ($zone == 'france') echo "<td class='td_g'>$zone_ville ($num_dept) $zone_ard_str</td>\n";
		if ($zone == 'domtom') echo "<td class='td_g'>$zone_ville $zone_dom</td>\n";
		if ($zone == 'etranger') echo "<td class='td_g'>$zone_pays $zone_ville</td>\n";
		echo "<td class='td_d'>$prix_str �</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class='td_g'>$quart</td>\n";
		echo "<td class='td_d'>( $hits hits )</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class='td_g'>$typp_str de $nbpi Pi�ces de $surf m� environ</td>\n";
		echo "<td class='td_d'><a href='/cons/details.php?tel_ins=$tel_ins&amp;from=liste&amp;zone=$rec_zone&amp;zone_pays=$rec_zone_pays&amp;zone_dom=$rec_zone_dom&amp;zone_region=$rec_zone_region&amp;zone_dept=$rec_zone_dept&amp;zone_ville=$rec_zone_ville&amp;zone_ard=$rec_zone_ard&amp;dept_voisin=$rec_dept_voisin&amp;typp=$rec_typp&amp;P1=$rec_P1&amp;P2=$rec_P2&amp;P3=$rec_P3&amp;P4=$rec_P4&amp;P5=$rec_P5&amp;sur_min=$rec_sur_min&amp;prix_max=$rec_prix_max&amp;ids=$rec_ids' class='details' rel='nofollow' title=\"D�tails de l'annonce\"></a></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br/>\n";
		$i++;
	}
	return ($i - 1);
}
//------------------------------------------------------------------------------------------------
function print_result_autour_ville($result) {

	// On voit s'il y a des r�sultats
	if (mysqli_num_rows($result)) {

		while (list($zone_ville, $nba) = mysqli_fetch_row($result)) {

			$zone_ville   = ucwords(strtolower($zone_ville));
			echo "$zone_ville : $nba annonces<br/>";
		}
	}
}
