<?PHP

include("data.php");
include("../include/inc_base.php");

//------------------------------------------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'set_region') {

	isset($_POST['idr'])        ? $idr        = $_POST['idr']                          : die;
	isset($_POST['lat'])        ? $lat        = $_POST['lat']                          : die;
	isset($_POST['lng'])        ? $lng        = $_POST['lng']                          : die;
	isset($_POST['maps_code'])  ? $maps_code  = $_POST['maps_code']                    : die;
	isset($_POST['address_GG']) ? $address_GG = addslashes(utf8_decode(trim($_POST['address_GG']))) : die;

	dtb_connection();
	$query  = "UPDATE loc_region SET region_lat='$lat',region_lng='$lng',maps_code='$maps_code',address_GG='$address_GG' WHERE idr='$idr'";
	dtb_query($query, __FILE__, __LINE__, 0);
	echo 'OK';
	die;
}
//------------------------------------------------------------------------------------------------------------
if ($action == 'get_data_next_search') {
	dtb_connection();

	// On en prend une
	$query  = "SELECT region,idr FROM loc_region WHERE maps_code=0 ORDER BY idr ASC LIMIT 1";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	list($region, $idr) = mysqli_fetch_row($result);

	if (mysqli_num_rows($result) == 0) $code_retour = 0;
	else $code_retour = 1;

	$region = addslashes($region);

	echo "{ 'code_retour' : '$code_retour' ,'idr' : '$idr' , 'region' : '$region' }";
	die;
}
//------------------------------------------------------------------------------------------------------------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Geocodage des d�partements</title>
	<meta charset="UTF-8">
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTASDNGt1Ah7UMjIzjNf91KosJQYhT2_N2tGBVmUwT_PKT4VUzPoyhomg" type="text/javascript"></script>
</head>

<body>
	<script type="text/JavaScript">
		var geocoder = new GClientGeocoder();
var data_for_search;
//---------------------------------------------------------------------------------
var maps_code = 0;  
// 0 valeur initiale on a rien fait
// 1 Tout est OK
// 2 le serveur a r�pondu qu'il ne trouvait pas d'adresse
// 3 le programme n'a pas trouv� france dans l'adresse renvoy�e par le serveur



//---------------------------------------------------------------------------------
// Faire une requ�te synchone pour r�cup�rer les infos n�cessaires � la prochaine recherche
function get_data_next_search() {

	var xhr = new XMLHttpRequest();               
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
			  
				// R�cup�ration des donn�es
				console.log(xhr.responseText);
        data_for_search = eval ('('+xhr.responseText+')');

        if ( data_for_search.code_retour == 0 ) clearInterval(timeInterval);				
				console.log(data_for_search.idr);
				console.log(data_for_search.region);

				send_geocoder_request();
				
      } else window.alert(xhr.status); 
    }
  }; 


  xhr.open( "POST", "/loc/geocoder-region.php",false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=get_data_next_search'); 

}
//---------------------------------------------------------------------------------
// Envoi de la requ�te � GG_MAPS
function send_geocoder_request() {

  var location = 'France , '+data_for_search.region;

  geocoder.getLocations(location, addAddressToMap);
  console.log("Envoi d'une requ�te vers GG_MAP : "+location);


}
//---------------------------------------------------------------------------------
function addAddressToMap(response) {
  if (!response || response.Status.code != 200) {
    console.log("Sorry, we were unable to geocode that address");
    maps_code = 2;
  } else {

    place = response.Placemark[0];
    point = new GLatLng(place.Point.coordinates[1],
                        place.Point.coordinates[0]);
    console.log(place.address)
		console.log(point.lat());										
		console.log(point.lng());
    console.log('------------------');
    
		// Pour l'instant on v�rifie qu'on est bien en France
		if ( place.address.search(/france/i) == -1 ) maps_code = 3;
    else {     
	    var lat  = point.lat();
	    var lng  = point.lng();
			maps_code = 1;
			var address_GG = place.address;
	  }
	}

  console.log('lat : '+lat)
	console.log('lng : '+lng);										
	console.log('maps_code : '+maps_code);
  console.log('------------------');

  // Ici on va envoyer la requ�te vers SAG-SIVIT pour mettre � jour la dtb
	var xhr = new XMLHttpRequest();
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {

        console.log(xhr.responseText);

      } else window.alert(xhr.status); 
    }
  }; 
	

  xhr.open( "POST", "/loc/geocoder-region.php",  false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=set_region&idr='+data_for_search.idr+'&lat='+lat+'&lng='+lng+'&maps_code='+maps_code+'&address_GG='+address_GG); 

}
//---------------------------------------------------------------------------------


timeInterval = setInterval(get_data_next_search,5000); 

</script>
</body>

</html>