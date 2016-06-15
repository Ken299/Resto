<?php
	require_once("konf.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	$sql = "DELETE FROM bronn WHERE bronn_ID='".$id."'";
	if (mysqli_query($yhendus, $sql)){
		echo "Broneering ID ".$id." on kustutatud ";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($yhendus);
	}

	mysqli_close($yhendus);
?>