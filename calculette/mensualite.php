<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?PHP

$Capital = 1000000.0;
$NbAn = 10;
$TxAn = 0.04;

$Echeance = calcul_mensualite($Capital,$NbAn,$TxAn);


/*-----------------------------------------------------------------
/*---*/ 
function calcul_mensualite($Capital,$NbAn,$TxAn) {

  // Le nombre d'�ch�ances par an
  $EchAn = 12.0;
	
  // Calcul du Taux Periodique
	$TxPer = $TxAn / $EchAn ;

	echo "TxPer => $TxPer<br>";
	
	// Le Nombre d'�chance total
	$NbEch = $EchAn * $NbAn ;
	
	echo "NbEch => $NbEch<br>";
	
	// Caucul interm�diare de la puissance
	$PxPer = pow(( 1.0 + $TxPer ),$NbEch);

	echo "PxPer => $PxPer<br>";

	
	$Echeance = ( $Capital * $TxPer * $PxPer ) / ( $PxPer - 1.0 ); 

  echo "$Echeance<br>";


  return($Echeance);

}

?>
</body>
</html>
