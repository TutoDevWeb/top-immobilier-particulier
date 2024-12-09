<?PHP
session_start();
if (!isset($_SESSION['idc'])) die;
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_dtb_compte_recherche.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_tracking.php");
include("../include/inc_tools.php");


$connexion = dtb_connection();
count_cnx($connexion);

$compte_email = get_email_compte_recherche($connexion, $_SESSION['idc']);

isset($_SESSION['from'])       ? $from       = $_SESSION['from']       : $from       = '';
isset($_SESSION['my_referer']) ? $my_referer = $_SESSION['my_referer'] : $my_referer = '';

if ($from != '' && $my_referer != '')
	tracking($connexion, CODE_CTR, 'OK', "Entrée dans Interface Utilisateur:$compte_email<br/>$from => $my_referer", __FILE__, __LINE__);
else
	tracking($connexion, CODE_CTR, 'OK', "Entrée dans Interface Utilisateur:$compte_email", __FILE__, __LINE__);

isset($_REQUEST['action'])  ? $action = trim($_REQUEST['action']) : '';

if ($action == 'supprimer_alerte_baisse') {
	isset($_REQUEST['idab'])  ? $idab = trim($_REQUEST['idab']) : die;
	supprimer_alerte_baisse($connexion, $idab, __FILE__, __LINE__);
	tracking($connexion, CODE_CTR, 'OK', "Interface Utilisateur:$compte_email:$compte_pass:suppression alerte baisse $idab", __FILE__, __LINE__);
}

if ($action == 'supprimer_alerte_recherche') {
	isset($_REQUEST['idar'])  ? $idar = trim($_REQUEST['idar']) : die;
	supprimer_alerte_recherche($connexion, $idar, __FILE__, __LINE__);
	tracking($connexion, CODE_CTR, 'OK', "Interface Utilisateur:$compte_email:$compte_pass:suppression alerte recherche $idar", __FILE__, __LINE__);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Votre compte recherche :: tableau de bord</title>
	<meta charset="UTF-8">
	<script type='text/javascript' src='/jvscript/popup.js'></script>
	<script src="/jquery-lib/jquery-1.2.3.pack.js" type="text/javascript"></script>
	<script src="/jquery-lib/jquery.history_remote.pack.js" type="text/javascript"></script>
	<script src="/jquery-lib/jquery.tabs.pack.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {

			<?PHP
			if ($action == 'supprimer_alerte_recherche') echo "\$('#interface').tabs(2);";
			if ($action == 'supprimer_alerte_baisse') echo "\$('#interface').tabs(3);";
			?>

			$('#interface').tabs({
				fxAutoHeight: true
			});
		});
	</script>
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/styles-compte-recherche.css" rel="stylesheet" type="text/css" />
	<link href="/jquery-lib/jquery.tabs.css" rel="stylesheet" type="text/css" media="print, projection, screen" />
	<!-- Additional IE/Win specific style sheet (Conditional Comments) -->
	<!--[if lte IE 7]>
<link rel="stylesheet" href="/jquery-lib/jquery.tabs-ie.css" type="text/css" media="projection, screen" />
<![endif]-->
	<meta name="robots" content="noindex,nofollow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_compte_recherche('Tableau de bord : ' . $compte_email); ?>
			<?PHP make_backlink($from, $my_referer); ?>
			<div id='interface'>
				<ul>
					<li><a href='#fragment-1'><span>Votre tableau de bord</span></a></li>
					<li><a href='#fragment-2'><span>Alertes de Recherche</span></a></li>
					<li><a href='#fragment-3'><span>Alertes à la baisse</span></a></li>
					<li><a href='#fragment-4'><span>Capacité de Financement</span></a></li>
				</ul>
				<div id='fragment-1'><?PHP print_bienvenue($compte_email, $_SESSION['idc']); ?></div>
				<div id='fragment-2'><?PHP print_alertes_recherche($connexion, $_SESSION['idc']); ?></div>
				<div id='fragment-3'><?PHP print_alertes_baisse($connexion, $_SESSION['idc']); ?></div>
				<div id='fragment-4'><?PHP print_financement($connexion, $_SESSION['idc']); ?></div>
			</div>
			<?PHP print_xiti_code('compte-recherche'); ?>
			<div id='clearboth'>&nbsp;</div>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP
/*-----------------------------------------------------------------------------------*/
function print_bienvenue($compte_email, $idc) {
?>
	<h2>Bienvenue dans le tableau de bord de votre compte recherche</h2>
	<p>Dans votre tableau de bord vous retrouvez :</p>
	<ul id='tdb_retrouver'>
		<li>les alertes recherches que vous avez déjà mémorisées</li>
		<li>les alertes à la baisse que vous avez positionnées</li>
		<li>les critères de financement que vous avez mémorisés</li>
	</ul>
	<p>Ces services sont là pour vous aider dans votre recherche</p>
	<ul id='tdb_aider'>
		<li>Avec les alertes recherches vous recevrez dès leur mise en ligne les nouvelles annonces qui correspondent aux critères que vous avez mémorisés</li>
		<li>Avec les alertes à la baisse vous serez prévenu au moment d'une baisse de prix d'un produit que vous avez sélectionné.</li>
		<li>La mémorisation de votre capacité de financement vous permet lors de la navigation sur le site d'avoir en temps réel le montant de la mensualité de votre crédit.</li>
	</ul>
	<p>Pour accéder à la gestion de ces services cliquer sur les onglets en haut de page</p>
	<ul id='tdb_acceder'>
		<li>Alertes recherches</li>
		<li>Alertes à la baisse</li>
		<li>Capacité de financement</li>
	</ul>
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_financement($connexion, $idc) {


	$query  = "SELECT finance_actif,finance_fixe,finance_credit_montant,finance_apport_montant,finance_taux_annuel,finance_nb_annee FROM compte_recherche WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);
	list($finance_actif, $finance_fixe, $finance_credit_montant, $finance_apport_montant, $finance_taux_annuel, $finance_nb_annee) = mysqli_fetch_row($result);

	if ($finance_actif) {

		if ($finance_fixe == 'apport_radio') print_financement_apport_fixe($finance_apport_montant, $finance_taux_annuel, $finance_nb_annee);
		if ($finance_fixe == 'credit_radio') print_financement_credit_fixe($finance_credit_montant, $finance_taux_annuel, $finance_nb_annee);
		print_cible_unifinance_300_250();
	} else {
		echo "<h2>Vous n'avez pas mémorisé votre capacité de financement</h2>";
		echo "<p>Pour mémoriser votre capacité de financement : </p>";
		echo "<ol>\n";
		echo "<li>Aller sur n'importe quelle fiche détaillée d'un produit</li>\n";
		echo "<li>Se déplacer vers la calculette financière <em>(* en bas et à droite de la fiche détaillée, image ci-dessous)</em></li>\n";
		echo "<li>Choisir les paramètres de votre financement : Apport / Taux / Durée</li>\n";
		echo "<li>Cliquer sur le bouton 'Mémoriser ces valeurs'</li>\n";
		echo "</ol>\n";
		echo "<p><img src='/images/aide-capacite-financement.gif' alt='Aide pour mémoriser votre capacité de financement' /></p>";
	}
}
/*-----------------------------------------------------------------------------------*/
function print_financement_apport_fixe($finance_apport_montant, $finance_taux_annuel, $finance_nb_annee) {
?>
	<h2>Valeurs enregistrées de votre capacité de financement</h2>
	<table id='tab_finance'>
		<tr>
			<td>Vous avez decidé de fixer le montant de votre apport personnel à <?PHP echo "$finance_apport_montant"; ?> Euros</td>
		</tr>
		<tr>
			<td>Sur chaque produit le système calculera le montant restant à emprunter.</td>
		</tr>
		<tr>
			<td>Ce calcul se fera sur la base d'un taux fixe annuel de <?PHP echo "$finance_taux_annuel"; ?> %</td>
		</tr>
		<tr>
			<td>Sur une durée de <?PHP echo "$finance_nb_annee"; ?> Ans</td>
		</tr>
	</table>
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_financement_credit_fixe($finance_credit_montant, $finance_taux_annuel, $finance_nb_annee) {
?>
	<h2>Valeurs enregistrées de votre capacité de financement</h2>
	<table id='tab_finance'>
		<tr>
			<td>Vous avez decidé de fixer le montant de votre credit à <?PHP echo "$finance_credit_montant"; ?> Euros</td>
		</tr>
		<tr>
			<td>Sur chaque produit le système calculera l'apport personnel restant à financer.</td>
		</tr>
		<tr>
			<td>Le calcul de votre credit se fera sur la base d'un taux fixe annuel de <?PHP echo "$finance_taux_annuel"; ?> %</td>
		</tr>
		<tr>
			<td>Sur une durée de <?PHP echo "$finance_nb_annee"; ?> Ans</td>
		</tr>
	</table>
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_alertes_recherche($connexion, $idc) {

	$query = "SELECT idar,zone,zone_pays,zone_dom,zone_region,zone_dept,zone_ville,zone_ard,dept_voisin,typp,P1,P2,P3,P4,P5,sur_min,prix_max FROM compte_recherche_alertes_recherche WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

	if (mysqli_num_rows($result)) {

		echo "<h2>Liste de vos alertes recherche</h2>\n";
		while (list($idar, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) = mysqli_fetch_row($result)) {

			echo "<table id='tab_alerte_recherche'><tr>\n";
			echo "<td class='td_left'>\n";
			print_lien_recherche($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max);
			echo "</td>\n";
			echo "<td class='td_right'>\n";
			print_supprimer_alerte_recherche($idar);
			echo "</td>\n";
			echo "</tr></table>\n";
		}
	} else {
		echo "<h2>Vous n'avez pas d'alerte de positionnée</h2>";
		echo "<p>Pour positionner une alerte recherche : </p>";
		echo "<ol>\n";
		echo "<li>Faire votre recherche sur la zone géographique qui vous intéresse</li>\n";
		echo "<li>Préciser le maximum de crititères : nombre de pièces / prix maximum / surface minimum</li>\n";
		echo "<li>Aller en bas de la page de résultats de la recherche</li>\n";
		echo "<li>Cliquer sur le bouton 'Créer une alerte' <em>(* image ci-dessous)</em></li>\n";
		echo "</ol>\n";
		echo "<p><img src='/images/aide-alerte-recherche.gif' alt='Aide pour positionner une alerte recherche' /></p>";
	}

	return;
}
/*-----------------------------------------------------------------------------------*/
function print_lien_recherche($zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max) {

	/*-----------------------------------------------------------------------------------*/
	if ($zone == 'france') {

		// Ici on fait l'ancre
		$recherche = 'France ';
		if ($zone_region != '') $recherche .= $zone_region . ", ";
		if ($zone_dept   != '') $recherche .= $zone_dept . ", ";
		if ($zone_ville  != '') $recherche .= $zone_ville . ", ";
		if ($zone_ard    != '') $recherche .= "arrondissement " . $zone_ard . ", ";
		if ($dept_voisin != '') $recherche .= "département voisin " . $dept_voisin . ", ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".<br />";

		if ($typp == VAL_DTB_TOUS_PRODUITS) $recherche .= "Tous produits ";
		if ($typp == VAL_DTB_APPARTEMENT) $recherche .= "Appartements ";
		if ($typp == VAL_DTB_LOFT) $recherche .= "Loft ";
		if ($typp == VAL_DTB_MAISON) $recherche .= "Maisons ";
		if ($typp == VAL_DTB_CHALET) $recherche .= "Chalets ";

		if ($P1 == '1') $recherche .= "de 1 pièces, ";
		if ($P2 == '2') $recherche .= "de 2 pièces, ";
		if ($P3 == '3') $recherche .= "de 3 pièces, ";
		if ($P4 == '4') $recherche .= "de 4 pièces, ";
		if ($P5 == '5') $recherche .= "de 5 pièces ou plus, ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".<br />";

		if ($sur_min  != '0') $recherche .= "Superficie minimum de $sur_min m2, ";
		if ($prix_max != '0') $recherche .= "Prix maximum de $prix_max Euros, ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".";

		//echo "$recherche<br/>\n";

		// Ici on fait l'url
		$recherche_url = '/cons/recherche-liste.php?zone=france';

		if ($zone_region != '') $recherche_url .= "&zone_region=" . urlencode($zone_region);
		if ($zone_dept   != '') $recherche_url .= "&zone_dept=" . urlencode($zone_dept);
		if ($zone_ville  != '') $recherche_url .= "&zone_ville=" . urlencode($zone_ville);
		if ($zone_ard    != '') $recherche_url .= "&zone_ard=" . urlencode($zone_ard);
		if ($dept_voisin != '') $recherche_url .= "&dept_voisin=" . urlencode($dept_voisin);

		if ($typp == VAL_DTB_TOUS_PRODUITS) $recherche_url .= "&typp=" . VAL_NUM_TOUS_PRODUITS;
		if ($typp == VAL_DTB_APPARTEMENT) $recherche_url .= "&typp=" . VAL_NUM_APPARTEMENT;
		if ($typp == VAL_DTB_LOFT) $recherche_url .= "&typp=" . VAL_NUM_LOFT;
		if ($typp == VAL_DTB_MAISON) $recherche_url .= "&typp=" . VAL_NUM_MAISON;
		if ($typp == VAL_DTB_CHALET) $recherche_url .= "&typp=" . VAL_NUM_CHALET;

		if ($P1 == '1') $recherche_url .= "&P1=1";
		if ($P2 == '2') $recherche_url .= "&P2=2";
		if ($P3 == '3') $recherche_url .= "&P3=3";
		if ($P4 == '4') $recherche_url .= "&P4=4";
		if ($P5 == '5') $recherche_url .= "&P5=5";

		if ($sur_min  != '0') $recherche_url .= "&sur_min=" . $sur_min;
		if ($prix_max != '0') $recherche_url .= "&prix_max=" . $prix_max;

		//echo "$recherche_url<br/>\n";

		echo "<a href='$recherche_url'>$recherche</a>";
	}

	/*-----------------------------------------------------------------------------------*/
	if ($zone == 'domtom') {

		// Ici on fait l'ancre
		$recherche = 'DomTom ';
		if ($zone_dom != '') $recherche .= $zone_dom . ", ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".<br />";

		if ($typp == VAL_DTB_TOUS_PRODUITS) $recherche .= "Tous produits ";
		if ($typp == VAL_DTB_APPARTEMENT) $recherche .= "Appartements ";
		if ($typp == VAL_DTB_LOFT) $recherche .= "Loft ";
		if ($typp == VAL_DTB_MAISON) $recherche .= "Maisons ";
		if ($typp == VAL_DTB_CHALET) $recherche .= "Chalets ";

		if ($P1 == '1') $recherche .= "de 1 pièces, ";
		if ($P2 == '2') $recherche .= "de 2 pièces, ";
		if ($P3 == '3') $recherche .= "de 3 pièces, ";
		if ($P4 == '4') $recherche .= "de 4 pièces, ";
		if ($P5 == '5') $recherche .= "de 5 pièces ou plus, ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".<br />";

		if ($sur_min  != '0') $recherche .= "Superficie minimum de $sur_min m2, ";
		if ($prix_max != '0') $recherche .= "Prix maximum de $prix_max Euros, ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".";

		//echo "$recherche<br/>\n";

		// Ici on fait l'url
		$recherche_url = '/cons/recherche-liste.php?zone=domtom';

		$recherche_url .= "&zone_dom=" . urlencode($zone_dom);

		if ($typp == VAL_DTB_TOUS_PRODUITS) $recherche_url .= "&typp=" . VAL_NUM_TOUS_PRODUITS;
		if ($typp == VAL_DTB_APPARTEMENT) $recherche_url .= "&typp=" . VAL_NUM_APPARTEMENT;
		if ($typp == VAL_DTB_LOFT) $recherche_url .= "&typp=" . VAL_NUM_LOFT;
		if ($typp == VAL_DTB_MAISON) $recherche_url .= "&typp=" . VAL_NUM_MAISON;
		if ($typp == VAL_DTB_CHALET) $recherche_url .= "&typp=" . VAL_NUM_CHALET;

		if ($P1 == '1') $recherche_url .= "&P1=1";
		if ($P2 == '2') $recherche_url .= "&P2=2";
		if ($P3 == '3') $recherche_url .= "&P3=3";
		if ($P4 == '4') $recherche_url .= "&P4=4";
		if ($P5 == '5') $recherche_url .= "&P5=5";

		if ($sur_min  != '0') $recherche_url .= "&sur_min=" . $sur_min;
		if ($prix_max != '0') $recherche_url .= "&prix_max=" . $prix_max;

		//echo "$recherche_url<br/>\n";

		echo "<a href='$recherche_url'>$recherche</a>";
	}

	/*-----------------------------------------------------------------------------------*/
	if ($zone == 'etranger') {

		// Ici on fait l'ancre
		$recherche = 'Pays ';
		$recherche .= $zone_pays . ", ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".<br />";

		if ($typp == VAL_DTB_TOUS_PRODUITS) $recherche .= "Tous produits ";
		if ($typp == VAL_DTB_APPARTEMENT) $recherche .= "Appartements ";
		if ($typp == VAL_DTB_LOFT) $recherche .= "Loft ";
		if ($typp == VAL_DTB_MAISON) $recherche .= "Maisons ";
		if ($typp == VAL_DTB_CHALET) $recherche .= "Chalets ";

		if ($P1 == '1') $recherche .= "de 1 pi�ces, ";
		if ($P2 == '2') $recherche .= "de 2 pi�ces, ";
		if ($P3 == '3') $recherche .= "de 3 pi�ces, ";
		if ($P4 == '4') $recherche .= "de 4 pi�ces, ";
		if ($P5 == '5') $recherche .= "de 5 pi�ces ou plus, ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".<br />";

		if ($sur_min  != '0') $recherche .= "Superficie minimum de $sur_min m�, ";
		if ($prix_max != '0') $recherche .= "Prix maximum de $prix_max Euros, ";
		$recherche = substr(trim($recherche), 0, -1);
		$recherche = $recherche . ".";

		//echo "$recherche<br/>\n";

		// Ici on fait l'url
		$recherche_url = '/cons/recherche-liste.php?zone=etranger';

		$recherche_url .= "&zone_pays=" . urlencode($zone_pays);

		if ($typp == VAL_DTB_TOUS_PRODUITS) $recherche_url .= "&typp=" . VAL_NUM_TOUS_PRODUITS;
		if ($typp == VAL_DTB_APPARTEMENT) $recherche_url .= "&typp=" . VAL_NUM_APPARTEMENT;
		if ($typp == VAL_DTB_LOFT) $recherche_url .= "&typp=" . VAL_NUM_LOFT;
		if ($typp == VAL_DTB_MAISON) $recherche_url .= "&typp=" . VAL_NUM_MAISON;
		if ($typp == VAL_DTB_CHALET) $recherche_url .= "&typp=" . VAL_NUM_CHALET;

		if ($P1 == '1') $recherche_url .= "&P1=1";
		if ($P2 == '2') $recherche_url .= "&P2=2";
		if ($P3 == '3') $recherche_url .= "&P3=3";
		if ($P4 == '4') $recherche_url .= "&P4=4";
		if ($P5 == '5') $recherche_url .= "&P5=5";

		if ($sur_min  != '0') $recherche_url .= "&sur_min=" . $sur_min;
		if ($prix_max != '0') $recherche_url .= "&prix_max=" . $prix_max;

		//echo "$recherche_url<br/>\n";

		echo "<a href='$recherche_url'>$recherche</a>";
	}
}
/*-----------------------------------------------------------------------------------*/
function print_supprimer_alerte_recherche($idar) {

	$supprimer_url = "/compte-recherche/tableau-de-bord.php?action=supprimer_alerte_recherche&idar=" . $idar;
	$supprimer_anchor = "<img src='/images/icon_sup.gif' />";

	echo "<a href='$supprimer_url' title='Supprimer cette alerte'>$supprimer_anchor</a>";
}
/*-----------------------------------------------------------------------------------*/
function print_supprimer_alerte_baisse($idab) {

	$supprimer_url = "/compte-recherche/tableau-de-bord.php?action=supprimer_alerte_baisse&idab=" . $idab;
	$supprimer_anchor = "<img src='/images/icon_sup.gif' />";

	$alerte_baisse = "<a href='" . $supprimer_url . "' title='Supprimer cette alerte'>" . $supprimer_anchor . "</a>";

	return ($alerte_baisse);
}
/*-----------------------------------------------------------------------------------*/
function print_alertes_baisse($connexion, $idc) {

	$idab_declencher  = false;
	$idab_positionner = false;

	// Sélection et affichage des alertes qui ont été déclenchées
	$query = "SELECT idab,tel_ins,prix_positionnement,date_positionnement,prix_apres_alerte,envoyer,date_envoyer FROM compte_recherche_alertes_baisse WHERE idc='$idc' AND envoyer=1";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

	if (mysqli_num_rows($result)) {
		$idab_declencher = true;
		echo "<h2>Liste des alertes qui ont été déclenchées</h2>";
		while (list($idab, $tel_ins, $prix_positionnement, $date_positionnement, $prix_apres_alerte, $envoyer, $date_envoyer) = mysqli_fetch_row($result)) {

			// On veut savoir si l'annonce existe et si c'est le cas son etat
			if (compte_annonce_existe($connexion, $tel_ins, __FILE__, __LINE__)) {
				$annonce_existe = true;
				$etat = get_etat($connexion, $tel_ins, __FILE__, __LINE__);
			} else $annonce_existe = false;

			echo "<table id='tab_alerte_baisse_declencher'>\n";

			if ($annonce_existe == false) echo "<tr><td class='td_left'>Numéro de l'annonce : $tel_ins : Cette annonce n'est plus en ligne</td><td rowspan='5' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";
			if ($annonce_existe == true && $etat == 'attente_paiement') echo "<tr><td class='td_left'>Numéro de l'annonce : $tel_ins : <em>(* annonce en attente de renouvellement)</em><td rowspan='5' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";
			if ($annonce_existe == true && $etat == 'attente_validation') echo "<tr><td class='td_left'>Numéro de l'annonce : $tel_ins : <em>(* annonce en cours de modification)</em><td rowspan='5' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";
			if ($annonce_existe == true && $etat == 'ligne') echo "<tr><td class='td_left'><a href='/annonce-{$tel_ins}.htm' target='_blank'>Numéro de l'annonce : $tel_ins</a></td><td rowspan='5' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";

			echo "<tr><td class='td_left'>Prix au moment du positionnement de l'alerte $prix_positionnement Euros</td></tr>\n";
			echo "<tr><td class='td_left'>L'alerte a été positionnée le $date_positionnement</td></tr>\n";
			echo "<tr><td class='td_left'>Prix après déclenchement de l'alerte $prix_apres_alerte Euros</td></tr>\n";
			echo "<tr><td class='td_left'>L'alerte a été envoyée le $date_envoyer</td></tr>\n";
			echo "</table>\n";
		}
	}
	// Sélection et affichage des alertes qui sont encore positionnées
	$query = "SELECT idab,tel_ins,prix_positionnement,date_positionnement FROM compte_recherche_alertes_baisse WHERE idc='$idc' AND envoyer=0";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

	if (mysqli_num_rows($result)) {
		$idab_positionner = true;
		echo "<h2>Liste des alertes qui sont encore positionn�es</h2>";
		while (list($idab, $tel_ins, $prix_positionnement, $date_positionnement) = mysqli_fetch_row($result)) {

			// On veut savoir si l'annonce existe et si c'est le cas son etat
			if (compte_annonce_existe($connexion, $tel_ins, __FILE__, __LINE__)) {
				$annonce_existe = true;
				$etat = get_etat($connexion, $tel_ins, __FILE__, __LINE__);
			} else $annonce_existe = false;

			echo "<table id='tab_alerte_baisse_positionner'>\n";

			if ($annonce_existe == false) echo "<tr><td class='td_left'>Numéro de l'annonce : $tel_ins : Cette annonce n'est plus en ligne</td><td rowspan='4' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";
			if ($annonce_existe == true && $etat == 'attente_paiement') echo "<tr><td class='td_left'>Numéro de l'annonce : $tel_ins : <em>(* annonce en attente de renouvellement)</em><td rowspan='4' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";
			if ($annonce_existe == true && $etat == 'attente_validation') echo "<tr><td class='td_left'>Numéro de l'annonce : $tel_ins : <em>(* annonce en cours de modification)</em><td rowspan='4' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";
			if ($annonce_existe == true && $etat == 'ligne') echo "<tr><td class='td_left'><a href='/annonce-{$tel_ins}.htm' target='_blank'>Numéro de l'annonce : $tel_ins</a></td><td rowspan='4' class='td_right'>" . print_supprimer_alerte_baisse($idab) . "</td></tr>\n";

			echo "<tr><td class='td_left'>Prix au moment du positionnement de l'alerte $prix_positionnement Euros</td></tr>\n";
			echo "<tr><td class='td_left'>L'alerte a été positionnée le $date_positionnement</td></tr>\n";
			echo "<tr><td class='td_left'>L'alerte n'a pas été envoyée</td></tr>\n";
			echo "</table>\n";
		}
	}

	if ($idab_declencher == false && $idab_positionner == false) {
		echo "<h2>Vous n'avez pas d'alerte de positionnée</h2>";
		echo "<p>Pour positionner une alerte à la baisse : </p>";
		echo "<ol>\n";
		echo "<li>Aller sur n'importe quelle fiche détaillée d'un produit</li>\n";
		echo "<li>Aller vers les boutons  <em>(* à mi-hauteur sur la gauche de la fiche détaillée, image ci-dessous)</em></li>\n";
		echo "<li>Cliquer sur le bouton 'Créer une alerte'</li>\n";
		echo "</ol>\n";
		echo "<p><img src='/images/aide-alerte-baisse.gif' alt='Aide pour positionner une alerte à la baisse' /></p>";
	}
}
/*-----------------------------------------------------------------------------------*/
function make_backlink($from, $my_referer) {

	if ($from == 'details') echo "<p class='backlink'><a href='$my_referer' class='nav_ico12' title='Retourner à l'annonce ou vous avez cliquez sur votre compte'>Retouner à l'annonce</a></p>\n";
	if ($from == 'liste') echo "<p class='backlink'><a href='$my_referer' class='nav_ico12' title='Retourner sur les résultats de recherche ou vous avez cliquez sur votre compte'>Retourner à la recherche</a></p>\n";

	$_SESSION['from'] = '';
	$_SESSION['my_referer'] = '';

	return;
}
/*-----------------------------------------------------------------------------------*/
?>