<?PHP

include("data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");

//------------------------------------------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'set_ville') {
	isset($_POST['idv'])        ? $idv        = trim($_POST['idv'])                    : die;
	isset($_POST['ville'])      ? $ville      = addslashes(trim($_POST['ville']))      : die;
	isset($_POST['lat'])        ? $lat        = $_POST['lat']                          : die;
	isset($_POST['lng'])        ? $lng        = $_POST['lng']                          : die;
	isset($_POST['maps_code'])  ? $maps_code  = $_POST['maps_code']                    : die;
	isset($_POST['address_GG']) ? $address_GG = addslashes(utf8_decode(trim($_POST['address_GG']))) : die;

	dtb_connection();

	$query  = "UPDATE loc_ville SET ville_lat='$lat',ville_lng='$lng',maps_code='$maps_code',address_GG='$address_GG' WHERE idv='$idv' LIMIT 1";
	dtb_query($query, __FILE__, __LINE__, 0);
	echo 'OK';
	die;
}
//------------------------------------------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'get_data_next_search') {
	dtb_connection();

	// On en prend une
	$query  = "SELECT ville_CDIP,idv,idd,idr FROM loc_ville WHERE maps_code=0 ORDER BY idv ASC LIMIT 1";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	list($ville, $idv, $idd, $idr) = mysqli_fetch_row($result);

	// On r�cup�re le nom de son d�partement
	$query  = "SELECT dept_lat,dept_lng,dept FROM loc_departement WHERE idd='$idd'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	list($dept_lat, $dept_lng, $dept) = mysqli_fetch_row($result);

	// On r�cup�re le nom de sa r�gion
	$query  = "SELECT region FROM loc_region WHERE idr='$idr'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	list($region) = mysqli_fetch_row($result);

	$ville  = addslashes($ville);
	$dept   = addslashes($dept);
	$region = addslashes($region);

	$dept_zoom = ZOOM_DEPT;

	echo "{ 'idv' : '$idv' , 'ville' : '$ville' , 'dept' : '$dept' , 'region' : '$region' , 'dept_lat' : '$dept_lat' , 'dept_lng' : '$dept_lng' , 'dept_zoom' : '$dept_zoom' }";
	die;
}
//------------------------------------------------------------------------------------------------------------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Geocodage des villes</title>
	<meta charset="UTF-8">
	<style type='text/css'>
		div#map {
			width: 658px;
			height: 550px
		}
	</style>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTASDNGt1Ah7UMjIzjNf91KosJQYhT2_N2tGBVmUwT_PKT4VUzPoyhomg" type="text/javascript"></script>
	<script type="text/JavaScript">
		//<![CDATA[
var map;
var geocoder = new GClientGeocoder();
var data_for_search;
//---------------------------------------------------------------------------------
var maps_code = 0;  
// 0 valeur initiale on a rien fait
// 1 Tout est OK
// 2 le serveur a r�pondu qu'il ne trouvait pas d'adresse
// 3 le programme n'a pas trouv� france dans l'adresse renvoy�e par le serveur
// 4 la v�rification de coordonn�es a echouer.


//---------------------------------------------------------------------------------
function load_map() {

  map = new GMap2(document.getElementById("map"));
  map.setCenter(new GLatLng(46.255847,2.197266),parseInt(6));
  map.addControl(new GSmallMapControl());

  timeInterval = setInterval(get_data_next_search,5000); 
  //get_data_next_search();
}
//---------------------------------------------------------------------------------
// Faire une requ�te synchone pour r�cup�rer les infos n�cessaires � la prochaine recherche
function get_data_next_search() {

	var xhr = new XMLHttpRequest();               
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
			  
				// R�cup�ration des donn�es
        data_for_search = eval ('('+xhr.responseText+')');
				//console.log(data_for_search.ville);
				//console.log(data_for_search.dept);
				//console.log(data_for_search.region);
				//console.log(data_for_search.dept_lat);
				//console.log(data_for_search.dept_lng);
				//console.log(data_for_search.dept_zoom);
				
				send_geocoder_request();
				
      } else window.alert(xhr.status); 
    }
  }; 


  xhr.open( "POST", "/loc/geocoder-ville.php",false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=get_data_next_search'); 

}
//---------------------------------------------------------------------------------
// Envoi de la requ�te � GG_MAPS
function send_geocoder_request() {

  var location = 'France , '+data_for_search.region+' , '+data_for_search.dept+' , '+data_for_search.ville;

  geocoder.getLocations(location, addAddressToMap);
  console.log("Envoi d'une requ�te vers GG_MAP : "+location);


}
//---------------------------------------------------------------------------------
function addAddressToMap(response) {

  if (!response || response.Status.code != 200) {
    console.log("Sorry, we were unable to geocode that address");
    maps_code = 2;
  } else {

    var place = response.Placemark[0];
    var point = new GLatLng(place.Point.coordinates[1],
                            place.Point.coordinates[0]);
    console.log(place.address)
		//console.log(point.lat());										
		//console.log(point.lng());
    //console.log('------------------');
    
		// Pour l'instant on v�rifie qu'on est bien en France
		if ( place.address.search(/france/i) == -1 ) maps_code = 3;
    else {     
	    var lat  = point.lat();
	    var lng  = point.lng();
			maps_code = 1;
			var address_GG = place.address;

      //---------------------------------------------------------
      // Maintenant on regarde si les coordonn�es du d�partement sont dans la r�gion
	    map.setCenter(new GLatLng(data_for_search.dept_lat,data_for_search.dept_lng),parseInt(data_for_search.dept_zoom));
      var marker = new GMarker(point);
      map.clearOverlays();
			map.addOverlay(marker);

      // Limite de la carte
      var bounds = map.getBounds();
		
		  // Param�tres de la carte
      var bounds = map.getBounds();
      var ne_lat = bounds.getNorthEast().lat();
      var ne_lng = bounds.getNorthEast().lng();
      var sw_lat = bounds.getSouthWest().lat();
      var sw_lng = bounds.getSouthWest().lng();

      console.log('ne_lat => '+ne_lat+' :ne_lng => '+ne_lng+' :sw_lat => '+sw_lat+' :sw_lng => '+sw_lng);		
		
      if ( bounds.contains(point) ) maps_code = 1;
	    else maps_code = 4;
	  }
	}

  // Ici on va envoyer la requ�te vers SAG-SIVIT pour mettre � jour la dtb
	var xhr = new XMLHttpRequest();
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {

        console.log(xhr.responseText);

      } else window.alert(xhr.status); 
    }
  }; 
	

  xhr.open( "POST", "/loc/geocoder-ville.php",  false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=set_ville'+'&idv='+data_for_search.idv+'+&ville='+escape(data_for_search.ville)+'&dept='+escape(data_for_search.dept)+'&region='+escape(data_for_search.region)+'&lat='+lat+'&lng='+lng+'&maps_code='+maps_code+'&address_GG='+address_GG); 

}
//------------------------------------------------------------------------------------------------
//]]>
</script>

<body onload="load_map();" onunload="GUnload()">
	<div id='map'></div>

</html>