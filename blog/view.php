<?php
	require_once("php/pdo_conf.php");
	
	try {
		// Leiab kõrgeima ID postituste tabelis
		$stmt = $yhendus->query("SELECT MAX(post_ID) as maxID FROM postitused");
		$stmt->execute();
		
		$postTotal = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$stmt->closeCursor();
		
		// Kontrollib, et leht ei hakkaks tegema tööd kui on juba teada, et sellist ID pole olemas
		if(isset($_GET["id"]) && ($_GET["id"] <= $postTotal["maxID"]) && ($_GET["id"] > 0)){
			// Leiab õige ID'ga postituse ning võtab sellelt info/sisu
			$stmt = $yhendus->query("SELECT * FROM postitused WHERE post_ID = " . $_GET["id"]);
			$stmt->execute();
			
			$result = $stmt->fetchAll();

			$result = json_encode($result);
		} else {
			header("Location: blog.html");
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	
	$yhendus = null;
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Siia läheb posti tiitel -->
		<title>Postitus</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/view.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script>
			var data = JSON.parse(<?php echo json_encode($result); ?>)[0];
			var maxID = JSON.parse(<?php echo $postTotal['maxID'] ?>);
			
			$(document).ready(function(){
				getSideBarPosts();
				
				$("#cover").attr("src", data.img);
				$("#title").text(data.pealkiri);
				$("#autor").text(data.autor);
				$("#kuupaev").text(data.kuupaev.slice(0,10));
				$("#body_text").html(data.sisu);
				disablePrev();
				disableNext();
				
				$("#btn_prev").click(function(){
					window.location = "view.php?id=" + parseInt(data.post_ID - 1);
				});				
				
				$("#btn_next").click(function(){
					window.location = "view.php?id=" + parseInt(parseInt(data.post_ID) + 1);
				});				
				
				$("#btn_back").click(function(){
					window.location = "blog.html";
				});
			});
			
			function disablePrev() {
				if(data.post_ID == 1){
					$("#btn_prev").attr("disabled", true);
				}
			}
			
			function disableNext() {
				if(data.post_ID == maxID){
					$("#btn_next").attr("disabled", true);
				}
			}
			
			// Võtab requestiga külgribale 
			function getSideBarPosts() {	
				$.ajax({
					type: "POST",
					url: "php/getposts.php",
					data:{"currPost": data.post_ID},
					success: function(data) {
						handleData(data);
					}
				});
			}
			
			function handleData(data) {
				var results = jQuery.parseJSON(data);
				console.log(results);
				
				for (var i = 0; i < results.length; i++){
					$("#side").append("<div class='otherArticle' id='"+results[i].post_ID+"'></div>");
					$("#"+results[i].post_ID).append("<p>"+results[i].pealkiri+"</p>");
					// Lisab click eventi, mille abil edastatakse id, et kuvada kogu postitust.
					$("#"+results[i].post_ID).bind("click", "div", function(e) {
						var target = $(e.target);
						if (target.is("p") || target.is("h1")) {
							window.location = "view.php?id=" + target.parent().attr("id") ;
						}
					});
				}
			}
			
			function getBeforeAndAfter() {	
				$.ajax({
					type: "POST",
					url: "php/getBeforeAndAfter.php",
					data:{"currPost": data.post_ID},
					success: function(data) {
						handleData(data);
					}
				});
			}
			
			function handleBeforeAndAFter(data) {
				
			}
		</script>
	</head>
	
	<body>
		<div id="fb-root"></div>
		<script>
			// Facebook API käivitamine
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {
					return;
				} 
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.6&appId=1616749911974239";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div id="nav">
			<input type="button" id="btn_prev" value="Eelmine">
			<input type="button" id="btn_next" value="Järgmine">
			<input type="button" id="btn_back" value="Tagasi">
		</div>
		<!-- Siia tuleb kogu postitus koos kaasneva infoga -->
		<div id="post">
			<!-- Sisu -->
			<div id="content">
				<img id="cover" src="">
				<h1 id="title"></h1>
				<div id="info">
					<p>Autor: <span id="autor"></span> | <span id="kuupaev"></span></p>
				</div>
				<div id="body_text">
					
				</div>
			</div>
			<!-- Siia alla lükkaks sotisiaalmeedia lingid. Vb tagid ka? -->
			<div id="bottom">
				<!-- Facebooki Like nupp -->
				<div class="fb-like" data-href="http://greeny.cs.tlu.ee/~ottismi/Resto/blog/view.php?id=<?php echo $_GET["id"] ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
			</div>
		</div>
		<div id="side">
		</div>

	</body>
</html>