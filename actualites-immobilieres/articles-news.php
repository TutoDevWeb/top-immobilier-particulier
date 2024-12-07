<?PhP
include("../include/inc_tools.php");
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_adsense.php");
include("../include/inc_xiti.php");

(isset($_REQUEST['news_url']) && trim($_REQUEST['news_url']) != '') ? $news_url = trim($_REQUEST['news_url']) : die;

$connexion = dtb_connection();
define('DEBUG_NEWS', 0);

if (get_data_news_by_url($connexion, $news_titre, $news_description, $news_url) === false) die;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title><?PHP echo "$news_titre"; ?></title>
	<meta name="Description" content="<?PHP echo "$news_description"; ?>" />
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/news.css" rel="stylesheet" type="text/css" />
	<meta name="robots" content="index,follow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="http://www.top-immobilier-particulier.fr/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP
			make_ariane_news_articles($news_titre);
			print_news_by_url($connexion, $news_url);
			print_news_date($connexion, $news_url);
			print_news_connexe_by_url_order_dat($connexion, $news_url);
			print_xiti_code('');
			?>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>

<?PHP
//------------------------------------------------------------------------------------------------------
function print_news_by_url($connexion, $news_url) {

	$query = "SELECT dat_creation,news_titre,news_description,news_contenu FROM news WHERE news_url='$news_url' LIMIT 1";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		list($dat_creation, $news_titre, $news_description, $news_contenu) = mysqli_fetch_row($result);
		echo "<h1>$news_titre</h1>\n";
		echo "<a href='/compte-annonce/passer-annonce.php'><img src='/images-pub/vendre-top-immobilier-particuliers-savoir-700x120.gif' title='20 Euros pour 6 mois sur TOP-IMMOBILIER-PARTICULIER.FR' alt='Cliquez pour en savoir plus...' /></a>";
		echo "<div id='news'><p><strong>{$news_description}</strong></p>{$news_contenu}<div id='news_footer'>&nbsp;</div></div>\n";
	}
}
//------------------------------------------------------------------------------------------------------
function print_news_date($connexion, $news_url) {

	$query  = "SELECT DATE_FORMAT(dat_creation,'%d-%m-%Y') FROM news WHERE news_url='$news_url'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		list($dat_creation) = mysqli_fetch_row($result);
		echo "<div id='news_dat'><div id='dat_creation'><em>Date de cr�ation : $dat_creation</em></div></div>\n";
	}
}
//------------------------------------------------------------------------------------------------------
function print_news_connexe_by_url($connexion, $news_url) {

	echo "<div id='news_connexe'>\n";
	$query  = "SELECT news_connexe FROM news_connexe WHERE news_url='$news_url' ORDER BY news_connexe ASC";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		echo "<h2>Articles d'actualit�s pr�c�dents en rapport</h2>\n";
		while (list($news_connexe) = mysqli_fetch_row($result)) {
			$news = get_titre_news_by_url($connexion, $news_connexe);
			$news_dat = get_dat_news_by_url($connexion, $news_connexe);
			echo "<h3>$news_dat&nbsp;<a href='/actualites-immobilieres/$news_connexe.htm' title='Article du $news_dat en rapport avec cette actualit�'>$news</a></h3>\n";
		}
	}
	echo "</div>\n";
}
//------------------------------------------------------------------------------------------------------
// Order by dat
function print_news_connexe_by_url_order_dat($connexion, $news_url) {

	echo "<div id='news_connexe'>\n";
	$query  = "SELECT c.news_connexe FROM news_connexe as c, news as n WHERE c.news_url=n.news_url AND c.news_url='$news_url' ORDER BY n.dat_creation";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		echo "<h2>Articles d'actualit�s pr�c�dents en rapport</h2>\n";
		while (list($news_connexe) = mysqli_fetch_row($result)) {
			$news = get_titre_news_by_url($connexion, $news_connexe);
			$news_dat = get_dat_news_by_url($connexion, $news_connexe);
			echo "<h3>$news_dat&nbsp;<a href='/actualites-immobilieres/$news_connexe.htm' title='Article du $news_dat en rapport avec cette actualit�'>$news</a></h3>\n";
		}
	}
	echo "</div>\n";
}
//------------------------------------------------------------------------------------------------------
function get_data_news_by_url($connexion, &$news_titre, &$news_description, $news_url) {
	$query = "SELECT news_titre,news_description FROM news WHERE news_url='$news_url'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		list($news_titre, $news_description) = mysqli_fetch_row($result);
		return true;
	} else return false;
}
//------------------------------------------------------------------------------------------------------
function get_titre_news_by_url($connexion, $news_url) {
	$query = "SELECT news_titre FROM news WHERE news_url='$news_url'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		list($news_titre) = mysqli_fetch_row($result);
		return $news_titre;
	} else return false;
}
//------------------------------------------------------------------------------------------------------
function get_dat_news_by_url($connexion, $news_url) {
	$query = "SELECT DATE_FORMAT(dat_creation,'%d-%m-%Y') FROM news WHERE news_url='$news_url'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_NEWS);
	if (mysqli_num_rows($result)) {
		list($news_dat) = mysqli_fetch_row($result);
		return $news_dat;
	} else return false;
}

?>