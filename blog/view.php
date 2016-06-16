<?php
	require_once("php/pdo_conf.php");
	
	try {
		$stmt = $yhendus->query("SELECT * FROM postitused WHERE post_ID = " . $_GET["id"]);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		$result = json_encode($result);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	
	$yhendus = null;
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Siia läheb posti tiitel -->
		<title>Postitus</title>
		<meta charset="UTF-8">
		<!-- <link rel="stylesheet" type="text/css" href="css/blog.css"> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				var data = JSON.parse(<?php echo json_encode($result); ?>);
				$("#cover").attr("src", data[0].img);
				$("#title").text(data[0].pealkiri);
				$("#body_text").html(data[0].sisu);
			});
		</script>
	</head>
	
	<body>
		<!-- Siia tuleb kogu postitus koos kaasneva infoga -->
		<div id="post">
			<!-- Sisu -->
			<div id="content">
				<img id="cover" src="">
				<h1 id="title">
				</h1>
				<div id="body_text">
					
				</div>
			</div>
			<!-- Siia alla lükkaks sotisiaalmeedia lingid. Vb tagid ka? -->
			<div id="bottom"></div>
		</div>

	</body>
</html>