<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_ariane.php");
include("../include/inc_count_cnx.php");
include("../include/inc_xiti.php");
include("../include/inc_tools.php");

dtb_connection();
count_cnx();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Plan du site</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-tools.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src='/jvscript/popup.js'></script>
	<meta name="robots" content="index,follow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page("Plan du Site") ?>
			<div id='plan'>
				<h1>Plan du site</h1>
				<ul class='niv1'>
					<li><a href='/noref/faq.php' title='R�ponses aux questions fr�quemment pos�es' rel="nofollow">FAQ : R�ponses aux questions fr�quemment pos�es</a></li>
					<li><a href='/noref/contact-equipe.php?action=print_form' title='Contacter nous' rel="nofollow">Contacter Nous</a></li>
					<li><a href='/noref/loupe.php' title='Augmenter ou diminuer la taille du texte' rel="nofollow">+ Loupe - : Augmenter ou diminuer la taille du texte</a></li>
					<li><a href='/noref/condition.php' rel='nofollow'>Conditions d'utilisations</a></li>
					<li><a href='/noref/mention.php' rel='nofollow'>Mentions l&eacute;gales</a></li>
					<li>
						<p><a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche'>Acheteurs : Cr�er votre compte recherche</a></p>
					</li>
					<li>
						<p><a href='/compte-annonce/passer-annonce.php'>Vendeurs : D&eacute;poser des offres de vente</a></p>
						<ul class='niv2'>
							<li><a href='/vendre-de-particulier-a-particulier-en-france.htm'>D&eacute;poser une offre de vente entre particuliers en France</a></li>
							<li><a href='/entre-particuliers-dom-tom.htm'>D&eacute;poser une offre de vente entre particuliers dans les Dom Tom</a></li>
							<li><a href='/vendre-entre-particulier-a-etranger.htm'>D&eacute;poser une offre de vente entre particuliers &agrave; l'&eacute;tranger</a></li>
						</ul>
					</li>
					<li>
						<p>Recherche par villes</p>
						<ul class='niv2'>
							<li><a href='/immobilier-entre-particuliers-paris.htm'>Immobilier entre particuliers &agrave; Paris</a>
								<ul class='niv2'>
									<li><a href='/vente-appartement-entre-particuliers-paris.htm'>Vente appartement particuliers Paris</a></li>
									<li><a href='/vente-studio-entre-particuliers-paris.htm'>Vente studio particuliers Paris</a></li>
									<li><a href='/vente-loft-entre-particuliers-paris.htm'>Vente loft particuliers Paris</a></li>
								</ul>
							</li>
							<li><a href='/immobilier-entre-particuliers-marseille.htm'>Immobilier entre particuliers &agrave; Marseille</a></li>
							<li><a href='/immobilier-entre-particuliers-lyon.htm'>Immobilier entre particuliers &agrave; Lyon</a></li>
							<li><a href='/immobilier-entre-particuliers-toulouse.htm'>Immobilier entre particuliers &agrave; Toulouse</a></li>
							<li><a href='/immobilier-entre-particuliers-nice.htm'>Immobilier entre particuliers &agrave; Nice</a></li>
							<li><a href='/immobilier-entre-particuliers-nantes.htm'>Immobilier entre particuliers &agrave; Nantes</a></li>
							<li><a href='/immobilier-entre-particuliers-strasbourg.htm'>Immobilier entre particuliers &agrave; Strasbourg</a></li>
							<li><a href='/immobilier-entre-particuliers-montpellier.htm'>Immobilier entre particuliers &agrave; Montpellier</a></li>
							<li><a href='/immobilier-entre-particuliers-bordeaux.htm'>Immobilier entre particuliers &agrave; Bordeaux</a></li>
							<li><a href='/immobilier-entre-particuliers-toulon.htm'>Immobilier entre particuliers &agrave; Toulon</a></li>
							<li><a href='/immobilier-entre-particuliers-cannes.htm'>Immobilier entre particuliers &agrave; Cannes</a></li>
							<li><a href='/immobilier-entre-particuliers-lille.htm'>Immobilier entre particuliers &agrave; Lille</a></li>
						</ul>
					</li>
					<li>
						<p>Produits en pr�sentation</p>
						<ul class='niv2'>
							<?PHP print_produit(); ?>
						</ul>
					</li>
				</ul>
				<?PHP print_xiti_code("plan-du-site"); ?>
			</div><!-- end plan -->
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'>&nbsp;</div>
</body>

</html>
<?PHP
function print_produit() {

	$query = "SELECT ville FROM ref_ville";
	$result_list_ville   = dtb_query($query, __FILE__, __LINE__, 0);
	while (list($ville) = mysqli_fetch_row($result_list_ville)) {

		$ville_s = addslashes($ville);
		$query = "SELECT tel_ins,typp,COUNT(*) as nb FROM ano WHERE etat='ligne' AND zone_ville='$ville_s' AND zone_ville != 'Paris' GROUP BY typp";
		$result_list_product = dtb_query($query, __FILE__, __LINE__, 0);
		while (list($tel_ins, $typp, $nb) = mysqli_fetch_row($result_list_product)) {

			$query = "SELECT ville_url,ville_lieu,dept_url FROM ref_ville WHERE ville='$ville_s'";
			$result_spec_ville = dtb_query($query, __FILE__, __LINE__, 0);
			list($ville_url, $ville_lieu, $dept_url) = mysqli_fetch_row($result_spec_ville);

			if ($nb == 1) echo "<li><a href='/$typp,$ville_url,$dept_url.htm'>$nb $typp $ville_lieu</a></li>\n";
			if ($nb  > 1) echo "<li><a href='/$typp,$ville_url,$dept_url.htm'>$nb ${typp}s $ville_lieu</a></li>\n";
		}
	}
}
?>