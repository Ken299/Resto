<?php
	require_once('php/functions.php');
	if(!isset($_SESSION["id_from_db"])){
		// kui on,suunan data lehele
		header("Location: login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<title>Admin page</title>
</head>
<body>
	<div class="page-header">
		<li class="menu-item"><a href="php/logout.php" class="menu-link">Logi välja</a></li>
	</div>
	<div id="table-view">
		<h1>Lauad</h1>
		<table border='1'>
			<tr>
				<th>Laua number</th>
				<th>Laua kirjeldus</th>
				<th>Laua suurus</th>
				<th>Broneeritud</th>
			</tr>
			<?php
				$stmt = $mysqli->prepare("SELECT * FROM restolauad");
				$stmt->bind_result($id, $tablenr, $description, $booked, $size);
				$stmt->execute();
				while($stmt->fetch()){
					echo "
						<tr>
							<td>$tablenr</td>
							<td>$description</td>
							<td>$size</td>
							<td>$booked</td>
						</tr>
					";
				}
			?>
		</table>
	</div>
	
</body>
</html>