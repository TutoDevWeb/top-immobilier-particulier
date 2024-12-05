<?PHP
//-----------------------------------------------------------------------
// On va rechercher la ville ou il manque un produit et on doit ressortir ces infos
// La fonction retourne true si elle a trouv�e et false si il n'y a plus rien a faire.
function target_ville(&$ville,&$dept,&$produit) {

  $appartement = false;
  $maison = false;
  $studio = false;

  for(;;) {

    // Je tire au sort le produit
    $produit = random_produit();

    // Si j'ai d�j� fait ce produit je reprend
    if ( $appartement == true ) continue;
		else $appartement = true;

    // Si j'ai d�j� fait ce produit je reprend
    if ( $studio == true ) continue;
		else $studio = true;

    // Si j'ai d�j� fait ce produit je reprend
    if ( $maison == true ) continue;
		else $maison = true;

    // Je cherche une ville a faire sur ce produit
    $find = get_ville_a_faire(&$ville,&$dept,$produit);

    // Si je trouve je retourne vrai et donc sort de la boucle
    if ( $find ) return true;
    
    // Sinon je vais continuer sauf si j'ai fait tous les produits
    else if ( $appartement && $maison && $studio ) return false;

  }

}
//-----------------------------------------------------------------------
// On cherche une ville � faire sur un produit donn�
function get_ville_a_faire(&$ref_ville,&$ref_dept,$produit) {

  $query = "SELECT ville,dept FROM ref_ville";
  $result_ref_ville = dtb_query($query,__FILE__,__LINE__,1);
  while ( list($ref_ville,$ref_dept) = mysqli_fetch_row($result_ref_ville) ) {

    $ref_ville_s = addslashes($ref_ville);
  
    // Il faut faire la recherche sur ano en fonction du produit cherch�
    if ( $produit == 'Appartement' )
      $query_ano = "SELECT count(*) FROM ano WHERE typp='".VAL_DTB_APPARTEMENT."' AND nbpi != 1 AND zone_ville='$ref_ville_s' AND num_dept='$ref_dept'";

    if ( $produit == 'Studio' )
      $query_ano = "SELECT count(*) FROM ano WHERE typp='".VAL_DTB_APPARTEMENT."' AND nbpi = 1 AND zone_ville='$ref_ville_s' AND num_dept='$ref_dept'";

    if ( $produit == 'Maison' )
      $query_ano = "SELECT count(*) FROM ano WHERE typp='".VAL_DTB_MAISON."' AND zone_ville='$ref_ville_s' AND num_dept='$ref_dept'";

    $result_ano = dtb_query($query_ano,__FILE__,__LINE__,1);
    list($nb) = mysqli_fetch_row($result_ano);    
    if ( $nb == 0 ) return true;

  }

  // Si j'arrive l� c'est que kj'ai rien trouv� sur ce produit
  return false;
  
}
?>
