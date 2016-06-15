<?php
	require_once("pdo_conf.php");
	
	try {
		$stmt = $yhendus->query("SELECT * FROM postitused");
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		echo json_encode($result);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
    }
	
	$yhendus = null;
?>