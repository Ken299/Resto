<?php
	require_once("konf.php");
	
	$name = mysqli_real_escape_string($yhendus, $_POST['name']);
	$arv = mysqli_real_escape_string($yhendus, $_POST['arv']);
	$email = mysqli_real_escape_string($yhendus, $_POST['email']);
	$telefon = mysqli_real_escape_string($yhendus, $_POST['telefon']);
	$kuupaev = mysqli_real_escape_string($yhendus, $_POST['kuupaev']);
	$aeg = mysqli_real_escape_string($yhendus, $_POST['tunnid'] . ":" . $_POST['minutid']);
	$lisainfo = mysqli_real_escape_string($yhendus, $_POST['lisainfo']);
	
	$sql = "INSERT INTO bronn (arv, nimi, email, telefon, kuupaev, aeg, lisa) 
			VALUES ('$arv', '$name', '$email', '$telefon', '$kuupaev', '$aeg', '$lisainfo')";
	if (mysqli_query($yhendus, $sql)){
		echo "Broneering tehtud!";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($yhendus);
	}
	
	mysqli_close($yhendus);
?>