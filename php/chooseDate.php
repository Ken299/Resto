<?php
	require_once("konf.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	
	$stmt = "SELECT * FROM bronn WHERE kuupaev='".$id."' AND confirmed = 1 ORDER BY aeg";
	$result = mysqli_query($yhendus, $stmt);
	$potential = array();
	while($row = mysqli_fetch_assoc($result)){
		$potential[] = $row;
	}
	
	echo json_encode($potential);
	mysqli_close($yhendus);
?>