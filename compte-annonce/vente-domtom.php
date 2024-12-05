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
include("../include/inc_tracking.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");

filtrer_les_entrees_post(__FILE__,__LINE__);
filtrer_les_entrees_request(__FILE__,__LINE__);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : die; 

dtb_connection();
count_cnx();


// Si c'est une reprise on ne met pas l'index
if ( is_reprise() ) $link_index = false;
else $link_index = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Entre particuliers dans les Dom-Tom</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
<link href="/styles/global-vente.css" rel="stylesheet" type="text/css" />
<meta name="Description" content="Vendre entre particuliers dans les Dom-Tom avec TOP-IMMOBILIER-PARTICULIERS.FR" />
<script type="text/javascript" src="/compte-annonce/jvscript/valid_field.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/nbcar.js"></script>
<script type="text/javascript" src="/compte-annonce/jvscript/valid_form_ano.js"></script>
</head>
<body>
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
    <div id="userpan">
      <?PHP make_ariane_passer_annonce('domtom'); ?>
      <div id='vente' style='background:  url(/images/fond-palmier-paillote.jpg) no-repeat bottom right'>
        <h1>Entre particuliers dans les Dom-Tom</h1>
        <div id='titre'>Déposer une offre de vente de studio, appartement, maison dans les Dom Tom</div>
                <?PHP
                if ( $action == 'print_form' ) {
                  print_ano_form('domtom');
                  tracking(CODE_CTA,'OK',"Entrée sur formulaire création vente domtom",__FILE__,__LINE__);
                  restore_session();
                }
                if ( $action == 'store_session' ) {
                  if ( !compte_annonce_existe($_POST['tel_ins'],__FILE__,__LINE__) || is_modif() ) {

                    // Vérifier les codes
                    if ( $_POST['code_set'] == $_POST['code_get'] ) {
                      store_session();
                      goto('fiche.php');          
                    }      
                  } else deja_annonce();
                }

                print_xiti_code('form-vente-domtom');
                ?>
      </div><!-- end vente -->    
    </div><!-- end userpan -->
  </div><!-- end mainpan -->
  <div id='footerpan'></div>
</body>
</html>
