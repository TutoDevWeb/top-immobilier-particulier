<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<title>Actions � appliquer sur les comptes de recherches</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="/styles/styles.css" rel="stylesheet" type="text/css">
	<STYLE type="text/css">
		<!--
		body {
			background-color: #FFFFFF;
		}
		-->
	</STYLE>
</head>

<body>
	<?PHP
	include("../data/data.php");
	include("../include/inc_base.php");
	include("../include/inc_tracking.php");
	include("../include/inc_conf.php");
	include("../include/inc_dtb_compte_recherche.php");

	isset($_REQUEST['action']) ? $action = trim($_REQUEST['action']) : die;
	if (isset($_GET['compte_email'])) $compte_email = trim($_GET['compte_email']);


	dtb_connection(__FILE__, __LINE__);
	?>

	<table width="600" border="1" align=center cellpadding="5" cellspacing="0" bordercolor="336633">
		<tr>
			<td class="text12cg">Traitement des actions sur les comptes recherches</td>
		</tr>
		<tr>
			<td>
				<?PHP process_action($action, $compte_email); ?>
			</td>
		</tr>
	</table>


	<?PHP

	//------------------------------------------------------------------------------------------------
	function process_action($action, $compte_email) {

		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_compte_recherche_sup_form') print_compte_recherche_sup_form($compte_email);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'compte_recherche_sup') {

			$compte_email = mysqli_real_escape_string($compte_email);

			$query  = "SELECT idc FROM compte_recherche WHERE compte_email='$compte_email' LIMIT 1";
			$result = dtb_query($query, $file, $line, DEBUG_DTB_COMPTE);

			if (mysqli_num_rows($result)) {

				list($idc) = mysqli_fetch_row($result);
				echo "<p><strong>Le compte recherche compte_email => $compte_email :: idc => $idc a �t� supprim�</strong></p>";
				tracking(CODE_ADM, 'OK', "ADMIN:compte recherche  => $compte_email :: idc => $idc: suppression", __FILE__, __LINE__);
				supprimer_compte_recherche($idc, __FILE__, __LINE__);
			} else {

				echo "<p><strong>Le compte recherche compte_email => $compte_email :: idc => $idc n'existe pas</strong></p>";
				tracking(CODE_ADM, 'OK', "ADMIN:compte recherche => $compte_email :: idc => $idc: suppression<br/>le compte n'existe pas", __FILE__, __LINE__);
			}
		}

		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_get_admin_link_form') print_get_admin_link_form($compte_email);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'get_admin_link') {

			$compte_email = mysqli_real_escape_string($compte_email);

			$query = "SELECT idc,compte_pass FROM compte_recherche WHERE  compte_email='$compte_email' LIMIT 1";
			$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);

			if (mysqli_num_rows($result)) {
				list($idc, $compte_pass) = mysqli_fetch_row($result);
				echo "<a href='/compte-recherche/gestion-connexion-recherche.php?action=demande_connexion&compte_email=$compte_email&compte_pass=$compte_pass&user=adminsag'>ADMIN : Connexion � compte_email => $compte_email :: idc => $idc</a>";
			} else {
				echo "<p><strong>Le compte recherche compte_email => $compte_email n'existe pas</strong></p>";
			}
		}
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_statistiques') print_statistiques();
		//----------------------------------------------------------------------------------------------------
		if ($action == 'voir_inactif') voir_inactif();
		//----------------------------------------------------------------------------------------------------

	}
	//--------------------------------------------------------------------------------------
	function print_compte_recherche_sup_form($compte_email) {
	?>
		<form name="compte_recherche_sup_form" method="get" action="adm-compte-recherche-action.php" target="exe">
			<p><strong>Supprimer un compte recherche</strong><br />Email<br />
				<input name="compte_email" type="text" id="compte_email" size="20" maxlength="128">
				<input type="hidden" name="action" value="compte_recherche_sup">
			</p>
			<p><input type="submit" name="Submit3" value="Supprimer"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function print_get_admin_link_form($compte_email) {
	?>
		<form name="get_admin_link_form" method="get" action="adm-compte-recherche-action.php" target="exe">
			<p><strong>Editer un compte recherche</strong><br />Email<br />
				<input name="compte_email" type="text" id="compte_email" size="20" maxlength="128">
				<input type="hidden" name="action" value="get_admin_link">
			</p>
			<p><input type="submit" name="Submit3" value="Editer"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function print_statistiques() {

		// Nombre de compte actif
		$query = "SELECT idc FROM compte_recherche WHERE compte_etat='actif'";
		$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);
		$nb = mysqli_num_rows($result);
		echo "<p>Il y a $nb comptes actif</p>";

		// Nombre de compte inactif
		$query = "SELECT idc FROM compte_recherche WHERE compte_etat='inactif'";
		$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);
		$nb = mysqli_num_rows($result);
		echo "<p>Il y a $nb comptes inactif</p>";

		// Nombre de compte ou le financement a �t� enregistr�
		$query = "SELECT idc FROM compte_recherche WHERE finance_actif=1";
		$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);
		$nb = mysqli_num_rows($result);
		echo "<p>Il y a $nb comptes ou le financement a �t� enregistr�</p>";

		// Nombre d'alerte � la baisse de positionn�
		$query = "SELECT idab FROM compte_recherche_alertes_baisse";
		$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);
		$nb = mysqli_num_rows($result);
		echo "<p>Il y a $nb alertes � la baisse de positionn�es</p>";

		// Nombre d'alertes recherche
		$query = "SELECT idar FROM compte_recherche_alertes_recherche";
		$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);
		$nb = mysqli_num_rows($result);
		echo "<p>Il y a $nb alertes recherche de positionn�es</p>";
	}
	//--------------------------------------------------------------------------------------
	function voir_inactif() {

		// Nombre de compte inactif
		$query = "SELECT compte_email,compte_date,compte_inactif_relancer FROM compte_recherche WHERE compte_etat='inactif'";
		$result = dtb_query($query, __FILE__, __LINE__, DEBUG_DTB_COMPTE);
		if (mysqli_num_rows($result)) {

			while (list($compte_email, $compte_date, $compte_inactif_relancer) = mysqli_fetch_row($result)) {
				if ($compte_inactif_relancer) echo "<p>$compte_email => $compte_date : mail de relance envoy�</p>";
				else  echo "<p>$compte_email => $compte_date</p>";
			}
		} else echo "<p>Il n'y a pas de compte inactif</p>";
	}
	?>
</body>

</html>