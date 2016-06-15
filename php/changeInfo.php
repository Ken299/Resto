<?php
	require_once("konf.php");
	
	$id = mysqli_real_escape_string($yhendus, $_POST['id']);
	
	$stmt = "SELECT bronn_ID, lisa, aeg, arv, kuupaev FROM bronn WHERE bronn_ID='".$id."'";
	$sql = $yhendus->prepare($stmt);
	
	$sql->bind_result($bronn_ID, $lisa, $aeg, $arv, $kuupaev);
	$sql->execute();
	$sql->fetch();
	$response = "
		<tr>
			<td align=center><input style='width: 100%; height: 100%; border: none' id ='arvVal' value=$arv /></td>
			<td align=center><input style='width: 100%; height: 100%; border: none' id='aegVal' value=$aeg /></td>
			<td align=center><input style='width: 100%; height: 100%; border: none' class='kuupaevVal' type='text' name='kuupaevVal' id='datepicker2' onmousedown='datepick();' value=$kuupaev ></td>
			<td align=center><textarea id='textareaVal' style='width: 100%; height: 100%; border: none'>$lisa</textarea> </td>
		</tr>
		
	";
	echo json_encode(array($bronn_ID, $response));
	

	mysqli_close($yhendus);
?>