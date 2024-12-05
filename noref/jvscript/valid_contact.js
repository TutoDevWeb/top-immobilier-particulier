function valid_contact() {

  if ( document.getElementById('subject')   != null  && document.getElementById('subject').value   == '' ) { window.alert("Remplir l'objet du message"); return false; }   
  if ( document.getElementById('message')   != null  && document.getElementById('message').value   == '' ) { window.alert("Remplir le message");         return false; }
  if ( document.getElementById('mail_from') != null  && document.getElementById('mail_from').value == '' ) { window.alert("Saisisser votre mail");       return false; }
  if ( document.getElementById('code_get')  != null  && document.getElementById('code_get').value  == '' ) { window.alert("Recopier le code");           return false; }
  if ( document.getElementById('code_set')  != null  && document.getElementById('code_get')  != null && document.getElementById('code_set').value != document.getElementById('code_get').value ) { window.alert("Erreur sur le code"); return false; }

	return true;

}
