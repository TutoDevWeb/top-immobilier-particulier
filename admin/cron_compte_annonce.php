<title>CRON COMPTE ANNONCE</title>
<?PHP

include("/home/web/tip/tip-fr/data/data.php");
include("/home/web/tip/tip-fr/include/inc_base.php");
include("/home/web/tip/tip-fr/include/inc_conf.php");
include("/home/web/tip/tip-fr/include/inc_mail_compte_annonce.php");
include("/home/web/tip/tip-fr/include/inc_tracking.php");
include("/home/web/tip/tip-fr/include/inc_ano_sup.php");
include("/home/web/tip/tip-fr/include/inc_photo.php");

define('DEBUG_CRON', 1);

// Durée d'envoi d'une centaine de mail
set_time_limit(100);

$connexion = dtb_connection(__FILE__, __LINE__);

tracking($connexion, CODE_CRA, 'OK', "Tache cron compte annonce.", __FILE__, __LINE__);

//----------------------------------------
relancer_attente_paiement($connexion);
effacer_attente_paiement($connexion);
basculer_annonce_sur_fin($connexion);


//----------------------------------------------------------------------------------------------------
function basculer_annonce_sur_fin($connexion) {

	if (DEBUG_CRON) echo "<p><strong>Chercher les annonces qui sont en fin de parution</strong></p>";
	tracking($connexion, CODE_CRA, 'OK', "Chercher les annonces qui sont en fin de parution", __FILE__, __LINE__);

	// Le 10/08/2008 on commence à supprimer les silvers immo
	// Le 19/09/2008 je remets les silver pour ne pas vider totalement le site. Je vais prospecter par téléphone.
	// Le 18/11/2008 Je vais supprimer les silver-immo pour vider le site.
	$query = "SELECT ida,tel_ins,email,password,hits,dat_fin FROM ano WHERE now() > dat_fin AND etat='ligne' LIMIT 1";
	//$query = "SELECT ida,tel_ins,email,password,hits,dat_fin FROM ano WHERE now() > dat_fin AND etat='ligne' AND email != 'silver_immo@yahoo.fr' LIMIT 5";
	//$query = "SELECT ida,tel_ins,email,password,hits,dat_fin FROM ano WHERE now() > dat_fin AND etat='ligne' LIMIT 5";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CRON);

	while (list($ida, $tel_ins, $email, $password, $hits, $dat_fin) = mysqli_fetch_row($result)) {

		if (DEBUG_CRON) echo "$ida::$tel_ins: Fin parution au $dat_fin<br/>";

		// Mettre dans l'état attente_paiement et mettre la date ins à aujourd'hui
		// On fait comme si l'annonce était nouvelle. C'est le plus simple.
		// On marque quand même un flag fin_parution pour l'admin c'est utile à la compréhension
		$query = "UPDATE ano SET dat_ins=now(),etat='attente_paiement',mail_relancer_paiement=0,fin_parution=1 WHERE tel_ins='$tel_ins' LIMIT 1";
		dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CRON);

		mail_fin_parution($connexion, $tel_ins, $password, $hits);

		tracking($connexion, CODE_CRA, 'OK', "ida => $ida::tel_ins => $tel_ins::email => $email:: Fin de parution", __FILE__, __LINE__);
	}
}
//----------------------------------------------------------------------------------------------------
function relancer_attente_paiement($connexion) {

	if (DEBUG_CRON) echo "<p><strong>Chercher les annonces en atente_paiement qui doivent être relancées</strong></p>";
	tracking($connexion, CODE_CRA, 'OK', "Chercher les annonces en atente_paiement qui doivent être relancées", __FILE__, __LINE__);


	$duree_relancer = DUREE_RELANCER_ATTENTE_PAIEMENT;
	$duree_effacer  = DUREE_EFFACER_ATTENTE_PAIEMENT;

	$query = "SELECT ida,tel_ins,password,email FROM ano WHERE etat='attente_paiement' AND (( TO_DAYS(now()) - TO_DAYS(dat_ins) ) >= '$duree_relancer') AND mail_relancer_paiement=0";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CRON);

	while (list($ida, $tel_ins, $password, $email) = mysqli_fetch_row($result)) {

		if (DEBUG_CRON) echo "$ida,$tel_ins:$email: Envoi du mail Relancer Attente Paiement<br/>";

		mail_relancer_attente_paiement($connexion, $tel_ins, $password, $duree_relancer, $duree_effacer);

		// Noter l'envoi du mail
		$query = "UPDATE ano SET mail_relancer_paiement=1 WHERE tel_ins='$tel_ins' LIMIT 1";
		dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CRON);

		tracking($connexion, CODE_CRA, 'OK', "ida => $ida::tel_ins => $tel_ins::email => $email:: Envoi du mail Relancer Attente Paiement", __FILE__, __LINE__);
	}
}
//----------------------------------------------------------------------------------------------------
function effacer_attente_paiement($connexion) {

	if (DEBUG_CRON) echo "<p><strong>Chercher les annonces en atente_paiement qui doivent être effacées</strong></p>";
	tracking($connexion, CODE_CRA, 'OK', "Chercher les annonces en atente_paiement qui doivent être effacées", __FILE__, __LINE__);

	$duree_effacer = DUREE_EFFACER_ATTENTE_PAIEMENT;
	$query = "SELECT ida,tel_ins,email FROM ano WHERE etat='attente_paiement' AND ( TO_DAYS(now()) - TO_DAYS(dat_ins) ) >= '$duree_effacer'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CRON);

	while (list($ida, $tel_ins, $email) = mysqli_fetch_row($result)) {

		ano_sup($tel_ins, __FILE__, __LINE__, DEBUG_CRON);
		tracking($connexion, CODE_CRA, 'OK', "ida => $ida::tel_ins => $tel_ins::email => $email:: Suppression attente paiement", __FILE__, __LINE__);
	}
}
?>