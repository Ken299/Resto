<?php
	require_once('config.php');
	require_once('User.class.php');
	
	session_start();
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	mysqli_set_charset($mysqli, "utf8");
	//Uus instants klassist User
	$User = new User($mysqli);
?>