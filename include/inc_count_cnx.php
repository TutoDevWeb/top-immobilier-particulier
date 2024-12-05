<?PHP
function count_cnx($connexion) {

	$ip = $_SERVER['REMOTE_ADDR'];

	// Chercher l'ip est dans la table
	$query  = "SELECT ip FROM cnx_sag WHERE ip='$ip'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

	// Si elle y est on met � jour la date
	if (mysqli_num_rows($result)) {

		$query = "UPDATE cnx_sag SET dat=now() WHERE ip='$ip' LIMIT 1";
		dtb_query($connexion, $query, __FILE__, __LINE__, 0);

		// Sinon on l'ins�re
	} else {

		$query = "INSERT INTO cnx_sag (ip,dat) VALUES ('$ip',now())";
		dtb_query($connexion, $query, __FILE__, __LINE__, 0);
	}

	// On retrouve la fenêtre
	$win = get_win($connexion);

	// On purge les entr�es qui sont trop vieilles
	$query = "DELETE FROM cnx_sag WHERE ( (UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(dat) ) > $win )";
	dtb_query($connexion, $query, __FILE__, __LINE__, 0);

	// On compte les entr�es restants
	$query = "SELECT COUNT(ip) FROM cnx_sag";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);

	list($cnx) = mysqli_fetch_row($result);
	return $cnx;
}

function get_win($connexion) {

	// On compte les entr�es restants
	$query = "SELECT HOUR(now())";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, 0);
	list($hour) = mysqli_fetch_row($result);

	if ($hour <=  5) $win =  300; // 5 minutes  jusqu'�  5H59
	else if ($hour <=  9) $win =  900; // 15 minutes jusqu'�  9H59
	else if ($hour <= 22) $win = 1800; // 30 minutes jusqu'� 22H59
	else if ($hour <= 23) $win =  900; // 15 minutes jusqu'� 23H59

	//echo "hour:$hour | win:$win<br/>";

	return $win;
}

function print_cnx($cnx) {

	if ($cnx == 1) echo "<strong>1 connecté</strong>";
	else echo "<strong>$cnx connectés</strong>";
}

function print_virtual_cnx($cnx) {

	$virtual_cnx = get_virtual_cnx();

	$cnx = $cnx + $virtual_cnx;

	if ($cnx == 1) echo "<strong>1 connecté</strong>";
	else echo "<strong>$cnx connectés</strong>";
}

function get_virtual_cnx() {

	$index_jour  = (int)date("w", time());
	$index_heure = (int)date("G", time());
	//$index_GMT = date("O",time());

	$jour = array(1.0, 0.996, 0.88, 0.898, 0.765, 0.765, 0.775);
	$heure = array(0.2, 0.1, 0.05, 0, 0, 0.05, 0.05, 0.1, 0.2, 0.4, 0.6, 0.7, 0.6, 0.7, 0.8, 0.9, 0.9, 1, 0.95, 0.8, 0.8, 0.8, 0.6, 0.4);

	//echo "index_jour  => $index_jour<br/>\n";
	//echo "index_heure => $index_heure<br/>\n";
	//echo "index_GMT   => $index_GMT<br/>\n";

	//echo "coef_jour  => ",$jour[$index_jour],"<br/>\n";
	//echo "coef_heure => ",$heure[$index_heure],"<br/>\n";

	// Le 10/08/2008 on passe de 20 à 15
	$virtual_cnx = (int)(15.0 * $jour[$index_jour] * $heure[$index_heure]);

	return $virtual_cnx;
}
