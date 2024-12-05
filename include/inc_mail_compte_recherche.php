<?PHP
//-----------------------------------------------------------------------------------------------
function mail_alerte_recherche($compte_email,$list_alerte) {

  $url_site       = URL_SITE;
  $url_short_site = URL_SHORT_SITE;

  get_compte_arg_creation($compte_email,&$compte_pass,&$compte_ip,&$compte_date,&$compte_index_GMT,__FILE__,__LINE__);

  $list_alerte = substr($list_alerte,0,-1);
  $list_tab = explode('|',$list_alerte);

	$subject = "$url_short_site : $compte_email : Alerte recherche";

	$message  = "Ce mail vous informe de la présence de nouveaux produits correspondant à votre recherche.\r\n";	
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous pouvez voir les produits en cliquant sur les liens suivants\r\n";
  foreach ( $list_tab as $tel_ins )
	 $message .= "${url_site}annonce-${tel_ins}.htm\r\n\r\n";	
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous pouvez demander de rentrer en contact avec les vendeurs\r\n";
  $message .= "${url_site}connexion-compte-recherche,$compte_email,$compte_pass.htm#fragment-1\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous pouvez voir les détails de l'alerte en cliquant sur le lien suivant\r\n";
  $message .= "${url_site}connexion-compte-recherche,$compte_email,$compte_pass.htm#fragment-2\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ce lien,\r\n";
  $message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
  $message .= "--------------------------------------------------------------\r\n\r\n";

  compte_send_mail($compte_email,$subject,$message,true);

}
//-----------------------------------------------------------------------------------------------
function mail_alerte_baisse($compte_email,$tel_ins) {

  $url_site       = URL_SITE;
  $url_short_site = URL_SHORT_SITE;

  get_compte_arg_creation($compte_email,&$compte_pass,&$compte_ip,&$compte_date,&$compte_index_GMT,__FILE__,__LINE__);

	$subject = "$url_short_site : $compte_email : Alerte a la baisse";

	$message  = "Ce mail vous informe de la baisse du prix d'un produit sur lequel vous avez positionné une alerte à la baisse.\r\n";	
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous pouvez voir le produit en cliquant sur le lien suivant\r\n";
	$message .= "${url_site}annonce-${tel_ins}.htm\r\n\r\n";	
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous pouvez voir les détails de l'alerte en cliquant sur le lien suivant\r\n";
  $message .= "${url_site}connexion-compte-recherche,$compte_email,$compte_pass.htm\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ce lien,\r\n";
  $message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
  $message .= "--------------------------------------------------------------\r\n\r\n";

  compte_send_mail($compte_email,$subject,$message,true);

}
//-----------------------------------------------------------------------------------------------
function mail_creation_compte_recherche($compte_email) {

  $url_site       = URL_SITE;
  $url_short_site = URL_SHORT_SITE;

  get_compte_arg_creation($compte_email,&$compte_pass,&$compte_ip,&$compte_date,&$compte_index_GMT,__FILE__,__LINE__);

	$subject = "$url_short_site : $compte_email : Veuillez activer votre compte de recherche SVP";

	$message  = "Vous avez créé un compte de recherche sur $url_short_site,\r\n";	
  $message .= "--------------------------------------------------------------\r\n";
	$message .= "Vos identifiants de connexion sont : \r\n";
	$message .= "Votre email : $compte_email\r\n";
	$message .= "Votre mot de passe : $compte_pass\r\n";	
  $message .= "Ce mot de passe vous est attribué de manière aléatoire.\r\n\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous devez cliquer sur le lien suivant pour activer votre compte.\r\n";
  $message .= "Pendant 24 heures vous pouvez utiliser votre compte sans l'avoir activé.\r\n";
  $message .= "${url_site}activer-compte-recherche,$compte_email,$compte_pass.htm\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Pour accéder à votre compte vous devez cliquer sur ce lien.\r\n";
  $message .= "${url_site}connexion-compte-recherche,$compte_email,$compte_pass.htm\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ces liens,\r\n";
  $message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
  $message .= "--------------------------------------------------------------\r\n\r\n";

	$message .= "-----------------------------------\r\n";
  $message .= "Adresse de connexion : $compte_ip\r\n";
  $message .= "Date de création du compte : $compte_date ( GMT $compte_index_GMT )\r\n";
	$message .= "-----------------------------------\r\n";

  compte_send_mail($compte_email,$subject,$message,false);

}
//-----------------------------------------------------------------------------------------------
function mail_relancer_activation_compte_recherche($compte_email) {

  $url_site       = URL_SITE;
  $url_short_site = URL_SHORT_SITE;
  $relancer_compte_recherche_inactif   = DUREE_RELANCER_COMPTE_RECHERCHE_INACTIF;
  $supprimer_compte_recherche_inactif  = DUREE_SUPPRIMER_COMPTE_RECHERCHE_INACTIF;
  $duree_restant = $supprimer_compte_recherche_inactif - $relancer_compte_recherche_inactif;

  get_compte_arg_creation($compte_email,&$compte_pass,&$compte_ip,&$compte_date,&$compte_index_GMT,__FILE__,__LINE__);

	$subject = "$url_short_site : $compte_email : Veuillez activer votre compte de recherche SVP";

	$message  = "Vous avez créé un compte de recherche sur $url_short_site,\r\n";	
  $message .= "--------------------------------------------------------------\r\n";
	$message .= "Ce compte de recherche n'est pas activé depuis plus de $relancer_compte_recherche_inactif jours \r\n";
  $message .= "--------------------------------------------------------------\r\n";
	$message .= "Ce compte doit être activé pour vous permettre :\r\n";
	$message .= "  - de recevoir des alertes mail au moment de la mise en ligne de nouveaux produits selon vos critères enregistrés.\r\n";
	$message .= "  - de recevoir des alertes mail au moment ou le prix des produits que vous avez sélectionnés est à la baisse.\r\n";
	$message .= "  - de voir immédiatement les mensualités de votre crédit en mémorisant votre capacité de financement.\r\n";
  $message .= "--------------------------------------------------------------\r\n";
	$message .= "Il vous reste moins de $duree_restant jours pour activer ce compte\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Vous devez cliquer sur le lien suivant pour activer votre compte.\r\n";
  $message .= "${url_site}activer-compte-recherche,$compte_email,$compte_pass.htm\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Pour accéder à votre compte vous devez cliquer sur ce lien.\r\n";
  $message .= "${url_site}connexion-compte-recherche,$compte_email,$compte_pass.htm\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ces liens,\r\n";
  $message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
  $message .= "--------------------------------------------------------------\r\n";

	$message .= "-----------------------------------\r\n";
  $message .= "Adresse de connexion : $compte_ip\r\n";
  $message .= "Date de création du compte : $compte_date ( GMT $compte_index_GMT )\r\n";
	$message .= "-----------------------------------\r\n";

  compte_send_mail($compte_email,$subject,$message,false);

}
//-----------------------------------------------------------------------------------------------
function mail_password_compte_recherche($compte_email) {

  $url_site       = URL_SITE;
  $url_short_site = URL_SHORT_SITE;

  get_compte_arg_creation($compte_email,&$compte_pass,&$compte_ip,&$compte_date,&$compte_index_GMT,__FILE__,__LINE__);

	$subject = "$url_short_site : $compte_email : Votre mot de passe";

  $message .= "Pour accéder à votre compte vous pouvez cliquer sur ce lien.\r\n";
  $message .= "${url_site}connexion-compte-recherche,$compte_email,$compte_pass.htm\r\n";
  $message .= "--------------------------------------------------------------\r\n";
  $message .= "Si votre logiciel de messagerie ne vous permet pas de cliquer sur ce lien,\r\n";
  $message .= "Copier le lien et Coller le dans la barre d'adresse de votre navigateur.\r\n";
  $message .= "--------------------------------------------------------------\r\n\r\n";
  $message .= "Votre mot de passe est : $compte_pass\r\n";
  $message .= "--------------------------------------------------------------\r\n\r\n";

	$message .= "-----------------------------------\r\n";
  $message .= "Adresse de connexion : $compte_ip\r\n";
  $message .= "Date de création du compte : $compte_date ( GMT $compte_index_GMT )\r\n";
	$message .= "-----------------------------------\r\n";

  compte_send_mail($compte_email,$subject,$message,false);

}
//-----------------------------------------------------------------------------------------------
function compte_send_mail($compte_email,$subject,$message,$trace=false) {

  $url_site           = URL_SITE;
  $url_short_site     = URL_SHORT_SITE;
	$email_master       = EMAIL_WEBMASTER;
	$email_cc_webmaster = EMAIL_CC_WEBMASTER;

  $mess  = "Bonjour,\r\n\r\n\r\n";	
  $mess .= $message;
  $mess .= "\r\n\r\nTrès Cordialement. A bientôt sur $url_site\r\n";

  $headers  = "From: $email_master\r\n";
  $headers .= "BCC: $email_cc_webmaster\r\n";       
  $headers .= "X-Priority: 1 (Highest)\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
	
  if ( mail($compte_email,$subject,$mess,$headers)) {
	  if ( $trace == true ) echo "<p class=text12cg>Envoi du mail à :$compte_email</p>\n";
	  return true;
	} else {
	  if ( $trace == true ) echo "<p class=text12cg>ECHEC envoi du mail à :$compte_email</p>\n";
	  return false;
  }
}
?>