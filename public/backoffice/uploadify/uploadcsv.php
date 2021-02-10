<?php
include('../conn/conn.php');
session_start();

//$xupload = $_POST['xupload'];
$today = date('Y-m-d');

$target_path = "../uploads/";

$rand = rand(1,100);


$ext = pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION); 	

$newfile = "Client".".".$ext;
$target_path = "../uploads/".$newfile;
$filename =  $_FILES['Filedata']['name'];
$filetype =  $_FILES['Filedata']['type'];
$filesize =  $_FILES['Filedata']['size'];

if(move_uploaded_file($_FILES['Filedata']['tmp_name'], $target_path)) {
			echo $success =  "The file ".  basename( $_FILES['Filedata']['name']). " has been uploaded";
} 
else
{

	echo $error = "There was an error uploading the file, please try again!";

}



?>