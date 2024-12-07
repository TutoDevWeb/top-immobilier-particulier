<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_random.php");
include("../include/inc_tracking.php");
include("../include/inc_dtb_compte_recherche.php");
include("../include/inc_mail_compte_recherche.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");

filtrer_les_entrees_request(__FILE__, __LINE__);

$connexion = dtb_connection();
count_cnx($connexion);
isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die;

if ($action == 'compte_creation') {
	isset($_REQUEST['compte_email']) ? $compte_email = strtolower(trim($_REQUEST['compte_email'])) : die;
}

if ($action == 'demande_activation') {
	isset($_REQUEST['compte_email']) ? $compte_email = trim($_REQUEST['compte_email']) : die;
	isset($_REQUEST['compte_pass'])  ? $compte_pass  = trim($_REQUEST['compte_pass'])  : die;
}

if ($action == 'demande_email_activation') {
	isset($_REQUEST['compte_email']) ? $compte_email = trim($_REQUEST['compte_email']) : die;
}

if ($action == 'demande_connexion') {

	if (demande_connexion_recherche($connexion, trim($_REQUEST['compte_email']), trim($_REQUEST['compte_pass']), $code_refus, __FILE__, __LINE__) !== false) {

		if ($_SESSION['from']       == '') $_SESSION['from']       = trim($_REQUEST['from']);
		if ($_SESSION['my_referer'] == '') $_SESSION['my_referer'] = $_SERVER['HTTP_REFERER'];

		// Aller à l'interface utilisateur
		header('Location: /compte-recherche/tableau-de-bord.php');
	}
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Créer ou Accéder à votre compte de recherche</title>
	<meta charset="UTF-8">
	<meta name="Description" content="Accéder à votre compte recherche pour bénéficier des services gratuit d'aide à votre recherche immobilière sur TOP-IMMOBILIER-PARTICULIER.FR" />
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-gestion-connexion.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src='/compte-recherche/jvscript/valid_field.js'></script>
	<script type='text/javascript' src='/compte-recherche/jvscript/valid_form.js'></script>
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<div id='gauche'></div>
			<div id='droite'></div>
			<?PHP make_ariane_page('Votre Compte Recherche'); ?>
			<?PHP
			/* Les demandes de connexion qui arrivent ici sont des echecs */
			if ($action == 'demande_connexion') gestion_echec_connexion($code_refus);

			/* Traitement d'une demande compte recherche depuis l'accueil */
			/* On ne sait pas si l'internaute vient pour la premi�re fois ou s'il a d�j� un compte */
			else if ($action == 'accueil_compte_recherche') {

				// Est ce qu'on peut récupérer un cookie.
				if (get_cookie_recherche($compte_email, $compte_pass) === true) {

					print_connexion_compte_recherche($compte_email, $compte_pass);
					tracking($connexion, CODE_CTR, 'OK', "Entrée sur Accueil compte recherche<br />on a trouvé un cookie:$compte_email", __FILE__, __LINE__);
				} else {

					print_creation_compte_recherche();
					print_connexion_compte_recherche($compte_email = '', $compte_pass = '', $message = true);
					print_lien_password_oublier();
					tracking($connexion, CODE_CTR, 'OK', "Entrée sur Accueil compte recherche<br />ce visiteur n'a pas de cookie", __FILE__, __LINE__);
				}

				/* Traitement d'une demande de cr�ation d'un compte */
			} else if ($action == 'compte_creation') {

				if ($compte_email == '') {
					echo "<p class='allo_reponse'>Rentrer un email SVP</p>";
					print_creation_compte_recherche();
					tracking($connexion, CODE_CTR, 'OK', "compte_creation:Rentrer un email SVP", __FILE__, __LINE__);
				} else if (compte_recherche_existe($connexion, $compte_email, __FILE__, __LINE__) == true) {
					echo "<p class='allo_reponse'>Un compte existe déjà sur cet email : $compte_email</p>";
					print_connexion_compte_recherche($compte_email, $compte_pass);
					print_lien_password_oublier();
					tracking($connexion, CODE_CTR, 'OK', "$compte_email:compte_creation:un compte existe déjà sur cet email", __FILE__, __LINE__);
				} else {
					creation_compte_recherche($connexion, $compte_email, $compte_pass, __FILE__, __LINE__);
					echo "<p class='allo_reponse'>Votre compte a été créé<br/> Un mot de passe vous a été attribué</p>";
					print_creation_compte_recherche($compte_email, $compte_pass);
					echo "<p class='reponse_commentaire'>Vous allez recevoir un email de confirmation avec un lien d'activation.<br />";
					echo "Vous devez cliquer sur ce lien pour activer votre compte.<br />";
					echo "Pendant 24 heures vous pouvez continuer à utiliser votre compte sans l'avoir activé.";
					mail_creation_compte_recherche($compte_email, __FILE__, __LINE__, true);
					tracking($connexion, CODE_CTR, 'OK', "$compte_email:compte_creation:création du compte", __FILE__, __LINE__);
				}

				/* Traitement de la demande d'activation du compte */
			} else if ($action == 'demande_activation') {

				if (compte_recherche_existe($connexion, $compte_email, __FILE__, __LINE__)) {

					$compte_etat = get_etat_compte_recherche($connexion, $compte_email, $compte_pass, __FILE__, __LINE__);

					if ($compte_etat == 'inactif') {

						activer_compte_recherche($connexion, $compte_email, __FILE__, __LINE__);
						echo "<p class='allo_reponse'>Votre compte de recherche a été activé</p>\n";
						print_connexion_compte_recherche($compte_email, $compte_pass);
						tracking($connexion, CODE_CTR, 'OK', "$compte_email:$compte_pass:demande_activation:activation réussi", __FILE__, __LINE__);
					} else if ($compte_etat == 'actif') {
						echo "<p class='allo_reponse'>Votre compte de recherche est déjà activé</p>\n";
						print_connexion_compte_recherche($compte_email, $compte_pass);
						tracking($connexion, CODE_CTR, 'OK', "$compte_email:$compte_pass:demande_activation:compte déjà activé", __FILE__, __LINE__);
					}
				} else {
					echo "<p class='allo_reponse'>Nous ne retrouvons pas cet email dans notre base</p>";
					tracking($connexion, CODE_CTR, 'OK', "$compte_email:$compte_pass:demande_activation:compte inconnu", __FILE__, __LINE__);
				}
				/* Formulaire pour demande d'envoi de mail avec lien d'activation */
			} else if ($action == 'demande_email_activation') {

				if (compte_recherche_existe($connexion, $compte_email, __FILE__, __LINE__)) {

					echo "<p class='allo_reponse'>Un email vous a été envoyé avec un lien d'activation<br/>$compte_email</p>\n";
					/* On envoie ce mail c'est le même qu'à la création */
					mail_creation_compte_recherche($connexion, $compte_email);
					tracking($connexion, CODE_CTR, 'OK', "$compte_email:demande_email_activation:email envoyé", __FILE__, __LINE__);
				} else {
					echo "<p class='allo_reponse'>Nous ne retrouvons pas cet email dans notre base</p>";
					print_activation_compte_recherche();
					tracking($connexion, CODE_CTR, 'OK', "$compte_email:demande_email_activation:email inconnu dans cette base", __FILE__, __LINE__);
				}
			}

			print_xiti_code("gestion-connexion-recherche");
			?>
			<div id='clearboth'>&nbsp;</div>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP
/*--------------------------------------------------------------------------------------------------------*/
function print_creation_compte_recherche($compte_email = '', $compte_pass = '') {

	if ($compte_email == '' && $compte_pass == '') {
?>
		<div id='creation'>
			<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' onsubmit="return valid_form_creation();" autocomplete="off">
				<fieldset>
					<legend>Créer votre compte recherche</legend>
					<p class='info'>Créer gratuitement en un click votre compte de recherche personnalisé et sauvegarder toutes vos informations</p>
					<p><label for='creation_compte_email'>Votre email</label>&nbsp;&nbsp;<input id='creation_compte_email' name='compte_email' type='text' size="25" maxlength="128" /></p>
					<p><em>(* Aucune autre information ne vous sera demandée)</em></p>
					<input type='hidden' name='action' value='compte_creation' />
					<input class='but_input' type='submit' value="Créer" />
					<p>Avec votre compte vous pourrez</p>
					<ul>
						<li>mémoriser vos critéres de recherche</li>
						<li>être prévenu par mail dès la publication de nouvelles annonces</li>
						<li>sélectionner des produits et être prévenu par mail lors d'une baisse de leur prix</li>
						<li>mémoriser vos critères de financement et les retrouver sur chaque annonce</li>
					</ul>
				</fieldset>
			</form>
		</div>
	<?PHP
	} else {
	?>
		<div id='creation'>
			<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' onsubmit="return valid_form_connexion();" autocomplete="off">
				<fieldset>
					<legend>Accéder à votre compte recherche</legend>
					<p><label for='compte_email'>Votre email</label>&nbsp;&nbsp;<input id='compte_email' name='compte_email' type='text' size="25" maxlength="128" value="<?PHP echo "$compte_email"; ?>" readonly /></p>
					<p><label for='compte_pass'>Votre mot de passe</label>&nbsp;&nbsp;<input id='compte_pass' name='compte_pass' type='password' value="<?PHP echo "$compte_pass"; ?>" size="15" maxlength="15" readonly /></p>
					<input type='hidden' name='action' value='demande_connexion' />
					<input class='but_input' type='submit' value="Accéder" />
				</fieldset>
			</form>
		</div>
	<?PHP
	}
}
/*--------------------------------------------------------------------------------------------------------*/
function print_connexion_compte_recherche($compte_email = '', $compte_pass = '', $message = false) {
	?>
	<div id='connexion'>
		<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' onsubmit="return valid_form_connexion();" autocomplete="off">
			<fieldset>
				<legend>Accéder à votre compte recherche</legend>
				<?PHP if ($message === true) echo "<p class='info'>Pour accéder à votre compte recherche il faut d'abord avoir créer votre compte.</p>\n"; ?>
				<p><label for='connexion_compte_email'>Votre email</label>&nbsp;&nbsp;<input id='connexion_compte_email' name='compte_email' type='text' size="25" maxlength="128" value="<?PHP echo "$compte_email"; ?>" /></p>
				<p><label for='connexion_compte_pass'>Votre mot de passe</label>&nbsp;&nbsp;<input id='connexion_compte_pass' name='compte_pass' type='password' value='<?PHP echo $compte_pass; ?>' size="15" maxlength="15" /></p>
				<input type='hidden' name='action' value='demande_connexion' />
				<input class='but_input' type='submit' value='Accéder' />
			</fieldset>
		</form>
	</div>
<?PHP
}
/*--------------------------------------------------------------------------------------------------------*/
function print_lien_password_oublier() {
?>
	<p><a href='/compte-recherche/gestion-password-recherche.php?action=print_form_password_oublier' class='nav_ico11' title='Cliquer ici si vous avez oublié votre mot de passe.'>Vous avez oublié votre mot de passe ?</a></p>

<?PHP
}
/*--------------------------------------------------------------------------------------------------------*/
function print_activation_compte_recherche() {
?>
	<div id='activation'>
		<form action="<?PHP echo $_SERVER['PHP_SELF'] ?>" method='get' onsubmit="return valid_form_activation();" autocomplete="off">
			<fieldset>
				<legend>Activer votre compte</legend>
				<p>Vous devez activer votre compte recherche</p>
				<p>Pour cela cliquer sur le lien d'activation que vous avez reçu</p>
				<p>Pour recevoir un nouveau lien d'activation rentrer votre email</p>
				<p><label for='activation_compte_email'>Votre email</label>&nbsp;&nbsp;<input id='activation_compte_email' name='compte_email' type='text' size='25' maxlength='128' /></p>
				<input type='hidden' name='action' value='demande_email_activation' />
				<input class='but_input' type='submit' value="Recevoir un lien d'activation" />
			</fieldset>
		</form>
	</div>
<?PHP
}
/*--------------------------------------------------------------------------------------------------------*/
function gestion_echec_connexion($code_refus) {

	if ($code_refus == COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION_IDENTIFIANT) {
		echo "<p class='allo_reponse'>Accès refusé<br/>Veuillez vérifier vos identifiants !!<br/>Avez vous créé votre compte de recherche ?</p>";
		print_creation_compte_recherche();
		print_connexion_compte_recherche();
		print_lien_password_oublier();
	} else if ($code_refus == COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION) {
		print_creation_compte_recherche();
		print_connexion_compte_recherche();
		print_lien_password_oublier();
	} else if ($code_refus == COMPTE_RECHERCHE_CONNEXION_ECHEC_INACTIF) {
		print_activation_compte_recherche();
	}
}
?>