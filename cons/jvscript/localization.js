function Localization() {

	//------------------------------------------------
	this.show = function () {

		// Valeurs sur la zone
		var zone = document.getElementById('zone').value;
		var zone_pays = document.getElementById('zone_pays').value;
		var zone_dom = document.getElementById('zone_dom').value;
		var zone_region = document.getElementById('zone_region').value;
		var zone_dept = document.getElementById('zone_dept').value;
		var zone_ville = document.getElementById('zone_ville').value;
		var zone_ard = document.getElementById('zone_ard').value;

		//console.log('show_localization zone_ville : '+zone_ville);
		//console.log('show_localization zone_dept : '+zone_dept);
		//console.log('show_localization zone_region : '+zone_region);

		zone_pays = 'France';

		var lien_ville = (zone_ville != '') ? " &raquo; <a href='#' title=\"Voir les r�sultats sur : " + zone_ville + "\" onClick='switchzone.ville(\"encodeURI(e(zone_dept)+"\",\"encodeURI(e(zone_ville)+"\");return false;'>" + zone_ville + "</a>"    : '';
		var lien_dept = (zone_dept != '') ? " &raquo; <a href='#' title=\"Voir les r�sultats sur : " + zone_dept + "\" onClick='switchzone.dept(\"encodeURI(e(zone_dept)+"\");return false;'>" + zone_dept + "</a>"       : '';
		var lien_region = (zone_region != '') ? " &raquo; <a href='#' title=\"Voir les r�sultats sur : " + zone_region + "\" onClick='switchzone.region(\"encodeURI(e(zone_region)+"\");return false;'>" + zone_region + "</a>" : '';
		var lien_pays = (zone_pays != '') ? " :: <a href='#' title=\"Voir les r�sultats sur : " + zone_pays + "\" onClick='switchzone.pays(\"encodeURI(e(zone_pays)+"\");return false;'>" + zone_pays + "</a>"            : '';
		var lien_accueil = " <a href='/' title=\"Retour � l'accueil\" >Accueil</a>";

		document.getElementById('localization').innerHTML = lien_accueil + lien_pays + lien_region + lien_dept + lien_ville;

	}
}
