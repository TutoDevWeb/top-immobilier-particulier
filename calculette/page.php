<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Document sans titre</title>
	<meta charset="UTF-8">
	<link href="/styles/global-body.css" rel="stylesheet" type="text/css" />
	<link href="/styles/global-deux-coln.css" rel="stylesheet" type="text/css" />
	<link href="/styles/styles-details.css" rel="stylesheet" type="text/css" />
	<link href="/styles/lib-ph.css" rel="stylesheet" type="text/css" />
</head>

<body>




	<?PHP

	isset($_REQUEST['action'])      ? $action      = trim($_REQUEST['action'])        : $action      = 'afficher';
	isset($_REQUEST['prix'])        ? $prix        = trim($_REQUEST['prix'])          : die;
	isset($_REQUEST['fixe'])        ? $fixe        = trim($_REQUEST['fixe'])          : $fixe        = '';
	isset($_REQUEST['apport'])      ? $apport      = trim($_REQUEST['apport'])        : $apport      = 0.0;
	isset($_REQUEST['credit'])      ? $credit      = trim($_REQUEST['credit'])        : $credit      = 0.0;
	isset($_REQUEST['nb_annee'])    ? $nb_annee    = (int)trim($_REQUEST['nb_annee']) : $nb_annee    = 0;
	isset($_REQUEST['taux_annuel']) ? $taux_annuel = trim($_REQUEST['taux_annuel'])   : $taux_annuel = 0.0;


	computer($action, $prix, $fixe, $apport, $credit, $nb_annee, $taux_annuel);

	function computer($action, $prix, $fixe, $apport, $credit, $nb_annee, $taux_annuel) {

		$frais_notaire = calcul_frais($prix);
		$montant_a_racquer =  $prix + $frais_notaire;

	?>
		<div id='computer'>
			<form method="get" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
				<div id='header'> <img src="../logo/sans-agences-120x60.gif" width="120" height="60" hspace="10" vspace="10" align="absmiddle">Calcul
					de votre financement </div>
				<div id='somme'>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>Prix de vente</td>
							<td><?PHP echo "$prix �"; ?><input type="hidden" name="prix" value="<?PHP echo "$prix"; ?>"></td>
						</tr>
						<tr>
							<td>Estimation des frais de notaire</td>
							<td><?PHP echo "$frais_notaire �"; ?></td>
						</tr>
						<tr>
							<td>Montant &agrave; financer</td>
							<td><?PHP echo "$montant_a_racquer �"; ?></td>
						</tr>
					</table>
				</div>
				<div id='switch'>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>Je fixe le montant de l'apport personnel</td>
							<td><input name="fixe" type="radio" value="apport" checked></td>
							<td><input name="apport" type="text" value="" size="10" maxlength="10"></td>
						</tr>
						<tr>
							<td>Je fixe le montant de mon cr&eacute;dit</td>
							<td><input type="radio" name="fixe" value="credit"></td>
							<td><input name="credit" type="text" value="" size="10" maxlength="10"></td>
						</tr>
					</table>
				</div>
				<div id='credit'>

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>Dur&eacute;e</td>
							<td>
								<select name="$nb_annee">
									<option value="5">5 Ans</option>
									<option value="10">10 Ans</option>
									<option value="15">15 Ans</option>
									<option value="20">20 Ans</option>
									<option value="25">25 Ans</option>
								</select>
							</td>
							<td rowspan="2"><input type='submit' value='Calculer'></td>
						</tr>
						<tr>
							<td>Taux</td>
							<td><input name='$taux_annuel' type='text' value='4.0' size="10" maxlength="10"> en %</td>
						</tr>
					</table>
				</div>
				<div id='resultats'>
					<p>Mensualit&eacute; de :</p>
					<p>Apport de :</p>
				</div>
			</form>
		</div>
	<?PHP
	}

	function calcul_frais($prix) {

		$prix_vente = array(50000.0, 60000.0, 70000.0, 80000.0, 90000.0, 100000.0, 200000.0, 300000.0, 400000.0, 500000.0, 600000.0, 700000.0, 800000.0, 900000.0, 1000000.0, 1200000.0, 1400000.0, 1600000.0, 1800000.0, 2000000.0, 2250000.0, 2500000.0, 2750000.0, 3000000.0, 3500000.0, 4000000.0, 4500000.0, 5000000);
		$frais_notaire = array(4500.0, 5200.0, 5800.0, 6400.0, 7000.0, 7600.0, 13800.0, 20000.0, 26200.0, 32300.0, 38500.0, 44700.0, 50900.0, 57000.0, 63200.0, 75600.0, 87900.0, 100300.0, 112600.0, 125000.0, 140400.0, 155900.0, 171300.0, 186800.0, 217600.0, 248500.0, 279400.0, 310300);

		if ($prix < $prix_vente[0]) return false;
		if ($prix >= $prix_vente[count($prix_vente) - 1]) return false;

		/* Rechercher la tranche */
		for ($i = 0; $i < (count($prix_vente) - 1); $i++) {

			if ($prix >= $prix_vente[$i] && $prix < $prix_vente[$i + 1]) {

				$prix_a = $prix_vente[$i];
				$prix_b = $prix_vente[$i + 1];

				$frais_a = $frais_notaire[$i];
				$frais_b = $frais_notaire[$i + 1];

				break;
			}
		}

		/*
  echo "prix_a => $prix_a<br>";
  echo "prix_b => $prix_b<br>";
  echo "frais_a => $frais_a<br>";
  echo "frais_b => $frais_b<br>";
  */

		// On fait une interpol lin�aire
		$A = ($frais_a - $frais_b) / ($prix_a - $prix_b);
		$B = $frais_a - ($A * $prix_a);

		$frais = ($A * $prix) + $B;

		/*
  echo "A => $A<br>";
  echo "B => $B<br>";
  echo "frais => $frais<br>";
	*/

		return $frais;
	}

	/*-----------------------------------------------------------------
/*---*/
	function calcul_mensualite($Capital, $NbAn, $TxAn) {

		// Le nombre d'�ch�ances par an
		$EchAn = 12.0;

		// Calcul du Taux Periodique
		$TxPer = $TxAn / $EchAn;

		echo "TxPer => $TxPer<br>";

		// Le Nombre d'�chance total
		$NbEch = $EchAn * $NbAn;

		echo "NbEch => $NbEch<br>";

		// Caucul interm�diare de la puissance
		$PxPer = pow((1.0 + $TxPer), $NbEch);

		echo "PxPer => $PxPer<br>";


		$Echeance = ($Capital * $TxPer * $PxPer) / ($PxPer - 1.0);

		echo "$Echeance<br>";


		return ($Echeance);
	}
	?>
</body>

</html>