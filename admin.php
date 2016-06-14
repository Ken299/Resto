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
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
		<table id="bronniTabel" border='1' margin='50px'>
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
				<th>Muuda andmeid</th>
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
							<td><button class='changeInfo' name=$bronn_ID id=$lisa>Muuda lisainfot</button></td>
						</tr>
					";
				}
			?>
			
		</table>
		<script>
		$(document).ready(function(){
			$('#datepicker').bind("paste",function(e) {
					e.preventDefault();
			});
			datepick();
			$(".changeInfo").click(function(event){
				request = $.ajax({
					url: "changeInfo.php",
					type: "post",
					data: {
							id: this.name,
							value: this.id
						  }
				});
				
				request.done(function (response, textStatus, jqXHR){
					var splitList = response.split(" ", 4);
					console.log(splitList);
					var responseList = response.substring(response.indexOf(' ')+20);
					this.change = document.getElementById("changeInfo");
					this.change.innerHTML = "";
					this.change.innerHTML += "<h2>Broneeringu "+splitList[0]+" muutmine";
					var HTML = "<table border=1><tr>";
					HTML += "<th align=center>Inimeste arv</th><th align=center>Aeg</th><th align=center>Kuupäev</th><th align=center>Lisainfo</th></tr>";
					HTML += "<tr><td align=center><input id ='arvVal' value="+splitList[2]+" /></td><td align=center><input id='aegVal' value="+splitList[1]+" /></td><td align=center><input class='kuupaevVal' type='text' name='kuupaevVal' id='datepicker' onmousedown='datepick();' value="+splitList[3]+" ></td><td align=center><textarea id='textareaVal'>"+responseList+"</textarea> </td></tr></table>";
					HTML += "<button id='confirmInfoBtn' class='confirmInfo' name="+splitList[0]+">Kinnita muudatus</button>"
					this.change.innerHTML += HTML;
					console.log(response);
				});
			});
			$(document).on("click", ".confirmInfo", function(){
				console.log("Test");
				var text = $('#textareaVal').val();
				var arv = $('#arvVal').val();
				var aeg = $('#aegVal').val();
				var kuupaev = $('.kuupaevVal').val();
				console.log(text);
				request = $.ajax({
					url: "confirmInfo.php",
					type: "post",
					data: {
						id: this.name,
						textareaVal: text,
						arvVal: arv,
						aegVal: aeg,
						kuupaevVal: kuupaev
					}
				});
				request.done(function (response, textStatus, jqXHR){
					console.log(response);
				});
			});
			
		});
		$('.datepicker').on("click", function(){
			datepick();
		});
		function datepick() {
			$("#datepicker").datepicker({
					dateFormat: "yy-mm-dd"
				});
			}
		</script>
		<div id='changeInfo'></div>
		
		<h1>Kinnitatud broneeringud</h1>
		<h2>Vali kuupäev</h2>
		<?php 
			$yhendus=new mysqli("localhost", "if13", "ifikad", "if13_mikkottis");
			$stmt = $yhendus->prepare("SELECT count(*), kuupaev FROM bronn WHERE confirmed = 1 AND kuupaev > curdate() group by kuupaev");
			$stmt->bind_result($count, $kuupaev);
			$stmt->execute();
			while($stmt->fetch()){
				echo "<button id=$kuupaev value=$kuupaev>$kuupaev</button>";
			}
		?>
		<table border='1' >
			<tr>
				<th>Inimeste arv</th>
				<th>Eesnimi</th>
				<th>Email</th>
				<th>Telefon</th>
				<th>Kuupäev</th>
				<th>Aeg</th>
				<th>Lisa</th>
				<th>Kinnitatud</th>
			</tr>
			<?php
				$yhendus=new mysqli("localhost", "if13", "ifikad", "if13_mikkottis");
				$stmt = $yhendus->prepare("SELECT * FROM bronn WHERE confirmed = 1 AND kuupaev = CURDATE()");
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
						</tr>
					";
				}
			?>
			
		</table>
	</div>
	
</body>
</html>