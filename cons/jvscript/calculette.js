/*-------------------------------------------------------------------------------------------*/
function load_calculette (finance_actif,fixe,apport,credit,nb_annee,taux_annuel) {

  if ( finance_actif == 1 ) {

    /* Valeurs sur les filtres */
    if ( fixe == 'apport_radio' ) {
      document.getElementById('apport_radio').checked = true ;
      document.getElementById('credit_radio').checked = false;
    }

    if ( fixe == 'credit_radio' ) {
      document.getElementById('apport_radio').checked = false;
      document.getElementById('credit_radio').checked = true ;
    }

    document.getElementById('apport_montant').value = apport;
    document.getElementById('credit_montant').value = credit;
    document.getElementById('nb_annee').value       = nb_annee;
    document.getElementById('taux_annuel').value    = taux_annuel;

  }

}
/*-------------------------------------------------------------------------------------------*/
function calculette () {

  /* Valeurs sur les filtres */
  var prix  = document.getElementById('prix').value;
  var frais = document.getElementById('frais').value;
  var montant_a_financer = document.getElementById('montant_a_financer').value;
  var apport_radio   = document.getElementById('apport_radio').checked;
  var credit_radio   = document.getElementById('credit_radio').checked;
  var apport_montant = document.getElementById('apport_montant').value;
  var credit_montant = document.getElementById('credit_montant').value;
  var nb_annee       = document.getElementById('nb_annee').value;
  var taux_annuel    = document.getElementById('taux_annuel').value;

  if ( document.getElementById('memoriser_financement_bouton') != null ) document.getElementById('memoriser_financement_bouton').style.display = ''; 
	if ( document.getElementById('ok_memoriser_financement') != null ) document.getElementById('ok_memoriser_financement').style.display = 'none'; 

  /*
  console.log(prix);
  console.log(frais);
  console.log(montant_a_financer);
  console.log(apport_radio);
  console.log(credit_radio);
  console.log(apport_montant);
  console.log(credit_montant);
	*/
	
	/* Si c'est l'apport qui est coché on calcule le montant crédit */
	if ( apport_radio == true ) {

	  if ( apport_montant == '0' || apport_montant == '' ) {

		  document.getElementById('apport_montant').value = '0';
	    document.getElementById('credit_montant').value = montant_a_financer;
      var mensualite = calcul_mensualite(parseFloat(document.getElementById('credit_montant').value),parseFloat(nb_annee),parseFloat(taux_annuel));
      document.getElementById('res_mensualite').innerHTML = "Mensualité de "+mensualite+" Euros";
      document.getElementById('res_apport').innerHTML     = "Pas d'apport personnel"; 
		
		/* Si la valeur de l'apport est supérieur au montant_a_financer */
		} else if ( parseFloat(apport_montant) > parseFloat(montant_a_financer) ) {

		  document.getElementById('credit_montant').value = '0';
      document.getElementById('res_mensualite').innerHTML = "Pas de crédit";
      document.getElementById('res_apport').innerHTML     = "Apport supérieur au montant à financer";

		} else {
		
	    document.getElementById('credit_montant').value = montant_a_financer - apport_montant;
      var mensualite = calcul_mensualite(parseFloat(document.getElementById('credit_montant').value),parseFloat(nb_annee),parseFloat(taux_annuel));
      document.getElementById('res_mensualite').innerHTML = "Mensualité de "+mensualite+" Euros";
      document.getElementById('res_apport').innerHTML     = "Apport personnel de "+apport_montant+" Euros"; 

    }

	} 

	/* Si c'est le credit qui est coché on calcule le montant de l'apport */
	if ( credit_radio == true ) {

	  if ( credit_montant == '0' || credit_montant == '' ) {

	    document.getElementById('apport_montant').value = montant_a_financer ;
		  document.getElementById('credit_montant').value = '0';
      document.getElementById('res_mensualite').innerHTML = "Pas de crédit";    
      document.getElementById('res_apport').innerHTML = "Apport Personnel de "+apport_montant+" Euros"; 

		} else if ( parseFloat(credit_montant) > parseFloat(montant_a_financer) ) {

	    document.getElementById('res_mensualite').innerHTML = "Votre crédit est supérieur au montant à financer";
		  document.getElementById('apport_montant').value = '0';

    } else {

      var mensualite = calcul_mensualite(parseFloat(document.getElementById('credit_montant').value),parseFloat(nb_annee),parseFloat(taux_annuel));
      document.getElementById('res_mensualite').innerHTML = "Mensualité de "+mensualite+" Euros";
	    document.getElementById('apport_montant').value = montant_a_financer - credit_montant ;
      document.getElementById('res_apport').innerHTML     = "Apport Personnel de "+document.getElementById('apport_montant').value+" Euros"; 

    }

  }

}
/*-------------------------------------------------------------------------------------------*/
/* Capital à emprunter                        */
/* NbAn : durée en année de l'emprunt         */
/* TxAn : taux annuel en pourcentage          */
/*--------------------------------------------*/
function calcul_mensualite(Capital,NbAn,TxAn) {

  // Le nombre d'échéances par an
  var EchAn = 12.0;
	
	// Le taux annuel est saisi en pourcentage donc on rectifie
	TxAn = TxAn / 100.0;
	
  // Calcul du Taux Periodique
	var TxPer = TxAn / EchAn ;
	
	// Le Nombre d'échance total
	var NbEch = EchAn * NbAn ;
	
	// Calcul intermédiare de la puissance
	var PxPer = Math.pow(( 1.0 + TxPer ),NbEch);
	
	var Echeance = Math.ceil(( Capital * TxPer * PxPer ) / ( PxPer - 1.0 )); 

  /*
	console.log("TxPer => "+TxPer);
	console.log("NbEch => "+NbEch);
	console.log("PxPer => "+PxPer);
  console.log("Echeance =>"+Echeance);
  */
	
  return(Echeance);

}
/*-------------------------------------------------------------------------------------------*/
function clear_result() {

  document.getElementById('res_mensualite').innerHTML = "";
  document.getElementById('res_apport').innerHTML     = "";

}
