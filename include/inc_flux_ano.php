<?PHP

function get_titre($zone_ville,$zone_ard,$typp,$nbpi,$surf,$prix) {

  // Cas du Studio
  if ( $nbpi == 1 ) {

    if ( $zone_ard ) $titre = $zone_ville." : ".$zone_ard." ard Studio de ".$surf." m2 ".$prix." Euros";
	  else $titre = $titre = $zone_ville." : Studio de ".$surf." m2 ".$prix." Euros";
	
	} else {

    if ( $zone_ard ) $titre = $zone_ville." : ".$zone_ard." ard ".ucfirst($typp)." de ".$nbpi." pieces ".$surf." m2 ".$prix." Euros";
	  else $titre = $titre = $zone_ville." : ".ucfirst($typp)." de ".$nbpi." pieces ".$surf." m2 ".$prix." Euros";

  }

  return $titre;

}

?>