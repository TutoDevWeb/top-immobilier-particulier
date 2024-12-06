<?PHP
include("../include/inc_ariane.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_tools.php");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Les services proposés aux vendeurs</title>
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-ccm.css" rel="stylesheet" type="text/css" />
	<meta name="robots" content="noindex,nofollow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page("Vendeurs + d'infos") ?>
			<div id='ccm_vendeurs'>
				<h1>Ce que ce site vous propose de plus !</h1>
				<h2>D&egrave;s que vous cr&eacute;ez votre annonce, les acheteurs 'cibl&eacute;s' sont pr&eacute;venus !</h2>
				<p>Les acheteurs 'cibl&eacute;s' sont ceux qui ont enregistré r&eacute;cemment sur ce site une recherche d'un produit qui correspond
					aux caractéristiques du votre. Vous devez avoir un retour imm&eacute;diat en termes de contact. Quelques conseils : tennez un
					discours de vendeur, mettez en valeur les avantages de votre produit, ouvrez la porte &agrave; une n&eacute;gociation sur le prix.
					Ne vous avancez surtout pas sur son montant d&egrave;s le d&eacute;part. Sachez qu'il faudra toujours n&eacute;gocier mais fixez
					vous une marge. C'est plut&ocirc;t &ccedil;a qui est important.</p>
				<div class='compo'><img src="/images/ccm-vendeurs-alerte-recherche.jpg" alt='Les acheteurs sont prévenus dès la mise en ligne de votre produit' /></div>
				<h2>Un lien vers votre blog et vos vidéos de visites virtuelles</h2>
				<p>Nous pla&ccedil;ons un lien et nous comptons les visiteurs que nous envoyons vers votre blog. Ce serait dommage de ne pas profiter
					de cet avantage le plus souvent gratuit. Un blog n'est pas difficile à faire. C'est un document comme un autre. Ce qui compte
					c'est la qualité de la rédaction et des média que vous mettez en ligne. Attention donc &agrave; la qualité de la vidéo. On voit
					trop souvent des vidéos de mauvaise qualité.<em> (* blog ou site personnel notre service reste le m&ecirc;me)</em></p>
				<div class='compo'><img src="/images/ccm-vendeurs-blog.jpg" alt='Vos vid�os de visites virtuelles sur votre blog !' /></div>
				<h2>Déclencher des alertes à la baisse</h2>
				<p>Si vous baisser le prix de votre produit ne serait ce que d'un Euro, tous les acheteurs qui ont positionné une 'alerte à la baisse'
					sur votre produit seront prévenus. Le but ce n'est pas de vous amenez à baisser votre prix mais de déclencher un contact, une
					négociation.</p>
				<div class='compo'><img src="/images/ccm-vendeurs-alerte-baisse.jpg" alt="Déclencher des alertes à la baisse !" /></div>
			</div><!-- ccm_vendeurs -->
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>