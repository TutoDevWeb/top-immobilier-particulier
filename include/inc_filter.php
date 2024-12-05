<?PHP
function filtre(&$entry) {

  // liste des caractères filtrés
	// # < > $ ! ? " { } ( ) \ ; * % ` = [ ]

  // Suppression des caractères interdits
	$entry = preg_replace("/\\x23|\\x3c|\\x3e|\\x24|\\x21|\\x3f|\\x22|\\x7b|\\x7d|\\x28|\\x29|\\x5c|\\x3b|\\x2a|\\x25|\\x60|\\x3d|\\x5b|\\x5d/","-",$entry);

}
//-----------------------------------------------------------------------------------
function filtrer_les_entrees_request($file,$line) {
  array_walk($_REQUEST,"filtre");
  return true;  
}
//-----------------------------------------------------------------------------------
function filtrer_les_entrees_post($file,$line) {
  array_walk($_POST,"filtre");
  return true;  
}
//-----------------------------------------------------------------------------------
function filtrer_les_entrees_get($file,$line) {

	/*
	echo "-------------------------------------<br/>";
  print_r($_GET);
	echo "<br/>";*/

  array_walk($_GET,"filtre");
  return true;  
}
//-----------------------------------------------------------------------------------
function filtre_non_imprimable($bla) {

  // Suppression des caractères non imprimables.
  $bla  = preg_replace("/\\x0|[\x01-\x1f]/U"," ",$bla);

  return $bla;
}
//-----------------------------------------------------------------------------------
?>