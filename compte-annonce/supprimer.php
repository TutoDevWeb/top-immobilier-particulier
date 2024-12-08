<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) die;
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_tracking.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_ano_sup.php");
include("../include/inc_photo.php");
include("../include/inc_cibleclick.php");

$connexion = dtb_connection();

filtrer_les_entrees_post(__FILE__, __LINE__);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Immobilier Particuliers Paris - Annonces Immobilières entre Particuliers Paris</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-compte-annonce.css" rel="stylesheet" type="text/css" />
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
						print_deconnexion();
						$tel_ins = $_SESSION['tel_ins'];
						if (compte_annonce_existe($connexion, $tel_ins, __FILE__, __LINE__)) {
							$ida = get_ida($connexion, $tel_ins, __FILE__, __LINE__);
							if ($ida == $_SESSION['ida']) {
								echo "<p>&nbsp;</p>";
								echo "<p class='allo_reponse'>Votre annonce référence $tel_ins a été supprimée<br/>Nous vous remercions d'avoir utilisé notre site</p>";

								tracking_session_annonce($connexion, CODE_CTA, 'OK', "Suppression de l'annonce $tel_ins", __FILE__, __LINE__);

								ano_sup($tel_ins, __FILE__, __LINE__, $trace = false);
							} else tracking_session_annonce($connexion, CODE_CTA, 'OK', "Tentative de suppression de $tel_ins par ida::$ida alors que $ida n'est pas le propriétaire", __FILE__, __LINE__);
						} else {

							echo "<p>&nbsp;</p>";
							echo "<p class='allo_reponse'>L'annonce référence $tel_ins a déjà été supprimée</p>";

							tracking_session_annonce($connexion, CODE_CTA, 'OK', "L'annonce $tel_ins a déjà été supprimée", __FILE__, __LINE__);
						}
						echo "<p>&nbsp;</p>";

						print_cible_unifinance_300_250();

						?>
					</td>
					<td class='cell_b'><?PHP print_cibleclick_120_600();  ?></td>
				</tr>
			</table>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>