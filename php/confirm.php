<?php
	require_once("konf.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	
	$sql = "UPDATE bronn SET confirmed=1 WHERE bronn_ID='".$id."'";

	if (mysqli_query($yhendus, $sql)){
		echo "Broneering ID ".$id." on kinnitatud";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($yhendus);
	}

	mysqli_close($yhendus);
?>