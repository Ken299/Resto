<!DOCTYPE html>
<html>
	<head>
		<title>Blogi testimine</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				getPosts();
			});
			
			// Võtab andmebaasist olemasolevad postitused.
			function getPosts() {					
				$.ajax({
					url: "getposts.php",
					success: function(data) {
						handleData(data);
					}
				});
			}
			
			// Tegeleb saadud andmetega edasi 
			function handleData(data) {
				var results = jQuery.parseJSON(data);
				console.log(results);
				for (var i = 0; i < results.length; i++){
					$("#main").append("<div class='post' id='"+results[i].post_ID+"'></div>");
					$("#"+results[i].post_ID).append("<img src='../uploads/"+results[i].img+"' height='300'>");
					$("#"+results[i].post_ID).append("<h1>"+results[i].pealkiri+"</h1>");
					$("#"+results[i].post_ID).append("<p>"+results[i].sisu+"</p>");
				}
			}
		</script>
	</head>
	
	<body>
		<div id="main">
		</div>
	</body>
</html>