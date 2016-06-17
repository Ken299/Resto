<?php
	require_once('php/functions.php');
	//if(isset($_SESSION["rights"])){
		if(($_SESSION["rights"])!=1){
			// kui on,suunan data lehele
			header("Location: login.php");
			exit();
		}
	//}
	
	//muutujad errorite jaoks
	$create_uname_error = $create_pw_error = $create_radio_error = $uname_error = $pw_error = "";
	//muutujad väärtuste joks
	$create_uname = $create_pw = $optradio = $pw = $uname = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["create"])){
			//kasutajanimi
			if ( empty($_POST["create_uname"]) ) {
				$create_uname_error = "See väli on kohustuslik";
			}else{
				$create_uname = cleanInput($_POST["create_uname"]);
			}
			//parool
			if ( empty($_POST["create_pw"]) ) {
				$create_pw_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_pw"]) < 8) {
					$create_pw_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_pw = cleanInput($_POST["create_pw"]);
				}
			}
			if(empty($_POST["optradio"])){
				$create_radio_error = "See väli on kohustuslik";
			}else{
				$rights = ($_POST["optradio"]);
			}
			
			//võib kasutaja teha
			if(	$create_uname_error == "" && $create_pw_error == ""){
				$password_hash = hash("sha512", $create_pw);
				//käivitame funktsiooni
				$create_response = $User->createUser($create_uname, $password_hash, $rights);
				header("Location:login.php");
				//lõpetame php laadimise
				exit();
			}
		}
	}
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/CustomAdmin.css" />
<head>
	<title>Admini leht</title>
</head>
<body>
	<script>
		$(document).ready(function(){
			$(".deleteBtn").click(function(event){
				var confirm1 = confirm('Oled kindel, et soovid kustutada kasutajat?');
				if(confirm1){
					request = $.ajax({
						url: "php/deleteUser.php",
						type: "post",
						data: {
								id: this.name
							  }
					});
					request.done(function (response, textStatus, jqXHR){
						window.location.reload();
						console.log(response);
					});
				}
			});
		});
		
	</script>
	<nav class="navbar navbar-inverse">
	<div class="navbar-header">
	<p><a href="admin.php"><img src="img/relatedposts/manna.png" width="50px" height="50px"></a><span style="color: white;" class="MVD"> Manna Va Doosa kontohaldus</span></p>
	</div>
	<p align="right" style="margin-right: 40px; margin-top: 15px;"class="menu-item"><a href="php/logout.php" class="btn btn-restoran">Logi välja</a></p>
	</nav>
	<br><br><br>
	<div class="col-md-2 col-md-offset-5" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		<div id="register-view">
			<form method="post">
				<h1 style="color: white;">Loo uus konto</h1>
			
				<?php if(isset($create_response->error)):?>
				<p style="color:red;"><?=$create_response->error->message;?></p>
				<?php elseif(isset($create_response->success)):?>
				<p style="color:green;"><?=$create_response->success->message;?></p>
				<?php endif;?>
			
				<fieldset class="form-group">
					<label for="create_uname" style="color: white;">Kasutajanimi</label><span class="error" style="color:red;"> <?php echo $create_uname_error?></span>
					<input type="text" class="form-control" name="create_uname" placeholder="Kasutajanimi" value="<?php if(isset($_POST["create_uname"])){echo $create_uname;}?>" />
				</fieldset>
				<fieldset class="form-group">	
					<label for="create_pw" style="color: white;">Parool</label><span class="error" style="color:red;"> <?php echo $create_pw_error?></span>
					<input type="password" class="form-control" name="create_pw" placeholder="Parool" />
				</fieldset>
				<div class="container">
					<form role="form" name="rights">
						<span class="error" style="color:red;"><?php echo $create_radio_error ?></span>
						<label class="radio-inline" style="color: white;">
							<input type="radio" name="optradio" value="1">Admin</input>
						</label>
						<label class="radio-inline" style="color: white;">
							<input type="radio" name="optradio" value="2">Broneeringud</input>
						</label>
						<label class="radio-inline" style="color: white;">
							<input type="radio" name="optradio" value="3">Blogi</input>
						</label>
					</form>
					<div>
						<input type="submit" class="btn btn-restoran" name="create" value='Loo konto' style="margin-top: 35px;"/>
						<br><br>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div>
		<table border=1>
			<tr>
				<th style=color:white>Kasutajanimi</th>
				<th style=color:white>Õigused</th>
				<th style=color:white>Kustuta</th>
			</tr>
			<?php
				$yhendus=new mysqli("localhost", "if13", "ifikad", "if13_leetussa");
				$stmt = $yhendus->prepare("SELECT id, username, rights FROM users");
				$stmt->bind_result($id, $username, $rights);
				$stmt->execute();
				while($stmt->fetch()){
					echo "<tr>";
					if($rights==1){
						echo "
							<td style=color:white>$username</td>
							<td style=color:white>Admin</td>
							<td><button class=deleteBtn name=$id> Kustuta</button></td>
						";
					}
					if($rights==2){
						echo "
							<td style=color:white>$username</td>
							<td style=color:white>Broneerija</td>
							<td><button class=deleteBtn name=$id> Kustuta</button></td>
						";
					}
					if($rights==3){
						echo "
							<td style=color:white>$username</td>
							<td style=color:white>Blogi</td>
							<td><button class=deleteBtn name=$id> Kustuta</button></td>
						";
					}
					echo "</tr>";
				}
			?>
		</table>
	</div>
	
</body>
</html>

