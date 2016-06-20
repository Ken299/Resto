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
	<p><a href="galerii.php"><img src="img/relatedposts/manna.png" width="50px" height="50px"></a><span style="color: white;" class="MVD"> Manna Va Doosa kontohaldus</span></p>
	</div>
	<p align="right" style="margin-right: 40px; margin-top: 15px;"class="menu-item"><a href="php/logout.php" class="btn btn-restoran">Logi välja</a></p>
	</nav>
	<br><br><br>
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#tab1">Galerii piltide lisamine</a></li>
	</ul>
	<div class="tab-content">
	<br>
	<div id="tab1" class="tab-pane fade in active">
	<h2 align="center" style="color: white;">Lisa pilte</h2>
	<br>
	<div class="col-md-3 col-md-offset-5" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		<br>
		<form action="php/create_photo_gallery.php" method="post" enctype="multipart/form-data">
			<table width="100%">
				<tr>
					<td style="color:white">Select Photo (one or multiple):</td>
					<td><input type="file" name="files[]" multiple /></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="color:white">Note: Supported image format: .jpeg, .jpg, .png, .gif</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Create Gallery" id="selectedButton"/></td>
				</tr>
			</table>
		</form>
	</div>
	</div>
	<div id="tab2" class="tab-pane fade">
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
		</script>
		
	
</body>
</html>

