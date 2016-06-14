<?php
	$host = 'localhost';
	$db   = 'if13_mikkottis';
	$user = 'if13';
	$pass = 'ifikad';
	$charset = 'utf8';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$yhendus = new PDO($dsn, $user, $pass, $opt);