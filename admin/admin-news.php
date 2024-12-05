<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");

/*
http://www.top-immobilier-particuliers.fr/admin/admin-news.php?action=start
*/

dtb_connection();
$url_short_site = URL_SHORT_SITE;
define('DEBUG_ADMIN_NEWS',0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Administration du news de <?PHP echo "$url_short_site"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
//---------------------------------------------------------------------------
function confirm_delete() {
  confirmation = confirm('Etes vous sur de vouloir supprimer ? ');
  if(confirmation) return true;
  else return false;
}
//---------------------------------------------------------------------------
function nbcar(item_id,item_count_id) {
  item_ptr       = document.getElementById(item_id);
  item_count_ptr = document.getElementById(item_count_id);
  if ( item_id != null && item_count_ptr != null ) item_count_ptr.value = item_ptr.value.length;
}
//---------------------------------------------------------------------------
function init_count() {
  nbcar('news_titre','news_titre_count');
  nbcar('news_description','news_description_count');
  nbcar('news_contenu','news_contenu_count');
  nbcar('news_url','news_url_count');
}
//---------------------------------------------------------------------------

</script>
</head>
<body onload="init_count();">
<?PHP
  //make_ariane_news_element('administration');
  echo "<p><a href='/admin/admin-news.php?action=start'>Retour � l'accueil de l'Administration</a></p>";

  check_arg(&$action,&$news_url,&$news_titre,&$news_description,&$news_contenu,&$news_connexe);

  if ( $action == 'start' ) print_start();
  
  if ( $action == 'creer_news' ) { creer_news($news_url,$news_titre,$news_description,$news_contenu);  print_start(); }

  if ( $action == 'choisir_news' ) {
    if ( news_existe($news_url) ) {
      print_form_news($news_url);
      print_form_ajouter_news_connexe($news_url);
      print_form_supprimer_news_connexe($news_url);
      echo "<p><a href='/admin/admin-news.php?action=start'>Retour � l'accueil de l'Administration</a></p>";
    } else {
      echo "<p>L'�l�ment n'est pas dans le news</p>\n";
      print_start();
    }
  }

  if ( $action == 'modifier_news' ) {
    if ( news_existe($news_url) ) {
      modifier_news($news_url,$news_titre,$news_description,$news_contenu);
      echo "<p>L'�l�ment a �t� modifi�</p>\n";
      print_start();
    } else {
      echo "<p>L'�l�ment n'est pas dans le news</p>\n";
      print_start();
    }
  }

  if ( $action == 'supprimer_news'         ) { supprimer_news($news_url);                      print_start(); }
  if ( $action == 'ajouter_news_connexe'   ) { ajouter_news_connexe($news_url,$news_connexe);   print_start(); }
  if ( $action == 'supprimer_news_connexe' ) { supprimer_news_connexe($news_url,$news_connexe); print_start(); }

  if ( $action == 'generer_le_flux' )   { generer_le_flux(); print_start(); }
  if ( $action == 'refaire_les_dates' ) { refaire_les_dates(); print_start(); }


?>
  


<?PHP
//------------------------------------------------------------------------------------------------
function print_start() {
  print_form_news();
  print_form_modifier_news();
  print_form_supprimer_news();
	print_form_generer_le_flux();
	print_form_refaire_les_dates();


}
//------------------------------------------------------------------------------------------------
function check_arg($action,$news_url,$news_titre,$news_description,$news_contenu,$news_connexe) {
  
  isset($_REQUEST['action']) ? $action = trim($_REQUEST['action'])  : die ; 

  if ( $action == 'creer_news' ) {
    ( isset($_REQUEST['news_url'])         && trim($_REQUEST['news_url'])         != '' ) ? $news_url         = trim($_REQUEST['news_url'])         : die; 
    ( isset($_REQUEST['news_titre'])       && trim($_REQUEST['news_titre'])       != '' ) ? $news_titre       = trim($_REQUEST['news_titre'])       : die; 
    ( isset($_REQUEST['news_description']) && trim($_REQUEST['news_description']) != '' ) ? $news_description = trim($_REQUEST['news_description']) : die; 
    ( isset($_REQUEST['news_contenu'])     && trim($_REQUEST['news_contenu'])     != '' ) ? $news_contenu     = trim($_REQUEST['news_contenu'])     : die; 
  }

  if ( $action == 'choisir_news' ) {
    ( isset($_REQUEST['news_url']) && trim($_REQUEST['news_url']) != '' ) ? $news_url = trim($_REQUEST['news_url']) : die; 
  }

  if ( $action == 'modifier_news' ) {
    ( isset($_REQUEST['news_url'])         && trim($_REQUEST['news_url'])         != '' ) ? $news_url         = trim($_REQUEST['news_url'])         : die; 
    ( isset($_REQUEST['news_titre'])       && trim($_REQUEST['news_titre'])       != '' ) ? $news_titre       = trim($_REQUEST['news_titre'])       : die; 
    ( isset($_REQUEST['news_description']) && trim($_REQUEST['news_description']) != '' ) ? $news_description = trim($_REQUEST['news_description']) : die; 
    ( isset($_REQUEST['news_contenu'])     && trim($_REQUEST['news_contenu'])     != '' ) ? $news_contenu     = trim($_REQUEST['news_contenu'])     : die; 
  }

  if ( $action == 'supprimer_news' ) {
    ( isset($_REQUEST['news_url']) && trim($_REQUEST['news_url']) != '' ) ? $news_url = trim($_REQUEST['news_url']) : die; 
  }

  if ( $action == 'ajouter_news_connexe' || $action == 'supprimer_news_connexe' ) {
    ( isset($_REQUEST['news_url'])     && trim($_REQUEST['news_url'])     != '' ) ? $news_url     = trim($_REQUEST['news_url'])     : die; 
    ( isset($_REQUEST['news_connexe']) && trim($_REQUEST['news_connexe']) != '' ) ? $news_connexe = trim($_REQUEST['news_connexe']) : die; 
  }

}
//------------------------------------------------------------------------------------------------
function print_form_news($news_url="") {

  if ( trim($news_url) != "" ) {
    $query  = "SELECT news_titre,news_description,news_contenu FROM news WHERE news_url='$news_url'";
    $result = dtb_query($query,__FILE__,__LINE__,DEBUG_ADMIN_NEWS);
    list($news_titre,$news_description,$news_contenu) = mysqli_fetch_row($result); 
  } else $news_contenu = "<img src='images/' title=\" \" alt=\" \" />";

?>
<h1>Gestion des News</h1>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post'>
<fieldset>
<?PHP 
if ( trim($news_url) == "" ) echo "<legend>Cr�er</legend>"; else echo "<legend>Modifier</legend>"; ?>
  <p><label for='news_titre'>Titre de la News (news_titre)</label>
    entre 60 et 80 caract&egrave;res. <strong>Au del&agrave; de 80 ca risque de poser des probl&egrave;mes</strong> en largeur sur les 
    titres et le fil d'ariane. <br />
  <input id='news_titre' name='news_titre' type='text' size="80" maxlength="255" value="<?PHP echo "$news_titre";  ?>" onKeyUp="nbcar('news_titre','news_titre_count');" />
  &nbsp;&nbsp;
  <input id='news_titre_count' name='news_titre_count' type='text' size="5" maxlength="3" readonly="readonly" />
  </p>
  <p><label for='news_description'>R�sum� du contenu de la News (news_description)</label>
    entre 150 &agrave; 250 caract&egrave;res. ( Ca c'est repris dans la meta descriptiton)<br />
  <textarea id='news_description' name='news_description' cols="100" rows="5" onKeyUp="nbcar('news_description','news_description_count');"><?PHP echo "$news_description";  ?></textarea>
  &nbsp;&nbsp;
  <input id='news_description_count' name='news_description_count' type='text' size="5" maxlength="3" readonly="readonly" /></p>
  <p>
    <label for='news_contenu'>Contenu de la News (news_contenu)</label>
    au moins 1000 caract&egrave;res pour une bonne mise en page et &lt; 2000 car c'est pas un roman<br />
  <strong>1500 c'est une bonne taille</strong></p>
  <p>Les pourcentages avec une virgule ex 6,8%. Les Gros chiffres avec un point ex 30.000.<br />
    Les liens avec un target='_blank'<br />
    <textarea id='news_contenu' name='news_contenu' cols="100" rows="15" onKeyUp="nbcar('news_contenu','news_contenu_count');"><?PHP echo "$news_contenu";  ?></textarea>
&nbsp;&nbsp; 
    <input id='news_contenu_count' name='news_contenu_count' type='text' size="5" maxlength="5" readonly="readonly" />
  </p>
  <?PHP
if ( trim($news_url) == "" ) {
?>
  <p><label for='news_url'>url de la News (news_url)</label>
    entre 60 et 80 caract&egrave;res (Attention au format des dates c'est tr&egrave;s partique pour ranger les photos.)<br />
  <input id='news_url' name='news_url' type='text' size="80" maxlength="128" onKeyUp="nbcar('news_url','news_url_count');" value="YYYY-MM-DD-" />
  &nbsp;&nbsp;
  <input id='news_url_count' name='news_url_count' type='text' size="5" maxlength="3" readonly="readonly" /></p>
	<p>
<?PHP
}
if ( trim($news_url) == "" ) {
  echo "<input type='hidden' name='action' value='creer_news' />";
  echo "<input type='submit' name='creer' value=\"Cr�ation d'un �l�ment\" />";
} else {
  echo "<input type='hidden' name='news_url' value='$news_url' />";
  echo "<input type='hidden' name='action' value='modifier_news' />";
  echo "<input type='submit' name='modifier' value=\"Modification d'un �l�ment\" />";
}
?>
</p>
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function creer_news($news_url,$news_titre,$news_description,$news_contenu) {

  $news_titre       = mysqli_real_escape_string($news_titre);
  $news_description = mysqli_real_escape_string($news_description);
  $news_contenu     = mysqli_real_escape_string($news_contenu);

  $flux_pub_date = date("r",time());
  $insert = "INSERT INTO news (dat_creation,news_url,news_titre,news_description,news_contenu,flux_pub_date) 
             VALUES (now(),'$news_url','$news_titre','$news_description','$news_contenu','$flux_pub_date')";
  dtb_query($insert,__FILE__,__LINE__,DEBUG_ADMIN_NEWS);
}
//------------------------------------------------------------------------------------------------
function modifier_news($news_url,$news_titre,$news_description,$news_contenu) {

  $news_titre       = mysqli_real_escape_string($news_titre);
  $news_description = mysqli_real_escape_string($news_description);
  $news_contenu     = mysqli_real_escape_string($news_contenu);

  $query = "UPDATE news SET news_titre='$news_titre',news_description='$news_description',news_contenu='$news_contenu' WHERE news_url='$news_url' LIMIT 1";
  dtb_query($query,__FILE__,__LINE__,DEBUG_ADMIN_NEWS);

}
//------------------------------------------------------------------------------------------------
function supprimer_news($news_url) {

  // Supprimer l'�l�ment de news
  $query = "DELETE FROM news WHERE news_url='$news_url' LIMIT 1";
  dtb_query($query,__FILE__,__LINE__,1);

  // Supprimer toutes les occurences ou l'�l�ment a �t� connexe 
  $query = "DELETE FROM news_connexe WHERE news_url='$news_url'";
  dtb_query($query,__FILE__,__LINE__,1);

}
//------------------------------------------------------------------------------------------------
function select_news() {

  $query  = "SELECT news_url FROM news ORDER BY dat_creation DESC";
  $result = dtb_query($query,__FILE__,__LINE__,DEBUG_ADMIN_NEWS);
  if ( mysqli_num_rows($result) ) {
    echo "<select name='news_url'>\n";
    while ( list($news_url,$news_titre) = mysqli_fetch_row($result) ) { 
      echo "<option value='$news_url'>$news_url</option>"; 
    }
    echo "</select>\n";
  } else echo "Pas de valeurs<br/>\n";

}
//------------------------------------------------------------------------------------------------
function print_form_modifier_news() {
?>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post'>
<fieldset><legend>Modifier</legend>
<?PHP select_news(); ?>
<input type='hidden' name='action' value='choisir_news' />
<input type='submit' name='sub_chosir' value="Choisir une news &agrave; Modifier" />
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function print_form_supprimer_news() {
?>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post' onsubmit='return confirm_delete();'>
<fieldset><legend>Supprimer</legend>
<?PHP select_news(); ?>
<input type='hidden' name='action' value='supprimer_news' />
<input type='submit' name='sub_supprimer' value="Choisir une news &agrave; Supprimer" />
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function print_form_refaire_les_dates() {
?>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post'>
<fieldset><legend>Refaire les date du flux</legend>
<input type='hidden' name='action' value='refaire_les_dates' />
<input type='submit' name='sub_chosir' value="Refaire" />
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function print_form_generer_le_flux() {
?>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post'>
<fieldset><legend>G�n�rer le flux</legend>
<input type='hidden' name='action' value='generer_le_flux' />
<input type='submit' name='sub_chosir' value="G�n�rer le Flux" />
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function news_existe($news_url) {

  if ( trim($news_url) != "" ) {
    $query  = "SELECT * FROM news WHERE news_url='$news_url'";
    $result = dtb_query($query,__FILE__,__LINE__,DEBUG_ADMIN_NEWS);
    if ( mysqli_num_rows($result) ) return true;
    else return false;
  }

}
//------------------------------------------------------------------------------------------------
// Faire un select de la liste des �l�ments connexe ajoutable
function select_news_connexe_ajoutable($news_url) {

  // On s�lection tout les �l�ments connexe d�j� utilis�
  $query  = "SELECT news_connexe FROM news_connexe WHERE news_url='$news_url'";
  $result = dtb_query($query,__FILE__,__LINE__,1);

  // On s�lection toute la liste des �l�ments du news sauf lui m�me
  $query_ajoutable  = "SELECT news_url FROM news WHERE news_url != '$news_url'";

  // On fabrique la requ�te pour s�lectionner ceux qui sont ajoutable
  while ( list($news_connexe) = mysqli_fetch_row($result) ) $query_ajoutable .= " AND news_url != '$news_connexe'";
  
	$query_ajoutable .= " ORDER BY dat_creation DESC";
	
  // On fait la requ�te pour r�cup�rer les ajoutables
  $result = dtb_query($query_ajoutable,__FILE__,__LINE__,1);

  echo "<select name='news_connexe'>\n";
  while ( list($news_url) = mysqli_fetch_row($result) ) {
    echo "<option value='$news_url'>$news_url</option>\n"; 
  }
  echo "</select>\n";
}
//------------------------------------------------------------------------------------------------
function print_form_ajouter_news_connexe($news_url) {
?>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post'>
<fieldset>
  <legend>Ajouter des news connexes</legend>
<?PHP select_news_connexe_ajoutable($news_url); ?>
<input type='hidden' name='news_url' value='<?PHP echo "$news_url"; ?>' />
<input type='hidden' name='action' value='ajouter_news_connexe' />
<input type='submit' name='sub_ajouter_connexe' value="Choisir une news connexe &agrave; Ajouter" />
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function ajouter_news_connexe($news_url,$news_connexe) {

  echo "Ajouter $news_connexe comme �l�ment connexe � $news_url<br />";

  $query  = "INSERT INTO news_connexe (news_url,news_connexe) VALUES ('$news_url','$news_connexe')";    
  dtb_query($query,__FILE__,__LINE__,1);


}
//------------------------------------------------------------------------------------------------
// Faire un select de la liste des �l�ments connexes supprimables
function select_news_connexe_supprimable($news_url) {

  // On s�lection les �l�ments connexes de l'�l�ments
  $query  = "SELECT news_connexe FROM news_connexe WHERE news_url='$news_url'";
  $result = dtb_query($query,__FILE__,__LINE__,DEBUG_ADMIN_NEWS);

  echo "<select name='news_connexe'>\n";
  while ( list($news_connexe) = mysqli_fetch_row($result) ) {
    echo "<option value='$news_connexe'>$news_connexe</option>\n"; 
  }
  echo "</select>\n";
}
//------------------------------------------------------------------------------------------------
function print_form_supprimer_news_connexe($news_url) {
?>
<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='post'>
<fieldset>
  <legend>Supprimer des news connexes</legend>
<?PHP select_news_connexe_supprimable($news_url); ?>
<input type='hidden' name='news_url' value='<?PHP echo "$news_url"; ?>' />
<input type='hidden' name='action' value='supprimer_news_connexe' />
<input type='submit' name='sub_ajouter_connexe' value="Choisir une news connexe &agrave; Supprimer" />
</fieldset>
</form>
<?PHP
}
//------------------------------------------------------------------------------------------------
function supprimer_news_connexe($news_url,$news_connexe) {

  echo "Supprimer $news_connexe comme �l�ment connexe � $news_url<br />";

  $query  = "DELETE FROM news_connexe WHERE news_url='$news_url' AND news_connexe='$news_connexe' LIMIT 1";
  dtb_query($query,__FILE__,__LINE__,1);

}
//------------------------------------------------------------------------------------------------
function generer_le_flux() {

  $xml  = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
  $xml .= '<?xml-stylesheet type="text/xsl" href="updates.xslt" ?>';
  $xml .= '<rss version="2.0">';
  $xml .= '<channel>';
  $xml .= '<title>'.SITE_NAME_FR.'</title>';
  $xml .= '<link>'.URL_SITE.'</link>';
  $xml .= "<description>Flux de l'actualit� immobili�re</description>";
  $xml .= '<image>';
  $xml .= '<url>'.URL_SITE.'images/top-immobilier-particuliers-240x60.jpg</url>'; 
  $xml .= '<title>Actualit�s</title>'; 
  $xml .= '<link>'.URL_SITE.'actualites-immobilieres/</link>'; 
  $xml .= '</image>';

	
  $query  = "SELECT DATE_FORMAT(dat_creation,'%d-%m-%Y'),news_titre,news_description,news_url,flux_pub_date FROM news ORDER BY dat_creation DESC LIMIT 15";
  $result = dtb_query($query,__FILE__,__LINE__,0);
	
  while ( list($news_dat,$news_titre,$news_description,$news_url,$flux_pub_date) = mysqli_fetch_row($result) ) {

    $xml .= '<item>';
    $xml .= '<title>('.$news_dat.') '.$news_titre.'</title>';
    $xml .= '<link>'.URL_SITE.'actualites-immobilieres/'.$news_url.'.htm</link>';
    $xml .= "<guid isPermaLink='false'>".$news_url."</guid>";
    $xml .= '<description>'.$news_description.'</description>';
    $xml .= '<pubDate>'.$flux_pub_date.'</pubDate>';
		$xml .= '<author>Equipe de www.top-immobilier-particuliers.fr</author>';
		$xml .= '</item>';
	
  }

  $xml .= '</channel>';
  $xml .= '</rss>';

  // �criture dans le fichier
  if ( ($fp = fopen("../actualites-immobilieres/xml-flux-news.xml", 'w+')) !== false ) {
    fputs($fp, $xml);
    fclose($fp);
  } else echo "<p>Echec cr�ation du flux</p>";
}
//------------------------------------------------------------------------------------------------
function refaire_les_dates() {

  // On lit la date et on r�cup�re un time stamp
  $query = "SELECT idw,UNIX_TIMESTAMP(dat_creation) FROM news";
  $result = dtb_query($query,__FILE__,__LINE__,0);
  while ( list($idw,$dat_unix) = mysqli_fetch_row($result) ) {

    $flux_pub_date = date("r",$dat_unix);

    echo "$idw<br/>";
    echo "$dat_unix<br/>";
    echo "$flux_pub_date<br/>";

    $query = "UPDATE news SET flux_pub_date='$flux_pub_date' WHERE idw='$idw'";
    dtb_query($query,__FILE__,__LINE__,0);
  }
}
?>
</body>
</html>
