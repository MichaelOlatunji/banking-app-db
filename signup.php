<?php
session_start();
// echo json_encode($_FILES['passport']);
require 'connect.php';
// $data = json_decode(file_get_contents('php://input'), true);
$response = array();
$checker = false;
$sname = $_REQUEST['surname'];
$mname = $_REQUEST['midname'];
$lname = $_REQUEST['lastname'];
$mail = $_REQUEST['email'];
$ph = $_REQUEST['phone'];
$gen = $_REQUEST['gender'];
$uname = $_REQUEST['username'];
$pwd =$_REQUEST['password'];
$_SESSION['username'] = $uname;

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["passport"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_FILES["passport"])) {
    $check = getimagesize($_FILES["passport"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }
}

// if file already exist
if(file_exists($target_file)){
    // echo 'file already exist';
    $response['imageExist'] = 'File already Exists';
    $uploadOk = 0;
}

// checks size more than 1mb
if($_FILES['passport']['size'] > 1000000){
    // echo 'file is too large';
    $response['imageLarge'] = 'Image is more than 1mb, please upload an image of smaller size';
    $uploadOk = 0;
}

//checks file type
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    // echo "Sorry, only JPG, JPEG and PNG files are allowed.";
    $response['imageType'] = 'Sorry, only JPG, JPEG and PNG files are allowed.';
    $uploadOk = 0;
}

// check if image is uploaded
if($uploadOk == 0){
    // echo 'your file failed to upload';
    $response['uploaded'] = 'image failed to upload';
}else {
    if (move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["passport"]["name"]). " has been uploaded.";
        $response['uploaded'] = 'image successfully uploaded';
    } else {
        // echo "Sorry, there was an error uploading your file.";
        $response['uploaded'] = 'There was an error uploading your image';
    }
}

if($uploadOk == 1){
    $insert = mysqli_query($connect,"INSERT INTO info(surname,mid_name,last_name,email,phone,gender,username,password,passport) 
    VALUES ('$sname','$mname','$lname','$mail','$ph','$gen','$uname','$pwd','$target_file')");
    if($insert){
        $checker = true;
    }
}

if($checker){
    $response['message'] = 'inserted';
    $response['success'] = true;
}

else{
    $response['message'] = 'not inserted';
    $response['success'] = false;
    $error = mysqli_error($connect);
    $response['error'] = $error;
    // echo mysqli_error($connect);
}
echo json_encode($response);

// echo json_encode($_FILES['passport']);
?>