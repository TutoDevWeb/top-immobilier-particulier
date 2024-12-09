<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) die;
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_ariane.php");
include("../include/inc_tracking.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");
include("../include/inc_fiche.php");
include("../include/inc_photo.php");
include("../include/inc_cibleclick.php");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Page de préparation de l'annonce</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-compte-annonce.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-ph.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src='/jvscript/photo.js'></script>
	<script type='text/javascript' src='/jvscript/popup.js'></script>
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<table id='annonce'>
				<tr>
					<td class='cell_b'><?PHP print_cibleclick_120_600();  ?></td>
					<td class='cell_c'>
						<?PHP
						/*
	        print_r($_SESSION);
		      echo "<p>&nbsp;</p>\n";
		      echo "<p>&nbsp;</p>\n";
			    */
						$zone = $_SESSION['zone'];

						$connexion = dtb_connection();

						if (data_en_session_ok()) {

							make_ariane_fiche_preparation($zone);

							if (is_connexion_admin()) echo "<p class=text12cg>CONNEXION ADMIN</p>";

							print_bouton_maps_upload($zone, is_modif());

							tracking_session_annonce($connexion, CODE_CTA, 'OK', "Visualisation de la fiche", __FILE__, __LINE__);

							print_session_fiche();

							$photo = get_photo_from_session();

							// print_galerie_photo($photo);

							print_bouton_reprendre_ligne($zone, is_modif());

							if (count($photo) ==  0) print_cible_unifinance_300_250();
						} else {

							echo "<p>&nbsp;</p>";
							print_deconnexion();

							print_cible_unifinance_300_250();
						}
						?>
					</td>
					<td class='cell_b'><?PHP print_cibleclick_120_600();  ?></td>
				</tr>
			</table>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP
//-----------------------------------------------------------------------------------------------------------
function print_bouton_maps_upload($zone, $modif) {

	echo "<div class='make'>";

	if ($zone == 'france') {
		if ($modif) echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous pouvez modifier vos photos ou repositionner votre logement sur une carte</p>\n";
		else  echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous devez télécharger vos photos et positionner votre logement sur une carte</p>\n";
		echo "<p><em>(* L'ordre n'a pas d'importance)</em></p>\n";
		echo "<p>";
		echo "<a href='upload.php' title='Gestion des photos'><img src='/images/btn_cre_pho.gif' alt='Gestion des photos' /></a>\n";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<a href='maps.php' title='Gestion des cartes'><img src='/images/btn_cre_map.gif' alt='Gestion des cartes' /></a>\n";
		echo "</p>";
	} else {
		if ($modif) echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous pouvez modifier vos photos</p>\n";
		else  echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous devez télécharger vos photos</p>\n";
		echo "<p><a href='upload.php' title='Gestion des photos'><img src='/images/btn_cre_pho.gif' alt='Gestion des photos' /></p></a>\n";
	}

	echo "</div>";
}
//-----------------------------------------------------------------------------------------------------------
function print_bouton_reprendre_ligne($zone, $modif) {

	echo "<div class='make'>";

	if ($modif) echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous pouvez reprendre la rédaction de l'annonce ou la remettre en ligne</p>";
	else  echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous pouvez reprendre la rédaction de l'annonce ou la mettre en ligne</p>";

	echo "<p>";

	// Reprendre
	if ($zone == 'france')
		echo "<a href='vente-france.php?action=print_form' title='Reprise de la rédaction'><img src='/images/btn_cre_rep.gif' alt='Reprise de la rédaction' /></a>\n";
	if ($zone == 'domtom')
		echo "<a href='vente-domtom.php?action=print_form' title='Reprise de la rédaction'><img src='/images/btn_cre_rep.gif' alt='Reprise de la rédaction' /></a>\n";
	if ($zone == 'etranger')
		echo "<a href='vente-etranger.php?action=print_form' title='Reprise de la rédaction'><img src='/images/btn_cre_rep.gif' alt='Reprise de la rédaction' /></a>\n";

	echo "&nbsp;&nbsp;&nbsp;";

	// Re-mettre ligne
	if ($modif)  echo "<a href='ano_update.php' title='Remettre en ligne'><img src='/images/btn_cre_rli.gif' alt='Remettre en ligne' /></a>\n";

	// Mettre en ligne
	else {
		if ($zone == 'france')
			echo "<a href=\"javascript:confirm_ligne_france('paiement.php?action=print_form');\" title='Mettre en ligne'><img src='/images/btn_cre_lig.gif' alt='Mettre en ligne' /></a>\n";
		else
			echo "<a href=\"javascript:confirm_ligne_autre_zone('paiement.php?action=print_form');\" title='Mettre en ligne'><img src='/images/btn_cre_lig.gif' alt='Mettre en ligne' /></a>\n";
	}

	echo "</p>";

	echo "</div>";
}
//-----------------------------------------------------------------------------------------------------------
?>