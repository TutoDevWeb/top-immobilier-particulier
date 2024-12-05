<?PHP
function make_hits($tel_ins) {

  // Lire le cookie hits
  $cookie = isset($_COOKIE["hits"]) ? $_COOKIE["hits"] : '';

  // R�cup�rer la liste des annonces d�j� vues
  $already_seen_list = explode('#',$cookie);
  
  // Le num�ro de t�l�phone est-il dans la liste des annonces consult�es stock�es dans le cookie
  if ( !in_array($tel_ins,$already_seen_list) ) {

    // Si il n'y est pas il faut l'ajouter dans la liste
    setcookie('hits',$cookie.$tel_ins.'#',time()+300,"/");

    // Il faut compter le hit
    $update = "UPDATE ano SET hits=hits+1 WHERE tel_ins='$tel_ins' LIMIT 1";
    dtb_query($update,__FILE__,__LINE__,0);    
  
  }
}
?>
