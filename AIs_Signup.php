<?php
include('db.php');	//database connect
session_start();

$target_dir = "upload/";    //photo upload
 
$id;
$id_r=mysqli_query($link, "SELECT id FROM `ais` ORDER BY `ais`.`id` DESC LIMIT 1");    //id_result
if(mysqli_num_rows($id_r) > 0) {
	while($row = mysqli_fetch_assoc($id_r)){
		echo "id:" . $row["id"]."<br>";
		$id = $row["id"];
		$id++;    //ID AUTO++
	}
} else {
	echo "0 results";
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fn_array=explode(".",basename($_FILES["fileToUpload"]["name"]));//segment filename 
$mainName = $fn_array[0];//filename 
$subName = $fn_array[1];//Filename Extension
$id_string = str_pad($id,6,'0',STR_PAD_LEFT).'.'.$subName;    
			//The str_pad() function pads a string to a new length.
$target_file_id = $target_dir .$id_string;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {	// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if (file_exists($target_file_id)) {	// Check if file already exists
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5120000) {	// Check file size < 5MB
    echo "Sorry, your file is too large."; 
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" 
   && $imageFileType != "jpeg") {	// Allow certain file formats
    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {	// Check if $uploadOk is set to 0 by an error
    echo "Sorry, your file was not uploaded.";

} else {	// if everything is ok, try to upload file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_id)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
unset($out);	#use unset() to reset $out
exec("D:/wampserver/wamp64/www/AIs/upload/move.py {$id_string}",$out,$res);
echo "<br>";
echo '外部程序運行是否成功:'.$res."(0代表成功,1代表失敗)";

//data upload.
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$nickname = $_POST['nickname'];
$hobby = $_POST['hobby'];
$introduce = $_POST['introduce'];//name the value    $_POST['NAME']

$sql="INSERT INTO `ais`(`username`, `password`, `id`, `nickname`, `hobby`, `introduction`, `photo`) VALUES ('$username', '$password', '$id','$nickname','$hobby','$introduce','$id_string')";

$result=$link->query($sql);

if ($result) {
	echo mysqli_affected_rows($link). "插入成功"; 
	//return MySQL（SELECT，INSERT，UPDATE，REPLACE，DELETE）
}
else{
	echo "插入失敗";
}
mysqli_close($link);

setcookie("id",$id,time()+1800);	//secure
setcookie("nickname", $nickname, time()+1800);
setcookie("hobby", $hobby, time()+1800);
setcookie("introduction" ,$introduce, time()+1800);
setcookie("photo" ,$id_string, time()+1800);	//cookies
echo"<script>";
echo"alert（'Hello world'）;";
echo"</ script>";
header("Location: http://ais/AIs.html");
?>