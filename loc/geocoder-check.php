<?PHP

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_tracking.php");

//------------------------------------------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'get_region') {
	dtb_connection();

	// On en prend une
	$query  = "SELECT region FROM loc_region";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$list_region = '[';
	while (list($region) = mysqli_fetch_row($result)) {

		$region = addslashes($region);
		$list_region .= "'" . $region . "' ,";
	}

	$list_region = substr($list_region, 0, -1);
	$list_region .= "]";
	echo $list_region;
	die;
}
//------------------------------------------------------------------------------------------------------------
if ($action == 'get_dept_in_region') {
	isset($_POST['zone_region']) ? $zone_region = addslashes(trim($_POST['zone_region'])) : die;
	dtb_connection();

	// On en prend une
	$query  = "SELECT d.dept FROM loc_departement as d,loc_region as r WHERE d.idr=r.idr AND r.region='$zone_region'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$list_dept = '[';
	while (list($dept) = mysqli_fetch_row($result)) {

		$dept = addslashes($dept);
		$list_dept .= "'" . $dept . "' ,";
	}

	$list_dept = substr($list_dept, 0, -1);
	$list_dept .= "]";
	echo $list_dept;
	die;
}
//------------------------------------------------------------------------------------------------------------
if ($action == 'get_ville_in_dept') {
	isset($_POST['zone_dept']) ? $zone_dept = addslashes(trim($_POST['zone_dept'])) : die;
	dtb_connection();

	// On en prend une
	$query  = "SELECT v.ville FROM loc_ville as v,loc_departement as d WHERE v.idd=d.idd AND d.dept='$zone_dept' ORDER BY v.ville ASC";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	$list_ville = '[';
	while (list($ville) = mysqli_fetch_row($result)) {

		$ville = addslashes($ville);
		$list_ville .= "'" . $ville . "' ,";
	}

	$list_ville = substr($list_ville, 0, -1);
	$list_ville .= "]";
	echo $list_ville;
	die;
}
//------------------------------------------------------------------------------------------------------------
if ($action == 'get_map_region') {
	isset($_POST['zone_region']) ? $zone_region = addslashes(trim($_POST['zone_region'])) : die;
	dtb_connection();

	$query  = "SELECT region_lat,region_lng FROM loc_region WHERE region='$zone_region'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	list($region_lat, $region_lng) = mysqli_fetch_row($result);

	$region_zoom = ZOOM_REGION;

	$rep = "{ 'region_lat' : '$region_lat' , 'region_lng' : '$region_lng' ,  'region_zoom' : '$region_zoom' }";

	echo $rep;
	die;
}
//------------------------------------------------------------------------------------------------------------
if ($action == 'get_map_dept') {
	isset($_POST['zone_region']) ? $zone_region = addslashes(trim($_POST['zone_region'])) : die;
	isset($_POST['zone_dept'])   ? $zone_dept   = addslashes(trim($_POST['zone_dept']))   : die;
	dtb_connection();

	$query  = "SELECT d.dept_lat,d.dept_lng FROM loc_departement as d, loc_region as r WHERE d.dept='$zone_dept' AND r.region='$zone_region'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);

	list($dept_lat, $dept_lng) = mysqli_fetch_row($result);

	$dept_zoom = ZOOM_DEPT;

	$rep = "{ 'dept_lat' : '$dept_lat' , 'dept_lng' : '$dept_lng' ,  'dept_zoom' : '$dept_zoom' }";

	echo $rep;
	die;
}
//------------------------------------------------------------------------------------------------------------
if ($action == 'get_map_ville') {
	isset($_POST['zone_region']) ? $zone_region = addslashes(trim($_POST['zone_region'])) : die;
	isset($_POST['zone_dept'])   ? $zone_dept   = addslashes(trim($_POST['zone_dept']))   : die;
	isset($_POST['zone_ville'])  ? $zone_ville  = addslashes(trim($_POST['zone_ville']))  : die;
	dtb_connection();

	$query  = "SELECT v.ville_lat,v.ville_lng FROM loc_ville as v, loc_departement as d, loc_region as r WHERE v.idd=d.idd AND v.idr=r.idr AND v.ville='$zone_ville' AND d.dept='$zone_dept' AND r.region='$zone_region'";
	tracking_dtb($query, __FILE__, __LINE__);

	$result = dtb_query($query, __FILE__, __LINE__, 0);

	list($ville_lat, $ville_lng) = mysqli_fetch_row($result);

	$ville_zoom = ZOOM_VILLE;

	$rep = "{ 'ville_lat' : '$ville_lat' , 'ville_lng' : '$ville_lng' ,  'ville_zoom' : '$ville_zoom' }";

	echo $rep;
	die;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Check en lecture du geocodage des tables loc_ville / loc_dept / loc_region</title>
	<meta charset="UTF-8">
	<style type='text/css'>
		div#map {
			width: 658px;
			height: 550px
		}
	</style>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script>
	<script type="text/javascript">
		//<![CDATA[
		var map;

		function load_map() {

			map = new GMap2(document.getElementById("map"));
			map.setCenter(new GLatLng(46.255847, 2.197266), parseInt(6));
			map.addControl(new GSmallMapControl());

			get_region();

		}
		//---------------------------------------------------------------------------------
		// Faire une requ�te pour r�cup�rer les r�gions
		function get_region() {

			var id_zone_region = document.getElementById('zone_region');
			var id_zone_dept = document.getElementById('zone_dept');
			var id_zone_ville = document.getElementById('zone_ville');

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {

						list_region = eval('(' + xhr.responseText + ')');

						// On vide les select d'abord
						id_zone_dept.options.length = 0;
						id_zone_ville.options.length = 0;
						//id_zone_dept.style.visibility = 'hidden';
						//id_zone_ville.style.visibility = 'hidden';

						// On initalise
						var new_region = new Option('Choisir', '');
						id_zone_region.options[id_zone_region.length] = new_region;

						// On le rempli avec la liste
						for (var i in list_region) {
							new_region = new Option(list_region[i], list_region[i]);
							id_zone_region.options[id_zone_region.length] = new_region;
						}
					} else window.alert(xhr.status);
				}
			};

			xhr.open("POST", "/loc/geocoder-check.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('action=get_region');

		}
		//---------------------------------------------------------------------------------
		// Faire une requ�te pour r�cup�rer les d�partement
		function get_dept(zone_region) {

			var id_zone_region = document.getElementById('zone_region');
			var id_zone_dept = document.getElementById('zone_dept');
			var id_zone_ville = document.getElementById('zone_ville');

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {

						list_dept = eval('(' + xhr.responseText + ')');

						// On vide les select d'abord
						id_zone_dept.options.length = 0;
						id_zone_ville.options.length = 0;
						//id_zone_dept.style.visibility = 'visible';
						//id_zone_ville.style.visibility = 'hidden';

						// On initalise
						var new_dept = new Option('Choisir', '');
						id_zone_dept.options[id_zone_dept.length] = new_dept;

						// On le rempli avec la liste
						for (var i in list_dept) {
							new_dept = new Option(list_dept[i], list_dept[i]);
							id_zone_dept.options[id_zone_dept.length] = new_dept;
						}
					} else window.alert(xhr.status);
				}
			};

			xhr.open("POST", "/loc/geocoder-check.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('action=get_dept_in_region&zone_region=' + encodeURI(zone_region));

		}
		//---------------------------------------------------------------------------------
		// Faire une requ�te pour r�cup�rer les villes
		function get_ville(zone_dept) {

			var id_zone_region = document.getElementById('zone_region');
			var id_zone_dept = document.getElementById('zone_dept');
			var id_zone_ville = document.getElementById('zone_ville');

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {

						list_ville = eval('(' + xhr.responseText + ')');

						// On vide les select d'abord
						id_zone_ville.options.length = 0;
						//id_zone_ville.style.visibility = 'visible';

						// On initalise
						var new_ville = new Option('Choisir', '');
						id_zone_ville.options[id_zone_ville.length] = new_ville;

						// On le rempli avec la liste
						for (var i in list_ville) {
							new_ville = new Option(list_ville[i], list_ville[i]);
							id_zone_ville.options[id_zone_ville.length] = new_ville;
						}
					} else window.alert(xhr.status);
				}
			};

			xhr.open("POST", "/loc/geocoder-check.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('action=get_ville_in_dept&zone_dept=' + encodeURI(zone_dept));

		}
		//---------------------------------------------------------------------------------
		// Aller sur une carte
		function go_map() {

			var id_zone_region = document.getElementById('zone_region');
			var id_zone_dept = document.getElementById('zone_dept');
			var id_zone_ville = document.getElementById('zone_ville');

			// Conditions pour chercher une r�gion
			// La r�gion soit choisie
			// Le d�partement ne soit pas choisie ou soit vide.
			// La ville soit vide
			if (id_zone_region.selectedIndex != 0 && (id_zone_dept.options.length == 0 || id_zone_dept.selectedIndex == 0) && id_zone_ville.options.length == 0) {
				console.log('On recherche une carte de r�gion');
				var zone_region = id_zone_region.options[id_zone_region.selectedIndex].value;
				console.log(zone_region);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if (xhr.status == 200) {

							data = eval('(' + xhr.responseText + ')');
							map.setCenter(new GLatLng(data.region_lat, data.region_lng), parseInt(data.region_zoom));
							var marker = new GMarker(new GLatLng(data.region_lat, data.region_lng));
							map.addOverlay(marker);

							var bounds = map.getBounds();
							var ne_lat = bounds.getNorthEast().lat();
							var ne_lng = bounds.getNorthEast().lng();
							var sw_lat = bounds.getSouthWest().lat();
							var sw_lng = bounds.getSouthWest().lng();

							console.log("region_lat => " + data.region_lat + " : region_lng => " + data.region_lng);
							console.log("ne_lat => " + ne_lat + " : sw_lat => " + sw_lat);
							console.log("ne_lng => " + ne_lng + " : sw_lng => " + sw_lng);

						} else window.alert(xhr.status);
					}
				};

				xhr.open("POST", "/loc/geocoder-check.php", false);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send('action=get_map_region&zone_region=' + encodeURI(zone_region));

			}

			// Conditions pour chercher un d�partement
			// La r�gion soit choisie
			// Le d�partement soit choisie
			// La ville soit vide ou pas choisie
			if (id_zone_region.selectedIndex != 0 && id_zone_dept.selectedIndex != 0 && (id_zone_ville.options.length == 0 || id_zone_ville.selectedIndex == 0)) {
				console.log('On recherche une carte de d�partement');
				var zone_region = id_zone_region.options[id_zone_region.selectedIndex].value;
				var zone_dept = id_zone_dept.options[id_zone_dept.selectedIndex].value;
				console.log(zone_dept);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if (xhr.status == 200) {

							data = eval('(' + xhr.responseText + ')');
							map.setCenter(new GLatLng(data.dept_lat, data.dept_lng), parseInt(data.dept_zoom));
							var marker = new GMarker(new GLatLng(data.dept_lat, data.dept_lng));
							map.addOverlay(marker);

							var bounds = map.getBounds();
							var ne_lat = bounds.getNorthEast().lat();
							var ne_lng = bounds.getNorthEast().lng();
							var sw_lat = bounds.getSouthWest().lat();
							var sw_lng = bounds.getSouthWest().lng();

							console.log("dept_lat => " + data.dept_lat + " : dept_lng => " + data.dept_lng);
							console.log("ne_lat => " + ne_lat + " : sw_lat => " + sw_lat);
							console.log("ne_lng => " + ne_lng + " : sw_lng => " + sw_lng);

						} else window.alert(xhr.status);
					}
				};

				xhr.open("POST", "/loc/geocoder-check.php", false);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send('action=get_map_dept&zone_dept=' + encodeURI(zone_dept) + '&zone_region=' + encodeURI(zone_region));

			}

			// Conditions pour chercher une ville
			// La r�gion soit choisie
			// Le d�partement soit choisie
			// La ville ne soit pas vide et la ville soit choisie
			if (id_zone_region.selectedIndex != 0 && id_zone_dept.selectedIndex != 0 && id_zone_ville.options.length != 0 && id_zone_ville.selectedIndex != 0) {
				console.log('On recherche une carte de ville');
				var zone_region = id_zone_region.options[id_zone_region.selectedIndex].value;
				var zone_dept = id_zone_dept.options[id_zone_dept.selectedIndex].value;
				var zone_ville = id_zone_ville.options[id_zone_ville.selectedIndex].value;
				console.log(zone_ville);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if (xhr.status == 200) {

							data = eval('(' + xhr.responseText + ')');
							map.setCenter(new GLatLng(data.ville_lat, data.ville_lng), parseInt(data.ville_zoom));
							var marker = new GMarker(new GLatLng(data.ville_lat, data.ville_lng));
							map.addOverlay(marker);

						} else window.alert(xhr.status);
					}
				};

				xhr.open("POST", "/loc/geocoder-check.php", false);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send('action=get_map_ville&zone_ville=' + encodeURI(zone_ville) + '&zone_dept=' + encodeURI(zone_dept) + '&zone_region=' + encodeURI(zone_region));

			}
		}

		//------------------------------------------------------------------------------------------------
		//]]>
	</script>
</head>

<body onload="load_map();" onunload="GUnload()">
	<div id='select'>
		<form action="#" onsubmit="go_map(); return false;">
			<select id="zone_region" name="zone_region" onChange="get_dept(this.value);">
			</select>
			<select id="zone_dept" name="zone_dept" onChange="get_ville(this.value);">
			</select>
			<select id="zone_ville" name="zone_ville">
			</select>
			<input type='submit' name='voir' value="Voir">
		</form>
	</div>
	<div id='map'></div>
</body>

</html>