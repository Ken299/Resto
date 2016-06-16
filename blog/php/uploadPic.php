<?php
	$img_name = basename($_FILES["fileToUpload"]["name"]);
	
	uploadPic($img_name);
	
	function uploadPic($img_name) {
		$target_dir = "uploads/";
		$target_file = $target_dir . $img_name;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "Fail on pilt - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "Fail pole pilt.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Vabandust, fail on juba üles laetud.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Vabandust, faili suurus on liiga suur..";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			echo "Vabandust, ainult JPG, JPEG ja PNG failid on lubatud.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Vabandust, teie faili ei laetud üles.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
			} else {
				echo "Vabandust, faili üles laadimisel tekkis viga.";
			}
		}
	}
?>