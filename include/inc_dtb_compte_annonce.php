<?PHP

//--------------------------------------------------------------------------------------------------------
function insert_annonce($connexion, $password, $file, $line) {

	$zone        = mysqli_real_escape_string($connexion, $_SESSION['zone'] ?? '');
	$zone_pays   = mysqli_real_escape_string($connexion, $_SESSION['zone_pays'] ?? '');
	$zone_region = mysqli_real_escape_string($connexion, $_SESSION['zone_region'] ?? '');
	$zone_dept   = mysqli_real_escape_string($connexion, $_SESSION['zone_dept'] ?? '');
	$zone_ville  = mysqli_real_escape_string($connexion, $_SESSION['zone_ville'] ?? '');
	$zone_ard    = mysqli_real_escape_string($connexion, $_SESSION['zone_ard'] ?? '');
	$zone_dom    = mysqli_real_escape_string($connexion, $_SESSION['zone_dom'] ?? '');
	$num_dept    = mysqli_real_escape_string($connexion, $_SESSION['num_dept'] ?? '');

	$tel_ins    = mysqli_real_escape_string($connexion, $_SESSION['tel_ins'] ?? '');
	$email      = mysqli_real_escape_string($connexion, $_SESSION['sagmail'] ?? '');
	$ok_email   = mysqli_real_escape_string($connexion, $_SESSION['ok_email'] ?? '');
	$tel_bis    = mysqli_real_escape_string($connexion, $_SESSION['tel_bis'] ?? '');
	$etat       = 'attente_paiement';


	$typp     = mysqli_real_escape_string($connexion, $_SESSION['typp'] ?? '');
	$nbpi     = mysqli_real_escape_string($connexion, $_SESSION['nbpi'] ?? '');
	$surf     = mysqli_real_escape_string($connexion, $_SESSION['surf'] ?? '');
	$prix     = mysqli_real_escape_string($connexion, $_SESSION['prix'] ?? '');
	$quart_s  = mysqli_real_escape_string($connexion, $_SESSION['quart'] ?? '');
	$blabla_s = mysqli_real_escape_string($connexion, $_SESSION['blabla'] ?? '');

	$maps_lat   = $_SESSION['maps_lat'];
	$maps_lng   = $_SESSION['maps_lng'];
	$maps_actif = $_SESSION['maps_actif'];

	$wwwblog    = mysqli_real_escape_string($connexion, $_SESSION['wwwblog'] ?? '');

	$ip_ins = $_SERVER['REMOTE_ADDR'];

	$insert = "INSERT INTO ano (tel_ins,ip_ins,password,email,ok_email,
                              tel_bis,etat,dat_ins,
                              zone,zone_pays,zone_region,zone_dept,zone_ville,zone_ard,zone_dom,num_dept,
                              typp,nbpi,surf,prix,quart,blabla,
                              maps_lat,maps_lng,maps_actif,wwwblog) 
              VALUES ('$tel_ins','$ip_ins','$password','$email','$ok_email',
                      '$tel_bis','$etat',now(),
                      '$zone','$zone_pays','$zone_region','$zone_dept','$zone_ville','$zone_ard','$zone_dom','$num_dept',
                      '$typp','$nbpi','$surf','$prix','$quart_s','$blabla_s',
                      '$maps_lat','$maps_lng','$maps_actif','$wwwblog')";
	dtb_query($connexion, $insert, $file, $line, DEBUG_DTB_ANO);

	return (mysqli_insert_id($connexion));
}
//--------------------------------------------------------------------------------------------------------
// Mise à jour d'une annonce.
// On ne met à jour que la partie produit.
//--------------------------------------------------------------------------------------------------------
function update_annonce($connexion, $etat, $file, $line) {

	$tel_ins  = mysqli_real_escape_string($connexion, $_SESSION['tel_ins'] ?? '');
	$ok_email = mysqli_real_escape_string($connexion, $_SESSION['ok_email'] ?? '');
	$tel_bis  = mysqli_real_escape_string($connexion, $_SESSION['tel_bis'] ?? '');

	$zone        = mysqli_real_escape_string($connexion, $_SESSION['zone'] ?? '');
	$zone_pays   = mysqli_real_escape_string($connexion, $_SESSION['zone_pays'] ?? '');
	$zone_region = mysqli_real_escape_string($connexion, $_SESSION['zone_region'] ?? '');
	$zone_dept   = mysqli_real_escape_string($connexion, $_SESSION['zone_dept'] ?? '');
	$zone_ville  = mysqli_real_escape_string($connexion, $_SESSION['zone_ville'] ?? '');
	$zone_ard    = mysqli_real_escape_string($connexion, $_SESSION['zone_ard'] ?? '');
	$zone_dom    = mysqli_real_escape_string($connexion, $_SESSION['zone_dom'] ?? '');
	$num_dept    = mysqli_real_escape_string($connexion, $_SESSION['num_dept'] ?? '');

	$typp       = mysqli_real_escape_string($connexion, $_SESSION['typp'] ?? '');
	$nbpi       = mysqli_real_escape_string($connexion, $_SESSION['nbpi'] ?? '');
	$surf       = mysqli_real_escape_string($connexion, $_SESSION['surf'] ?? '');
	$prix       = mysqli_real_escape_string($connexion, $_SESSION['prix'] ?? '');
	$quart_s    = mysqli_real_escape_string($connexion, $_SESSION['quart'] ?? '');
	$blabla_s   = mysqli_real_escape_string($connexion, $_SESSION['blabla'] ?? '');

	$maps_lat   = $_SESSION['maps_lat'];
	$maps_lng   = $_SESSION['maps_lng'];
	$maps_actif = $_SESSION['maps_actif'];

	$wwwblog    = mysqli_real_escape_string($connexion, $_SESSION['wwwblog'] ?? '');

	$update = "UPDATE ano SET ok_email='$ok_email',
                            tel_bis='$tel_bis',
                            etat='$etat',
                            zone='$zone',
                            zone_pays='$zone_pays',
                            zone_region='$zone_region',
                            zone_dept='$zone_dept',
                            zone_ville='$zone_ville',
                            zone_ard='$zone_ard',
                            zone_dom='$zone_dom',
                            num_dept='$num_dept',
                            typp='$typp',
                            nbpi='$nbpi',
                            surf='$surf',
                            quart='$quart_s',
                            prix='$prix',
                            blabla='$blabla_s', 
                            maps_lat='$maps_lat',
                            maps_lng='$maps_lng',
                            maps_actif='$maps_actif',
                            wwwblog='$wwwblog'
                            WHERE tel_ins='$tel_ins' LIMIT 1";

	dtb_query($connexion, $update, $file, $line, DEBUG_DTB_ANO);
}
//--------------------------------------------------------------------------------------------------------
function compte_annonce_existe($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT * FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	if (mysqli_num_rows($result)) return true;
	else return false;
}
//--------------------------------------------------------------------------------------------------------
function get_zone($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT zone FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	list($zone) = mysqli_fetch_row($result);

	return $zone;
}
//--------------------------------------------------------------------------------------------------------
function get_etat($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT etat FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	list($etat) = mysqli_fetch_row($result);

	return $etat;
}
//--------------------------------------------------------------------------------------------------------
function get_ida($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT ida FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	list($ida) = mysqli_fetch_row($result);

	return $ida;
}
//--------------------------------------------------------------------------------------------------------
function get_email($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT email FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	if (mysqli_num_rows($result)) {
		list($email) = mysqli_fetch_row($result);
		return $email;
	} else return false;
}
//--------------------------------------------------------------------------------------------------------
function get_password($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT password FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	list($password) = mysqli_fetch_row($result);

	return $password;
}
//--------------------------------------------------------------------------------------------------------
function get_annonceur_items($connexion, $tel_ins, $file, $line) {

	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	$select = "SELECT nom,prenom,adresse,ville,code,email FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $select, $file, $line, DEBUG_DTB_ANO);

	$data = mysqli_fetch_array($result, MYSQLI_ASSOC);

	return $data;
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce en ligne pour affichage accueil
function get_nb_ano($connexion) {

	$select = "SELECT COUNT(ida) FROM ano WHERE etat='ligne'";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
	list($nb) = mysqli_fetch_row($result);

	return $nb;
}
//------------------------------------------------------------------------------------------------
function get_dept_region_by_num_dept($connexion, $num_dept, &$dept, &$region) {

	$query  = "SELECT d.dept,r.region FROM loc_departement as d, loc_region as r WHERE d.idr=r.idr AND d.dept_num='$num_dept'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);
	list($dept, $region) = mysqli_fetch_row($result);
}
//------------------------------------------------------------------------------------------------
function get_ip_dat($connexion, $tel_ins, &$ip_ins, &$dat_ins) {

	$query  = "SELECT ip_ins,dat_ins FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);
	list($ip_ins, $dat_ins) = mysqli_fetch_row($result);
}
//--------------------------------------------------------------------------------------------------------
// Retourne les meilleurs taux de clics
function select_meilleure($connexion) {

	$select = "SELECT ard,typp,prix,quart,nbpi,surf,pa_note,tel_ins,hits FROM ano WHERE etat='ligne' ORDER BY hits DESC limit 5";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);

	return $result;
}
//--------------------------------------------------------------------------------------------------------
// Retourne les dernières entrées
function select_derniere($connexion) {

	$select = "SELECT ard,typp,prix,quart,nbpi,surf,pa_note,tel_ins,hits FROM ano WHERE etat='ligne' ORDER BY dat_ins DESC limit 5";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);

	return $result;
}
//--------------------------------------------------------------------------------------------------------
function set_date_modification($connexion, $tel_ins, $file, $line) {

	$update = "UPDATE ano SET dat_mod=now() WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($connexion, $update, $file, $line, DEBUG_DTB_ANO);
}
//--------------------------------------------------------------------------------------------------------
function get_date_modification($connexion, $tel_ins, $file, $line) {

	$query  = "SELECT dat_mod FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_ANO);
	list($dat_mod) = mysqli_fetch_row($result);
	return $dat_mod;
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce sur la france
// Si simul vaut 1 on va générer un chiffre simulé
function get_nb_ano_by_typp_france($connexion, $simul, &$nb_appartement, &$nb_maison, &$nb_loft, &$nb_chalet) {

	$nb_appartement = 0;
	$nb_maison      = 0;
	$nb_loft        = 0;
	$nb_chalet      = 0;

	$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND zone='france' GROUP BY typp";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
	while (list($typp, $nb) = mysqli_fetch_row($result)) {
		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement = $nb;
		else if ($typp == VAL_DTB_MAISON) $nb_maison      = $nb;
		else if ($typp == VAL_DTB_LOFT) $nb_loft        = $nb;
		else if ($typp == VAL_DTB_CHALET) $nb_chalet      = $nb;
	}

	if ($simul == true) {

		// Coefficient mutiplicateur
		$coef = COEF_SIMUL;

		// Les silver immo sont les annonces simulées  
		$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND email='silver_immo@yahoo.fr' AND zone='france' GROUP BY typp";
		$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
		while (list($typp, $nb) = mysqli_fetch_row($result)) {
			if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement_silver = $nb * $coef;
			else if ($typp == VAL_DTB_MAISON) $nb_maison_silver      = $nb * $coef;
			else if ($typp == VAL_DTB_LOFT) $nb_loft_silver        = $nb * $coef;
			else if ($typp == VAL_DTB_CHALET) $nb_chalet_silver      = $nb * $coef;
		}

		$nb_appartement += (int)$nb_appartement_silver;
		$nb_maison      += (int)$nb_maison_silver;
		$nb_loft        += (int)$nb_loft_silver;
		$nb_chalet      += (int)$nb_chalet_silver;
	}
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce sur la région
function get_nb_ano_by_typp_region($connexion, $region, &$nb_appartement, &$nb_maison, &$nb_loft, &$nb_chalet) {

	$nb_appartement = 0;
	$nb_maison      = 0;
	$nb_loft        = 0;
	$nb_chalet      = 0;

	$region = addslashes($connexion, $region);

	$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND zone_region='$region' GROUP BY typp";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
	while (list($typp, $nb) = mysqli_fetch_row($result)) {
		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement = $nb;
		else if ($typp == VAL_DTB_MAISON) $nb_maison      = $nb;
		else if ($typp == VAL_DTB_LOFT) $nb_loft        = $nb;
		else if ($typp == VAL_DTB_CHALET) $nb_chalet      = $nb;
	}
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce sur le d�partement
function get_nb_ano_by_typp_dept($connexion, $zone_dept, &$nb_appartement, &$nb_maison, &$nb_loft, &$nb_chalet) {

	$nb_appartement = 0;
	$nb_maison      = 0;
	$nb_loft        = 0;
	$nb_chalet      = 0;

	$zone_dept = addslashes($connexion, $zone_dept);

	$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND zone_dept='$zone_dept' GROUP BY typp";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
	while (list($typp, $nb) = mysqli_fetch_row($result)) {
		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement = $nb;
		else if ($typp == VAL_DTB_MAISON) $nb_maison      = $nb;
		else if ($typp == VAL_DTB_LOFT) $nb_loft        = $nb;
		else if ($typp == VAL_DTB_CHALET) $nb_chalet      = $nb;
	}
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce sur la ville
function get_nb_ano_by_typp_ville($connexion, $zone_ville, &$nb_appartement, &$nb_maison, &$nb_loft, &$nb_chalet) {

	$nb_appartement = 0;
	$nb_maison      = 0;
	$nb_loft        = 0;
	$nb_chalet      = 0;

	$zone_ville = addslashes($zone_ville);

	$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND zone_ville='$zone_ville' GROUP BY typp";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
	while (list($typp, $nb) = mysqli_fetch_row($result)) {
		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement = $nb;
		else if ($typp == VAL_DTB_MAISON) $nb_maison      = $nb;
		else if ($typp == VAL_DTB_LOFT) $nb_loft        = $nb;
		else if ($typp == VAL_DTB_CHALET) $nb_chalet      = $nb;
	}
}
//--------------------------------------------------------------------------------------------------------
// Retourne le nombre d'annonce en ligne par type de produit
function get_nb_ano_by_typp_zone($connexion, $zone, &$nb_appartement, &$nb_maison, &$nb_loft, &$nb_chalet) {

	$nb_appartement = 0;
	$nb_maison      = 0;
	$nb_loft        = 0;
	$nb_chalet      = 0;

	$select = "SELECT typp,COUNT(*) FROM ano WHERE etat='ligne' AND zone='$zone' GROUP BY typp";
	$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
	while (list($typp, $nb) = mysqli_fetch_row($result)) {
		if ($typp == VAL_DTB_APPARTEMENT) $nb_appartement = $nb;
		else if ($typp == VAL_DTB_MAISON) $nb_maison      = $nb;
		else if ($typp == VAL_DTB_LOFT) $nb_loft        = $nb;
		else if ($typp == VAL_DTB_CHALET) $nb_chalet      = $nb;
	}
}
//--------------------------------------------------------------------------------------------------------
function get_cntblog($connexion, $tel_ins) {

	$query = "SELECT cntblog FROM ano WHERE wwwblog != '' AND tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);

	if (mysqli_num_rows($result)) {
		list($cntblog) = mysqli_fetch_row($result);
		return $cntblog;
	} else return false;
}
//--------------------------------------------------------------------------------------------------------
function get_dat_fin($connexion, $tel_ins) {

	$query = "SELECT dat_fin FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_ANO);

	if (mysqli_num_rows($result)) {
		list($dat_fin) = mysqli_fetch_row($result);
		return $dat_fin;
	} else return false;
}
/*----------------------------------------------------------------------------------------------------*/
// Lit les identifiants dans le cookie
// Renvoi faux si rien touver
function get_cookie_annonce(&$compte_tel_ins, &$compte_pass) {

	if (isset($_COOKIE["connexion_compte_annonce"])) {

		$cookie = explode('|', $_COOKIE["connexion_compte_annonce"]);

		// Position des valeurs dans le cookie
		$sag_version    = $cookie[IND_SAG_VERSION];
		$compte_tel_ins = $cookie[IND_COMPTE_TEL_INS];
		$compte_pass    = $cookie[IND_COMPTE_PASS];

		if ($sag_version == VERSION_SAG) return true;
		else return false;
	}
	return false;
}
/*----------------------------------------------------------------------------------------------------*/
function demande_connexion_annonce($connexion, $compte_tel_ins, $compte_pass, &$code_refus, $file, $line) {

	// Si les identifiants sont là, on s'en sert pour faire l'authentification
	if ($compte_tel_ins != '' && $compte_pass != '') {

		$compte_tel_ins_s = mysqli_real_escape_string($connexion, $compte_tel_ins);
		$compte_pass_s    = mysqli_real_escape_string($connexion, $compte_pass);
		$authentification_type = 'IDENTIFIANT';

		tracking($connexion, CODE_CTA, 'OK', "Compte Annonce : Demande Connexion avec identifiant:$compte_tel_ins:$compte_pass", $file, $line);


		// Sinon c'est une demande de connexion avec authentification par cookie
	} else if (isset($_COOKIE["connexion_compte_annonce"])) {

		$cookie = explode('|', $_COOKIE["connexion_compte_annonce"]);

		// Position des valeurs dans le cookie
		$sag_version    = $cookie[IND_SAG_VERSION];
		$compte_tel_ins = $cookie[IND_COMPTE_TEL_INS];
		$compte_pass    = $cookie[IND_COMPTE_PASS];

		tracking($connexion, CODE_CTA, 'OK', "Compte Annonce : Demande Connexion Cookie:$compte_tel_ins:$compte_pass", $file, $line);

		if ($sag_version == VERSION_SAG) {
			$compte_tel_ins_s = mysqli_real_escape_string($connexion, $compte_tel_ins);
			$compte_pass_s    = mysqli_real_escape_string($connexion, $compte_pass);
		} else {
			tracking($connexion, CODE_CTA, 'KO', "Compte Annonce : Echec Connexion Cookie:$compte_tel_ins:$compte_pass:$sag_version: ECHEC_VERSION", $file, $line);
			return COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION;
		}
		// Dans ce cas il n'y a pas d'identifiants
	} else {

		tracking($connexion, CODE_CTA, 'KO', "Compte Annonce : Echec Connexion: pas identifiant : ECHEC_AUTHENTIFICATION", $file, $line);
		$code_refus = COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION;
		return false;
	}

	// Requête pour connexion
	$query  = "SELECT ida,email FROM ano WHERE tel_ins='$compte_tel_ins_s' AND password='$compte_pass_s' AND bloquage='no'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	// Si il y a un résultat
	if (mysqli_num_rows($result)) {

		// On peut se connecter
		list($ida, $email) = mysqli_fetch_row($result);

		// Clear de la session
		unset($_SESSION);
		$_SESSION = array();

		$_SESSION['ida']     = $ida;
		$_SESSION['tel_ins'] = $compte_tel_ins;
		$_SESSION['sagmail'] = $email;

		if (isset($_REQUEST['user']) && ($_REQUEST['user'] == 'adminsag')) {

			$_SESSION['user'] = 'adminsag';
			tracking($connexion, CODE_CTA, 'OK', "CONNEXION ADMIN: Compte Annonce : Connexion Acceptée<br/>$compte_tel_ins:$compte_pass:$ida", $file, $line);
		} else {

			$sag_version = VERSION_SAG;

			// On envoi un cookie pour 90 jours 90 * 24 * 3600
			setcookie("connexion_compte_annonce", $sag_version . '|' . $compte_tel_ins . '|' . $compte_pass, time() + 7776000, "/");

			/*
			// Mettre à jour la date de la dernière connexion
			$query  = "UPDATE compte_recherche SET compte_date_connexion=now() WHERE idc='$idc' LIMIT 1";
			dtb_query($query,$file,$line,DEBUG_DTB_COMPTE);
			*/

			tracking($connexion, CODE_CTA, 'OK', "CONNEXION USER: Compte Annonce : Connexion Acceptée<br/>$compte_tel_ins:$compte_pass:$ida", $file, $line);
		}
		return $ida;

		// Sinon c'est un echec et il faut savoir pourquoi
	} else {

		// Les identifiants sont-ils bons     
		$query  = "SELECT ida,bloquage FROM ano WHERE tel_ins='$compte_tel_ins_s' AND password='$compte_pass_s'";
		$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

		// Si il y a un résultats c'est que les identifiants sont bons
		if (mysqli_num_rows($result)) {

			list($ida, $bloquage) = mysqli_fetch_row($result);

			if ($bloquage == 'yes') {
				$code_refus = COMPTE_ANNONCE_CONNEXION_ECHEC_BLOQUAGE;
				tracking($connexion, CODE_CTA, 'KO', "Compte Annonce : Echec Connexion:$compte_tel_ins:$compte_pass: ECHEC_BLOQUAGE", $file, $line);
				return false;
			}
		} else {
			if ($authentification_type == 'IDENTIFIANT') {
				tracking($connexion, CODE_CTA, 'KO', "Compte Annonce : Echec Connexion:$compte_tel_ins:$compte_pass: ECHEC_AUTHENTIFICATION_IDENTIFIANT", $file, $line);
				$code_refus = COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION_IDENTIFIANT;
				return false;
			} else {
				tracking($connexion, CODE_CTA, 'KO', "Compte Annonce : Echec Connexion:$compte_tel_ins:$compte_pass: ECHEC_AUTHENTIFICATION", $file, $line);
				$code_refus = COMPTE_ANNONCE_CONNEXION_ECHEC_AUTHENTIFICATION;
				return false;
			}
		}
	}
}
