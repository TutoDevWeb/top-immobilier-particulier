function select_dept(init_num_dept) {

  var init_num_dept = init_num_dept;

  //----------------------------------------------------------------------------------------------------
  // Fonction pour charger le select des départements
  this.fill = function () {

    var id_num_dept   = document.getElementById('num_dept'); 
    var id_zone_ville = document.getElementById('zone_ville'); 
    var id_zone_ard   = document.getElementById('zone_ard'); // Select 
    var id_div_ard    = document.getElementById('ard'); // Div 

    id_num_dept.options.length  = 0;
    id_zone_ville.options.length = 0;
    id_zone_ard.options.length   = 0;

    id_num_dept.style.visibility  = 'hidden';
    id_zone_ville.style.visibility = 'hidden';
    id_div_ard.style.visibility    = 'hidden';

    var xhr = browser.getHttpObject() ; 
    xhr.onreadystatechange  = function() { 
      if ( xhr.readyState  == 4 ) {
        if ( xhr.status  == 200 ) {

          // On initalise
          var new_dept = new Option('Choisir','0');
          id_num_dept.options[id_num_dept.length] = new_dept;
  
          var list = eval ('('+xhr.responseText+')');
          // On le rempli avec la liste
          for ( var i in list ) {
            new_dept = new Option(list[i].dept_num+' - '+list[i].dept,list[i].dept_num);
            id_num_dept.options[id_num_dept.length] = new_dept;
          }
          id_num_dept.style.visibility  = 'visible';

          if ( parseInt(init_num_dept) != 0 ) {
            id_num_dept.selectedIndex = parseInt(init_num_dept) ;
						//window.alert("sv.fill"); 
            sv.fill(init_num_dept);
            init_num_dept = 0 ;
          }
        } else window.alert(xhr.status); 
      }
    } 

    xhr.open("POST","/compte-annonce/vente-france.php",true); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xhr.send('action=get_liste_num_dept'); 

  }  
}
        

