<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_ariane.php");
include("../include/inc_random.php");
include("../include/inc_tracking.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_filter.php");

filtrer_les_entrees_request(__FILE__, __LINE__);

$connexion = dtb_connection();
count_cnx($connexion);
//isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die ; 

$prix_annonce = PRIX_ANNONCE;
$duree_annonce = DUREE_ANNONCE;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Passer une annonce sur TOP-IMMOBILIER-PARTICULIER.FR</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Description" content="Pour votre vente immobilière passez une annonce sur TOP-IMMOBILIER-PARTICULIER.FR. 20 Euros pour 6 mois de parution." />
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/styles-passer-annonce.css" rel="stylesheet" type="text/css" />
	<meta name="robots" content="index,follow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page("Passer une annonce"); ?>
			<img src="/images-pub/vendre-top-immobilier-particuliers-700x120.gif" title='20 Euros pour 6 mois sur TOP-IMMOBILIER-PARTICULIER.FR' alt='20 Euros pour 6 mois sur TOP-IMMOBILIER-PARTICULIER.FR' />
			<ul id='listarg'>
				<li>512 caractères pour rédiger en détails votre annonce</li>
				<li>5 photos</li>
				<li>Votre bien facilement localisable sur une carte</li>
				<li>Un compteur des visiteurs de votre fiche détaillée</li>
				<li>Un lien vers votre Blog <em>(* vos vidéos de visites virtuelles sur votre blog c'est gratuit )</em></li>
				<li>Un compteur des visiteurs envoyés par TOP-IMMOBILIER-PARTICULIER.FR vers votre blog</li>
			</ul>

			<p><img src="/images/arrow5.gif" alt="" /><strong>Passer une annonce sur TOP-IMMOBILIER-PARTICULIER.FR</strong></p>

			<ul id='depositbox'>
				<li><a href="/vendre-de-particulier-a-particulier-en-france.htm" title="Passer une annonce pour un logement situ� en France">Passer une annonce pour un logement situé en France</a></li>
				<li><a href="/entre-particuliers-dom-tom.htm" title="Passer une annonce pour un logement situ� dans les Dom Tom">Passer une annonce pour un logement situé dans les Dom Tom</a></li>
				<li><a href="/vendre-entre-particulier-a-etranger.htm" title="Passer une annonce pour un logement situ� � l'�tranger">Passer une annonce pour un logement situé à l'étranger</a></li>
			</ul>
			<img src='/images-pub/concurrence-sans-agences.gif' title='FAITE JOUER LA CONCURRENCE' alt='FAITE JOUER LA CONCURRENCE' />

		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>