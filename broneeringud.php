<?php
	require_once('php/functions.php');
	//if(isset($_SESSION["rights"])){
	if(($_SESSION["rights"])!=2){
		// kui on,suunan data lehele
		header("Location: login.php");
		exit();
	}
	//}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/CustomAdmin.css" />
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
					$("#bronniTabel").load("admin.php #bronniTabel");
					console.log(response);
				});
			});
		});
		
		
	</script>
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="navbar-header">
	<p><a href="broneeringud.php"><img src="img/relatedposts/manna.png" width="50px" height="50px"></a><span style="color: white;" class="MVD"> Manna Va Doosa broneeringud</span></p>
	</div>
	<p align="right" style="margin-right: 40px; margin-top: 15px;"class="menu-item"><a href="php/logout.php" class="btn btn-restoran">Logi välja</a></p>
	</nav>
	<div id="table-view">
		<h1 class='tableView'>Broneeringud</h1><br><br><br>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#newB">Uued broneeringud</a></li>
			<li><a data-toggle="tab" href="#acceptedB">Kinnitatud broneeringud</a></li>
			<li><a data-toggle="tab" href="#addB">Käsitsi lisamine</a></li>
		</ul>
		<div class="tab-content">
		<br>
		<div id="newB" class="tab-pane fade in active">
		<br><br>
		<div class="col-md-10 col-md-offset-1" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		<br>
			<table class="table table-hover" id="bronniTabel" border='1' margin='50px'>
				<tr class="tableView">
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
						if(isset($_GET["edit"]) && $bronn_ID == $_GET["edit"]){
							echo "
								<tr class='tableView'>
									<td><input style='color:black;width: 100%; height: 100%; border: none' id ='arvVal' value=$arv /></td>
									<td>$nimi</td>
									<td>$email</td>
									<td>$telefon</td>
									<td><input style='color:black;width: 100%; height: 100%; border: none' class='kuupaevVal' type='text' name='kuupaevVal' id='datepicker2' onmousedown='datepick();' value=$kuupaev ></td>
									<td><input style='color:black; width: 100%; height: 100%; border: none' id='aegVal' value=$aeg /></td>
									<td><textarea  class='form-control' id='textareaVal' style='color:black; width: 100%; height: 100%; border: none;'>$lisa</textarea></td>
									<td>$confirmed</td>
									<td><button class='confirmBtn btn btn-success' name=$bronn_ID id='kinnitus'>Kinnita broneering</button></td>
									<td><a href='?' class='confirmInfo btn btn-primary' name=$bronn_ID id=$lisa>Salvesta lisainfo</a></td>
									<td><button class='deleteBtn btn btn-restoran' name=$bronn_ID id='delete'>Kustuta broneering</button></td>
								</tr>
							";
						}else{
							echo "
								<tr class='tableView'>
									<td>$arv</td>
									<td>$nimi</td>
									<td>$email</td>
									<td>$telefon</td>
									<td>$kuupaev</td>
									<td>$aeg</td>
									<td><textarea readonly rows='3' class='form-control' style='width: 100%; height: 100%; border: none; color:black;'>$lisa</textarea></td>
									<td>$confirmed</td>
									<td><button class='confirmBtn btn btn-success' name=$bronn_ID id='kinnitus'>Kinnita broneering</button></td>
									<td><a href='?edit=$bronn_ID' class='btn btn-primary'>Muuda</a></td>
									<td><button class='deleteBtn btn btn-restoran' name=$bronn_ID id='delete'>Kustuta broneering</button></td>
								</tr>
							";
						}
						//<td><button class='changeInfo' name=$bronn_ID id=$lisa>Muuda lisainfot</button></td>
														//<td><button class='confirmInfo' name=$bronn_ID id=$lisa>Salvesta lisainfo</button></td>

					}
				?>
				
			</table>
		</div>
		</div>
		<div id="acceptedB" class="tab-pane fade">
		<h2 class='tableView' align="center">Kinnitatud broneeringud</h2>
		<div class="col-md-10 col-md-offset-1" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
			<div id='changeInfo'></div>
			
			<h3 class='tableView'>Vali kuupäev</h3>
			<?php 
				$buttonID = 1;
				$yhendus=new mysqli("localhost", "if13", "ifikad", "if13_mikkottis");
				$stmt = $yhendus->prepare("SELECT count(*), kuupaev FROM bronn WHERE confirmed = 1 AND kuupaev >= curdate() group by kuupaev");
				$stmt->bind_result($count, $kuupaev);
				$stmt->execute();
				while($stmt->fetch()){
					echo "<button class='kuupaevBtn btn btn-primary' id=$buttonID value=$kuupaev>$kuupaev</button>";
					$buttonID++;
				}
			?>
			<div id='chooseDate'></div>
			</div>
			</div>
		<div id="addB" class="tab-pane fade">
			<h1 class="tableView" align="center">Loo uus broneering</h1>
		<div class="col-md-2 col-md-offset-5" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		<form id="bronni" align="center">
		<div class="form-group">
			<p>Nimi</p> 
			<input type="text" name="name" id="name" required>
		</div>
		<div class="form-group">
			<p>Arv</p>
			<input type="number" name="arv" id="arv" required>		
		</div>
		<div class="form-group">
			<p>E-mail</p>
			<input type="email" name="email" id="email" required>
		</div>
		<div class="form-group">
			<p>Telefon</p>
			<input type="number" name="telefon" id="telefon" required>
		</div>
		<div class="form-group">
			<p>Kuupäev</p>
			<input type="text" onchange="showAvailability()" name="kuupaev" id="datepicker" required>
		</div>
		<div class="form-group">
			<p id="txt_seats"></p>
			<p>Aeg</p>
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
			</div>
			<div class="form-group">
				<p id="error_date"></p>
			</div>
			<div class="form-group">
				<p>Lisainfo</p>
				<textarea class='form-control' rows="4" cols="22" name="lisainfo" id="lisainfo"></textarea></br></br>
				
				<input type="submit" id="btn_submit" class="btn btn-restoran" value="Broneeri">
			</div>
				<p id="txt_result"></p>
			</form>
		</div>
		</div>
		
		<!-- Muutmine ja kinnitatud broneeringud -->
		
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
					this.change.innerHTML += "<h2>Broneeringu muutmine</h2>";
					var HTML = "<table class='table table-hover' border=1><tr>";
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
					$("#bronniTabel").load("admin.php #bronniTabel");
					console.log(response);
					
				});
			});
			$(document).on("click", ".kuupaevBtn", function(e){
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
						var table = $('<table class="table table-hover" border=1>');
						var tr = "<tr class='tableView'>";
						tr += "<th>Kustuta broneering</th><th>Muuda broneering</th><th>Inimeste arv</th><th>Eesnimi</th><th>Email</th><th>Telefon</th><th>Kuupäev</th><th>Aeg</th><th>Lisa</th></tr>";
						$(tr).appendTo(table);
						$.each(item, function(index, value){
							var TableRow = "<tr class='tableView'>";
							$.each(value, function (key, val){
								if(key != 'bronn_ID' && key !='confirmed'){
									<?php if(isset($_GET["editConfirmed"])) {
										echo "if(key =='arv'){
											TableRow += '<td><input style=color:black id=arvVal value='+val+' /></input></td>';
										}
										if(key == 'aeg'){
											TableRow += '<td align=center><input style=color:black id=aegVal value='+val+' /></input></td>';
										}
										if(key == 'kuupaev'){
											TableRow += '<td align=center><input style=color:black class=kuupaevVal type=text name=kuupaevVal id=datepicker2 onmousedown=datepick(); value=$kuupaev ></input></td>';
										}
										if(key == 'lisa'){
											TableRow += '<td align=center><textarea class=form-control id=textareaVal style=color:black>$lisa</textarea> </textarea></td>';
										}else{
											TableRow += '<td>' + val + '</td>';
										}";
										
									}else{
										echo "TableRow += '<td>' + val + '</td>';";
									}?>
									
								}
								if(key == 'bronn_ID'){
									TableRow +="<td><button class='deleteBtn btn btn-restoran' name="+val+" id='delete'>Kustuta broneering</button></td>";
									TableRow +="<td><a href='?editConfirmed="+val+"&dateBtn="+$(e.target).attr("id")+"'>Muuda</a></td>";
								}
							});
							TableRow += "</tr>";
							$(table).append(TableRow);
						});
						$(table).appendTo("#chooseDate");
					});
				});
				
			($(".kuupaevBtn") && $("#<?php if(isset($_GET['dateBtn'])){echo $_GET['dateBtn'];} ?>")).trigger("click");
			
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
					//$("").html("");
					$("#bronniTabel").load("admin.php");
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
		
		<!-- Käsitsi lisamine -->
		
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
	
</body>
</html