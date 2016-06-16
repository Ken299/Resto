<?php
	require_once('../php/functions.php');
	if(($_SESSION["rights"])!=3){
		// kui on,suunan data lehele
		header("Location: ../login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Blogi postitamine</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/blogpost.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>
			$(document).ready(function(){
		
				// Käivitab TinyMCE liidese koos vajalike seadistustega
				tinymce.init({
								selector: "textarea",
								width: 1000,
								height: 200,
								automatic_uploads: false,
								auto_focus: "sisu",
								plugins: "advlist autolink autosave image link preview searchreplace wordcount",
								menubar: "file edit insert view format",
								toolbar: "undo redo | styleselect | bold italic | alighnleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image preview searchreplace"
							});
				
				
				// Laeb alla olemasolevad pildid
				getImages();
				
				// AJAX POST request, et laadida uus pilt üles.
				$("#laePilt").on("submit",(function(e) {
					e.preventDefault();
					var formData = new FormData(this);
					
					var $form = $(this);
					var $inputs = $form.find("input, select, button, textarea");
					
					// Lukustab inputid kuni request on jõudnud mingi tulemuseni.
					$inputs.prop("disabled", true);

					$.ajax({
						url: "php/uploadPic.php",
						type: "POST",
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function (data) {
							console.log(data);
							// Teeb inputi väljad tühjaks
							$("#laePilt")[0].reset();
							// Teeb pilte hoidva div'i tühjaks
							$("#images").empty();
							// Laeb uuesti pildid, loodetavasti koos uutega
							getImages();
						},
						error: function (data) {
							console.log(data);
						},
						complete: function (data) {
							$inputs.prop("disabled", false);
						}
					});
				}));
				
				// AJAX POST request, et blogisse lisada uus postitus.
				$("#laePost").on("submit",(function(e) {
					e.preventDefault();
					
					editorToString();
					
					var formData = new FormData(this);
					
					var $form = $(this);
					var $inputs = $form.find("input, select, button, textarea");

					$inputs.prop("disabled", true);

					$.ajax({
						url: "php/upload.php",
						type: "POST",
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function (data) {
							console.log(data);
							$("#laePost")[0].reset();
							$("#tulemus").append("<p>Postitatud!</p>");
						},
						error: function (data) {
							console.log(data);
						},
						complete: function (data) {
							$inputs.prop("disabled", false);
						}
					});
				}));
			});
			
			// Võtab liidese TinyMCE sisu ning paneb selle #sisu inputi, et POST request saaks seda edasi anda.
			function editorToString() {
				$("#sisu").val(tinyMCE.activeEditor.getContent());
			}
			
			// Võtab pildid kaustast.
			function getImages(forList) {
				var dir = "uploads/";
				
				$.ajax({
					url: dir,
					success: function (data) {
						displayPics(data, dir);
					}
				});
			}
			
			// Saadud andmete põhjal paneb pildid #images div'i 
			function displayPics(data, dir) {
				var i = 0;
				$(data).find("a:contains(.jpg),a:contains(.jpeg),a:contains(.png)").each(function () {
					$("#images").append("<img src='"+dir+""+$(this).attr("href")+"' id='img_"+i+"'>");
					i++;
				});
			}
		</script>
	</head>
	<div class="page-header">
		<li class="menu-item"><a href="../php/logout.php" class="menu-link">Logi välja</a></li>
	</div>
	<body>
		<!-- Form uue pildi üles laadimiseks -->
		<form id="laePilt" method="post" enctype="multipart/form-data">
				<p>Lae uus pilt:</p>
				<input type="file" name="fileToUpload" id="fileToUpload"></br> </br>
				<input type="submit" value="Lae" name="submit">
		</form> </br>
		
		<p>Olemasolevad pildid:</p>
		<!-- Siiakse laetakse olemasolevad pildid -->
		<div id="images"></div>
		
		<!-- Script pildi valimiseks -->
		<script src="js/imgSelect.js"></script>
		
		<!-- Form postituse tegemiseks blogisse -->
		<div id="sisestus">
			<form id="laePost" method="post" enctype="multipart/form-data" novalidate>
				<input type="hidden" id="pic" name="pic" value="">
				<input type="text" name="pealkiri" id="pealkiri" placeholder="Pealkiri" required> </br> </br>
				<textarea name="sisu" id="sisu" required></textarea> </br> </br>
				<input id="btn_post" type="submit" value="Postita" name="submit" disabled="true">
			</form> </br>
		</div>
		
		<!-- Siia läheks link blogipostitusele -->
		<div id="tulemus"></div>
	</body>
</html>