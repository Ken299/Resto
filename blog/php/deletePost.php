<?php
	require_once("pdo_conf.php");
	
	try {
		if (isset($_POST['currPost'])){
			// Otsib välja tabelis eelneva ja järgneva postituste ID'd
			$currPost = $_POST['currPost'];
			
			$stmt = $yhendus->query("DELETE FROM postitused WHERE post_ID = '$currPost'");
				 
			$stmt->execute();
		}
		
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
    }
	$yhendus = null;
?>