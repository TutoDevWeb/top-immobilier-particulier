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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>FAQ</title>
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
		  <?PHP make_ariane_page("FAQ"); ?>
      <div id='faq'>
			<h1>Réponses aux questions fréquemment posées</h1>
      <h2>Questions relatives au site</h2>
      <ul>
        <li class='question'>But du site ?</li>
        <li class='answer'>Mettre à la disposition des vendeurs des <strong>moyens de qualité</strong> pour diffuser <strong>à un prix raisonnable</strong> leurs offres de vente de 
          biens immobiliers qu'ils soient situés sur le territoire Francais ou à l'étranger.</li>
        <li class='answer'>Mettre à la disposition des acheteurs des moyens spécifiques pour faciliter leur recherche :</li>
        <li class='answer'>- recevoir des alertes mail au moment de la mise en ligne de nouveaux produits selon des critères enregistrés.</li>
        <li class='answer'>- recevoir des alertes mail au moment ou le prix de produits sélectionnés est à la baisse.</li>
        <li class='answer'>- voir immédiatement les mensualités de crédit en mémorisant une capacité de financement.</li>
      </ul>
      <ul>
        <li class='question'>A qui s'adresse ce site ?</li>
        <li class='answer'>Ce site d'annonces immobilières s'adresse <strong>uniquement à des particuliers.</strong></li>
        <li class='question'>Par qui est exploité ce site ?</li>
        <li class='answer'>Ce site est exploité par WEBATLON-CREATION, entreprise spécilisée dans la création et l'exploitation de site 
          internet d'annonces immobilières. <strong>Ce site est totalement indépendant</strong> et ne défend aucun intérêt autres que 
          ceux de l'entreprise qui l'exploite</li>
        <li class='question'>Pourquoi ce site est-il payant ?</li>
        <li class='answer'>En dehors des considérations économiques, c'est le seul et unique moyen d'avoir un contenu de qualité. Sur 
          un site gratuit n'importe qui peut annoncer n'importe quoi. Nous en avons fait l'expérience. Nous ne sommes pas là pour vous 
          faire perdre votre temps.</li>
        <li class='question'>Il y a peu d'annonces, est ce que c'est un problème ?</li>
        <li class='answer'>Non, vous n'avez aucun intérêt à ce que votre annonce soit noyée dans la masse. Le fait qu'il y ait peu d'annonces 
          ne signifie pas que vous ne serez pas vu. Bien sûr ce n'est pas un site leader mais vous pouvez diversifier à peu de frais. 
          <a href="/compte-annonce/passer-annonce.php" class='navsearch11'>Consulter la liste des services que nous proposons</a> et essayer 
          de trouver mieux à ce prix.</li>
      </ul>
			<h2>Questions relatives aux annonces rédigées par les vendeurs.</h2>
      <ul>
        <li class='question'>Quel est mon mot de passe ? je ne l'ai rentré nulle part ?</li>
        <li class='answer'>Votre mot de passe est attribué automatiquement. Utilisez le lien de connexion fourni dans le courriel envoyé 
          par le site au moment de la création de l'annonce. Dans ces conditions la gestion du mot de passe est transparente pour vous.</li>
        <li class='question'>Je rentre mon email et mon mot de passe et je n'arrive pas à me connecter ?</li>
        <li class='answer'>C'est normal, si vous &ecirc;tes un vendeur vous vous connectez &agrave; un compte annonce et vous devez rentrer 
          votre numéro de téléphone (le téléphone 1) et le mot de passe qui vous a été attribué. Utilisez le lien de connexion fourni 
          dans le courriel envoyé par le site au moment de la création de l'annonce.</li>
        <li class='question'>Pourquoi lorsque je r&eacute;dige mon annonce certains caractères sont interdits ?</li>
        <li class='answer'>Certains caractères utilisés de façon mal intentionné peuvent déboucher sur un problème de sécurité au niveau 
          de notre serveur. C'est la raison de ce filtrage. De plus, il ne s'agit pas d'une petite annonce destinée à un journal. Vous 
          ne payez le nombre de mots. Vous avez la possibilité de rédiger votre annonce. Dans ce cas les caractères qui servent à faire 
          des abrégés ou autres encarts sont inutiles. </li>
        <li class='question'>Pourquoi un format paysage pour la première photo téléchargée ?</li>
        <li class='answer'>La première photo est affichée en première page. Pour des raisons d'esth&eacute;tique graphique, il faut quelle 
          soit au format paysage. Elle restera en premi&egrave;re page tant qu'une photo d'une annonce plus récente ne prendra pas sa 
          place. La photo est cliquable et génère donc des visites.</li>
        <li class='question'>Pourquoi dans certains cas il faudra réduire la taille des photos ?</li>
        <li class='answer'>Certains appareils photos numériques ont des résolutions importantes. Sans réglage adéquat cela peut se traduire 
          par des photos de très grande taille. Elles peuvent être difficiles à télécharger. Dans ce cas il faudra <a href="#" class='navsearch11'>réduire 
          la taille des photos</a> avant le téléchargement.</li>
        <li class='question'>Pourquoi un paiement par chèque ?</li>
        <li class='answer'>C'est encore le moyen de paiement le plus sûr. De plus il permet l'identification immédiate du donneur d'ordre. 
          En clair nous savons à qui nous avons à faire.</li>
      </ul>

			<h2>Questions relatives aux services de recherche proposés aux acheteurs</h2>
      <ul>
        <li class='question'>Les services proposés aux acheteurs sont-ils payants ?</li>
        <li class='answer'>Non c'est absolument gratuit.</li>
        <li class='question'>Les services proposés aux acheteurs sont-ils anonymes ?</li>
        <li class='answer'>Oui. A aucun moment on ne vous demandera votre nom ou une quelconque information.</li>
        <li class='question'>Les vendeurs connaissent-ils mon courriel ?</li>
        <li class='answer'>Non</li>
        <li class='question'>Les vendeurs peuvent-ils me contacter ?</li>
        <li class='answer'>Non. C'est vous qui avez cette possibilit&eacute;.</li>
        <li class='question'>Quel est mon mot de passe ? je ne l'ai rentré nulle part ?</li>
        <li class='answer'>Votre mot de passe est attribué automatiquement. Utilisez le lien de connexion fourni dans le courriel envoyé 
          par le site au moment de la création de l'annonce. Dans ces conditions la gestion du mot de passe est transparente pour vous.</li>
        <li class='question'>Que se passe-t-il si mon compte n'est pas activ&eacute; dans les 24 heures qui suivent sa création ?</li>
        <li class='answer'>Si votre compte n'est pas activé 24 heures apr&egrave;s votre inscription, vous ne pouvez plus vous y connecter. Vous ne recevez pas d'alertes. Il ne vous sert plus à rien.</li>
				<li class='answer'>Si votre compte n'est toujours pas activé <?PHP echo DUREE_RELANCER_COMPTE_RECHERCHE_INACTIF; ?> jours apr&egrave;s votre inscription, vous recevez un courriel de relance.</li>
				<li class='answer'>Si votre compte n'est toujours pas activé <?PHP echo DUREE_SUPPRIMER_COMPTE_RECHERCHE_INACTIF; ?> jours apr&egrave;s votre inscription, il est supprimé.</li>
				<li class='answer'>En fait l'activation nous permet d'être sûr que l'acheteur a fourni une adresse valide et sans erreur. Nous laissons 24 heures à l'acheteur pour faire cette manipulation de manière à ce qu'il ne soit pas dérangé par cette contrainte immédiatement après la création de son compte.</li>
        <li class='question'>Combien de temps dure mon inscription à un compte de recherche ?</li>
        <li class='answer'>Il n'y a pas de limite, cependant votre compte sera automatiquement supprimé si il n'y a pas de connexion pendant <?PHP echo COMPTE_RECHERCHE_PERIMER; ?> jours.</li>
      </ul>
			
			
      </div> <!-- faq -->
    </div> <!-- end userpan -->
  </div> <!-- end mainpan -->
  <div id='footerpan'>&nbsp;</div><!-- end footerpan -->
</body>
</html>
?>
