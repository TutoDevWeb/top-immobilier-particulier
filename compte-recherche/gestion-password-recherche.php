<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_random.php");
include("../include/inc_dtb_compte_recherche.php");
include("../include/inc_tracking.php");
include("../include/inc_mail_compte_recherche.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");


filtrer_les_entrees_request(__FILE__,__LINE__);

dtb_connection();
count_cnx();
isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die ;

if ( $action == 'demande_password_oublier' ) {
  isset($_REQUEST['compte_email']) ? $compte_email = trim($_REQUEST['compte_email']) : die ; 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Vous avez oubli� votre mot de passe ?</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
<link href="/styles/global-gestion-connexion.css" rel="stylesheet" type="text/css" />
<script type='text/javascript'  src='/compte-recherche/jvscript/valid_field.js'></script>
<script type='text/javascript'  src='/compte-recherche/jvscript/valid_form.js'></script>
<meta name="robots" content="noindex,nofollow" />
</head>
<body>
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
    <div id='userpan'>
      <div id='gauche'><?PHP print_cibleclick_120_600();  ?></div> 
      <div id='droite'><?PHP print_cibleclick_120_600();  ?></div> 
        <?PHP make_ariane_compte_recherche('Mot de passe oubli�'); ?>
        <?PHP
        /* Les demandes de connexion qui arrivent ici sont des echecs */
        if      ( $action == 'print_form_password_oublier' ) {

          print_compte_recherche_password_oublier(); 
          tracking(CODE_CTR,'OK',"Affichage formulaire mot de passe oubli�",__FILE__,__LINE__);

        /* Traitement de la demande d'envoie du mail de connexion */
        } else if ( $action == 'demande_password_oublier' ) {

          if ( compte_recherche_existe($compte_email,__FILE__,__LINE__) ) {
                    
            echo "<p class='allo_reponse'>Un email a �t� envoy� � $compte_email</p>\n";
            mail_password_compte_recherche($compte_email);
            tracking(CODE_CTR,'OK',"$compte_email:demande_password_oublier:email envoy�",__FILE__,__LINE__);

          } else {
            echo "<p class='allo_reponse'>Nous ne retrouvons pas cet email dans notre base<br/>$compte_email</p>";
            print_compte_recherche_password_oublier();
            tracking(CODE_CTR,'OK',"$compte_email:demande_password_oublier:email inconnu dans cette base",__FILE__,__LINE__);
          }

        }

        echo "<p><a href='/' class='nav_ico11' title=\"Pour aller � l'accueil cliquer sur ce lien\">Pour aller � l'accueil cliquer sur ce lien</a></p>\n";

        echo "<p><a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche' class='nav_ico11' title='Pour acc�der � votre compte recherche cliquer sur ce lien'>Pour acc�der � votre compte recherche cliquer sur ce lien</a></p>";

        print_xiti_code("gestion-passsword-recherche");

        print_cible_unifinance_300_250();

        ?>
			<div id='clearboth'>&nbsp;</div>
    </div><!-- end userpan -->
  </div><!-- end mainpan -->
  <div id='footerpan'></div>
</body>
</html>
<?PHP
/*--------------------------------------------------------------------------------------------------------*/
function print_compte_recherche_password_oublier() {
?>
    <form action="<?PHP echo $_SERVER['PHP_SELF'] ?>" method='get' onsubmit="return valid_form_password();"> 
      <fieldset><legend>Vous avez oubli� votre mot de passe ?</legend>
      <p><label for='password_compte_email'>Votre email</label>&nbsp;&nbsp;<input id='password_compte_email' name='compte_email' type='text' size="25" maxlength="128" /></p>
      <input type='hidden' name='action' value='demande_password_oublier' />
      <input  class='but_input' type='submit' value="Retrouver mon mot de passe"/>
      </fieldset>
    </form>
<?PHP
}
?>