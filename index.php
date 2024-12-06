<?PHP
include("data/data.php");
include("include/inc_base.php");
include("include/inc_conf.php");
include("include/inc_format.php");
include("include/inc_diaporama.php");
include("include/inc_random.php");
include("include/inc_vep.php");
include("include/inc_dtb_compte_annonce.php");
include("include/inc_tools.php");
include("include/inc_adsense.php");
include("include/inc_count_cnx.php");
include("include/inc_tracking.php");

$connexion = dtb_connection();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Immobilier entre Particuliers - Annonces Immobilières entre Particulier</title>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/styles-index.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='/jvscript/popup.js'></script>
	<script type="text/javascript" src='/jvscript/search.js'></script>
	<script type="text/javascript" src='/jvscript/geo.js'></script>
	<!-- <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script> -->
	<script type="text/javascript">
		//<![CDATA[
		var map = null;
		var mgr = null;

		function load_map() {
			return; // ICI
			if (GBrowserIsCompatible()) {
				map = new GMap2(document.getElementById("map"));
				//map.setCenter(new GLatLng(46.255847,2.197266), 5);
				map.setCenter(new GLatLng(47.5, 2.197266), 5);
				map.addControl(new GSmallMapControl());
				mgr = new GMarkerManager(map);

				var townList = new Array();

				<?PHP print_town_list($connexion); ?>

				function createMarker(point, town) {

					var icon_big_town = new GIcon();
					icon_big_town.image = "/images/map_big_town.gif";
					icon_big_town.iconSize = new GSize(15, 18);
					icon_big_town.iconAnchor = new GPoint(7, 18);
					icon_big_town.infoWindowAnchor = new GPoint(20, 0);

					var icon_small_town = new GIcon();
					icon_small_town.image = "/images/map_small_town.gif";
					icon_small_town.iconSize = new GSize(15, 18);
					icon_small_town.iconAnchor = new GPoint(7, 18);
					icon_small_town.infoWindowAnchor = new GPoint(20, 0);

					if (town.town_class == 'big') var marker_options = icon_big_town;
					if (town.town_class == 'small') var marker_options = icon_small_town;

					var marker = new GMarker(point, marker_options);
					//marker.value = number => Remove from Google example ;
					GEvent.addListener(marker, "click", function() {
						var myHtml = "<div class='infoMarker'>" + show_data(town) + "</div>";
						map.openInfoWindowHtml(point, myHtml);
					});
					return marker;
				}

				for (var i = 0; i < townList.length; i++) {
					var point = new GLatLng(townList[i].lat, townList[i].lng);
					/*map.addOverlay(createMarker(point,townList[i]));*/
					if (townList[i].town_class == 'big') mgr.addMarker(createMarker(point, townList[i]), 1)
					if (townList[i].town_class == 'small') mgr.addMarker(createMarker(point, townList[i]), 6)

				}

			} // Fin if GBrowser
		} // Fin load_map

		// Object for town data
		function townData(town_class, region, dept, ville, lat, lng, nb_appartement, nb_maison, nb_loft, nb_chalet) {
			this.town_class = town_class;
			this.region = region;
			this.dept = dept;
			this.ville = ville;
			this.lat = lat;
			this.lng = lng;
			this.nb_appartement = nb_appartement;
			this.nb_maison = nb_maison;
			this.nb_loft = nb_loft;
			this.nb_chalet = nb_chalet;
		}

		function show_data(town) {
			var arg = "zone=france" + "&zone_region=" + escape(town.region) + "&zone_dept=" + escape(town.dept) + "&zone_ville=" + escape(town.ville);
			var info = "<div id='saginfo'>top-immobilier-particuliers.fr</div>";
			if (town.nb_appartement) info += town.nb_appartement + ((town.nb_appartement == 1) ? " Appartement<br/>" : " Appartements<br/>");
			if (town.nb_maison) info += town.nb_maison + ((town.nb_maison == 1) ? " Maison<br/>" : " Maisons<br/>");
			if (town.nb_chalet) info += town.nb_nb_chalet + ((town.nb_chalet == 1) ? " Chalet<br/>" : " Chalets<br/>");
			if (town.nb_loft) info += town.nb_loft + " Loft<br/>";

			info = info + "<img src='/images/arrow5.gif' /><a class='navsearch11' href='/cons/recherche-carte.php?" + arg + "'>Aller sur " + town.ville + "</a>";
			return info;
		}
		//]]>
	</script>
</head>


<body onload="load_map();" onunload="GUnload(); clear_window();">
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>


		<div id='userpan'>
			<div id='header'><img src="/images-pub/juste-le-prix-468x60.gif" title="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est de l'immobilier strictement entre particuliers" /></div>
			<table id='compte'>
				<tr>
					<td class='cell_b'>
						<div id='acheteurs'><a href='/compte-recherche/compte-recherche-ccm.php' title="Accéder à plus d'informations concernant les services à disposition des acheteurs" rel='nofollow'>+ d'infos</a></div>
						<div><img src="/images-header/particulier-acheteur-21.gif" alt="Servives d'aide à la Recherche - Compte de recherche" /></div>
						<p><a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche' title='Accéder à votre compte de recherche'>Votre
								Compte</a>&nbsp;<em> (* Gratuit)</em></p>
					</td>
					<td class='cell_c'>
						<?PHP //print_virtual_cnx(count_cnx()); 
						?><br />
						<img src="images/top-immobilier-particuliers-240x60.jpg" title='Achetez et Vendez facilement avec TOP-IMMOBILIER-PARTICULIERS.FR' alt='Achetez et Vendez facilement avec TOP-IMMOBILIER-PARTICULIERS.FR' width="240" height="60" /><br />
					</td>
					<td class='cell_b'>
						<div id='vendeurs'><a href='/compte-annonce/compte-annonce-ccm.php' title="Accéder à plus d'informations concernant les services à disposition des vendeurs" rel='nofollow'>+ d'infos</a></div>
						<div><img src="/images-header/particulier-vendeur-21.gif" alt='Passer une annonces 6 mois pour 20 Euros' /></div>
						<p><a href='/compte-annonce/passer-annonce.php' title='Passer une annonce'>Passer une annonce</a>&nbsp;&nbsp;&nbsp;<a href='/compte-annonce/gestion-connexion-annonce.php?action=accueil_compte_annonce' title='Accéder à votre compte annonce'>Votre Compte</a></p>
					</td>
				</tr>
			</table>
			<?PHP
			$ida_array = select_annnonce($connexion, $first = 0, $last = 3);
			if (count($ida_array)) print_selection_annonce($ida_array);
			?>
			<table id='recherche'>
				<tr>
					<td class='cell_g'>
						<?PHP
						print_search_form($connexion);
						//print_vep_logo();
						//tracking(CODE_NAV, 'OK', "index", __FILE__, __LINE__);
						?>

					</td>
					<td class='cell_c'>
						<h1>Immobilier entre Particuliers. Annonces Immobilières entre Particuliers à Paris, en Ile de France, en France et à l'étranger. Appartement, Maison, Pavillon, Loft à la Vente</h1>
						<div id="message">Recherche sur les cartes. Double click sur la zone pour voir d'autres villes</div>
						<div id="map"></div>
					</td>
					<td class='cell_d'>
						<?PHP
						print_town_search();
						print_byphone_search();

						?>
					</td>
				</tr>
			</table>
			<br />
			?>
		</div> <!-- end userpan -->

	</div> <!-- end mainpan -->
	<div id='footerpan'>
		<?PHP print_rules(); //print_link(); 
		?>
	</div><!-- end footerpan -->
</body>

</html>
<?PHP
//--------------------------------------------------------------------------------------------------
function print_main_offre($connexion) {
?>
	<div class="search">
		<h2>
			<?PHP
			$nb_vente = get_nb_ano($connexion);
			echo "$nb_vente Offres de Vente\n";
			?>
		</h2>
	</div>
	<div class="arrow3"></div>
<?PHP
}
//--------------------------------------------------------------------------------------------------
function print_search_form($connexion) {
	$sur_min = 0;
	$prix_max = 0;
?>
	<form method="get" action="/cons/recherche-liste.php" onsubmit="return validation(this);">
		<div id='search'>
			<h2>Zones Géographiques</h2>
			<div class="box_dashed">
				<?PHP print_select_dept($connexion); ?>
			</div>
			<div class="box_dashed">
				<?PHP print_select_dom($connexion); ?>
			</div>
			<div class="box">
				<?PHP print_select_pays($connexion); ?>
			</div>
			<h2>Crit&egrave;res Optionnels</h2>
			<div class="box_dashed">
				Nombre de Pièces<br />
				<input name="P1" title="Cocher pour sélectionner les logements d'une pièce" type="checkbox" value="1" />
				1P&nbsp; <input title="Cocher pour sélectionner les logements de deux pièces" name="P2" type="checkbox" value="2" />
				2P&nbsp; <input title="Cocher pour sélectionner les logements de trois pièces" name="P3" type="checkbox" value="3" /> &nbsp;3P<br /> <input title="Cocher pour sélectionner les logements de quatre pièces" name="P4" type="checkbox" value="4" />
				4P&nbsp; <input title="Cocher pour sélectionner les logements de cinq pièces ou plus" name="P5" type="checkbox" value="5" /> &nbsp;5P ou +
			</div>
			<div class="box_dashed">Type&nbsp;
				<select title='Choisir le type de logement recherché' name="typp">
					<option value="0" selected='selected'>Tous Produits&nbsp;&nbsp;</option>
					<option value="1">Appartement</option>
					<option value="8">Maison</option>
					<option value="3">Loft</option>
					<option value="6">Chalet</option>
				</select>
			</div>
			<div class="box_dashed">
				<input type="hidden" id="zone" name="zone" value="france" />
				Surface min<br />
				<select title='Choisir votre surface minimum' id="sur_min" name="sur_min">
					<option value="0">Surface&nbsp;&nbsp;</option>
					<option value="10" <?PHP if ($sur_min ==  10) echo "selected='selected'"; ?>>10</option>
					<option value="20" <?PHP if ($sur_min ==  20) echo "selected='selected'"; ?>>20</option>
					<option value="30" <?PHP if ($sur_min ==  30) echo "selected='selected'"; ?>>30</option>
					<option value="40" <?PHP if ($sur_min ==  40) echo "selected='selected'"; ?>>40</option>
					<option value="50" <?PHP if ($sur_min ==  50) echo "selected='selected'"; ?>>50</option>
					<option value="60" <?PHP if ($sur_min ==  60) echo "selected='selected'"; ?>>60</option>
					<option value="70" <?PHP if ($sur_min ==  70) echo "selected='selected'"; ?>>70</option>
					<option value="80" <?PHP if ($sur_min ==  80) echo "selected='selected'"; ?>>80</option>
					<option value="90" <?PHP if ($sur_min ==  90) echo "selected='selected'"; ?>>90</option>
					<option value="100" <?PHP if ($sur_min == 100) echo "selected='selected'"; ?>>100</option>
				</select>
			</div>
			<div class="box">
				Prix Max<br />
				<select title='Choisir votre prix maximum' id="prix_max" name="prix_max">
					<option value="0">Prix Max&nbsp;&nbsp;</option>
					<option value="100000" <?PHP if ($prix_max ==  100000) echo "selected='selected'"; ?>>100000</option>
					<option value="200000" <?PHP if ($prix_max ==  200000) echo "selected='selected'"; ?>>200000</option>
					<option value="300000" <?PHP if ($prix_max ==  300000) echo "selected='selected'"; ?>>300000</option>
					<option value="400000" <?PHP if ($prix_max ==  400000) echo "selected='selected'"; ?>>400000</option>
					<option value="500000" <?PHP if ($prix_max ==  500000) echo "selected='selected'"; ?>>500000</option>
					<option value="600000" <?PHP if ($prix_max ==  600000) echo "selected='selected'"; ?>>600000</option>
					<option value="700000" <?PHP if ($prix_max ==  700000) echo "selected='selected'"; ?>>700000</option>
					<option value="800000" <?PHP if ($prix_max ==  800000) echo "selected='selected'"; ?>>800000</option>
					<option value="900000" <?PHP if ($prix_max ==  900000) echo "selected='selected'"; ?>>900000</option>
					<option value="1000000" <?PHP if ($prix_max == 1000000) echo "selected='selected'"; ?>>1000000</option>
				</select>
			</div>
			<div class="box_last"><input title='Cliquer pour lancer la recherche sur la zone choisie' class="but_input" type="submit" name="Submit" value="Go" /></div>
		</div>
	</form>

<?PHP
}
//--------------------------------------------------------------------------------------------------------
function print_select_dom($connexion) {

	echo "Recherche Dom Tom<br/> \n";
	echo "<select title=\"Choisir le département ou le territoire d'outre mer\" id='zone_dom' name='zone_dom' onchange='on_zone_dom();'>\n";
	echo "<option value=''>Choisir</option>\n";
	$query = "SELECT zone_dom FROM ano WHERE etat='ligne' AND zone='domtom' GROUP BY zone_dom";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_INDEX);
	if (mysqli_num_rows($result)) {
		while (list($zone_dom) = mysqli_fetch_row($result)) {
			echo "<option value='$zone_dom'>$zone_dom</option>\n";
		}
	}
	echo "</select>\n";
}


//--------------------------------------------------------------------------------------------------------
function print_select_dept($connexion) {

	echo "Recherche France<br/> \n";
	echo "<select title=\"Choisir le numéro du département de france métropole\" id='zone_dept' name='zone_dept' onchange='on_zone_dept();'>\n";
	echo "<option value=''>Choisir&nbsp;&nbsp;</option>\n";
	// $query = "SELECT num_dept,zone_dept FROM ano WHERE etat='ligne' AND zone='france' GROUP BY num_dept";
	$query = "SELECT num_dept,zone_dept FROM ano WHERE etat='ligne' AND zone='france'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);
	if (mysqli_num_rows($result)) {
		while (list($num_dept, $zone_dept) = mysqli_fetch_row($result)) {
			echo "<option value=\"$zone_dept\">$num_dept</option>\n";
		}
	}
	echo "</select>\n";
}
//--------------------------------------------------------------------------------------------------------
function print_select_pays($connexion) {

	echo "Recherche Pays<br/> \n";
	echo "<select title=\"Choisir un pays\" id='zone_pays' name='zone_pays' onchange='on_zone_pays();'>\n";
	echo "<option value=''>Choisir</option>\n";
	$query = "SELECT zone_pays FROM ano WHERE etat='ligne' AND zone='etranger' GROUP BY zone_pays";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_INDEX);
	if (mysqli_num_rows($result)) {
		while (list($zone_pays) = mysqli_fetch_row($result)) {
			echo "<option value='$zone_pays'>$zone_pays</option>\n";
		}
	}
	echo "</select>\n";
}
//--------------------------------------------------------------------------------------------------------
function print_town_list($connexion) {

	// region / département / ville / lat / lng / nb_appartement / nb_maison / nb_Loft / nb_chalet


	$ref_ville      = array();
	$ref_dept       = array();

	// Sélection des villes référencées
	$query = "SELECT ville,dept FROM ref_ville";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);
	while (list($ville, $dept) = mysqli_fetch_row($result)) {
		array_push($ref_ville, $ville);
		array_push($ref_dept, $dept);
	}

	// Touver les informations sur les villes référencées
	$list_loc_dept      = array();
	$list_loc_region    = array();
	$list_loc_ville_lat = array();
	$list_loc_ville_lng = array();

	for ($i = 0; $i < COUNT($ref_ville); $i++) {
		$the_ref_ville = addslashes($ref_ville[$i]);
		$the_ref_dept  = $ref_dept[$i];
		$query = "SELECT v.ville_lat,v.ville_lng,d.dept,r.region FROM loc_ville as v, loc_departement as d, loc_region as r WHERE v.ville='$the_ref_ville' AND v.idd=d.idd AND d.dept_num='$the_ref_dept' AND v.idr=r.idr";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);
		list($loc_ville_lat, $loc_ville_lng, $loc_dept, $loc_region) = mysqli_fetch_row($result);
		array_push($list_loc_dept, $loc_dept);
		array_push($list_loc_region, $loc_region);
		array_push($list_loc_ville_lat, $loc_ville_lat);
		array_push($list_loc_ville_lng, $loc_ville_lng);
	}


	$list_nb_appartement = array();
	$list_nb_maison      = array();
	$list_nb_loft        = array();
	$list_nb_chalet      = array();

	for ($i = 0; $i < COUNT($ref_ville); $i++) {
		$the_ref_ville = $ref_ville[$i];
		$the_ref_dept  = $ref_dept[$i];
		get_nb_ano_by_typp_ville_dept($connexion, $the_ref_ville, $the_ref_dept, $nb_appartement, $nb_maison, $nb_loft, $nb_chalet);
		array_push($list_nb_appartement, $nb_appartement);
		array_push($list_nb_maison, $nb_maison);
		array_push($list_nb_loft, $nb_loft);
		array_push($list_nb_chalet, $nb_chalet);
	}


	$j = 0;
	for ($i = 0; $i < COUNT($ref_ville); $i++) {

		if ($list_nb_appartement[$i] != 0  || $list_nb_maison[$i] != 0 || $list_nb_loft[$i] != 0 || $list_nb_chalet[$i] != 0) {

			if ($i < 15) printf("townList[%d] = new townData(\"%s\",\"%s\",\"%s\",\"%s\",%f,%f,%d,%d,%d,%d);\n", $j, 'big', $list_loc_region[$i], $list_loc_dept[$i], $ref_ville[$i], $list_loc_ville_lat[$i], $list_loc_ville_lng[$i], $list_nb_appartement[$i], $list_nb_maison[$i], $list_nb_loft[$i], $list_nb_chalet[$i]);
			else printf("townList[%d] = new townData(\"%s\",\"%s\",\"%s\",\"%s\",%f,%f,%d,%d,%d,%d);\n", $j, 'small', $list_loc_region[$i], $list_loc_dept[$i], $ref_ville[$i], $list_loc_ville_lat[$i], $list_loc_ville_lng[$i], $list_nb_appartement[$i], $list_nb_maison[$i], $list_nb_loft[$i], $list_nb_chalet[$i]);
			$j++;
		}
	}
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce sur la ville. ( Uniquement celles qui sont géolocalisées )
function get_nb_ano_by_typp_ville_dept($connexion, $zone_ville, $num_dept, &$nb_appartement, &$nb_maison, &$nb_loft, &$nb_chalet) {

	$nb_appartement = 0;
	$nb_maison      = 0;
	$nb_loft        = 0;
	$nb_chalet      = 0;

	$zone_ville = addslashes($zone_ville);

	$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND maps_actif=1 AND zone_ville='$zone_ville' AND num_dept='$num_dept' GROUP BY typp";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, 0);
	while (list($typp, $nb) = mysqli_fetch_row($result)) {
		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement = $nb;
		else if ($typp == VAL_DTB_MAISON) $nb_maison      = $nb;
		else if ($typp == VAL_DTB_LOFT) $nb_loft        = $nb;
		else if ($typp == VAL_DTB_CHALET) $nb_chalet      = $nb;
	}
}
//--------------------------------------------------------------------------------------------------------
function print_town_search() {
?>
	<div id="town">
		<h2>Recherche par Villes</h2>
		<a href='/immobilier-entre-particuliers-paris.htm' title="Recherche par arrondissements et départements voisins sur Paris">Paris</a>
		<a href='/immobilier-entre-particuliers-marseille.htm' title='Recherche par arrondissements et départements voisins sur Marseille'>Marseille</a>
		<a href='/immobilier-entre-particuliers-lyon.htm' title='Recherche par arrondissements et départements voisins sur Lyon'>Lyon</a>
		<a href='/immobilier-entre-particuliers-toulouse.htm' title='Accéder directement à la recherche sur Toulouse'>Toulouse</a>
		<a href='/immobilier-entre-particuliers-nice.htm' title='Accéder directement à la recherche sur Nice'>Nice</a>
		<a href='/immobilier-entre-particuliers-nantes.htm' title='Accéder directement à la recherche sur Nantes'>Nantes</a>
		<a href='/immobilier-entre-particuliers-strasbourg.htm' title='Accéder directement à la recherche sur Strasbourg'>Strasbourg</a>
		<a href='/immobilier-entre-particuliers-montpellier.htm' title='Accéder directement à la recherche sur Montpellier'>Montpellier</a>
		<a href='/immobilier-entre-particuliers-bordeaux.htm' title='Accéder directement à la recherche sur Bordeaux'>Bordeaux</a>
		<a href='/immobilier-entre-particuliers-toulon.htm' title='Accéder directement à la recherche sur Toulon'>Toulon</a>
		<a href='/immobilier-entre-particuliers-cannes.htm' title='Accéder directement à la recherche sur Cannes'>Cannes</a>
		<a href='/immobilier-entre-particuliers-lille.htm' title='Accéder directement à la recherche sur Lille'>Lille</a>
	</div>
<?PHP
}
//--------------------------------------------------------------------------------------------------------
function print_byphone_search() {
?>
	<form method="get" action="/cons/details.php" onsubmit="return valid_byphone(this);">
		<div id="byphone">
			<h2>Recherche par<br />T&eacute;l&eacute;phone</h2>
			<div class="box_last">
				<input title="Rentrer le numéro de téléphone de l'annonce" name="tel_ins" type="text" size="11" maxlength="10" />
				<input title="Cliquer pour lancer la recherche sur le numéro de téléphone" class="but_input" type="submit" name="Submit" value="Go" />
			</div>
		</div>
	</form>
<?PHP
}
//--------------------------------------------------------------------------------------------------------
function print_news($connexion) {

	$query  = "SELECT news_titre,news_description,news_url FROM news ORDER BY dat_creation DESC LIMIT 3";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_INDEX);

	while (list($news_titre, $news_description, $news_url) = mysqli_fetch_row($result)) {
		echo "<div class='news_item'>\n";
		echo "<p>&#8226;&nbsp;<a href='/actualites-immobilieres/{$news_url}.htm'>$news_titre</a></p>\n";
		echo "<p>$news_description</p>\n";
		echo "</div>\n";
	}
}
//--------------------------------------------------------------------------------------------------------
function print_rules() {
?>
	<ul id='rules'>
		<li><a href='/revue-sites.htm'>Revue de Sites</a>&nbsp;|&nbsp;</li>
		<li><a href='/noref/mention.php' title='Mentions légales de ce site' rel='nofollow'>Mentions&nbsp;L&eacute;gales</a>&nbsp;|&nbsp;</li>
		<li><a href='/noref/condition.php' title="Conditions d'utilisation de ce site" rel='nofollow'>Conditions d'utilisation</a></li>
	</ul>
<?PHP
}
//--------------------------------------------------------------------------------------------------------
function print_link() {
?>
	<ul id='partners'>
		<li><a href='http://www.provitrine.fr/' title='petites annonces gratuites'>Annonces Gratuites</a>&nbsp;|&nbsp;</li>
		<li><a href='http://www.aarcroisiere.com/' title='Croisières maritime et fluviale'>AAR Croisiere</a>&nbsp;|&nbsp;</li>
		<li><a href='http://www.destockplus.com/'>Destock Plus : Annonces Grossistes</a>&nbsp;|&nbsp;</li>
		<li><a href='http://www.seti-expert.fr/'>Seti-Expert.fr</a>&nbsp;|&nbsp;</li>
		<li><a href='http://www.gites-nature.com/'>Gites Nature</a>&nbsp;|&nbsp;</li>
		<li><a href='http://www.desirimmo.com/' title='Annonces immobilières gratuites'>Annonces immobilieres gratuites</a>&nbsp;|&nbsp;</li>
		<li><a href='http://www.securite-online.fr/' target='_blank' title='alarme et accessoire sur Securite-online.fr'>Securité Online</a></li>
	</ul>

<?PHP
}
?>