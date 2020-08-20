<?php

	float function calculMontan($idDistributeur, $valeur)
	{
		$tranche_array = array();
		$sql_query_tranches = "SELECT seuiltranche, valtranche FROM tranche WHERE distributeur = ".$idDistributeur." ORDER BY seuiltranche ASC";
		$result_set_tranches=mysql_query($sql_query_tranches);
		while($row=mysql_fetch_row($result_set_tranches))
		{
			$tranche_array[$row[0]] = $row[1];
		}

		foreach ($tranche_array as $key => $value){
		    
		}

		$r= 0;
	    return $r;
	}
	
?>
