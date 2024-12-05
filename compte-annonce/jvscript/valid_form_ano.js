//---------------------------------------------------------------------
function valid_form_ano(zone) {

  var debug = 1;
  //if ( debug) window.alert(zone);

  // Premier Tableau
  var zone_pays  = document.getElementById("zone_pays");
  var zone_ville = document.getElementById("zone_ville");
  var num_dept   = document.getElementById("num_dept");
  var zone_dom   = document.getElementById("zone_dom");
  var zone_ard   = document.getElementById("zone_ard");
	
  if ( is_empty(zone_pays,"Pays ?")) return false;

  // Dans ce cas on doit v�rifier la Ville et le D�partement de M�tropole
  if ( zone == 'france' ) {
    //if ( debug) window.alert('V�rification FRANCE');
    if ( is_unselected(num_dept,"Choisir le D�partement !")) return false;
    if ( is_unselected(zone_ville,"Choisir la Ville !")) return false;
    if ( zone_ville.value == 'Paris' || zone_ville.value == 'Marseille' || zone_ville.value == 'Lyon' ) {
      if ( is_unselected(zone_ard,"Choisir l'Arrondissement !")) return false;
		}
	}
	
  // Dans ce cas on doit v�rifier la Ville et la D�partement Hors M�tropole
  if ( zone == 'domtom' ) {
    //if ( debug) window.alert('V�rification DOM TOM');
    if ( is_unselected(zone_dom,"S�lectionner le D�partement ?")) return false;
    if ( is_empty(zone_ville,"Ville ?")) return false;	
	}

  // Dans ce cas on doit v�rifier la Ville
  if ( zone == 'etranger' ) {
    if ( is_empty(zone_ville,"Ville ?")) return false;	
	}

  // Deuxi�me Tableau
	var typp       = document.getElementById("typp");
	var nbpi       = document.getElementById("nbpi");
	var surf       = document.getElementById("surf");
	var prix       = document.getElementById("prix");

  if ( is_unselected(typp,"Type de Produit ?")) return false;
  if ( is_unselected(nbpi,"Nombre de Pi�ces ?")) return false;
  if ( is_empty(surf,"Surperficie ?")) return false;
  if ( is_empty(prix,"Prix ?")) return false;

  // Troisi�me Tableau
	var blabla = document.getElementById("blabla");
  if ( is_empty(blabla,"Description de votre produit ?")) return false;

  // Quatri�me Tableau
	var tel_ins   = document.getElementById("tel_ins");
	var tel_bis   = document.getElementById("tel_bis");
	var sagmail   = document.getElementById("sagmail");
	var condition = document.getElementById("condition");
	var code_set  = document.getElementById("code_set");
	var code_get  = document.getElementById("code_get");

  if ( is_empty(tel_ins,"Votre T�l�phone 1 ?")) return false;
  if ( telephone_invalide(tel_ins) ) return false;
	
  if ( is_empty(sagmail,"Votre Email ?")) return false;
  if ( email_invalide(sagmail) ) return false;
	
	// Si le t�l�phone bis est renseign�, le v�rifier
	if ( tel_bis.value != "" && telephone_invalide(tel_bis) ) return false;

  if ( code_get_empty(code_get) ) return false;
  if ( code_get_false(code_set,code_get) ) return false;
	
	// V�rifier que les conditions sont lues
	if ( condition.checked != true ) {
	  window.alert("Lire les conditions d'utilisation et cocher SVP");
		return false;
  }

	return true;
}
//---------------------------------------------------------------------
