<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<meta charset="UTF-8">
	<title>Geocodage d'une adresse</title>
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
				document.recherche.lat.value = point.lat();
				document.recherche.lng.value = point.lng();
				map.setCenter(point, 12);
				console.log("Lat => " + point.lat());
				console.log("Lng => " + point.lng());


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
	<div id="map_canvas" style="width: 500px; height: 300px"></div>

	<?PHP

	chargement_formulaire_recherche();

	//-----------------------------------------------------------------------------------
	function chargement_formulaire_recherche() {
	?>
		<form name="recherche" action="#" onSubmit="showLocation(); return false;">
			<table width="500" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2"> Rentrer votre adresse : (*Num�ro) Rue Ville<br>
						<input type="text" name="adresse" value="" size="50">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="sub" type="submit" value="recherche">
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">Valeurs trouv&eacute;es</td>
				</tr>
				<tr>
					<td>Lat =&gt;
						<input type="text" id="lat" name="lat" value="" size="15">
					</td>
					<td>Lng =&gt;
						<input type="text" id="lng" name="lng" value="" size="15">
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	?>
</body>

</html>