<?PHP
session_start();

include("../data/data.php");
include("../include/inc_base.php");
include("../include/inc_nav.php");
include("../include/inc_tracking.php");

dtb_connection(__FILE__,__LINE__);

tracking_session_annonce(CODE_CTA,'OK',"Déconnexion",__FILE__,__LINE__);

session_destroy();

header('Location: /');  

?>