<?php
	require_once("php/functions.php");
	if(isset($_SESSION["rights"])){
		if($_SESSION["rights"]==1){
			// kui on,suunan data lehele
	//		echo "suunab admin lehele";
			header("Location: admin.php");
			exit();
		}elseif($_SESSION["rights"]==2){
			// kui on,suunan data lehele
			header("Location: broneeringud.php");
			exit();
		}elseif($_SESSION["rights"]==3){
			// kui on,suunan data lehele
			header("Location: blog/blog_post.php");
			exit();
		}
	}
	
	
	//muutujad errorite jaoks
	$create_uname_error = $create_pw_error = $uname_error = $pw_error = "";
	//muutujad väärtuste joks
	$create_uname = $create_pw = $pw = $uname = "";
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
			//võib kasutaja teha
			if(	$create_uname_error == "" && $create_pw_error == ""){
				$password_hash = hash("sha512", $create_pw);
				//käivitame funktsiooni
				$create_response = $User->createUser($create_uname, $password_hash);
				header("Location:login.php");
				//lõpetame php laadimise
				exit();
			}
		}
		if(isset($_POST["login"])){

			//kasutajanimi
			if(empty($_POST["uname"])){
				$uname_error = "See väli on kohustuslik";
			}else{
				// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$uname = cleanInput($_POST["uname"]);
			}
			//parool
			if(empty($_POST["pw"])){
				$pw_error = "See väli on kohustuslik";
			}else{
				$pw = cleanInput($_POST["pw"]);
			}
			
			$password_hash = hash("sha512", $pw);
				// käivitan funktsiooni
			$login_response = $User->loginUser($uname, $password_hash);
			if(isset($login_response->success)){
				//läks edukalt, peab sessiooni salvestama
				print_r($login_response);
				$_SESSION["rights"] = $login_response->success->user->rights;
				$_SESSION["nimi"] = $login_response->success->user->nimi;
					if($_SESSION["rights"]==1){
						echo "broneeringu lehele2";
						header("Location:admin.php");
						exit();
					}
					if($_SESSION["rights"]==2){
						echo "broneeringu lehele";
						header("Location:broneeringud.php");
						exit();
					}
					if($_SESSION["rights"]==3){
						echo "broneeringu lehele";
						header("Location:blog/blog_post.php");
						exit();
					}
					
				
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

</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="navbar-header">
	<p><a href="login.php"><img src="img/relatedposts/manna.png" width="50px" height="50px"></a><span style="color: white;" class="MVD"> Manna Va Doosa sisselogimine</span></p>
	</div>
	<p align="right" style="margin-right: 40px; margin-top: 15px;"class="menu-item"><a href="./" class="btn btn-restoran">Kodulehele</a></p>
	</nav>
	<br><br><br>
<div class="col-md-2 col-md-offset-5" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
<div id="login-view">
<form method="post">
	<h1 style="color: white;">Sisselogimine</h1>
	
	<?php if(isset($login_response->error)):?>
	<p style="color:red;"><?=$login_response->error->message;?></p>
	<?php elseif(isset($login_response->success)):?>
	<p style="color:green;"><?=$login_response->success->message;?></p>
	<?php endif;?>
	
	<fieldset class="form-group">
		<label for="uname" style="color: white;">Username</label><span class="error" style="color:red;"> <?php echo $uname_error?></span>
		<input type="text" class="form-control" name="uname" placeholder="Kasutajanimi" value="<?php if(isset($_POST["uname"])){echo $uname;}?>" />
	</fieldset>
	<fieldset class="form-group">
		<label for="pw" style="color: white;">Password</label><span class="error" style="color:red;"> <?php echo $pw_error?></span>
		<input type="password" class="form-control" name="pw" placeholder="Parool"/>
	</fieldset>
	<input type="submit" class="btn btn-restoran" style="margin-top: 35px;" name="login" value="Logi sisse"/>
	<br><br>
</form>
</div>
</div>
</div>
</body>
</html>
