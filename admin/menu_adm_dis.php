<?PHP
include("../include/inc_conf.php");
include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_count_cnx.php");
$connexion = dtb_connection();
?>
<HTML>

<HEAD>
	<meta http-equiv=Content-Type content="text/html;  charset=ISO-8859-1">
	<TITLE>menu_adm_dis</TITLE>
	<link href="/styles/styles.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		<!--
		.titre {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			font-weight: bold;
			color: #CC3300;
		}

		.machine {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 10px;
			font-weight: bold;
			text-decoration: underline;
		}
		-->
	</style>
</HEAD>

<BODY>
	<table width="160" border="1" cellpadding="3" cellspacing="0">
		<tr>
			<td class="machine">
				<?PHP
				$url_site = URL_SITE;
				$url_short_site = URL_SHORT_SITE;
				echo "<a href='$url_site' target='_blank'>$url_short_site</a>";

				?>
			</td>
		</tr>
		<tr>
			<td class="titre">Monitoring</td>
		</tr>
		<tr>
			<td><?PHP print_cnx(count_cnx($connexion)); ?></td>
		</tr>
		<tr>
			<td><?PHP print_virtual_cnx(count_cnx($connexion)); ?></td>
		</tr>
		<tr>
			<td><a href="tracking.php?action=examiner&cmd=print_form&nbj=1&code=TOUT" target="exe">Examiner tracking</a></td>
		</tr>
		<tr>
			<td><a href="tracking.php?action=purger&cmd=print_form" target="exe">Purger tracking</a></td>
		</tr>
		<tr>
			<td><a href="check_tab_ano.php" target="exe">Check Database</a></td>
		</tr>
		<tr>
			<td class="titre">Statistiques</td>
		</tr>
		<tr>
			<td><a href="stat.php" target="exe">Statistiques</a></td>
		</tr>
		<tr>
			<td><a href="stat_referencement.php" target="exe">Statistiques R&eacute;f&eacute;rencement</a></td>
		</tr>
		<tr>
			<td class="titre">Monitoring Annonces</td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-monitoring.php" target="exe">Annonces</a></td>
		</tr>
		<tr>
			<td class="titre">Action Annonce</td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=print_ano_sup_form" target="exe">Supprimer</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=print_get_admin_link_form" target="exe">Editer</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=print_ano_voir_form" target="exe">Voir</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=print_lock_ano_voir_form" target="exe">Voir Blocage</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=print_change_mail_form" target="exe">Changer Mail</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=print_change_tel_ins_form" target="exe">Changer tel_ins</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-annonce-action.php?action=make_flux_annonces" target="exe">Make Flux</a></td>
		</tr>
		<tr>
			<td class="titre">Action Compte</td>
		</tr>
		<tr>
			<td><a href="adm-compte-recherche-action.php?action=print_compte_recherche_sup_form" target="exe">Supprimer</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-recherche-action.php?action=print_get_admin_link_form" target="exe">Editer</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-recherche-action.php?action=print_statistiques" target="exe">Statistiques</a></td>
		</tr>
		<tr>
			<td><a href="adm-compte-recherche-action.php?action=voir_inactif" target="exe">Voir Inactif</a></td>
		</tr>
	</table>
</body>

</html>