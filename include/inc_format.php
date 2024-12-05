<?PHP
//-----------------------------------------------------------------------
function to_str_ard($ard) {

  if      ( $ard == 1 ) $str_ard = "&nbsp;${ard}&nbsp;er&nbsp;&nbsp;";
	else if ( $ard < 10 ) $str_ard = "&nbsp;${ard}&nbsp;ième";
	else                  $str_ard = "${ard}&nbsp;ième";
  return  $str_ard;

}
//-----------------------------------------------------------------------
function format_telephone($telephone) {

  $tel_1 = substr($telephone,0,2);
  $tel_2 = substr($telephone,2,2);
  $tel_3 = substr($telephone,4,2);
  $tel_4 = substr($telephone,6,2);
  $tel_5 = substr($telephone,8,2);

  return $tel_1."-".$tel_2."-".$tel_3."-".$tel_4."-".$tel_5 ;
}
//-----------------------------------------------------------------------
function format_prix($prix) {

	$last = strlen($prix) - 1;

  $format = '';
	$ip = 0;
	for ( $i = $last ; $i >= 0 ; $i-- ) {
		$char = substr($prix,$i,1);
		$format = $char.$format;
	  $ip++;
		// Tout les trois caractères on isère un point
    if ( $ip == 3 && $i != 0 ) { $format = ".".$format; $ip = 0 ;}
	} 
	return($format);

}
//-----------------------------------------------------------------------
function to_date($a_datetime) {
  return substr($a_datetime,0,10);
}
//-----------------------------------------------------------------------
function to_datm($a_datetime) {
  $hi_y = substr($a_datetime,0,4);
  $hi_m = substr($a_datetime,5,2);
  $hi_j = substr($a_datetime,8,2);
  
  switch ($hi_m) {
  case '01' : $hi_mm = 'Jan'; break;
  case '02' : $hi_mm = 'Fev'; break;
  case '03' : $hi_mm = 'Mar'; break;
  case '04' : $hi_mm = 'Avr'; break;
  case '05' : $hi_mm = 'Mai'; break;
  case '06' : $hi_mm = 'Jun'; break;
  case '07' : $hi_mm = 'Jui'; break;
  case '08' : $hi_mm = 'Aou'; break;
  case '09' : $hi_mm = 'Sep'; break;
  case '10' : $hi_mm = 'Oct'; break;
  case '11' : $hi_mm = 'Nov'; break;
  case '12' : $hi_mm = 'Dec'; break;
  }
  
  return ($hi_j.'-'.$hi_mm.'-'.$hi_y);

}
//-----------------------------------------------------------------------
function to_full_dat($a_datetime) {
  $hi_y = substr($a_datetime,0,4);
  $hi_m = substr($a_datetime,5,2);
  $hi_j = substr($a_datetime,8,2);
  
  switch ($hi_m) {
  case '01' : $hi_mm = 'Janvier'; break;
  case '02' : $hi_mm = 'Févier'; break;
  case '03' : $hi_mm = 'Mars'; break;
  case '04' : $hi_mm = 'Avril'; break;
  case '05' : $hi_mm = 'Mai'; break;
  case '06' : $hi_mm = 'Juin'; break;
  case '07' : $hi_mm = 'Juillet'; break;
  case '08' : $hi_mm = 'Août'; break;
  case '09' : $hi_mm = 'Septembre'; break;
  case '10' : $hi_mm = 'Octobre'; break;
  case '11' : $hi_mm = 'Novembre'; break;
  case '12' : $hi_mm = 'Décembre'; break;
  }
  
  return ($hi_j.'-'.$hi_mm.'-'.$hi_y);

}


function format_ard($ard) {
  if      ( $ard == 0 ) return ""; 
  else if ( $ard == 1 ) return "1 er Ard"; 
  else if ( $ard <= 20 ) return "$ard ième Ard"; 
}
function format_domaine($email) {

  $pos = strpos($email,'@');
	$lgr = strlen($email);
	
	//echo "pos=$pos<br/>";
	//echo "lgr=$lgr<br/>";
	
	$domaine = substr($email,$pos,$lgr);
	
	return($domaine);

}
//--------------------------------------------------------------------
// Récupére la chaîne pour afficher le nom d'un produit.
// La valeur de typp en argument est la valeur numérique correspondant au produit 
function typp_from_num_to_str($typp) {
  if ( $typp == VAL_NUM_TOUS_PRODUITS  ) return VAL_STR_TOUS_PRODUITS;
  if ( $typp == VAL_NUM_APPARTEMENT    ) return VAL_STR_APPARTEMENT;
	if ( $typp == VAL_NUM_PAVILLON       ) return VAL_STR_PAVILLON;
	if ( $typp == VAL_NUM_LOFT           ) return VAL_STR_LOFT;
	if ( $typp == VAL_NUM_VILLA          ) return VAL_STR_VILLA;
	if ( $typp == VAL_NUM_MAISON_VILLAGE ) return VAL_STR_MAISON_VILLAGE;
	if ( $typp == VAL_NUM_CHALET         ) return VAL_STR_CHALET;
	if ( $typp == VAL_NUM_RIAD           ) return VAL_STR_RIAD;
	if ( $typp == VAL_NUM_MAISON         ) return VAL_STR_MAISON;

}
//--------------------------------------------------------------------
function typp_from_dtb_to_str($typp) {
  if ( $typp == VAL_DTB_APPARTEMENT    ) return VAL_STR_APPARTEMENT;
	if ( $typp == VAL_DTB_PAVILLON       ) return VAL_STR_PAVILLON;
	if ( $typp == VAL_DTB_LOFT           ) return VAL_STR_LOFT;
	if ( $typp == VAL_DTB_VILLA          ) return VAL_STR_VILLA;
	if ( $typp == VAL_DTB_MAISON_VILLAGE ) return VAL_STR_MAISON_VILLAGE;
	if ( $typp == VAL_DTB_CHALET         ) return VAL_STR_CHALET;
	if ( $typp == VAL_DTB_RIAD           ) return VAL_STR_RIAD;
	if ( $typp == VAL_DTB_MAISON         ) return VAL_STR_MAISON;
}
//--------------------------------------------------------------------
function typp_from_dtb_to_num($typp) {
  if ( $typp ==  VAL_DTB_APPARTEMENT    ) return VAL_NUM_APPARTEMENT;
	if ( $typp ==  VAL_DTB_PAVILLON       ) return VAL_NUM_PAVILLON;
	if ( $typp ==  VAL_DTB_LOFT           ) return VAL_NUM_LOFT;
	if ( $typp ==  VAL_DTB_VILLA          ) return VAL_NUM_VILLA;
	if ( $typp ==  VAL_DTB_MAISON_VILLAGE ) return VAL_NUM_MAISON_VILLAGE;
	if ( $typp ==  VAL_DTB_CHALET         ) return VAL_NUM_CHALET;
	if ( $typp ==  VAL_DTB_RIAD           ) return VAL_NUM_RIAD;
	if ( $typp ==  VAL_DTB_MAISON         ) return VAL_NUM_MAISON;
}
//--------------------------------------------------------------------
// Récupére la valeur des index des différents select
// La valeur de typp en argument est sa valeur numérique utilisée dans la session 
function typp_from_num_to_selectedIndex($typp,$zone) {

  if ( $zone == 'paris' || $zone == 'region' ) {
	  if ( $typp == VAL_NUM_APPARTEMENT ) return 1;
	  if ( $typp == VAL_NUM_MAISON      ) return 2;
	  if ( $typp == VAL_NUM_LOFT        ) return 3;
	}

  if ( $zone == 'france' ) {
	  if ( $typp == VAL_NUM_APPARTEMENT    ) return 1;
	  if ( $typp == VAL_NUM_MAISON         ) return 2;
	  if ( $typp == VAL_NUM_LOFT           ) return 3;
	  if ( $typp == VAL_NUM_CHALET         ) return 4;
	}

  if ( $zone == 'domtom' ) {
	  if ( $typp == VAL_NUM_APPARTEMENT    ) return 1;
	  if ( $typp == VAL_NUM_MAISON         ) return 2;
	  if ( $typp == VAL_NUM_LOFT           ) return 3;
	}

  if ( $zone == 'etranger' ) {
	  if ( $typp == VAL_NUM_APPARTEMENT    ) return 1;
	  if ( $typp == VAL_NUM_MAISON         ) return 2;
	  if ( $typp == VAL_NUM_LOFT           ) return 3;
	  if ( $typp == VAL_NUM_CHALET         ) return 4;
	}

}
//--------------------------------------------------------------------
// Récupére la valeur des index des différents select
function zone_dom_to_selectedIndex($zone_dom) {

  if ( $zone_dom == 'Guadeloupe'               ) return 1;
  if ( $zone_dom == 'Martinique'               ) return 2;
  if ( $zone_dom == 'Guyane'                   ) return 3;
  if ( $zone_dom == 'La Reunion'               ) return 4;
  if ( $zone_dom == 'Saint-Pierre-et-Miquelon' ) return 5;
  if ( $zone_dom == 'Mayotte'                  ) return 6;
  if ( $zone_dom == 'Wallis et Futuna'         ) return 7;
  if ( $zone_dom == 'Polynesie Française'      ) return 8;
  if ( $zone_dom == 'Nouvelle-Caledonie'       ) return 9;

}
//--------------------------------------------------------------------
// Retourne vrai si un champ n'est pas vide et false sinon 
function est_vide($champ) {

  if ( trim(empty($champ)) == '' ) return true;
	else return false;
}
//--------------------------------------------------------------------
// Retourne vrai si le champ est trop long
function est_trop_long($champ,$ln_max) {

  $ln_champ = strlen($champ);

  if ( $ln_champ > $ln_max ) return true;
	else return false;
}
?>