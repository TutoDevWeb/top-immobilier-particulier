<?PHP
//-----------------------------------------------------------------------
// Fabrique une annonce de maison
function make_maison($ref_ville, $ref_dept) {

	$str_commodite = make_commodite();

	$blabla = $str_commodite;

	echo "--------------------------------<br/>";
	echo "$ref_ville : $blabla<br/>";

	make_zone($ref_ville, $ref_dept, $zone, $zone_pays, $zone_region, $zone_dept, $zone_ville, $zone_ard, $num_dept);

	$surf = mt_rand(100, 200);

	$prix = make_prix($ref_ville, $ard, $surf);

	$tel_ins  = get_telephone();
	$email    = 'silver_immo@yahoo.fr';
	$ok_email = 0;
	$password = pass_generator();
	$etat     = 'attente_validation';
	$duree    = 6;

	//----------------------------------------------------------------------------------------
	// dat_fin : Calculer la date de fin 
	$select = "SELECT DATE_ADD(now(),interval $duree MONTH)";
	$result = dtb_query($select, __FILE__, __LINE__, 1);
	list($dat_fin) = mysqli_fetch_row($result);

	$zone_ville_s  = mysqli_real_escape_string($zone_ville);
	$zone_dept_s   = mysqli_real_escape_string($zone_dept);
	$zone_region_s = mysqli_real_escape_string($zone_region);

	$typp     = 8;
	$nbpi     = $nbp;
	$blabla_s = mysqli_real_escape_string($blabla);

	$insert = "INSERT INTO ano (tel_ins,password,email,ok_email,
	                            tel_bis,etat,dat_ins,dat_fin,
															zone,zone_pays,zone_region,zone_dept,zone_ville,zone_ard,num_dept,
	                            typp,nbpi,surf,prix,blabla) 
	            VALUES ('$tel_ins','$password','$email','$ok_email',
	                    '$tel_bis','$etat',now(),'$dat_fin',
											'$zone','$zone_pays','$zone_region_s','$zone_dept_s','$zone_ville_s','$zone_ard','$num_dept',
	                    '$typp','$nbpi','$surf','$prix','$blabla_s')";
	dtb_query($insert, __FILE__, __LINE__, 1);
	//echo "$insert<br/>";

}
