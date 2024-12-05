<?PHP
session_start();
include("../data/data.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");
include("../include/inc_ano_form.php");
include("../include/inc_ariane.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_session.php");
include("../include/inc_base.php");
include("../include/inc_random.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_count_cnx.php");
include("../include/inc_tracking.php");
include("../include/inc_xiti.php");

filtrer_les_entrees_post(__FILE__,__LINE__);
filtrer_les_entrees_request(__FILE__,__LINE__);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : die;

//----------------------------------------------------------------------------
// R�ponse � la requ�te Ajax qui fait le select des d�partements
//----------------------------------------------------------------------------
if ( $action == 'get_liste_num_dept' ) {
    dtb_connection();
    $query  = "SELECT dept_num,dept FROM loc_departement ORDER BY dept_num ASC";
    $result = dtb_query($query,__FILE__,__LINE__,0);
    tracking_dtb($query,__FILE__,__LINE__);
    $liste = '[';
    while ( list($dept_num,$dept) = mysqli_fetch_row($result) ) {
      $dept = addslashes($dept);
      $liste = $liste."{'dept_num':'$dept_num','dept':'$dept'},";
    }
    $liste = substr($liste,0,-1);
    $liste .= ']';
    echo "$liste";
    die;
}
//----------------------------------------------------------------------------
// R�ponse � la requ�te Ajax qui fait le select des villes
//----------------------------------------------------------------------------
if ( $action == 'get_ville_in_dept' ) {
    isset($_POST['dept_num']) ? $dept_num = trim($_POST['dept_num']) : die;
    dtb_connection();
    $query  = "SELECT v.ville,v.nb_ard FROM loc_ville as v,loc_departement as d WHERE v.maps_code=1 AND v.idd = d.idd AND d.dept_num='$dept_num' ORDER BY v.ville ASC";
    $result = dtb_query($query,__FILE__,__LINE__,0);
    tracking_dtb($query,__FILE__,__LINE__);
    $liste = '[';
    while ( list($ville,$nb_ard) = mysqli_fetch_row($result) ) {
      $ville = addslashes($ville);
      $liste = $liste."{ 'ville' : '$ville' , 'nb_ard' : '$nb_ard' } ,";
    }
    $liste = substr($liste,0,-1);
    $liste .= ']';
    echo "$liste";
    die;
}
  


dtb_connection();
count_cnx();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Vendre de particulier � particulier en France</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
<link href="/styles/global-vente.css" rel="stylesheet" type="text/css" />
<meta name="Description" content="Vendre en france de particuliers � particuliers avec TOP-IMMOBILIERS-PARTICULIERS.FR" />
<script type="text/javascript" src="/jvscript/browser.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/valid_field.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/nbcar.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/valid_form_ano.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/select_dept.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/select_ville.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/select_ard.js"></script>
<script type="text/javascript">
function start() {
  sd.fill();
  print_nbcar();
}
</script>
<?PHP
if ( $action == 'print_form' ) {

  $zd = (isset($_SESSION['num_dept'])   && $_SESSION['num_dept']   != '') ? $_SESSION['num_dept']              :  0 ;
  $zv = (isset($_SESSION['zone_ville']) && $_SESSION['zone_ville'] != '') ? addslashes($_SESSION['zone_ville']) : '' ;
  $za = (isset($_SESSION['zone_ard'])   && $_SESSION['zone_ard']   != '') ? $_SESSION['zone_ard']               :  0 ;

  echo "<script type='text/javascript'>\n";
  
  //Instanciation de l'objet browser
  printf("var browser = new Browser();\n");
  printf("var sd = new select_dept('$zd');\n");
  printf("var sv = new select_ville('$zv',$za);\n");
  printf("var sa = new select_ard($za);\n");
  echo "window.onload = start;";
  echo  "</script>\n";
}
?>
</head>
<body>
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
    <div id='userpan'>
      <?PHP make_ariane_passer_annonce('france'); ?>
      <div id='vente' style='background:  url(/images/fond-tour.jpg) no-repeat bottom right'>
        <h1>Vendre de particulier &agrave; Particulier en France</h1>
        <div id='titre'>D�poser une offre de vente de studio, appartement, maison en France</div>
                <?PHP
                /*
								print_r($_POST);
                echo "<p>&nbsp;</p>\n";
                echo "<p>&nbsp;</p>\n";
                echo "<p>&nbsp;</p>\n";*/
                if ( $action == 'print_form' ) {
                  print_ano_form('france');
                  tracking(CODE_CTA,'OK',"Entr�e sur formulaire cr�ation vente france",__FILE__,__LINE__);
                  restore_session();
                }
                if ( $action == 'store_session' ) {
                  if ( !compte_annonce_existe($_POST['tel_ins'],__FILE__,__LINE__) || is_modif() ) {

                    // V�rifier les codes
                    if ( $_POST['code_set'] == $_POST['code_get'] ) {
                      store_session();
                      goto('fiche.php');          
                    }      
                  } else deja_annonce();
                }
                print_xiti_code('form-vente-france');
                ?>
                
      <p><a href="http://www.parcsdelagdal.com/"  title="Agence Immobili�re � Marrakech" target="_blank">Immobilier Marrakech</a></p>
      </div><!-- end vente -->    
    </div><!-- end userpan -->
  </div><!-- end mainpan -->
  <div id='footerpan'></div>
</body>
</html>
