<?PHP
session_start();
if (!isset($_SESSION['tel_ins'])) exit;

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_conf.php");
include("../include/inc_filter.php");
include("../include/inc_tools.php");
include("../include/inc_random.php");
include("../include/inc_upload.php");
include("../include/inc_nav.php");
include("../include/inc_ariane.php");
include("../include/inc_tracking.php");
include("../include/inc_cibleclick.php");


set_time_limit(240);

if (!filtrer_les_entrees_get(__FILE__, __LINE__)) die;
if (!filtrer_les_entrees_post(__FILE__, __LINE__)) die;
dtb_connection();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Gestion des Photos</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-compte-annonce.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src='/jvscript/upload.js'></script>
</head>

<body>
	<div id='toolspan'><?PHP print_tools('tools'); ?></div>
	<div id='mainpan'>
		<div id='header'><img src="/images-pub/header-message-1.jpg" alt="TOP-IMMOBILIER-PARTICULIER.FR c'est le top de l'immobilier entre particuliers" /></div>
		<div id='userpan'>
			<div id='upload'>
				<?PHP
				if (data_en_session_ok()) {
					make_ariane_upload($_SESSION['zone']);
					tracking_session_annonce(CODE_CTA, 'OK', "Entr�e dans Gerer les Photos", __FILE__, __LINE__);

				?>

					<p>&nbsp;</p>
					<!-- Formulaire de gestion des photos -->
					<table id='gesph' width="600" border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#336699">
						<tr>
							<td>
								<p class="text12g"><img src="/images/hand.gif" align="absmiddle">&nbsp;&nbsp;<font color="#336699">T�l�charger les photos</font>
								</p>
								<p class="text12g">
									<font color="#336699"></font> ( 5 photos de 4 M&eacute;ga octets maximum )
								</p>
								<p class="text12g">Conseils</p>
								<ul>
									<li>Mettre la photo num�ro 1 au format paysage.</li>
									<li>Mettre un plan.</li>
									<li>Mettre des photos de l'environnement ( rue, fa&ccedil;ade, vue sur l'ext&eacute;rieur ).</li>
									<li>Si possible, choisir un jour clair et lumineux.</li>
									<li>Si possible, faire les photos de votre int&eacute;rieur avec un grand angle.</li>
									<li>A l'int&eacute;rieur, penser &agrave; ouvrir toutes les fen&ecirc;tres et &agrave; allumer les lumi&egrave;res.</li>
								</ul>
							</td>
						</tr>
						<tr>
							<td>
								<!-- Formulaire d'upload des photos -->
								<form name="photo" action="<?PHP echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" onSubmit="return validation();">
									<table id="upload" width="550" border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#336699">
										<tr>
											<td>
												<p class="action_user">(1) -&gt; Parcourir votre disque dur pour s&eacute;lectionner la photo</p>
												<p>
													<input type="hidden" name="upload" value="1">
													<input type="hidden" name="maxval" value="<?PHP echo WEIGTH_MAX ?>">
													<input name="photo1" type="file" class="text11" size="65">
												</p>
											</td>
										</tr>
										<tr>
											<td class="action_user">(2) -&gt; Envoyer la photo vers le site<img src="../images/spacer.gif" width="40" height="8" border=0>
												<input class="but_input" type="submit" name="Submit" value="Envoyer">
											</td>
										</tr>
									</table>
								</form>
								<?PHP

								dtb_connection(__FILE__, __LINE__);

								// Si il n'y a pas de num�ro de 'session photo', qui est en fait un pr�fixe.
								if (!isset($_SESSION['my_session'])) creation_prefixe();

								if (isset($_POST['upload'])) upload_photo();

								// Si supprimer
								if (isset($_GET['Sub_Supp'])) supprimer();

								$nbp = aff_thumb();

								?>
							</td>
						</tr>
					</table>
					<p>&nbsp;</p>
					<form name="suite" action="fiche.php" method="get">
						<table id='saveph' width="600" border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#336699">
							<tr>
								<td class="action_user"> (3) -&gt; Gestion des photos termin&eacute;e<img src="../images/spacer.gif" width="40" height="8" border=0>
									<input class="but_input" type="submit" name="Submit" value="Enregistrer">
								</td>
							</tr>
						</table>
					</form>

					<p>&nbsp;</p>
					<?PHP if ($nbp == 0) print_cible_unifinance_300_250(); ?>
					<p>&nbsp;</p>
				<?PHP
				} else print_if_no_data();
				?>
			</div><!-- end upload -->
		</div><!-- end userpan -->
	</div><!-- end mainpan -->
	<div id='footerpan'></div>
</body>

</html>