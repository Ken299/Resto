<?php
	require_once('php/functions.php');
	//if(isset($_SESSION["rights"])){
		/*if(($_SESSION["rights"])!=1){
			// kui on,suunan data lehele
			header("Location: login.php");
			exit();
		}*/
	//}
	
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/CustomAdmin.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<head>
	<title>Galerii leht</title>
</head>
<body>
	<script>
		$(document).ready(function(){
			
		});
		
	</script>
	<script>
	$(document).ready(function() {
	$('a[data-confirm]').click(function(ev) {
		var href = $(this).attr('href');
		if (!$('#dataConfirmModal').length) {
			$('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">OK</a></div></div>');
		} 
		$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
		$('#dataConfirmOK').attr('href', href);
		$('#dataConfirmModal').modal({show:true});
		return false;
	});
});
</script>
	<nav class="navbar navbar-inverse">
	<div class="navbar-header">
	<p><a href="admin.php"><img src="img/relatedposts/manna.png" width="50px" height="50px"></a><span style="color: white;" class="MVD"> Manna Va Doosa kontohaldus</span></p>
	</div>
	<p align="right" style="margin-right: 40px; margin-top: 15px;"class="menu-item"><a href="php/logout.php" class="btn btn-restoran">Logi välja</a></p>
	</nav>
	<br><br><br>
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#tab1">Kasutajad</a></li>
		<li><a href="#tab2">Uus kasutaja</a></li>
	</ul>
	<div class="tab-content">
	<br>
	<div id="tab1" class="tab-pane fade in active">
	<h2 align="center" style="color: white;">Kontode haldamine</h2>
	<br>
	<div class="col-md-2 col-md-offset-5" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		<br>
		<h1>FUCK YOU</h1>
		<form action="php/create_photo_gallery.php" method="post" enctype="multipart/form-data">
			<table width="100%">
				<tr>
					<td>Select Photo (one or multiple):</td>
					<td><input type="file" name="files[]" multiple /></td>
				</tr>
				<tr>
					<td colspan="2" align="center">Note: Supported image format: .jpeg, .jpg, .png, .gif</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Create Gallery" id="selectedButton"/></td>
				</tr>
			</table>
		</form>
	</div>
	</div>
	<div id="tab2" class="tab-pane fade">
	<div class="col-md-2 col-md-offset-5" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		
	</div>
	</div>
	</div>
	<!-- tabi salvestamine refreshil -->
		<script>
		$('#myTab a').click(function(e) {
			e.preventDefault();
			$(this).tab('show');
		});

		// store the currently selected tab in the hash value
		$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
			var id = $(e.target).attr("href").substr(1);
			window.location.hash = id;
		});

		// on load of the page: switch to the currently selected tab
		var hash = window.location.hash;
		$('#myTab a[href="' + hash + '"]').tab('show');
		
		/*var dir = "php/images2/image_uploads";
		var fileextension = ".jpg";
		$.ajax({
			//This will retrieve the contents of the folder if the folder is configured as 'browsable'
			url: dir,
			success: function (data) {
				//Lsit all png file names in the page
				$(data).find("a:contains(" + fileextension + ")").each(function () {
					var filename = this.href.replace(window.location.host, "").replace("http:///~leetussa/Suvepraktika/Resto", "");
					$("#pildid").append($("<img src=" + dir + filename + "></img>"));
				});
			}
		});*/
		</script>
		<div class="highslide-gallery" id="pildid" align='center'>
		<?php

   $files = glob("php/images2/image_uploads/*.*");

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
		echo '<a id="'.$i.'" href="'.$image .'" class="highslide" onclick="return hs.expand(this, {slideshowGroup: 1})" alt="Random image" ><img src="'.$image.'" alt="Random image" title="Click to enlarge" width="304" height=236"/> </a>'."<br /><br />";
		echo '<div class="highslide-caption" ></div>';
		
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
	</div>
	
</body>
</html>

