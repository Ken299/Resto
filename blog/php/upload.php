<?php
	require_once("pdo_conf.php");

	$img_name = $_POST['pic'];
	$pealkiri = $_POST['pealkiri'];
	$sisu = $_POST['sisu'];
	$autor = $_POST['autor'];
	
	try {
		$stmt = $yhendus->prepare("INSERT INTO postitused (img, pealkiri, sisu, autor)
								VALUES (:img_name, :pealkiri, :sisu, :autor)");
		$stmt->bindParam(":img_name", $img_name);
		$stmt->bindParam(":pealkiri", $pealkiri);
		$stmt->bindParam(":sisu", $sisu);
		$stmt->bindParam(":autor", $autor);
		$stmt->execute();
		
		echo "New records created successfully";
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
    }
	
	$yhendus = null;
	
?>