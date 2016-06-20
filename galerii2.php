<?php

   $files = glob("images2/image_uploads/*.*");

  for ($i=0; $i<count($files); $i++)

{

$image = $files[$i];
$supported_file = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);

$ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

if (in_array($ext, $supported_file)) {
    //print $image ."<br />";
		
	if($i==0){
		$id = $i;
		echo '<a id="'.$i.'" href="'.$image .'" class="highslide" onclick="return hs.expand(this, {slideshowGroup: 1})" alt="Random image" ><img src="'.$image.'" alt="Random image" title="Click to enlarge" width="304" height=236"/> </a>';
		echo '<div class="highslide-caption"></div>';
	}
	
	else{
		echo '<div class="hidden-container">';
		echo '<a href="'.$image.'" class="highslide" onclick="return hs.expand(this, {thumbnailId: '.$id.', slideshowGroup: 1})"></a>';
		echo '<div class="highslide-caption"></div>';
	}

   
} else {
    continue;
 }

}

?>