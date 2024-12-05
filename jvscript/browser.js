//Classe de définition de Browser
function Browser() {

  //Détection de la  plate forme
  if ( navigator.appVersion.indexOf('Win') != -1 )
    this.win = true;
  if ( navigator.appVersion.indexOf('Mac') != -1 )
    this.mac = true;
  if ( navigator.userAgent.indexOf('Linux') != -1 )
    this.linux = true;

  //La plate forme en chaîne de caractères
  if ( this.win )
    this.plateForme = 'Windows';
  if ( this.mac )
    this.plateForme = 'Macintosh';
  if ( this.linux )
    this.plateForme = 'Linux';

  //window.alert(this.plateForme);

  //Détection du navigateur
  if (navigator.userAgent.indexOf('Opera')!=-1)
    this.opera = true;
  if (navigator.userAgent.indexOf('Konqueror')!=-1)
    this.konqueror = true;
  if (navigator.userAgent.indexOf('Safari')!=-1)
    this.safari = true;
  if (navigator.userAgent.indexOf('Firefox/1.0')!=-1)
    this.ff10 = true;
  if (navigator.userAgent.indexOf('Firefox/1.5')!=-1)
    this.ff15 = true;
  if (navigator.userAgent.indexOf('Netscape/7.0')!=-1)
    this.netscape = true;
  if (navigator.userAgent.indexOf('MSIE 7')!=-1)
    this.ie7 = true;
  if (navigator.userAgent.indexOf('MSIE 6')!=-1)
    this.ie6 = true;

  //Le navigateur en chaîne de caractères
  if ( this.opera )
    this.navigateur = 'Opera';
  if ( this.konqueror )
    this.navigateur = 'Konqueror';
  if ( this.safari )
    this.navigateur = 'Safari';
  if ( this.ff10 || this.ff15 )
    this.navigateur = 'Firefox';
  if ( this.ie7 || this.ie6 )
    this.navigateur = 'Internet Explorer';
  if ( !this.navigateur )
    this.navigateur = 'inconnu';

  //window.alert(this.navigateur);

  //Instancier une nouvelle requête AJAX
	this.getHttpObject = function() {
	if ( this.ie6 || this.ie7 )
	  return new ActiveXObject('Microsoft.XMLHTTP');
	else
	  return new XMLHttpRequest();
	}
 
	//Fonction qui affecte une opacité
	this.setOpacity = function(el, valeur) {
	  //Sous IE
	  if ( this.ie7 || this.ie6 ) {
	    var op = parseInt(valeur*100);
	    el.style.filter = 'alpha(opacity='+op+')';
	  }
	  //Sous les autres navigateurs
	  else {
	    el.style.opacity = valeur;
	  }
	}

	//Affecte une image de fond à un élément
	this.setBackground = function(elt, image, couleur) {
	  if ( this.ie6 ) {
	    elt.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\''+image+'\',sizingMethod=\'image\')';
	    elt.style.backgroundColor = couleur;
	  }
	  else //Sous Firefox et IE7
	    elt.style.background = 'url('+image+') '+couleur;
	}

	//Affecte une taille visuelle à un élément
	this.setWidth = function(elt, valeur) {
	  if ( this.ie6 || this.ie7 )
	    elt.style.width = valeur + 'px';
	  else {
	    //Sous Firefox, on doit récupérer la bordure
	    var b = parseInt(elt.style.border||0);
	    //Et le padding
	    var p = parseInt(elt.style.padding||0);
	    //Pour les soustraire à la taille réelle
	    elt.style.width = (valeur-2*(b+p)) + 'px';
	  }
	}

}
