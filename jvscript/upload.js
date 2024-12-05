function validation() {

  var test_jpg  = false;
	var test_jpeg = false;
  with (document.photo) {
   		
		  //window.alert(maxval.value);
		  //window.alert(photo1.value);
			
			var file_name = photo1.value ;

      if ( file_name == '' ) {
			  window.alert('Choisir un fichier photo');
        return false;
      }
      var file_ext = file_name.split('.');
			var siz = file_ext.length;

		  //window.alert(file_ext[siz-1]);
       
      if ( file_ext[siz-1].toUpperCase() != 'JPEG' && file_ext[siz-1].toUpperCase() != 'JPG' ) {
        window.alert("Utiliser exclusivement des fichiers avec une extention en .jpg ou .jpeg\n\nSi vous avez des difficultés de transfert de photos, n'hésitez pas à nous contacter");
        return false;
      }
	}
  return true;
}

