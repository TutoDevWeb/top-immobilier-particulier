<?PHP

define('CODE_DBG', 'DBG'); // Code de debug.
define('CODE_ADM', 'ADM'); // Code pour une action administrateur
define('CODE_NAV', 'NAV'); // Code pour une navigation 

define('CODE_RCL', 'RCL'); // Code pour une recherche liste
define('CODE_RCC', 'RCC'); // Code pour une recherche carte
define('CODE_RED', 'RED'); // Code pour une recherche avec accès à la fiche détaillée.
define('CODE_DTB', 'DTB'); // Code pour une recherche trace d'un appel à la database

define('CODE_CTA', 'CTA'); // Code pour la tracabilité des comptes annonce
define('CODE_CTR', 'CTR'); // Code pour la tracabilité des comptes recherche

define('CODE_CRA', 'CRA'); // Code pour la tache cron des comptes annonces
define('CODE_CRR', 'CRR'); // Code pour la tache cron des compte recherche


//-------------------------------------------------------------------------------------
// La fonction note une opération faite sur l'IP courant en vue d'une limitation
// $cop     : code opération
// $comment : commentaire
//-------------------------------------------------------------------------------------
function tracking($connexion, $cop, $res, $comment, $file, $line) {

	$ip         = $_SERVER['REMOTE_ADDR'];
	$tel_ins    = isset($_SESSION['tel_ins']) ? $_SESSION['tel_ins'] : 0;
	$file       = basename($file);
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$referer     = $_SERVER['HTTP_REFERER'];

	$comment = addslashes($comment);

	$insert = "INSERT INTO tracking (dat,ip,tel_ins,cop,res,user_agent,referer,file,line,comment) 
             VALUES (now(),'$ip','$tel_ins','$cop','$res','$user_agent','$referer','$file','$line','$comment')";

	mysqli_query($connexion, $insert);
}
//-------------------------------------------------------------------------------------
// Tracking d'un appel à la database
//-------------------------------------------------------------------------------------
function tracking_dtb($connexion, $query, $file, $line) {

	$file       = basename($file);
	$comment    = addslashes($query);
	$ip         = $_SERVER['REMOTE_ADDR'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$referer    = $_SERVER['HTTP_REFERER'];

	$insert = "INSERT INTO tracking (dat,ip,tel_ins,cop,res,user_agent,referer,`file`,`line`,comment) 
             VALUES (now(),'$ip','','DTB','OK','$user_agent','$referer','$file','$line','$comment')";

	mysqli_query($connexion, $insert);
}
//-------------------------------------------------------------------------------------
// La fonction tracque les actions des annonceurs dans les espaces pro et par.
// $cop     : code opération
// $comment : commentaire
// Dans le commentaire on concaténe systématiquement : email de l'annonceur
//-------------------------------------------------------------------------------------
function tracking_session_annonce($connexion, $cop, $res, $comment, $file, $line) {

	$ip      = $_SERVER['REMOTE_ADDR'];
	$tel_ins = isset($_SESSION['tel_ins']) ? $_SESSION['tel_ins'] : 0;
	$ida     = isset($_SESSION['ida'])     ? $_SESSION['ida']     : 0;

	$file    = basename($file);

	// Lorsqu'il s'agit d'une connexion de l'administrateur il faut le signaler dans la trace
	if (is_connexion_admin())  $comment = addslashes("SESSION ANNONCE ADMIN<br/>ida => $ida::tel_ins =>$tel_ins<br/>" . $comment);
	else                         $comment = addslashes("SESSION ANNONCE USERS<br/>ida => $ida::tel_ins =>$tel_ins<br/>" . $comment);

	$insert = "INSERT INTO tracking (dat,ip,tel_ins,cop,res,file,line,comment) 
             VALUES (now(),'$ip','$tel_ins','$cop','$res','$file','$line','$comment')";

	mysqli_query($connexion, $insert);
}
