<?php

function insertLog($user,$usertype,  $message)
{

	$date = date("d-m-Y");
	$date_time = date("Y/m/d h:i:sa");
	$file_name = "log/log_$date.txt";
	if(file_exists($file_name) != 1)
	{
		//create file if not exist
		$file_contents = fopen($file_name, "w");
		fclose($file_contents);
	}
	$data = "$date_time - $user ($usertype) : $message  \n";
	
	$output = print_r(file_get_contents($file_name).$data, true);
	file_put_contents($file_name, $output);
}
?>