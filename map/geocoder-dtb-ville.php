<?PHP

include("../data/data.php");
include("../include/inc_base.php");


//----------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'set_ville') {

	isset($_POST['ville'])      ? $ville      = addslashes(trim($_POST['ville']))      : die;
	isset($_POST['lat'])        ? $lat        = $_POST['lat']                          : die;
	isset($_POST['lng'])        ? $lng        = $_POST['lng']                          : die;
	isset($_POST['maps_code'])  ? $maps_code  = $_POST['maps_code']                    : die;
	isset($_POST['address_GG']) ? $address_GG = addslashes(utf8_decode(trim($_POST['address_GG']))) : die;

	dtb_connection();
	$query  = "UPDATE loc_ville SET ville_lat='$lat',ville_lng='$lng',maps_code='$maps_code',address_GG='$address_GG' WHERE ville='$ville'";
	dtb_query($query, __FILE__, __LINE__, 0);
	echo 'OK';
	die;
}

//----------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'get_zone') {
	isset($_POST['dept_num']) ? $dept_num = trim($_POST['dept_num']) : die;
	dtb_connection();
	$query  = "SELECT d.dept,r.region FROM loc_departement as d,loc_region as r WHERE d.idr = r.idr AND d.dept_num='$dept_num'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	list($dept, $region) = mysqli_fetch_row($result);
	echo "$dept , $region , France";
	die;
}


//----------------------------------------------------------------------------
isset($_POST['action']) ? $action = trim($_POST['action']) : $action = '';
if ($action == 'get_list_ville') {
	isset($_POST['dept_num']) ? $dept_num = trim($_POST['dept_num']) : die;
	dtb_connection();
	$query  = "SELECT v.ville FROM loc_ville as v,loc_departement as d WHERE v.idd = d.idd AND d.dept_num='$dept_num'";
	$result = dtb_query($query, __FILE__, __LINE__, 0);
	$liste = '[';
	while (list($ville) = mysqli_fetch_row($result)) {
		$ville = addslashes($ville);
		$liste = $liste . "'$ville',";
	}
	$liste = substr($liste, 0, -1);
	$liste .= ']';
	echo "$liste";
	die;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Geocodage des villes</title>
	<meta charset="UTF-8">
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTASDNGt1Ah7UMjIzjNf91KosJQYhT2_N2tGBVmUwT_PKT4VUzPoyhomg" type="text/javascript"></script>
</head>

<body>
	<script type="text/JavaScript">
		var geocoder = new GClientGeocoder();
var zone = ''; // Contiendra le nom du d�partement , la r�gion et enfin France
var list_ville = Array();
var idv=0;
//---------------------------------------------------------------------------------
var maps_code = 0;  
// 0 valeur initiale on a rien fait
// 1 Tout est OK
// 2 le serveur a r�pondu qu'il ne trouvait pas d'adresse
// 3 le programme n'a pas trouv� france dans l'adresse renvoy�e par le serveur



//---------------------------------------------------------------------------------
// Fait une requ�te synchr�ne pour r�cup�rer le nom du d�partement et de la r�gion
function get_zone(dept_num) {

	var xhr = new XMLHttpRequest();               
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
			  console.log(xhr.responseText);
        zone = xhr.responseText;
      } else window.alert(xhr.status); 
    }
  }; 

  xhr.open( "POST", "/map/geocoder-dtb-ville.php",false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=get_zone&dept_num='+dept_num); 

}
//---------------------------------------------------------------------------------
function get_list_ville(dept_num) {

  window.alert(dept_num);
	
	var xhr = new XMLHttpRequest();
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
			  console.log(xhr.responseText);
        list_ville = eval ('('+xhr.responseText+')');
				//for ( var i in list_ville ) {
			    //console.log(list_ville[i]);
				//}
				idv=0;
				timeInterval = setInterval(send_geocoder_request,5000); 
      } else window.alert(xhr.status); 
    }
  }; 

  xhr.open( "POST", "/map/geocoder-dtb-ville.php",  false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=get_list_ville&dept_num='+dept_num); 

}
//---------------------------------------------------------------------------------
function send_geocoder_request() {

  var location = list_ville[idv]+' , '+zone;

  geocoder.getLocations(location, addAddressToMap);
  console.log("Envoi d'une requ�te vers GG_MAP : "+location);


}
//---------------------------------------------------------------------------------
function addAddressToMap(response) {
  maps_code = 0;
  var ville = list_ville[idv];


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

        if ( idv == (list_ville.length-1) ) clearInterval(timeInterval);
				idv++;

      } else window.alert(xhr.status); 
    }
  }; 
	

  xhr.open( "POST", "/map/geocoder-dtb-ville.php",  false); 
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xhr.send('action=set_ville&ville='+ville+'&lat='+lat+'&lng='+lng+'&maps_code='+maps_code+'&address_GG='+address_GG); 

}
//---------------------------------------------------------------------------------

//get_zone('06');
//get_list_ville('06');

get_zone('13');
get_list_ville('13');


//get_zone('83');
//get_list_ville('83');

</script>
</body>

</html>