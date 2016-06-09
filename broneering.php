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
			$(function() {
				$( "#datepicker" ).datepicker();
			});
			
			function showSeats(str){
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
				xmlhttp.open("GET","getdates.php?q="+str,true);
				xmlhttp.send();
			}
		</script>
	</head>
	<body>
		<form action="reserving.php" method="post">
			<datalist id="list_tunnid">
				<option value="8">
				<option value="9">
				<option value="10">
				<option value="11">
				<option value="12">
				<option value="13">
				<option value="14">
				<option value="15">
				<option value="16">
				<option value="17">
				<option value="18">
				<option value="19">
				<option value="20">
				<option value="21">
			</datalist>
			
			<datalist id="list_mins">
				<option value="00">
				<option value="10">
				<option value="20">
				<option value="30">
				<option value="40">
				<option value="50">
			</datalist>
		
			<p>Nimi:</p> 
			<input type="text" name="name" id="name">
			<p>Arv:</p>
			<input type="text" name="arv" id="arv">		
			<p>E-mail:</p>
			<input type="text" name="email" id="email">
			<p>Kuupäev:</p>
			<input type="text" onchange="showSeats(this.value)" name="kuupaev" id="datepicker">
			<p id="txt_seats"></p>
			<p>Aeg:</p>
			<input list="list_tunnid" name="tunnid" id="tunnid"> :
			<input list="list_mins" name="minutid" id="minutid"></br></br>
			<input type="submit" value="Broneeri">
		</form>
	</body>

</html>