<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) exit;

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_tracking.php");
include("../include/inc_photo.php");
include("../include/inc_format.php");
include("../include/inc_filter.php");
include("../include/inc_nav.php");
include("../include/inc_fiche.php");
include("../include/inc_random.php");
include("../include/inc_dtb_compte_annonce.php");

if (!filtrer_les_entrees_get(__FILE__, __LINE__)) die;

if (DEBUG_MODIFIER) echo "Restaure from base<br/>";

$connexion = dtb_connection(__FILE__, __LINE__);

$tel_ins = $_SESSION['tel_ins'];

if (compte_annonce_existe($connexion, $tel_ins, __FILE__, __LINE__) === true) {

	$ida = get_ida($connexion, $tel_ins, __FILE__, __LINE__);

	if ($ida == $_SESSION['ida']) {

		restore_from_base($tel_ins);
		restore_photo_session($ida);

		// Stoker la date / heure du debut de la modif
		set_date_modification($connexion, $tel_ins, __FILE__, __LINE__);

		tracking_session_annonce($connexion, CODE_CTA, 'OK', "Démarre la modification", __FILE__, __LINE__);

		$_SESSION['modifier'] = 1;

		header('Location: /compte-annonce/fiche.php?action=print_form');
	} else tracking_session_annonce($connexion, CODE_CTA, 'OK', "Démarre la modification de $tel_ins par ida::$ida qui n'est pas son propriétaire", __FILE__, __LINE__);
} else tracking_session_annonce($connexion, CODE_CTA, 'OK', "Démarre la modification d'une annonce qui n'existe plus", __FILE__, __LINE__);
