<?PHP

//----------------------
// cron_compte_recherche.php

//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_date_positionnement(&$where_condition, $date_positionnement) {

	$where_condition .= " AND ( dat_ins > '$date_positionnement' )";
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_liste(&$where_condition, $liste) {

	if ($liste != '') {
		// On enlève le dernier séparateur.
		$liste = substr($liste, 0, -1);
		$annonce_tab = explode('|', $liste);
		foreach ($annonce_tab as $tel_ins) $where_condition .= " AND tel_ins != '$tel_ins'";
	}
}

//-----------------
// recherche-carte-ajax.php

//--------------------------------------------------------------------------------
function make_where_condition_with_maps(&$where_condition, $sw_lat, $sw_lng, $ne_lat, $ne_lng) {
	$where_condition = " etat='ligne' AND maps_actif=1 AND maps_lat > $sw_lat AND maps_lat < $ne_lat AND maps_lng > $sw_lng AND maps_lng < $ne_lng ";
}

//---------------------------
// recherche-liste.php / cron_compte_recherche.php / recherche-carte-ajax.php

//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_zone(&$where_condition, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin) {

	if ($zone == 'france') {

		// Si il y a une recherche sur la ville
		if ($zone_ville != "") {

			// Faire la condition where pour la recherche sur la ville
			$where_condition .= " AND ( ( zone_ville='$zone_ville' )";

			// Si il y a la ville il y a le département
			$where_condition .= " AND ( zone_dept='$zone_dept' )";

			// Si il y a une recherche sur les arrondissements
			if ($zone_ard != '') {

				// Faire la condition where pour la recherche par arrondissement
				$list_ard = explode(",", $zone_ard);

				$i = 0;
				foreach ($list_ard as $zone_ard)
					if ($i++ == 0) $where_condition .= " AND ( zone_ard='$zone_ard'";
					else $where_condition .= " OR zone_ard='$zone_ard'";

				$where_condition .= " )";
			}

			// Si il y a une recherche sur les départements voisins
			if ($dept_voisin != '') {

				// Faire la condition where pour la recherche par arrondissement
				$list_dept = explode(",", $dept_voisin);

				$i = 0;
				foreach ($list_dept as $num_dept)
					if ($i++ == 0) $where_condition .= " OR ( num_dept='$num_dept'";
					else $where_condition .= " OR num_dept='$num_dept'";

				$where_condition .= " )";
			}

			$where_condition .= " )";

			// Si il y a une recherche sur les départements de métropole
		} elseif ($zone_dept != "") {

			// Faire la condition where pour la recherche sur ces département
			$where_condition .= " AND ( zone_dept='$zone_dept' )";

			// Si il y a une recherche sur les régions de métropole
		} elseif ($zone_region != "") {

			// Faire la condition where pour la recherche sur ces département
			$where_condition .= " AND ( zone_region='$zone_region' )";
		}

		// Faire la condition where pour la recherche sur ces département
		$where_condition .= " AND ( zone='france' )";
	} elseif ($zone == 'domtom') {

		// Faire la condition where pour la recherche sur ces département
		$where_condition .= " AND zone_dom='$zone_dom' AND zone='domtom'";
	} elseif ($zone == 'etranger') {

		// Faire la condition where pour la recherche par pays
		$where_condition .= " AND zone_pays='$zone_pays' AND zone='etranger'";
	}
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_nbpi(&$where_condition, $P1, $P2, $P3, $P4, $P5) {

	if ($P1 != '0' || $P2 != '0' || $P3 != '0' || $P4 != '0' || $P5 != '0') {

		$where_condition .= " AND ( nbpi=0 ";
		if ($P1 == '1') $where_condition .= " OR nbpi=1";
		if ($P2 == '2') $where_condition .= " OR nbpi=2";
		if ($P3 == '3') $where_condition .= " OR nbpi=3";
		if ($P4 == '4') $where_condition .= " OR nbpi=4";
		if ($P5 == '5') $where_condition .= " OR nbpi>=5";
		$where_condition .= " )";
	}
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_typp(&$where_condition, $typp) {

	if ($typp != '0') {

		if ($typp == VAL_NUM_APPARTEMENT) $where_condition .= " AND typp='appartement'";
		if ($typp == VAL_NUM_LOFT) $where_condition .= " AND typp='loft'";
		if ($typp == VAL_NUM_CHALET) $where_condition .= " AND typp='chalet'";
		if ($typp == VAL_NUM_MAISON) $where_condition .= " AND typp='maison'";
	}
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_typp_dtb(&$where_condition, $typp) {

	if ($typp != '') $where_condition .= " AND typp='$typp'";
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_sur_min(&$where_condition, $sur_min) {
	if ($sur_min != '0') $where_condition .= " AND surf >= $sur_min";
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition_with_prix_max(&$where_condition, $prix_max) {
	if ($prix_max != '0') $where_condition .= " AND prix <= $prix_max";
}
