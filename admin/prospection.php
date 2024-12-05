<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_tracking.php");
include("../include/inc_conf.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_mail_compte_annonce.php");
include("../include/inc_ano_sup.php");
include("../include/inc_photo.php");
include("../include/inc_format.php");

define('DEBUG_ANO_PROSPECTION',1);

check_arg(&$action,&$tel_pro,&$dialogue_pro,&$etat_pro);

dtb_connection(__FILE__,__LINE__);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Prospection</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?PHP

// Lancement sans argument. On est au menu principal.
if      ( $action == "" ) { 
  print_tester_panel();
  print_examiner_panel();

// Sinon on est dans les actions
} else {

  //-----------------------------------------------------------------------------------------
  if ( $action == 'tester_tel_pro' ) {

    if ( ($etat_pro = get_tel_pro_etat($tel_pro,__FILE__,__LINE__)) === false ) {
	
	    echo "<p>Le num�ro n'existe pas il faut l'exploiter\n</p>";
      print_exploiter_numero_panel($tel_pro);
	
	  } else {

	    echo "<p>Le num�ro existe etat_pro => $etat_pro\n</p>";
	
	  }

  //-----------------------------------------------------------------------------------------
  // Examiner les num�ros selon  l'etat
  } else if ( $action == 'examiner_tel_pro' )
    examiner_numero($etat_pro,__FILE__,__LINE__);

  //-----------------------------------------------------------------------------------------
  // Insertion d'un num�ro de t�l�phone
  else if ( $action == 'inserer_tel_pro' )
    inserer_numero($tel_pro,$dialogue_pro,$etat_pro,__FILE__,__LINE__);

  //-----------------------------------------------------------------------------------------
  // Modification d'un num�ro de t�l�phone
  else if ( $action == 'modifier_tel_pro' )
    modifier_numero($tel_pro,$dialogue_pro,$etat_pro,__FILE__,__LINE__);

  //-----------------------------------------------------------------------------------------

  retour_au_menu();

}
//-----------------------------------------------------------------------------------------------
function print_tester_panel() {
?>
  <div id='tester_panel'>
    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' autocomplete="off"> 
      <fieldset><legend>Tester un num�ro</legend>
      <p><label for='tel_pro'>T�l�phone � tester</label>&nbsp;&nbsp;<input id='tel_pro' name='tel_pro' type='text' size="25" maxlength="128" /></p>
      <input type='hidden' name='action' value='tester_tel_pro' />
      <input  class='but_input' type='submit' value='Tester un num�ro'/>
      </fieldset>
    </form>
  </div>
<?
}
//-----------------------------------------------------------------------------------------------
function print_examiner_panel() {
?>
  <div id='examiner_panel'>
    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' autocomplete="off"> 
      <fieldset><legend>Examiner les num�ros</legend>
      <p><label for='etat_pro'>Etat</label><br/>
			<select id='etat_pro' name='etat_pro'>
			<option value='ligne'>ligne</option>
			<option value='refus'>refus</option>
			<option value='inexploitable'>inexploitable</option>
			<option value='a_rappeler'>a_rappeler</option>
			<option value='a_faire'>a_faire</option>
			</select></p>
      <input type='hidden' name='action' value='examiner_tel_pro' />
      <input  class='but_input' type='submit' value='Examiner les num�ro'/>
      </fieldset>
    </form>
  </div>
<?
}
//-----------------------------------------------------------------------------------------------
function print_exploiter_numero_panel($tel_pro) {
?>
  <div id='exploiter_numero_panel'>
    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' autocomplete="off"> 
      <fieldset><legend>Rentrer les informations de dialogue et positionner un �tat</legend>
      <p><label for='dialogue_pro'>Dialogue</label><br/><textarea id='dialogue_pro' name='dialogue_pro' rows='10' cols='80' ></textarea></p>
      <p><label for='etat_pro'>Etat</label><br/>
			<select id='etat_pro' name='etat_pro'>
			<option value='D�cider'>D�cider de la suite</option>
			<option value='ligne'>ligne</option>
			<option value='refus'>refus</option>
			<option value='inexploitable'>inexploitable</option>
			<option value='a_rappeler'>a_rappeler</option>
			<option value='a_faire'>a_faire</option>
			</select></p>
      <input type='hidden' name='tel_pro' value='<?PHP echo "$tel_pro"; ?>' />
      <input type='hidden' name='action' value='inserer_tel_pro' />
      <input  class='but_input' type='submit' value='Enregistrer un num�ro'/>
      </fieldset>
    </form>
  </div>
<?
}
//-----------------------------------------------------------------------------------------------
function print_modifier_numero_panel($tel_pro,$dialog_pro,$etat_pro) {
?>
  <div id='modifier_numero_panel'>
    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='get' autocomplete="off"> 
      <fieldset><legend>Mofifier le num�ro <?PHP echo "<b>$tel_pro</b>"; ?></legend>
      <p><label for='dialogue_pro'>Dialogue</label><br/><textarea id='dialogue_pro' name='dialogue_pro' rows='10' cols='80' ><?PHP echo $dialog_pro ?></textarea></p>
      <p><label for='etat_pro'>Etat</label><br/>
			<select id='etat_pro' name='etat_pro'>
			<option value='ligne'         <?PHP if ($etat_pro == 'ligne')         echo "selected='selected'" ?>>ligne</option>
			<option value='refus'         <?PHP if ($etat_pro == 'refus')         echo "selected='selected'" ?>>refus</option>
			<option value='inexploitable' <?PHP if ($etat_pro == 'inexploitable') echo "selected='selected'" ?>>inexploitable</option>
			<option value='a_rappeler'    <?PHP if ($etat_pro == 'a_rappeler')    echo "selected='selected'" ?>>a_rappeler</option>
			<option value='a_faire'       <?PHP if ($etat_pro == 'a_faire')       echo "selected='selected'" ?>>a_faire</option>
			</select></p>
      <input type='hidden' name='tel_pro' value='<?PHP echo "$tel_pro"; ?>' />
      <input type='hidden' name='action' value='modifier_tel_pro' />
      <input  class='but_input' type='submit' value='Modifier le num�ro'/>
      </fieldset>
    </form>
  </div>
<?
}
//-----------------------------------------------------------------------------------------------
function inserer_numero($tel_pro,$dialogue_pro,$etat_pro,$file,$line) {

  $tel_pro      = mysqli_real_escape_string($tel_pro);
  $dialogue_pro = mysqli_real_escape_string($dialogue_pro);
  $etat_pro     = mysqli_real_escape_string($etat_pro);

  $query = "INSERT INTO ano_prospection (tel_pro,dialogue_pro,etat_pro) 
	                      VALUES ('$tel_pro','$dialogue_pro','$etat_pro')";

	if ( dtb_query($query,$file,$line,DEBUG_ANO_PROSPECTION) !== false ) {
	
	  echo "<p>Le num�ro $tel_pro a �t� ins�rer correctement</p>";
	
	}

}
//-----------------------------------------------------------------------------------------------
function modifier_numero($tel_pro,$dialogue_pro,$etat_pro,$file,$line) {

  $tel_pro      = mysqli_real_escape_string($tel_pro);
  $dialogue_pro = mysqli_real_escape_string($dialogue_pro);
  $etat_pro     = mysqli_real_escape_string($etat_pro);

	$query = "UPDATE ano_prospection SET dialogue_pro='$dialogue_pro',
	                                     etat_pro='$etat_pro'
														           WHERE tel_pro='$tel_pro' LIMIT 1";		

	if ( dtb_query($query,$file,$line,DEBUG_ANO_PROSPECTION) !== false ) {
	
	  echo "<p>Le num�ro $tel_pro a �t� mis a jour correctement</p>";

	}

}
//-----------------------------------------------------------------------------------------------
function examiner_numero($etat_pro,$file,$line) {

  $etat_pro = mysqli_real_escape_string($etat_pro);

  echo "<p>Liste des num�ro dans l'�tat => $etat_pro</p>";

	$query = "SELECT tel_pro,dialogue_pro FROM ano_prospection WHERE etat_pro='$etat_pro'";		
	if ( ($result = dtb_query($query,$file,$line,DEBUG_ANO_PROSPECTION)) !== false ) {
    while ( list($tel_pro,$dialogue_pro) = mysqli_fetch_row($result) ) {

      print_modifier_numero_panel($tel_pro,$dialogue_pro,$etat_pro);

    }
	}
}
//-----------------------------------------------------------------------------------------------
function retour_au_menu() {
?>

<p><a href='/admin/prospection.php'>Retour au menu</a></p> 

<?PHP
}
?>
</body>
</html>
<?PHP
//-----------------------------------------------------------------------------------------------
// Si le num�ro n'existe pas la fonction retourne false.
// Si le num�ro existe la fonction retourne l'etat.
function get_tel_pro_etat($tel_pro,$file,$line) {

  $query  = "SELECT etat_pro FROM ano_prospection WHERE tel_pro='$tel_pro'";
  $result = dtb_query($query,$file,$line,DEBUG_ANO_PROSPECTION);
	
	if ( mysqli_num_rows($result) ) {

    list($etat_pro) = mysqli_fetch_row($result);
    return($etat_pro);
		
  } else return false;
}
//-----------------------------------------------------------------------------------------------
// Test des arguments d'entr�e
function check_arg(&$action,&$tel_pro,&$dialogue_pro,&$etat_pro) {

  if ( isset($_GET['action'])  ) $action = trim($_GET['action']); else $action = "";

  //-----------------------------------------------------------------------------------------------
  // Si on doit tester un num�ro de t�l�phone il faut v�rifier qu'on l'a ET �ventuellement le formater
  if ( $action == 'tester_tel_pro' ) {

    if ( isset($_GET['tel_pro']) && trim($_GET['tel_pro']) != "" ) $tel_pro = trim($_GET['tel_pro']);
		else {
		 echo "<p>Saisir un num�ro de t�l�phone</p>";
		 die;
    }
  }
  //-----------------------------------------------------------------------------------------------
  // Si on doit examiner les num�ro selon leur �tat
  if ( $action == 'examiner_tel_pro' ) {

    $etat_pro = trim($_GET['etat_pro']);

  }
  //-----------------------------------------------------------------------------------------------
  // Si on doit inserer un num�ro de t�l�phone
  if ( $action == 'inserer_tel_pro' ) {

    if ( isset($_GET['tel_pro']) && trim($_GET['tel_pro']) != "" ) $tel_pro = trim($_GET['tel_pro']);
		else {
		 echo "<p>Il manque un num�ro de t�l�phone</p>";
		 die;
    }

    $dialogue_pro = trim($_GET['dialogue_pro']);
    $etat_pro     = trim($_GET['etat_pro']);

  }
  //-----------------------------------------------------------------------------------------------
  // Si on doit modifier un num�ro de t�l�phone
  if ( $action == 'modifier_tel_pro' ) {

    $tel_pro      = trim($_GET['tel_pro']);
    $dialogue_pro = trim($_GET['dialogue_pro']);
    $etat_pro     = trim($_GET['etat_pro']);

  }
  //-----------------------------------------------------------------------------------------------

}
?>
