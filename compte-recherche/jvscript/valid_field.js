//--------------------------------------------------------------------------------------------
// Filtre pour un champ de texte ( TEXT ou TEXTAREA )
var nb_avert=0;
function is_text(field_id) {

  if ( field_id != null ) {
  
    fgen = /[#<>$!"{}()[\];*%`\\]+/;

    // Tant qu'il y a des caract�res interdits.
    for (;;) {

      // Si il y a un caract�re interdit
      if ( field_id.value.search(fgen) != -1 ) {
    
        if ( nb_avert < 2 ) {
          if ( nb_avert == 0 ) window.alert("Ne mettre que lettre, chiffre, virgule, point.");
          if ( nb_avert == 1 ) window.alert("ATTENTION : IL FAUT LIRE LES MESSAGES !!");
          nb_avert++;
        }
      
        // Remplacement des caract�res interdits
        field_id.value = field_id.value.replace(fgen,'-');
  
      } else break;
    }
  }
}
//--------------------------------------------------------------------------------------------
// Filtre pour un champ de type entier ( TEXT )
function is_number(field_name,field_value) {
  reg_number = RegExp("^[0-9]*$");  
  if ( !reg_number.test(field_value) ) {
    window.alert(field_name+" : Ne mettre que des chiffres ");
    return false;
  } return true;
}
//--------------------------------------------------------------------------------------------
function is_empty(field_id,mess) {
  if ( field_id != null && field_id.value == '' ) { 
    field_id.focus();
    window.alert(mess);
    return true;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function is_unselected(field_id,mess) {
  if ( field_id != null && field_id.selectedIndex == 0 ) { 
    field_id.focus();
    window.alert(mess);
    return true;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function telephone_invalide(field_id) {

  if ( field_id != null ) {  
    // V�rifier tel_ins
    reg_tel = RegExp("[0-9]{10}");
    result  = reg_tel.test(field_id.value);
    if ( result == false ) {
      field_id.focus();
      window.alert("Mettre un num�ro de t�l�phone � 10 chiffres");
      return true;
    } else return false;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function email_invalide(field_id) {

  if ( field_id != null ) {  
    reg_mail = new RegExp("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]+$","i");
    result = reg_mail.test(field_id.value);
    if ( result == false ) {
      field_id.focus();
      window.alert("Rentrez un email valide");
      return true;  
    } else return false;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function format_url(field_id) {

  if ( field_id != null ) {

    var reg = RegExp('http://', 'i');;
    if (!reg.test(field_id.value)) field_id.value = "http://"+field_id.value;

  }
}
//--------------------------------------------------------------------------------------------
function code_get_empty(field_id) {
  if ( field_id != null && field_id.value == "" ) {
    field_id.focus();
    window.alert("Recopier le code de s�curit� !");
    return true;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function code_get_false(set_field_id,get_field_id) {
  if ( set_field_id != null && get_field_id != null && (set_field_id.value != get_field_id.value) ) {
    get_field_id.focus();
    window.alert("Erreur sur le code de s�curit� !");
    return true;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function est_trop_court(field_id,size,name) {
  if ( field_id != null && field_id.value.length < size ) {
    field_id.focus();
    window.alert(name+" fait "+field_id.value.length+" caract�res et le minimum autoris� est "+size+" caract�res");
    return true;
  } else return false;
}
//--------------------------------------------------------------------------------------------
function description_est_trop_court(field_id,size) {
  if ( field_id != null && field_id.value.length < size ) {
    field_id.focus();
    window.alert("On vous demande au moins 200 caract�res pour d�crire votre activit� de mani�re pr�cise et optimiser votre r�f�rencement");
    return true;
  } else return false;
}

