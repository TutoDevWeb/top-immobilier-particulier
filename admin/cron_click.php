
<?PHP

include("/home/web/tip/tip-fr/data/data.php");
include("/home/web/tip/tip-fr/include/inc_base.php");
include("/home/web/tip/tip-fr/include/inc_conf.php");
include("/home/web/tip/tip-fr/include/inc_mail_compte_annonce.php");
include("/home/web/tip/tip-fr/include/inc_tracking.php");

define('DEBUG_CLICK', 1);

// La tache sera lancée toutes les heures entres 12 heures et 22 heures soit 10 fois par jours.
// Nombre de click à chaque lancement de la tache.
// Dans ce cas on aura 60 click simuler par jours.
$nb_click = 10;

dtb_connection(__FILE__, __LINE__);

tracking($connexion, CODE_DBG, 'OK', "Cron Click $nb_click", __FILE__, __LINE__);

cron_click($nb_click);

//----------------------------------------------------------------------------------------------------
function cron_click($connexion, $nb_click) {


	$query = "SELECT COUNT(ida) FROM ano WHERE etat='ligne'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CLICK);
	list($nba) = mysqli_fetch_row($result);

	if (DEBUG_CLICK) echo "<p class=text12cg>Il y a $nba annonce en ligne</p>";

	for ($ic = 1; $ic <= $nb_click; $ic++) {

		srand((float)microtime() * date("YmdGis"));
		$offset = rand(0, $nba - 1);

		// On sélectionne l'annonce
		$query = "SELECT ida,tel_ins FROM ano WHERE etat='ligne' LIMIT $offset,1";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CLICK);
		list($ida, $tel_ins) = mysqli_fetch_row($result);

		if (DEBUG_CLICK) echo "<p class=text12cg>Tirage au sort offset:$offset ida:$ida tel_ins:$tel_ins</p>";

		// Il faut compter le hit
		$update = "UPDATE ano SET hits=hits+1 WHERE tel_ins='$tel_ins' LIMIT 1";
		dtb_query($connexion, $update, __FILE__, __LINE__, DEBUG_CLICK);

		tracking($connexion, CODE_DBG, 'OK', "$tel_ins:simul click", __FILE__, __LINE__);
	}
}
?>

