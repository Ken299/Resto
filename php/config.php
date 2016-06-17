<?php
	$servername = "localhost";
	$server_username = "if13";
	$server_password = "ifikad";
	$database = "if13_leetussa";
	$yhendus=new mysqli($servername, $server_username, $server_password, $database);
	
	if($yhendus === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>