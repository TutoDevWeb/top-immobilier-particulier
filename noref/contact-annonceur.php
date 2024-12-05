<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_filter.php");
include("../include/inc_tracking.php");
include("../include/inc_random.php");
include("../include/inc_cibleclick.php");
include("../include/inc_mail_compte_annonce.php");
include("../include/inc_dtb_compte_annonce.php");

// On doit impérativement savoir ce qu'on fait (action) et le type du contact (contact_type)
isset($_REQUEST['action'])       ? $action        = $_REQUEST['action']        : die;

// Seules les deux actions sont possibles
if ( $action != 'print_form' && $action != 'send_mail' ) die; 

// Vérification des arguments dans le cas de l'action 'print_form'
if ( $action == 'print_form' ) {
    isset($_REQUEST['tel_ins']) ? $tel_ins = $_REQUEST['tel_ins'] : die;;
}

// Vérification des arguments dans le cas de l'action 'send_mail'
if ( $action == 'send_mail' ) {

    ( isset($_REQUEST['tel_ins'])   &&   trim($_REQUEST['tel_ins']) != "" )   ? $tel_ins    = $_REQUEST['tel_ins']     : die;
    ( isset($_REQUEST['mail_from']) &&   trim($_REQUEST['mail_from']) != "" ) ? $mail_from  = $_REQUEST['mail_from']   : die;
    ( isset($_REQUEST['message'])   &&   trim($_REQUEST['message']) != "" )   ? $message    = $_REQUEST['message']     : die;
    ( isset($_REQUEST['code_get'])  &&   trim($_REQUEST['code_get']) != "" )  ? $code_get   = $_REQUEST['code_get']    : die;

}

dtb_connection();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Contact Annonceur</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
<link href="/styles/global-dialog.css" rel="stylesheet" type="text/css" />
<meta name="robots" content="noindex,nofollow" />
<script type='text/javascript' src='jvscript/valid_contact.js'></script>
</head>
<body>
  <div id='contact_ano'>
    <?PHP
    if ( $action == 'send_mail' ) {
      if ( $code_get == $_SESSION['code_set'] ) {
        $ok = mail_contact_annonceur($tel_ins,$mail_from,$message,$trace=false);
        confirmation_ecran($ok);
      }
    } else if ( $action == 'print_form' ) print_form_mail($tel_ins);
    ?>
  </div> <!-- end contact -->
</body>
</html>
<?PHP
function print_form_mail($tel_ins) {
  $_SESSION['code_set'] = code_generator(4);
?>
  <form method='post' action="<?PHP echo $_SERVER['PHP_SELF'];  ?>" onsubmit='return valid_contact();'>
   <table id='input_mail'>
    <tr> 
      <td bgcolor='#3399CC' height='70'>
        <p class='text12wb'><img src='/images/pdm-120x60.gif' align='middle' alt='SANS_AGENCES.COM' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contacter l'annonceur</p>
      </td>
    </tr>
    <tr> 
      <td>
        <p><strong>Votre Message</strong><br/>
        <textarea id='message' name="message" cols="45" rows="5" class="text12j"></textarea></p> 
        <p><strong>Votre Mail</strong><br/>
        <input name='tel_ins' type='hidden' value='<?PHP echo "$tel_ins"; ?>' />
        <input name='action'  type='hidden' value='send_mail' />
        <input id='mail_from' name='mail_from' type='text' class='text12j' size='50' maxlength='128' /></p>
        <table id='code'>
          <tr>
            <td>
              Recopier le code<br/> 
              <input id='code_set' name='code_set' type='text' class='textc' size='5' maxlength='4' value="<?PHP echo $_SESSION['code_set']; ?>" readonly='readonly' /> 
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input id='code_get' name='code_get' type='text' class='textc' size='5' maxlength='4' />
            </td>
            <td valign="bottom"><input class='but_input' type='submit' name='Submit' value='Envoyer' /></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<?PHP
}
function confirmation_ecran($ok) {
?>
   <table id='input_mail'>
    <tr> 
      <td bgcolor='#3399CC' height='70'>
        <p class='text12wb'><img src='/images/pdm-120x60.gif' align='middle' alt='SANS_AGENCES.COM' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contacter l'annonceur</p>
      </td>
    </tr>
    <tr height='260'> 
      <td>
      <?PHP
      if ( $ok == true ) echo "<p class='text12g'>Votre message a &eacute;t&eacute; envoy&eacute;</p>";
      else               echo "<p class='text12g'>Echec envoi de votre message</p>";
      ?>
      </td>
    </tr>
  </table>
<?PHP
}
?>
