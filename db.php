<?php
header("Content-Type: text/html;charset=utf-8");	//utf-8

$link = mysqli_connect('localhost','account number','password','ais');	//database connect

mysqli_query($link,'set names utf8');	//db coding

if (mysqli_connect_errno()) {	//Determine if the database is successfully connected
	echo "資料庫連接失敗"."<br>";
	exit;
}
else{
	echo "資料庫連接成功"."<br>";
}
?>