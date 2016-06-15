<?php
	require_once("konf.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	$textarea = mysqli_real_escape_string($yhendus, $_POST['textareaVal']);
	$arv = mysqli_real_escape_string($yhendus, $_POST['arvVal']);
	$aeg = mysqli_real_escape_string($yhendus, $_POST['aegVal']);
	$kuupaev = mysqli_real_escape_string($yhendus, $_POST['kuupaevVal']);
	$sql = "UPDATE bronn SET lisa='".$textarea."', arv='".$arv."', aeg='".$aeg."', kuupaev='".$kuupaev."' WHERE bronn_ID='".$id."'";

	if (mysqli_query($yhendus, $sql)){
		echo "Broneering ID ".$id." on muudetud ".$textarea."";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($yhendus);
	}

	mysqli_close($yhendus);
?>