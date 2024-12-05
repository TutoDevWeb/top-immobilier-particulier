//---------------------------------------------------------------------
function valid_form_connexion() {

  var compte_email  = document.getElementById("connexion_compte_email");
  var compte_pass   = document.getElementById("connexion_compte_pass");
	
  if ( is_empty(compte_email,"Merci de mettre votre email.\n\nVous nous avez fourni cet email au moment de la cr�ation de votre compte recherche\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de votre compte de recherche")) return false;
  if ( email_invalide(compte_email) ) return false;

	// V�rifier sagpass
  reg_pass = RegExp("[a-zA-Z0-9]{5}");
	if ( !reg_pass.test(compte_pass.value) ) {
	  window.alert("Nous d�tectons une erreur de format sur le mot de passe que vous nous proposez.\n\nMerci de mettre le mot de passe qui vous a �t� attribu�.\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de votre compte recherche");
    return false;
	}

	return true;
}
//---------------------------------------------------------------------
function valid_form_creation() {

  var compte_email  = document.getElementById("creation_compte_email");
	
  if ( is_empty(compte_email,"Merci de mettre votre email.\n\nVous nous avez fourni cet email au moment de la cr�ation de votre compte recherche\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de votre compte de recherche")) return false;
  if ( email_invalide(compte_email) ) return false;

  /*	
  if ( code_get_empty(code_get) ) return false;
  if ( code_get_false(code_set,code_get) ) return false;
  */
	
	return true;
}
//---------------------------------------------------------------------
function valid_form_password() {

  var compte_email  = document.getElementById("password_compte_email");
	
  if ( is_empty(compte_email,"Merci de mettre votre email.\n\nVous nous avez fourni cet email au moment de la cr�ation de votre compte recherche\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de votre compte de recherche")) return false;
  if ( email_invalide(compte_email) ) return false;

  /*	
  if ( code_get_empty(code_get) ) return false;
  if ( code_get_false(code_set,code_get) ) return false;
  */
	
	return true;
}
//---------------------------------------------------------------------
function valid_form_activation() {

  var compte_email  = document.getElementById("activation_compte_email");
	
  if ( is_empty(compte_email,"Merci de mettre votre email.\n\nVous nous avez fourni cet email au moment de la cr�ation de votre compte recherche\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de votre compte de recherche")) return false;
  if ( email_invalide(compte_email) ) return false;

  /*	
  if ( code_get_empty(code_get) ) return false;
  if ( code_get_false(code_set,code_get) ) return false;
  */
	
	return true;
}
//---------------------------------------------------------------------
