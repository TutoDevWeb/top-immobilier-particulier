<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) die;
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_tracking.php");
include("../include/inc_conf.php");
include("../include/inc_random.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_photo.php");
include("../include/inc_mail_compte_annonce.php");
include("../include/inc_cibleclick.php");

// Si il n' a pas ou plus les données 'annonce' en session
if (!data_en_session_ok()) {
	header('Location: /');
	die;
}

filtrer_les_entrees_post(__FILE__, __LINE__);
filtrer_les_entrees_request(__FILE__, __LINE__);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : die;
$connexion = dtb_connection();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Immobilier Particuliers Paris - Annonces Immobilières entre Particuliers Paris</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-compte-annonce.css" rel="stylesheet" type="text/css" />
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
						if (compte_annonce_existe($connexion, $_SESSION['tel_ins'], __FILE__, __LINE__) === false) {

							go_attente_paiement($connexion);
							tracking_session_annonce($connexion, CODE_CTA, 'OK', "Annonce mise en attente de paiement", __FILE__, __LINE__);
						} else tracking_session_annonce($connexion, CODE_CTA, 'OK', "Annonce mise en attente de paiement alors que l'annonce existe déjà", __FILE__, __LINE__);
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
//-------------------------------------------------------------------------------------
function go_attente_paiement($connexion) {

	// Générer un password
	$password = pass_generator();

	// Insérer l'annonce
	$_SESSION['ida'] = insert_annonce($connexion, $password, __FILE__, __LINE__);

	// Récupérer les photos session
	renomage_photo($_SESSION['ida'], __FILE__, __LINE__);

	// Envoi d'un mail au moment de la cr�ation
	mail_creation($connexion, $_SESSION['tel_ins'], $password);

	print_deconnexion();

	print_info_attente_paiement($_SESSION['tel_ins']);

	purger_session();
}
?>