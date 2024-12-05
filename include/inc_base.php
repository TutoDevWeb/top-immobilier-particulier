<?PHP
//-------------------------------------------------------------------------------------
function dtb_connection() {

	$the_mysqli_server   = SAG_SQL_SERVER;
	$the_mysqli_user     = SAG_SQL_USER;
	$the_mysqli_password = SAG_SQL_PASSWORD;
	$the_mysqli_database = SAG_SQL_DATABASE;

	if ($connexion = mysqli_connect($the_mysqli_server, $the_mysqli_user, $the_mysqli_password)) {
		mysqli_select_db($connexion, $the_mysqli_database);
		return $connexion;
	}
}
//-------------------------------------------------------------------------------------
function dtb_query($connexion, $query, $file, $line, $trace) {
	if ($result = mysqli_query($connexion, $query)) {
		if ($trace) echo "<p>OK:$query</p>\n";
		return $result;
	} else {
		if ($trace) echo "<p>KO:$query</p>\n";
		$err = addslashes('KO: Erreur numéro :mysqli_l_errno()' . mysqli_error($connexion) . '<br/>');
		echo "$err<br/>$line:$file<br/>\n";
		return false;
	}
}
