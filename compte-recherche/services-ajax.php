<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_dtb_compte_recherche.php");
include("../include/inc_tracking.php");
include("../include/inc_filter.php");

filtrer_les_entrees_request(__FILE__,__LINE__);
dtb_connection();

isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die ;

$idc = get_idc(&$compte_email,&$compte_pass);

if ( $idc !== false ) {

  if ( $action == 'memoriser_financement' ) {
    check_arg_financement(&$fixe,&$credit,&$apport,&$taux_annuel,&$nb_annee);
    if ( memoriser_financement($idc,$fixe,$credit,$apport,$taux_annuel,$nb_annee,__FILE__,__LINE__) === true ) {
      tracking(CODE_CTR,'OK',"Service Financement Mémorisation:$compte_email:$compte_pass",__FILE__,__LINE__);
      echo "ok_memoriser_financement";
    } else {
      tracking(CODE_CTR,'KO',"Service Financement Mémorisation:$compte_email:$compte_pass:ko_memoriser_financement",__FILE__,__LINE__);
		  echo "ko_memoriser_financement";
    }
    die;
  }

  if ( $action == 'creer_alerte_recherche' ) {
    check_arg_alerte_recherche(&$zone,&$zone_pays,&$zone_dom,&$zone_region,&$zone_dept,&$zone_ville,&$zone_ard,&$dept_voisin,&$typp,&$P1,&$P2,&$P3,&$P4,&$P5,&$sur_min,&$prix_max);
    if ( creer_alerte_recherche($idc,$zone,$zone_pays,$zone_dom,$zone_region,$zone_dept,$zone_ville,$zone_ard,$dept_voisin,$typp,$P1,$P2,$P3,$P4,$P5,$sur_min,$prix_max,__FILE__,__LINE__) == true ) {
      tracking(CODE_CTR,'OK',"Service Alertes Recherche:$compte_email:$compte_pass:création",__FILE__,__LINE__);
      echo "ok_alerte_recherche";
    } else {
      tracking(CODE_CTR,'KO',"Service Alertes Recherche:$compte_email:$compte_pass:ko_alerte_recherche",__FILE__,__LINE__);
		  echo "ko_alerte_recherche";
    }
    die;
  }

  if ( $action == 'creer_alerte_baisse' ) {
    check_arg_alerte_baisse(&$tel_ins,&$prix);
    if ( creer_alerte_baisse($idc,$tel_ins,$prix,__FILE__,__LINE__) === true ) {
      tracking(CODE_CTR,'OK',"Service Alertes Baisse:$compte_email:$compte_pass:création",__FILE__,__LINE__);
      echo "ok_alerte_baisse";
    } else {
      tracking(CODE_CTR,'KO',"Service Alertes Baisse:$compte_email:$compte_pass:ko_alerte_baisse",__FILE__,__LINE__);
		  echo "ko_alerte_baisse";
    }
		die;
  }

}

/*----------------------------------------------------------------------------------------------------*/
function check_arg_alerte_baisse($tel_ins,$prix) {

  isset($_REQUEST['tel_ins'])      ? $tel_ins      = trim($_REQUEST['tel_ins'])      : die ; 
  isset($_REQUEST['prix'])         ? $prix         = trim($_REQUEST['prix'])         : die ; 

}
/*----------------------------------------------------------------------------------------------------*/
function check_arg_alerte_recherche($zone,$zone_pays,$zone_dom,$zone_region,$zone_dept,$zone_ville,$zone_ard,$dept_voisin,$typp,$P1,$P2,$P3,$P4,$P5,$sur_min,$prix_max) {

  // Paramètres concernant la zone géographique
  isset($_REQUEST['zone'])        ? $zone          = trim($_REQUEST['zone'])        : die ; 
  isset($_REQUEST['zone_pays'])   ? $zone_pays     = trim($_REQUEST['zone_pays'])   : $zone_pays   = '' ; 
  isset($_REQUEST['zone_dom'])    ? $zone_dom      = trim($_REQUEST['zone_dom'])    : $zone_dom    = '' ; 
  isset($_REQUEST['zone_region']) ? $zone_region   = trim($_REQUEST['zone_region']) : $zone_region = '' ; 
  isset($_REQUEST['zone_dept'])   ? $zone_dept     = trim($_REQUEST['zone_dept'])   : $zone_dept   = '' ; 
  isset($_REQUEST['zone_ville'])  ? $zone_ville    = trim($_REQUEST['zone_ville'])  : $zone_ville  = '' ; 
  isset($_REQUEST['zone_ard'])    ? $zone_ard      = trim($_REQUEST['zone_ard'])    : $zone_ard    = '' ;
  isset($_REQUEST['zone_dept'])   ? $zone_dept     = trim($_REQUEST['zone_dept'])   : $zone_dept   = '' ; 
  isset($_REQUEST['dept_voisin']) ? $dept_voisin   = trim($_REQUEST['dept_voisin']) : $dept_voisin = '' ; 

  // Paramètres concernant le produit
  isset($_REQUEST['typp'])      ? $typp     = trim($_REQUEST['typp']) : $typp     = '0' ;
  isset($_REQUEST['P1'])        ? $P1       = trim($_REQUEST['P1'])   : $P1       = '0' ;
  isset($_REQUEST['P2'])        ? $P2       = trim($_REQUEST['P2'])   : $P2       = '0' ;
  isset($_REQUEST['P3'])        ? $P3       = trim($_REQUEST['P3'])   : $P3       = '0' ;
  isset($_REQUEST['P4'])        ? $P4       = trim($_REQUEST['P4'])   : $P4       = '0' ;
  isset($_REQUEST['P5'])        ? $P5       = trim($_REQUEST['P5'])   : $P5       = '0' ;
  isset($_REQUEST['sur_min'])   ? $sur_min  = $_REQUEST['sur_min']    : $sur_min  = '0' ;
  isset($_REQUEST['prix_max'])  ? $prix_max = $_REQUEST['prix_max']   : $prix_max = '0' ;

}
/*----------------------------------------------------------------------------------------------------*/
function check_arg_financement($fixe,$credit,$apport,$taux_annuel,$nb_annee) {

  isset($_REQUEST['fixe'])        ? $fixe        = trim($_REQUEST['fixe'])        : die ; 
  isset($_REQUEST['credit'])      ? $credit      = trim($_REQUEST['credit'])      : die ; 
  isset($_REQUEST['apport'])      ? $apport      = trim($_REQUEST['apport'])      : die ; 
  isset($_REQUEST['taux_annuel']) ? $taux_annuel = trim($_REQUEST['taux_annuel']) : die ; 
  isset($_REQUEST['nb_annee'])    ? $nb_annee    = trim($_REQUEST['nb_annee'])    : die ; 

}
?>