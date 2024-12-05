<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_format.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<title>Monitoring des annonces</title>
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

	dtb_connection();
	monitoring_ano();

	if (isset($_GET['action'])) $action  = trim($_GET['action']);

	//------------------------------------------------------------------------------------------------
	function monitoring_ano() {

		$select = "SELECT ida,tel_ins,ip_ins,email,etat,dat_ins,dat_fin,fin_parution,mail_relancer_paiement FROM ano WHERE ( etat != 'ligne' ) ORDER BY dat_ins DESC";
		$result = dtb_query($select, __FILE__, __LINE__, DEBUG_ADM_ANO_MONIT);

		echo "<table width=600 align=center border=1 cellpadding=3 cellspacing=0 bordercolor=#336633>\n";
		while (list($ida, $tel_ins, $ip_ins, $email, $etat, $dat_ins, $dat_fin, $fin_parution, $mail_relancer_paiement)  = mysqli_fetch_row($result)) {

			if ($etat == 'attente_paiement') print_attente($ida, $tel_ins, $ip_ins, $email, $etat, $dat_ins, $dat_fin, $fin_parution, $mail_relancer_paiement);

			else if ($etat == 'attente_validation') print_attente($ida, $tel_ins, $ip_ins, $email, $etat, $dat_ins, $dat_fin, $fin_parution, $mail_relancer_paiement);
		}
		echo "</table>\n";
	}
	//----------------------------------------------------------------------------------------------------------------------------
	function print_attente($ida, $tel_ins, $ip_ins, $email, $etat, $dat_ins, $dat_fin, $fin_parution, $mail_relancer_paiement) {

		// Si l'annonce est en attente paiement
		$str_paiement = '';


		if ($etat == 'attente_paiement') {

			if ($fin_parution == '1') $str_paiement .= "<br/>Attente sur fin de parution";

			// Calculer depuis combien de jours
			$query = "SELECT (TO_DAYS(now()) - TO_DAYS(dat_ins)) FROM ano WHERE tel_ins='$tel_ins'";
			$result = dtb_query($query, $file, $line, DEBUG_DTB_ANO);
			list($nbj_attente) = mysqli_fetch_row($result);

			$str_paiement .= "<br/>attente paiement depuis $nbj_attente jours";

			if ($mail_relancer_paiement == 1) {

				// Calculer le nombre de jours restant avant la suppression
				$nbj_suppression = DUREE_EFFACER_ATTENTE_PAIEMENT - $nbj_attente;
				$str_paiement .= "<br/>suppression dans $nbj_suppression jours";
			} else {

				// Calculer le nombre de jours restant avant la relance paiement
				$nbj_relance = DUREE_RELANCER_ATTENTE_PAIEMENT - $nbj_attente;
				$str_paiement .= "<br/>relance dans $nbj_relance jours";
			}
		}



		echo "<tr>\n";
		echo "<td width=300>$ida:$tel_ins:$etat<br/>$dat_ins<br/><a href='/admin/tracking.php?nbj=2&code=TOUT&IP_to_track=$ip_ins&cmd=process_tracking&action=examiner'>$ip_ins</a>$str_paiement</td>\n";
		echo "<td class=text11>\n";
		echo "<p>$email</p>\n";
		echo "<p><a href='adm-compte-annonce-voir.php?ida=$ida&tel_ins=$tel_ins'>Voir</a></p>";
		echo "<p><a href='adm-compte-annonce-action.php?action=print_send_mail_info_form&tel_ins=$tel_ins'>Mailer</a></p>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}
	//----------------------------------------------------------------------------------------------------------------------------

	?>
</body>

</html>