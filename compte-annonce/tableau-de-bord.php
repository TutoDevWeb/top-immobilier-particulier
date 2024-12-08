<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) die;
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_nav.php");
include("../include/inc_tracking.php");
include("../include/inc_conf.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_fiche.php");
include("../include/inc_photo.php");
include("../include/inc_format.php");
include("../include/inc_cibleclick.php");

$connexion = dtb_connection();

filtrer_les_entrees_post(__FILE__, __LINE__);

if (isset($_POST['action']) && $_POST['action'] == 'store_session') {
	store_session();
	gotoo("fiche.php");
	//print_r($_SESSION);
	die;
}

$tel_ins = $_SESSION['tel_ins'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Tableau de bord de gestion de votre annonce</title>
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache, must-revalidate" />
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-compte-annonce.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-ph.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src="/compte-annonce/jvscript/valid_field.js"></script>
	<script type='text/javascript' src="/jvscript/photo.js"></script>
	<script type='text/javascript' src="/jvscript/popup.js"></script>
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<table id='annonce'>
				<tr>
					<td class='cell_b'><?PHP print_cibleclick_120_600();  ?></td>
					<td class='cell_c'>
						<?PHP

						/*
          print_r($_SESSION);
          echo "<p>&nbsp;</p>\n";
          echo "<p>&nbsp;</p>\n";
					*/

						if (is_modif()) {

							if (is_connexion_admin()) echo "<p class=text12cg>CONNEXION ADMIN</p>";
							restore_session();
							tracking_session_annonce($connexion, CODE_CTA, 'OK', "Appel Formulaire Modification", __FILE__, __LINE__);
						} else {

							print_deconnexion();

							// Lire l'�tat dans la base
							$etat = get_etat($connexion, $tel_ins, __FILE__, __LINE__);

							if (is_connexion_admin()) {
								echo "<p class=text12cg>CONNEXION ADMIN</p>";
								echo "<p class=text12cg>ETAT : $etat</p>";
							}

							if ($etat == 'attente_paiement') print_attente_paiement($connexion, $tel_ins, $etat);
							else if ($etat == 'attente_validation') print_attente_validation($connexion, $tel_ins, $etat);
							else if ($etat == 'ligne') print_ligne($connexion, $tel_ins);
						}

						?>
					</td>
					<td class='cell_b'><?PHP print_cibleclick_120_600();  ?></td>
				</tr>
			</table>
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>
<?PHP
//----------------------------------------------------------------------------------------------------------
function print_attente_paiement($connexion, $tel_ins, $etat) {

	print_info_attente_paiement($tel_ins);

	tracking_session_annonce($connexion, CODE_CTA, 'OK', "Accès tableau de bord : attente_paiement", __FILE__, __LINE__);
}
//----------------------------------------------------------------------------------------------------------
function print_attente_validation($connexion, $tel_ins, $etat) {

	echo "<div class='make'><p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Nous allons remettre votre annonce en ligne dans les meilleurs délais</p></div>";
	if (is_connexion_admin()) {
		echo "<p class=text12cg>CONNEXION ADMIN</p>";
		echo "<p class=text12cg>ETAT : $etat</p>";
		print_modifier();
	}

	print_dtb_fiche($tel_ins);
	$photo = get_photo_from_dir($_SESSION['ida']);
	print_galerie_photo($photo);

	tracking_session_annonce($connexion, CODE_CTA, 'OK', "Accès tableau de bord : attente_validation", __FILE__, __LINE__);
}
//----------------------------------------------------------------------------------------------------------
function print_ligne($connexion, $tel_ins) {

	$url_short_site = URL_SHORT_SITE;
	$ctnblog = get_cntblog($connexion, $tel_ins);
	$dat_fin = to_full_dat(get_dat_fin($connexion, $tel_ins));
	print_modifier_supprimer();
	echo "<p>Votre annonce est en ligne jusqu'au $dat_fin</p>\n";
	if ($ctnblog !== false) echo "<p>Vous avez eu $ctnblog visites sur votre blog suite à des clicks sur $url_short_site</p>";
	print_dtb_fiche($tel_ins);
	$photo = get_photo_from_dir($_SESSION['ida']);
	print_galerie_photo($photo);
	tracking_session_annonce($connexion, CODE_CTA, 'OK', "Accès tableau de bord : annonce en ligne", __FILE__, __LINE__);
}
//------------------------------------------------------------------------
function print_modifier_supprimer() {
	echo "<div class='make'>";
	echo "<p><img src='/images/hp3.gif' align='absmiddle' />&nbsp;&nbsp;&nbsp;Vous pouvez modifier ou supprimer votre annonce</p>";
	echo "<p><a href='modifier.php' title='Modifier votre Annonce'><img src='/images/btn_modifier.gif' alt='Modifier votre Annonce' /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:confirm_delete('supprimer.php','votre annonce');\" title='Supprimer votre Annonce'><img src='/images/btn_supprimer.gif' alt='Supprimer votre Annonce' /></a></p>\n";
	echo "</div>";
}
//----------------------------------------------------------------------------------------------------------
function store_session() {

	$_SESSION['ard']      = $_POST['ard'];
	$_SESSION['quart']    = trim($_POST['quart']);
	$_SESSION['typp']     = $_POST['typp'];
	$_SESSION['nbpi']     = $_POST['nbpi'];
	$_SESSION['surf']     = $_POST['surf'];
	$_SESSION['prix']     = $_POST['prix'];

	$_SESSION['blabla']   = trim(filtre_non_imprimable($_POST['blabla']));

	if ($_POST['tel_bis'] != "") $_SESSION['tel_bis']  = $_POST['tel_bis'];
	else $_SESSION['tel_bis'] = '0000000000';
}
//----------------------------------------------------------------------------------------------------------
function restore_session() {

	echo "<script language='JavaScript'>\n";
	echo "with (document.ano) {\n";

	if (isset($_SESSION['ard']))  printf("ard.selectedIndex=%d;\n", $_SESSION['ard'] - 1);
	if (isset($_SESSION['quart']))  printf("quart.value='%s';\n", addslashes($_SESSION['quart']));
	if (isset($_SESSION['typp']))  printf("typp.selectedIndex=%d;\n", $_SESSION['typp'] - 1);
	if (isset($_SESSION['nbpi']))  printf("nbpi.value=%d;\n", $_SESSION['nbpi']);
	if (isset($_SESSION['surf']))  printf("surf.value=%d;\n", $_SESSION['surf']);
	if (isset($_SESSION['prix']))  printf("prix.value=%d;\n", $_SESSION['prix']);

	if (isset($_SESSION['blabla']))  printf("blabla.value='%s';\n", addslashes($_SESSION['blabla']));
	if (isset($_SESSION['tel_bis']) && $_SESSION['tel_bis'] != '0000000000')  printf("tel_bis.value='%s';\n", $_SESSION['tel_bis']);

	echo ";}\n";
	echo  "</script>\n";
}
?>