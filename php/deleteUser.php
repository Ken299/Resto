<?php
	require_once("config.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	
	$sql = "DELETE FROM users WHERE id='".$id."'";

	if (mysqli_query($yhendus, $sql)){
		echo "Kasutaja ID ".$id." on Kustutatud";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($yhendus);
	}

	mysqli_close($yhendus);
?>