<title>CRON COMPTE RECHERCHE</title>
<?PHP
include("/home/web/tip/tip-fr/data/data.php");
include("/home/web/tip/tip-fr/include/inc_base.php");
include("/home/web/tip/tip-fr/include/inc_conf.php");
include("/home/web/tip/tip-fr/include/inc_where_condition.php");
include("/home/web/tip/tip-fr/include/inc_dtb_compte_recherche.php");
include("/home/web/tip/tip-fr/include/inc_mail_compte_recherche.php");
include("/home/web/tip/tip-fr/include/inc_tracking.php");

set_time_limit(100);

define('DEBUG_CRON_COMPTE_RECHERCHE', 1);

dtb_connection();

// S�lection d'une tranches de compte � traiter.
$query = "SELECT idc,compte_email FROM compte_recherche WHERE  ( UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(compte_dernier_traitement) ) > 86400 LIMIT 0,100";
$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

$nb = mysqli_num_rows($result);
echo "Compte Recherche tache cron: Il y a $nb comptes � traiter<br />";
tracking(CODE_CRR, 'OK', "Compte Recherche tache cron: il y a $nb comptes � traiter", __FILE__, __LINE__);

while (list($idc, $compte_email) = mysqli_fetch_row($result)) {

	echo "-------------------------------------<br/>";


	if (check_if_ok_for_alerte($idc)) {

		echo "Traitement des alertes sur $idc:$compte_email<br/>";
		// Traiter les alertes recherches
		traiter_alerte_recherche($idc, $compte_email);

		// Traiter les alertes � la baisse
		traiter_alerte_baisse($idc, $compte_email);
	}

	// Enregistrer la date du traitement
	enregistrer_date_traitement($idc);

	// Teste si le compte est inactif et proc�de aux actions n�cessaires selon la dur�e d'inactivit�.
	traiter_compte_recherche_inactif($idc, $compte_email);

	// Teste si le compte est p�rim� et le supprime si c'est le cas.
	purger_compte_recherche_perimer($idc);
}
/*----------------------------------------------------------------------------------------------------*/
// On va regarder si le compte est OK pour que l'on puisse proc�der aux traitements des alertes
function check_if_ok_for_alerte($idc) {

	echo "Test pour voir si le compte recherche idc=$idc est OK pour les traitements d'alertes<br/>\n";

	$query = "SELECT * FROM compte_recherche WHERE idc='$idc' AND compte_bloquage='no' AND ( (compte_etat = 'actif') OR (UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(compte_date)) < 86400 )";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	if (mysqli_num_rows($result)) {
		echo "idc=$idc est OK pour les traitements d'alertes<br/>\n";
		return true;
	} else {
		echo "idc=$idc n'est pas OK pour les traitements d'alertes<br/>\n";
		return false;
	}
}
/*----------------------------------------------------------------------------------------------------*/
// Traiter les alertes recherche qui sont positionn�es sur ce compte
function traiter_alerte_recherche($idc, $compte_email) {

	//tracking(CODE_CRR,'OK',"Traiter alerte recherche de $compte_email => $idc",__FILE__,__LINE__);

	echo "Traiter les alertes recherche de $idc $compte_email<br/>\n";

	// S�lectionner les alertes recherche de ce compte
	$query = "SELECT idar,date_positionnement,zone,zone_pays,zone_dom,zone_region,zone_dept,zone_ville,zone_ard,dept_voisin,typp,P1,P2,P3,P4,P5,sur_min,prix_max,liste FROM compte_recherche_alertes_recherche WHERE idc='$idc'";
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	// Pour chaque alerte regarder si il y a des annonces
	while (list($idar, $date_positionnement, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $liste) = mysqli_fetch_row($result)) {

		$where_condition = make_where_condition($date_positionnement, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $liste);

		recherche_nouvelle_annonce($idar, $idc, $compte_email, $where_condition);
	}

	return;
}
/*----------------------------------------------------------------------------------------------------*/
// Traiter les alertes � la baisse qui sont positionn�es sur ce compte
function traiter_alerte_baisse($idc, $compte_email) {

	//tracking(CODE_CRR,'OK',"Traiter alerte baisse de $compte_email => $idc",__FILE__,__LINE__);

	echo "Traiter les alertes � la baisse de $idc $compte_email<br/>\n";

	// S�lection des Alertes � la baisse � d�clencher pour cet annonceur
	$query = "SELECT a.tel_ins,a.prix,crab.idab,crab.prix_positionnement FROM ano as a , compte_recherche_alertes_baisse as crab WHERE a.etat='ligne' AND crab.idc='$idc' AND a.tel_ins=crab.tel_ins AND a.prix < crab.prix_positionnement AND crab.envoyer=0";
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	while (list($tel_ins, $prix, $idab, $prix_positionnement) = mysqli_fetch_row($result)) {

		tracking(CODE_CRR, 'OK', "D�clenche alerte baisse<br/>Annonce $tel_ins<br/>Acheteur $compte_email", __FILE__, __LINE__);
		$query = "UPDATE compte_recherche_alertes_baisse SET envoyer=1,date_envoyer=now(),prix_apres_alerte='$prix' WHERE idab='$idab' LIMIT 1";

		dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

		mail_alerte_baisse($compte_email, $tel_ins);
	}
	return;
}
/*----------------------------------------------------------------------------------------------------*/
// Enregistrer la date du traitement
function enregistrer_date_traitement($idc) {

	$query = "UPDATE compte_recherche SET compte_dernier_traitement=now() WHERE idc='$idc' LIMIT 1";
	dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	//tracking(CODE_CRR,'OK',"Enregistrement date de traitement $idc",__FILE__,__LINE__);

}
//-------------------------------------------------------------------------------------------------------------------
function make_where_condition($date_positionnement, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $liste) {

	$zone        = mysqli_real_escape_string($zone);
	$zone_pays   = mysqli_real_escape_string($zone_pays);
	$zone_dom    = mysqli_real_escape_string($zone_dom);
	$zone_region = mysqli_real_escape_string($zone_region);
	$zone_dept   = mysqli_real_escape_string($zone_dept);
	$zone_ville  = mysqli_real_escape_string($zone_ville);
	$zone_ard    = mysqli_real_escape_string($zone_ard);

	$where_condition = "etat='ligne'";
	make_where_condition_with_date_positionnement($where_condition, $date_positionnement);
	make_where_condition_with_zone($where_condition, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin);
	make_where_condition_with_typp_dtb($where_condition, $typp);
	make_where_condition_with_nbpi($where_condition, $P1, $P2, $P3, $P4, $P5);
	make_where_condition_with_sur_min($where_condition, $sur_min);
	make_where_condition_with_prix_max($where_condition, $prix_max);
	make_where_condition_with_liste($where_condition, $liste);

	return $where_condition;
}
//-------------------------------------------------------------------------------------------------------------------
// Au niveau du format de la liste on d�cide de mettre le num�ro de l'annonce suivit d'un s�parateur
// C'est plus simple car on peut concat�ner directement dans la base
// Le s�parateur est supprim� � la lecture. ( nombreux essais de fait )
function recherche_nouvelle_annonce($idar, $idc, $compte_email, $where_condition) {

	// On s�lectionne les nouvelles annonces.
	$query  = "SELECT ida,tel_ins FROM ano WHERE " . $where_condition;
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	// Si il y a des r�sultats
	if (mysqli_num_rows($result)) {

		// On fait une liste que l'on met sous la forme d'une chaine de caract�res
		while (list($ida, $alerte) = mysqli_fetch_row($result)) {

			$list_alerte .= $alerte . '|';
		}
		// On ajoute � la liste d'annonce que l'on a d�j� mailer.
		$query  = "UPDATE compte_recherche_alertes_recherche SET liste=CONCAT(liste,'$list_alerte') WHERE idar='$idar' AND idc='$idc' LIMIT 1";
		dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

		tracking(CODE_CRR, 'OK', "D�clenche alerte recherche<br/>$compte_email<br/>$list_alerte", __FILE__, __LINE__);

		// On maile les nouvelle annonce sur les email FAI des acheteurs
		mail_alerte_recherche($compte_email, $list_alerte);
	}
}
//-------------------------------------------------------------------------------------------------------------------
function  purger_compte_recherche_perimer($idc) {

	echo "Tester pour voir si le compte recherche idc=$idc est p�rim�<br/>\n";

	// S�lectionner les compte � purger
	$compte_recherche_perimer = COMPTE_RECHERCHE_PERIMER;

	$query  = "SELECT idc,compte_email FROM compte_recherche WHERE idc='$idc' AND  ((TO_DAYS(now()) - TO_DAYS(compte_date_connexion)) >  $compte_recherche_perimer)";
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	while (list($idc, $compte_email) = mysqli_fetch_row($result)) {

		supprimer_compte_recherche($idc, __FILE__, __LINE__);

		tracking(CODE_CRR, 'OK', "Suppression compte recherche p�rim� $compte_email => $idc", __FILE__, __LINE__);
	}
}
//-------------------------------------------------------------------------------------------------------------------
function traiter_compte_recherche_inactif($idc, $compte_email) {

	echo "Tester pour voir si le compte recherche idc=$idc est inactif<br/>\n";

	// Regarder si le compte est inactif,n'a pas �t� relanc�, et doit �tre relanc�
	$relancer_compte_recherche_inactif = DUREE_RELANCER_COMPTE_RECHERCHE_INACTIF;

	$query  = "SELECT * FROM compte_recherche WHERE idc='$idc' AND compte_etat='inactif' AND compte_inactif_relancer=0 AND ((TO_DAYS(now()) - TO_DAYS(compte_date)) >  $relancer_compte_recherche_inactif)";
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	if (mysqli_num_rows($result)) {

		echo "Le compte recherche idc=$idc est inactif depuis plus de $relancer_compte_recherche_inactif jours. On envoie un mail<br/>\n";

		mail_relancer_activation_compte_recherche($compte_email);

		tracking(CODE_CRR, 'OK', "Mail relance compte recherche inactif $compte_email => $idc", __FILE__, __LINE__);

		// Enregistrer la relance
		$query  = "UPDATE compte_recherche SET compte_inactif_relancer=1 WHERE idc='$idc' LIMIT 1";
		dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);
	}

	// Regarder si le compte est inactif, at�t relanc� et doit �tre supprimer
	$supprimer_compte_recherche_inactif = DUREE_SUPPRIMER_COMPTE_RECHERCHE_INACTIF;

	$query  = "SELECT * FROM compte_recherche WHERE idc='$idc' AND compte_etat='inactif' AND compte_inactif_relancer=1 AND ((TO_DAYS(now()) - TO_DAYS(compte_date)) >  $supprimer_compte_recherche_inactif)";
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_CRON_COMPTE_RECHERCHE);

	if (mysqli_num_rows($result)) {

		echo "Le compte recherche idc=$idc est inactif depuis plus de $supprimer_compte_recherche_inactif jours. On supprime le compte<br/>\n";

		supprimer_compte_recherche($idc, __FILE__, __LINE__);

		tracking(CODE_CRR, 'OK', "Suppression compte recherche inactif $compte_email => $idc", __FILE__, __LINE__);
	}
}
?>