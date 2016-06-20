<?php
	require_once("pdo_conf.php");	
	
	// Leiab kõrgeima ID postituste tabelis
	$stmt = $yhendus->query("SELECT MAX(post_ID) as maxID FROM postitused");
	$stmt->execute();
	
	$postTotal = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo $postTotal['maxID'];
	
	$stmt->closeCursor();