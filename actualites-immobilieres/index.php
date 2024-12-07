<?PHP
include("../include/inc_tools.php");
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_xiti.php");

dtb_connection();
define('DEBUG_NEWS', 0);
$title = SITE_NAME . " : Actualit�s Immobili�res";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title><?PHP echo "$title"; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Description" content="<?PHP echo "$title "; ?> Nationales et Internationales. Br�ves sur les tendances des march�s immobiliers et les �v�nements importants." />
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
			make_ariane_news_index();
			echo "<h1>$title</h1>\n";

			print_news_listing();
			print_xiti_code('');
			?>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP

function print_news_listing() {

	$query  = "SELECT MONTH(dat_creation),DATE_FORMAT(dat_creation,'%d-%m-%Y'),news_titre,news_description,news_url FROM news ORDER BY dat_creation DESC";
	$result = dtb_query($query, __FILE__, __LINE__, DEBUG_NEWS);

	$actual_month = '';
	echo "<div id='news_listing'>\n";
	while (list($news_month, $news_date, $news_titre, $news_description, $news_url) = mysqli_fetch_row($result)) {
		if ($actual_month == '' || $actual_month != $news_month) {
			echo "<div class='month_separate'></div>\n";
			$actual_month = $news_month;
		}
		echo "<h2>($news_date) <a href='/actualites-immobilieres/$news_url.htm'>$news_titre</a></h2>\n";
		echo "<p>$news_description</p>\n";
	}
	echo "</div>\n";
}
?>