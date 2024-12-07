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
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<?PHP make_ariane_page("FAQ"); ?>
			<div id='faq'>
				<h1>R�ponses aux questions fr�quemment pos�es</h1>
				<h2>Questions relatives au site</h2>
				<ul>
					<li class='question'>But du site ?</li>
					<li class='answer'>Mettre � la disposition des vendeurs des <strong>moyens de qualit�</strong> pour diffuser <strong>� un prix raisonnable</strong> leurs offres de vente de
						biens immobiliers qu'ils soient situ�s sur le territoire Francais ou � l'�tranger.</li>
					<li class='answer'>Mettre � la disposition des acheteurs des moyens sp�cifiques pour faciliter leur recherche :</li>
					<li class='answer'>- recevoir des alertes mail au moment de la mise en ligne de nouveaux produits selon des crit�res enregistr�s.</li>
					<li class='answer'>- recevoir des alertes mail au moment ou le prix de produits s�lectionn�s est � la baisse.</li>
					<li class='answer'>- voir imm�diatement les mensualit�s de cr�dit en m�morisant une capacit� de financement.</li>
				</ul>
				<ul>
					<li class='question'>A qui s'adresse ce site ?</li>
					<li class='answer'>Ce site d'annonces immobili�res s'adresse <strong>uniquement � des particuliers.</strong></li>
					<li class='question'>Par qui est exploit� ce site ?</li>
					<li class='answer'>Ce site est exploit� par WEBATLON-CREATION, entreprise sp�cilis�e dans la cr�ation et l'exploitation de site
						internet d'annonces immobili�res. <strong>Ce site est totalement ind�pendant</strong> et ne d�fend aucun int�r�t autres que
						ceux de l'entreprise qui l'exploite</li>
					<li class='question'>Pourquoi ce site est-il payant ?</li>
					<li class='answer'>En dehors des consid�rations �conomiques, c'est le seul et unique moyen d'avoir un contenu de qualit�. Sur
						un site gratuit n'importe qui peut annoncer n'importe quoi. Nous en avons fait l'exp�rience. Nous ne sommes pas l� pour vous
						faire perdre votre temps.</li>
					<li class='question'>Il y a peu d'annonces, est ce que c'est un probl�me ?</li>
					<li class='answer'>Non, vous n'avez aucun int�r�t � ce que votre annonce soit noy�e dans la masse. Le fait qu'il y ait peu d'annonces
						ne signifie pas que vous ne serez pas vu. Bien s�r ce n'est pas un site leader mais vous pouvez diversifier � peu de frais.
						<a href="/compte-annonce/passer-annonce.php" class='navsearch11'>Consulter la liste des services que nous proposons</a> et essayer
						de trouver mieux � ce prix.
					</li>
				</ul>
				<h2>Questions relatives aux annonces r�dig�es par les vendeurs.</h2>
				<ul>
					<li class='question'>Quel est mon mot de passe ? je ne l'ai rentr� nulle part ?</li>
					<li class='answer'>Votre mot de passe est attribu� automatiquement. Utilisez le lien de connexion fourni dans le courriel envoy�
						par le site au moment de la cr�ation de l'annonce. Dans ces conditions la gestion du mot de passe est transparente pour vous.</li>
					<li class='question'>Je rentre mon email et mon mot de passe et je n'arrive pas � me connecter ?</li>
					<li class='answer'>C'est normal, si vous &ecirc;tes un vendeur vous vous connectez &agrave; un compte annonce et vous devez rentrer
						votre num�ro de t�l�phone (le t�l�phone 1) et le mot de passe qui vous a �t� attribu�. Utilisez le lien de connexion fourni
						dans le courriel envoy� par le site au moment de la cr�ation de l'annonce.</li>
					<li class='question'>Pourquoi lorsque je r&eacute;dige mon annonce certains caract�res sont interdits ?</li>
					<li class='answer'>Certains caract�res utilis�s de fa�on mal intentionn� peuvent d�boucher sur un probl�me de s�curit� au niveau
						de notre serveur. C'est la raison de ce filtrage. De plus, il ne s'agit pas d'une petite annonce destin�e � un journal. Vous
						ne payez le nombre de mots. Vous avez la possibilit� de r�diger votre annonce. Dans ce cas les caract�res qui servent � faire
						des abr�g�s ou autres encarts sont inutiles. </li>
					<li class='question'>Pourquoi un format paysage pour la premi�re photo t�l�charg�e ?</li>
					<li class='answer'>La premi�re photo est affich�e en premi�re page. Pour des raisons d'esth&eacute;tique graphique, il faut quelle
						soit au format paysage. Elle restera en premi&egrave;re page tant qu'une photo d'une annonce plus r�cente ne prendra pas sa
						place. La photo est cliquable et g�n�re donc des visites.</li>
					<li class='question'>Pourquoi dans certains cas il faudra r�duire la taille des photos ?</li>
					<li class='answer'>Certains appareils photos num�riques ont des r�solutions importantes. Sans r�glage ad�quat cela peut se traduire
						par des photos de tr�s grande taille. Elles peuvent �tre difficiles � t�l�charger. Dans ce cas il faudra <a href="#" class='navsearch11'>r�duire
							la taille des photos</a> avant le t�l�chargement.</li>
					<li class='question'>Pourquoi un paiement par ch�que ?</li>
					<li class='answer'>C'est encore le moyen de paiement le plus s�r. De plus il permet l'identification imm�diate du donneur d'ordre.
						En clair nous savons � qui nous avons � faire.</li>
				</ul>

				<h2>Questions relatives aux services de recherche propos�s aux acheteurs</h2>
				<ul>
					<li class='question'>Les services propos�s aux acheteurs sont-ils payants ?</li>
					<li class='answer'>Non c'est absolument gratuit.</li>
					<li class='question'>Les services propos�s aux acheteurs sont-ils anonymes ?</li>
					<li class='answer'>Oui. A aucun moment on ne vous demandera votre nom ou une quelconque information.</li>
					<li class='question'>Les vendeurs connaissent-ils mon courriel ?</li>
					<li class='answer'>Non</li>
					<li class='question'>Les vendeurs peuvent-ils me contacter ?</li>
					<li class='answer'>Non. C'est vous qui avez cette possibilit&eacute;.</li>
					<li class='question'>Quel est mon mot de passe ? je ne l'ai rentr� nulle part ?</li>
					<li class='answer'>Votre mot de passe est attribu� automatiquement. Utilisez le lien de connexion fourni dans le courriel envoy�
						par le site au moment de la cr�ation de l'annonce. Dans ces conditions la gestion du mot de passe est transparente pour vous.</li>
					<li class='question'>Que se passe-t-il si mon compte n'est pas activ&eacute; dans les 24 heures qui suivent sa cr�ation ?</li>
					<li class='answer'>Si votre compte n'est pas activ� 24 heures apr&egrave;s votre inscription, vous ne pouvez plus vous y connecter. Vous ne recevez pas d'alertes. Il ne vous sert plus � rien.</li>
					<li class='answer'>Si votre compte n'est toujours pas activ� <?PHP echo DUREE_RELANCER_COMPTE_RECHERCHE_INACTIF; ?> jours apr&egrave;s votre inscription, vous recevez un courriel de relance.</li>
					<li class='answer'>Si votre compte n'est toujours pas activ� <?PHP echo DUREE_SUPPRIMER_COMPTE_RECHERCHE_INACTIF; ?> jours apr&egrave;s votre inscription, il est supprim�.</li>
					<li class='answer'>En fait l'activation nous permet d'�tre s�r que l'acheteur a fourni une adresse valide et sans erreur. Nous laissons 24 heures � l'acheteur pour faire cette manipulation de mani�re � ce qu'il ne soit pas d�rang� par cette contrainte imm�diatement apr�s la cr�ation de son compte.</li>
					<li class='question'>Combien de temps dure mon inscription � un compte de recherche ?</li>
					<li class='answer'>Il n'y a pas de limite, cependant votre compte sera automatiquement supprim� si il n'y a pas de connexion pendant <?PHP echo COMPTE_RECHERCHE_PERIMER; ?> jours.</li>
				</ul>


			</div> <!-- faq -->
		</div> <!-- end userpan -->
	</div> <!-- end mainpan -->
	<div id='footerpan'>&nbsp;</div><!-- end footerpan -->
</body>

</html>
?>