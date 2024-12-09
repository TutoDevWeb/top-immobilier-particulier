<?PHP

//-----------------------------------------------------------------------------------------------
// Mail envoyé par le site : Appel depuis contact_annonceur.php
// Fait pour contacter les annonceurs
function mail_contact_annonceur($connexion, $tel_ins, $mail_from, $message, $trace = false) {

	// On recherche le mail de l'annonceur
	if (($email_annonceur = get_email($connexion, $tel_ins, __FILE__, __LINE__)) !== false) {

		$url_site       = URL_SITE;
		$url_short_site = URL_SHORT_SITE;
		$email_master = EMAIL_WEBMASTER;
		$email_cc_webmaster = EMAIL_CC_WEBMASTER;


		$mess_site  = "Bonjour,\r\n\r\n";

		$mess_site .= "Ce message vous est envoyé par $mail_from un visiteur du site $url_short_site\r\n\r\n";
		$mess_site .= "Il concerne l'annonce suivante :\r\n";
		$mess_site .= "{$url_site}annonce-{$tel_ins}.htm\r\n\r\n";
		$mess_site .= "Ci-dessous son message\r\n";
		$mess_site .= "-----------------------------------------------\r\n";
		$mess_site .= "$message\r\n";
		$mess_site .= "-----------------------------------------------\r\n\r\n";
		$mess_site .= "Très cordialement. L'équipe de $url_short_site\r\n";

		$headers  = "From: $mail_from\r\n";
		$headers .= "BCC: $email_cc_webmaster\r\n";
		$headers .= "X-Priority: 1 (Highest)\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n";

		$subject = "$url_short_site : Contact annonce ref : $tel_ins";

		if (mail($email_annonceur, $subject, $mess_site, $headers)) {
			if ($trace == true) echo "<p class=text12cg>OK: Envoi du mail de contact_annonceur</p>\n";
			return true;
		} else {
			if ($trace == true) echo "<p class=text12cg>KO: Envoi du mail de contact_annonceur</p>\n";
			return false;
		}
	}
	return false;
}
//-----------------------------------------------------------------------------------------------
// Mail envoyé par le site : Appel depuis contact_webmaster.php
// Fait pour contacter le webmaster
function mail_contact_webmaster($mail_from, $subject, $message, $trace = false) {

	$email_master = EMAIL_WEBMASTER;

	$headers  = "From: $mail_from\r\n";
	$headers .= "X-Priority: 1 (Highest)\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
	$headers .= "Content-Transfer-Encoding: 8bit\r\n";

	$subject = 'Demande contact webmaster: ' . $subject;

	if (mail($email_master, $subject, $message, $headers)) {
		if ($trace == true) echo "<p class=text12cg>OK: Envoi du mail de contact_webmaster</p>\n";
		return true;
	} else {
		if ($trace == true) echo "<p class=text12cg>KO: Envoi du mail de contact_webmaster</p>\n";
		return false;
	}
}
//-----------------------------------------------------------------------------------------------
// Tous les envois de mail ci-dessous ( Site / Admin / Cron ) font appel à la fonction appli_mail()
//-----------------------------------------------------------------------------------------------
// Ci dessous la liste des Mails envoyés par le site
//-----------------------------------------------------------------------------------------------
// Mail envoyé par le site
function mail_creation($connexion, $tel_ins, $password) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;
	$duree_annonce  = DUREE_ANNONCE;
	$prix_annonce   = PRIX_ANNONCE;

	$cheque_ordre   = CHEQUE_ORDRE;
	$cheque_adresse = CHEQUE_ADRESSE;
	$cheque_legal   = CHEQUE_LEGAL;

	$subject  = "$url_short_site : $tel_ins : creation de votre annonce";

	$message  = "Vous avez créé une annonce sur $url_short_site,\r\n";
	$message .= "---------------------------------------------------------------------------------------\r\n";
	$message .= "Nous sommes en attente de votre chêque de paiement\r\n";
	$message .= "---------------------------------------------------------------------------------------\r\n";
	$message .= "PENSER A METTRE LE NUMERO DE TELEPHONE D'INSCRIPTION AU DOS DU CHEQUE : $tel_ins\r\n";
	$message .= "---------------------------------------------------------------------------------------\r\n";
	$message .= "Montant du chêque : $prix_annonce Euros\r\n";
	$message .= "Durée de parution : $duree_annonce mois à compter de la réception du chêque\r\n";
	$message .= "Chêque à l'ordre de : $cheque_ordre\r\n";
	$message .= "Expédier à l'adresse : $cheque_adresse\r\n";
	$message .= "$cheque_legal\r\n";
	$message .= "---------------------------------------------------------------------------------------\r\n";
	$message .= "Vos identifiants de connexion sont :\r\n";
	$message .= "Votre téléphone : $tel_ins\r\n";
	$message .= "Votre mot de passe : $password\r\n";
	$message .= "Ce mot de passe vous est attribué de manière aléatoire.\r\n\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Cliquer sur le lien suivant pour un accès direct à la gestion de votre annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ce lien,\r\n";
	$message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
	$message .= "--------------------------------------------------------------\r\n\r\n";

	get_ip_dat($connexion, $tel_ins, $ip_ins, $dat_ins);
	$index_GMT = date("O", time());
	$message .= "-----------------------------------\r\n";
	$message .= "Adresse de connexion : $ip_ins\r\n";
	$message .= "Date de l'annonce : $dat_ins ( GMT $index_GMT )\r\n";
	$message .= "-----------------------------------\r\n";

	appli_mail($connexion, $tel_ins, $subject, $message, false);
}
//-----------------------------------------------------------------------------------------------
// Mail envoy� par le site
function mail_password_compte_annonce($connexion, $tel_ins) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;

	$password = get_password($connexion, $tel_ins, __FILE__, __LINE__);

	$subject  = "$url_short_site : $tel_ins : Informations de connexion";

	$message  = "Vos identifiants de connexion\r\n";
	$message .= "Votre téléphone : $tel_ins\r\n";
	$message .= "Votre mot de passe : $password\r\n";
	$message .= "Ce mot de passe est généré de manière aléatoire.\r\n\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Cliquer sur le lien suivant pour un accès direct à la gestion de votre annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "--------------------------------------------------------------\r\n";

	$trace = false;
	appli_mail($connexion, $tel_ins, $subject, $message, $trace);
}
//-----------------------------------------------------------------------------------------------
// Ci dessous la liste des Mails envoyés par la tache CRON
//-----------------------------------------------------------------------------------------------
// Mail envoyé par la tache CRON
function mail_relancer_attente_paiement($connexion, $tel_ins, $password, $duree_relancer, $duree_effacer) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;
	$duree_annonce  = DUREE_ANNONCE;
	$prix_annonce   = PRIX_ANNONCE;

	$cheque_ordre   = CHEQUE_ORDRE;
	$cheque_adresse = CHEQUE_ADRESSE;
	$cheque_legal   = CHEQUE_LEGAL;

	$subject = "$url_short_site : Nous sommes en attente de votre cheque de paiement";

	$duree_reste = $duree_effacer - $duree_relancer;

	$message  = "Vous avez créé une annonce sur $url_short_site,\r\n";
	$message .= "Le site attend votre chêque de paiement depuis $duree_relancer jours.\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "FAITE JOUER LA CONCURRENCE !! LA CONCURRENCE FAIT BAISSER LES PRIX !!\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Nous vous rappelons les conditions de parution.\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Montant du chêque : $prix_annonce Euros\r\n";
	$message .= "Durée de parution : $duree_annonce mois à compter de la réception du chêque\r\n";
	$message .= "Chêque à l'ordre de : $cheque_ordre\r\n";
	$message .= "Expédier à l'adresse : $cheque_adresse\r\n";
	$message .= "$cheque_legal\r\n";
	$message .= "---------------------------------------------------------------------------------------\r\n";
	$message .= "PENSER A METTRE LE NUMERO DE TELEPHONE D'INSCRIPTION AU DOS DU CHEQUE : $tel_ins\r\n";
	$message .= "---------------------------------------------------------------------------------------\r\n";
	$message .= "Cliquer sur le lien suivant pour un accès direct à la gestion de votre annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ce lien,\r\n";
	$message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "En cas de difficultés contacter le webmaster\r\n";
	$message .= "--------------------------------------------------------------\r\n\r\n";
	$message .= "Sans réception du chêque de paiement,\r\n";
	$message .= "cette annonce sera automatiquement effacée dans $duree_reste jours à compter de ce jour.\r\n";
	$message .= "--------------------------------------------------------------\r\n";

	appli_mail($connexion, $tel_ins, $subject, $message, false);
}
//-----------------------------------------------------------------------------------------------
// Mail envoyé par la tache CRON
function mail_fin_parution($connexion, $tel_ins, $password, $hits) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;

	$subject = "$url_short_site : Fin de parution de votre annonce";

	$message  = "L'annonce associée au numéro de téléphone $tel_ins est arrivée en fin de parution.\r\n";
	$message .= "Cette annonce a été vue $hits fois.\r\n\r\n";
	$message .= "Nous espérons que vous avez été satisfait de ce service\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Si nécessaire, cliquer sur le lien suivant pour une nouvelle parution de votre annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ce lien,\r\n";
	$message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
	$message .= "--------------------------------------------------------------\r\n";

	appli_mail($connexion, $tel_ins, $subject, $message, false);
}
//-----------------------------------------------------------------------------------------------
// Ci dessous les mail envoyés par l'administrateur.
//-----------------------------------------------------------------------------------------------
// Mail envoyé par l'admin :: Action mailer
function mail_info($connexion, $tel_ins, $password, $info) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;

	$subject = "$url_short_site : $tel_ins : Information concernant votre annonce";

	$message = "$info\r\n\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Cliquer sur le lien suivant pour un accès direct à l'annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Rappel de vos identifiants de connexion\r\n";
	$message .= "Votre téléphone : $tel_ins\r\n";
	$message .= "Votre mot de passe : $password\r\n";

	$trace = true;
	appli_mail($connexion, $tel_ins, $subject, $message, $trace);
}
//-----------------------------------------------------------------------------------------------
// Mail envoyé par l'admin
function mail_go_ligne_sur_paiement($connexion, $tel_ins, $password, $dat_fin) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;

	$dat_fin = to_full_dat($dat_fin);

	$subject = "$url_short_site : $tel_ins : Reception paiement:Votre annonce a ete mise en ligne";

	$message  = "Votre annonce a été mise en ligne\r\n\r\n";
	$message .= "Elle sera maintenue en ligne jusqu'au $dat_fin\r\n";

	$message .= "\r\nSuivez ce lien pour un rappel des conditions d'utilisation {$url_site}noref/condition.php\r\n\r\n";

	$message .= "Pour une action rapide cliquer sur un des liens suivants \r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Pour voir votre annonce sur $url_short_site\r\n";
	$message .= "{$url_site}annonce-{$tel_ins}.htm\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Pour un accès direct à la gestion de votre annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Rappel de vos identifiants de connexion\r\n";
	$message .= "Votre téléphone : $tel_ins\r\n";
	$message .= "Votre mot de passe : $password\r\n";

	$trace = true;
	appli_mail($connexion, $tel_ins, $subject, $message, $trace);
}
//-----------------------------------------------------------------------------------------------
// Mail envoyé par l'admin
function mail_go_ligne_sur_validation($connexion, $tel_ins, $password) {

	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;

	$subject = "$url_short_site : $tel_ins : Votre annonce a ete remise en ligne";

	$message  = "Suite à vos modifications, votre annonce a été remise en ligne\r\n\r\n";


	$message .= "\r\nSuivez ce lien pour un rappel des conditions d'utilisation {$url_site}noref/condition.php\r\n\r\n";


	$message .= "Pour une action rapide cliquer sur un des liens suivants \r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Pour voir votre annonce sur $url_short_site\r\n";
	$message .= "{$url_site}annonce-{$tel_ins}.htm\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Pour un accès direct à la gestion de votre annonce\r\n";
	$message .= "{$url_site}connexion-{$tel_ins}-{$password}.htm\r\n";
	$message .= "--------------------------------------------------------------\r\n";
	$message .= "Rappel de vos identifiants de connexion\r\n";
	$message .= "Votre téléphone : $tel_ins\r\n";
	$message .= "Votre mot de passe : $password\r\n";

	$trace = true;
	appli_mail($connexion, $tel_ins, $subject, $message, $trace);
}
//-----------------------------------------------------------------------------------------------
function appli_mail($connexion, $tel_ins, $subject, $message, $trace = false) {

	$url_site           = URL_SITE;
	$url_short_site     = URL_SHORT_SITE;
	$email_master       = EMAIL_WEBMASTER;
	$email_cc_webmaster = EMAIL_CC_WEBMASTER;


	$query  = "SELECT email FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_MAIL);
	list($email)  = mysqli_fetch_row($result);

	$mess  = "Bonjour,\r\n\r\n\r\n";
	$mess .= $message;
	$mess .= "\r\n\r\nTrès Cordialement. L'équipe de $url_site\r\n";

	$headers  = "From: $email_master\r\n";
	$headers .= "BCC: $email_cc_webmaster\r\n";
	$headers .= "X-Priority: 1 (Highest)\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
	$headers .= "Content-Transfer-Encoding: 8bit\r\n";

	if (mail($email, $subject, $mess, $headers)) {
		if ($trace == true) echo "<p class=text12cg>Envoi du mail à :$email</p>\n";
		return true;
	} else {
		if ($trace == true) echo "<p class=text12cg>ECHEC envoi du mail à :$email</p>\n";
		return false;
	}
}
