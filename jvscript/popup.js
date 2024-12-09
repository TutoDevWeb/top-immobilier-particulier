var fw = 0;
function clear_window() {

	if (fw != 0) fw.close();

}
function popup_show(f, ww, hh) {

	fw = window.open(f, 'f', 'titlebar=no,resizable=no,toolbar=no,width=' + ww + ',height=' + hh + ',status=no');
	var cx = screen.width / 2 - ww / 2;
	var cy = screen.height / 2 - hh / 2;
	fw.moveTo(cx, cy);
	fw.focus();

}
function popup_pass(f, ww, hh) {

	fw = window.open(f, 'f', 'titlebar=yes,resizable=no,toolbar=no,width=' + ww + ',height=' + hh + ',status=no,scrollbars=no');
	var cx = screen.width / 2 - ww / 2;
	var cy = screen.height / 2 - hh / 2;
	fw.moveTo(cx, cy);
	fw.focus();

}
function popup_scroll_show(f, ww, hh) {

	//titlebar=0,toolbar=no,height="+ph+",width="+pw+",status=no


	fw = window.open(f, 'f', 'titlebar=no,resizable=no,toolbar=no,width=' + ww + ',height=' + hh + ',status=no,scrollbars=yes');
	var cx = screen.width / 2 - ww / 2;
	var cy = screen.height / 2 - hh / 2;
	fw.moveTo(cx, cy);
	fw.focus();

}
//---------------------------------------------------------------------------
function popup_contact_ano(tel_ins) {

	fw = window.open('/contact-' + tel_ins + '.htm', 'f', 'titlebar=yes,resizable=no,toolbar=no,width=400,height=330,status=no,scrollbars=no');
	fw.moveTo(0, 0);
	fw.focus();

}
//---------------------------------------------------------------------------
function popup_contact_webmaster() {

	fw = window.open('/noref/contact_webmaster.php', 'w', 'titlebar=yes,resizable=no,toolbar=no,width=400,height=370,status=no,scrollbars=no');
	fw.moveTo(0, 0);
	fw.focus();

}
//---------------------------------------------------------------------------
function popup_contact(ww, hh) {

	fw = window.open('', 'popup1', 'titlebar=yes,resizable=yes,toolbar=no,width=' + ww + ',height=' + hh + ',status=no,scrollbars=no');
	var cx = screen.width / 2 - ww / 2;
	var cy = screen.height / 2 - hh / 2;
	fw.resizeTo(ww, hh);
	fw.moveTo(cx, cy);
	fw.focus();

}
//---------------------------------------------------------------------------
function to(url) {

	window.location.href = url;

}
//---------------------------------------------------------------------------
// Demande une confirmation avant une action
function confirm_delete(page, texte) {
	confirmation = confirm('Etes vous sur de vouloir supprimer ' + texte + ' ? ');
	if (confirmation)
		window.location.replace(page);
}

//---------------------------------------------------------------------------
function confirm_ligne_france(page) {
	confirmation = confirm('Avez vous téléchargé les photos ?\nAvez vous positionné votre logement sur la carte ?\n\nSi OUI cliquez sur OK !!\n\nSi NON cliquer sur Annuler et faite le nécessaire !!\n\nMerci');
	if (confirmation)
		window.location.replace(page);
}

//---------------------------------------------------------------------------
function confirm_ligne_autre_zone(page) {
	confirmation = confirm('Avez vous téléchargé les photos ?\n\nSi OUI cliquez sur OK !!\n\nSi NON cliquer sur Annuler et faite le nécessaire !!\n\nMerci');
	if (confirmation)
		window.location.replace(page);
}