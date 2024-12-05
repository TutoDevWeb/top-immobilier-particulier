<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) exit;

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_ariane.php");
include("../include/inc_tracking.php");
include("../include/inc_cibleclick.php");


dtb_connection();

if (!filtrer_les_entrees_get(__FILE__,__LINE__)) die; 
if (!filtrer_les_entrees_post(__FILE__,__LINE__)) die;

if ( $_REQUEST['action'] == 'enregistrer' ) enregistrer();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Positionnement sur la Carte</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
<link href="/styles/global-compte-annonce.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/jvscript/popup.js'></script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script>
<?PHP initialiser_geolocalisateur(); ?>
<script type="text/javascript">
var map;
var geocoder;

//------------------------------------------------------------------------------------------------
function initialize() {
  map = new GMap2(document.getElementById("map_canvas"));
  var point = new GLatLng(init_lat,init_lng);
  map.setCenter(point,init_scale);
  map.addControl(new GLargeMapControl());
  geocoder = new GClientGeocoder();
  set_marker(point);
}
//------------------------------------------------------------------------------------------------
// Si il y a une position initiale on appelle cette fonction
function set_marker(point) {
  marker = new GMarker(point);
  map.addOverlay(marker);
  marker.openInfoWindowHtml(zone_ville+'<br/><br/>'+zone_add);
}
//------------------------------------------------------------------------------------------------
// addAddressToMap() is called when the geocoder returns an
// answer.  It adds a marker to the map with an open info window
// showing the nicely formatted version of the address and the country code.
function addAddressToMap(response) {
  map.clearOverlays();
  if (!response || response.Status.code != 200) {
    alert("D�sol�, nous ne sommes pas capable de localiser cette adresse\nEssayer une autre adresse approchante ou Faire une autre formulation");
  } else {
    place = response.Placemark[0];

    point = new GLatLng(place.Point.coordinates[1],
                        place.Point.coordinates[0]);

    document.enregistrer.maps_lat.value = point.lat();                    
    document.enregistrer.maps_lng.value = point.lng();
    document.enregistrer.quart.value = document.rechercher.quart.value ;
    map.setCenter(point, 15);
                    
    marker = new GMarker(point);
    map.addOverlay(marker);
    marker.openInfoWindowHtml(place.address + '<br/>' +
    '<strong>Country code:</strong> ' + place.AddressDetails.Country.CountryNameCode);
  }
}
//------------------------------------------------------------------------------------------------
// showLocation() is called when you click on the Search button
// in the form.  It geocodes the address entered into the form
// and adds a marker to the map at that location.
function showLocation() {

  /*
  if      ( zone_ard == 0 ) var address = document.rechercher.quart.value +' , '+zone_ville+' , '+zone_add ;
  else if ( zone_ard == 1 ) var address = document.rechercher.quart.value +', 13001 1 er arrondissement , '+zone_ville+' , '+zone_add ;
  else                      var address = document.rechercher.quart.value +' , '+zone_ard+' �me arrondissement , '+zone_ville+' , '+zone_add ;
  Le localisateur ne r�pond pas si on met un arropndissement  
  */
	
	
  var address = document.rechercher.quart.value +' , '+zone_ville+' , '+zone_add ;

	window.alert("On recherche \n\n"+address);
  geocoder.getLocations(address, addAddressToMap);
}
//------------------------------------------------------------------------------------------------
window.onload = initialize;
</script>
</head>
<body>
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
    <div id='userpan'>
		  <div id='usermaps'>
    <?PHP
    if ( data_en_session_ok() ) {
    make_ariane_maps($_SESSION['zone']);
	  ?>
      <form id='rechercher' name="rechercher" action="#" onSubmit="showLocation(); return false;">
        <fieldset>
          <legend><strong>(1)</strong> Positionner votre logement</legend>
          <div class='do'>votre num�ro ( * optionnel ) , votre rue</div>
          <div class='do'> 
            <input type="text" id='quart' name="quart" value="<?PHP echo $_SESSION['quart']; ?>" size="40" maxlength="40">
            <div class='do'>(Le texte saisi ici appara�t sur l'annonce)</div>
            <input name="sub_recherche" class="but_input" type="submit" value="Rechercher">
          </div>
        </fieldset>
      </form>
			<p><em>( * si vous n'arrivez pas � positionner votre logement.<br />
			Merci de terminer l'annonce et de mailer l'adresse au webmaster )</em></p>			
      <div id='map_canvas'></div>
      <form id='enregistrer' name="enregistrer" action="<?PHP echo $_REQUEST['PHP_SELF']; ?>">
        <fieldset>
          <legend><strong>(2)</strong> Enregistrer votre position</legend>
          <input type="hidden" id='maps_lat' name="maps_lat" value="<?PHP echo $_SESSION['maps_lat']; ?>">
          <input type="hidden" id='maps_lng' name="maps_lng" value="<?PHP echo $_SESSION['maps_lng']; ?>">
          <input type="hidden" id='quart' name="quart"    value="<?PHP echo $_SESSION['quart']; ?>">
          <input type="hidden" name="action"   value="enregistrer">
          <input type="submit" class="but_input" name="sub_enregistrer" value="Enregistrer">
        </fieldset>
      </form>
      <?PHP 
		  } else print_if_no_data();
		  ?>
			</div><!-- end usermaps -->
    </div><!-- end userpan -->
  </div><!-- end mainpan -->
  <div id='footerpan'></div>
</body>
</html>
<?PHP
function initialiser_geolocalisateur() {

	tracking_session_annonce(CODE_CTA,'OK',"Entr�e dans Gerer les Cartes",__FILE__,__LINE__);

  // Dans les deux cas il faut r�cup�rer la zone aditionnelle
  if ( $_SESSION['zone_dept'] == $_SESSION['zone_region'] ) $zone_add = $_SESSION['zone_region'].' ,  France';
	else $zone_add = $_SESSION['zone_dept'].' ,  '.$_SESSION['zone_region'].' ,  France';

  echo "<script language='JavaScript'>\n";

  // Dans ce cas il faut restaurer le point qui est en session
  // Le Quart est connu
  if ( isset($_SESSION['maps_actif']) && $_SESSION['maps_actif'] == 1 )  {


    // On positionne une variable pour que le geolocalisateur sache ce qu'il doit faire  
    echo "var maps_actif = 1;\n";
    
    printf("var init_lat = %s;\n",$_SESSION['maps_lat']);
    printf("var init_lng = %s;\n",$_SESSION['maps_lng']);
    echo "var init_scale = 15;\n";

    // L'adresse est en 3 ou 4 parties : Quartier / Arrondissement /Ville / Zone additionnelle
    printf("var quart = '%s';\n",addslashes($_SESSION['quart']));
    printf("var zone_ard = '%d';\n",addslashes($_SESSION['zone_ard']));
    printf("var zone_ville = '%s';\n",addslashes($_SESSION['zone_ville']));
    printf("var zone_add  = '%s';\n",addslashes($zone_add));

    $quart = $_SESSION['quart']; 
    tracking_session_annonce(CODE_CTA,'OK',"Initialisation du geolocalisateur � l'adresse => $quart",__FILE__,__LINE__);

      
  } else {
  
    echo "var maps_actif = 0;\n";

    // Il faut lire les coordonn�es de la ville dans la database
    get_lat_lng($_SESSION['zone_ville'],$_SESSION['zone_dept'],&$ville_lat,&$ville_lng);

    printf("var init_lat   = %f;\n",$ville_lat);
    printf("var init_lng   = %f;\n",$ville_lng);
    echo "var init_scale = 12;\n";

    // L'adresse est en 3 parties : Arrondissement / Ville / Zone additionnelle
		// Le Quartier va �tre saisi par l'utilisateur
    printf("var zone_ard = '%d';\n",addslashes($_SESSION['zone_ard']));
    printf("var zone_ville = '%s';\n",addslashes($_SESSION['zone_ville']));
    printf("var zone_add  = '%s';\n",addslashes($zone_add));

    tracking_session_annonce(CODE_CTA,'OK',"Initialisation du geolocalisateur => Pas d'adresse connue",__FILE__,__LINE__);

  }

  echo  "</script>\n";

}
// Mattre les valeurs de la localisation en session puis aller sur la fiche
function enregistrer() {

  if ( $_REQUEST['maps_lat'] != '' && $_REQUEST['maps_lng'] != '' ) {


    $_SESSION['maps_lat']   = $_REQUEST['maps_lat'];
    $_SESSION['maps_lng']   = $_REQUEST['maps_lng'];
    $_SESSION['maps_actif'] = 1;
    $_SESSION['quart']      = trim($_REQUEST['quart']);

    $quart = $_SESSION['quart'];

    tracking_session_annonce(CODE_CTA,'OK',"Enregistrement de la localisation : $quart",__FILE__,__LINE__);

    goto("/compte-annonce/fiche.php");

  }

}
//------------------------------------------------------------------------------------------------
function get_lat_lng($ville,$dept,&$ville_lat,&$ville_lng) {

  $ville_s = mysqli_real_escape_string($ville);
  $dept_s = mysqli_real_escape_string($dept);

  $query = "SELECT v.ville_lat,v.ville_lng FROM loc_ville as v, loc_departement as d WHERE v.ville LIKE '$ville_s' AND v.idd = d.idd AND d.dept='$dept_s'";
  $result = dtb_query($query,__FILE__,__LINE__,0);
  list($ville_lat,$ville_lng) = mysqli_fetch_row($result);

}

?>
