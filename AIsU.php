<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>AIs</title>
	<style>@import url("AIs.css")</style>
</head>

<body bgcolor="">
	<?php
		// clean server cache
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	?>
	<?php
		include "check_login.php";
	?> 
	<form action="AIs.php" method="post" enctype="multipart/form-data">
		<label class="cover">
			<input type="file" id="fileToUpload" name="fileToUpload" accept="image/jpg, image/JPG, image/jpeg, image/png" >
			<img id="photo" src="photo_test.jpg" alt=""><br>  
		</label>
			<div align="center">
				暱稱 Nickname:<br>
				<input type="text" id="nickname" name="nickname" maxlength="28" value=""><br><br>
			</div>
			&nbsp&nbsp興趣 Hobby:<br>
			<textarea wrap="virtual" name="hobby" id="hobby">範例:打籃球/唱歌/彈鋼琴/看電影</textarea><br><br>
			&nbsp&nbsp介紹你自己 Introduce more:<br>
			<textarea wrap="virtual" name="introduce" id="introduce"></textarea><br><br>
			<div align="right">
				<input type="submit" name="submit" value="更新" />
			</div>
	</form>
</body>
</html>

<!-- JavaScript part -->
<script type="text/javascript">
	
	function readCookie(name) {
    	var nameEQ = name + "=";
    	var ca = document.cookie.split(';');
    	for(var i=0;i < ca.length;i++) {
        	var c = ca[i];
        	while (c.charAt(0)==' ') c = c.substring(1,c.length);
        	if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    	}
    	return null;
	}
	
	var nickname = decodeURI(readCookie('nickname'));
	var hobby = decodeURIComponent(readCookie('hobby'));
	var introduction = decodeURIComponent(readCookie('introduction'));
	var photo = decodeURIComponent(readCookie('photo'));	//get cookies
	var newphoto =  "./upload/" + photo;
	
	var img = new FileReader();    //preview photo
		document.forms[0].elements[0].onchange=function(){
			img.readAsDataURL(this.files[0]);
		}
		img.onloadend=function(){
			document.images[0].src = this.result;
		}
		
	document.getElementById("nickname").value = nickname;	//show cookies
	document.getElementById("hobby").innerHTML = hobby;
	document.getElementById("introduce").innerHTML = introduction.split("+").join(" ");	
	document.getElementById("photo").src = newphoto;
</script>