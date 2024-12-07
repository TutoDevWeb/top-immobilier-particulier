<!DOCTYPE html>
<html>

<head>
	<title>Monitoring des Particuliers</title>
	<meta charset="UTF-8">
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
	include("../include/inc_dtb_compte_annonce.php");
	include("../include/inc_mail_compte_annonce.php");
	include("../include/inc_ano_sup.php");
	include("../include/inc_photo.php");
	include("../include/inc_format.php");
	include("../include/inc_flux_ano.php");

	if (isset($_GET['action'])) $action  = trim($_GET['action']);
	if (isset($_GET['tel_ins'])) $tel_ins = trim($_GET['tel_ins']);

	$connexion = dtb_connection(__FILE__, __LINE__);
	?>

	<table width="600" border="1" align=center cellpadding="5" cellspacing="0" bordercolor="336633">
		<tr>
			<td class="text12cg">Traitement des actions sur les annonces</td>
		</tr>
		<tr>
			<td>
				<?PHP process_action($action, $tel_ins); ?>
			</td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-monitoring.php">Retour au Monitoring</a></td>
		</tr>
	</table>


	<?PHP

	//------------------------------------------------------------------------------------------------
	function process_action($connexion, $action, $tel_ins) {

		//----------------------------------------------------------------------------------------------------
		if ($action == 'lowercase')                 make_lowercase($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_get_admin_link_form') print_get_admin_link_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_get_admin_link')        make_get_admin_link($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_change_tel_ins_form') print_change_tel_ins_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_change_tel_ins')       make_change_tel_ins($connexion, $tel_ins, $_GET['new_tel_ins']);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_change_mail_form')    print_change_mail_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_change_mail')          make_change_mail($connexion, $tel_ins, $_GET['new_mail']);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_send_mail_info_form') print_send_mail_info_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_send_mail_info')       make_send_mail_info($connexion, $tel_ins, $_GET['mail_info']);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_ano_sup_form')        print_ano_sup_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_ano_sup')               make_ano_sup($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_ano_voir_form')       print_ano_voir_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'go_ligne_sur_paiement')     go_ligne_sur_paiement($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'go_ligne_sur_validation')   go_ligne_sur_validation($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'go_ligne_silent')           go_ligne_silent($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'print_lock_ano_voir_form')  print_lock_ano_voir_form($tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_lock_ano_voir')        make_lock_ano_voir($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_lock_ano_yes')         make_lock_ano_yes($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_lock_ano_no')          make_lock_ano_no($connexion, $tel_ins);
		//----------------------------------------------------------------------------------------------------
		if ($action == 'make_flux_annonces')        make_flux_annonces($connexion,);
	}
	//--------------------------------------------------------------------------------------
	function make_lowercase($connexion, $tel_ins) {

		$query = "SELECT blabla FROM ano WHERE tel_ins='$tel_ins' LIMIT 1";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);

		if (mysqli_num_rows($result)) {

			list($blabla) = mysqli_fetch_row($result);

			$blabla = strtolower(addslashes($blabla));
			$query = "UPDATE ano SET blabla='$blabla' WHERE tel_ins='$tel_ins' LIMIT 1";
			dtb_query($connexion, $query, __FILE__, __LINE__, 1);
		} else echo "<p>Cette annonce n'existe pas :$tel_ins</p>\n";
	}

	//--------------------------------------------------------------------------------------
	function print_get_admin_link_form($tel_ins) {
	?>
		<form name="get_admin_link_form" method="get" action="adm-compte-annonce-action.php" target="exe">
			<p><strong>Editer un compte annonce</strong><br /><?PHP echo "$tel_ins"; ?><br />
				<input name="tel_ins" type="text" id="tel_ins" size="20" maxlength="128">
				<input type="hidden" name="action" value="make_get_admin_link">
			</p>
			<p><input type="submit" name="Submit3" value="Editer"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_get_admin_link($connexion, $tel_ins) {

		$query = "SELECT password FROM ano WHERE tel_ins='$tel_ins' LIMIT 1";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);

		if (mysqli_num_rows($result)) {

			list($password) = mysqli_fetch_row($result);
			echo "<a href='/compte-annonce/gestion-connexion-annonce.php?action=demande_connexion&compte_tel_ins=$tel_ins&compte_pass=$password&user=adminsag'>ADMIN : Editer Annonce	$tel_ins</a>";
		} else echo "<p>Cette annonce n'existe pas :$tel_ins</p>\n";
	}
	//--------------------------------------------------------------------------------------
	function print_change_tel_ins_form($tel_ins) {
	?>
		<form name="change_tel_ins" method="get" action="adm-compte-annonce-action.php" target="exe">
			<table align=center width="300" border="1" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<p><strong>Proc&eacute;dure de Changement de T�l�phone</strong><br />
							T�l�phone Actuel<br />
							<input type="text" name="tel_ins">
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Nouveau T&eacute;l&eacute;phone<br />
							<input type="text" name="new_tel_ins">
						</p>
						<p>
							<input type="hidden" name="action" value="make_change_tel_ins">
							<input type="submit" name="Submit" value="Changer le T�l�phone">
						</p>
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_change_tel_ins($connexion, $tel_ins, $new_tel_ins) {

		echo "<p>$tel_ins:tel_ins</p>";
		echo "<p>$new_tel_ins:new_tel_ins</p>";

		// Il ne faut pas que le nouveau num�ro de t�l�phone existe d�j�
		if (annonce_existe($connexion, $new_tel_ins, __FILE__, __LINE__) === false) {

			// Il faut que l'ancien que l'on doit changer existe
			if (annonce_existe($connexion, $tel_ins, __FILE__, __LINE__) === true) {

				echo "<p class=text12cg>L'annonce num�ro $tel_ins � �t� chang�e en $new_tel_ins</p>";

				$update = "UPDATE ano SET tel_ins='$new_tel_ins' WHERE tel_ins='$tel_ins' LIMIT 1";
				$result = dtb_query($connexion, $update, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);
			} else echo "<p class=text12cg>L'annonce n'existe pas $tel_ins</p>";
		} else  echo "<p class=text12cg>Op�ration Interdite<br/>Le nouveau num�ro de t�l�phone propos� existe d�j� $new_tel_ins</p>";
	}
	//--------------------------------------------------------------------------------------
	function print_change_mail_form($tel_ins) {
	?>

		<form name="change_mail" method="get" action="adm-compte-annonce-action.php" target="exe">
			<table align=center width="300" border="1" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<p><strong>Proc&eacute;dure de Changement de Mail</strong><br />
							T�l�phone<br />
							<input type="text" name="tel_ins">
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Nouveau mail<br /><input type="text" name="new_mail"></p>
						<p>
							<input type="hidden" name="action" value="make_change_mail">
							<input type="submit" name="Submit" value="Changer le Mail">
						</p>
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_change_mail($connexion, $tel_ins, $new_mail) {

		if (trim($new_mail) != '') {

			echo "$tel_ins:tel_ins<br/>";
			echo "$new_mail:new_mail<br/>";

			// Tester si l'annonce existe
			$query = "SELECT ida FROM ano WHERE tel_ins = '$tel_ins'";
			$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);

			if (mysqli_num_rows($result)) {

				echo "<p class=text12cg>Annonce existe :  Changer le mail $new_mail</p>";

				$update = "UPDATE ano SET email='$new_mail' WHERE tel_ins='$tel_ins' LIMIT 1";
				$result = dtb_query($connexion, $update, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);
			} else {

				echo "<p class=text12cg>Annonce n'existe pas $tel_ins</p>";
			}
		} else echo "<p>Saisir le mail</p>";
	}
	//--------------------------------------------------------------------------------------
	function print_send_mail_info_form($tel_ins) {
	?>
		<form name="mail_info_form" action='adm-compte-annonce-action.php' method="get" target="exe">
			<p>Mailer</p>
			<p>A l'attention de Bonjour,</p>
			<p><textarea class='text11j' name='mail_info' cols='70' rows='8'></textarea></p>
			<p>Tr�s Cordialement</p>
			<p><input type='hidden' name='tel_ins' value='<?PHP echo "$tel_ins"; ?>'>
				<input type='hidden' name='action' value='make_send_mail_info'>
				<input type='submit' name='Sub3' value='Envoyer'>
			</p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_send_mail_info($connexion, $tel_ins, $mail_info) {

		$password = get_password($connexion, $tel_ins, __FILE__, __LINE__);
		mail_info($connexion, $tel_ins, $password, $mail_info);
	}
	//--------------------------------------------------------------------------------------
	function print_ano_sup_form($tel_ins) {
	?>
		<form name="ano_sup_form" method="get" action="adm-compte-annonce-action.php" target="exe">
			<table align=center width="300" border="1" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<p><strong>Proc&eacute;dure de Suppression d'une annonce</strong><br />T�l�phone <br />
							<input type="hidden" name="action" value="make_ano_sup">
							<input type="text" name="tel_ins">
						</p>
						<p><input type="submit" name="Submit" value="Supprimer l'annonce"></p>
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_ano_sup($connexion, $tel_ins) {

		if (ano_sup($tel_ins, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION) === true)
			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins:supprimer: L'annonce a �t� supprim�", __FILE__, __LINE__);
		else
			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins:supprimer: L'annonce n'existe pas", __FILE__, __LINE__);
	}
	//--------------------------------------------------------------------------------------
	function print_ano_voir_form($tel_ins) {
	?>
		<form name="ano_voir_form" method="get" action="adm-compte-annonce-voir.php" target="exe">
			<p><strong>Voir une annonce</strong><br />T�l�phone <br />
				<input name="tel_ins" type="text" id="tel_ins" size="14" maxlength="10">
			</p>
			<p><input type="submit" name="Submit3" value="Voir Annonce"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function go_ligne_sur_paiement($connexion, $tel_ins) {

		if (annonce_existe($connexion, $tel_ins, __FILE__, __LINE__) === true) {

			echo "<p>On place l'annonce en ligne</p>\n";
			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins: goto ligne sur paiement", __FILE__, __LINE__);

			$duree = DUREE_ANNONCE;

			//----------------------------------------------------------------------------------------
			// dat_fin : Calculer la date de fin 
			$select = "SELECT DATE_ADD(now(),interval $duree MONTH)";
			$result = dtb_query($connexion, $select, __FILE__, __LINE__, DEBUG_DTB_ANO);
			list($dat_fin) = mysqli_fetch_row($result);

			$update = "UPDATE ano SET etat='ligne',dat_fin='$dat_fin' WHERE tel_ins='$tel_ins' LIMIT 1";
			$result = dtb_query($connexion, $update, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);

			$password = get_password($connexion, $tel_ins, __FILE__, __LINE__);

			mail_go_ligne_sur_paiement($connexion, $tel_ins, $password, $dat_fin);
		}
	}
	//--------------------------------------------------------------------------------------
	function go_ligne_sur_validation($connexion, $tel_ins) {

		if (annonce_existe($connexion, $tel_ins, __FILE__, __LINE__) === true) {

			echo "<p>On place l'annonce en ligne</p>\n";
			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins: goto ligne", __FILE__, __LINE__);
			$update = "UPDATE ano SET etat='ligne' WHERE tel_ins='$tel_ins' LIMIT 1";
			$result = dtb_query($connexion, $update, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);

			$password = get_password($connexion, $tel_ins, __FILE__, __LINE__);

			mail_go_ligne_sur_validation($connexion, $tel_ins, $password);
		}
	}
	//--------------------------------------------------------------------------------------
	function go_ligne_silent($connexion, $tel_ins) {

		if (annonce_existe($connexion, $tel_ins, __FILE__, __LINE__) === true) {

			echo "<p>On place l'annonce en ligne sans envoi de mail</p>\n";
			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins: goto ligne", __FILE__, __LINE__);
			$update = "UPDATE ano SET etat='ligne' WHERE tel_ins='$tel_ins' LIMIT 1";
			$result = dtb_query($connexion, $update, __FILE__, __LINE__, DEBUG_ADM_ANO_ACTION);
		}
	}
	//--------------------------------------------------------------------------------------
	function print_lock_ano_voir_form($tel_ins) {
	?>
		<form name="lock_ano_voir_form" method="get" action="adm-compte-annonce-action.php" target="exe">
			<p><strong>Voir �tat blocage d'une annonce</strong><br />T�l�phone <br />
				<input name="tel_ins" type="text" id="tel_ins" size="14" maxlength="10">
				<input type="hidden" name="action" value="make_lock_ano_voir">
			</p>
			<p><input type="submit" name="Submit3" value="Voir etat blocage annonce"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_lock_ano_voir($connexion, $tel_ins) {

		if ($tel_ins != '') {

			echo "<p>Voir l'�tat du blocage du compte annonce</p>\n";

			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins: Voir l'�tat du blocage du compte annonce", __FILE__, __LINE__);

			$query = "SELECT bloquage FROM ano WHERE tel_ins='$tel_ins' LIMIT 1";
			$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

			if (mysqli_num_rows($result)) {

				list($bloquage) = mysqli_fetch_row($result);

				if ($bloquage ==  'no') {
					echo "<p>$tel_ins:Le compte annonce n'est pas bloqu�e</p>\n";
					print_lock_ano_yes_form($tel_ins);
				}

				if ($bloquage == 'yes') {
					echo "<p>$tel_ins:Le compte annonce est bloqu�e</p>\n";
					print_lock_ano_no_form($tel_ins);
				}
			} else echo "<p>$tel_ins:Cette annonce n'existe pas</p>";
		} else echo "<p>Mettre un num�ro de t�l�phone</p>";
	}
	//--------------------------------------------------------------------------------------
	function print_lock_ano_yes_form($tel_ins) {
	?>
		<form name="lock_ano_yes_form" method="get" action="adm-compte-annonce-action.php" target="exe">
			<input type="hidden" name="tel_ins" value="<?PHP echo "$tel_ins"; ?>">
			<input type="hidden" name="action" value="make_lock_ano_yes">
			<p><input type="submit" name="Submit3" value="Bloquer le compte annonce"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_lock_ano_yes($connexion, $tel_ins) {

		if ($tel_ins != '') {

			echo "<p>Blocage de l'annonce $tel_ins</p>\n";

			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins: Blocage de l'annonce", __FILE__, __LINE__);

			$query = "UPDATE ano SET bloquage='yes' WHERE tel_ins='$tel_ins' LIMIT 1";
			dtb_query($connexion, $query, __FILE__, __LINE__, 1);
		} else echo "<p>Mettre un num�ro de t�l�phone</p>";
	}
	//--------------------------------------------------------------------------------------
	function print_lock_ano_no_form($tel_ins) {
	?>
		<form name="lock_ano_no_form" method="get" action="adm-compte-annonce-action.php" target="exe">
			<input type="hidden" name="tel_ins" value="<?PHP echo "$tel_ins"; ?>">
			<input type="hidden" name="action" value="make_lock_ano_no">
			<p><input type="submit" name="Submit3" value="D�bloquer le compte annonce"></p>
		</form>
	<?PHP
	}
	//--------------------------------------------------------------------------------------
	function make_lock_ano_no($connexion, $tel_ins) {

		if ($tel_ins != '') {

			echo "<p>D�blocage de l'annonce $tel_ins</p>\n";

			tracking($connexion, CODE_ADM, 'OK', "ADMIN:$tel_ins: D�-blocage de l'annonce", __FILE__, __LINE__);

			$query = "UPDATE ano SET bloquage='no' WHERE tel_ins='$tel_ins' LIMIT 1";
			dtb_query($connexion, $query, __FILE__, __LINE__, 1);
		} else echo "<p>Mettre un num�ro de t�l�phone</p>";
	}
	//--------------------------------------------------------------------------------------
	function annonce_existe($connexion, $tel_ins, $file, $line) {

		$query = "SELECT * FROM ano WHERE tel_ins='$tel_ins' LIMIT 1";
		$result = dtb_query($connexion, $query, $file, $line, DEBUG_ADM_ANO_ACTION);

		if (mysqli_num_rows($result)) return true;
		else return false;
	}
	//--------------------------------------------------------------------------------------
	function make_flux_annonces($connexion,) {

		$xml  = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
		$xml .= '<rss version="2.0">';
		$xml .= '<channel>';
		$xml .= '<title>' . SITE_NAME_FR . '</title>';
		$xml .= '<link>' . URL_SITE . '</link>';
		$xml .= "<description>Flux des derni�res annonces immobili�res</description>";
		$xml .= '<image>';
		$xml .= '<url>' . URL_SITE . 'images/top-immobilier-particuliers-240x60.jpg</url>';
		$xml .= '<title>Annonces Immobili�res</title>';
		$xml .= '<link>' . URL_SITE . 'annonces-immobilieres/</link>';
		$xml .= '</image>';


		$query  = "SELECT tel_ins,DATE_FORMAT(dat_ins,'%d-%m-%Y'),UNIX_TIMESTAMP(dat_ins),zone_ville,zone_ard,typp,nbpi,surf,prix,blabla FROM ano WHERE etat='ligne' ORDER BY dat_ins DESC LIMIT 15";
		$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

		while (list($tel_ins, $dat_ano, $dat_unix, $zone_ville, $zone_ard, $typp, $nbpi, $surf, $prix, $blabla) = mysqli_fetch_row($result)) {

			$titre = get_titre($zone_ville, $zone_ard, $typp, $nbpi, $surf, $prix);

			$description = "( " . $dat_ano . " ) " . substr($blabla, 0, 140) . "...";
			$flux_pub_date = date("r", $dat_unix);

			$xml .= '<item>';
			$xml .= '<title>' . $titre . '</title>';
			$xml .= '<link>' . URL_SITE . 'annonce-' . $tel_ins . '.htm</link>';
			$xml .= "<guid isPermaLink='false'>annonce-" . $tel_ins . "</guid>";
			$xml .= '<description>' . $description . '</description>';
			$xml .= '<pubDate>' . $flux_pub_date . '</pubDate>';
			$xml .= '</item>';
		}

		$xml .= '</channel>';
		$xml .= '</rss>';

		// �criture dans le fichier
		if (($fp = fopen("../annonces-immobilieres/xml-flux-annonces.xml", 'w+')) !== false) {
			fputs($fp, $xml);
			fclose($fp);
			echo "<p>OK => Cr�ation du flux</p>";
		} else echo "<p>Echec cr�ation du flux</p>";
	}
	?>
</body>

</html>