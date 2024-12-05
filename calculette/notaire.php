<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?PHP

if ( ( $frais = calcul_frais($prix=2230000.0) ) !== false ) echo "$frais<br>";
else echo "Hors Barème<br>";

function calcul_frais($prix) { 

  $prix_vente = array(50000.0,60000.0,70000.0,80000.0,90000.0,100000.0,200000.0,300000.0,400000.0,500000.0,600000.0,700000.0,800000.0,900000.0,1000000.0,1200000.0,1400000.0,1600000.0,1800000.0,2000000.0,2250000.0,2500000.0,2750000.0,3000000.0,3500000.0,4000000.0,4500000.0,5000000);
  $frais_notaire =array(4500.0,5200.0,5800.0,6400.0,7000.0,7600.0,13800.0,20000.0,26200.0,32300.0,38500.0,44700.0,50900.0,57000.0,63200.0,75600.0,87900.0,100300.0,112600.0,125000.0,140400.0,155900.0,171300.0,186800.0,217600.0,248500.0,279400.0,310300);

  if ( $prix < $prix_vente[0] ) return false;
  if ( $prix >= $prix_vente[count($prix_vente)-1] ) return false;

  /* Rechercher la tranche */
	for ( $i=0 ; $i < (count($prix_vente)-1) ; $i++ ) {
	
	  if ( $prix >= $prix_vente[$i] && $prix < $prix_vente[$i+1] ) {
		
		  $prix_a = $prix_vente[$i];
			$prix_b = $prix_vente[$i+1];

		  $frais_a = $frais_notaire[$i];
			$frais_b = $frais_notaire[$i+1];

      break; 
		
		}
	
	}

  echo "prix_a => $prix_a<br>";
  echo "prix_b => $prix_b<br>";
  echo "frais_a => $frais_a<br>";
  echo "frais_b => $frais_b<br>";

  // On fait une interpol linéaire
	$A = ( $frais_a - $frais_b ) / ( $prix_a - $prix_b );
  $B = $frais_a - ( $A * $prix_a ) ;
	
	$frais = ( $A * $prix ) + $B;

  echo "A => $A<br>";
  echo "B => $B<br>";
  echo "frais => $frais<br>";
	
	return $frais;

}

?>
</body>
</html>
