<?php
	$baasiaadress="localhost";
	$baasikasutaja="if13";
	$baasiparool="ifikad";
	$baasinimi="if13_mikkottis";
	$yhendus=new mysqli($baasiaadress, $baasikasutaja, $baasiparool, $baasinimi);
	
	if($yhendus === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}