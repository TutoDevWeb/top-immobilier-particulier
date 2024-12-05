<?PHP
include("../data/data.php");
include("../include/inc_base.php");

//if (!filtrer_les_entrees_get(__FILE__,__LINE__)) die;

dtb_connection();

isset($_GET['tel_ins']) ? $tel_ins = mysqli_real_escape_string($_GET['tel_ins']) : die;
isset($_GET['wwwblog']) ? $wwwblog = mysqli_real_escape_string($_GET['wwwblog']) : die;

// Lire le cookie blog
$cookie = isset($_COOKIE["blog"]) ? $_COOKIE["blog"] : '';

// R�cup�rer la liste des annonces d�j� vues
$already_seen_list = explode('#', $cookie);

// Le num�ro de t�l�phone est-il dans la liste des annonces consult�es stock�es dans le cookie
if (!in_array($tel_ins, $already_seen_list)) {

	// Si il n'y est pas il faut l'ajouter dans la liste
	setcookie('blog', $cookie . $tel_ins . '#', time() + 300, "/");

	// Il faut compter le hit
	$query = "UPDATE ano SET cntblog=cntblog+1 WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($query, __FILE__, __LINE__, 0);
}

$url_wwwblog = "http://" . $wwwblog;
header("Location: $url_wwwblog");
