<?PHP
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_flux_ano.php");
include("../include/inc_ariane.php");

dtb_connection();
$url_short_site = URL_SHORT_SITE;
define('DEBUG_FLUX_ANNONCE', 0);

?>
<html>

<head>
	<title>Make Flux Annonce</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<?PHP


	generer_le_flux();

	//------------------------------------------------------------------------------------------------
	function generer_le_flux() {

		$xml  = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
		$xml .= '<rss version="2.0">';
		$xml .= '<channel>';
		$xml .= '<title>' . SITE_NAME_FR . '</title>';
		$xml .= '<link>' . URL_SITE . '</link>';
		$xml .= "<description>Flux des derni�res annonces immobili�res</description>";
		$xml .= '<image>';
		$xml .= '<url>' . URL_SITE . 'images/top-immobilier-particuliers-240x60.jpg</url>';
		$xml .= '<title>Annonces Immobili�res</title>';
		$xml .= '<link>' . URL_SITE . 'annonces-immobilieres/</link>';
		$xml .= '</image>';


		$query  = "SELECT tel_ins,DATE_FORMAT(dat_ins,'%d-%m-%Y'),UNIX_TIMESTAMP(dat_ins),zone_ville,zone_ard,typp,nbpi,surf,prix,blabla FROM ano WHERE etat='ligne' ORDER BY dat_ins DESC LIMIT 15";
		$result = dtb_query($query, __FILE__, __LINE__, 0);

		while (list($tel_ins, $dat_ano, $dat_unix, $zone_ville, $zone_ard, $typp, $nbpi, $surf, $prix, $blabla) = mysqli_fetch_row($result)) {

			$titre = get_titre($zone_vile, $zone_ard, $typp, $nbpi, $surf, $prix);

			$description = "( " . $dat_ano . " ) " . substr($blabla, 0, 140) . "...";
			$flux_pub_date = date("r", $dat_unix);

			$xml .= '<item>';
			$xml .= '<title>' . $titre . '</title>';
			$xml .= '<link>' . URL_SITE . 'annonce-' . $tel_ins . '.htm</link>';
			$xml .= "<guid isPermaLink='false'>annonce-" . $tel_ins . "</guid>";
			$xml .= '<description>' . $description . '</description>';
			$xml .= '<pubDate>' . $flux_pub_date . '</pubDate>';
			$xml .= '</item>';
		}

		$xml .= '</channel>';
		$xml .= '</rss>';

		// �criture dans le fichier
		if (($fp = fopen("xml-flux-annonces.xml", 'w+')) !== false) {
			fputs($fp, $xml);
			fclose($fp);
		} else echo "<p>Echec cr�ation du flux</p>";
	}
	?>

</body>

</html>