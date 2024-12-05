//---------------------------------------------------------------------
function fill_valid_form(form) {

  window.alert("Vous avez fait un double Click.\n Ceci est un formulaire de test\n");

  form.nom.value     = "Fondacci"; 
  form.prenom.value  = "Jean Louis"; 
  form.adresse.value = "832 Avenue de Fréjus_Paul Ricard"; 
  form.ville.value   = "Mandelieu La Napoule"; 
  form.code.value    = "06210"; 
}
//---------------------------------------------------------------------
function valid_form_ano_valider() {

  var nom     = document.getElementById("nom");
  var prenom  = document.getElementById("prenom");
  var adresse = document.getElementById("adresse");
  var ville   = document.getElementById("ville");
  var code    = document.getElementById("code");

  // Contrôler que les champs ne sont pas vide
  if ( is_empty(nom,"Nom ?")) return false;
  if ( is_empty(prenom,"Prenom ?")) return false;
  if ( is_empty(adresse,"Adresse ?")) return false;
  if ( is_empty(ville,"Ville ?")) return false;
  if ( is_empty(code,"Code ?")) return false;

  // Contrôler que le champ code fait 5 caractères
  if ( code.value.length != 5 ) {
    window.alert("Code à 5 chiffres");
    return false;
  }
	
	return true;

}
//---------------------------------------------------------------------
