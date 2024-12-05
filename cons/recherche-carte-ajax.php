<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_tracking.php");
include("../include/inc_where_condition.php");

dtb_connection();

isset($_REQUEST['action']) ? $action = mysqli_real_escape_string(trim($_REQUEST['action']))   : die ;

if ( $action == 'get_estate_list' ) {

  // Param�tres obligatoites
  isset($_REQUEST['ne_lat']) ? $ne_lat = mysqli_real_escape_string(trim($_REQUEST['ne_lat']))   : die ;
  isset($_REQUEST['ne_lng']) ? $ne_lng = mysqli_real_escape_string(trim($_REQUEST['ne_lng']))   : die ;
  isset($_REQUEST['sw_lat']) ? $sw_lat = mysqli_real_escape_string(trim($_REQUEST['sw_lat']))   : die ;
  isset($_REQUEST['sw_lng']) ? $sw_lng = mysqli_real_escape_string(trim($_REQUEST['sw_lng']))   : die ;

  // Param�tres optionnel du filtrage
  isset($_REQUEST['typp'])   ? $typp = mysqli_real_escape_string(trim($_REQUEST['typp']))   : $typp = '0' ;
  isset($_REQUEST['P1'])     ? $P1   = mysqli_real_escape_string(trim($_REQUEST['P1']))     : $P1   = '0' ;
  isset($_REQUEST['P2'])     ? $P2   = mysqli_real_escape_string(trim($_REQUEST['P2']))     : $P2   = '0' ;
  isset($_REQUEST['P3'])     ? $P3   = mysqli_real_escape_string(trim($_REQUEST['P3']))     : $P3   = '0' ;
  isset($_REQUEST['P4'])     ? $P4   = mysqli_real_escape_string(trim($_REQUEST['P4']))     : $P4   = '0' ;
  isset($_REQUEST['P5'])     ? $P5   = mysqli_real_escape_string(trim($_REQUEST['P5']))     : $P5   = '0' ;

  isset($_REQUEST['sur_min'])  ? $sur_min  = mysqli_real_escape_string($_REQUEST['sur_min'])  : $sur_min  = '0' ;
  isset($_REQUEST['prix_max']) ? $prix_max = mysqli_real_escape_string($_REQUEST['prix_max']) : $prix_max = '0' ;

  //$deb = 0;
  //$fin = 100;

  $query   = "SELECT ida,tel_ins,zone_dept,zone_ville,zone_ard,num_dept,typp,nbpi,prix,surf,quart,blabla,maps_lat,maps_lng FROM ano WHERE ";

  $where_condition = ''; 
  make_where_condition_with_maps($where_condition,$sw_lat,$sw_lng,$ne_lat,$ne_lng);
  make_where_condition_with_typp($where_condition,$typp);
  make_where_condition_with_nbpi($where_condition,$P1,$P2,$P3,$P4,$P5);
  make_where_condition_with_sur_min($where_condition,$sur_min);
  make_where_condition_with_prix_max($where_condition,$prix_max);

  //$where_condition .= " LIMIT $deb,$fin";

  $query .= $where_condition;

  tracking_dtb($query,__FILE__,__LINE__);
  
  $result  = dtb_query($query,__FILE__,__LINE__,0);

  if ( mysqli_num_rows($result) ) {

    $liste = '[';
    while ( list($ida,$tel_ins,$zone_dept,$zone_ville,$zone_ard,$num_dept,$typp,$nbpi,$prix,$surf,$quart,$blabla,$maps_lat,$maps_lng) = mysqli_fetch_row($result) ) {
      $zone_ville = addslashes($zone_ville);
      $zone_dept  = addslashes($zone_dept);
      $quart      = addslashes($quart);
      $quart     = process_special_char($quart);
      $blabla     = addslashes($blabla);
      $blabla     = process_special_char($blabla);
      
      $liste = $liste."{'ida':'$ida','tel_ins':'$tel_ins','zone_dept':'$zone_dept','zone_ville':'$zone_ville','zone_ard':'$zone_ard','num_dept':'$num_dept','typp':'$typp','nbpi':'$nbpi','prix':'$prix','surf':'$surf','quart':'$quart','blabla':'$blabla','lat':'$maps_lat','lng':'$maps_lng'} ,";
    }
    $liste = substr($liste,0,-1);
    $liste .= ']';
    echo "$liste";
  } else echo "[]";
  die;
}
//--------------------------------------------------------------------------------
if ( $action == 'get_nb_ano_total' ) {

  // Param�tres obligatoites Carte
  isset($_REQUEST['ne_lat']) ? $ne_lat = mysqli_real_escape_string(trim($_REQUEST['ne_lat']))   : die ;
  isset($_REQUEST['ne_lng']) ? $ne_lng = mysqli_real_escape_string(trim($_REQUEST['ne_lng']))   : die ;
  isset($_REQUEST['sw_lat']) ? $sw_lat = mysqli_real_escape_string(trim($_REQUEST['sw_lat']))   : die ;
  isset($_REQUEST['sw_lng']) ? $sw_lng = mysqli_real_escape_string(trim($_REQUEST['sw_lng']))   : die ;

  $query   = "SELECT typp,COUNT(*) FROM ano WHERE ";
  $where_condition = ''; 
  make_where_condition_with_maps(&$where_condition,$sw_lat,$sw_lng,$ne_lat,$ne_lng);
  $query .= $where_condition;
	$query .= " GROUP BY typp";
  tracking_dtb($query,__FILE__,__LINE__);
  $result  = dtb_query($query,__FILE__,__LINE__,0);

  $nb_appartement = 0;
  $nb_loft        = 0;
  $nb_chalet      = 0;
  $nb_maison      = 0;

  while ( list($typp,$nb) = mysqli_fetch_row($result) ) {

    if      ( $typp == VAL_DTB_APPARTEMENT    ) $nb_appartement = $nb;
    else if ( $typp == VAL_DTB_LOFT           ) $nb_loft        = $nb;
    else if ( $typp == VAL_DTB_CHALET         ) $nb_chalet      = $nb;
    else if ( $typp == VAL_DTB_MAISON         ) $nb_maison      = $nb;

  }

  $rep = "";
  if      ( $nb_appartement == 1 ) $rep .= "1 Appartement<br/>";
	else if ( $nb_appartement  > 1 ) $rep .= "$nb_appartement Appartements<br/>";

  if      ( $nb_maison      == 1 ) $rep .= "1 Maison<br/>";
	else if ( $nb_maison       > 1 ) $rep .= "$nb_maison Maisons<br/>";

  if ( $nb_loft > 0 ) $rep .= "$nb_loft Loft<br/>";

  if      ( $nb_chalet      == 1 ) $rep .= "1 Chalet<br/>";
	else if ( $nb_chalet       > 1 ) $rep .= "$nb_chalet Chalets<br/>";

  echo "$rep";
  die;

}
//--------------------------------------------------------------------------------
if ( $action == 'get_nb_ano_select' ) {

  // Param�tres obligatoites Carte
  isset($_REQUEST['ne_lat']) ? $ne_lat = mysqli_real_escape_string(trim($_REQUEST['ne_lat']))   : die ;
  isset($_REQUEST['ne_lng']) ? $ne_lng = mysqli_real_escape_string(trim($_REQUEST['ne_lng']))   : die ;
  isset($_REQUEST['sw_lat']) ? $sw_lat = mysqli_real_escape_string(trim($_REQUEST['sw_lat']))   : die ;
  isset($_REQUEST['sw_lng']) ? $sw_lng = mysqli_real_escape_string(trim($_REQUEST['sw_lng']))   : die ;

  // Param�tres optionnel du filtrage
  isset($_REQUEST['typp'])   ? $typp = mysqli_real_escape_string(trim($_REQUEST['typp']))   : $typp = '0' ;
  isset($_REQUEST['P1'])     ? $P1   = mysqli_real_escape_string(trim($_REQUEST['P1']))     : $P1   = '0' ;
  isset($_REQUEST['P2'])     ? $P2   = mysqli_real_escape_string(trim($_REQUEST['P2']))     : $P2   = '0' ;
  isset($_REQUEST['P3'])     ? $P3   = mysqli_real_escape_string(trim($_REQUEST['P3']))     : $P3   = '0' ;
  isset($_REQUEST['P4'])     ? $P4   = mysqli_real_escape_string(trim($_REQUEST['P4']))     : $P4   = '0' ;
  isset($_REQUEST['P5'])     ? $P5   = mysqli_real_escape_string(trim($_REQUEST['P5']))     : $P5   = '0' ;

  isset($_REQUEST['sur_min'])  ? $sur_min  = mysqli_real_escape_string($_REQUEST['sur_min'])  : $sur_min  = '0' ;
  isset($_REQUEST['prix_max']) ? $prix_max = mysqli_real_escape_string($_REQUEST['prix_max']) : $prix_max = '0' ;

  $query   = "SELECT typp,COUNT(*) FROM ano WHERE ";
  $where_condition = ''; 
  make_where_condition_with_maps($where_condition,$sw_lat,$sw_lng,$ne_lat,$ne_lng);
  make_where_condition_with_typp($where_condition,$typp);
  make_where_condition_with_nbpi($where_condition,$P1,$P2,$P3,$P4,$P5);
  make_where_condition_with_sur_min($where_condition,$sur_min);
  make_where_condition_with_prix_max($where_condition,$prix_max);
  $query .= $where_condition;
	$query .= " GROUP BY typp";
  tracking_dtb($query,__FILE__,__LINE__);
  $result  = dtb_query($query,__FILE__,__LINE__,0);

  $nb_appartement = 0;
  $nb_loft        = 0;
  $nb_chalet      = 0;
  $nb_maison      = 0;

  while ( list($typp,$nb) = mysqli_fetch_row($result) ) {

    if      ( $typp == VAL_DTB_APPARTEMENT    ) $nb_appartement = $nb;
    else if ( $typp == VAL_DTB_LOFT           ) $nb_loft        = $nb;
    else if ( $typp == VAL_DTB_CHALET         ) $nb_chalet      = $nb;
    else if ( $typp == VAL_DTB_MAISON         ) $nb_maison      = $nb;

  }


  $rep = "";
  if      ( $nb_appartement == 1 ) $rep .= "1 Appartement<br/>";
	else if ( $nb_appartement  > 1 ) $rep .= "$nb_appartement Appartements<br/>";

  if      ( $nb_maison      == 1 ) $rep .= "1 Maison<br/>";
	else if ( $nb_maison       > 1 ) $rep .= "$nb_maison Maisons<br/>";

  if ( $nb_loft > 0 ) $rep .= "$nb_loft Loft<br/>";

  if      ( $nb_chalet      == 1 ) $rep .= "1 Chalet<br/>";
	else if ( $nb_chalet       > 1 ) $rep .= "$nb_chalet Chalets<br/>";

  echo "$rep";
  die;

}
//--------------------------------------------------------------------------------
if ( $action == 'get_map_region' ) get_map_region();
//--------------------------------------------------------------------------------
if ( $action == 'get_map_dept'   ) get_map_dept();
//--------------------------------------------------------------------------------
if ( $action == 'get_map_ville'  ) get_map_ville();
//--------------------------------------------------------------------------------
function get_map_ville() {

  isset($_REQUEST['zone_ville']) ? $zone_ville = mysqli_real_escape_string(trim($_REQUEST['zone_ville']))   : die ;
  isset($_REQUEST['zone_dept'])  ? $zone_dept  = mysqli_real_escape_string(trim($_REQUEST['zone_dept']))    : die ;

  $query   = "SELECT v.ville_lat,v.ville_lng,d.dept,r.region FROM loc_ville as v, loc_departement as d, loc_region as r 
              WHERE v.idd=d.idd AND v.idr=r.idr AND v.ville='$zone_ville' AND d.dept='$zone_dept'";
  tracking_dtb($query,__FILE__,__LINE__);
  $result  = dtb_query($query,__FILE__,__LINE__,0);
  list($ville_lat,$ville_lng,$dept,$region) = mysqli_fetch_row($result);

  $dept   = addslashes($dept);
  $region = addslashes($region);

  $rep = "{ 'ville_lat' : '$ville_lat' , 'ville_lng' : '$ville_lng' , 'dept' : '$dept' , 'region' : '$region' , 'zoom' : '11' }"; 

  echo "$rep";
  die;
}
//--------------------------------------------------------------------------------
function get_map_dept() {

  isset($_REQUEST['dept']) ? $dept = mysqli_real_escape_string(trim($_REQUEST['dept']))   : die ;

  $query   = "SELECT d.dept_lat,d.dept_lng,r.region FROM loc_departement as d, loc_region as r 
              WHERE d.idr=r.idr AND d.dept='$dept'";
  tracking_dtb($query,__FILE__,__LINE__);
  $result  = dtb_query($query,__FILE__,__LINE__,0);
  list($dept_lat,$dept_lng,$region) = mysqli_fetch_row($result);

  $region = addslashes($region);

  $rep = "{ 'dept_lat' : '$dept_lat' , 'dept_lng' : '$dept_lng' , 'region' : '$region' , 'zoom' : '9' }"; 

  echo "$rep";
  die;
}
//--------------------------------------------------------------------------------
function get_map_region() {

  isset($_REQUEST['region']) ? $region = mysqli_real_escape_string(trim($_REQUEST['region'])) : die ;

  $query   = "SELECT region_lat,region_lng FROM loc_region WHERE region='$region'";
  tracking_dtb($query,__FILE__,__LINE__);
  $result  = dtb_query($query,__FILE__,__LINE__,0);
  list($region_lat,$region_lng) = mysqli_fetch_row($result);

  $rep = "{ 'region_lat' : '$region_lat' , 'region_lng' : '$region_lng' , 'zoom' : '8' }"; 

  echo "$rep";
  die;
}
//--------------------------------------------------------------------------------
// On va enlever les caract�res sp�ciaux
function process_special_char($word) {  
  
  $word = str_replace('�','e',$word);
  $word = str_replace('�','E',$word);
  $word = str_replace('�','e',$word);
  $word = str_replace('�','e',$word);
  $word = str_replace('�','e',$word);
  $word = str_replace('�','o',$word); 
  $word = str_replace('�','o',$word); 
  $word = str_replace('�','a',$word);
  $word = str_replace('�','a',$word);
  $word = str_replace('�','u',$word);
  $word = str_replace('�','u',$word);
  $word = str_replace('�','u',$word);
  $word = str_replace('�','i',$word);
  $word = str_replace('�','i',$word);
  $word = str_replace('�','c',$word);
  $word = str_replace('�','Euros',$word);
  $word = str_replace('-',' ',$word);
  
  return $word;
}
?>
