<?php
	require_once("konf.php");
	
	$q = strval($_GET['q']);
	
	$sql = "SELECT COUNT(kuupaev) AS taken FROM bronn WHERE kuupaev LIKE '".$q."'";
	$result = mysqli_query($yhendus, $sql);
	$data = $result->fetch_assoc();
	
	echo 10-$data['taken'];

	mysqli_close($yhendus);
?>