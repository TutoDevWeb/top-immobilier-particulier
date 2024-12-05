<?PHP
function make_hits($tel_ins) {

  // Lire le cookie hits
  $cookie = isset($_COOKIE["hits"]) ? $_COOKIE["hits"] : '';

  // Récupérer la liste des annonces déjà vues
  $already_seen_list = explode('#',$cookie);
  
  // Le numéro de téléphone est-il dans la liste des annonces consultées stockées dans le cookie
  if ( !in_array($tel_ins,$already_seen_list) ) {

    // Si il n'y est pas il faut l'ajouter dans la liste
    setcookie('hits',$cookie.$tel_ins.'#',time()+300,"/");

    // Il faut compter le hit
    $update = "UPDATE ano SET hits=hits+1 WHERE tel_ins='$tel_ins' LIMIT 1";
    dtb_query($update,__FILE__,__LINE__,0);    
  
  }
}
?>
