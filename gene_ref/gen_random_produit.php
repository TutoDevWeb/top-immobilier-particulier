<?PHP
//-----------------------------------------------------------------------
// Tirage au sort de la ville pond�r� par le nombre d'habitant par villes
function random_produit() {

// On g�n�re 3 types de produit car il y aura 3 types d'annonces
$T_produit = array("Maison","Studio","Appartement");

// Table de pond�ration du type de produit
$num_T = array(0,1,1,2,2,2,2);

// Tirage de l'index dans la table
$ind_num   = mt_rand(0,count($num_T)-1);

// R�cup�rer le produit
$ind_T = $num_T[$ind_num];

$produit = $T_produit[$ind_T];

//echo "$produit<br/>";

return $produit;

}
?>