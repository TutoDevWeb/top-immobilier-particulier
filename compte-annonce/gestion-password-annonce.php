<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_random.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_mail_compte_annonce.php");
include("../include/inc_tracking.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");

filtrer_les_entrees_request(__FILE__, __LINE__);

dtb_connection();
count_cnx();
isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die;

if ($action == 'demande_password_oublier') {
	isset($_REQUEST['compte_tel_ins']) ? $compte_tel_ins = trim($_REQUEST['compte_tel_ins']) : die;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Vous avez oubli� votre mot de passe</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-gestion-connexion.css" rel="stylesheet" type="text/css" />
	<meta name="robots" content="noindex,nofollow" />
	<script type='text/javascript' src='/compte-annonce/jvscript/valid_field.js'></script>
	<script type='text/javascript' src='/compte-annonce/jvscript/valid_form_connexion.js'></script>
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<div id='gauche'><?PHP print_cibleclick_120_600();  ?></div>
			<div id='droite'><?PHP print_cibleclick_120_600();  ?></div>
			<?PHP make_ariane_compte_annonce('Mot de passe oubli�'); ?>
			<?PHP
			/* Traitement de la demande d'envoie du mail de connexion */
			if ($action == 'print_form_password_oublier') {
				print_compte_annonce_password_oublier();
				tracking(CODE_CTA, 'OK', "Affichage formulaire mot de passe oubli�", __FILE__, __LINE__);

				/* Traitement de la demande d'envoie du mail de connexion */
			} else if ($action == 'demande_password_oublier') {

				if (compte_annonce_existe($compte_tel_ins, __FILE__, __LINE__)) {

					echo "<p class='allo_reponse'>Un email a �t� envoy�</p>\n";
					mail_password_compte_annonce($compte_tel_ins);
					tracking(CODE_CTA, 'OK', "$compte_tel_ins:demande_password_oublier:email envoy�", __FILE__, __LINE__);
				} else {
					echo "<p class='allo_reponse'>Nous ne retrouvons pas d'annonce correspondant � ce num�ro de t�l�phone : $compte_tel_ins</p>";
					print_compte_annonce_password_oublier();
					tracking(CODE_CTA, 'OK', "$compte_tel_ins:demande_password_oublier:$compte_tel_ins inconnu dans cette base", __FILE__, __LINE__);
				}
			}

			echo "<p><a href='/' class='nav_ico11' title=\"Pour aller � l'accueil cliquer sur ce lien\">Pour aller � l'accueil cliquer sur ce lien</a></p>";

			echo "<p><a href='/compte-annonce/gestion-connexion-annonce.php?action=accueil_compte_annonce' class='nav_ico11' title='Pour acc�der � votre compte annonce cliquer sur ce lien'>Pour acc�der � votre compte annonce cliquer sur ce lien</a></p>";

			print_xiti_code("gestion-password-annonce");

			print_cible_unifinance_300_250();

			?>
			<div id='clearboth'>&nbsp;</div>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP
/*--------------------------------------------------------------------------------------------------------*/
function print_compte_annonce_password_oublier() {
?>
	<form action="<?PHP echo $_SERVER['PHP_SELF'] ?>" method='get' onsubmit="return valid_form_password();">
		<fieldset>
			<legend>Vous avez oubli� votre mot de passe ?</legend>
			<p><label for='password_compte_tel_ins'>Votre t�l�phone</label>&nbsp;&nbsp;<input id='password_compte_tel_ins' name='compte_tel_ins' type='text' size="25" maxlength="128" /></p>
			<input type='hidden' name='action' value='demande_password_oublier' />
			<input class='but_input' type='submit' value="Vous avez oubli� votre mot de passe" />
		</fieldset>
	</form>
<?PHP
}
?>