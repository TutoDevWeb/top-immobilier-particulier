<?PHP
include("../data/data.php");
include("../include/inc_base.php");

//if (!filtrer_les_entrees_get(__FILE__,__LINE__)) die;

$connexion = dtb_connection();

isset($_GET['tel_ins']) ? $tel_ins = mysqli_real_escape_string($connexion, $_GET['tel_ins']) : die;
isset($_GET['wwwblog']) ? $wwwblog = mysqli_real_escape_string($connexion, $_GET['wwwblog']) : die;

// Lire le cookie blog
$cookie = isset($_COOKIE["blog"]) ? $_COOKIE["blog"] : '';

// Récupérer la liste des annonces déjà vues
$already_seen_list = explode('#', $cookie);

// Le numéro de téléphone est-il dans la liste des annonces consultées stockées dans le cookie
if (!in_array($tel_ins, $already_seen_list)) {

	// Si il n'y est pas il faut l'ajouter dans la liste
	setcookie('blog', $cookie . $tel_ins . '#', time() + 300, "/");

	// Il faut compter le hit
	$query = "UPDATE ano SET cntblog=cntblog+1 WHERE tel_ins='$tel_ins' LIMIT 1";
	dtb_query($connexion, $query, __FILE__, __LINE__, 0);
}

$url_wwwblog = "http://" . $wwwblog;
header("Location: $url_wwwblog");
