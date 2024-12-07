<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_filter.php");
include("../include/inc_format.php");
include("../include/inc_where_condition.php");
include("../include/inc_print_result.php");
include("../include/inc_search_keywords.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_dtb_compte_recherche.php");
include("../include/inc_adsense.php");
include("../include/inc_vep.php");
include("../include/inc_count_cnx.php");
include("../include/inc_tracking.php");
include("../include/inc_xiti.php");
include("../include/inc_tools.php");

$connexion = dtb_connection();
count_cnx($connexion);
check_arg($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $ids, $ref_type, $keywords, $ville_url, $dept_url, $ard_url);

?>
<!DOCTYPE html>
<html>

<head>
	<title><?PHP make_title($ref_type, $keywords, $ville_url, $ard_url); ?></title>
	<?PHP make_meta_description($ref_type, $keywords, $ville_url, $ard_url); ?>
	<meta charset="UTF-8">
	<?PHP make_meta_robot($ref_type, $ids); ?>
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/styles-recherche-liste.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-filter.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-link.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-keyword.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/jvscript/browser.js"></script>
	<script type='text/javascript' src='/jvscript/popup.js'></script>
	<script type='text/javascript' src='/jvscript/search.js'></script>
	<script type='text/javascript' src='/compte-recherche/jvscript/services.js'></script>
	<script type='text/javascript'>
		var browser = new Browser();
	</script>
</head>

<body onload="make_zone_ard();make_dept_voisin();">
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='userpan'>
			<div id='header'>
				<div id='logosag'><a href='/' title='WWW.TOP-IMMOBILIER-PARTICULIER.FR'><img src="/images/pdm-120x60.gif" alt="WWW.TOP-IMMOBILIER-PARTICULIER.FR" /></a></div>
				<h1>
					<?PHP make_H1($ref_type, $keywords, $ville_url, $ard_url); ?>
				</h1>
				<div id='navigation'>
					<?PHP if ($zone == 'france') echo "<img src='/images/btn-navigation-120x20.gif' alt='Naviguer dans la zone géographique' />"; ?>
				</div>
				<div id='localization'>
					<?PHP if ($zone == 'france') make_fil_localisation($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max); ?>
				</div>
			</div>
			<div id='gauche'>
				<?PHP
				print_offre_by_zone($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville);
				print_filter_zone($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
				print_selection_zone($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
				?>
			</div>
			<div id='droite'>
				<?PHP
				if ($zone_ville == 'Paris') print_keyword_search();
				?>
				<div id='partners-onglet'></div>
				<div id='partners-box'><?PHP print_partners($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville); ?></div>
			</div>
			<div id='centre'>
				<?PHP
				if ($zone == 'france') make_button_to_maps($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
				process_results($connexion, $nba, $nbt, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $ids);
				print_bouton_alerte_recherche($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
				make_traking($connexion, $nba, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
				if ($nbt <= 3) {
					echo "<p>&nbsp;</p>";
				}
				?>
				<div id='clearboth'>&nbsp;</div>
			</div> <!-- end centre -->
		</div> <!-- end userpan -->
	</div> <!-- end mainpan -->
	<div id='footerpan'>&nbsp;</div><!-- end footerpan -->
</body>

</html>
<?PHP
//--------------------------------------------------------------------------------
function check_arg($connexion, &$zone, &$zone_pays, &$zone_dom, &$zone_region, &$zone_dept, &$zone_ville, &$zone_ard, &$dept_voisin, &$typp, &$P1, &$P2, &$P3, &$P4, &$P5, &$sur_min, &$prix_max, &$ids, &$ref_type, &$keywords, &$ville_url, &$dept_url, &$ard_url) {

	// Paramètres concernant la zone géographique
	isset($_REQUEST['zone'])        ? $zone          = trim($_REQUEST['zone'])        : $zone        = '';
	isset($_REQUEST['zone_pays'])   ? $zone_pays     = trim($_REQUEST['zone_pays'])   : $zone_pays   = '';
	isset($_REQUEST['zone_dom'])    ? $zone_dom      = trim($_REQUEST['zone_dom'])    : $zone_dom    = '';
	isset($_REQUEST['zone_region']) ? $zone_region   = trim($_REQUEST['zone_region']) : $zone_region = '';
	isset($_REQUEST['zone_dept'])   ? $zone_dept     = trim($_REQUEST['zone_dept'])   : $zone_dept   = '';
	isset($_REQUEST['zone_ville'])  ? $zone_ville    = trim($_REQUEST['zone_ville'])  : $zone_ville  = '';
	isset($_REQUEST['zone_ard'])    ? $zone_ard      = trim($_REQUEST['zone_ard'])    : $zone_ard    = '';
	isset($_REQUEST['zone_dept'])   ? $zone_dept     = trim($_REQUEST['zone_dept'])   : $zone_dept   = '';
	isset($_REQUEST['dept_voisin']) ? $dept_voisin   = trim($_REQUEST['dept_voisin']) : $dept_voisin = '';

	// Paramètres concernant le produit
	isset($_REQUEST['typp'])      ? $typp     = trim($_REQUEST['typp']) : $typp     = '0';
	isset($_REQUEST['P1'])        ? $P1       = trim($_REQUEST['P1'])   : $P1       = '0';
	isset($_REQUEST['P2'])        ? $P2       = trim($_REQUEST['P2'])   : $P2       = '0';
	isset($_REQUEST['P3'])        ? $P3       = trim($_REQUEST['P3'])   : $P3       = '0';
	isset($_REQUEST['P4'])        ? $P4       = trim($_REQUEST['P4'])   : $P4       = '0';
	isset($_REQUEST['P5'])        ? $P5       = trim($_REQUEST['P5'])   : $P5       = '0';
	isset($_REQUEST['sur_min'])   ? $sur_min  = $_REQUEST['sur_min']    : $sur_min  = '0';
	isset($_REQUEST['prix_max'])  ? $prix_max = $_REQUEST['prix_max']   : $prix_max = '0';

	// Paramètres concernant le référencement
	isset($_REQUEST['ref_type'])  ? $ref_type   = trim($_REQUEST['ref_type'])  : $ref_type  = '';
	isset($_REQUEST['keywords'])  ? $keywords   = trim($_REQUEST['keywords'])  : $keywords  = '';
	isset($_REQUEST['ville_url']) ? $ville_url  = trim($_REQUEST['ville_url']) : $ville_url = '';
	isset($_REQUEST['dept_url'])  ? $dept_url   = trim($_REQUEST['dept_url'])  : $dept_url  = '';
	isset($_REQUEST['ard_url'])   ? $ard_url    = trim($_REQUEST['ard_url'])   : $ard_url   = '';

	// Si il n'y a pas de tranches à sélectionner on prend la première
	isset($_REQUEST['ids']) ? $ids = $_REQUEST['ids'] : $ids = '1';

	//------------------------------------------------------------------------- 
	// Traitement liées au référencement.
	// On affecte certains arguments manquant pour pouvoir faire un trie  
	//------------------------------------------------------------------------- 
	// Si la page doit être référencée. 
	if ($ref_type != '') {


		if ($ref_type == 'paris') {

			// Traitements fait ici pour éviter de le faire dans chaque fonction de référencement ( make_H1 / make_Meta ... ) 
			$keywords  =  ucwords(str_replace('-', ' ', $keywords));
			$dept_url  =  ucwords(str_replace('-', ' ', $dept_url));
			$ville_url =  ucwords(str_replace('-', ' ', $ville_url));

			// Configuration des arguements nécessaire à l'algorithme de trie de la recherche
			$zone       = 'france';
			$zone_dept  = $dept_url;
			$zone_ville = $ville_url;
			$zone_ard   = $ard_url;
		}


		if ($ref_type == 'town') {

			// Traitements fait ici pour éviter de le faire dans chaque fonction de référencement ( make_H1 / make_Meta ... ) 
			$dept_url  =  ucwords(str_replace('-', ' ', $dept_url));
			$ville_url =  ucwords(str_replace('-', ' ', $ville_url));

			// Configuration des arguements nécessaire à l'algorithme de trie de la recherche
			$zone       = 'france';
			$zone_dept  = $dept_url;
			$zone_ville = $ville_url;
		}

		// Dans le cas du référencement par produit
		// On doit récupérer les urls du département et de la ville
		// On doit également faire des traitements sur les paramètres reçu avant de les passer aux fonctions de référencement
		if ($ref_type == 'product') {

			// Traitements fait ici pour éviter de le faire dans chaque fonction de référencement ( make_H1 / make_Meta ... ) 
			// Les doubles tirets dans l'Url sont transformés en apostrophes
			$dept_url  =  str_replace('--', "'", $dept_url);
			$ville_url =  str_replace('--', "'", $ville_url);

			// Les tirets dans l'Url sont transformés en espace
			$dept_url  =  ucwords(str_replace('-', ' ', $dept_url));
			$ville_url =  ucwords(str_replace('-', ' ', $ville_url));

			// Configuration des arguements nécessaire à l'algorithme de trie de la recherche
			$zone       = 'france';
			$zone_dept  = $dept_url;
			$zone_ville = $ville_url;
		}
	}

	// Vérification de la présence et de la validité de zone
	if ($zone == '') {
		tracking($connexion, CODE_RCL, 'KO', "Il manque l'argument zone", __FILE__, __LINE__);
		die;
	} else if ($zone != 'france' && $zone != 'domtom' && $zone != 'etranger') {
		tracking($connexion, CODE_RCL, 'KO', "L'argument zone a une valeur erron�e : " . $zone, __FILE__, __LINE__);
		die;
	}

	// Si on a un département il faut vérifier qu'il est bon
	if ($zone_dept != '') {
		$zone_dept_s = mysqli_real_escape_string($connexion, $zone_dept);
		$query = "SELECT dept FROM loc_departement WHERE dept='$zone_dept_s'";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_RECHERCHE);
		if (!mysqli_num_rows($result)) {
			tracking($connexion, CODE_RCL, 'KO', "Le nom du département est erroné : $zone_dept", __FILE__, __LINE__);
			die;
		}
	}

	// Si on a le departement on doit chercher et trouver la région si on ne l'a pas
	if ($zone_dept != '' && $zone_region == '') {

		$zone_dept_s = mysqli_real_escape_string($connexion, $zone_dept);
		$query = "SELECT r.region FROM loc_departement as d, loc_region as r WHERE d.idr = r.idr AND d.dept='$zone_dept_s'";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_RECHERCHE);

		if (mysqli_num_rows($result)) list($zone_region) = mysqli_fetch_row($result);
		else {
			tracking($connexion, CODE_RCL, 'KO', "On ne trouve pas la région avec le département : $zone_dept", __FILE__, __LINE__);
			die;
		}
	}

	// Si on a la ville on doit avoir le département impérativement car il peut y avoir conflit
	// Sauf dans le cas du référencement par produit
	if ($zone_ville != '' && $zone_dept == '') {
		tracking($connexion, CODE_RCL, 'KO', "On doit connaitre le département si on a la ville : $zone_ville : $zone_dept", __FILE__, __LINE__);
		die;
	}

	// Si on a la ville
	if ($zone_ville != '') {

		// Si on a une liste de département voisin, vérifier qu'on est bien sur Paris / Marseille ou Lyon.
		if ($dept_voisin != '' && strtolower($zone_ville) != 'paris' && strtolower($zone_ville) != 'marseille' && strtolower($zone_ville) != 'lyon') {
			tracking($connexion, CODE_RCL, 'KO', "Departement voisin sur sur ville non autorisée : $zone_ville", __FILE__, __LINE__);
			die;
		}

		// Si on a une liste d'arrondissement, vérifier qu'on est bien sur Paris / Marseille ou Lyon.
		if ($zone_ard != '' && strtolower($zone_ville) != 'paris' && strtolower($zone_ville) != 'marseille' && strtolower($zone_ville) != 'lyon') {
			tracking($connexion, CODE_RCL, 'KO', "Arrondissement sur ville non autorisée : $zone_ville", __FILE__, __LINE__);
			die;
		}
	}

	// Vérifier qu'on a au moins un Pi de coché
	if ($P1 == '0' && $P2 == '0' && $P3 == '0' && $P4 == '0' && $P5 == '0') {
		$P1 = '1';
		$P2 = '2';
		$P3 = '3';
		$P4 = '4';
		$P5 = '5';
	}
}
//-------------------------------------------------------------------------------------------------------------------
function make_traking($connexion, $nba, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	if ($zone == 'france') {
		$str = "Nombres de résultats => $nba :: $zone :: $zone_region :: $zone_dept :: $zone_ville";
	}

	if ($zone == 'domtom') {
		$str = "Nombres de résultats => $nba :: $zone :: $zone_dom :: $zone_ville";
	}

	if ($zone == 'etranger') {
		$str = "Nombres de résultats => $nba :: $zone :: $zone_pays :: $zone_ville";
	}

	tracking($connexion, CODE_RCL, 'OK', $str, __FILE__, __LINE__);
}
//-------------------------------------------------------------------------------------------------------------------
function count_results($connexion, $where_condition) {


	$select = "SELECT COUNT(tel_ins) FROM ano WHERE " . $where_condition;
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_RECHERCHE);

	// Nombre de résultats
	list($nba) = mysqli_fetch_row($result);

	return ($nba);
}
//-------------------------------------------------------------------------------------------------------------------
function process_results($connexion, &$nba, &$nbt, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $ids) {

	$where_condition = make_where_condition($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);

	$nba = count_results($connexion, $where_condition);

	// Si il n'y a pas de résultats le dire
	if ($nba == 0) print_no_result();
	else {

		// Compter le nombre de tranches de résultat visibles
		$nb_slide = compute_slide($nba);

		$query = make_main_query($ids, $where_condition);
		tracking_dtb($connexion, $query, __FILE__, __LINE__);

		$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_RECHERCHE);

		$nbt = print_result_table($result, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $ids);

		make_link($ids, $nb_slide, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
	}
}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	$where_condition = "etat='ligne'";
	make_where_condition_with_zone($where_condition, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin);
	make_where_condition_with_typp($where_condition, $typp);
	make_where_condition_with_nbpi($where_condition, $P1, $P2, $P3, $P4, $P5);
	make_where_condition_with_sur_min($where_condition, $sur_min);
	make_where_condition_with_prix_max($where_condition, $prix_max);

	$where_condition .= " ORDER BY hits DESC";
	return $where_condition;
}
//-------------------------------------------------------------------------------------------------------------------
function make_main_query($ids, $where_condition) {

	$query = "SELECT zone,zone_pays,zone_dom,zone_region,zone_dept,num_dept,zone_ville,zone_ard,typp,prix,quart,nbpi,surf,tel_ins,hits FROM ano WHERE ";

	$deb = ($ids - 1) * RECH_SLIDE;
	$fin = RECH_SLIDE;

	$where_condition .= " LIMIT $deb,$fin";
	$query .= $where_condition;

	return $query;
}
//-------------------------------------------------------------------------------------------------------------------
function compute_slide($nba) {

	$nb_slide = Ceil($nba / RECH_SLIDE);

	// Limiter le nombre de tranches
	if ($nb_slide > RECH_MAX_SLIDE) {

		$nb_slide   = RECH_MAX_SLIDE;
		$max_res    = RECH_MAX_SLIDE * RECH_SLIDE;

		echo "<p>Vous pouvez voir seulement $max_res résultats sur les listes ci dessous</p>\n";
	}

	return $nb_slide;
}
//-------------------------------------------------------------------------------------------------------------------
function make_link($ids, $nb_slide, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	// Créer la nouvelle Ligne
	echo "<div id='linkbar'>\n";
	echo "<ul>\n";
	// Faire la liste des liens qui pointe sur les requêtes de tranches
	for ($is = 1; $is <= $nb_slide; $is++) {
		echo "<li>";
		if ((int)$ids == $is) $class = "class='active'";
		else                    $class = "";

		// Refaire la liste des arguments recu
		$var = "ids=$is&amp;zone={$zone}&amp;zone_pays={$zone_pays}&amp;zone_dom={$zone_dom}&amp;zone_region={$zone_region}&amp;zone_dept={$zone_dept}&amp;zone_ville={$zone_ville}&amp;zone_ard={$zone_ard}&amp;dept_voisin={$dept_voisin}";
		if ($P1 == '1') $var .= "&amp;P1=1";
		if ($P2 == '2') $var .= "&amp;P2=2";
		if ($P3 == '3') $var .= "&amp;P3=3";
		if ($P4 == '4') $var .= "&amp;P4=4";
		if ($P5 == '5') $var .= "&amp;P5=5";
		$var = $var . "&amp;typp=$typp";
		if ($sur_min != '') $var = $var . "&amp;sur_min=$sur_min";
		if ($prix_max != '') $var = $var . "&amp;prix_max=$prix_max";

		//$var = urlencode($var);

		printf("<a $class href=\"/cons/recherche-liste.php?%s\">%s</a>", $var, $is);
		echo "</li>\n";
	}
	echo "</ul>\n";
	echo "</div>\n";
}
//-------------------------------------------------------------------------------------------------------------------
function print_no_result() {

	echo "<p>Il n'y a pas de résultats à votre recherche</p>\n";
	echo "<p><img src='/images/megaphone-courage.gif' alt='Pas de résultats'/></p>\n";
}
//-------------------------------------------------------------------------------------------------------------------
function print_partners($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville) {

	print_vep_logo();
	return;
}
//-------------------------------------------------------------------------------------------------------------------
function print_offre_by_zone($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville) {
?>
	<div class='filter_box'>

		<?PHP
		if ($zone == 'france') {
			if ($zone_ville  != '') $lieu = "$zone_ville";
			else if ($zone_dept   != '') $lieu = "$zone_dept";
			else if ($zone_region != '') $lieu = "$zone_region";
			else $lieu = 'en France';
		} else if ($zone == 'domtom') $lieu = "dans les Dom Tom";
		else if ($zone == 'etranger') $lieu = "� l'Etranger";
		echo "<h2>Offres de vente $lieu</h2>\n";
		?>

		<div class="box_last">
			<?PHP
			//--------------------------
			if ($zone == 'france') {

				if ($zone_ville  != '') get_nb_ano_by_typp_ville($connexion, $zone_ville, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
				else if ($zone_dept   != '') get_nb_ano_by_typp_dept($connexion, $zone_dept, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
				else if ($zone_region != '') get_nb_ano_by_typp_region($connexion, $zone_region, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
				else                           get_nb_ano_by_typp_france($connexion, $simul = true, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
			} else if ($zone == 'domtom') get_nb_ano_by_typp_zone($connexion, $zone = 'domtom', $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);

			else if ($zone == 'etranger') get_nb_ano_by_typp_zone($connexion, $zone = 'etranger', $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);

			// On récupère ce qu'on a trouvé
			if ($nb_appartement) echo "$nb_appartement Appartements<br/>\n";
			if ($nb_maison) echo "$nb_maison Maisons<br/>\n";
			if ($nb_loft) echo "$nb_loft Loft<br/>\n";
			if ($nb_chalet) echo "$nb_chalet Chalets<br/>\n";

			?>
		</div>
	</div>
	<div class="arrow3"></div>
<?PHP
}
//-------------------------------------------------------------------------------------------------------------------
function print_filter_zone($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {
?>
	<div class='filter_box'>
		<form method="get" name='filter' action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
			<?PHP
			if (strtolower($zone_ville) == 'paris') print_filter_paris($zone_ard, $dept_voisin);
			if (strtolower($zone_ville) == 'marseille') print_filter_marseille($zone_ard, $dept_voisin);
			if (strtolower($zone_ville) == 'lyon') print_filter_lyon($zone_ard, $dept_voisin);
			?>
			<h2>Filtrer par Critères</h2>
			<div class="box_dashed">
				<h3>Type</h3>&nbsp;
				<select id='typp' name="typp">
					<option value="0" <?PHP if ($typp ==  '0') echo "selected='selected'"; ?>>Tous Produits&nbsp;&nbsp;</option>
					<option value="1" <?PHP if ($typp ==  '1') echo "selected='selected'"; ?>>Appartement</option>
					<option value="8" <?PHP if ($typp ==  '8') echo "selected='selected'"; ?>>Maison</option>
					<option value="3" <?PHP if ($typp ==  '3') echo "selected='selected'"; ?>>Loft</option>
					<option value="6" <?PHP if ($typp ==  '6') echo "selected='selected'"; ?>>Chalet</option>
				</select>
			</div>
			<div class="box_dashed">
				<h3>Nombre de Pièces</h3><br />
				<input type="checkbox" id="check_P1" name="P1" value="1" <?PHP if ($P1 == '1') echo "checked='checked'"; ?> /> 1P&nbsp;
				<input type="checkbox" id="check_P2" name="P2" value="2" <?PHP if ($P2 == '2') echo "checked='checked'"; ?> /> 2P&nbsp;
				<input type="checkbox" id="check_P3" name="P3" value="3" <?PHP if ($P3 == '3') echo "checked='checked'"; ?> /> &nbsp;3P<br />
				<input type="checkbox" id="check_P4" name="P4" value="4" <?PHP if ($P4 == '4') echo "checked='checked'"; ?> /> 4P&nbsp;
				<input type="checkbox" id="check_P5" name="P5" value="5" <?PHP if ($P5 == '5') echo "checked='checked'"; ?> /> &nbsp;5P ou +
			</div>
			<div class="box_dashed">
				<h3>Surface min</h3><br />
				<select id="sur_min" name="sur_min">
					<option value="0">Surface&nbsp;&nbsp;</option>
					<option value="10" <?PHP if ($sur_min ==  '10') echo "selected='selected'"; ?>>10</option>
					<option value="20" <?PHP if ($sur_min ==  '20') echo "selected='selected'"; ?>>20</option>
					<option value="30" <?PHP if ($sur_min ==  '30') echo "selected='selected'"; ?>>30</option>
					<option value="40" <?PHP if ($sur_min ==  '40') echo "selected='selected'"; ?>>40</option>
					<option value="50" <?PHP if ($sur_min ==  '50') echo "selected='selected'"; ?>>50</option>
					<option value="60" <?PHP if ($sur_min ==  '60') echo "selected='selected'"; ?>>60</option>
					<option value="70" <?PHP if ($sur_min ==  '70') echo "selected='selected'"; ?>>70</option>
					<option value="80" <?PHP if ($sur_min ==  '80') echo "selected='selected'"; ?>>80</option>
					<option value="90" <?PHP if ($sur_min ==  '90') echo "selected='selected'"; ?>>90</option>
					<option value="100" <?PHP if ($sur_min == '100') echo "selected='selected'"; ?>>100</option>
				</select>
			</div>
			<div class="box">
				<h3>Prix max</h3><br />
				<select id="prix_max" name="prix_max">
					<option value="0">Prix Max&nbsp;&nbsp;</option>
					<option value="100000" <?PHP if ($prix_max ==  '100000') echo "selected='selected'"; ?>>100000</option>
					<option value="200000" <?PHP if ($prix_max ==  '200000') echo "selected='selected'"; ?>>200000</option>
					<option value="300000" <?PHP if ($prix_max ==  '300000') echo "selected='selected'"; ?>>300000</option>
					<option value="400000" <?PHP if ($prix_max ==  '400000') echo "selected='selected'"; ?>>400000</option>
					<option value="500000" <?PHP if ($prix_max ==  '500000') echo "selected='selected'"; ?>>500000</option>
					<option value="600000" <?PHP if ($prix_max ==  '600000') echo "selected='selected'"; ?>>600000</option>
					<option value="700000" <?PHP if ($prix_max ==  '700000') echo "selected='selected'"; ?>>700000</option>
					<option value="800000" <?PHP if ($prix_max ==  '800000') echo "selected='selected'"; ?>>800000</option>
					<option value="900000" <?PHP if ($prix_max ==  '900000') echo "selected='selected'"; ?>>900000</option>
					<option value="1000000" <?PHP if ($prix_max == '1000000') echo "selected='selected'"; ?>>1000000</option>
				</select>
				<input type="hidden" id="zone" name="zone" value="<?PHP echo "$zone";        ?>" />
				<input type="hidden" id="zone_pays" name="zone_pays" value="<?PHP echo "$zone_pays";   ?>" />
				<input type="hidden" id="zone_dom" name="zone_dom" value="<?PHP echo "$zone_dom";    ?>" />
				<input type="hidden" id="zone_region" name="zone_region" value="<?PHP echo "$zone_region"; ?>" />
				<input type="hidden" id="zone_dept" name="zone_dept" value="<?PHP echo "$zone_dept";   ?>" />
				<input type="hidden" id="zone_ville" name="zone_ville" value="<?PHP echo "$zone_ville";  ?>" />
			</div>
			<div class="box_last"><input class="box_input" type="submit" name="Submit" value="Go" /></div>
		</form>
	</div>
<?PHP
}
//-------------------------------------------------------------------------------------------------------------------
function print_filter_paris($zone_ard, $dept_voisin) {

	// Pour pourvoir ré-initialiser les checkbox
	$ard = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	if ($zone_ard == '') $zone_ard = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20";
	$ard_list = explode(',', $zone_ard);
	foreach ($ard_list as $num_ard) $ard[$num_ard] = 1;

	// Département voisin
	if ($dept_voisin != '') {
		$dept_list = explode(',', $dept_voisin);
		foreach ($dept_list as $num_dept) {
			if ($num_dept == '77') $dept_77 = 1;
			if ($num_dept == '78') $dept_78 = 1;
			if ($num_dept == '91') $dept_91 = 1;
			if ($num_dept == '92') $dept_92 = 1;
			if ($num_dept == '93') $dept_93 = 1;
			if ($num_dept == '94') $dept_94 = 1;
			if ($num_dept == '95') $dept_95 = 1;
		}
	}

?>
	<h2>Filtrer par Zone</h2>
	<div class="box_dashed">
		<h3>Arrondissements</h3><br />
		<table>
			<tr>
				<td>
					<div class='numpad'>1</div><input type='checkbox' id='ard_1' name='ard_1' onclick='make_zone_ard();' <?PHP if ($ard[1])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>2</div><input type='checkbox' id='ard_2' name='ard_2' onclick='make_zone_ard();' <?PHP if ($ard[2])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>3</div><input type='checkbox' id='ard_3' name='ard_3' onclick='make_zone_ard();' <?PHP if ($ard[3])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>4</div><input type='checkbox' id='ard_4' name='ard_4' onclick='make_zone_ard();' <?PHP if ($ard[4])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>5</div><input type='checkbox' id='ard_5' name='ard_5' onclick='make_zone_ard();' <?PHP if ($ard[5])  echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>6</div><input type='checkbox' id='ard_6' name='ard_6' onclick='make_zone_ard();' <?PHP if ($ard[6])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>7</div><input type='checkbox' id='ard_7' name='ard_7' onclick='make_zone_ard();' <?PHP if ($ard[7])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>8</div><input type='checkbox' id='ard_8' name='ard_8' onclick='make_zone_ard();' <?PHP if ($ard[8])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>9</div><input type='checkbox' id='ard_9' name='ard_9' onclick='make_zone_ard();' <?PHP if ($ard[9])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>10</div><input type='checkbox' id='ard_10' name='ard_10' onclick='make_zone_ard();' <?PHP if ($ard[10]) echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>11</div><input type='checkbox' id='ard_11' name='ard_11' onclick='make_zone_ard();' <?PHP if ($ard[11]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>12</div><input type='checkbox' id='ard_12' name='ard_12' onclick='make_zone_ard();' <?PHP if ($ard[12]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>13</div><input type='checkbox' id='ard_13' name='ard_13' onclick='make_zone_ard();' <?PHP if ($ard[13]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>14</div><input type='checkbox' id='ard_14' name='ard_14' onclick='make_zone_ard();' <?PHP if ($ard[14]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>15</div><input type='checkbox' id='ard_15' name='ard_15' onclick='make_zone_ard();' <?PHP if ($ard[15]) echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>16</div><input type='checkbox' id='ard_16' name='ard_16' onclick='make_zone_ard();' <?PHP if ($ard[16]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>17</div><input type='checkbox' id='ard_17' name='ard_17' onclick='make_zone_ard();' <?PHP if ($ard[17]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>18</div><input type='checkbox' id='ard_18' name='ard_18' onclick='make_zone_ard();' <?PHP if ($ard[18]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>19</div><input type='checkbox' id='ard_19' name='ard_19' onclick='make_zone_ard();' <?PHP if ($ard[19]) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>20</div><input type='checkbox' id='ard_20' name='ard_20' onclick='make_zone_ard();' <?PHP if ($ard[20]) echo "checked='checked'"; ?> />
				</td>
			</tr>
		</table>
		<div id='link_pad'>
			<a href='#' onclick='select_tout(); return false;' title='S�lectionner tous les arrondissements'>Tous</a>&nbsp;&nbsp;&nbsp;
			<a href='#' onclick='select_rien(); return false;' title='D�-s�lectionner tous les arrondissements'>Aucun</a>
		</div>
	</div>
	<div class="box">
		<h3>Départements Voisins</h3><br />
		<table>
			<tr>
				<td>
					<div class='numpad'>77</div><input name='dept_77' type='checkbox' id='dept_77' onclick='make_dept_voisin();' <?PHP if (isset($dept_77)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>78</div><input name='dept_78' type='checkbox' id='dept_78' onclick='make_dept_voisin();' <?PHP if (isset($dept_78)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>91</div><input name='dept_91' type='checkbox' id='dept_91' onclick='make_dept_voisin();' <?PHP if (isset($dept_91)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>92</div><input name='dept_92' type='checkbox' id='dept_92' onclick='make_dept_voisin();' <?PHP if (isset($dept_92)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>93</div><input name='dept_93' type='checkbox' id='dept_93' onclick='make_dept_voisin();' <?PHP if (isset($dept_93)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>94</div><input name='dept_94' type='checkbox' id='dept_94' onclick='make_dept_voisin();' <?PHP if (isset($dept_94)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>95</div><input name='dept_95' type='checkbox' id='dept_95' onclick='make_dept_voisin();' <?PHP if (isset($dept_95)) echo "checked='checked'"; ?> />
					<input type='hidden' id='zone_ard' name='zone_ard' />
					<input type='hidden' id='dept_voisin' name='dept_voisin' />
				</td>
			</tr>
		</table>
	</div>
<?PHP
}
//-------------------------------------------------------------------------------------------------------------------
function print_filter_marseille($zone_ard, $dept_voisin) {

	// Pour pourvoir ré-initialiser les checkbox
	$ard = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	if ($zone_ard == '') $zone_ard = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16";
	$ard_list = explode(',', $zone_ard);
	foreach ($ard_list as $num_ard) $ard[$num_ard] = 1;


	// Département voisin
	if ($dept_voisin != '') {
		$dept_list = explode(',', $dept_voisin);
		foreach ($dept_list as $num_dept) {
			if ($num_dept ==  '4') $dept_04 = 1;
			if ($num_dept == '30') $dept_30 = 1;
			if ($num_dept == '83') $dept_83 = 1;
			if ($num_dept == '84') $dept_84 = 1;
		}
	}

?>
	<h2>Filtrer par Zone</h2>
	<div class="box_dashed">
		<h3>Arrondissements</h3><br />
		<table>
			<tr>
				<td>
					<div class='numpad'>1</div> <input type='checkbox' id='ard_1' name='ard_1' onclick='make_zone_ard();' <?PHP if ($ard[1])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>2</div> <input type='checkbox' id='ard_2' name='ard_2' onclick='make_zone_ard();' <?PHP if ($ard[2])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>3</div> <input type='checkbox' id='ard_3' name='ard_3' onclick='make_zone_ard();' <?PHP if ($ard[3])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>4</div> <input type='checkbox' id='ard_4' name='ard_4' onclick='make_zone_ard();' <?PHP if ($ard[4])  echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>5</div> <input type='checkbox' id='ard_5' name='ard_5' onclick='make_zone_ard();' <?PHP if ($ard[5])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>6</div> <input type='checkbox' id='ard_6' name='ard_6' onclick='make_zone_ard();' <?PHP if ($ard[6])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>7</div> <input type='checkbox' id='ard_7' name='ard_7' onclick='make_zone_ard();' <?PHP if ($ard[7])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>8</div> <input type='checkbox' id='ard_8' name='ard_8' onclick='make_zone_ard();' <?PHP if ($ard[8])  echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>9</div> <input type='checkbox' id='ard_9' name='ard_9' onclick='make_zone_ard();' <?PHP if ($ard[9])   echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>10</div><input type='checkbox' id='ard_10' name='ard_10' onclick='make_zone_ard();' <?PHP if ($ard[10])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>11</div><input type='checkbox' id='ard_11' name='ard_11' onclick='make_zone_ard();' <?PHP if ($ard[11])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>12</div><input type='checkbox' id='ard_12' name='ard_12' onclick='make_zone_ard();' <?PHP if ($ard[12])  echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>13</div><input type='checkbox' id='ard_13' name='ard_13' onclick='make_zone_ard();' <?PHP if ($ard[13])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>14</div><input type='checkbox' id='ard_14' name='ard_14' onclick='make_zone_ard();' <?PHP if ($ard[14])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>15</div><input type='checkbox' id='ard_15' name='ard_15' onclick='make_zone_ard();' <?PHP if ($ard[15])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>16</div><input type='checkbox' id='ard_16' name='ard_16' onclick='make_zone_ard();' <?PHP if ($ard[16])  echo "checked='checked'"; ?> />
				</td>
			</tr>
		</table>
		<div id='link_pad'>
			<a href='#' onclick='select_tout(); return false;' title='S�lectionner tous les arrondissements'>Tous</a>&nbsp;&nbsp;&nbsp;
			<a href='#' onclick='select_rien(); return false;' title='D�-s�lectionner tous les arrondissements'>Aucun</a>
		</div>
	</div>
	<div class="box">
		<h3>Départements Voisins</h3><br />
		<table>
			<tr>
				<td>
					<div class='numpad'>83</div><input name='dept_83' type='checkbox' id='dept_83' onclick='make_dept_voisin();' <?PHP if (isset($dept_83)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>04</div><input name='dept_04' type='checkbox' id='dept_04' onclick='make_dept_voisin();' <?PHP if (isset($dept_04)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>84</div><input name='dept_84' type='checkbox' id='dept_84' onclick='make_dept_voisin();' <?PHP if (isset($dept_84)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>30</div><input name='dept_30' type='checkbox' id='dept_30' onclick='make_dept_voisin();' <?PHP if (isset($dept_30)) echo "checked='checked'"; ?> />
					<input type='hidden' id='zone_ard' name='zone_ard' />
					<input type='hidden' id='dept_voisin' name='dept_voisin' />
				</td>
			</tr>
		</table>
	</div>
<?PHP
}
//-------------------------------------------------------------------------------------------------------------------
function print_filter_lyon($zone_ard, $dept_voisin) {

	// Pour pourvoir ré-initialiser les checkbox
	$ard = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	if ($zone_ard == '') $zone_ard = "1,2,3,4,5,6,7,8,9";
	$ard_list = explode(',', $zone_ard);
	foreach ($ard_list as $num_ard) $ard[$num_ard] = 1;

	// Département voisin
	if ($dept_voisin != '') {
		$dept_list = explode(',', $dept_voisin);
		foreach ($dept_list as $num_dept) {
			if ($num_dept ==  '1') $dept_01 = 1;
			if ($num_dept == '38') $dept_38 = 1;
			if ($num_dept == '42') $dept_42 = 1;
			if ($num_dept == '71') $dept_71 = 1;
		}
	}

?>
	<h2>Filtrer par Zone</h2>
	<div class="box_dashed">
		<h3>Arrondissements</h3><br />
		<table>
			<tr>
				<td>
					<div class='numpad'>1</div><input type='checkbox' id='ard_1' name='ard_1' onclick='make_zone_ard();' <?PHP if ($ard[1])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>2</div><input type='checkbox' id='ard_2' name='ard_2' onclick='make_zone_ard();' <?PHP if ($ard[2])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>3</div><input type='checkbox' id='ard_3' name='ard_3' onclick='make_zone_ard();' <?PHP if ($ard[3])  echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>4</div><input type='checkbox' id='ard_4' name='ard_4' onclick='make_zone_ard();' <?PHP if ($ard[4])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>5</div><input type='checkbox' id='ard_5' name='ard_5' onclick='make_zone_ard();' <?PHP if ($ard[5])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>6</div><input type='checkbox' id='ard_6' name='ard_6' onclick='make_zone_ard();' <?PHP if ($ard[6])  echo "checked='checked'"; ?> />
				</td>
			</tr>
			<tr>
				<td>
					<div class='numpad'>7</div><input type='checkbox' id='ard_7' name='ard_7' onclick='make_zone_ard();' <?PHP if ($ard[7])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>8</div><input type='checkbox' id='ard_8' name='ard_8' onclick='make_zone_ard();' <?PHP if ($ard[8])  echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>9</div><input type='checkbox' id='ard_9' name='ard_9' onclick='make_zone_ard();' <?PHP if ($ard[9])  echo "checked='checked'"; ?> />
				</td>
			</tr>
		</table>
		<div id='link_pad'>
			<a href='#' onclick='select_tout(); return false;' title='Sélectionner tous les arrondissements'>Tous</a>&nbsp;&nbsp;&nbsp;
			<a href='#' onclick='select_rien(); return false;' title='Dé-sélectionner tous les arrondissements'>Aucun</a>
		</div>
	</div>
	<div class="box">
		<h3>Départements Voisins</h3><br />
		<table>
			<tr>
				<td>
					<div class='numpad'>01</div><input name='dept_01' type='checkbox' id='dept_01' onclick='make_dept_voisin();' <?PHP if (isset($dept_01)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>71</div><input name='dept_71' type='checkbox' id='dept_71' onclick='make_dept_voisin();' <?PHP if (isset($dept_71)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>42</div><input name='dept_42' type='checkbox' id='dept_42' onclick='make_dept_voisin();' <?PHP if (isset($dept_42)) echo "checked='checked'"; ?> />
				</td>
				<td>
					<div class='numpad'>38</div><input name='dept_38' type='checkbox' id='dept_38' onclick='make_dept_voisin();' <?PHP if (isset($dept_38)) echo "checked='checked'"; ?> />
					<input type='hidden' id='zone_ard' name='zone_ard' />
					<input type='hidden' id='dept_voisin' name='dept_voisin' />
				</td>
			</tr>
		</table>
	</div>
<?PHP
}
//-------------------------------------------------------------------------------------------------------------------
function print_selection_zone($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	// Ajouter en 2024 car ne sont pas passé
	$zone_ard = '';
	$dept_voisin = '';

	$where_condition = make_where_condition($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
	$query = "SELECT typp,prix,surf FROM ano WHERE " . $where_condition;

	tracking_dtb($connexion, $query, __FILE__, __LINE__);

	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);

	// Là il faut calculer les prix
	$prix_moyen = 0.0;
	$surf_moyen = 0.0;
	$prix_carre = 0.0;
	$nb_appartement = 0;
	$nb_loft = 0;
	$nb_maison = 0;
	$nb_chalet = 0;
	$nba = 0;
	while (list($typp, $prix, $surf) = mysqli_fetch_row($result)) {

		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement++;
		if ($typp == VAL_DTB_LOFT) $nb_loft++;
		if ($typp == VAL_DTB_MAISON) $nb_maison++;
		if ($typp == VAL_DTB_CHALET) $nb_chalet++;

		$prix_moyen += $prix;
		$surf_moyen += $surf;
		$nba++;
	}

	if ($nba == 0) $str_produit = 'Pas de Sélection';
	else if ($nba < 100) {

		$str_produit = "";
		if ($nb_appartement == 1) $str_produit .= "1 Appartement<br/>";
		else if ($nb_appartement  > 1) $str_produit .= "$nb_appartement Appartements<br/>";

		if ($nb_maison      == 1) $str_produit .= "1 Maison<br/>";
		else if ($nb_maison       > 1) $str_produit .= "$nb_maison Maisons<br/>";

		if ($nb_loft > 0) $str_produit .= "$nb_loft Loft<br/>";

		if ($nb_chalet      == 1) $str_produit .= "1 Chalet<br/>";
		else if ($nb_chalet       > 1) $str_produit .= "$nb_chalet Chalets<br/>";
	} else $str_produit = 'Réduire la sélection';

	if ($nba == 0) $str_stat = 'Pas de Résultats';
	else if ($nba < 100) {

		$prix_moyen = $prix_moyen / $nba;
		$surf_moyen = $surf_moyen / $nba;
		$prix_carre = $prix_moyen / $surf_moyen;

		$prix_moyen = (int) $prix_moyen;
		$surf_moyen = (int) $surf_moyen;
		$prix_carre = (int) $prix_carre;

		$str_prix_moyen = 'Prix moyen : ' . $prix_moyen . ' €<br/>';
		$str_surf_moyen = 'Surface Moyenne : ' . $surf_moyen . ' m2<br/>';
		$str_prix_carre = 'Prix au m2 : ' . $prix_carre . ' €/m2';

		$str_stat = $str_prix_moyen . $str_surf_moyen . $str_prix_carre;
	} else $str_stat = 'Trop de Résultats';


?>
	<div class="arrow3"></div>
	<div class='filter_box'>
		<h2>
			Votre sélection
		</h2>
		<div class="box">
			<div><?PHP echo "$str_produit" ?></div>
		</div>
		<div class="box_last">
			<?PHP echo "$str_stat"; ?>
		</div>
	</div>
<?PHP
}
//-------------------------------------------------------------------------------------------------------------------
function make_button_to_maps($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	// Refaire la liste des arguments reçus
	$var  = "zone=$zone";
	$var .= "&amp;zone_pays=$zone_pays";
	$var .= "&amp;zone_dom=$zone_dom";
	$var .= "&amp;zone_region=$zone_region";
	$var .= "&amp;zone_dept=$zone_dept";
	$var .= "&amp;zone_ville=$zone_ville";
	$var .= "&amp;zone_ard=$zone_ard";
	$var .= "&amp;dept_voisin=$dept_voisin";

	$var = $var . "&amp;typp=" . $typp;
	if ($P1 == '1') $var .= "&amp;P1=1";
	if ($P2 == '2') $var .= "&amp;P2=2";
	if ($P3 == '3') $var .= "&amp;P3=3";
	if ($P4 == '4') $var .= "&amp;P4=4";
	if ($P5 == '5') $var .= "&amp;P5=5";
	if ($sur_min  != '0') $var = $var . "&amp;sur_min=" . $sur_min;
	if ($prix_max != '0') $var = $var . "&amp;prix_max=" . $prix_max;

	echo "<a href=\"/cons/recherche-carte.php?{$var}\" title='Voir les résultats des recherches sur une carte' rel='nofollow'><img src='/images/btn-carte-468x20.gif' alt='Voir les résultats des recherches sur une carte'/></a>";
}
//-------------------------------------------------------------------------------------------------------------------
function make_fil_localisation($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	// On doit afficher 'France' => 'region' => 'Département' => 'Ville' 
	if ($zone == 'france') {

		$filter = "&amp;typp=$typp&amp;P1=$P1&amp;P2=$P2&amp;P3=$P3&amp;P4=$P4&amp;P5=$P5&amp;sur_min=$sur_min&amp;prix_max=$prix_max";

		$lien_accueil = "<a href='/' title=\"Retour à l'accueil\">Accueil</a>";
		echo "$lien_accueil\n";

		$lien_france  = " :: <a href=\"/cons/recherche-liste.php?zone=france&amp;zone_pays=France$filter\" title=\"Voir les offres de vente sur : France\" rel='nofollow'>France</a>";
		echo "$lien_france\n";


		if ($zone_region != '') {
			$lien_region  = " &raquo; <a href=\"/cons/recherche-liste.php?zone=france&amp;zone_pays=France&amp;zone_region=$zone_region$filter\" title=\"Voir les offres de vente sur : $zone_region\" rel='nofollow'>$zone_region</a>";
			echo "$lien_region\n";
		} else {
			print_select_region_in_france($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
			return;
		}

		if ($zone_dept   != '') {
			$lien_dept = " &raquo; <a href=\"/cons/recherche-liste.php?zone=france&amp;zone_pays=France&amp;zone_region=$zone_region&amp;zone_dept=$zone_dept$filter\" title=\"Voir les offres de vente sur : $zone_dept\" rel='nofollow'>$zone_dept</a>";
			echo "$lien_dept\n";
		} else {
			print_select_dept_by_zone_region($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
			return;
		}

		if ($zone_ville  != '') {
			$lien_ville   = " &raquo; <a href=\"/cons/recherche-liste.php?zone=france&amp;zone_pays=France&amp;zone_region=$zone_region&amp;zone_dept=$zone_dept&amp;zone_ville=$zone_ville$filter\" title=\"Voir les offres de vente sur : $zone_ville\" rel='nofollow'>$zone_ville</a>";
			echo "$lien_ville\n";
		} else print_select_ville_by_zone_dept($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
	}
}
//-------------------------------------------------------------------------------------------------------------------
function print_select_ville_by_zone_dept($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	$zone_dept_s = addslashes($zone_dept);

	echo "&nbsp;&raquo;&nbsp;<form style='display: inline;' method='get' action=\"", $_SERVER['PHP_SELF'], "\">\n";
	echo "<select name='zone_ville' onchange='this.form.submit();'>\n";
	echo "<option value=''>Choisir</option>\n";
	$query = "SELECT zone_ville FROM ano WHERE etat='ligne' AND zone_dept='$zone_dept_s' GROUP BY zone_ville";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);
	if (mysqli_num_rows($result)) {
		while (list($zone_ville) = mysqli_fetch_row($result)) {
			echo "<option value=\"$zone_ville\">$zone_ville</option>\n";
		}
	}
	echo "</select>\n";
	echo "<input type='hidden' name='zone' value=\"$zone\" />";
	echo "<input type='hidden' name='zone_pays' value=\"$zone_pays\" />";
	echo "<input type='hidden' name='zone_dom' value=\"$zone_dom\" />";
	echo "<input type='hidden' name='zone_region' value=\"$zone_region\" />";
	echo "<input type='hidden' name='zone_dept' value=\"$zone_dept\" />";
	echo "<input type='hidden' name='typp' value=\"$typp\" />";
	echo "<input type='hidden' id='hP1' name='P1' value=\"$P1\" />";
	echo "<input type='hidden' id='hP2' name='P2' value=\"$P2\" />";
	echo "<input type='hidden' id='hP3' name='P3' value=\"$P3\" />";
	echo "<input type='hidden' id='hP4' name='P4' value=\"$P4\" />";
	echo "<input type='hidden' id='hP5' name='P5' value=\"$P5\" />";
	echo "<input type='hidden' name='sur_min' value=\"$sur_min\" />";
	echo "<input type='hidden' name='prix_max' value=\"$prix_max\" />";
	echo "</form>\n";
}
//-------------------------------------------------------------------------------------------------------------------
function print_select_dept_by_zone_region($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	$zone_region_s = addslashes($zone_region);
	echo "&nbsp;&raquo;&nbsp;<form style='display: inline;' method='get' action=\"", $_SERVER['PHP_SELF'], "\">\n";
	echo "<select name='zone_dept' onchange='this.form.submit();'>\n";
	echo "<option value=''>Choisir</option>\n";
	$query = "SELECT zone_dept FROM ano WHERE etat='ligne' AND zone_region='$zone_region_s' GROUP BY zone_dept";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);
	if (mysqli_num_rows($result)) {
		while (list($zone_dept) = mysqli_fetch_row($result)) {
			echo "<option value=\"$zone_dept\">$zone_dept</option>\n";
		}
	}
	echo "</select>\n";
	echo "<input type='hidden' name='zone' value=\"$zone\" />\n";
	echo "<input type='hidden' name='zone_pays' value=\"$zone_pays\" />\n";
	echo "<input type='hidden' name='zone_dom' value=\"$zone_dom\" />\n";
	echo "<input type='hidden' name='zone_region' value=\"$zone_region\" />\n";
	echo "<input type='hidden' name='zone_ville' value=\"$zone_ville\" />\n";
	echo "<input type='hidden' name='typp' value=\"$typp\" />\n";
	echo "<input type='hidden' name='P1' value=\"$P1\" />\n";
	echo "<input type='hidden' name='P2' value=\"$P2\" />\n";
	echo "<input type='hidden' name='P3' value=\"$P3\" />\n";
	echo "<input type='hidden' name='P4' value=\"$P4\" />\n";
	echo "<input type='hidden' name='P5' value=\"$P5\" />\n";
	echo "<input type='hidden' name='sur_min' value=\"$sur_min\" />\n";
	echo "<input type='hidden' name='prix_max' value=\"$prix_max\" />\n";
	echo "</form>\n";
}
//-------------------------------------------------------------------------------------------------------------------
function print_select_region_in_france($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	// Ajouté en 2024
	$zone_ard = '';

	echo "&nbsp;&raquo;&nbsp;<form style='display: inline;' method='get' action=\"", $_SERVER['PHP_SELF'], "\">\n";
	echo "<select name='zone_region' onchange='this.form.submit();'>\n";
	echo "<option value=''>Choisir</option>\n";
	$query = "SELECT zone_region FROM ano WHERE etat='ligne' AND zone_pays='France' GROUP BY zone_region";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);
	if (mysqli_num_rows($result)) {
		while (list($zone_region) = mysqli_fetch_row($result)) {
			echo "<option value=\"$zone_region\">$zone_region</option>\n";
		}
	}
	echo "</select>\n";
	echo "<input type='hidden' name='zone' value=\"$zone\" />";
	echo "<input type='hidden' name='zone_pays' value=\"$zone_pays\" />";
	echo "<input type='hidden' name='zone_dom' value=\"$zone_dom\" />";
	echo "<input type='hidden' name='zone_dept' value=\"$zone_dept\" />";
	echo "<input type='hidden' name='zone_ville' value=\"$zone_ville\" />";
	echo "<input type='hidden' name='zone_ard' value=\"$zone_ard\" />";
	echo "<input type='hidden' name='typp' value=\"$typp\" />";
	echo "<input type='hidden' name='P1' value=\"$P1\" />";
	echo "<input type='hidden' name='P2' value=\"$P2\" />";
	echo "<input type='hidden' name='P3' value=\"$P3\" />";
	echo "<input type='hidden' name='P4' value=\"$P4\" />";
	echo "<input type='hidden' name='P5' value=\"$P5\" />";
	echo "<input type='hidden' name='sur_min' value=\"$sur_min\" />";
	echo "<input type='hidden' name='prix_max' value=\"$prix_max\" />";
	echo "</form>\n";
}
//-------------------------------------------------------------------------------------------------------------------
function print_bouton_alerte_recherche($connexion, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	if ($zone == 'france' && $zone_region == '' && $zone_dept == '' && $zone_ville == '') return;

	$idc = get_idc($connexion, $compte_email, $compte_pass);

	echo "<div id='alerte_recherche'>\n";
	echo "<table>\n";
	// Ligne 1
	if ($idc !== false) echo "<tr><td colspan='2'>Soyez informé dès la parution d'annonces sur les critères qui ont donné ces résultats <em>(*service Email gratuit)</em></td></tr>\n";
	else  echo "<tr><td>Soyez informé dès la parution d'annonces sur les critères qui ont donné ces résultats <em>(*service Email gratuit)</em></td></tr>\n";

	// Ligne 2
	echo "<tr>\n";

	// Si on a autentifier un utilisateur
	if ($idc !== false) {

		// CELLULE DE GAUCHE.
		if (get_alerte_recherche($connexion, $idc, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, __FILE__, __LINE__) === true) {

			// Si il y a déjà une alerte
			echo "<td class='cell_g'>Vous avez déjà positionné<br />une alerte avec ces critères</td>\n";
		} else if (get_max_alerte_recherche($connexion, $idc, __FILE__, __LINE__) === true) {

			$compte_recherche_max_alerte_recherche = COMPTE_RECHERCHE_MAX_ALERTE_RECHERCHE;

			// Si on a déjà atteint le maximum d'alertes
			echo "<td class='cell_g'>Vous avez $compte_recherche_max_alerte_recherche alertes de <br />positionnées et c'est le maximum</td>\n";
		} else {

			// Si tout est OK pour déclencher une alerte
			echo "<td class='cell_g'>\n";
			echo "<span id='alerte_recherche_bouton'><input  class='but_input' type='submit' onclick='send_creer_alerte_recherche();' value='Créer une alerte' /></span>\n";
			echo "<span id='ok_alerte_recherche' style='display: none;'><p>Votre alerte a été<br />positionnée avec succès</p></span>\n";
			echo "</td>\n";
		}

		// CELLULE DE DROITE.
		echo "<td class='cell_d'>\n";
		if ($compte_email != '') echo "<span class='compte_email'>$compte_email</span><br />\n";
		echo "<form action='/compte-recherche/gestion-connexion-recherche.php' method='get' >\n";
		echo "<input type='hidden' name='action' value='demande_connexion' />\n";
		echo "<input type='hidden' name='from' value='liste' />\n";
		echo "<input  class='but_input' type='submit' value='Votre compte' />\n";
		echo "</form>\n";
		echo "</td>\n";
	} else {
		// Une seule cellule avec un lien vers l'accueil du compte recherche
		echo "<td class='cell_d'><a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche' title='Vous devez Créer ou Accéder à votre compte recherche' class='navsearch11'>Créer ou Accéder à votre compte recherche</a></td>\n";
	}

	// Fin ligne 2  
	echo "</tr>\n";
	echo "</table>\n";
	echo "</div>\n";
}
//-------------------------------------------------------------------------------------------------------------------
// Fonction pour le référencement
//-------------------------------------------------------------------------------------------------------------------
// Fabrique le titre
function make_title($ref_type, $keywords, $ville_url, $ard_url) {

	// Si l'appel du script vient d'un lien de référencement
	if ($ref_type != '') {

		if ($ref_type == 'paris')
			echo "$keywords $ard_url";

		if ($ref_type == 'town')
			echo "Immobilier entre particuliers à $ville_url. Vente Appartement Maison Loft à $ville_url";

		if ($ref_type == 'product')
			echo "$keywords à $ville_url à vendre entre Particuliers sur TOP-IMMOBILIER-PARTICULIER.FR";
	} else echo "Immobilier entre Particuliers - Annonces Immobilières entre Particuliers";
}
//--------------------------------------------------------------------------------
// Fabrique le contenu de la balise H1
function make_H1($ref_type, $keywords, $ville_url, $ard_url) {

	// Si l'appel du script vient d'un lien de r�f�rencement
	if ($ref_type != '') {

		if ($ref_type == 'paris')
			echo "<strong>Résultats des recherches de $keywords $ard_url</strong>";

		if ($ref_type == 'town')
			echo "Immobilier entre particuliers à $ville_url.";

		if ($ref_type == 'product')
			echo "$keywords à $ville_url entre Particuliers.";
	} else echo "Résultats des recherches sous forme de listes";
}
//--------------------------------------------------------------------------------
// Fabrique la meta description
function make_meta_description($ref_type, $keywords, $ville_url, $ard_url) {

	// Si l'appel du script vient d'un lien de référencement
	if ($ref_type != '') {

		if ($ref_type == 'paris')
			echo "<meta name=\"Description\" content=\"$keywords $ard_url : Immobilier entre Particuliers sur TOP-IMMOBILIER-PARTICULIER.FR\" />\n";

		if ($ref_type == 'town')
			echo "<meta name=\"Description\" content=\"Immobilier entre particuliers à $ville_url. Annonces immobilières entre particuliers à $ville_url. Vente Appartement Maison Loft à $ville_url\" />\n";

		if ($ref_type == 'product')
			echo "<meta name=\"Description\" content=\"$keywords à $ville_url à vendre uniquement entre Particuliers. Sur TOP-IMMOBILIER-PARTICULIER.FR ne payer strictement que le prix !!\" />\n";
	} else echo "<meta name=\"Description\" content=\"Résulats de recherche de produit immobilier\" />\n";
}
//--------------------------------------------------------------------------------
// Fabrique la meta robot
function make_meta_robot($ref_type, $ids) {

	// Si l'appel du script vient d'un lien de référencement et qu'on est sur la première page
	if ($ref_type != '' && $ids == '1') {
		echo "<meta name=\"robots\" content=\"index,follow\" />\n";
	} else echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";
}
?>