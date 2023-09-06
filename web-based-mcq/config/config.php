<?php 
	session_start();
	
	

	$host = "localhost";
	$user = "root";
	$pass = "";
	$schema = "web_based_mcq";
	
	// connect to database
	$conn = mysqli_connect($host, $user, $pass, $schema);


	if (!$conn) 
	{
		die("Error connecting to database: " . mysqli_connect_error());
	}

	define('DOCUMENT_PATH', './documents');

	define('QUIZ_TYPES', array("beginner", "normal", "hard", "extreme", "legendary"));
?>