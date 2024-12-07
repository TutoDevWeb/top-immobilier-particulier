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

// Si il n' a pas ou plus les donn�es 'annonce' en session
if (!data_en_session_ok()) {
	header('Location: /');
	die;
}

filtrer_les_entrees_post(__FILE__, __LINE__);
filtrer_les_entrees_request(__FILE__, __LINE__);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : die;
dtb_connection();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Immobilier Particuliers Paris - Annonces Immobili�res entre Particuliers Paris</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
						if (compte_annonce_existe($_SESSION['tel_ins'], __FILE__, __LINE__) === false) {

							go_attente_paiement();
							tracking_session_annonce(CODE_CTA, 'OK', "Annonce mise en attente de paiement", __FILE__, __LINE__);
						} else tracking_session_annonce(CODE_CTA, 'OK', "Annonce mise en attente de paiement alors que l'annonce existe d�j�", __FILE__, __LINE__);
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
function go_attente_paiement() {

	// G�n�rer un password
	$password = pass_generator();

	// Ins�rer l'annonce
	$_SESSION['ida'] = insert_annonce($password, __FILE__, __LINE__);

	// R�cup�rer les photos session
	renomage_photo($_SESSION['ida'], __FILE__, __LINE__);

	// Envoi d'un mail au moment de la cr�ation
	mail_creation($_SESSION['tel_ins'], $password);

	print_deconnexion();

	print_info_attente_paiement($_SESSION['tel_ins']);

	purger_session();
}
?>