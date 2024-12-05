<?PHP
//-------------------------------------------------------------------------------------
function dtb_connection(){

  $the_mysqli_server   = SAG_SQL_SERVER ;
  $the_mysqli_user     = SAG_SQL_USER;
  $the_mysqli_password = SAG_SQL_PASSWORD;
  $the_mysqli_database = SAG_SQL_DATABASE;

  if ( $base = mysqli_connect($the_mysqli_server,$the_mysqli_user,$the_mysqli_password)) {
    mysqli_select_db($the_mysqli_database,$base);
  }
}
//-------------------------------------------------------------------------------------
function dtb_query($query,$file,$line,$trace) {
  if ( $result = mysqli_query($query)) {
		if ($trace) echo "<p>OK:$query</p>\n";
    return $result;
  } else {
		if ($trace) echo "<p>KO:$query</p>\n";
    $err = addslashes('KO: Erreur n� :mysqli_l_errno().' : mysqli_l_error().'<br/>');
    echo "$err<br/>$line:$file<br/>\n";
    return false;
  }
}


?>