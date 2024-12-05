<?PHP
include("../data/data.php");
include("../include/inc_base.php");

dtb_connection();

isset($_REQUEST['action']) ? $action = mysqli_real_escape_string(trim($_REQUEST['action']))   : die;
//----------------------------------------------------------------------------------------------
if ($action == 'get_town_list') {

	$query   = "SELECT ville,maps_scale,maps_lat,maps_lng FROM ref_ville WHERE maps_actif=1";
	$result  = dtb_query($query, __FILE__, __LINE__, 0);

	if (mysqli_num_rows($result)) {

		$liste = '[';
		while (list($ville, $maps_scale, $maps_lat, $maps_lng) = mysqli_fetch_row($result)) {
			$ville = addslashes($ville);
			$liste = $liste . "{'ville':'$ville','maps_scale':'$maps_scale','maps_lat':'$maps_lat','maps_lng':'$maps_lng'} ,";
		}
		$liste = substr($liste, 0, -1);
		$liste .= ']';
		echo "$liste";
	} else echo "[]";
	die;
}
//----------------------------------------------------------------------------------------------
if ($action == 'set_town') {

	// Param�tres obligatoites Carte
	isset($_REQUEST['ville'])      ? $ville  = mysqli_real_escape_string(trim($_REQUEST['ville']))            : die;
	isset($_REQUEST['max_ne_lat']) ? $max_ne_lat = mysqli_real_escape_string(trim($_REQUEST['max_ne_lat']))   : die;
	isset($_REQUEST['max_ne_lng']) ? $max_ne_lng = mysqli_real_escape_string(trim($_REQUEST['max_ne_lng']))   : die;
	isset($_REQUEST['max_sw_lat']) ? $max_sw_lat = mysqli_real_escape_string(trim($_REQUEST['max_sw_lat']))   : die;
	isset($_REQUEST['max_sw_lng']) ? $max_sw_lng = mysqli_real_escape_string(trim($_REQUEST['max_sw_lng']))   : die;

	$query   = "UPDATE ref_ville SET max_ne_lat='$max_ne_lat',max_ne_lng='$max_ne_lng',
	                                 max_sw_lat='$max_sw_lat',max_sw_lng='$max_sw_lng' 
																	 WHERE ville='$ville'";

	$result  = dtb_query($query, __FILE__, __LINE__, 0);
	echo "OK";
}
//----------------------------------------------------------------------------------------------
