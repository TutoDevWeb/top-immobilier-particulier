<?PHP
session_start();
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_filter.php");
include("../include/inc_tracking.php");
include("../include/inc_random.php");
include("../include/inc_cibleclick.php");
include("../include/inc_tools.php");
include("../include/inc_ariane.php");
include("../include/inc_mail_compte_annonce.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"><head>
<title>Loupe - Augmenter ou diminuer la taile du texte</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
<link href="/styles/global-tools.css" rel="stylesheet" type="text/css" />
<meta name="robots" content="noindex,nofollow" />
</head>
<body>
  <div id='toolspan'><?PHP print_tools('tools'); ?></div>
  <div id='mainpan'>
    <div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIERS.FR c'est le top de l'immobilier entre particuliers" /></div>
    <div id='userpan'>
		  <?PHP make_ariane_page("+ Loupe -"); ?>
      <div id='loupe'>
        <h1>Vous pouvez r�gler la taille d'affichage des textes contenus dans les pages de ce site.</h1>
			  <div id='explain'>
          <p class='text12'>Les textes ont une taille de police relative, c'est � dire agrandissable selon les besoins.</p>
          <p class='text12'>Pour cela vous devez r�gler votre navigateur.</p>
          <p class='text12'>Selon le navigateur pour modifier la taille d'affichage du texte vous devez :</p>
			  </div>
        <ul>
          <li class='text12'><strong>Pour Internet Explorer</strong> : allez dans Affichage >> Taille du texte et choisissez.</li>
          <li class='text12'><strong>Pour Mozilla, Firefox ou Netscape</strong> : Maintenir la touche Ctrl enfonc� tout en tapant sur la touche + pour agrandir et - pour diminuer.</li>
          <li class='text12'><strong>Pour Opera</strong> : appuyez sur les touches + ou - du pav� num�rique. Ou bien allez dans Affichage >> Zoom et choisir.</li>
          <li class='text12'><strong>Pour Avec divers navigateurs</strong> : Ctrl + molette de la souris</li>
        </ul>
      </div> <!-- end loupe -->
    </div> <!-- end userpan -->
  </div> <!-- end mainpan -->
  <div id='footerpan'>&nbsp;</div><!-- end footerpan -->
</body>
</html>