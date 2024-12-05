<?PHP
//-----------------------------------------------------------------------
// Fabrique une annonce d'appartement 2P/3P/4P/5P
function make_appartement($ref_ville, $ref_dept) {

	$debug = false;

	// Type 2/3 pi�ces ou T2/3 ou F2/3
	$T_typ  = array("2", "2", "2/3", "3", "3", "3", "3/4", "4", "4", "5");
	// Vrai par exemple si c'est un vrai F3 et aux si c'est un faux
	$T_spe  = array(true, true, false, true, true, true, false, true, true, true);
	// Nombre de pi�ces
	$T_nbp  = array(2, 2, 3, 3, 3, 3, 4, 4, 4, 5);
	// Nombre de chambres
	$T_nbc  = array(1, 1, 1, 2, 2, 2, 2, 3, 3, 4);
	// Superficie min
	$T_surf_min = array(30, 35, 40, 50, 55, 60, 65, 70, 80, 90);
	$T_surf_max = array(45, 50, 60, 70, 75, 80, 85, 90, 95, 110);

	// Un seul index pour tous les tableaux
	$ind      = mt_rand(0, count($T_typ) - 1);
	$typ      = $T_typ[$ind];
	$spe      = $T_spe[$ind];
	$nbp      = $T_nbp[$ind];
	$nbc      = $T_nbc[$ind];
	$surf_min = $T_surf_min[$ind];
	$surf_max = $T_surf_max[$ind];
	$surf = mt_rand($surf_min, $surf_max);


	// Label pi�ces / T / F
	$T_label = array(" pi�ces", " pi�ces", " pieces", " pieces", "T", "F");
	$ind     = mt_rand(0, count($T_label) - 1);
	$label   = $T_label[$ind];

	if ($debug) {
		echo "---------------------------<br/>";
		echo "label : $label<br/>";
	}

	// Label et type assembl� => F3 ou 4 pi�ces ou T3/4
	if ($label == "T" || $label == "F") $label_appart = $label . $typ;
	else  $label_appart = $typ . $label;

	if ($debug) {
		echo "----------------------------<br/>";
		echo "label_appart : $label_appart<br/>";
	}


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

	// Nombre d'�tage
	$ind_offset = mt_rand(1, 4);
	$nb_eta = $ind_col + $ind_offset;

	if ($debug) {
		echo "---------------------------<br/>";
		echo "etage : $eta<br/>";
		echo "nombre etage : $nb_eta<br/>";
	}

	// Exposition
	$T_expo = array("sud", "plein sud", "sud/est", "sud/ouest", "est/ouest", "ouest", "Sud", "Sud/Est", "Sud/Ouest", "Est/Ouest", "Ouest");
	$ind   = mt_rand(0, count($T_expo) - 1);
	$expo  = $T_expo[$ind];

	if ($debug) {
		echo "---------------------------<br/>";
		echo "expo : $expo<br/>";
	}

	$T_appart = array();
	array_push($T_appart, "Grand beau $label_appart, $surf m� + balcon. Appartement refait enti�rement � neuf.");
	array_push($T_appart, "$label_appart de $surf m�.");
	array_push($T_appart, "Dans r�sidence neuve, grand standing, $label_appart, $surf m�.");
	array_push($T_appart, "$label_appart, $surf m�, $expo , au $eta et dernier �tage.");
	array_push($T_appart, "$label_appart, $surf m�, tr�s bon �tat.");
	array_push($T_appart, "$label_appart $surf m� r�nov�, au $eta sur $nb_eta �tages.");
	array_push($T_appart, "Appartement $label_appart, $surf m�, r�sidence standing, vue d�gag�e sur $ville.");
	array_push($T_appart, "Dans immeuble semi-r�cent, au $eta avec ascenseur, $label_appart $surf m�.");
	array_push($T_appart, "$label_appart, $surf m�, au $eta. Dans r�sidence calme.");
	array_push($T_appart, "$label_appart $surf m� dans r�sidence ferm�e et gardienn�. $eta etage.");
	array_push($T_appart, "Appartement $label_appart traversant, $surf m�.");
	array_push($T_appart, "Dans bel ancien, appartement $label_appart traversant, $surf m�. Belle vue sur $ville.");
	array_push($T_appart, "Dans immeuble standing. Appartement �tat neuf $label_appart $surf m�. Au $eta, ascenseur.");
	array_push($T_appart, "$label_appart $surf m�, au $eta, ascenseur, dans immeuble de standing.");
	array_push($T_appart, "Au $eta. Immeuble ancien bourgeois r�nov�. Environ $surf m�.");
	array_push($T_appart, "$label_appart, $surf m�, bon standing, tout confort.");
	array_push($T_appart, "$label_appart, $surf m� loi carrez, enti�rement r�nov�.");
	array_push($T_appart, "Dans immeuble ancien, $surf m�, $label_appart enti�rement r�nov�.");
	array_push($T_appart, "Dans r�sidence arbor�e. $label_appart $expo, $surf m�, au $eta.");
	array_push($T_appart, "$label_appart, $surf m�, au $eta. Immeuble $nb_eta �tages. Expos� $expo.");
	array_push($T_appart, "Au $eta et dernier �tage, ascenseur. $label_appart environ $surf m�. R�sidence ferm�e. Superbe vue sur $ville.");
	array_push($T_appart, "Quartier r�sidentiel. Appartement lumineux $surf m�, au $eta.");
	array_push($T_appart, "Dans r�sidence ferm�e avec piscine, appartement $label_appart, $surf m�.");
	array_push($T_appart, "Dans r�sidence ferm�e, au $eta avec ascenseur. Appartement de $label_appart de $surf m�, orient� $expo.");
	array_push($T_appart, "Appartement $surf m� (loi Carrez) $expo, au $eta.");
	array_push($T_appart, "Appartement $label_appart, $surf m�, dans maison de ville.");
	array_push($T_appart, "$label_appart lumineux, $surf m�, au $eta sur $nb_eta �tages, bel immeuble ancien.");
	array_push($T_appart, "Tr�s beau $label_appart, dans ancien immeuble bourgeois, pierre de taille.");
	array_push($T_appart, "$label_appart $surf m�, enti�rement r�nov�.");
	array_push($T_appart, "Grand $label_appart r�cent, $surf m�, au dernier �tage.");
	array_push($T_appart, "Appartement $label_appart, $surf m�. Au $eta. Traversant, lumineux.");
	array_push($T_appart, "$label_appart traversant $surf m�, tr�s bon �tat, au $eta ascenseur.");
	array_push($T_appart, "$label_appart $surf m� environ. Dans r�sidence s�curis�e avec entr�e digicode.");
	array_push($T_appart, "Dans r�sidence calme et arbor�e. $label_appart, $surf m�, au $eta, exposition $expo.");
	array_push($T_appart, "Dans petite r�sidence s�curis�e. $label_appart, $surf m�.");
	array_push($T_appart, "Dans environnement id�al $label_appart de $surf m�.");
	array_push($T_appart, "Parc ferm�, petite r�sidence. $label_appart, au $eta, $surf m2 loi carrez.");
	array_push($T_appart, "$label_appart $surf m�, enti�rement r�nov�, grande hauteur sous plafond.");
	array_push($T_appart, "$label_appart, $surf m�, parfait �tat, lumineux et spacieux. Dans quartier calme.");
	$ind = mt_rand(0, count($T_appart) - 1);
	$str_appart = $T_appart[$ind];

	//-----------------------------------------------------------------------------------
	// S�jour / Salon / Bureau
	$T_sej = array();
	// Si vrai F2 / F3 .... 
	if ($spe == true) {
		array_push($T_sej, " Salon ,");
		array_push($T_sej, " Salon ,");
		array_push($T_sej, " Salon ,");
		array_push($T_sej, " Salon ,");
		array_push($T_sej, " Salon ,");
		array_push($T_sej, " Salon ,");
		array_push($T_sej, " Salon spacieux ,");
		array_push($T_sej, " Salon avec poutres sur rue,");
		array_push($T_sej, " Salon plein sud sur rue,");
		array_push($T_sej, " Salon avec balcon,");
		array_push($T_sej, " Salon avec vue,");
		array_push($T_sej, " Salon avec vue sur parc,");
		array_push($T_sej, " Salon avec chemin�e,");
		array_push($T_sej, " Salon portes fen�tres et balcon");
		array_push($T_sej, " S�jour ,");
		array_push($T_sej, " S�jour ,");
		array_push($T_sej, " S�jour ,");
		array_push($T_sej, " S�jour ,");
		array_push($T_sej, " S�jour ,");
		array_push($T_sej, " Grand s�jour ,");
		array_push($T_sej, " S�jour lumineux ,");
		array_push($T_sej, " S�jour donnant sur rue,");
		array_push($T_sej, " S�jour plein sud,");
		array_push($T_sej, " S�jour avec balcon ouvert sur cour,");
		array_push($T_sej, " S�jour belle vue,");
		array_push($T_sej, " S�jour avec vue sur parc,");
		array_push($T_sej, " S�jour avec chemin�e,");
		array_push($T_sej, " S�jour fen�tres, balcon");
		// Sinon une chambre de moins il faut ajouter qq chose
	} else {
		array_push($T_sej, " Double s�jour ,");
		array_push($T_sej, " Double s�jour ,");
		array_push($T_sej, " Double s�jour ,");
		array_push($T_sej, " Double s�jour ,");
		array_push($T_sej, " Double s�jour ,");
		array_push($T_sej, " Double s�jour spacieux ,");
		array_push($T_sej, " Double s�jour avec balcon,");
		array_push($T_sej, " Double s�jour avec vue,");
		array_push($T_sej, " Double s�jour avec vue sur parc,");
		array_push($T_sej, " Double s�jour avec chemin�e,");
		array_push($T_sej, " Grand s�jour/salle � manger ,");
		array_push($T_sej, " Double s�jour lumineux ,");
		array_push($T_sej, " Salon , bureau,");
		array_push($T_sej, " Salon , dressing,");
		array_push($T_sej, " Salon spacieux , bureau,");
		array_push($T_sej, " Salon avec poutres sur rue, salle � manger s�par�e,");
	}
	$ind = mt_rand(0, count($T_sej) - 1);
	$sej = $T_sej[$ind];

	//-----------------------------------------------------------------------------------
	// Cuisine
	$T_cui = array();
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
	array_push($T_cui, " cuisine �quip�e,");
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
	array_push($T_cui, " cuisine s�par�e am�nag�e,");
	array_push($T_cui, " cuisine am�nag�e �quip�e,");
	array_push($T_cui, " cuisine meubl�e,");
	array_push($T_cui, " cuisine US,");
	array_push($T_cui, " cuisine int�gr�e,");
	array_push($T_cui, " cuisine ouverte,");
	$ind = mt_rand(0, count($T_cui) - 1);
	$cui = $T_cui[$ind];

	//-----------------------------------------------------------------------------------
	// Chambres
	$T_cha = array();
	if ($nbc > 1) {
		array_push($T_cha, " $nbc chambres,");
		array_push($T_cha, " $nbc chambres avec une grande,");
		array_push($T_cha, " $nbc chambres dont une grande,");
		array_push($T_cha, " $nbc chambres avec placards, balcon,");
		array_push($T_cha, " $nbc chambres, rangements, balcon,");
		array_push($T_cha, " $nbc chambres, grandes fen�tres, balcon,");
		array_push($T_cha, " $nbc chambres, grandes fen�tres, balcon, vue d�gag�e,");
		array_push($T_cha, " $nbc chambres claires, grandes fen�tres,");
		array_push($T_cha, " $nbc chambres tr�s lumineuses, grandes fen�tres,");
		array_push($T_cha, " $nbc chambres, vue panoramique,");
	} else {
		array_push($T_cha, " chambre,");
		array_push($T_cha, " grande chambre,");
		array_push($T_cha, " chambre avec placards et balcon,");
		array_push($T_cha, " chambre avec rangements et balcon,");
		array_push($T_cha, " chambre, grande fen�tre, balcon,");
		array_push($T_cha, " chambre, balcon, grande fen�tre, vue d�gag�e,");
		array_push($T_cha, " chambre tr�s claire,");
		array_push($T_cha, " chambre tr�s lumineuse,");
		array_push($T_cha, " chambre, vue panoramique,");
		array_push($T_cha, " chambre au sud,");
	}
	$ind = mt_rand(0, count($T_cha) - 1);
	$cha = $T_cha[$ind];

	//-----------------------------------------------------------------------------------
	// Salle de bains / salle d'eau / WC
	$T_sdb = array();

	if ($nbp <= 3) {
		array_push($T_sdb, " salle de bains avec wc,");
		array_push($T_sdb, " salle de bains et wc s�par�s,");
		array_push($T_sdb, " salle de bains , wc,");
		array_push($T_sdb, " salle de bains , wc s�par�s,");
		array_push($T_sdb, " salle de bains , WC s�par�s,");
		array_push($T_sdb, " salle de bains baln�o , WC s�par�s,");
		array_push($T_sdb, " salle de bains et wc ind�pendants,");
		array_push($T_sdb, " salle de bains avec baignoire, WC separes,");
		array_push($T_sdb, " salle de bains baignoire / douche, wc,");
		array_push($T_sdb, " salle de bains baignoire / douche, wc sep,");
		array_push($T_sdb, " sdb baignoire wc,");
		array_push($T_sdb, " sdb baignoire , wc,");
		array_push($T_sdb, " SDB baignoire WC,");
		array_push($T_sdb, " SDB baignoire , WC,");
		array_push($T_sdb, " sdb, wc,");
		array_push($T_sdb, " sdb-wc,");
		array_push($T_sdb, " salle d'eau, wc s�par�s,");
		array_push($T_sdb, " douche wc,");
		array_push($T_sdb, " douche , wc s�par�s,");
		array_push($T_sdb, " douche WC,");
		array_push($T_sdb, " douche , WC s�par�s,");
	} else {
		array_push($T_sdb, " salle de bains avec wc,");
		array_push($T_sdb, " salle de bains et wc s�par�s,");
		array_push($T_sdb, " salle de bains , wc,");
		array_push($T_sdb, " salle de bains , wc s�par�s,");
		array_push($T_sdb, " salle de bains , WC s�par�s,");
		array_push($T_sdb, " salle de bains et wc ind�pendants,");
		array_push($T_sdb, " salle de bains avec baignoire, WC separes,");
		array_push($T_sdb, " salle de bains baln�o , WC s�par�s,");
		array_push($T_sdb, " salle de bains baignoire / douche, wc,");
		array_push($T_sdb, " salle de bains baignoire / douche, wc sep,");
		array_push($T_sdb, " sdb baignoire wc,");
		array_push($T_sdb, " sdb baignoire , wc,");
		array_push($T_sdb, " SDB baignoire WC,");
		array_push($T_sdb, " SDB baignoire , WC,");
		array_push($T_sdb, " sdb, wc,");
		array_push($T_sdb, " sdb-wc,");
		array_push($T_sdb, " salle de bains douche wc,");
		array_push($T_sdb, " salle de bains, douche , wc s�par�s,");
		array_push($T_sdb, " salle de bains, douche WC,");
		array_push($T_sdb, " salle de bains, douche , WC s�par�s,");
		array_push($T_sdb, " salle de bains, salle d'eau wc,");
		array_push($T_sdb, " salle de bains, salle d'eau , wc s�par�s,");
		array_push($T_sdb, " salle de bains, salle d'eau WC,");
		array_push($T_sdb, " salle de bains, salle d'eau , WC s�par�s,");
	}

	$ind = mt_rand(0, count($T_sdb) - 1);
	$sdb = $T_sdb[$ind];

	$str_piece = ${sej} . ${cui} . ${cha} . ${sdb};
	$str_piece = substr($str_piece, 0, -1) . ".";

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
	array_push($T_par, " Garage, parking.");
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
	array_push($T_rad, " Chauffage individuel fuel.");
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
	array_push($T_div, " Beaux volumes.");
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


	$str_commodite = make_commodite();

	$T_blabla = array();
	array_push($T_blabla, $str_appart . $str_piece . $rad . $par . $str_commodite . $div);
	array_push($T_blabla, $str_appart . $str_piece . $par . $rad . $str_commodite . $div);
	array_push($T_blabla, $str_appart . $str_piece . $par . $str_commodite . $rad . $div);
	array_push($T_blabla, $str_appart . $str_piece . $str_commodite . $par . $rad . $div);
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
	$nbpi     = $nbp;
	$blabla_s = mysqli_real_escape_string($blabla);

	$insert = "INSERT INTO ano (tel_ins,password,email,ok_email,
	                            tel_bis,etat,dat_ins,dat_fin,
															zone,zone_pays,zone_region,zone_dept,zone_ville,zone_ard,num_dept,
	                            typp,nbpi,surf,prix,blabla) 
	            VALUES ('$tel_ins','$password','$email','$ok_email',
	                    '$tel_bis','$typa','$etat',now(),'$dat_fin',
											'$zone','$zone_pays','$zone_region_s','$zone_dept_s','$zone_ville_s','$zone_ard','$num_dept',
	                    '$typp','$nbpi','$surf','$prix','$blabla_s')";
	//echo "$insert<br/>";
	dtb_query($insert, __FILE__, __LINE__, 1);
}
