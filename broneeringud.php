<?php
	require_once('php/functions.php');
	if(!isset($_SESSION["rights"])){
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
	<title>Broneeringute leht</title>
	<script>
	
		
		$(document).ready(function(){
			$(".confirmBtn").click(function(event){
				request = $.ajax({
					url: "php/confirm.php",
					type: "post",
					data: {
							id: this.name
						  }
				});
				
				request.done(function (response, textStatus, jqXHR){
					//$("#bronniTabel").load("admin.php #bronniTabel");
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
				<th>Kustuta broneering</th>
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
							<td><textarea readonly style='width: 100%; height: 100%; border: none'>$lisa</textarea></td>
							<td>$confirmed</td>
							<td><button class='confirmBtn' name=$bronn_ID id='kinnitus'>Kinnita broneering</button></td>
							<td><button class='changeInfo' name=$bronn_ID id=$lisa>Muuda lisainfot</button></td>
							<td><button class='deleteBtn' name=$bronn_ID id='delete'>Kustuta broneering</button></td>
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
					url: "php/changeInfo.php",
					type: "post",
					data: {
							id: this.name,
							value: this.id
						  }
				});
				
				request.done(function (response, textStatus, jqXHR){
					var item = JSON.parse(response);
					this.change = document.getElementById("changeInfo");
					this.change.innerHTML = "";
					this.change.innerHTML += "<h2>Broneeringu muutmine";
					var HTML = "<table border=1><tr>";
					HTML += "<th align=center>Inimeste arv</th><th align=center>Aeg</th><th align=center>Kuupäev</th><th align=center>Lisainfo</th></tr>";
					HTML += item[1];
					HTML += "</table>";
					HTML += "<button id='confirmInfoBtn' class='confirmInfo' name="+item[0]+">Kinnita muudatus</button>";
					this.change.innerHTML += HTML;
					
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
					url: "php/confirmInfo.php",
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
			$(document).on("click", ".kuupaevBtn", function(){
				$("#chooseDate").html("");
					var id = $(this).attr('value'); 
					console.log(id);
					request = $.ajax({
						url: "php/chooseDate.php",
						type: "post",
						data: {
							id
						}
					});
					request.done(function(response, textStatus, jqXHR){
						
						console.log(response);
						var item = JSON.parse(response);
						console.log(item);
						
						this.choose = document.getElementById("chooseDate");
						var table = $('<table border=1>');
						var tr = "<tr>";
						tr += "<th>Kustuta broneering</th><th>Inimeste arv</th><th>Eesnimi</th><th>Email</th><th>Telefon</th><th>Kuupäev</th><th>Aeg</th><th>Lisa</th></tr>";
						$(tr).appendTo(table);
						$.each(item, function(index, value){
							var TableRow = "<tr>";
							$.each(value, function (key, val){
								if(key != 'bronn_ID' && key !='confirmed'){
									TableRow += "<td>" + val + "</td>";
								}
								if(key == 'bronn_ID'){
									TableRow +="<td><button class='deleteBtn' name="+val+" id='delete'>Kustuta broneering</button></td>";
								}
							});
							TableRow += "</tr>";
							$(table).append(TableRow);
						});
						$(table).appendTo("#chooseDate");
					});
				});
			$(document).on("click", ".deleteBtn", function(){
				console.log("Test");
				request = $.ajax({
					url: "php/deleteBron.php",
					type: "post",
					data: {
						id: this.name
					}
				});
				request.done(function(response, textStatus, jqXHR){
					console.log(response);
				});
			});
		});
		$('.datepicker').on("click", function(){
			datepick();
		});
		function datepick() {
			$("#datepicker2").datepicker({
					dateFormat: "yy-mm-dd"
				});
			}
		</script>
		<div id='changeInfo'></div>
		
		<h1>Kinnitatud broneeringud</h1>
		<h2>Vali kuupäev</h2>
		<?php 
			$buttonID = 1;
			$yhendus=new mysqli("localhost", "if13", "ifikad", "if13_mikkottis");
			$stmt = $yhendus->prepare("SELECT count(*), kuupaev FROM bronn WHERE confirmed = 1 AND kuupaev > curdate() group by kuupaev");
			$stmt->bind_result($count, $kuupaev);
			$stmt->execute();
			while($stmt->fetch()){
				echo "<button class='kuupaevBtn' id=$buttonID value=$kuupaev>$kuupaev</button>";
				$buttonID++;
			}
		?>
		<div id='chooseDate'></div>
		
	</div>
	<script>
		$(function() {
			$("#datepicker").datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
		function showAvailability(){
			rawDate = $("#datepicker")[0].value;
			if (!rawDate || rawDate == "") {
				return;
			} else {
				compareDates();
				checkIfFull();
			}
			
			function compareDates(){
				var currentDate = new Date();
				var selectedDate = new Date(Date.parse(rawDate));
				
				var curHour = parseInt(currentDate.getHours());
				var curMin = parseInt(currentDate.getMinutes());
				var selHour = parseInt($("#tunnid")[0].value);
				var selMin = parseInt($("#minutid")[0].value);
				
				// Et päevade kontrollimisel loeks ainult päev, kuu ja aasta.
				currentDate.setHours(0,0,0,0);
				selectedDate.setHours(0,0,0,0);
				
				if (selectedDate.getTime() < currentDate.getTime()) {
					$("#error_date").text("Valitud päev on juba möödunud");
					$("#btn_submit")[0].disabled = true;
				} else if (selectedDate.getTime() > currentDate.getTime()) {
					$("#error_date").empty();
					$("#btn_submit")[0].disabled = false;
				} else if (selectedDate.getTime() == currentDate.getTime()) {
					if (curHour + 1 < selHour) {
						$("#error_date").empty();
						$("#btn_submit")[0].disabled = false;
					} else if (curHour + 1 > selHour) {
						$("#error_date").text("Broneerida saab ainult 1h enne valitud aega.");
						$("#btn_submit")[0].disabled = true;
					} else {
						if (curMin < selMin) {
							$("#error_date").empty();
							$("#btn_submit")[0].disabled = false;
						} else {
							$("#error_date").text("Broneerida saab ainult 1h enne valitud aega.");
							$("#btn_submit")[0].disabled = true;
						}
					}
				} else {
					$("#btn_submit")[0].disabled = true;
					if (curHour < selHour) {
						$("#error_date").text("Broneerida saab ainult 1h enne valitud aega.");
					} else if (curHour > selHour) {
						$("#error_date").text("Valitud aeg on juba möödunud.");
					} else {
						if (curMin < selMin) {
							$("#error_date").text("Broneerida saab ainult 1h enne valitud aega.");
						} else {
							$("#error_date").text("Valitud aeg on juba möödunud.");
						}
					}
				}
			}	
			
			function checkIfFull(){
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				} else {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("txt_seats").innerHTML = "Vabu kohti: "+xmlhttp.responseText;
					}
				};
				xmlhttp.open("GET","php/getdates.php?q="+rawDate,true);
				xmlhttp.send();
			}
		}
		
		$(document).ready(function(){
			$('#datepicker').bind("paste",function(e) {
				e.preventDefault();
			});
			
			$("#bronni").submit(function(event){
				var $form = $(this);
				var $inputs = $form.find("input, select, button, textarea");
				var serializedData = $form.serialize();

				$inputs.prop("disabled", true);

				request = $.ajax({
					url: "php/reserving.php",
					type: "post",
					data: serializedData
				});

				request.done(function (response, textStatus, jqXHR){
					document.getElementById("txt_result").innerHTML = "Broneering tehtud!";
					$("#bronni")[0].reset();
				});
				
				request.fail(function (jqXHR, textStatus, errorThrown){
					document.getElementById("txt_result").innerHTML = "The following error occurred: "+textStatus, errorThrown;
				});
				
				request.always(function() {
					$inputs.prop("disabled", false);
				});
				
				event.preventDefault();

			});
		});
	</script>
	</head>
		<h1>Loo uus broneering</h1>
		<form id="bronni">
			<p>Nimi:</p> 
			<input type="text" name="name" id="name" required>
			<p>Arv:</p>
			<input type="number" name="arv" id="arv" required>		
			<p>E-mail:</p>
			<input type="email" name="email" id="email" required>
			<p>Telefon:</p>
			<input type="number" name="telefon" id="telefon" required>
			<p>Kuupäev:</p>
			<input type="text" onchange="showAvailability()" name="kuupaev" id="datepicker" required>
			<p id="txt_seats"></p>
			<p>Aeg:</p>
			<select name="tunnid" id="tunnid" onchange="showAvailability()">
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
			</select> :
			<select name="minutid" id="minutid" onchange="showAvailability()">
				<option value="00">00</option>
				<option value="15">15</option>
				<option value="30">30</option>
				<option value="45">45</option>
			</select>
			<p id="error_date"></p>
			<p>Lisainfo:</p>
			<textarea rows="4" cols="40" name="lisainfo" id="lisainfo"></textarea></br></br>
			
			<input type="submit" id="btn_submit" value="Broneeri">
			<p id="txt_result"></p>
		</form>
	
</body>
</html>