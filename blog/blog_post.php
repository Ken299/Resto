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
		<script src="tinymce/tinymce.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/CustomAdmin.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<script>
			var picSet = 0;
		
			$(document).ready(function(){
				$("#autor").val("<?php echo $_SESSION["nimi"]; ?>");
				// Käivitab TinyMCE liidese koos vajalike seadistustega
				tinymce.init({
								selector: "textarea",
								skin: "custom",
								width: 1000,
								height: 200,
								automatic_uploads: false,
								auto_focus: "sisu",
								plugins: "advlist autolink autosave image link preview searchreplace wordcount",
								menubar: "file edit insert view format",
								toolbar: "undo redo | styleselect | bold italic | alighnleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image preview searchreplace",
								setup: function(sisu) {
									sisu.on("keyup", function(e) {
										validation();
									});
									
									sisu.on('paste', function(e) {
										validation();

									});

									sisu.on('cut', function(e) {
										validation();
									});
								}
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
							window.location = "view.php?id=" + data;
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
			
			// Kontrollime, et oleks pilt valitud ning pealkirjaks ja sisuks midagi sisestatud.
			function validation(imgPicked) {
				imgPicked = imgPicked || 0; // Kui pole väärtust kaasa antud, on 0.
				
				if (imgPicked == 1){
					picSet = 1;
				}
				
				if(($("#pealkiri").val() != "") && (tinyMCE.activeEditor.getContent() != "") && picSet != 0) {
					$("#btn_post").attr("disabled", false);
				} else {
					$("#btn_post").attr("disabled", true);
				}
			}
			
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
	<body>
	<nav class="navbar navbar-inverse">
	<div class="navbar-header">
	<p><a href="admin.php"><img src="../img/relatedposts/manna.png" width="50px" height="50px"></a><span style="color: white;" class="MVD"> Manna Va Doosa blogi</span></p>
	</div>
	<p align="right" style="margin-right: 40px; margin-top: 15px;"class="menu-item"><a href="../php/logout.php" class="btn btn-restoran">Logi välja</a></p>
	</nav>
	<br><br><br>
	<div class="col-md-7 col-md-offset-2" align="center" style="background-color: rgba(0,0,0, .3); border-radius: 20px;">
		<!-- Form uue pildi üles laadimiseks -->
		<form id="laePilt" method="post" enctype="multipart/form-data">
				<h2 style="color: white; font-family: Montserrat;">Uue pildi lisamine</h2>
				<input type="file" name="fileToUpload" id="fileToUpload" style="border: 1px solid white;"></br> </br>
				<input type="submit" value="Lae" name="submit">
		</form> </br>
		
		<h2 style="color: white; font-family: Montserrat;">Vali pilt:</h2>
		<!-- Siiakse laetakse olemasolevad pildid -->
		<div id="images"></div>
		
		<!-- Script pildi valimiseks -->
		<script src="js/imgSelect.js"></script>
		
		<!-- Form postituse tegemiseks blogisse -->
		<br><br>
		<h2 style="color: white; font-family: Montserrat;">Lisa pealkiri</h2>
		<div id="sisestus">
			<form id="laePost" method="post" enctype="multipart/form-data" novalidate>
				<input type="hidden" id="pic" name="pic" value="">
				<input type="hidden" id="autor" name="autor" value="">
				<input type="text" name="pealkiri" id="pealkiri" placeholder="Pealkiri" size="165" style="height: 50px;" onkeyup="validation()"> </br> </br>
				<textarea name="sisu" id="sisu"></textarea> </br> </br>
				<input id="btn_post" class="btn btn-success" type="submit" value="Postita" name="submit" disabled="true">
			</form> </br>
		</div>
		</div>
	</body>
</html>