<?PHP
/*----------------------------------------------------------------------------------------------------*/
function creation_compte_recherche($connexion, $compte_email, &$compte_pass, $file, $line) {

	$compte_email = mysqli_real_escape_string($connexion, $compte_email);
	$compte_ip = $_SERVER['REMOTE_ADDR'];

	// G�n�rer un password
	$compte_pass = pass_generator();

	$compte_index_GMT = date("O", time());

	/* On ins�re une date connexion pour que la tache cron ne supprime pas le compte imm�diatement */
	$query = "INSERT INTO compte_recherche (compte_ip,compte_email,compte_pass,compte_date,compte_index_GMT,compte_date_connexion) VALUES ('$compte_ip','$compte_email','$compte_pass',now(),'$compte_index_GMT',now())";
	dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	return (mysqli_insert_id($connexion));
}
/*----------------------------------------------------------------------------------------------------*/
function compte_recherche_existe($connexion, $compte_email, $file, $line) {

	$compte_email = mysqli_real_escape_string($connexion, $compte_email);

	$query  = "SELECT idc FROM compte_recherche WHERE compte_email='$compte_email'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result))  return true;
	else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function get_compte_arg_creation($connexion, $compte_email, &$compte_pass, &$compte_ip, &$compte_date, &$compte_index_GMT, $file, $line) {

	$compte_email = mysqli_real_escape_string($connexion, $compte_email);

	$query  = "SELECT compte_pass,compte_ip,compte_date,compte_index_GMT FROM compte_recherche WHERE compte_email='$compte_email'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
	list($compte_pass, $compte_ip, $compte_date, $compte_index_GMT) = mysqli_fetch_row($result);
}
/*----------------------------------------------------------------------------------------------------*/
function get_etat_compte_recherche($connexion, $compte_email, $compte_pass, $file, $line) {

	$compte_email = mysqli_real_escape_string($connexion, $compte_email);
	$compte_pass  = mysqli_real_escape_string($connexion, $compte_pass);

	$query  = "SELECT compte_etat FROM compte_recherche WHERE compte_email='$compte_email' AND compte_pass='$compte_pass'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
	list($compte_etat) = mysqli_fetch_row($result);
	return $compte_etat;
}
/*----------------------------------------------------------------------------------------------------*/
function activer_compte_recherche($connexion, $compte_email, $file, $line) {

	$compte_email = mysqli_real_escape_string($connexion, $compte_email);
	$query  = "UPDATE compte_recherche SET compte_etat='actif' WHERE compte_email='$compte_email'";
	dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
}
/*----------------------------------------------------------------------------------------------------*/
// Lit les identifiants dans le cookie
// Renvoi faux si rien touver
function get_cookie_recherche(&$compte_email, &$compte_pass) {

	if (isset($_COOKIE["connexion_compte_recherche"])) {

		$cookie = explode('|', $_COOKIE["connexion_compte_recherche"]);

		// Position des valeurs dans le cookie
		$sag_version  = $cookie[IND_SAG_VERSION];
		$compte_email = $cookie[IND_COMPTE_EMAIL];
		$compte_pass  = $cookie[IND_COMPTE_PASS];

		if ($sag_version == VERSION_SAG) return true;
		else return false;
	}
	return false;
}
/*----------------------------------------------------------------------------------------------------*/
// Lit les identifiants dans le cookie et renvoie l'idc
// Renvoi faux si rien touver
function get_idc($connexion, &$compte_email, &$compte_pass) {

	if (isset($_COOKIE["connexion_compte_recherche"])) {

		$cookie = explode('|', $_COOKIE["connexion_compte_recherche"]);

		// Position des valeurs dans le cookie
		$sag_version  = $cookie[IND_SAG_VERSION];
		$compte_email = $cookie[IND_COMPTE_EMAIL];
		$compte_pass  = $cookie[IND_COMPTE_PASS];

		if ($sag_version == VERSION_SAG) {

			$compte_email_s = mysqli_real_escape_string($connexion, $compte_email);
			$compte_pass_s  = mysqli_real_escape_string($connexion, $compte_pass);

			// Requête pour connexion
			$query  = "SELECT idc FROM compte_recherche WHERE compte_email='$compte_email_s' AND compte_pass='$compte_pass_s' AND compte_bloquage='no' AND ( (compte_etat = 'actif') OR (UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(compte_date)) < 86400 )";
			$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);

			// Si il y a un résultat
			if (mysqli_num_rows($result)) {
				list($idc) = mysqli_fetch_row($result);
				return $idc;
			} else return false;

			tracking($connexion, CODE_CTR, 'OK', "Get idc:$compte_email:$compte_pass", __FILE__, __LINE__);
		} else return false;
	} else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function get_email_compte_recherche($connexion, $idc) {

	$query  = "SELECT compte_email FROM compte_recherche WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);

	// Si il y a un r�sultat
	if (mysqli_num_rows($result)) {
		list($compte_email) = mysqli_fetch_row($result);
		return $compte_email;
	} else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function demande_connexion_recherche($connexion, &$compte_email, &$compte_pass, &$code_refus, $file, $line) {

	// Si les identifiants sont l�, on s'en sert pour faire l'authentification
	if ($compte_email != '' && $compte_pass != '') {


		$compte_email_s = mysqli_real_escape_string($connexion, $compte_email);
		$compte_pass_s  = mysqli_real_escape_string($connexion, $compte_pass);
		$authentification_type = 'IDENTIFIANT';

		tracking($connexion, CODE_CTR, 'OK', "Demande Connexion identifiant:$compte_email:$compte_pass", $file, $line);


		// Sinon c'est une demande de connexion avec authentification par cookie
	} else if (isset($_COOKIE["connexion_compte_recherche"])) {

		$cookie = explode('|', $_COOKIE["connexion_compte_recherche"]);

		// Position des valeurs dans le cookie
		$sag_version  = $cookie[IND_SAG_VERSION];
		$compte_email = $cookie[IND_COMPTE_EMAIL];
		$compte_pass  = $cookie[IND_COMPTE_PASS];

		tracking($connexion, CODE_CTR, 'OK', "Demande Connexion Cookie:$compte_email:$compte_pass", $file, $line);

		if ($sag_version == VERSION_SAG) {
			$compte_email_s = mysqli_real_escape_string($connexion, $compte_email);
			$compte_pass_s  = mysqli_real_escape_string($connexion, $compte_pass);
		} else {
			tracking($connexion, CODE_CTR, 'KO', "Echec Connexion Cookie:$compte_email:$compte_pass:$sag_version: ECHEC_VERSION", $file, $line);
			return COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION;
		}
		// Dans ce cas il n'y a pas d'identifiants
	} else {

		tracking($connexion, CODE_CTR, 'KO', "Echec Connexion: pas identifiant : ECHEC_AUTHENTIFICATION", $file, $line);
		$code_refus = COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION;
		return false;
	}

	// Requ�te pour connexion
	$query  = "SELECT idc FROM compte_recherche WHERE compte_email='$compte_email_s' AND compte_pass='$compte_pass_s' AND compte_bloquage='no' AND ( (compte_etat = 'actif') OR (UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(compte_date)) < 86400 )";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	// Si il y a un r�sultat
	if (mysqli_num_rows($result)) {
		// On peut se connecter
		list($idc) = mysqli_fetch_row($result);

		$_SESSION['idc'] = $idc;

		// Si c'est une connexion admin
		if (isset($_REQUEST['user']) && ($_REQUEST['user'] == 'adminsag')) {

			$_SESSION['user'] = 'adminsag';
			tracking($connexion, CODE_CTR, 'OK', "CONNEXION ADMIN: Compte Recherche : Connexion Accept�e<br/>$compte_email:$compte_pass:$idc", $file, $line);
		} else {

			$sag_version = VERSION_SAG;

			// On envoi un cookie pour 90 jours 90 * 24 * 3600
			setcookie("connexion_compte_recherche", $sag_version . '|' . $compte_email . '|' . $compte_pass, time() + 7776000, "/");

			// Mettre � jour la date de la dernière connexion
			$query  = "UPDATE compte_recherche SET compte_date_connexion=now() WHERE idc='$idc' LIMIT 1";
			dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

			tracking($connexion, CODE_CTR, 'OK', "CONNEXION USER:  Compte Recherche : Connexion Accept�e<br/>$compte_email:$compte_pass:$idc", $file, $line);
		}

		return $idc;

		// Sinon c'est un echec et il faut savoir pourquoi
	} else {

		// Les identifiants sont-ils bons     
		$query  = "SELECT idc,compte_etat,compte_bloquage FROM compte_recherche WHERE compte_email='$compte_email_s' AND compte_pass='$compte_pass_s'";
		$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

		// Si il y a un r�sultats c'est que les identifiants sont bons
		if (mysqli_num_rows($result)) {

			list($idc, $compte_etat, $compte_bloquage) = mysqli_fetch_row($result);

			if ($compte_bloquage == 'yes') {
				$code_refus = COMPTE_RECHERCHE_CONNEXION_ECHEC_BLOQUAGE;
				tracking($connexion, CODE_CTR, 'KO', "Echec Connexion:$compte_email:$compte_pass: ECHEC_BLOQUAGE", $file, $line);
				return false;
			} else if ($compte_etat == 'inactif') {
				tracking($connexion, CODE_CTR, 'KO', "Echec Connexion:$compte_email:$compte_pass: ECHEC_INACTIF", $file, $line);
				$code_refus = COMPTE_RECHERCHE_CONNEXION_ECHEC_INACTIF;
				return false;
			}
		} else {
			if ($authentification_type == 'IDENTIFIANT') {
				tracking($connexion, CODE_CTR, 'KO', "Echec Connexion:$compte_email:$compte_pass: ECHEC_AUTHENTIFICATION_IDENTIFIANT", $file, $line);
				$code_refus = COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION_IDENTIFIANT;
				return false;
			} else {
				tracking($connexion, CODE_CTR, 'KO', "Echec Connexion:$compte_email:$compte_pass: ECHEC_AUTHENTIFICATION", $file, $line);
				$code_refus = COMPTE_RECHERCHE_CONNEXION_ECHEC_AUTHENTIFICATION;
				return false;
			}
		}
	}
}
/*----------------------------------------------------------------------------------------------------*/
function memoriser_financement($connexion, $idc, $fixe, $credit, $apport, $taux_annuel, $nb_annee, $file, $line) {

	$idc = mysqli_real_escape_string($connexion, $idc);

	$query = "UPDATE compte_recherche SET finance_actif=1,finance_fixe='$fixe',finance_credit_montant='$credit',finance_apport_montant='$apport',finance_taux_annuel='$taux_annuel',finance_nb_annee='$nb_annee' WHERE idc='$idc' LIMIT 1";
	dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	return true;
}
/*----------------------------------------------------------------------------------------------------*/
function get_financement($connexion, $idc, &$finance_actif, &$fixe, &$credit, &$apport, &$taux_annuel, &$nb_annee, $file, $line) {

	$idc = mysqli_real_escape_string($connexion, $idc);

	$query  = "SELECT finance_actif,finance_fixe,finance_credit_montant,finance_apport_montant,finance_taux_annuel,finance_nb_annee FROM compte_recherche WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result)) {

		list($finance_actif, $fixe, $credit, $apport, $taux_annuel, $nb_annee) = mysqli_fetch_row($result);
		return true;
	} else {

		$finance_actif = '0';
		$fixe = 'apport_radio';
		$credit = '0.0';
		$apport = '0.0';
		$taux_annuel = '4.0';
		$nb_annee = '15';
		return false;
	}
}
/*----------------------------------------------------------------------------------------------------*/
function creer_alerte_recherche($connexion, $idc, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $file, $line) {

	$zone        = mysqli_real_escape_string($connexion, $zone);
	$zone_pays   = mysqli_real_escape_string($connexion, $zone_pays);
	$zone_dom    = mysqli_real_escape_string($connexion, $zone_dom);
	$zone_region = mysqli_real_escape_string($connexion, $zone_region);
	$zone_dept   = mysqli_real_escape_string($connexion, $zone_dept);
	$zone_ville  = mysqli_real_escape_string($connexion, $zone_ville);
	$zone_ard    = mysqli_real_escape_string($connexion, $zone_ard);
	$dept_voisin = mysqli_real_escape_string($connexion, $dept_voisin);
	$typp        = mysqli_real_escape_string($connexion, $typp);
	$P1          = mysqli_real_escape_string($connexion, $P1);
	$P2          = mysqli_real_escape_string($connexion, $P2);
	$P3          = mysqli_real_escape_string($connexion, $P3);
	$P4          = mysqli_real_escape_string($connexion, $P4);
	$P5          = mysqli_real_escape_string($connexion, $P5);
	$sur_min     = mysqli_real_escape_string($connexion, $sur_min);
	$prix_max    = mysqli_real_escape_string($connexion, $prix_max);

	if ($typp == VAL_NUM_TOUS_PRODUITS) $typp = VAL_DTB_TOUS_PRODUITS;
	if ($typp == VAL_NUM_APPARTEMENT) $typp = VAL_DTB_APPARTEMENT;
	if ($typp == VAL_NUM_MAISON) $typp = VAL_DTB_MAISON;
	if ($typp == VAL_NUM_LOFT) $typp = VAL_DTB_LOFT;
	if ($typp == VAL_NUM_CHALET) $typp = VAL_DTB_CHALET;

	$query  = "SELECT idar FROM compte_recherche_alertes_recherche WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result) < COMPTE_RECHERCHE_MAX_ALERTE_RECHERCHE) {
		$query = "INSERT INTO compte_recherche_alertes_recherche (idc,date_positionnement,zone,zone_pays,zone_dom,zone_region,zone_dept,zone_ville,zone_ard,dept_voisin,typp,P1,P2,P3,P4,P5,sur_min,prix_max) 
              VALUES ('$idc',now(),'$zone','$zone_pays','$zone_dom','$zone_region','$zone_dept','$zone_ville','$zone_ard','$dept_voisin','$typp','$P1','$P2','$P3','$P4','$P5','$sur_min','$prix_max')";
		dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
		tracking_dtb($connexion, $query, __FILE__, __LINE__);
		return true;
	} else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function get_alerte_recherche($connexion, $idc, $zone, $zone_pays, $zone_dom, $zone_region, $zone_dept, $zone_ville, $zone_ard, $dept_voisin, $typp, $P1, $P2, $P3, $P4, $P5, $sur_min, $prix_max, $file, $line) {

	$zone        = mysqli_real_escape_string($connexion, $zone);
	$zone_pays   = mysqli_real_escape_string($connexion, $zone_pays);
	$zone_dom    = mysqli_real_escape_string($connexion, $zone_dom);
	$zone_region = mysqli_real_escape_string($connexion, $zone_region);
	$zone_dept   = mysqli_real_escape_string($connexion, $zone_dept);
	$zone_ville  = mysqli_real_escape_string($connexion, $zone_ville);
	$zone_ard    = mysqli_real_escape_string($connexion, $zone_ard);
	$dept_voisin = mysqli_real_escape_string($connexion, $dept_voisin);
	$typp        = mysqli_real_escape_string($connexion, $typp);
	$P1          = mysqli_real_escape_string($connexion, $P1);
	$P2          = mysqli_real_escape_string($connexion, $P2);
	$P3          = mysqli_real_escape_string($connexion, $P3);
	$P4          = mysqli_real_escape_string($connexion, $P4);
	$P5          = mysqli_real_escape_string($connexion, $P5);
	$sur_min     = mysqli_real_escape_string($connexion, $sur_min);
	$prix_max    = mysqli_real_escape_string($connexion, $prix_max);

	if ($typp == VAL_NUM_TOUS_PRODUITS) $typp = VAL_DTB_TOUS_PRODUITS;
	if ($typp == VAL_NUM_APPARTEMENT) $typp = VAL_DTB_APPARTEMENT;
	if ($typp == VAL_NUM_MAISON) $typp = VAL_DTB_MAISON;
	if ($typp == VAL_NUM_LOFT) $typp = VAL_DTB_LOFT;
	if ($typp == VAL_NUM_CHALET) $typp = VAL_DTB_CHALET;

	// Test pour savoir si l'alerte existe
	if ($zone == 'france') $query  = "SELECT idar FROM compte_recherche_alertes_recherche WHERE idc='$idc' AND zone='$zone' AND zone_region='$zone_region' AND zone_dept='$zone_dept' AND zone_ville='$zone_ville' AND zone_ard='$zone_ard' AND zone_dept='$zone_dept' AND dept_voisin='$dept_voisin' AND typp='$typp' AND P1=$P1 AND P2=$P2 AND P3=$P3 AND P4=$P4 AND P5=$P5 AND sur_min=$sur_min AND prix_max=$prix_max";
	if ($zone == 'domtom') $query  = "SELECT idar FROM compte_recherche_alertes_recherche WHERE idc='$idc' AND zone='$zone' AND zone_dom='$zone_dom' AND zone_region='$zone_region' AND zone_dept='$zone_dept' AND zone_ville='$zone_ville' AND zone_ard='$zone_ard' AND zone_dept='$zone_dept' AND dept_voisin='$dept_voisin' AND typp='$typp' AND P1=$P1 AND P2=$P2 AND P3=$P3 AND P4=$P4 AND P5=$P5 AND sur_min=$sur_min AND prix_max=$prix_max";
	if ($zone == 'etranger') $query  = "SELECT idar FROM compte_recherche_alertes_recherche WHERE idc='$idc' AND zone='$zone' AND zone_pays='$zone_pays' AND zone_region='$zone_region' AND zone_dept='$zone_dept' AND zone_ville='$zone_ville' AND zone_ard='$zone_ard' AND zone_dept='$zone_dept' AND dept_voisin='$dept_voisin' AND typp='$typp' AND P1=$P1 AND P2=$P2 AND P3=$P3 AND P4=$P4 AND P5=$P5 AND sur_min=$sur_min AND prix_max=$prix_max";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result)) return true;
	else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function get_max_alerte_recherche($connexion, $idc, $file, $line) {

	$idc     = mysqli_real_escape_string($connexion, $idc);

	// Compter le nombre d'alerte recherche pour un utilisateur idc
	$query  = "SELECT idar FROM compte_recherche_alertes_recherche WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result) >= COMPTE_RECHERCHE_MAX_ALERTE_RECHERCHE) return true;
	else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function supprimer_alerte_recherche($connexion, $idar, $file, $line) {

	$idar = mysqli_real_escape_string($connexion, $idar);

	// On prends l'idc qui est en Session
	$idc = $_SESSION['idc'];

	// Supprimer l'alerte
	$query = "DELETE FROM compte_recherche_alertes_recherche WHERE idar='$idar' AND idc='$idc' LIMIT 1";
	dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
}
/*----------------------------------------------------------------------------------------------------*/
function creer_alerte_baisse($connexion, $idc, $tel_ins, $prix, $file, $line) {

	$idc     = mysqli_real_escape_string($connexion, $idc);
	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);
	$prix    = mysqli_real_escape_string($connexion, $prix);

	// V�rifier qu'une alerte n'est pas d�j� positionn�e sur cette annonce pour cet utilisateur
	$query  = "SELECT idc FROM compte_recherche_alertes_baisse WHERE tel_ins='$tel_ins' AND idc='$idc'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (!mysqli_num_rows($result)) {

		// V�rifier le maximum
		$query  = "SELECT idab FROM compte_recherche_alertes_baisse WHERE idc='$idc'";
		$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

		if (mysqli_num_rows($result) < COMPTE_RECHERCHE_MAX_ALERTE_BAISSE) {

			$query = "INSERT INTO compte_recherche_alertes_baisse (idc,tel_ins,prix_positionnement,date_positionnement) 
                                                       VALUES ('$idc','$tel_ins','$prix',now())";
			dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
			return true;
		} else return false;
	}
}
/*----------------------------------------------------------------------------------------------------*/
function get_deja_alerte_baisse($connexion, $idc, $tel_ins, $file, $line) {

	$idc     = mysqli_real_escape_string($connexion, $idc);
	$tel_ins = mysqli_real_escape_string($connexion, $tel_ins);

	// V�rifier qu'une alerte n'est pas d�j� positionn�e sur cette annonce pour cet utilisateur
	$query  = "SELECT idc FROM compte_recherche_alertes_baisse WHERE tel_ins='$tel_ins' AND idc='$idc'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result)) return true;
	else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function get_max_alerte_baisse($connexion, $idc, $file, $line) {

	$idc     = mysqli_real_escape_string($connexion, $idc);

	// Compter le nombre d'alerte à la baisse pour un utilisateur idc
	$query  = "SELECT idab FROM compte_recherche_alertes_baisse WHERE idc='$idc'";
	$result = dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);

	if (mysqli_num_rows($result) >= COMPTE_RECHERCHE_MAX_ALERTE_BAISSE) return true;
	else return false;
}
/*----------------------------------------------------------------------------------------------------*/
function supprimer_alerte_baisse($connexion, $idab, $file, $line) {

	$idab = mysqli_real_escape_string($connexion, $idab);

	// On prends l'idc qui est en Session
	$idc = $_SESSION['idc'];

	// Supprimer l'alerte
	$query = "DELETE FROM compte_recherche_alertes_baisse WHERE idab='$idab' AND idc='$idc' LIMIT 1";
	dtb_query($connexion, $query, $file, $line, DEBUG_DTB_COMPTE);
}
/*----------------------------------------------------------------------------------------------------*/
function supprimer_compte_recherche($connexion, $idc, $file, $line) {

	$idc = mysqli_real_escape_string($connexion, $idc);

	// Supprimer les alertes � la baisse
	$query = "DELETE FROM compte_recherche_alertes_baisse WHERE idc='$idc'";
	dtb_query($connexion, $query, $file, $line, 1);

	// Supprimer les alertes recherche
	$query = "DELETE FROM compte_recherche_alertes_recherche WHERE idc='$idc'";
	dtb_query($connexion, $query, $file, $line, 1);

	// Supprimer le compte recherche
	$query = "DELETE FROM compte_recherche WHERE idc='$idc' LIMIT 1";
	dtb_query($connexion, $query, $file, $line, 1);
}
