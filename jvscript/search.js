function validation(form) {

	//window.alert("Tilt");

	// Il faut qu'il y ait une zone géographique de sélectionnée
	if (form.zone_dept.selectedIndex == 0
		&& form.zone_dom.selectedIndex == 0
		&& form.zone_pays.selectedIndex == 0) {
		window.alert("Sélectionner une zone géographique !!");
		return false;
	}

	// Mémorise les arguments dans un cookie
	//set_search(form);  

	return true;

}
//-------------------------------------------------------------------------
//
function valid_cnx(form) {

	// Vérifier tel_ins
	reg_tel = RegExp("[0-9]{10}");
	if (!reg_tel.test(form.tel_ins.value)) {
		window.alert("Mettre un numéro de téléphone a 10 chiffres");
		return false;
	}

	// Vérifier sagpass
	reg_pass = RegExp("[a-zA-Z0-9]{5,10}");
	if (!reg_pass.test(form.sagpass.value)) {
		window.alert("Mettre un mot de passe de 5 à 10 caractères (chiffres ou lettres)");
		return false;
	}

	return true;
}
//-------------------------------------------------------------------------
// Refait la liste des arrondissements
function make_zone_ard() {

	if (document.getElementById('zone_ard') != null) {

		// Parcours des checkbox pour refaire la liste des arrondissement
		var ard_list = "";
		for (n_ard = 1; n_ard <= 20; n_ard++) {
			// Récupérer l'état du checkbox coorespondant au numéro d'arondissement		
			if (document.getElementById("ard_" + n_ard) != null && document.getElementById("ard_" + n_ard).checked == true) {
				ard_list = ard_list + n_ard + ",";
			}
		}

		// Supprimer la virgule à la fin
		ard_list = ard_list.substring(0, ard_list.length - 1);
		document.getElementById('zone_ard').value = ard_list;

	}
}
//-------------------------------------------------------------------------
//
function make_dept_voisin() {

	if (document.getElementById('dept_voisin') != null) {

		// Savoir dans quelle ville on est
		var ville = document.getElementById('zone_ville').value;
		ville = ville.toLowerCase();

		if (ville == 'paris') var list_dept_voisin = Array('77', '78', '91', '92', '93', '94', '95');
		if (ville == 'marseille') var list_dept_voisin = Array('83', '04', '84', '30');
		if (ville == 'lyon') var list_dept_voisin = Array('01', '71', '42', '38');

		var dept_voisin = "";
		for (var i in list_dept_voisin) {
			if (document.getElementById('dept_' + list_dept_voisin[i]) != null && document.getElementById('dept_' + list_dept_voisin[i]).checked == true) {
				dept_voisin = dept_voisin + list_dept_voisin[i] + ",";
			}
		}

		// Supprimer la virgule à la fin
		dept_voisin = dept_voisin.substring(0, dept_voisin.length - 1);
		document.getElementById('dept_voisin').value = dept_voisin;

	}
}
//-------------------------------------------------------------------------
//
function select_tout() {

	// Sélection de tous les arrondissement
	var ard_list = "";
	for (n_ard = 1; n_ard <= 20; n_ard++) {
		if (document.getElementById("ard_" + n_ard) != null) {
			document.getElementById("ard_" + n_ard).checked = true;
			ard_list = ard_list + n_ard + ",";
		}
	}

	// Mise à jour de zone_ard
	ard_list = ard_list.substring(0, ard_list.length - 1);
	if (document.getElementById('zone_ard') != null) document.getElementById('zone_ard').value = ard_list;

}
//-------------------------------------------------------------------------
//
function select_rien() {

	// Dé-sélection de tous les arrondissement
	for (n_ard = 1; n_ard <= 20; n_ard++) {
		if (document.getElementById("ard_" + n_ard) != null)
			document.getElementById("ard_" + n_ard).checked = false;
	}

	// Mise à jour de zone_ard
	if (document.getElementById('zone_ard') != null) document.getElementById('zone_ard').value = '';

}
//-------------------------------------------------------------------------
//
function valid_byphone(form) {

	// Vérifier tel_ins
	reg_tel = RegExp("[0-9]{10}");
	if (!reg_tel.test(form.tel_ins.value)) {
		window.alert("Mettre un num�ro de t�l�phone a 10 chiffres");
		return false;
	}

	return true;
}
