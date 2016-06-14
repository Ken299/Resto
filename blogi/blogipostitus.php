<!DOCTYPE html>
<html>
	<head>
		<title>Blogi postitamine</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style2.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>
			$(document).ready(function(){
				tinymce.init({selector:'textarea'});
				getImages();
			});
			
			function getImages() {
				var dir = "../uploads/";
				
				$.ajax({
					url: dir,
					success: function (data) {
						handleData(data, dir);
					}
				});
			}
			
			// Tegeleb saadud andmetega edasi 
			function handleData(data, dir) {
				var i = 0;
				$(data).find("a:contains(.jpg),a:contains(.jpeg),a:contains(.png)").each(function () {
					$("#images").append("<img src='"+dir+""+$(this).attr("href")+"' id='img_"+i+"'>");
					i++;
				});
			}
			
			
		</script>
	</head>
	
	<body>
		<div id="images">
		</div>
		<form>
		</form>
		<script>
			var selected = 0;
			var prevImg;
		
			// Muudab valitud pildi borderi paksuks ja punaseks. Eelnevalt valitud pildi borderi muudab tagasi defaulti.
			$('#images').on("click", "img", function (e) {
				e.preventDefault();
				
				$(this).css("border", "solid 3px red");
				if (selected == 1) {
					$("#"+prevImg).css("border", "solid 1px black");
				}
				prevImg = e.target.id;
				selected = 1;
			});
		</script>
		<div id="sisestus">
			<form action="upload.php" method="post" enctype="multipart/form-data">
				Vali pilt, mida üles laadida:
				<input type="file" name="fileToUpload" id="fileToUpload"></br>
				<input type="text" name="pealkiri" id="pealkiri" placeholder="Pealkiri" required> </br> </br>
				<textarea name="sisu" id="sisu"></textarea> </br> </br>
				<input type="submit" value="Postita" name="submit">
			</form> </br>

			
		</div>
		<div id="tulemus">
			
		</div>
	</body>
</html>