function select_ard(init_zone_ard) {

	var init_zone_ard = init_zone_ard;

	//----------------------------------------------------------------------------------------------------
	// Fonction pour charger le select des arrondissements
	this.fill = function (val_ville) {

		//window.alert('select_ard.fill : '+val_ville);

		var id_div_ard = document.getElementById('ard');        // Div 
		var id_zone_ard = document.getElementById('zone_ard');   // Select


		if (val_ville == 'Paris' || val_ville == 'Marseille' || val_ville == 'Lyon') {

			if (val_ville == 'Paris') var nb_ard = 20;
			if (val_ville == 'Marseille') var nb_ard = 16;
			if (val_ville == 'Lyon') var nb_ard = 9;

			id_div_ard.style.visibility = 'visible';

			var new_ard = new Option('Choisir', '0');
			id_zone_ard.options[id_zone_ard.length] = new_ard;

			for (var i = 1; i <= nb_ard; i++) {
				var str = (i == 1) ? ' er' : ' ième';
				new_ard = new Option(i + str, i);
				id_zone_ard.options[id_zone_ard.length] = new_ard;
			}

			// Si il y a une valeur initiale on initialise
			// On remet la valeur initiale 0 car on initialise qu'une seule fois.
			if (init_zone_ard != 0) {
				id_zone_ard.selectedIndex = init_zone_ard;
				init_zone_ard = 0;
			}

		} else {
			id_div_ard.style.visibility = 'hidden';
			id_zone_ard.options.length = 0;
		}

	}
}