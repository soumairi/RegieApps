<?php
function convertir($Montant)
{
	$grade = array(0 => "zero ",1=>" MILLIARDS ",2=>" MILLIONS ",3=>" MILLE ");
	$Mon = array(0=>" Dhs",1=>" Dhs",2=>" Cts",3=>" Cts");

	// Mise au format pour les chéques et le SWI
	$Montant = number_format($Montant,2,".","");

	if ($Montant == 0)
	{
		$result = $grade[0].$Mon[0];
	}else
	{
		$result = "";

		// Calcule des Unités
		$montant = intval($Montant);

		// Calcul des centimes
		$centime = round(($Montant * 100) - ($montant * 100),0);

		// Traitement pour les Milliards
		$nombre = $montant / 1000000000;
		$nombre = intval($nombre);
		if ($nombre > 0)
		{
			if ($nombre > 1)
			{
				$result = $result.cenvtir($nombre).$grade[1];
			}else
			{
				$result = $result." UN ".$grade[1];
				$result = substr($result,0,13)." ";
			}
			$montant = $montant - ($nombre * 1000000000);
		}

		// Traitement pour les Millions
		$nombre = $montant / 1000000;
		$nombre = intval($nombre);
		if ($nombre > 0)
		{
			if ($nombre > 1)
			{
				$result = $result.cenvtir($nombre).$grade[2];
			}else
			{
				$result = $result." UN ".$grade[2];
				$result = substr($result,0,12)." ";
			}
			$montant = $montant - ($nombre * 1000000);
		}

		// Traitement pour les Milliers
		$nombre = $montant / 1000;
		$nombre = intval($nombre);
		if ($nombre > 0)
		{
			if ($nombre > 1)
			{
				$result = $result.cenvtir($nombre).$grade[3];
			}else
			{
				$result = $result.$grade[3];
			}
			$montant = $montant - ($nombre * 1000);
		}

		// Traitement pour les Centaines & centimes
		$nombre = $montant;
		if ($nombre>0)
		{
			$result = $result.cenvtir($nombre);
		}
		// Traitement si le montant = 1
		if ((substr($result,0,7) == " et UN " and strlen($result) == 7))
		{
			$result = substr($result,3,3);
			$result = $result.$Mon[0];
			if (intval($centime) != 0)
			{
				$differ = cenvtir(intval($centime));
				if (substr($differ,0,7) == " et UN ")
				{
					if ($result == "")
					{
						$differ = substr($differ,3);
					}
					$result = $result." ".$differ.$Mon[2];
				}else
				{
					$result = $result." et ".$differ.$Mon[3];
				}
			}
			// Traitement si le montant > 1 ou = 0
		}else
		{
			if ($result != "")
			{
				$result = $result.$Mon[1];
			}
			if (intval($centime) != 0)
			{
				$differ = cenvtir(intval($centime));
				if (substr($differ,0,7) == " et UN ")
				{
					if ($result == "")
					{
						$differ = substr($differ,3);
					}
					$result = $result." ".$differ.$Mon[2];
				}else
				{
					if ($result != "")
					{
						$result = $result." et ".$differ.$Mon[3];
					}else
					{
						$result = $differ.$Mon[3];
					}
				}
			}
		}
	}
	return $result;
}

// fonction de convertion d'un chiffre à 3 digits en lettre
function cenvtir($Valeur)
{

	$code = "";
	//texte en clair
	$SUnit = array(1=>" et UN ", 2=>" DEUX ", 3=>" TROIS ", 4=>" QUATRE ", 5=>" CINQ ", 6=>" SIX ", 7=>" SEPT ", 8=>" HUIT ", 9=>" NEUF ", 10=>" DIX ", 11=>" ONZE ", 12=>" DOUZE ", 13=>" TREIZE ", 14=>" QUATORZE ", 15=>"QUINZE ", 16=>"SEIZE ", 17=>"DIX-SEPT ", 18=>"DIX-HUIT ", 19=>"DIX_NEUF ");
	$sDiz = array(20=> " VINGT ", 30=> " TRENTE ", 40=>" QUARANTE ", 50=>" CINQUANTE ", 60=>" SOIXANTE ", 70=>" SOIXANTE ", 80=>" QUATRE VINGT ", 90=>" QUATRE VINGT ");

	if ($Valeur>99)
	{
		$N1= intval($Valeur/100);
		if ($N1>1)
		{
			$code = $code.$SUnit[$N1];
		}
		$Valeur = $Valeur - ($N1*100);
		if ($code != "")
		{
			if ($Valeur == 0)
			{
				$code = $code." CENTS ";
			}else
			{
				$code = $code." CENT ";
			}
		}else
		{
			$code = " CENT ";
		}
	}
	if ($Valeur != 0)
	{
		if ($Valeur > 19)
		{
			$N1 = intval($Valeur/10)*10;
			$code = $code.$sDiz[$N1];
			if (($Valeur>=70) and(($Valeur<80)or($Valeur>=90)))
			{
				$Valeur = $Valeur + 10;
			}
			$Valeur = $Valeur - $N1;
		}
		if ($Valeur > 0)
		{
			$code = $code." ".$SUnit[$Valeur];
		}
	}
	return $code;
}
//echo convertir(1000000.01);
?>