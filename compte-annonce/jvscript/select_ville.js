function select_ville(init_zone_ville,init_zone_ard) {

  var init_zone_ville = init_zone_ville;
  var init_zone_ard   = init_zone_ard;

  //----------------------------------------------------------------------------------------------------
  // Fonction pour charger le select des villes
  this.fill = function (val_dept) {

    //console.log('select_ville.fill:val_dept  => '+val_dept);

    var id_zone_ville   = document.getElementById('zone_ville'); 
    var id_zone_ard     = document.getElementById('zone_ard'); // Select 
    var id_div_ard      = document.getElementById('ard'); // Div 

    var xhr = browser.getHttpObject() ; 
    xhr.onreadystatechange  = function() { 
      if ( xhr.readyState  == 4 ) {
        if ( xhr.status  == 200 ) {
        
          // On vide les select d'abord
          id_zone_ville.options.length=0;
          id_zone_ard.options.length=0;

          // On rend visible
          id_zone_ville.style.visibility = 'visible';
          id_div_ard.style.visibility   = 'hidden';

          // On initalise
          var new_ville = new Option('Choisir','0');
          id_zone_ville.options[id_zone_ville.length] = new_ville;

          var list = xhr.responseText;
          var ville_array = eval ('('+list+')');
          // On le rempli avec la liste
          for ( i in ville_array ) {

            var new_ville = new Option(ville_array[i].ville,ville_array[i].ville);
            id_zone_ville.options[id_zone_ville.length] = new_ville;

          }

          // Si il y a une valeur initiale pour la ville
          if ( init_zone_ville != '' ) {
					  //window.alert("init_zone_ville"+init_zone_ville);
            for ( var i = 0 ; i < id_zone_ville.length ; i++ ) {
              if ( id_zone_ville.options[i].value == init_zone_ville ) id_zone_ville.selectedIndex = i;          
            }
            if ( init_zone_ard != 0 ) sa.fill(init_zone_ville);
            init_zone_ville = '';
          }

        } else window.alert(xhr.status); 
      }
    }

    xhr.open("POST","/compte-annonce/vente-france.php",true); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xhr.send('action=get_ville_in_dept&dept_num='+ escape(val_dept) ); 

  }

}  