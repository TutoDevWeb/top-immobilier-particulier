<?PHP
include("../include/inc_ariane.php");
include("../include/inc_xiti.php");
include("../include/inc_tools.php");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Informations L�gales du site top-immobilier-particulier.fr</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-dialog.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='/jvscript/popup.js'></script>
	<meta name="robots" content="noindex,nofollow" />
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page("Mentions légales") ?>
			<div id='mention'>
				<div class='legal_box'>
					<p>1.<strong>Ce site fait l'objet d'une d&eacute;claration aupr&egrave;s de la CNIL.</strong></p>
					<p><img src="/images/cnil.gif" width="91" height="20" title='Commission Nationale Informatique et Libert�s' alt="CNIL" /></p>

					<p>Num&eacute;ro de d&eacute;claration : 1303433</p>
					<p>Vous disposez d'un droit d'acc&egrave;s, de modification, de rectification et de suppression des donn&eacute;es qui vous concernent
						( art. 34 de la loi 'Informatique et Libert&eacute;s' ).</p>
					<p>Pour l'exercer, <a href='http://www.top-immobilier-particulier.fr/noref/contact-equipe.php?action=print_form' rel='nofollow'><strong>Vous pouvez envoyer un courriel</strong></a><br />
						ou nous adresser un courrier postal &agrave; l'adresse ci-dessous</p>
				</div>
				<div class='legal_box'>
					<p><strong>2. Ce site est exploit&eacute; par :</strong></p>
					<p><img src="/images/siret.gif" alt="Num�ro de siret de l'entreprise" /></p>
				</div>
				<div class='legal_box'>
					<p><strong>3. Ce site est h&eacute;berg&eacute; par :</strong></p>
					<p>SARL SIVIT<br />
						SARL au capital de 8 000 Euros<br />
						Domaine des Quatre<br />
						Chemin des Planchettes<br />
						42110 Feurs - France
					</p>
				</div>
				<div class='legal_box'>
					<p><strong>4. Les informations qui sont collect&eacute;es sur ce site ne sont pas transmises &agrave; des tiers.</strong></p>
				</div>
				<?PHP print_xiti_code('infos-legales'); ?>
			</div><!-- end mention -->
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'>&nbsp;</div>
</body>

</html>