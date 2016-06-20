<?php
	require_once("pdo_conf.php");
	
	try {
		// Leiab kõrgeima ID postituste tabelis
		$stmt = $yhendus->query("SELECT MAX(post_ID) as maxID FROM postitused");
		$stmt->execute();
		
		$postTotal = $stmt->fetch(PDO::FETCH_ASSOC);
		$postTotal = $postTotal['maxID'];
		
		$stmt->closeCursor();
		
		if (isset($_POST['pagenr'])){
			// Otsib välja vajalikud postitused olenevalt lehest.
			$currPage = $_POST['pagenr'] - 1;
			
			
			$topResult = $postTotal - 5 * $currPage;
			$lastResult = $topResult - 5;
			
			$stmt = $yhendus->query("SELECT * FROM postitused 
									 WHERE post_ID <= '$topResult'
									 AND post_ID > '$lastResult'");
			$stmt->execute();
			
			$result = $stmt->fetchAll();
			echo json_encode($result);
		} else if (isset($_POST['currPost'])){
			// Otsib välja kuni kolm eelnevat postitust.
			$currPost = $_POST['currPost'];
			$postAmount = 10; // Mitu eelnevat postitust leida
			
			$stmt = $yhendus->query("SELECT * FROM postitused 
									 WHERE post_ID < '$currPost'
									 AND post_ID >= '$currPost' - '$postAmount'
									 AND post_ID > 0");
			$stmt->execute();
		
			$result = $stmt->fetchAll();
			
			$stmt->closeCursor();
			
			// Juhul, jääb puudu vanematest artiklitest, hakkab uusi võtma
			if (count($result) < $postAmount){
				$needed = $postAmount - count($result); // Mitu artiklit on juurde vaja leida
				$stmt = $yhendus->query("SELECT * FROM postitused 
						 WHERE post_ID <= '$postTotal'
						 AND post_ID > '$postTotal' - '$needed'
						 AND post_ID > '$currPost'");
				$stmt->execute();
				 
				$extraResults = $stmt->fetchAll();
				
				$result = array_merge($result, $extraResults);
			}
			echo json_encode($result);
		}

	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
    }
	$yhendus = null;
?>