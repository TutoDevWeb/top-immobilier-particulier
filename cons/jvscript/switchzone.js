function Switchzone() {

	//-----------------------------------------------------------------------------------
	// Affiche la carte d'une ville. zone_ville_s est passer en argument avec escape. 
	this.ville = function (zone_dept_s, zone_ville_s) {

		var zone_ville = unencodeURI(zone_ville_s);
		var zone_dept = unencodeURI(zone_dept_s);
		//console.log(zone_ville);
		var xhr = browser.getHttpObject();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {

					//console.log(xhr.responseText);
					var new_map = eval('(' + xhr.responseText + ')');

					if (document.getElementById('zone_ville') != null) document.getElementById('zone_ville').value = zone_ville;
					if (document.getElementById('zone_dept') != null) document.getElementById('zone_dept').value = new_map.dept;
					if (document.getElementById('zone_region') != null) document.getElementById('zone_region').value = new_map.region;

					// Il faut g�rer ces arguments pour ne pas d�clencher d'erreurs au moment du retour sur liste. (check_arg)
					// Ce sera plus n�cessaire quand les arrondissements et les d�partements voisins seront g�r�s sur les cartes.
					if (document.getElementById('zone_ville') != null
						&& document.getElementById('zone_ville').value != 'Paris'
						&& document.getElementById('zone_ville').value != 'Lyon'
						&& document.getElementById('zone_ville').value != 'Marseille') {

						if (document.getElementById('zone_ard') != null) document.getElementById('zone_ard').value = '';
						if (document.getElementById('dept_voisin') != null) document.getElementById('dept_voisin').value = '';

					}

					map.setCenter(new GLatLng(new_map.ville_lat, new_map.ville_lng), parseInt(new_map.zoom));
					//console.log('zoom => '+map.getZoom());

				}
			}
		}

		xhr.open("POST", "/cons/recherche-carte-ajax.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('action=get_map_ville&zone_ville=' + zone_ville_s + '&zone_dept=' + zone_dept_s);
	}
	//-----------------------------------------------------------------------------------
	// Affiche la carte d'un d�partement
	this.dept = function (zone_dept_s) {

		var zone_dept = unencodeURI(zone_dept_s);
		//console.log(zone_dept);
		var xhr = browser.getHttpObject();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {

					//console.log(xhr.responseText);
					var new_map = eval('(' + xhr.responseText + ')');

					document.getElementById('zone_ville').value = '';
					document.getElementById('zone_dept').value = zone_dept;
					document.getElementById('zone_region').value = new_map.region;

					map.setCenter(new GLatLng(new_map.dept_lat, new_map.dept_lng), parseInt(new_map.zoom));
					//console.log('zoom => '+map.getZoom());

				}
			}
		}

		xhr.open("POST", "/cons/recherche-carte-ajax.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('action=get_map_dept&dept=' + zone_dept_s);
	}

	//-----------------------------------------------------------------------------------
	// Affiche la carte d'une r�gion
	this.region = function (zone_region_s) {
		var zone_region = unencodeURI(zone_region_s);
		//console.log(zone_region);
		var xhr = browser.getHttpObject();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {

					//console.log(xhr.responseText);
					var new_map = eval('(' + xhr.responseText + ')');

					document.getElementById('zone_region').value = zone_region;
					document.getElementById('zone_dept').value = '';
					document.getElementById('zone_ville').value = '';

					map.setCenter(new GLatLng(new_map.region_lat, new_map.region_lng), parseInt(new_map.zoom));
					//console.log('zoom => '+map.getZoom());

				}
			}
		}

		xhr.open("POST", "/cons/recherche-carte-ajax.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('action=get_map_region&region=' + zone_region_s);
	}

	//-----------------------------------------------------------------------------------
	// Affiche la carte d'un pays
	this.pays = function (zone_pays) {

		document.getElementById('zone_region').value = '';
		document.getElementById('zone_dept').value = '';
		document.getElementById('zone_ville').value = '';

		map.setCenter(new GLatLng(46.255847, 2.197266), parseInt(6));

	}

}