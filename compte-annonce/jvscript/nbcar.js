function print_nbcar() {
 
  var max_car = 512;

  blabla = document.getElementById("blabla");
  nbcar  = document.getElementById("nbcar");

  if ( blabla != null && nbcar != null ) {

    is_text(blabla);
  
    if ( blabla.value.length > max_car ) blabla.value = blabla.value.substr(0,max_car);
		nbcar.value = blabla.value.length;

  }
}
window.onload = print_nbcar;