<?php
	require_once("pdo_conf.php");	
	
	// Gets the amount of posts in the table
	$stmt = $yhendus->query("SELECT COUNT(post_ID) as maxID FROM postitused");
	$stmt->execute();
	
	$postTotal = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo $postTotal['maxID'];
	
	$stmt->closeCursor();