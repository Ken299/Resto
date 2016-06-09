<?php
	require_once("konf.php");
	
	$name = mysqli_real_escape_string($yhendus, $_POST['name']);
	$arv = mysqli_real_escape_string($yhendus, $_POST['arv']);
	$email = mysqli_real_escape_string($yhendus, $_POST['email']);
	$kuupaev = mysqli_real_escape_string($yhendus, $_POST['kuupaev']);
	$aeg = mysqli_real_escape_string($yhendus, $_POST['tunnid'] . ":" . $_POST['minutid']);
	
	$sql = "INSERT INTO bronn (arv, nimi, email, kuupaev, aeg) VALUES ('$arv', '$name', '$email', '$kuupaev', '$aeg')";
	if (mysqli_query($yhendus, $sql)){
		echo "Broneering tehtud!";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($yhendus);
	}
	
	mysqli_close($yhendus);
?>