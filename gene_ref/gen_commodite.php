<?PHP
//-----------------------------------------------------------------------
// Fabrique la partie commoditées pour appartement et studio
function make_commodite() {

  $T_commodite = array(" Proche commodité,"," Proche toutes commodités,"," Commodités sur place,"," Sur place "," Proximité "," Proche ");
  $ind_num = mt_rand(0,count($T_commodite)-1);
  $str_commodite = $T_commodite[$ind_num];

  $T_commodite_ecole = array(""," écoles,"," ecole, college,"," écoles, lycée,"); 
  $ind_num = mt_rand(0,count($T_commodite_ecole)-1);
  $str_commodite_ecole = $T_commodite_ecole[$ind_num];

  $T_commodite_commerce = array(""," commerces,"," zone commerciale,"," tous commerces,"," grande surface,"," centre commercial,");
  $ind_num = mt_rand(0,count($T_commodite_commerce)-1);
  $str_commodite_commerce = $T_commodite_commerce[$ind_num];

  $T_commodite_divers = array(""," bus,"," tous transport,"," parc,"," espace vert,"," bus face immeuble,"," parc et jardin,"," bus au pied de la résidence,"," transports publics,");
  $ind_num = mt_rand(0,count($T_commodite_divers)-1);
  $str_commodite_divers = $T_commodite_divers[$ind_num];

	$T_commodite_phrase = array();
	$str = ${str_commodite}.${str_commodite_ecole}.${str_commodite_commerce}.${str_commodite_divers};
	array_push($T_commodite_phrase,$str);
  $str = ${str_commodite}.${str_commodite_commerce}.${str_commodite_ecole}.${str_commodite_divers};
	array_push($T_commodite_phrase,$str);

  $ind_num = mt_rand(0,count($T_commodite_phrase)-1);
  $str = $T_commodite_phrase[$ind_num];

  $str = substr($str,0,-1).".";
  return $str;

}
?>