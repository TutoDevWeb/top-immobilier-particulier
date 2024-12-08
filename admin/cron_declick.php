
<?PHP

include("/home/web/sans-agences/data/data.php");
include("/home/web/sans-agences/include/inc_base.php");
include("/home/web/sans-agences/include/inc_conf.php");
include("/home/web/sans-agences/include/inc_tracking.php");

define('DEBUG_DECLICK', 1);

// Diminuer le nombre de click des silver-immo

$nb_click = 10;

$connexion = dtb_connection(__FILE__, __LINE__);

tracking($connexion, CODE_DBG, 'OK', "Cron DeClick $nb_click", __FILE__, __LINE__);

cron_click($connexion, $nb_click);

//----------------------------------------------------------------------------------------------------
function cron_click($connexion, $nb_click) {

	$nb_click_min = 17 * $nb_click;

	$query = "SELECT tel_ins,hits FROM ano WHERE etat='ligne' AND email='silver_immo@yahoo.fr' AND hits > $nb_click_min";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_CLICK);

	while (list($tel_ins, $hits) = mysqli_fetch_row($result)) {

		// Il faut compter le hit
		$update = "UPDATE ano SET hits=hits-$nb_click WHERE tel_ins='$tel_ins' LIMIT 1";
		//dtb_query($update,__FILE__,__LINE__,DEBUG_CLICK);   
		echo "$hits :: $update<br />";
		//tracking(CODE_DBG,'OK',"$tel_ins:simul click",__FILE__,__LINE__);


	}
}
?>

