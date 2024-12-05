<?PHP
include("../include/inc_conf.php");
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_format.php");
include("../include/inc_fiche.php");
include("../include/inc_dtb_compte_annonce.php");
include("../include/inc_photo.php");

isset($_GET['tel_ins']) ? $tel_ins = $_GET['tel_ins'] : die;

dtb_connection(__FILE__, __LINE__);

// Requ�te pour la carte
$query  = "SELECT maps_lat,maps_lng,maps_actif,maps_scale,quart FROM ano WHERE tel_ins='$tel_ins'";
$result = dtb_query($query, __FILE__, __LINE__, 1);
if (mysqli_num_rows($result)) list($maps_lat, $maps_lng, $maps_actif, $maps_scale, $quart) = mysqli_fetch_row($result);
else {
	echo "<p>L'annonce n'existe pas : $tel_ins</p>";
	die;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<title>Voir Annonce</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="/styles/styles.css" rel="stylesheet" type="text/css">
	<link href="/styles/lib-ph.css" rel="stylesheet" type="text/css">
	<STYLE type="text/css">
		<!--
		body {
			background-color: #FFFFFF;
		}

		div#map {
			width: 355px;
			height: 355px;
			margin: 10px auto;
			border: 1px solid black;
		}
		-->
	</STYLE>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtggiWJMus6LWKUua04wt_RTMWPxCPq5RvY5_kHvjtn_Nx0AqdhQ133zHk-88S4-qNVRbymA2lk417A" type="text/javascript"></script>
	<script language="JavaScript" src="/jvscript/photo.js"></script>
	<script type="text/javascript">
		var map;
		var maps_lat = parseFloat(<?PHP echo "$maps_lat"; ?>);
		var maps_lng = parseFloat(<?PHP echo "$maps_lng"; ?>);
		var maps_actif = parseInt(<?PHP echo "$maps_actif"; ?>);
		var maps_scale = parseInt(<?PHP echo "$maps_scale"; ?>);
		var quart = "<?PHP echo "$quart"; ?>";

		//------------------------------------------------------------------------------------------------
		function load_map() {
			if (GBrowserIsCompatible() && maps_actif) {
				map = new GMap2(document.getElementById("map"));
				var point = new GLatLng(maps_lat, maps_lng);
				map.setCenter(point, maps_scale);
				map.addControl(new GSmallMapControl());
				var marker = new GMarker(point);
				map.addOverlay(marker);
				if (quart != '') {
					GEvent.addListener(marker, "click", function() {
						var myHtml = "<div style='text-align: center;'><br/>" + quart + "</div>";
						map.openInfoWindowHtml(point, myHtml);
					});
				}
			}
		}

		// Demande une confirmation avant de supprimer un site ou une categorie
		function confirm_delete(page, texte) {
			confirmation = confirm('Etes vous sur de vouloir supprimer ' + texte + ' ? ');
			if (confirmation)
				window.location.replace(page);
		}
	</script>
</head>

<body onload="load_map();  displayPics();" onunload="GUnload()">
	<table width=600 border=1 align=center cellpadding=10 cellspacing=0 bordercolor="336633" id=cadre>
		<tr>
			<td>
				<p>&nbsp;</p>
				<?PHP

				//$action = &new action();


				$zone = get_zone($tel_ins, __FILE__, __LINE__);

				echo "<p><strong>zone => $zone</strong></p>";

				// R�cup�rer l'�tat de l'annonce pour afficher les actions possibles
				$etat = get_etat($tel_ins, __FILE__, __LINE__);

				// R�cup�rer l'ida de l'annonce pour les photos
				$ida     = get_ida($tel_ins, __FILE__, __LINE__);

				print_dtb_fiche($tel_ins);
				$photo = get_photo_from_dir($ida);
				print_galerie_photo($photo);

				echo "<p><strong>etat annonce => $etat</strong></p>";

				if ($etat == 'attente_paiement') {

					$dat_mod = get_date_modification($tel_ins, __FILE__, __LINE__);
					echo "<p><strong>date debut derni�re modif => $dat_mod</strong></p>";

					$action->go_ligne_sur_paiement($tel_ins);
					$action->mailer($tel_ins);
					$action->editer($tel_ins);
					$action->lowercase($tel_ins);
					$action->ano_sup($tel_ins);
				} else if ($etat == 'attente_validation') {

					$action->go_ligne_sur_validation($tel_ins);
					$action->mailer($tel_ins);
					$action->editer($tel_ins);
					$action->go_ligne_silent($tel_ins);
					$action->lowercase($tel_ins);
					$action->ano_sup($tel_ins);
				}

				if ($maps_actif == 1) echo "<div id='map'></div>";


				class action {

					//------------------------------------------------------------------------------------------
					function editer($tel_ins) {

						$password = get_password($tel_ins, __FILE__, __LINE__);
						echo "<a href='/compte-annonce/gestion-connexion-annonce.php?action=demande_connexion&compte_tel_ins=$tel_ins&compte_pass=$password&user=adminsag' target='_blank'>Editer</a><br/>\n";
					}
					//------------------------------------------------------------------------------------------
					function lowercase($tel_ins) {
						echo "<a href='adm-compte-annonce-action.php?action=lowercase&tel_ins=$tel_ins'>Mettre en Minuscules</a><br/>\n";
					}
					//------------------------------------------------------------------------------------------
					function mailer($tel_ins) {
						echo "<a href='adm-compte-annonce-action.php?action=print_send_mail_info_form&tel_ins=$tel_ins'>Mailer</a><br/>\n";
					}
					//------------------------------------------------------------------------------------------
					function ano_sup($tel_ins) {
						echo "<a href=\"javascript:confirm_delete('adm-compte-annonce-action.php?action=make_ano_sup&tel_ins=$tel_ins','cette annonce')\">Supprimer</a><br/>\n";
					}
					//------------------------------------------------------------------------------------------
					function go_ligne_sur_paiement($tel_ins) {
						echo "<a href='adm-compte-annonce-action.php?action=go_ligne_sur_paiement&tel_ins=$tel_ins'>Mettre l'annonce en ligne sur un paiement</a><br/>";
					}
					//------------------------------------------------------------------------------------------
					function go_ligne_sur_validation($tel_ins) {
						echo "<a href='adm-compte-annonce-action.php?action=go_ligne_sur_validation&tel_ins=$tel_ins'>Valider l'annonce suite � modification</a><br/>";
					}
					//------------------------------------------------------------------------------------------
					function go_ligne_silent($tel_ins) {
						echo "<a href='adm-compte-annonce-action.php?action=go_ligne_silent&tel_ins=$tel_ins'>Valider l'annonce et la mettre ligne sans envoyer de mail</a><br/>";
					}
				}
				?>

				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>

</html>