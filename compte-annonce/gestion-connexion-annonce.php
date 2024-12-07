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

$connexion = dtb_connection();
count_cnx($connexion);
isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die;

if ($action == 'demande_connexion') {

	if (demande_connexion_annonce($connexion, trim($_REQUEST['compte_tel_ins']), trim($_REQUEST['compte_pass']), $code_refus, __FILE__, __LINE__) !== false) {

		// Aller à l'interface utilisateur
		header('Location: /compte-annonce/tableau-de-bord.php');
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Accéder à votre compte annonce</title>
	<meta charset="UTF-8">
	<meta name="Description" content="Accéder à votre compte annonce pour gérer vous même votre annonce immobilière sur TOP-IMMOBILIER-PARTICULIER.FR" />
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-gestion-connexion.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src='/compte-annonce/jvscript/valid_field.js'></script>
	<script type='text/javascript' src='/compte-annonce/jvscript/valid_form_connexion.js'></script>
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page('Votre Compte Annonce'); ?>
			<?PHP
			/* Les demandes de connexion qui arrivent ici sont des echecs */
			if ($action == 'demande_connexion') gestion_echec_connexion($code_refus);

			/* Traitement d'une demande compte annonce depuis l'accueil */
			/* On ne sait pas si l'internaute à déjà un compte */
			else if ($action == 'accueil_compte_annonce') {

				// Est ce qu'on peut récupérer un cookie.
				if (get_cookie_annonce($compte_tel_ins, $compte_pass) === true) {

					print_connexion_compte_annonce($compte_tel_ins, $compte_pass);
					tracking($connexion, CODE_CTA, 'OK', "Entrée sur Accueil compte annonce<br />on a trouvé un cookie:$compte_tel_ins", __FILE__, __LINE__);
				} else {

					print_connexion_compte_annonce($compte_tel_ins = '', $compte_pass = '', $message = true);
					print_lien_password_oublier();
					tracking($connexion, CODE_CTA, 'OK', "Entrée sur Accueil compte annonce<br />ce visiteur n'a pas de cookie", __FILE__, __LINE__);
				}
			}

			?>
			<div id='clearboth'>&nbsp;</div>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP
/*--------------------------------------------------------------------------------------------------------*/
function print_connexion_compte_annonce($compte_tel_ins = '', $compte_pass = '', $message = false) {
?>
	<div id='connexion'>
		<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' onsubmit="return valid_form_connexion();" autocomplete="off">
			<fieldset>
				<legend>Accéder à votre compte annonce</legend>
				<?PHP if ($message === true) echo "<p class='info'>Pour accéder à votre compte annonce il faut d'abord avoir <a href='http://www.top-immobilier-particulier.fr/compte-annonce/passer-annonce.php'>créé votre annonce</a></p>\n"; ?>
				<p><label for='compte_tel_ins'>Votre téléphone</label>&nbsp;&nbsp;<input id='connexion_compte_tel_ins' name='compte_tel_ins' type='text' size="25" maxlength="128" value="<?PHP echo "$compte_tel_ins"; ?>" /></p>
				<p><label for='connexion_compte_pass'>Votre mot de passe</label>&nbsp;&nbsp;<input id='connexion_compte_pass' name='compte_pass' type='password' value='<?PHP echo $compte_pass; ?>' size="15" maxlength="15" /></p>
				<input type='hidden' name='action' value='demande_connexion' />
				<input class='but_input' type='submit' value='Accéder' />
			</fieldset>
		</form>
	</div>
<?PHP
}
/*--------------------------------------------------------------------------------------------------------*/
function gestion_echec_connexion($code_refus) {

	if ($code_refus == COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION_IDENTIFIANT) {
		echo "<p class='allo_reponse'>Accès refusé<br/>Veuillez vérifier vos identifiants</p>";
		print_connexion_compte_annonce();
		print_lien_password_oublier();
	} else if ($code_refus == COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION) {
		print_connexion_compte_annonce();
		print_lien_password_oublier();
	}
}
/*--------------------------------------------------------------------------------------------------------*/
function print_lien_password_oublier() {
?>
	<p><a href='/compte-annonce/gestion-password-annonce.php?action=print_form_password_oublier' class='nav_ico11' title='Cliquer ici si vous avez oublié votre mot de passe.'>Vous avez oublié votre mot de passe ?</a></p>
<?PHP
}
?>