//-------------------------------------------------------------------------
// La fonction est appel�e lorsque l'on change de d�partement de m�tropole
function on_zone_dept() {

  document.getElementById('zone').value = 'france' ;  
  document.getElementById('zone_pays').selectedIndex = 0 ;  
  document.getElementById('zone_dom').selectedIndex = 0 ;  
}
//-------------------------------------------------------------------------
// La fonction est appel�e lorsque l'on change de d�partement de Dom Tom
function on_zone_dom() {

  document.getElementById('zone_dept').selectedIndex = 0 ;  
  document.getElementById('zone_pays').selectedIndex = 0 ;  
  document.getElementById('zone').value = 'domtom' ;  

}
//-------------------------------------------------------------------------
// La fonction est appel�e lorsque l'on change de pays
function on_zone_pays() {

  document.getElementById('zone_dept').selectedIndex = 0 ;  
  document.getElementById('zone_dom').selectedIndex = 0 ;  
  document.getElementById('zone').value = 'etranger' ;  

}