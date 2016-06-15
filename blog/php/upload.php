<?php
	require_once("pdo_conf.php");

	$img_name = $_POST['pic'];
	$pealkiri = $_POST['pealkiri'];
	$sisu = $_POST['sisu'];
	
	try {
		$stmt = $yhendus->prepare("INSERT INTO postitused (img, pealkiri, sisu)
								VALUES (:img_name, :pealkiri, :sisu)");
		$stmt->bindParam(":img_name", $img_name);
		$stmt->bindParam(":pealkiri", $pealkiri);
		$stmt->bindParam(":sisu", $sisu);
		$stmt->execute();
		
		echo "New records created successfully";
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
    }
	
	$yhendus = null;
	
?>