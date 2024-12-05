<?PHP
//-----------------------------------------------------------------------
// Fabrique une annonce de studio
function make_studio($ref_ville, $ref_dept) {

	// Superficie
	$surf = mt_rand(15, 28);

	$T_label_studio = array();
	if ($surf > 25)   array_push($T_label_studio, "Grand Studio");
	if ($surf > 25)   array_push($T_label_studio, "Studio");
	if ($surf < 18)   array_push($T_label_studio, "Studette");
	if ($surf < 18)   array_push($T_label_studio, "Studio");
	array_push($T_label_studio, "Studio");
	array_push($T_label_studio, "Studio");
	array_push($T_label_studio, "Studio");
	array_push($T_label_studio, "Studio");
	array_push($T_label_studio, "T1");
	array_push($T_label_studio, "T1");
	array_push($T_label_studio, "T1");
	array_push($T_label_studio, "1 pi�ce");
	array_push($T_label_studio, "1 pi�ce");
	array_push($T_label_studio, "1 pi�ce");
	array_push($T_label_studio, "1 pi�ce");
	array_push($T_label_studio, "1 pi�ce");
	array_push($T_label_studio, "Appartement 1 pi�ce");

	$ind            = mt_rand(0, count($T_label_studio) - 1);
	$label_studio   = $T_label_studio[$ind];

	//-----------------------------------------------------------------------------------
	// Etage
	$T_eta = array(
		array("rdc", "1er", "2e", "3e", "4e"),
		array("rdc", "1er", "2e", "3e", "4e"),
		array("rdc", "1er", "2e", "3e", "4e"),
		array("rez-de-chauss�e", "1er", "2i�me", "3i�me", "4i�me"),
		array("rez-de-chauss�e", "1er", "2�", "3�", "4�"),
		array("rez-de-chauss�e", "1er", "2�", "3�", "4�")
	);

	$ind_col = mt_rand(0, count($T_eta[0]) - 1);
	$ind_raw = mt_rand(0, count($T_eta) - 1);

	$eta     = $T_eta[$ind_raw][$ind_col];

	// Exposition
	$T_expo = array("sud", "plein sud", "sud/est", "sud/ouest", "est/ouest", "ouest", "Sud", "Sud/Est", "Sud/Ouest", "Est/Ouest", "Ouest");
	$ind   = mt_rand(0, count($T_expo) - 1);
	$expo  = $T_expo[$ind];

	//-----------------------------------------------------------------------------------
	// Cuisine
	$T_cui = array();
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisinette �quip�e avec bar am�ricain,");
	array_push($T_cui, " cuisine am�nag�e,");
	array_push($T_cui, " grande cuisine �quip�e,");
	array_push($T_cui, " cuisine am�ricaine,");
	array_push($T_cui, " cuisine am�ricaine,");
	array_push($T_cui, " cuisine am�ricaine,");
	array_push($T_cui, " cuisine am�ricaine,");
	array_push($T_cui, " cuisine,");
	array_push($T_cui, " cuisine am�ricaine �quip�e,");
	array_push($T_cui, " cuisine am�ricaine enti�rement �quip�e,");
	array_push($T_cui, " cuisine am�nag�e neuve,");
	array_push($T_cui, " cuisine neuve,");
	array_push($T_cui, " cuisine moderne �quip�e,");
	array_push($T_cui, " cuisine am�nag�e �quip�e,");
	array_push($T_cui, " cuisine meubl�e,");
	array_push($T_cui, " cuisine US,");
	array_push($T_cui, " cuisine ouverte,");
	$ind = mt_rand(0, count($T_cui) - 1);
	$cui = $T_cui[$ind];

	//-----------------------------------------------------------------------------------
	// Salle de bains / salle d'eau / WC
	$T_sdb = array();
	array_push($T_sdb, " salle de bains avec wc,");
	array_push($T_sdb, " salle de bains wc,");
	array_push($T_sdb, " salle de bains WC,");
	array_push($T_sdb, " sdb-wc,");
	array_push($T_sdb, " sdb et wc,");
	array_push($T_sdb, " salle de bains et wc s�par�s,");
	array_push($T_sdb, " salle de bains , wc s�par�s,");
	array_push($T_sdb, " salle de bains , WC s�par�s,");
	array_push($T_sdb, " salle de bains et wc ind�pendants,");
	array_push($T_sdb, " sdb baignoire wc,");
	array_push($T_sdb, " SDB baignoire WC,");
	array_push($T_sdb, " salle d'eau et wc,");
	array_push($T_sdb, " salle d'eau, wc s�par�s,");
	array_push($T_sdb, " douche wc,");
	array_push($T_sdb, " douche , wc s�par�s,");
	array_push($T_sdb, " douche WC,");
	array_push($T_sdb, " douche , WC s�par�s,");

	$ind = mt_rand(0, count($T_sdb) - 1);
	$sdb = $T_sdb[$ind];

	//-----------------------------------------------------------------------------------
	// Studio
	$T_studio = array();
	array_push($T_studio, "$label_studio, $surf m�, au $eta.");
	array_push($T_studio, "$label_studio, $surf m�, au $eta ascenseur.");
	array_push($T_studio, "Immeuble ancien en pierres, $label_studio $surf m�, $eta.");
	array_push($T_studio, "$label_studio $surf m� environ. Au $eta sur cour.");
	array_push($T_studio, "$label_studio $surf m� loi Carrez, au $eta sur cour.");
	array_push($T_studio, "$label_studio $surf m� �quip�. Au $eta avec ascenseur dans un immeuble ancien.");
	array_push($T_studio, "Tr�s beau $label_studio $surf m� �tat impeccable.");
	array_push($T_studio, "Grand $label_studio meubl�, $surf m�, d�cor�.");
	array_push($T_studio, "$label_studio meubl� $surf m�, refait � neuf.");
	array_push($T_studio, "$label_studio meubl� $surf m�, quartier tr�s agr�able.");
	array_push($T_studio, "Au $eta sans ascenseur, $label_studio $surf m�, refait � neuf.");
	array_push($T_studio, "Beau $label_studio de $surf m� environ, traversant, au $eta.");
	array_push($T_studio, "$label_studio de $surf m� dans petite r�sidence au $eta, bon standing.");
	array_push($T_studio, "$label_studio de $surf m� au $eta dans r�sidence de bon standing.");
	array_push($T_studio, "$label_studio $surf m� sur cour dans immeuble pierre de taille.");
	array_push($T_studio, "Immeuble pierre de taille. Au $eta sans ascenseur. $label_studio $surf m� (loi Carrez).");
	array_push($T_studio, "Beau $label_studio en bon �tat de $surf m� loi Carrez. $eta ascenseur.");
	array_push($T_studio, "Au $eta d'un immeuble ancien, $label_studio tr�s clair, $surf m� environ.");
	array_push($T_studio, "Dans immeuble de caract�re au $eta. $label_studio, $surf m�.");
	array_push($T_studio, "$label_studio, libre, $surf m�. Petite copropri�t�. $eta, refait neuf.");
	array_push($T_studio, "Au $eta et dernier �tage, $label_studio environ $surf m� habitables.");
	array_push($T_studio, "$label_studio $surf m� au $eta, r�sidence ferm�e.");

	$ind = mt_rand(0, count($T_studio) - 1);
	$str_studio = $T_studio[$ind];

	//-----------------------------------------------------------------------------------
	$T_sejour = array();
	array_push($T_sejour, " S�jour,");
	array_push($T_sejour, " S�jour,");
	array_push($T_sejour, " S�jour,");
	array_push($T_sejour, " Pi�ce principale,");
	array_push($T_sejour, " Pi�ce � vivre,");
	array_push($T_sejour, " S�jour avec 2 fen�tres,");
	array_push($T_sejour, " S�jour avec 2 fen�tres,");
	array_push($T_sejour, " S�jour avec 2 fen�tres,");
	array_push($T_sejour, " Pi�ce principale avec 2 fen�tres,");
	array_push($T_sejour, " Pi�ce � vivre avec grande fen�tre,");
	array_push($T_sejour, " S�jour avec placards et 2 fen�tres,");
	array_push($T_sejour, " S�jour avec placards et 2 fen�tres,");
	array_push($T_sejour, " S�jour avec placards et 2 fen�tres,");
	array_push($T_sejour, " Pi�ce principale avec placards et fen�tre,");
	array_push($T_sejour, " Pi�ce � vivre avec placards et 2 fen�tres,");
	array_push($T_sejour, " S�jour avec rangements,");
	array_push($T_sejour, " S�jour avec rangements,");
	array_push($T_sejour, " S�jour avec rangements,");
	array_push($T_sejour, " Pi�ce principale lumineuse avec fen�tre,");
	array_push($T_sejour, " Pi�ce � vivre tr�s claire avec 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grande pi�ce principale avec 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grande pi�ce � vivre avec grande fen�tre,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec placards et 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec placards et 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec placards et 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grande pi�ce principale avec placards et fen�tre,");
	if ($surf > 23) array_push($T_sejour, " Grande pi�ce � vivre avec placards et 2 fen�tres,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec rangements,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec rangements,");
	if ($surf > 23) array_push($T_sejour, " Grand s�jour avec rangements,");
	if ($surf > 23) array_push($T_sejour, " Grande pi�ce principale lumineuse avec fen�tre,");
	if ($surf > 23) array_push($T_sejour, " Grande pi�ce � vivre tr�s claire avec 2 fen�tres,");
	array_push($T_sejour, " S�jour tr�s lumineux et calme,");
	array_push($T_sejour, " S�jour tr�s lumineux et calme,");
	array_push($T_sejour, " S�jour tr�s lumineux et calme,");
	array_push($T_sejour, " Pi�ce principale avec vue sur $ville,");
	array_push($T_sejour, " Pi�ce � vivre tr�s ensoleill�,");
	array_push($T_sejour, " S�jour calme expos� $expo,");
	array_push($T_sejour, " S�jour tr�s lumineux, exposition $expo,");
	array_push($T_sejour, " S�jour tr�s lumineux et calme orient� $expo,");
	array_push($T_sejour, " Pi�ce principale avec superbe vue sur $ville,");
	array_push($T_sejour, " S�jour avec magnifique vue sur $ville,");
	array_push($T_sejour, " Pi�ce principale avec superbe vue sur $ville,");
	array_push($T_sejour, " Pi�ce � vivre tr�s ensoleill�,");
	$ind = mt_rand(0, count($T_sejour) - 1);
	$sej = $T_sejour[$ind];

	//-----------------------------------------------------------------------------------
	// Parking
	$T_par = array();
	array_push($T_par, "");
	array_push($T_par, "");
	array_push($T_par, "");
	array_push($T_par, "");
	array_push($T_par, "");
	array_push($T_par, " Possibilit� garage ferm�.");
	array_push($T_par, " Box ferm� en sous-sol.");
	array_push($T_par, " Parking privatif et cave.");
	array_push($T_par, " Possibilit� garage � proximit�.");
	array_push($T_par, " Possibilit� garage.");
	array_push($T_par, " Possibilit� garage location.");
	array_push($T_par, " Garage individuel sous-sol.");
	array_push($T_par, " Parking.");
	array_push($T_par, " Cave, parking.");
	array_push($T_par, " Possibilit� box.");
	array_push($T_par, " Cave, possibilit� box.");
	array_push($T_par, " Garage ferm�.");
	$ind = mt_rand(0, count($T_par) - 1);
	$par = $T_par[$ind];

	//-----------------------------------------------------------------------------------
	// Chauffage
	$T_rad = array();
	array_push($T_rad, "");
	array_push($T_rad, "");
	array_push($T_rad, "");
	array_push($T_rad, " Climatisation r�versible.");
	array_push($T_rad, " Chauffage collectif au sol.");
	array_push($T_rad, " Chauffage individuel.");
	array_push($T_rad, " Chauffage individuel.");
	array_push($T_rad, " Chauffage individuel gaz.");
	array_push($T_rad, " Chauffage collectif.");
	array_push($T_rad, " Chauffage collectif.");
	array_push($T_rad, " Chauffage collectif fioul.");
	array_push($T_rad, " Chauffage collectif gaz.");
	array_push($T_rad, " Chauffage electrique.");
	array_push($T_rad, " Chauffage �lectrique.");
	array_push($T_rad, " Climatisation.");
	array_push($T_rad, " Climatisation r�versible.");
	array_push($T_rad, " Chauffage gaz.");
	$ind = mt_rand(0, count($T_rad) - 1);
	$rad = $T_rad[$ind];

	//-----------------------------------------------------------------------------------
	// Divers
	$T_div = array();
	array_push($T_div, " Espaces verts.");
	array_push($T_div, " Espaces verts.");
	array_push($T_div, " Espaces verts.");
	array_push($T_div, " Lisi�re zone verte.");
	array_push($T_div, " Agences s'abstenir.");
	array_push($T_div, " Agence s'abstenir.");
	array_push($T_div, " Agences s'abstenir.");
	array_push($T_div, " Agence s'abstenir.");
	array_push($T_div, " Agences s'abstenir.");
	array_push($T_div, " Agence s'abstenir.");
	array_push($T_div, " Agences s'abstenir.");
	array_push($T_div, " Agence s'abstenir.");
	array_push($T_div, " Agence s'abstenir. Merci.");
	array_push($T_div, " Gardien.");
	array_push($T_div, " Tr�s faibles charges.");
	array_push($T_div, " Faibles charges.");
	array_push($T_div, " Tr�s bon emplacement.");
	array_push($T_div, " Tr�s calme.");
	array_push($T_div, " Frais de notaire r�duits.");
	array_push($T_div, " Frais de notaire r�duits.");
	array_push($T_div, " Frais de notaire r�duits.");
	array_push($T_div, " Espaces verts clos et arbor�s.");
	array_push($T_div, " Quartier tr�s agr�able.");
	array_push($T_div, " Parc avec aire jeux enfants.");
	array_push($T_div, " Interphone, digicode.");
	array_push($T_div, " Aires de jeux.");
	array_push($T_div, " Libre imm�diatement.");
	$ind = mt_rand(0, count($T_div) - 1);
	$div = $T_div[$ind];

	$str_piece = ${sej} . ${cui} . ${cha} . ${sdb};
	$str_piece = substr($str_piece, 0, -1) . ".";

	$str_commodite = make_commodite();

	$T_blabla = array();
	array_push($T_blabla, $str_studio . $str_piece . $rad . $par . $str_commodite . $div);
	array_push($T_blabla, $str_studio . $str_piece . $par . $rad . $str_commodite . $div);
	array_push($T_blabla, $str_studio . $str_piece . $par . $str_commodite . $rad . $div);
	array_push($T_blabla, $str_studio . $str_piece . $str_commodite . $par . $rad . $div);
	$ind    = mt_rand(0, count($T_blabla) - 1);
	$blabla = $T_blabla[$ind];

	echo "--------------------------------<br/>";
	echo "$ref_ville : $blabla<br/>";

	make_zone($ref_ville, $ref_dept, $zone, $zone_pays, $zone_region, $zone_dept, $zone_ville, $zone_ard, $num_dept);

	$prix = make_prix($ref_ville, $zone_ard, $surf);

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

	$typp     = 1;
	$nbpi     = 1;
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
