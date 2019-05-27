<?php
header("Content-Type:text/html; charset=utf-8");

// Create connection
$link = mysqli_connect('localhost','account number','password','ais');	//database connect
mysqli_query($link,'set names utf8');	//db coding
if (mysqli_connect_errno()) {	//Determine if the database is successfully connected
	//error
	exit;
}
else{
	//success
}

$data_getfrompi = htmlspecialchars($_GET['data']);
$data = (int)$data_getfrompi;

$sql = "SELECT `nickname`,`hobby`,`introduction` FROM `ais` WHERE `ais`.`id` LIKE '" . $data . "'";

$result = mysqli_query($link,$sql);
$row_result = mysqli_fetch_assoc($result);

echo $nickname = $row_result["nickname"]." ";
echo $hobby = $row_result["hobby"]." ";
echo $introduction = $row_result["introduction"];

mysqli_close($link);
?>