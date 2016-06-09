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
	<script>
		$(document).ready(function(){
			$(".confirmBtn").click(function(event){
				request = $.ajax({
					url: "confirm.php",
					type: "post",
					data: {
							id: this.name
						  }
				});
				
				request.done(function (response, textStatus, jqXHR){
					$("#bronniTabel").load("admin.php #bronniTabel");
					console.log(response);
				});
			});
		});
	</script>
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
		<h1>Broneeringud</h1>
		<table id="bronniTabel" border='1' padding='5px'>
			<tr>
				<th>Inimeste arv</th>
				<th>Eesnimi</th>
				<th>Email</th>
				<th>Telefon</th>
				<th>Kuupäev</th>
				<th>Aeg</th>
				<th>Lisa</th>
				<th>Kinnitatud</th>
				<th>Kinnita</th>
			</tr>
			<?php
				$yhendus=new mysqli("localhost", "if13", "ifikad", "if13_mikkottis");
				$stmt = $yhendus->prepare("SELECT * FROM bronn WHERE confirmed = 0");
				$stmt->bind_result($bronn_ID, $arv, $nimi, $email, $telefon, $kuupaev, $aeg, $lisa, $confirmed);
				$stmt->execute();
				while($stmt->fetch()){
					echo "
						<tr>
							<td>$arv</td>
							<td>$nimi</td>
							<td>$email</td>
							<td>$telefon</td>
							<td>$kuupaev</td>
							<td>$aeg</td>
							<td>$lisa</td>
							<td>$confirmed</td>
							<td><button class='confirmBtn' name=$bronn_ID id='kinnitus'>Kinnita broneering</button></td>
						</tr>
					";
				}
			?>
			
		</table>
	</div>
	
</body>
</html>