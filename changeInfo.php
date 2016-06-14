<?php
	require_once("konf.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	
	$stmt = "SELECT bronn_ID, lisa, aeg, arv, kuupaev FROM bronn WHERE bronn_ID='".$id."'";
	$sql = $yhendus->prepare($stmt);
	
	$sql->bind_result($bronn_ID, $lisa, $aeg, $arv, $kuupaev);
	$sql->execute();
	$sql->fetch();
	echo $bronn_ID;
	echo " ";
	echo $aeg;
	echo " ";
	echo $arv;
	echo " ";
	echo $kuupaev;
	echo " ";
	echo $lisa;
	

	mysqli_close($yhendus);
?>