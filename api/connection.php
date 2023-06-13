<?php
	error_reporting(1);

	$servername = "localhost";
	// REPLACE with your Database name
	$dbname = "id19694182_protadata";
	// REPLACE with Database user
	$username = "id19694182_schinqy";
	// REPLACE with Database user password
	$password = "PUTTYOURS";


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	echo "";

?>
