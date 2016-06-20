<?php
	require_once("pdo_conf.php");
	
	try {
		// Leiab kõrgeima ID postituste tabelis
		$stmt = $yhendus->query("SELECT MAX(post_ID) as maxID FROM postitused");
		$stmt->execute();
		
		$postTotal = $stmt->fetch(PDO::FETCH_ASSOC);
		$postTotal = $postTotal['maxID'];
		
		$stmt->closeCursor();
		
		
		if (isset($_POST['currPost'])){
			// Otsib välja tabelis eelneva ja järgneva postituste ID'd
			$currPost = $_POST['currPost'];
			
			$stmt = $yhendus->query("(SELECT * FROM postitused
									 WHERE post_ID < '$currPost'
									 AND post_ID > 0
									 ORDER BY post_ID DESC
									 LIMIT 1)
									 UNION
									 (SELECT * FROM postitused
									 WHERE post_ID > '$currPost'
									 AND post_ID <= '$postTotal'
									 ORDER BY post_ID ASC
									 LIMIT 1)");
						 
			$stmt->execute();
		
			$result = $stmt->fetchAll();
			
			$stmt->closeCursor();

			echo json_encode($result);
		}

	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
    }
	$yhendus = null;
?>