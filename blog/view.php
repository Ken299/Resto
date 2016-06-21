<?php
	require_once('../php/functions.php');
	require_once("php/pdo_conf.php");
	
	try {
		// Gets the post with the highest ID
		$stmt = $yhendus->query("SELECT MAX(post_ID) as maxID, MIN(post_ID) as minID FROM postitused");
		$stmt->execute();
		
		$postTotal = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$stmt->closeCursor();
		
		//  A few checks to ensure no work is done, when the page doesn't exist
		if(isset($_GET["id"]) && ($_GET["id"] <= $postTotal["maxID"]) && ($_GET["id"] >= $postTotal["minID"])){
			// Finds the post with the matching ID and gets the contents
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
		<title>Postitus</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/view.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script>
			var _data = JSON.parse(<?php echo json_encode($result); ?>)[0];
			var maxID = JSON.parse(<?php echo $postTotal['maxID'] ?>);
			var minID = JSON.parse(<?php echo $postTotal['minID'] ?>);
			var prev;
			var next;
			
			$(document).ready(function(){
				// Parses the data
				getSideBarPosts();
				getBeforeAndAfter();
				addSpecial();
				
				// Fills the elements with the necessary info
				$("#cover").attr("src", _data.img);
				$("#title").text(_data.pealkiri);
				$("#autor").text(_data.autor);
				$("#kuupaev").text(_data.kuupaev.slice(0,10));
				$("#body_text").html(_data.sisu);
				
				// Checks if it's necessary to disable either button
				disablePrev();
				disableNext();
				
				// Click events for the various buttons
				$("#btn_prev").click(function(){
					window.location = "view.php?id=" + prev;
				});				
				
				$("#btn_next").click(function(){
					window.location = "view.php?id=" + next;
				});				
				
				$("#btn_back").click(function(){
					window.location = "blog.html";
				});
			});
			
			// Buttons for users with special privileges
			function addSpecial() {
				if(rightCheck() == true) {
					//$("#special").append("<input type='button' id='btn_edit' value='Redigeeri'>");
					$("#special").append("<input type='button' id='btn_delete' value='Eemalda'>");
					
					$("#btn_delete").click(function(){
						if(rightCheck() == true) {
							$.ajax({
								type: "POST",
								url: "php/deletePost.php",
								data:{"currPost": _data.post_ID},
								success: function(data) {
									window.location = "blog.html";
								}
							});
						}
					});		
				}
				
				// Checks for the correct rights
				function rightCheck() {
					if(<?php if(isset($_SESSION["rights"])){echo $_SESSION["rights"];}else{echo 999;}?> == 3){
						return true;
					} else {
						return false;
					}
				}
			}
			
			// Disables the previous post button if the post's ID matches the minimum post ID found
			function disablePrev() {
				if(_data.post_ID == minID){
					$("#btn_prev").attr("disabled", true);
				}
			}
			
			// Disables the next post button if the post's ID matches the maximum post ID found
			function disableNext() {
				if(_data.post_ID == maxID){
					$("#btn_next").attr("disabled", true);
				}
			}
			
			// Gets posts to populate the sidebar
			function getSideBarPosts() {	
				$.ajax({
					type: "POST",
					url: "php/getposts.php",
					data:{"currPost": _data.post_ID},
					success: function(data) {
						handleData(data);
					}
				});
			}
			
			function handleData(data) {
				var results = jQuery.parseJSON(data);
				
				for (var i = 0; i < results.length; i++){
					$("#side").append("<div class='otherArticle' id='"+results[i].post_ID+"'></div>");
					$("#"+results[i].post_ID).append("<p>"+results[i].pealkiri+"</p>");
					$("#"+results[i].post_ID).bind("click", "div", function(e) {
						var target = $(e.target);
						if (target.is("p") || target.is("h1")) {
							window.location = "view.php?id=" + target.parent().attr("id") ;
						}
					});
				}
			}
			
			Gets the info of the blog posts submitted before and after the current one
			function getBeforeAndAfter() {	
				$.ajax({
					type: "POST",
					url: "php/getBeforeAndAfter.php",
					data:{"currPost": _data.post_ID},
					success: function(data) {
						handleBeforeAndAFter(data);
					}
				});
			}
			
			function handleBeforeAndAFter(data) {
				var results = jQuery.parseJSON(data);
				for (var i = 0; i < results.length; i++) {
					if (parseInt(results[i].post_ID) > parseInt(_data.post_ID)) {
						next = results[i].post_ID;
					} else if (parseInt(results[i].post_ID) < parseInt(_data.post_ID)) {
						prev = results[i].post_ID;
					}
				}
			}
		</script>
	</head>
    
    		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        		


    
	
	<body class=bloggg>
		
        <div class="col-md-8 col-md-offset-2" align="center" style="color: white; background-color: rgba(0, 0, 0, 0.81); border-radius: 50px;">
        <div id="fb-root"></div>
		<script>
			// Facebook API activation
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
            
            <br><br>
		<div id="nav">
			<input type="button" class= "btn-blogview" id="btn_prev" value="Eelmine">
			<input type="button" class="btn-blogview" id="btn_next" value="Järgmine">
			<input type="button" class="btn-blogview" id="btn_back" value="Tagasi">
            <br><br><br>
		</div>
		<div id="special"></div>
		<!-- This is where the post's contents go -->
		<div id="post">
			<!-- Content -->
			<div id="content">
				<img id="cover" src="" style="max-width: 768px; width:100%;">
				<h1 id="title"></h1>
				<div id="info">
					<p>Autor: <span id="autor"></span> | <span id="kuupaev"></span></p>
				</div>
				<div id="body_text">
					
				</div>
			</div>
			<!-- Social buttons -->
			<div id="bottom">
				<!-- Facebooki Like button -->
				<div class="fb-like" data-href="http://greeny.cs.tlu.ee/~ottismi/Resto/blog/view.php?id=<?php echo $_GET["id"] ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
			</div>
            <div style="" id="side">
                
            <h3>Vaata teisi postitusi</h3>
                <br><br><br>
		</div>
		</div>
            <br><br>
		
        </div>

	</body>
</html>