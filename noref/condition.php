<?PHP
include("../include/inc_ariane.php");
include("../include/inc_xiti.php");
include("../include/inc_cibleclick.php");
include("../include/inc_tools.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr">

<head>
	<title>Conditions G&eacute;n&eacute;rales d&#8217;utilisation du site top-immobilier-particulier.fr</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-dialog.css" rel="stylesheet" type="text/css" />
	<meta name="robots" content="noindex,nofollow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page("Conditions d'utilisation") ?>
			<div id='condition'>
				<ul>
					<li>1. L'utilisation du site top-immobilier-particulier.fr est proposée aux internautes sans aucune garantie.</li>
					<li>2. Les annonces paraissent sous la seule responsabilité de l'annonceur et en particulier nous ne pouvons être tenus pour responsable de la véracité des informations qui nous sont fournies.</li>
					<li>3. Pour toutes les annonces, nous proc&eacute;dons &agrave; une v&eacute;rification des textes et des photos pour nous assurer que rien n&#8217;est contraire aux bonnes m&#339;urs, susceptible de choquer, de troubler les lecteurs, d'&ecirc;tre &agrave; caract&egrave;re injurieux ou diffamatoire. Dans ce cas les annonces ne sont pas publi&eacute;es.</li>
					<li>4. L'utilisation du site implique l'acceptation sans condition des conditions d'utilisation.</li>
				</ul>
				<p><?PHP print_xiti_code('cond-utilisations'); ?></p>
				<p>&nbsp;</p>
				<?PHP print_cible_unifinance_300_250(); ?>
				<p>&nbsp;</p>
			</div><!-- end condition -->
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'>&nbsp;</div>
</body>

</html>