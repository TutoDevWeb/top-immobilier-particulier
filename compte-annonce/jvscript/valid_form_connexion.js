//---------------------------------------------------------------------
function valid_form_connexion() {

  var compte_tel_ins  = document.getElementById("connexion_compte_tel_ins");
  var compte_pass   = document.getElementById("connexion_compte_pass");
	
  if ( is_empty(compte_tel_ins,"Merci de mettre votre num�ro de t�l�phone num�ro 1.\n\nVous nous avez donn� ce num�ro au moment de la cr�ation de l'annonce\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de l'annonce")) return false;

	// V�rifier sagpass
  reg_pass = RegExp("[a-zA-Z0-9]{5}");
	if ( !reg_pass.test(compte_pass.value) ) {
	  window.alert("Nous d�tectons une erreur de format sur le mot de passe que vous nous proposez.\n\nMerci de mettre le mot de passe qui vous a �t� attribu�.\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de l'annonce");
    return false;
	}

	return true;
}
//---------------------------------------------------------------------
function valid_form_password() {

  var compte_tel_ins  = document.getElementById("password_compte_tel_ins");
	
  if ( is_empty(compte_tel_ins,"Merci de mettre votre num�ro de t�l�phone num�ro 1.\n\nVous nous avez donn� ce num�ro au moment de la cr�ation de l'annonce\n\nVous le trouverez dans le mail que vous avez d� recevoir au moment de la cr�ation de l'annonce")) return false;
	return true;

}
//---------------------------------------------------------------------
