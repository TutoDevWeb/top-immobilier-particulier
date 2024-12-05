//------------------------------------------------------------------------------------------------
function send_creer_alerte_baisse(tel_ins,prix) {

  //window.alert("Creer alerte recherche");

  var xhr = browser.getHttpObject() ; 
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
				var code_retour = xhr.responseText;
        //window.alert("code_retour="+code_retour);
        if ( code_retour == 'ok_alerte_baisse' ) {
				  if ( document.getElementById('alerte_baisse_bouton') != null ) document.getElementById('alerte_baisse_bouton').style.display = 'none'; 
				  if ( document.getElementById('ok_alerte_baisse') != null ) document.getElementById('ok_alerte_baisse').style.display = ''; 
        }
      }
    }
  }

  xhr.open("POST","/compte-recherche/services-ajax.php",true); 
  xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
  xhr.send('action=creer_alerte_baisse&tel_ins='+escape(tel_ins)+'&prix='+escape(prix)); 

}
//------------------------------------------------------------------------------------------------
function send_memoriser_financement() {

  var apport_radio    = document.getElementById('apport_radio');
  var credit_radio    = document.getElementById('credit_radio');
  var credit_montant  = document.getElementById('credit_montant');
  var apport_montant  = document.getElementById('apport_montant');
  var nb_annee_ptr    = document.getElementById('nb_annee');
  var taux_annuel_ptr = document.getElementById('taux_annuel');

  if ( apport_radio != null && credit_radio != null) {
	  if ( apport_radio.checked == true  && credit_radio.checked == false ) var fixe = 'apport_radio'; 
	  if ( apport_radio.checked == false && credit_radio.checked == true  ) var fixe = 'credit_radio'; 
  }

  if ( credit_montant  != null ) var credit   = credit_montant.value;
  if ( apport_montant  != null ) var apport   = apport_montant.value;
  if ( nb_annee_ptr    != null ) var nb_annee = nb_annee_ptr.value;
  if ( taux_annuel_ptr != null ) var taux_annuel = taux_annuel_ptr.value;

  var xhr = browser.getHttpObject() ; 
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
				var code_retour = xhr.responseText;
        if ( code_retour == 'ok_memoriser_financement' ) {
				  if ( document.getElementById('memoriser_financement_bouton') != null ) document.getElementById('memoriser_financement_bouton').style.display = 'none'; 
				  if ( document.getElementById('ok_memoriser_financement') != null ) document.getElementById('ok_memoriser_financement').style.display = ''; 
        }
      }
    }
  }

  xhr.open("POST","/compte-recherche/services-ajax.php",true); 
  xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
  xhr.send('action=memoriser_financement&fixe='+escape(fixe)+'&credit='+escape(credit)+'&apport='+escape(apport)+'&nb_annee='+escape(nb_annee)+'&taux_annuel='+escape(taux_annuel)); 

}
//------------------------------------------------------------------------------------------------
function send_creer_alerte_recherche() {

  if ( document.getElementById('zone')        != null ) var zone        = document.getElementById('zone').value;
  if ( document.getElementById('zone_pays')   != null ) var zone_pays   = document.getElementById('zone_pays').value;
  if ( document.getElementById('zone_dom')    != null ) var zone_dom    = document.getElementById('zone_dom').value;

  if ( document.getElementById('zone_region') != null ) var zone_region = document.getElementById('zone_region').value;
  if ( document.getElementById('zone_dept')   != null ) var zone_dept   = document.getElementById('zone_dept').value;
  if ( document.getElementById('zone_ville')  != null ) var zone_ville  = document.getElementById('zone_ville').value;
  if ( document.getElementById('zone_ard')    != null ) var zone_ard    = document.getElementById('zone_ard').value;
	else var zone_ard = '';
  if ( document.getElementById('dept_voisin') != null ) var dept_voisin = document.getElementById('dept_voisin').value;
  else var dept_voisin ='';

  if ( document.getElementById('typp') != null ) var typp = document.getElementById('typp').value;
  if ( document.getElementById('check_P1')   != null ) var P1   = ( document.getElementById('check_P1').checked == true ) ? 1 : 0 ;
  if ( document.getElementById('check_P2')   != null ) var P2   = ( document.getElementById('check_P2').checked == true ) ? 2 : 0 ;
  if ( document.getElementById('check_P3')   != null ) var P3   = ( document.getElementById('check_P3').checked == true ) ? 3 : 0 ;
  if ( document.getElementById('check_P4')   != null ) var P4   = ( document.getElementById('check_P4').checked == true ) ? 4 : 0 ;
  if ( document.getElementById('check_P5')   != null ) var P5   = ( document.getElementById('check_P5').checked == true ) ? 5 : 0 ;
  
  if ( document.getElementById('sur_min')  != null ) var sur_min  = document.getElementById('sur_min').value;
  if ( document.getElementById('prix_max') != null ) var prix_max = document.getElementById('prix_max').value;

  /*
  window.alert("Site en coours de test. Merci de votre compréhension. Cliquer sur tous les OK");
  window.alert("zone =>"+zone );
  window.alert("zone_pays =>"+zone_pays);
  window.alert("zone_dom =>"+zone_dom);
  window.alert("zone_region =>"+zone_region);
  window.alert("zone_dept =>"+zone_dept);
  window.alert("zone_ville =>"+zone_ville);
  window.alert("zone_ard =>"+zone_ard);
  window.alert("dept_voisin =>"+dept_voisin);
  window.alert("typp =>"+typp);
  window.alert("P1 => "+P1);
  window.alert("P2 => "+P2);
  window.alert("P3 => "+P3);
  window.alert("P4 => "+P4);
  window.alert("P5 => "+P5);
  window.alert("sur_min => "+sur_min);
  window.alert("prix_max => "+prix_max);
	return;
  */

  var xhr = browser.getHttpObject() ; 
  xhr.onreadystatechange  = function() { 
    if ( xhr.readyState  == 4 ) {
      if ( xhr.status  == 200 ) {
				var code_retour = xhr.responseText;
        if ( code_retour == 'ok_alerte_recherche' ) {
				  if ( document.getElementById('alerte_recherche_bouton') != null ) document.getElementById('alerte_recherche_bouton').style.display = 'none'; 
				  if ( document.getElementById('ok_alerte_recherche') != null ) document.getElementById('ok_alerte_recherche').style.display = ''; 
        }
      }
    }
  }

  xhr.open("POST","/compte-recherche/services-ajax.php",true); 
  xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
  xhr.send('action=creer_alerte_recherche&zone='+escape(zone)+'&zone_pays='+escape(zone_pays)+'&zone_dom='+escape(zone_dom)+'&zone_region='+escape(zone_region)+'&zone_dept='+escape(zone_dept)+'&zone_ville='+escape(zone_ville)+'&zone_ard='+escape(zone_ard)+'&dept_voisin='+escape(dept_voisin)+'&typp='+typp+'&P1='+P1+'&P2='+P2+'&P3='+P3+'&P4='+P4+'&P5='+P5+'&sur_min='+sur_min+'&prix_max='+prix_max); 

}