<?PHP
include("../data/data.php");
include("../include/inc_base.php");

dtb_connection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Manipulation de ref_ville</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP

	$query = "SELECT ville FROM ref_ville";
	$result = dtb_query($query, __FILE__, __LINE__, 1);

	while (list($ville_from_ref_ville) = mysqli_fetch_row($result)) {

		//echo "Recherche de $ville_from_ref_ville dans loc_ville<br/>";
		$ville_from_ref_ville = addslashes($ville_from_ref_ville);
		$query = "SELECT v.ville,v.ville_lat,v.ville_lng,d.dept FROM loc_ville as v , loc_departement as d WHERE v.idd = d.idd AND v.ville='$ville_from_ref_ville'";
		$result_loc = dtb_query($query, __FILE__, __LINE__, 0);

		if (mysqli_num_rows($result_loc) == 0)  echo "$ville_from_ref_ville n'est pas trouv� dans loc_ville<br/>";
		else {
			list($zone_ville, $ville_lat, $ville_lng, $zone_dept) = mysqli_fetch_row($result_loc);
			echo "$zone_ville => $zone_dept<br/>\n";

			//$dept_url = strtolower(str_replace(' ','-',$zone_dept));
			//$dept_url = str_replace("'",'--',$dept_url);

			//echo "$zone_dept => $dept_url<br/>\n";

			$query = "UPDATE ref_ville SET maps_lat='$ville_lat',maps_lng='$ville_lng',maps_actif=1 WHERE ville='$ville_from_ref_ville' LIMIT 1";
			dtb_query($query, __FILE__, __LINE__, 1);
		}
	}



	/*

//---------------------------------------------------------------------------------------------------
// G�rer les annonces sur Paris
// L'arrondissement d�j� positionn�
// zone doit �tre basculer sur france
// le num�ro du d�partement doit �tre mis � 75
$query = "SELECT tel_ins FROM ano WHERE zone='paris'";
$result = dtb_query($query,__FILE__,__LINE__,1);
while ( list($tel_ins) = mysqli_fetch_row($result) ) {

	// Mettre � jour la zone dept
  $query = "UPDATE ano SET zone='france',zone_dept=75 WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($query,__FILE__,__LINE__,1);

}

//---------------------------------------------------------------------------------------------------
// G�rer les d�partements de la couronne parisienne
// L'arrondissement doit devenir le d�partement puis mis � z�ro
// zone doit �tre basculer sur france
// on arrange un peu zone ville qui a �t� saisie � la main.
$query = "SELECT tel_ins,zone_ville,zone_ard FROM ano WHERE ( zone_ard=77 OR zone_ard=78  OR zone_ard=91 OR zone_ard=92 OR zone_ard=93 OR zone_ard=94 OR zone_ard=95 )";
$result = dtb_query($query,__FILE__,__LINE__,1);

while ( list($tel_ins,$zone_ville,$zone_ard) = mysqli_fetch_row($result) ) {

  $zone_ville = ucwords(strtolower($zone_ville));
  echo "$tel_ins : $zone_ville : $zone_ard<br/>\n";
	
	// Mettre � jour la zone dept
  $query = "UPDATE ano SET zone='france',zone_dept='$zone_ard',zone_ville='$zone_ville',zone_ard=0 WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($query,__FILE__,__LINE__,1);

}

//---------------------------------------------------------------------------------------------------
// R�cup�rer les arrondissements Lyon et marseille
$query = "SELECT tel_ins,zone_ville,quart FROM ano WHERE ( zone_ville='Marseille' OR zone_ville='Lyon')";
$result = dtb_query($query,__FILE__,__LINE__,1);

while ( list($tel_ins,$zone_ville,$quart) = mysqli_fetch_row($result) ) {

  echo "$tel_ins : $zone_ville : $quart<br/>\n";
	
	// On doit v�rifier si c'est un chiffre
	if ( ereg("^([0-9]{1,2}).*$",$quart,$zone_ard) ) {
	
	  echo "OK Ard => ",$zone_ard[1],"<br/>\n";
		
		$ard = $zone_ard[1]; 
		if ( $ard <= 16 ) {
	
	    // Mettre � jour la zone dept
      $query = "UPDATE ano SET zone_ard='$ard' WHERE tel_ins='$tel_ins' LIMIT 1";
	    dtb_query($query,__FILE__,__LINE__,1);

    }

  }
}


//---------------------------------------------------------------------------------------------------
// Mettre en forme les villes
// R�cup�rer les arrondissements Lyon et marseille
$query = "SELECT tel_ins,zone_ville FROM ano";
$result = dtb_query($query,__FILE__,__LINE__,1);

while ( list($tel_ins,$zone_ville) = mysqli_fetch_row($result) ) {

  $zone_ville = ucwords(strtolower(mysqli_real_escape_string($zone_ville)));
  echo "$tel_ins : $zone_ville<br/>\n";
	
  $query = "UPDATE ano SET zone_ville='$zone_ville' WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($query,__FILE__,__LINE__,1);


}

//---------------------------------------------------------------------------------------------------
// Mettre � jour la zone r�gion
$query = "SELECT a.tel_ins,a.zone_dept,r.region FROM ano as a, loc_departement as d, loc_region as r WHERE d.idr = r.idr AND d.dept_num = a.zone_dept";
$result = dtb_query($query,__FILE__,__LINE__,1);

while ( list($tel_ins,$zone_dept,$region) = mysqli_fetch_row($result) ) {

  echo "tel_ins => $tel_ins :: zone_dept => $zone_dept :: region => $region<br/>\n";
  $zone_region = mysqli_real_escape_string($region);
	
  $query = "UPDATE ano SET zone_region='$zone_region' WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($query,__FILE__,__LINE__,1);


}


//---------------------------------------------------------------------------------------------------
// Recopier zone_dept dans num_dept
// Puis mettre � jour zone_dept avec le nom du d�partement.
// On fait en deux parcours.
$query = "SELECT tel_ins,zone_dept FROM ano";
$result = dtb_query($query,__FILE__,__LINE__,1);

while ( list($tel_ins,$zone_dept) = mysqli_fetch_row($result) ) {

  echo "tel_ins => $tel_ins :: zone_dept => $zone_dept<br/>\n";
	
  $query = "UPDATE ano SET num_dept='$zone_dept' WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($query,__FILE__,__LINE__,1);

}

*/

	?>
</body>

</html>