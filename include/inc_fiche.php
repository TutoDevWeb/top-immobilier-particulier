<?PHP
// -------------------------------------------------------------------------------------------     
// Fonctions utilisées pour l'affichage de la fiche à partir des données de la database
// -------------------------------------------------------------------------------------------     
function print_dtb_fiche($connexion, $tel_ins) {

	$data  = get_data_from_dtb($connexion, $tel_ins);

	print_fiche($data);
}
//--------------------------------------------------------------------------------------------
function get_data_from_dtb($connexion, $tel_ins) {

	$query = "SELECT zone,zone_pays,zone_dept,zone_ville,zone_ard,zone_dom,ok_email,prix,typp,nbpi,surf,tel_bis,blabla,quart,tel_ins,wwwblog FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_FICHE);
	$data  = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$data["typp"] = typp_from_dtb_to_num($data["typp"]);

	return $data;
}
// -------------------------------------------------------------------------------------------     
// Fonctions utilisées pour l'affichage de la fiche à partir des données de session
// -------------------------------------------------------------------------------------------     
function print_session_fiche() {

	$data = get_data_from_session();

	print_fiche($data);
}
// -------------------------------------------------------------------------------------------     
function get_data_from_session() {

	$data = array(
		"zone"        => $_SESSION['zone'] ?? '',
		"zone_pays"   => $_SESSION['zone_pays'] ?? '',
		"zone_region" => $_SESSION['zone_region'] ?? '',
		"zone_dept"   => $_SESSION['zone_dept'] ?? '',
		"zone_ville"  => $_SESSION['zone_ville'] ?? '',
		"zone_ard"    => $_SESSION['zone_ard'] ?? '',
		"zone_dom"    => $_SESSION['zone_dom'] ?? '',
		"num_dept"    => $_SESSION['num_dept'] ?? '',
		"ok_email"    => $_SESSION['ok_email'] ?? '',
		"prix"        => $_SESSION['prix'] ?? '',
		"typp"        => $_SESSION['typp'] ?? '',
		"nbpi"        => $_SESSION['nbpi'] ?? '',
		"surf"        => $_SESSION['surf'] ?? '',
		"tel_ins"     => $_SESSION['tel_ins'] ?? '',
		"tel_bis"     => $_SESSION['tel_bis'] ?? '',
		"wwwblog"     => $_SESSION['wwwblog'] ?? '',
		"blabla"      => $_SESSION['blabla'] ?? '',
		"quart"       => $_SESSION['quart'] ?? ''
	);

	return $data;
}
// -------------------------------------------------------------------------------------------     
// Fonctions utilisées pour l'affichage de la fiche à partir des données du tableau data
// -------------------------------------------------------------------------------------------     
function print_fiche($data) {

	$zone       = $data['zone'];
	$zone_pays  = $data['zone_pays'];
	$zone_dept  = $data['zone_dept'];
	$zone_ville = $data['zone_ville'];
	$zone_ard_str  = format_ard($data['zone_ard']);
	$zone_dom   = $data['zone_dom'];

	$ok_email   = $data['ok_email'];
	$prix_str   = format_prix($data['prix']);
	$typp_str   = typp_from_num_to_str($data['typp']);

	$nbpi     = $data['nbpi'];
	$surf     = $data['surf'];
	$tel_ins  = $data['tel_ins'];
	$tel_bis  = $data['tel_bis'];
	$blabla   = $data['blabla'];
	$quart    = $data['quart'];

	$wwwblog  = $data['wwwblog'];

?>
	<div id='zone_fiche'>
		<table>
			<tr>
				<td class='textlwb'>
					<?PHP
					if ($zone == 'france') echo "$zone_ville ( $zone_dept )";
					if ($zone == 'domtom') echo "$zone_ville ( $zone_dom )";
					if ($zone == 'etranger') echo "$zone_pays - $zone_ville";
					?>
				</td>
				<td class='textrwb'><?PHP echo "$prix_str"; ?> �</td>
			</tr>
			<tr>
				<td colspan='2' class='textlwb'>
					<?PHP
					if ($data['zone_ard'] == 0) echo "$quart";
					else  echo "$zone_ard_str- $quart";
					?>
				</td>
			</tr>
			<tr>
				<td colspan='2' class='textlwb'><?PHP echo "$typp_str de $nbpi Pi�ces de $surf m� environ" ?></td>
			</tr>
		</table>
		<br />
		<table id='blabla'>
			<tr>
				<td class='textj'>
					<?PHP echo $blabla  ?>
				</td>
			</tr>
		</table>
		<br />
		<table>
			<?PHP
			if ($ok_email) {
				echo "<tr>\n";
				echo "<td colspan='2' class='textwb'>Vous serez contact� par mail&nbsp;&nbsp;<img src='/images/email_ano.jpg' width='26' height='17' hspace='40' align='absmiddle' border='0' /></td>\n";
				echo "</tr>\n";
			}
			?>
			<tr>
				<td class='textwb'>T�l�phone</td>
				<td class='textwb'>
					<?PHP
					$tel_ins_str = format_telephone($tel_ins);
					echo "$tel_ins_str";
					if ($tel_bis != '0000000000') {
						$tel_bis_str = format_telephone($tel_bis);
						echo "<br/>$tel_bis_str";
					}
					?>
				</td>
			</tr>
			<?PHP
			if ($wwwblog != '') {
				echo "<tr>\n";
				echo "<td colspan='2' class='textwb'>Plus d'infos sur ce blog&nbsp;&nbsp;<a class='textwb' href='/compte-annonce/goto.php?tel_ins=$tel_ins&wwwblog=$wwwblog' target='_blank'>$wwwblog</a></td>\n";
				echo "</tr>\n";
			}
			?>
		</table>
	</div>
<?PHP
}
// -------------------------------------------------------------------------------------------     
// Cette fonction est utilisée dans le cas d'une modification d'une annonce qui existe déjà
// Elle permet de recharger les variables de Session sur lesquelles on travaille pendant la
// création de l'annonce.
function restore_from_base($connexion, $tel_ins) {

	dtb_connection(__FILE__, __LINE__);

	$query = "SELECT zone,zone_pays,zone_region,zone_dept,zone_ville,zone_ard,zone_dom,num_dept,email,ok_email,quart,typp,nbpi,surf,prix,blabla,tel_bis,maps_lat,maps_lng,maps_actif,wwwblog,cntblog
            FROM ano WHERE tel_ins='$tel_ins'";
	$result = dtb_query($connexion, $query, __FILE__, __LINE__, DEBUG_MODIFIER);
	list($zone, $zone_pays, $zone_region, $zone_dept, $zone_ville, $zone_ard, $zone_dom, $num_dept, $email, $ok_email, $quart, $typp, $nbpi, $surf, $prix, $blabla, $tel_bis, $maps_lat, $maps_lng, $maps_actif, $wwwblog, $cntblog) = mysqli_fetch_row($result);

	$_SESSION['zone']        = $zone;
	$_SESSION['zone_pays']   = $zone_pays;
	$_SESSION['zone_region'] = $zone_region;
	$_SESSION['zone_dept']   = $zone_dept;
	$_SESSION['zone_ville']  = $zone_ville;
	$_SESSION['zone_ard']    = $zone_ard;
	$_SESSION['zone_dom']    = $zone_dom;
	$_SESSION['num_dept']    = $num_dept;

	$_SESSION['sagmail']    = $email;
	$_SESSION['ok_email']   = $ok_email;
	$_SESSION['quart']      = $quart;
	$_SESSION['typp']       = typp_from_dtb_to_num($typp);
	$_SESSION['nbpi']       = $nbpi;
	$_SESSION['surf']       = $surf;
	$_SESSION['prix']       = $prix;
	$_SESSION['blabla']     = $blabla;
	$_SESSION['tel_bis']    = $tel_bis;

	$_SESSION['maps_lat']   = $maps_lat;
	$_SESSION['maps_lng']   = $maps_lng;
	$_SESSION['maps_actif'] = $maps_actif;

	$_SESSION['wwwblog'] = $wwwblog;
	$_SESSION['cntblog'] = $cntblog;
}
?>