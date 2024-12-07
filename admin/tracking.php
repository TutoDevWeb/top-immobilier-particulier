<!DOCTYPE html>
<html>

<head>
	<title>Examen du tracking</title>
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

	isset($_GET['action']) ? $action = $_GET['action'] : die;

	dtb_connection(__FILE__, __LINE__);

	if ($action == "examiner") {

		isset($_GET['cmd'])  ? $cmd  = $_GET['cmd']  : die;
		isset($_GET['nbj'])  ? $nbj  = $_GET['nbj']  : die;
		isset($_GET['code']) ? $code = $_GET['code'] : die;
		isset($_GET['dtb_trace'])   ? $dtb_trace   = (int)trim($_GET['dtb_trace'])   : $dtb_trace   =  0;
		isset($_GET['IP_to_track']) ? $IP_to_track =      trim($_GET['IP_to_track']) : $IP_to_track = '';

		print_r($_GET);

		if ($cmd == "print_form") print_examiner_form($nbj, $code, $dtb_trace, $IP_to_track);
		if ($cmd == "process_tracking") {
			process_examiner_tracking($nbj, $code, $dtb_trace, $IP_to_track);
			print_examiner_form($nbj, $code, $dtb_trace, $IP_to_track);
		}
	}

	if ($action == "purger") {

		isset($_GET['cmd']) ? $cmd = $_GET['cmd'] : die;

		if ($cmd == "print_form") print_purger_form();
		else {
			process_purger_tracking($cmd);
			print_purger_form();
		}
	}



	//-------------------------------------------------------------------------------------------------
	//
	function process_purger_tracking($cmd) {

		if ($cmd == "purger_tout") {
			$query = "DELETE FROM tracking";
			$result = dtb_query($query, __FILE__, __LINE__, 1);
		}
	}
	//-------------------------------------------------------------------------------------------------
	//
	function process_examiner_tracking($nbj, $code, $dtb_trace, $IP_to_track) {

		$where = " ((TO_DAYS(NOW()) - TO_DAYS(dat)) < $nbj ) ";
		if ($IP_to_track != '') $where .= " AND ip = '$IP_to_track'";

		if ($dtb_trace   != 0) {
			// RCL => Code pour une recherche liste DTB => Trace des appels database 
			if ($code == 'RCL') $where .= " AND ( cop='DTB' OR cop = 'RCL') ";
			// RCC => Code pour une recherche carte 
			if ($code == 'RCC') $where .= " AND ( cop='DTB' OR cop = 'RCC') ";
		} else {
			if ($code == 'RCC') $where .= " AND cop = 'RCC'";
			if ($code == 'RCL') $where .= " AND cop = 'RCL'";
		}

		// Code pour les entr�e sur le site
		if ($code == 'NAV') $where .= " AND cop = 'NAV'";

		// Code pour les actions administrateur Recherche ou Compte
		if ($code == 'ADM') $where .= " AND cop = 'ADM'";

		// Tracking pour une recherche avec acc�s � la fiche d�taill�e.
		if ($code == 'RED') $where .= " AND cop = 'RED'";

		// Code pour la tracabilit� des comptes annonce
		if ($code == 'CTA') $where .= " AND cop = 'CTA'";
		// Code pour la tracabilit� des comptes recherche
		if ($code == 'CTR') $where .= " AND cop = 'CTR'";

		//Code pour la tache cron des compte annonce
		if ($code == 'CRA') $where .= " AND cop = 'CRA'";
		//Code pour la tache cron des compte recherche
		if ($code == 'CRR') $where .= " AND cop = 'CRR'";


		// Tri en fonction des codes s�lectionner
		$query = "SELECT idk,dat,ip,tel_ins,cop,res,user_agent,referer,file,line,comment FROM tracking WHERE $where ORDER BY  idk DESC";
		$result = dtb_query($query, __FILE__, __LINE__, 1);


		echo "<table width='100%' border=1 align=center cellpadding=3 cellspacing=0 bordercolor=336633>";
		echo '<caption>Liste tracking</caption>';
		echo '<tr>';
		echo '<td>idk</td>';
		echo '<td>date / ip</td>';
		echo '<td>cop / res</td>';
		echo '<td>file / line</td>';
		echo '<td>comment</td>';
		echo '</tr>';

		$ir = 0;
		while (list($idk, $dat, $ip, $tel_ins, $cop, $res, $user_agent, $referer, $file, $line, $comment)  = mysqli_fetch_row($result)) {

			// L� on ajoute les infos $referer ou $user_agent qui peuvent nous int�resser selon le code.

			/* Dans ce cas on ne prend que les traces ou il y a le referer */
			if ($code == 'REF') {
				if (is_referer($referer)) {
					$comment = $referer . "<br/>" . $comment;
					if (is_browser_user_agent($user_agent)) $comment = $user_agent . "<br/>" . $comment;
				} else continue;
			}

			/* Dans ce cas on prend les code RCC et RCL et on ajoute le referer si il y est */
			if ($code == 'RCC' || $code == 'RCL') {
				if (is_referer($referer)) $comment = $referer . "<br/>" . $comment;
				if (is_browser_user_agent($user_agent)) $comment = $user_agent . "<br/>" . $comment;
			}

			if ($code == 'CTA') {
				if (is_referer($referer)) $comment = $referer . "<br/>" . $comment;
			}

			if ($code == 'CTR') {
				if (is_referer($referer)) $comment = $referer . "<br/>" . $comment;
			}

			/* Dans ce cas on prend les code RCC et RCL et on ajoute le referer si il y est */
			if ($code == 'TOUT') {
				if ($user_agent != '') $comment = $user_agent . "<br/>" . $comment;
				if ($referer    != '') $comment = $referer . "<br/>" . $comment;
			}

			echo "<tr>\n";
			echo "<td>$idk</td>\n";
			echo "<td>$dat<br/><a href='/admin/tracking.php?nbj=2&code=TOUT&IP_to_track=$ip&cmd=process_tracking&action=examiner'>$ip</a></td>\n";
			echo "<td>$cop<br/>$res</td>\n";
			$file = basename($file);
			echo "<td>$file<br/>$line</td>\n";
			echo "<td>$comment</td>\n";
			echo "</tr>\n";
			$ir++;
		}

		echo '</table>';
		echo "Nombre de r�sultats $ir<br/>\n";
	}
	//-------------------------------------------------------------------------------------------------
	//
	function is_browser_user_agent($user_agent) {

		if ($user_agent == "Mozilla/2.0 (compatible; Ask Jeeves/Teoma; +http://about.ask.com/en/docs/about/webmasters.shtml)") return false;
		if ($user_agent == "Mediapartners-Google") return false;
		if ($user_agent == "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)") return false;
		if ($user_agent == "Mozilla/5.0 (compatible; Yahoo! Slurp/3.0; http://help.yahoo.com/help/us/ysearch/slurp)") return false;
		if ($user_agent == "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)") return false;
		if ($user_agent == "msnbot/1.1 (+http://search.msn.com/msnbot.htm)") return false;
		if ($user_agent == "Gigabot/3.0 (http://www.gigablast.com/spider.html)") return false;
		if ($user_agent == "Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.8.1) VoilaBot BETA 1.2 (http://www.voila.com/)") return false;
		if ($user_agent == "Java/1.4.1_04") return false;

		/*   
  if ( $user_agent == "" ) return true;
  if ( $user_agent == "" ) return true;
  */

		return true;
	}
	//-------------------------------------------------------------------------------------------------
	//
	function is_referer($referer) {

		if ($referer != "" && !ereg('http://www.top-immobilier-particulier.fr', $referer)) return true;
		else return false;
	}
	//-------------------------------------------------------------------------------------------------
	//
	function print_tracking_form() {
	?>
		<form name="tracking_liste" method="get" action="<?PHP print($_SERVER['PHP_SELF']); ?>">
			<table width="720" border="1" align="center" cellpadding="20" cellspacing="0" bordercolor="336633">
				<tr>
					<td>Remonter sur <br />
						<input name="nbj" type="int" value="2" size="5">
						jours
					</td>
					<td>
						<input type="hidden" name="action" value="liste">
						<input type="submit" name="Submit" value="Examiner le tracking">
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	//-------------------------------------------------------------------------------------------------
	//
	function print_purger_form() {
	?>
		<form name="tracking_purger" method="get" action="<?PHP print($_SERVER['PHP_SELF']); ?>">
			<table width="100%" border="1" align="center" cellpadding="20" cellspacing="0" bordercolor="336633">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="5">
							<tr>
								<td>Annuler </td>
								<td>
									<input type="radio" name="cmd" value="annuler" checked>
								</td>
							</tr>
							<tr>
								<td>Purger</td>
								<td>
									<input type="radio" name="cmd" value="purger_tout">
								</td>
							</tr>
						</table>

					</td>
					<td>
						<input type="hidden" name="action" value="purger">
						<input type="submit" name="Submit" value="Purger le tracking">
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	//-------------------------------------------------------------------------------------------------
	//
	function print_examiner_form($nbj, $code, $dtb_trace, $IP_to_track) {
	?>
		<form name="tracking_examiner" method="get" action="<?PHP print($_SERVER['PHP_SELF']); ?>">
			<table width="100%" border="1" align="center" cellpadding="20" cellspacing="0" bordercolor="336633">
				<tr>
					<td>
						<table width="350" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td>Nombre de jours</td>
								<td>
									<select name="nbj">
										<option value="1" <?PHP if ($nbj ==  '1') echo "selected" ?>>1</option>
										<option value="2" <?PHP if ($nbj ==  '2') echo "selected" ?>>2</option>
										<option value="3" <?PHP if ($nbj ==  '3') echo "selected" ?>>3</option>
										<option value="4" <?PHP if ($nbj ==  '4') echo "selected" ?>>4</option>
										<option value="5" <?PHP if ($nbj ==  '5') echo "selected" ?>>5</option>
										<option value="6" <?PHP if ($nbj ==  '6') echo "selected" ?>>6</option>
										<option value="7" <?PHP if ($nbj ==  '7') echo "selected" ?>>7</option>
										<option value="15" <?PHP if ($nbj == '15') echo "selected" ?>>15</option>
										<option value="21" <?PHP if ($nbj == '21') echo "selected" ?>>21</option>
										<option value="28" <?PHP if ($nbj == '28') echo "selected" ?>>28</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>(NAV) Entr&eacute;e sur le site</td>
								<td>
									<input type="radio" name="code" value="NAV" <?PHP if ($code == 'NAV') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>(ADM) Action de l'administrateur</td>
								<td>
									<input type="radio" name="code" value="ADM" <?PHP if ($code == 'ADM') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>(CTR) Monitoring Compte Recherche</td>
								<td>
									<input type="radio" name="code" value="CTR" <?PHP if ($code == 'CTR') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td>(CRR) Cron Compte Recherche</td>
								<td>
									<input type="radio" name="code" value="CRR" <?PHP if ($code == 'CRR') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>(CTA) Monitoring Compte Annonce</td>
								<td>
									<input type="radio" name="code" value="CTA" <?PHP if ($code == 'CTA') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td>(CRA) Cron Compte Annonce</td>
								<td>
									<input type="radio" name="code" value="CRA" <?PHP if ($code == 'CRA') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>(RED) Recherche D&eacute;taill&eacute;e</td>
								<td>
									<input type="radio" name="code" value="RED" <?PHP if ($code == 'RED') echo "checked" ?>>
								</td>
							</tr>
							<tr align="center" valign="middle">
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>(RCC) Recherche Carte</td>
								<td>
									<input type="radio" name="code" value="RCC" <?PHP if ($code == 'RCC') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td>(RCL) Recherche Liste</td>
								<td>
									<input type="radio" name="code" value="RCL" <?PHP if ($code == 'RCL') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td>(DTB) Trace Database</td>
								<td>
									<input type="checkbox" name="dtb_trace" value="1" <?PHP if ($dtb_trace == 1) echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">-------------------------------------------------------------------</td>
							</tr>
							<tr>
								<td>Filtrage sur le Referer</td>
								<td>
									<input type="radio" name="code" value="REF" <?PHP if ($code == 'REF') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td>Tout</td>
								<td>
									<input name="code" type="radio" value="TOUT" <?PHP if ($code == 'TOUT') echo "checked" ?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">IP<br />
									<input name="IP_to_track" type="text" id="IP_to_track" value="<?PHP echo "$IP_to_track"; ?>">
								</td>
							</tr>
						</table>

					</td>
					<td>
						<input type="hidden" name="cmd" value="process_tracking">
						<input type="hidden" name="action" value="examiner">
						<input type="submit" name="Submit" value="Examiner le tracking">
					</td>
				</tr>
			</table>
		</form>
	<?PHP
	}
	?>
</body>

</html>