<?PHP
//--------------------------------------------------------------------------------
function make_ariane_paris_keywords($keywords) {
	echo "<p><a class='home' href='/' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a class='page' href='/immobilier-entre-particuliers-paris.htm'>Immobilier particuliers Paris</a>&nbsp;&raquo;&nbsp;<strong>$keywords</strong></p>";
}
//--------------------------------------------------------------------------------
function make_ariane_page($page) {
	echo "<p><a href='/' class=' home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<strong>{$page}</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_compte_recherche($page) {
	echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-recherche/gestion-connexion-recherche.php?action=accueil_compte_recherche' class='page' title='Accéder à votre compte recherche'>Votre compte recherche</a>&nbsp;&raquo;&nbsp;<strong>$page</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_compte_annonce($page) {
	echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/gestion-connexion-annonce.php?action=accueil_compte_annonce' class='page' title='Accéder à votre compte annonce'>Accueil Compte Annonce</a>&nbsp;&raquo;&nbsp;<strong>$page</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_passer_annonce($zone) {
	if ($zone == 'france') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<strong>France</strong></p>\n";
	if ($zone == 'domtom') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<strong>Dom-Tom</strong></p>\n";
	if ($zone == 'etranger') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<strong>Etranger</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_fiche_preparation($zone) {
	if ($zone == 'france') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/vendre-de-particulier-a-particulier-en-france.htm' class='page' title='Déposer une offre de vente de logement en France'>France</a>&nbsp;&raquo;&nbsp;<strong>Page de Préparation</strong></p>\n";
	if ($zone == 'domtom') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/entre-particuliers-dom-tom.htm' class='page' title='Déposer une offre de vente de logement dans les Dom-Tom' >Dom-Tom</a>&nbsp;&raquo;&nbsp;<strong>Page de Préparation</strong></p>\n";
	if ($zone == 'etranger') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/vendre-entre-particulier-a-etranger.htm' class='page' title=\"Déposer une offre de vente de logement à l'étranger\" >Etranger</a>&nbsp;&raquo;&nbsp;<strong>Page de Préparation</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_upload($zone) {
	if ($zone == 'france') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/vendre-de-particulier-a-particulier-en-france.htm' class='page' title='Déposer une offre de vente de logement en France'>France</a>&nbsp;&raquo;&nbsp;<strong>Gestion des photos</strong></p>\n";
	if ($zone == 'domtom') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/entre-particuliers-dom-tom.htm' class='page' title='Déposer une offre de vente de logement dans les Dom-Tom' >Dom-Tom</a>&nbsp;&raquo;&nbsp;<strong>Gestion des photos</strong></p>\n";
	if ($zone == 'etranger') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/vendre-entre-particulier-a-etranger.htm' class='page' title=\"Déposer une offre de vente de logement à l'étranger\" >Etranger</a>&nbsp;&raquo;&nbsp;<strong>Gestion des photos</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_maps($zone) {
	if ($zone == 'france') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/vendre-de-particulier-a-particulier-en-france.htm' class='page' title='Déposer une offre de vente de logement en France'>France</a>&nbsp;&raquo;&nbsp;<strong>Gestion des Cartes</strong></p>\n";
	if ($zone == 'domtom') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/entre-particuliers-dom-tom.htm' class='page' title='Déposer une offre de vente de logement dans les Dom-Tom' >Dom-Tom</a>&nbsp;&raquo;&nbsp;<strong>Gestion des Cartes</strong></p>\n";
	if ($zone == 'etranger') echo "<p><a href='/' class='home' title=\"Aller à l'accueil\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='/compte-annonce/passer-annonce.php' class='page' title='Passer une annonce sur TOP-IMMOBILIER-PARTICULIERS.FR'>Passer une Annonce</a>&nbsp;&raquo;&nbsp;<a href='/vendre-entre-particulier-a-etranger.htm' class='page' title=\"Déposer une offre de vente de logement à l'étranger\" >Etranger</a>&nbsp;&raquo;&nbsp;<strong>Gestion des Cartes</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_lexique_index() {
	$url_site      = URL_SITE;
	$url_site_site = URL_SHORT_SITE;
	echo "<p><a href='$url_site' class='home' title=\"Aller à l'accueil du site $url_site_site\">Accueil</a>&nbsp;&raquo;&nbsp;<strong>Lexique</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_lexique_element($elm_url) {
	$url_site      = URL_SITE;
	$url_site_site = URL_SHORT_SITE;
	$url_site_lexique      = URL_SITE_LEXIQUE;
	$url_site_site_lexique = URL_SHORT_SITE_LEXIQUE;
	echo "<p><a href='$url_site' class='home' title=\"Aller à l'accueil du site $url_site_site\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='$url_site_lexique' class='page' title=\"Aller sur l'accueil du lexique\">Lexique</a>&nbsp;&raquo;&nbsp;<strong>$elm_url</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_news_index() {
	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;
	echo "<p><a href='$url_site' class='home' title=\"Aller à l'accueil du site $url_short_site\">Accueil</a>&nbsp;&raquo;&nbsp;<strong>Actualités Immobilières</strong></p>\n";
}
//--------------------------------------------------------------------------------
function make_ariane_news_articles($news_url) {
	$url_site       = URL_SITE;
	$url_short_site = URL_SHORT_SITE;
	echo "<p><a href='$url_site' class='home' title=\"Aller à l'accueil du site $url_short_site\">Accueil</a>&nbsp;&raquo;&nbsp;<a href='{$url_site}actualites-immobilieres' class='page' title=\"Aller sur l'accueil de l'actualités immobilières\">Actualités Immobilières</a>&nbsp;&raquo;&nbsp;<strong>$news_url</strong></p>\n";
}
