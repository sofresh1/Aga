<?php 
	include_once 'security.php';

	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	/*** check if the users is already logged in ***/
	if(login())
	{
	    header("Location: index.php");
    	exit;
	} else {
		header("Location: login.php");
    exit;
	}
?>