<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_dtb_compte_annonce.php");
dtb_connection();

isset($_GET['action']) ? $action = $_GET['action'] : $action = 'chargement_session';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<meta charset="UTF-8">
	<title>Tools for Geocoding Data</title>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script>
	<script type="text/javascript">
		var map;
		var geocoder;

		function initialize() {
			map = new GMap2(document.getElementById("map_canvas"));
			map.setCenter(new GLatLng(46.225453, 2.197266), 5);
			map.addControl(new GLargeMapControl());
			geocoder = new GClientGeocoder();
		}

		// addAddressToMap() is called when the geocoder returns an
		// answer.  It adds a marker to the map with an open info window
		// showing the nicely formatted version of the address and the country code.
		function addAddressToMap(response) {
			map.clearOverlays();
			if (!response || response.Status.code != 200) {
				alert("Sorry, we were unable to geocode that address");
			} else {
				place = response.Placemark[0];
				point = new GLatLng(place.Point.coordinates[1],
					place.Point.coordinates[0]);
				document.enregistrer.lat.value = point.lat();
				document.enregistrer.lng.value = point.lng();
				map.setCenter(point, 12);

				marker = new GMarker(point);
				map.addOverlay(marker);
				marker.openInfoWindowHtml(place.address + '<br>' +
					'<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
			}
		}

		// showLocation() is called when you click on the Search button
		// in the form.  It geocodes the address entered into the form
		// and adds a marker to the map at that location.
		function showLocation() {
			var address = document.recherche.adresse.value;
			geocoder.getLocations(address, addAddressToMap);
		}
		// findLocation() is used to enter the sample addresses into the form.
		function findLocation(address) {
			document.recherche.adresse.value = address;
			showLocation();
		}
	</script>
</head>

<body onLoad="initialize()">
	<?PHP

	if ($action == 'chargement_session') chargement_session();
	if ($action == 'suivant') $_SESSION['ind']++;
	if ($action == 'enregistrer') {
		enregistrer($_GET['lat'], $_GET['lng'], $_GET['tel_ins']);
		$_SESSION['ind']++;
	}
	if ($action == 'enregistrer_echec') {
		enregistrer_echec($_GET['tel_ins']);
		$_SESSION['ind']++;
	}
	chargement_formulaire_recherche();



	//-----------------------------------------------------------------------------------
	function enregistrer($lat, $lng, $tel_ins) {

		$query = "UPDATE ano SET maps_lat='$lat',maps_lng='$lng',maps_actif=1 WHERE tel_ins='$tel_ins' LIMIT 1";
		dtb_query($query, __FILE__, __LINE__, 1);
	}
	//-----------------------------------------------------------------------------------
	function enregistrer_echec($tel_ins) {

		$query = "UPDATE ano SET maps_echec=1 WHERE tel_ins='$tel_ins' LIMIT 1";
		dtb_query($query, __FILE__, __LINE__, 1);
	}
	//-----------------------------------------------------------------------------------
	function chargement_session() {

		$query = "SELECT quart,tel_ins,zone_ville FROM ano WHERE etat='ligne' AND maps_actif=0 AND maps_echec=0";
		$result = dtb_query($query, __FILE__, __LINE__, 1);

		$_SESSION['quart']      = array();
		$_SESSION['tel_ins']    = array();
		$_SESSION['zone_ville'] = array();

		while (list($quart, $tel_ins, $zone_ville) = mysqli_fetch_row($result)) {
			array_push($_SESSION['quart'], $quart);
			array_push($_SESSION['tel_ins'], $tel_ins);
			array_push($_SESSION['zone_ville'], $zone_ville);
		}

		$_SESSION['ind'] = 0;
	}
	//-----------------------------------------------------------------------------------
	function chargement_formulaire_recherche() {
		$ind        = $_SESSION['ind'];
		$quart      = $_SESSION['quart'][$ind];
		$tel_ins    = $_SESSION['tel_ins'][$ind];
		$zone_ville = $_SESSION['zone_ville'][$ind];
	?>
		<form name="recherche" action="#" onSubmit="showLocation(); return false;">
			<table width="600" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td> Rentrer votre adresse : (*Num�ro) Rue Ville<br>
						<input type="text" name="adresse" value="<?PHP echo "$quart , $zone_ville"; ?>" size="50">
					</td>
				</tr>
				<tr>
					<td><input name="sub" type="submit" value="recherche"></td>
				</tr>
			</table>
		</form>
		<div id="map_canvas" style="width: 500px; height: 300px"></div>
		<form name="enregistrer" action="<?PHP echo $_REQUEST['PHP_SELF']; ?>">
			<table width="600" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>PHONE&nbsp;<input type="text" name="tel_ins" size="15" value="<?PHP echo "$tel_ins"; ?>"></td>
					<td>LAT&nbsp;<input type="text" name="lat" size="15" value=""></td>
					<td>LNG&nbsp;<input type="text" name="lng" size="15" value=""></td>
				</tr>
				<tr>
					<td colspan="3">
						<input type="hidden" name="action" value="enregistrer">
						<input type="submit" name="find" value="Enregistrer">
					</td>
				</tr>
			</table>
		</form>
		<p>
		<form name="suivant" action="<?PHP echo $_REQUEST['PHP_SELF']; ?>">
			<input type="hidden" name="action" value="suivant">
			<input type="submit" name="find" value="Suivant">
		</form>
		</p>
		<p>
		<form name="echec" action="<?PHP echo $_REQUEST['PHP_SELF']; ?>">
			<input type="hidden" name="tel_ins" value="<?PHP echo "$tel_ins"; ?>">
			<input type="hidden" name="action" value="enregistrer_echec">
			<input type="submit" name="find" value="Echec">
		</form>
		</p>
	<?PHP
	}
	?>
</body>

</html>