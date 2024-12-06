<?PHP
//---------------------------------------------------------------------------------------------------
//
function store_session($connexion) {

	// Ici on va vérifier que tous les champs textuels n'exèdent pas une certaine longueur
	// Ces champs ne pourraient être injectés qu'avec un script d'injection fait pour saturer la base.
	foreach ($_POST as  $entry)
		if (est_trop_long($entry, 512)) die;

	$_SESSION['zone']       = $_POST['zone'];
	$_SESSION['zone_pays']  = trim($_POST['zone_pays']);
	$_SESSION['zone_ville'] = trim($_POST['zone_ville']);
	$_SESSION['zone_ard'] = (trim($_POST['zone_ard']) == '') ? 0 : (int)trim($_POST['zone_ard']);
	$_SESSION['zone_dom']   = trim($_POST['zone_dom']);
	$_SESSION['num_dept']   = trim($_POST['num_dept']);

	/* Si on est en France il faut retrouver le nom du département et celui de la region */
	if ($_SESSION['zone'] == 'france')
		get_dept_region_by_num_dept($connexion, $_SESSION['num_dept'], $_SESSION['zone_dept'], $_SESSION['zone_region']);

	/* Si on est dans les Dom Tom on traite la ville */
	if ($_SESSION['zone'] == 'domtom')
		$_SESSION['zone_ville'] = ucfirst(strtolower($_SESSION['zone_ville']));

	/* Si on est à l'étranger on traite le pays et la ville */
	if ($_SESSION['zone'] == 'etranger') {
		$_SESSION['zone_pays']  = ucfirst(strtolower($_SESSION['zone_pays']));
		$_SESSION['zone_ville'] = ucfirst(strtolower($_SESSION['zone_ville']));
	}

	$_SESSION['typp']       = $_POST['typp'];
	$_SESSION['nbpi']       = $_POST['nbpi'];
	$_SESSION['surf']       = trim($_POST['surf']);
	$_SESSION['prix']       = trim($_POST['prix']);

	$_SESSION['tel_ins']   = trim($_POST['tel_ins']);
	$_SESSION['sagmail']   = trim($_POST['sagmail']);
	$_SESSION['wwwblog']   = trim($_POST['wwwblog']);
	$_SESSION['ok_email']  = isset($_POST['ok_email']) ? 1 : 0;

	$_SESSION['blabla']  = trim(filtre_non_imprimable($_POST['blabla']));

	if ($_POST['tel_bis'] != "") $_SESSION['tel_bis']  = trim($_POST['tel_bis']);
	else                           $_SESSION['tel_bis']  = '0000000000';

	$_SESSION['condition']  = $_POST['condition'];
}
//---------------------------------------------------------------------------------------------------
//
function restore_session() {

	echo "<script type='text/javascript'>\n";
	echo "with (document.ano) {\n";

	// On doit repositioner les éléments caractérisant la zone
	if (isset($_SESSION['zone'])) {

		//-------------------------------------------------------------------------
		if ($_SESSION['zone'] == 'france') {
			printf("zone_pays.value='%s';\n", addslashes($_SESSION['zone_pays']));
		}
		//-------------------------------------------------------------------------
		if ($_SESSION['zone'] == 'domtom') {
			printf("zone_pays.value='%s';\n", addslashes($_SESSION['zone_pays']));
			printf("zone_ville.value='%s';\n", addslashes($_SESSION['zone_ville']));
			printf("zone_dom.selectedIndex=%d;\n", zone_dom_to_selectedIndex($_SESSION['zone_dom']));
		}
		//-------------------------------------------------------------------------
		if ($_SESSION['zone'] == 'etranger') {
			printf("zone_pays.value='%s';\n", addslashes($_SESSION['zone_pays']));
			printf("zone_ville.value='%s';\n", addslashes($_SESSION['zone_ville']));
		}
		//-------------------------------------------------------------------------

	}

	if (isset($_SESSION['typp']))    printf("typp.selectedIndex=%d;\n", typp_from_num_to_selectedIndex($_SESSION['typp'], $_SESSION['zone']));
	if (isset($_SESSION['nbpi']))    printf("nbpi.value=%d;\n", $_SESSION['nbpi']);
	if (isset($_SESSION['surf']))    printf("surf.value=%d;\n", $_SESSION['surf']);
	if (isset($_SESSION['prix']))    printf("prix.value=%d;\n", $_SESSION['prix']);

	if (isset($_SESSION['blabla']))    printf("blabla.value='%s';\n", addslashes($_SESSION['blabla']));
	if (isset($_SESSION['tel_bis']) && $_SESSION['tel_bis'] != '0000000000')  printf("tel_bis.value='%s';\n", $_SESSION['tel_bis']);

	if (isset($_SESSION['tel_ins']))    printf("tel_ins.value='%s';\n", $_SESSION['tel_ins']);
	if (isset($_SESSION['sagmail']))    printf("sagmail.value='%s';\n", $_SESSION['sagmail']);
	if (isset($_SESSION['wwwblog']))    printf("wwwblog.value='%s';\n", $_SESSION['wwwblog']);
	if (isset($_SESSION['ok_email']) && $_SESSION['ok_email'] == 1)   printf("ok_email.checked=true;\n");

	if (is_modif() || isset($_SESSION['condition'])) printf("condition.checked=true;\n");

	echo "}\n";
	echo  "</script>\n";
}
