<?php
	require_once('php/config.php');
	require_once('php/User.class.php');
	
	session_start();
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	mysqli_set_charset($mysqli, "utf8");
	//Uus instants klassist User
	$User = new User($mysqli);
?>