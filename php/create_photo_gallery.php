<?php
/*extract($_POST);
    $error=array();
    $extension=array("jpeg","jpg","png","gif");
    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name)
            {
                $file_name=$_FILES["files"]["name"][$key];
                $file_tmp=$_FILES["files"]["tmp_name"][$key];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
                if(in_array($ext,$extension))
                {
                    if(!file_exists("photo_gallery/".$file_name))
                    {
                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"photo_gallery/".$file_name);
                    }
                    else
                    {
                        $filename=basename($file_name,$ext);
                        $newFileName=$filename.time().".".$ext;
                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"photo_gallery/".$newFileName);
                    }
                }
                else
                {
                    array_push($error,"$file_name, ");
                }
            }*/
			require_once('functions.php');
		$files = array();

        $allowed_filetypes = array('.jpg','.jpeg','.gif','.bmp','.png','.tif');
        $max_filesize = 1524288;
		$folder_name = 'test';
		$upload_path = 'images2/image_uploads/';
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
						echo "vb tootab ";
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