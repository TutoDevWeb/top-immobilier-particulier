<?PHP
function print_cibleclick_120_600() {

  static $last_val=0;
  $nb_val = 8;

	//echo "last_val => $last_val<br/>";

  srand((double)microtime()*date("YmdGis")); 
  $val = rand(1,$nb_val);

  // Si on retire la même valeur on prend la suivante
	if ( $val == $last_val ) {
	  //echo "Les valeurs sont égales val => $val : last_val => $last_val<br/>";
		if ( $val == $nb_val ) $val = 1;
		else $val++;
	}

	//echo "Valeur choisie val => $val<br/>";

	$last_val = $val;


  switch($val) {
	case 1 : print_cible_opodo_offre_speciales_120_600();
	         break;
	case 2 : print_cible_opodo_auto_120_600();
	         break;
	case 3 : print_cible_opodo_croisieres_120_600();
	         break;
  case 4 : print_cible_opodo_location_vacances_120_600();
	         break;
  case 5 : print_cible_opodo_low_cost_120_600();
	         break;
  case 6 : print_cible_opodo_hotel_120_600();
	         break;
  case 7 : print_cible_opodo_hotel_londres_120_600();
	         break;
  case 8 : print_cible_opodo_hotel_paris_120_600();
	         break;

	}


}
function print_cible_opodo_auto_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b247&bnb=247" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=247" border="0" alt="Opodo" width="120" height="600" /></a><br />
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_2x_moins_cher_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4415&type=b30&bnb=30" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4415&b=30" border="0" alt="2xMoinsCher.com" width="120" height="600"/></a><br/>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_location_vacances_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b252&bnb=252" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=252" border="0" alt="Opodo" width="120" height="600"/></a><br/>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_low_cost_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b240&bnb=240" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=240" border="0" alt="Opodo" width="120" height="600"/></a><br/>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_hotel_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b230&bnb=230" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=230" border="0" alt="Opodo" width="120" height="600"/></a><br/>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_hotel_londres_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b232&bnb=232" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=232" border="0" alt="Opodo" width="120" height="600"/></a><br/>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_hotel_paris_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b233&bnb=233" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=233" border="0" alt="Opodo" width="120" height="600"/></a><br/>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_croisieres_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b236&bnb=236" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=236" border="0" alt="Opodo" width="120" height="600" /></a><br />
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_opodo_offre_speciales_120_600(){
?>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<script language="javascript" type="text/javascript" src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&type=html&hnb=101&js=1"></script>
<noscript><a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4388&type=b1&bnb=1" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4388&b=1" border="0"/></a><br /></noscript>
<!-- END PARTNER PROGRAM -->
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_cible_unifinance_300_250(){
?>
<div id='pub'>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4387&type=b12&bnb=12" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4387&b=12" border="0" alt="UNIFINANCE, Crédit et Rachat de Crédits" width="300" height="250"/></a><br/>
<!-- END PARTNER PROGRAM -->
</div>
<?PHP
}
/*-----------------------------------------------------------------------------------*/
function print_meilleur_taux_300_250(){
?>
<div id='pub'>
<!-- BEGIN PARTNER PROGRAM - DO NOT CHANGE THE PARAMETERS OF THE HYPERLINK -->
<a href="http://clic.reussissonsensemble.fr/click.asp?ref=356018&site=4493&type=b18&bnb=18" target="_blank">
<img src="http://banniere.reussissonsensemble.fr/view.asp?ref=356018&site=4493&b=18" border="0" alt="Meilleurtaux.com" width="300" height="250"/></a><br/>
<!-- END PARTNER PROGRAM -->
</div>
<?PHP
}
?>