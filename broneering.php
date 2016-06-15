<!doctype html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<title>
			Bronni testimine
		</title>
		<script>
			var request;

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
					xmlhttp.open("GET","getdates.php?q="+rawDate,true);
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
						url: "reserving.php",
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
	<body>
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