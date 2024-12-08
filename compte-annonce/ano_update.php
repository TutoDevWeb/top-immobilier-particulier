<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) exit;

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_tracking.php");
include("../include/inc_photo.php");
include("../include/inc_nav.php");
include("../include/inc_dtb_compte_annonce.php");

// Si il n' a pas ou plus les donn�es 'annonce' en session
if (!data_en_session_ok()) {
	header('Location: /');
	die;
}

$connexion = dtb_connection(__FILE__, __LINE__);

if (compte_annonce_existe($connexion, $_SESSION['tel_ins'], __FILE__, __LINE__) === true) {

	$ida = get_ida($connexion, $_SESSION['tel_ins'], __FILE__, __LINE__);
	if ($ida == $_SESSION['ida']) {

		$etat = get_etat($connexion, $_SESSION['tel_ins'], __FILE__, __LINE__);

		if ($etat == 'ligne') $etat = 'attente_validation';

		update_annonce($connexion, $etat, __FILE__, __LINE__);
		renomage_photo($_SESSION['ida'], __FILE__, __LINE__);
		purger_session();
		header('Location: /compte-annonce/tableau-de-bord.php');
	} else tracking_session_annonce($connexion, CODE_CTA, 'OK', "Demande de mise à jour de l'annonce $tel_ins par ida::$ida qui n'est pas son propriétaire", __FILE__, __LINE__);
} else tracking_session_annonce($connexion, CODE_CTA, 'OK', "Demande de mise à jour d'une annonce qui n'existe plus", __FILE__, __LINE__);
