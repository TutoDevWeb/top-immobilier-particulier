function Estate() {

  var coord  = '';
  var filter = '';
  var zone_arg = '';

  //-----------------------------------------------------------------------------------
  // Mise à jour de l'ensemble des zones
  this.update = function () {
    update_coord();
    update_filter();
    update_zone_arg();
    get_nb_ano_total();
    get_nb_ano_select();
    get_list();
  }
  //-----------------------------------------------------------------------------------
  // Mise à jour des paramètres qui concernent les coordonnées
  function update_coord () {

    // Paramètres de la carte
    var bounds = map.getBounds();
    var ne_lat = bounds.getNorthEast().lat();
    var ne_lng = bounds.getNorthEast().lng();
    var sw_lat = bounds.getSouthWest().lat();
    var sw_lng = bounds.getSouthWest().lng();
    
    coord  = 'ne_lat='+ne_lat+'&ne_lng='+ne_lng+'&sw_lat='+sw_lat+'&sw_lng='+sw_lng;

  }
  //-----------------------------------------------------------------------------------
  // Mise à jour des paramètres qui concernent le filtrage
  function update_filter () {

    // Valeurs sur les filtres
    var typp = document.getElementById('typp').value;
    var P1   = document.getElementById('P1').checked ? 1 : 0 ;
    var P2   = document.getElementById('P2').checked ? 2 : 0 ;
    var P3   = document.getElementById('P3').checked ? 3 : 0 ;
    var P4   = document.getElementById('P4').checked ? 4 : 0 ;
    var P5   = document.getElementById('P5').checked ? 5 : 0 ;
    var sur_min  = document.getElementById('sur_min').value;
    var prix_max = document.getElementById('prix_max').value;

    filter = 'typp='+typp+'&P1='+P1+'&P2='+P2+'&P3='+P3+'&P4='+P4+'&P5='+P5+'&sur_min='+sur_min+'&prix_max='+prix_max;

  }
  //-----------------------------------------------------------------------------------
  // Mise à jour des paramètres qui concernent la zone
  function update_zone_arg() {

    // Valeurs sur la zone
    var zone         = document.getElementById('zone').value;
    var zone_pays    = document.getElementById('zone_pays').value;
    var zone_dom     = document.getElementById('zone_dom').value;
    var zone_region  = document.getElementById('zone_region').value;
    var zone_dept    = document.getElementById('zone_dept').value;
    var zone_ville   = document.getElementById('zone_ville').value;
    var zone_ard     = document.getElementById('zone_ard').value;
    var dept_voisin  = document.getElementById('dept_voisin').value;

    zone_arg = 'zone='+zone+'&zone_pays='+zone_pays+'&zone_dom='+zone_dom+'&zone_region='+zone_region+'&zone_dept='+zone_dept+'&zone_ville='+zone_ville+'&zone_ard='+zone_ard+'&dept_voisin='+dept_voisin;

    //window.alert(zone_arg);

  }
  //-----------------------------------------------------------------------------------
  // Retourne le nombre d'annonce sur la carte en fonction des limites et du filtrage
  function get_nb_ano_select () {

    document.getElementById('nbr_ano_select').innerHTML = '<p><img src="/images/ajax-loader.gif" width="" height="" alt="" /></p>' ;
    var xhr = browser.getHttpObject() ; 
    xhr.onreadystatechange  = function() { 
      if ( xhr.readyState  == 4 ) {
        if ( xhr.status  == 200 ) {
          document.getElementById('nbr_ano_select').innerHTML = xhr.responseText;
        }
      }
    }

    xhr.open("POST","/cons/recherche-carte-ajax.php",true); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xhr.send('action=get_nb_ano_select&'+coord+'&'+filter); 
  }
 
  //-----------------------------------------------------------------------------------
  // Retourne le nombre d'annonce sur la carte en fonction des limites et du filtrage
  function get_nb_ano_total() {

    document.getElementById('nbr_ano_total').innerHTML = '<p><img src="/images/ajax-loader.gif" width="" height="" alt="" /></p>' ;
    var xhr = browser.getHttpObject() ; 
    xhr.onreadystatechange  = function() { 
      if ( xhr.readyState  == 4 ) {
        if ( xhr.status  == 200 ) {
          document.getElementById('nbr_ano_total').innerHTML = xhr.responseText;
        }
      }
    }

    xhr.open("POST","/cons/recherche-carte-ajax.php",true); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xhr.send('action=get_nb_ano_total&'+coord); 
  }
  //------------------------------------------------------------------------------------------------
  function get_list () {

    var xhr = browser.getHttpObject() ; 
    xhr.onreadystatechange  = function() { 
      if ( xhr.readyState  == 4 ) {
        if ( xhr.status  == 200 ) {

          //console.log(xhr.responseText);
          var estateList = eval ('('+xhr.responseText+')');

          if ( estateList.length < 300 ) {

            // On parcours la liste des annonces à afficher
            for ( var i = 0 ; i < estateList.length ; i++ ) {

              // Index de l'annonce
              var ida = parseInt(estateList[i].ida);           
              //console.log("Traiter annonce => ida "+ida); 
              // Ici on a besoin de savoir si le marker existe
              if ( !markerExisting(ida) ) {
              
                //console.log("Creation de marker => ida "+ida); 
                markerList[ida] = createMarker(estateList[i]); 
                //console.log("Creation marqueur + overlay : "+ida);
                map.addOverlay(markerList[ida]);

              }
            }

            // On parcours la nouvelle table des marqueurs
            for ( var idm in markerList ) {
              var do_remove = true;
              for ( var i = 0 ; i < estateList.length ; i++ )
                if ( idm == parseInt(estateList[i].ida) ) do_remove = false;

              if ( do_remove ) {
                map.removeOverlay(markerList[idm]);
                delete markerList[idm];
                //console.log("Suppression marker + overlay : "+idm);
              }
            }
          
            compute_stat(estateList);

          } // Fin si estate list         
          //console.log("------------------Fin Get_estate_list-----------------"); 
        } else window.alert(xhr.status); 
      }
    }

    xhr.open("POST","/cons/recherche-carte-ajax.php",true); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xhr.send('action=get_estate_list&'+coord+'&'+filter); 
  }
  //------------------------------------------------------------------------------------------------
  this.backList = function () {

    window.location.href = '/cons/recherche-liste.php?'+zone_arg+'&'+filter;

  }
  //------------------------------------------------------------------------------------------------
  this.to_details = function (tel_ins) {
    window.location.href = '/cons/details.php?from=carte&tel_ins='+tel_ins+'&'+zone_arg+'&'+filter;
  }
  //------------------------------------------------------------------------------------------------
  function compute_stat(estateList) {

    var prix_moyen = 0.0;
    var surf_moyen = 0.0;
    var prix_carre = 0.0;
    var nb = 0;
     
    for ( var i = 0 ; i < estateList.length ; i++ ) {

      prix_moyen += parseFloat(estateList[i].prix);  
      surf_moyen += parseFloat(estateList[i].surf);      
      nb++;
    }  
    
    if ( nb != 0 ) {
    
      prix_moyen = prix_moyen / nb ;
      surf_moyen = surf_moyen / nb ;
      prix_carre = Math.round(prix_moyen / surf_moyen) ;
      prix_moyen = Math.round(prix_moyen);
      surf_moyen = Math.round(surf_moyen);
      //console.log('prix_moyen => '+prix_moyen+' surf_moyen => '+surf_moyen+' prix_carre => '+prix_carre);

      str_prix_moyen = 'Prix moyen : '+prix_moyen+' €<br/>' ;
      str_surf_moyen = 'Surface Moyenne : '+surf_moyen+' m²<br/>';
      str_prix_carre = 'Prix au m² : '+prix_carre+' €/m²';
    
      document.getElementById('stat_filtrage').innerHTML = str_prix_moyen+str_surf_moyen+str_prix_carre;
    } else document.getElementById('stat_filtrage').innerHTML = 'Pas de sélection';

  }
  //------------------------------------------------------------------------------------------------
  function createMarker(arg) {

    //console.log("Create Marker ida => "+arg.ida);

    var icon_maison = new GIcon();
    icon_maison.image = "/images/map_maison.gif";
    icon_maison.iconSize = new GSize(18,18);
    icon_maison.iconAnchor = new GPoint(9,9);
    icon_maison.infoWindowAnchor = new GPoint(20, 0);

    var icon_appart = new GIcon();
    icon_appart.image = "/images/map_appart.gif";
    icon_appart.iconSize = new GSize(18,18);
    icon_appart.iconAnchor = new GPoint(9,9);
    icon_appart.infoWindowAnchor = new GPoint(20, 0);

    var icon_loft = new GIcon();
    icon_loft.image = "/images/map_loft.gif";
    icon_loft.iconSize = new GSize(18,18);
    icon_loft.iconAnchor = new GPoint(9,9);
    icon_loft.infoWindowAnchor = new GPoint(20, 0);

    if ( arg.typp == 'maison'      ) var marker_options = icon_maison;
    if ( arg.typp == 'chalet'      ) var marker_options = icon_maison;
    if ( arg.typp == 'appartement' ) var marker_options = icon_appart;
    if ( arg.typp == 'loft'        ) var marker_options = icon_loft;

    var point = new GLatLng(arg.lat,arg.lng);
    var marker = new GMarker(point,marker_options);
    GEvent.addListener(marker,"click", function() {
      var myHtml = "<div class='infoMarker'>"+show_annonce(arg.tel_ins,arg.typp,arg.nbpi,arg.zone_ville,arg.zone_ard,arg.num_dept,arg.quart,arg.prix,arg.surf,arg.blabla)+go_ville(arg.zone_dept,arg.zone_ville)+"</div>";
      map.openInfoWindowHtml(point, myHtml);
    });
    return marker;
  }
  //------------------------------------------------------------------------------------------------
  function markerExisting(ida) {

    for ( var idm in markerList )
      if ( ida == idm ) return true;
    return false;

  }
  //------------------------------------------------------------------------------------------------
  function show_annonce(tel_ins,typp,nbpi,ville,ard,num_dept,quart,prix,surf,blabla) {

    var str_piece = (nbpi == 1) ? " pièce" : " pièces"; 
    
    var info = "<div class='infoAnnonce'>";

    info += "<table width='100%' border='0' cellspacing='3' cellpadding='0'>";
    info += "<tr><td colspan='2' ><a class='navsearch12' href='#' onclick=\"estate.to_details('"+tel_ins+"');\">"+typp+" de "+nbpi+str_piece+"</a></td></tr>";
    info += "<tr><td colspan='2' class='cell_dotted'></td></tr>";

    if ( parseInt(ard) == 0 )
      info += "<tr><td class='cell_left'>"+ville+" - "+num_dept+"</td><td class='cell_right'>"+prix+" Euros</td></tr>";
		else 	
      info += "<tr><td class='cell_left'>"+ville+" - "+ard+"</td><td class='cell_right'>"+prix+" Euros</td></tr>";

    info += "<tr><td class='cell_left'>"+quart+"</td><td class='cell_right'>"+surf+" m²</td></tr>";
    info += "<tr><td colspan='2' class='cell_dotted'></td></tr>";
    info += "<tr><td colspan='2' class='cell_justify'>"+blabla+"</td></tr>";
    info += "</table>";
    info += "</div>"

    return info;

  }
  //------------------------------------------------------------------------------------------------
  function go_ville(zone_dept,zone_ville) {

    var zone_ville_selected   = document.getElementById('zone_ville').value;
    if ( zone_ville_selected != zone_ville )
    var info = "<div class='infoNav'><img src='/images/arrow5.gif' /><a href='#' class='navsearch11' onclick=\"switchzone.ville('"+escape(zone_dept)+"','"+escape(zone_ville)+"');\">Aller sur "+zone_ville+"</a></div>";
    else
      var info ="";

    return info;

  }

}