<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");
include("../include/inc_search_keywords.php");
include("../include/inc_ariane.php");
include("../include/inc_vep.php");
include("../include/inc_adsense.php");
include("../include/inc_tracking.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_tools.php");


$title        = "Vente loft entre particuliers � Paris";
$description  = "Vente de loft entre particuliers � Paris. Listes des arrondissements avec nombre de loft dans chaque arrondissement et liens direct sur la s�lection de produit.";
$h1           = "Vente loft entre particuliers � Paris";
$keywords     = "Vente loft � Paris";
$keywords_url = "vente-loft-paris";
$query        = "&typt=vente&typp=3&P1=1&P2=2&P3=3&P4=4&P5=5";

dtb_connection();
count_cnx();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
	<title><?PHP echo "$title"; ?></title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-produit-paris.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-keyword.css" rel="stylesheet" type="text/css" />
	<meta name="Description" content="<?PHP echo "$description"; ?>" />
	<meta name="robots" content="index,follow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<div id='gauche'><?PHP print_skyscraper_160_600(); ?></div>
			<div id='droite'>
				<?PHP print_keyword_search();
				print_xiti_code($keywords_url); ?>
				<img src="/images-pub/paris-sans-agences-160x400.gif" title='20 Euros pour 6 mois sur TOP-IMMOBILIER-PARTICULIER.FR' alt='20 Euros pour 6 mois sur TOP-IMMOBILIER-PARTICULIER.FR' />
			</div>
			<div id='centre'>
				<?PHP make_ariane_paris_keywords($keywords); ?>
				<h1><?PHP echo "$h1"; ?></h1>
				<div id='list'>
					<?PHP
					$ard_stat    = get_query_stat($query);
					$number_size = get_stat_number_size($ard_stat);
					print_keyword_link_rewriting($keywords_url, $keywords, $ard_stat, $number_size, STAT);
					?>
				</div>
				<div id='partners-onglet'></div>
				<div id='partners-box'>
					<a href="http://www.drome-ardeche.org/drome_immobilier.html" title="Drome immobilier entre particuliers sans agences immobilieres">Immobilier Drome</a> |
					<a href='http://www.a-louer-vente.com/ppg-louer-terroirs.htm' title='Louer, vendre'>Louer, Vendre</a>
				</div>
				<?PHP print_vep_ban();
				tracking(CODE_NAV, 'OK', "$keywords_url", __FILE__, __LINE__);
				?>
				<div id='clearboth'>&nbsp;</div>
			</div> <!-- end centre -->
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>