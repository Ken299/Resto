<?php
	require_once('functions.php');
	$files = array();

	$allowed_filetypes = array('.jpg','.jpeg','.gif','.bmp','.png','.tif');
	$max_filesize = 1524288;
	$folder_name = 'test';
	$upload_path = '../images2/image_uploads/';
	/*if(!file_exists($upload_path)){
		mkdir($upload_path);
	}*/
	for ($i = 0; $i < count($_FILES['files']['name']); $i++){
		if($_FILES['files']['name'][$i] != "") {
			$filename = $_FILES['files']['name'][$i];
			$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); 
			$ext = strtolower($ext);

			if(!in_array($ext,$allowed_filetypes))
				die("The file you attempted to upload ($filename) is not allowed.");

			if(filesize($_FILES['files']['tmp_name'][$i]) > $max_filesize)
				die("The file you attempted to upload ($filename) is too large.");

			if(!is_writable($upload_path))
				die("You cannot upload to the specified directory, please CHMOD it to 777.");

			$ran = rand();
			$filename = $ran.$ext;
			if(move_uploaded_file($_FILES['files']['tmp_name'][$i],$upload_path.$filename)) {
				$result = mysqli_query($yhendus, "Insert Into galerii (image, originalname) Values ('$filename', '".$_FILES['files']['name'][$i]."');");
				
				if($result){
					//array_push($files, "http://www.site.com/images/image_uploads/$filename => ".$_FILES['files']['name'][$i]);
				}else{
					echo "<p style=\"color:#cc3333;\">Unable to upload ".$_FILES['files']['name'][$i]."</p>";
				}
			}else{
				echo "<p style=\"color:#cc3333;\">Unable to upload ".$_FILES['files']['name'][$i]."</p>";
			}
		}
	}
?>