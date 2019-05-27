<?php
include('db.php');	//database connect
$username = $_POST["username"];
$password = $_POST["password"];

session_start();

if(isset($_POST["submit"]) && $_POST["submit"] = "signin"){
	echo "signin"."<br>";
	$sql = "SELECT * FROM `ais` WHERE `ais`.`username`='".$_POST["username"]."' AND `ais`.`password`='".$_POST["password"]."'";    //compare db
	$result = mysqli_query($link,$sql);
	$row_result = mysqli_fetch_assoc($result);
	
	$admin = $row_result["username"];
	$admin2 = $row_result["password"];
	$id = $row_result["id"];
	$nickname = $row_result["nickname"];
	$hobby = $row_result["hobby"];
	$introduction = $row_result["introduction"];
	$photo = $row_result["photo"];	//data
	
	if($_POST["username"]==$admin){
		if($_POST["password"]==$admin2){
			setcookie("id",$id,time()+900);	//secure
			setcookie("nickname", $nickname, time()+900);
			setcookie("hobby", $hobby, time()+900);
			setcookie("introduction" ,$introduction, time()+900);
			setcookie("photo" ,$photo, time()+900);	//cookies
			
			header("Location: http://smiletomato.ddns.net:8888/AIs/AIsU.php"); 
			exit;
		}else{
			
		}
	}
}
if(isset($_POST["submit"]) && $_POST["submit"] = "signup"){
	$_SESSION['password'] = $password;
	$_SESSION['username'] = $username;
	header("Location: http://smiletomato.ddns.net:8888/AIs/AIs_Signup.html");
	exit;	
}
?>