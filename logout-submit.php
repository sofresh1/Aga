<?php 
	include_once 'security.php';

	/*** check if the users is already logged in ***/
	logout();

	header("Location: index.php");
?>