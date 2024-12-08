<?PHP

define('VERSION_SITE', 'VERSION-V7');       // Version du site
define('VERSION_DATE', '4-Septembre-2008');   // Date de la livraison

define('VERSION_SAG', 'SAG-V5');   // Version du format des cookie
define('STAT', 1);                 // Affichage du nomdre d'annonce dans le site
define('ANO_DEBUG', 0);            // Permet la mise en place du double click pour la mise au point des annonces

define('DUREE_ANNONCE', 6);   // Durée en mois.
define('PRIX_ANNONCE', 20);   // Prix pour la durée.
define('CHEQUE_ORDRE', 'WEBATLON CREATION');
define('CHEQUE_ADRESSE', '832 Av de Fréjus MANDELIEU 06210');
define('CHEQUE_LEGAL', 'Régime des micro-entreprises / TVA non applicable, article 293B du CGI');

define('SITE_NAME', 'TOP-IMMOBILIER-PARTICULIER');
define('SITE_NAME_FR', 'TOP-IMMOBILIER-PARTICULIER.FR');
define('URL_SITE', 'http://www.top-immobilier-particulier.fr/');
define('URL_SHORT_SITE', 'www.top-immobilier-particulier.fr');
define('URL_ADMIN', 'http://www.top-immobilier-particulier.fr/admin/');

define('URL_SITE_LEXIQUE', 'http://lexique.top-immobilier-particulier.fr/');
define('URL_SHORT_SITE_LEXIQUE', 'lexique.top-immobilier-particulier.fr');

// Email du webmaster
define('EMAIL_WEBMASTER', 'top.immobilier.particulier@gmail.com');


// Email sur lequel est envoyé un Carbon Copy
define('EMAIL_CC_WEBMASTER', 'jl.fondacci@gmail.com');

//-----------------------------------------------------------------------------
// Définitions relatives aux comptes de recherche
// Code de refus sur des echec sur des tentatives de connexion
define('COMPTE_RECHERCHE_CONNEXION_ECHEC_BLOQUAGE', 2);
define('COMPTE_RECHERCHE_CONNEXION_ECHEC_INACTIF', 3);
define('COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION', 4);
define('COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION_IDENTIFIANT', 5);

define('COMPTE_RECHERCHE_MAX_ALERTE_BAISSE', 10);
define('COMPTE_RECHERCHE_MAX_ALERTE_RECHERCHE', 5);

//-----------------------------------------------------------------------------
// Nombre de jour après lesquels on relance un compte inactif
define('DUREE_RELANCER_COMPTE_RECHERCHE_INACTIF', 15);
// Nombre de jour après lesquels on supprime un compte inactif
define('DUREE_SUPPRIMER_COMPTE_RECHERCHE_INACTIF', 21);

// Les comptes de recherche sont supprimés si il n' a pas de connexion 
// au bout d'un certains nombre de jour
define('COMPTE_RECHERCHE_PERIMER', 360);

//-----------------------------------------------------------------------------
// Définitions relatives aux comptes annonce
// Code de refus sur des echec sur des tentatives de connexion
define('COMPTE_ANNONCE_CONNEXION_ECHEC_BLOQUAGE', 2);
define('COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION', 4);
define('COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION_IDENTIFIANT', 5);

//-----------------------------------------------------------------------------
// Pour les cookies compte annonce ou compte recherche
define('IND_SAG_VERSION', 0);    // Version du logiciel
define('IND_COMPTE_EMAIL', 1);   // Email du compte recherche
define('IND_COMPTE_TEL_INS', 1); // Tel_Ins du compte Annonce
define('IND_COMPTE_PASS', 2);    // Password du compte recherche

//-----------------------------------------------------------------------------
// Nombre de jour aprés lesquels on relance une annonce en attente de paiement
define('DUREE_RELANCER_ATTENTE_PAIEMENT', 15);
// Nombre de jour aprés lesquels on efface une annonce en attente de paiement
define('DUREE_EFFACER_ATTENTE_PAIEMENT', 21);

//-----------------------------------------
// Coefficient de simulation du nombre d'annonces
// Le 10/08/2008 on passe de 2 à 1.5
// Le 16/09/2008 on passe de 1.5 à 1.0
define('COEF_SIMUL', 1.0);
//-----------------------------------------
// Catégorie de produit
define('VAL_NUM_TOUS_PRODUITS', '0');
define('VAL_NUM_APPARTEMENT', '1');
define('VAL_NUM_PAVILLON', '2');
define('VAL_NUM_LOFT', '3');
define('VAL_NUM_VILLA', '4');
define('VAL_NUM_MAISON_VILLAGE', '5');
define('VAL_NUM_CHALET', '6');
define('VAL_NUM_RIAD', '7');
define('VAL_NUM_MAISON', '8');
//----------------------
define('VAL_STR_TOUS_PRODUITS', 'Tous Produits');
define('VAL_STR_APPARTEMENT', 'Appartement');
define('VAL_STR_PAVILLON', 'Pavillon');
define('VAL_STR_LOFT', 'Loft');
define('VAL_STR_VILLA', 'Villa');
define('VAL_STR_MAISON_VILLAGE', 'Maison de Village');
define('VAL_STR_CHALET', 'Chalet');
define('VAL_STR_RIAD', 'Riad');
define('VAL_STR_MAISON', 'Maison');
//----------------------
define('VAL_DTB_TOUS_PRODUITS', '');
define('VAL_DTB_APPARTEMENT', 'appartement');
define('VAL_DTB_PAVILLON', 'pavillon');
define('VAL_DTB_LOFT', 'loft');
define('VAL_DTB_VILLA', 'villa');
define('VAL_DTB_MAISON_VILLAGE', 'maison_de_village');
define('VAL_DTB_CHALET', 'chalet');
define('VAL_DTB_RIAD', 'riad');
define('VAL_DTB_MAISON', 'maison');
//----------------------

//-----------------------------------------
// Paramétrage de la recherche
//
define('RECH_SLIDE', 10);       // Taille d'une tranche d'affichage de résultats de la recherche
define('RECH_MAX_SLIDE', 10);  // Nombre maximal de tranche  de la recherche

//-----------------------------------------
// France valeur des zoom
define('ZOOM_REGION', 8);
define('ZOOM_DEPT', 9); // Avec zoom à 9 il y a environ 400 villes en code 4
define('ZOOM_VILLE', 11);

// Repertoire des photos
define('ABS_ROOT_PHOTO', '/home/web/tip/tip-fr/images_fiches/');

// Taile des thumbs
define('THUMB_X', 100); // Valeur X d'une photo réduite
define('THUMB_Y', 75);  // Valeur Y d'une photo réduite

//----------------------------------
// Définition des DEBUG
// Administration
define('DEBUG_ADM_ANO_ACTION', 1);
define('DEBUG_ADM_ANO_MONIT', 1);

// Index
define('DEBUG_INDEX', 0);

define('DEBUG_DTB_COMPTE', 0);

// Gestion des annonces
define('DEBUG_MAIL', 0);
define('DEBUG_MODIFIER', 0);
define('DEBUG_FICHE', 0);
define('DEBUG_ANO_FORM', 0);
define('DEBUG_DTB_ANO', 0);

define('DEBUG_SEARCH_KEYWORDS', 0);

define('DEBUG_IDENTIFICATION_CTRL', 0);

// Formulaire de Contact
define('DEBUG_CONTACT_WEBMASTER', 0);
define('DEBUG_CONTACT_ANO', 0);

// Consultation
define('DEBUG_DETAILS', 0);
define('DEBUG_RECHERCHE', 0);

// Photo
define('DEBUG_DIAPORAMA', 0);
define('DEBUG_PHOTO', 0);

define('CODE_CTA', 1);
