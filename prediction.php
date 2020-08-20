<?php

	function standard_deviation($ar, $doff=1)
	{
		$nobs = count($ar);

		if($nobs <= 1)
			return 0;

		$mu = array_sum($ar) / $nobs; 
		$dif = array();
		foreach ($ar as $value) {
			array_push($dif, pow($value - $mu,2));
		}
		$r= sqrt(array_sum($dif) / ($nobs - $doff));
	    return $r;
	}

	function prediction($ar)
	{
		$nobs = count($ar);

		if($nobs == 0) {
			return 7;
		} else {
			$mu = array_sum($ar) / $nobs; 
			$r = standard_deviation($ar) + $mu;

		if($r <= 0) $r = 7;

	    return $r;
		}

		
	}
	
?>
