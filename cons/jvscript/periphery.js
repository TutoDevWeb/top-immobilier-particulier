//-----------------------------------------------------------------------------------
function load_init() {
  check_nbpi();
}
//-----------------------------------------------------------------------------------
function check_nbpi() {

  var P1   = document.getElementById('P1').checked ? 1 : 0 ;
  var P2   = document.getElementById('P2').checked ? 2 : 0 ;
  var P3   = document.getElementById('P3').checked ? 3 : 0 ;
  var P4   = document.getElementById('P4').checked ? 4 : 0 ;
  var P5   = document.getElementById('P5').checked ? 5 : 0 ;

  if ( P1 == 0 && P2 == 0 && P3 == 0 && P4 == 0 && P5 == 0 ) {
 
    //console.log('On checke les nmpi');   
    document.getElementById('P1').checked = true ;
    document.getElementById('P2').checked = true ;
    document.getElementById('P3').checked = true ;
    document.getElementById('P4').checked = true ;
    document.getElementById('P5').checked = true ;
    
  } 
}
//-----------------------------------------------------------------------------------
// Retourne les biens qui ne sont pas en intra-muros
function estatePeriphery() {

  var xhr = browser.getHttpObject() ; 
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {

        //console.log(xhr.responseText);
        var estatePeriphery = eval ('('+xhr.responseText+')');

        var str_annonce = '';
        var point_ville = new GLatLng(ville_lat,ville_lng);
        // On parcours la liste des annonces à afficher
        for ( var i = 0 ; i < estatePeriphery.length ; i++ ) {

          var zone_ville = estatePeriphery[i].zone_ville;
          var nba        = estatePeriphery[i].nba;
          var dist       = point_ville.distanceFrom(new GLatLng(estatePeriphery[i].lat,estatePeriphery[i].lng));
          dist = Math.round(dist / 1000);

          str_annonce += "<div id='peri'>A "+dist+" Kms : "+zone_ville+" : "+nba+" Annonce(s)</div>";
        }           
        document.getElementById('list_periphery').innerHTML = str_annonce;

        //console.log(str_annonce);

          
      } else window.alert(xhr.status); 
    }
  }
    
  var coord  = '&ne_lat='+max_ne_lat+'&ne_lng='+max_ne_lng+'&sw_lat='+max_sw_lat+'&sw_lng='+max_sw_lng;

  // Valeurs sur les filtres
  var typp = document.getElementById('typp').value;
  var P1   = document.getElementById('P1').checked ? 1 : 0 ;
  var P2   = document.getElementById('P2').checked ? 2 : 0 ;
  var P3   = document.getElementById('P3').checked ? 3 : 0 ;
  var P4   = document.getElementById('P4').checked ? 4 : 0 ;
  var P5   = document.getElementById('P5').checked ? 5 : 0 ;
  var sur_min  = document.getElementById('sur_min').value;
  var prix_max = document.getElementById('prix_max').value;

  var filter = '&typp='+typp+'&P1='+P1+'&P2='+P2+'&P3='+P3+'&P4='+P4+'&P5='+P5+'&sur_min='+sur_min+'&prix_max='+prix_max;

  var zone = '&ville='+ville;

  xhr.open("POST","/ref/ville-ajax.php",true); 
  xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
  xhr.send('action=get_estate_list_periphery'+coord+filter+zone); 
}