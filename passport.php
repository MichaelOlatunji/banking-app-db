<?php
require_once 'connect.php';

echo json_encode($_FILES['passport']);

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["passport"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_FILES["passport"])) {
    $check = getimagesize($_FILES["passport"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// if file already exist
if(file_exists($target_file)){
    echo 'file already exist';
    $uploadOk = 0;
}

// checks size more than 1mb
if($_FILES['passport']['size'] > 1000000){
    echo 'file is too large';
    $uploadOk = 0;
}

//checks file type
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, JPEG and PNG files are allowed.";
    $uploadOk = 0;
}

// check if image upload
if($uploadOk == 0){
    echo 'your file failed to upload';
}else {
    if (move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["passport"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$insert = mysqli_query($connect,"INSERT INTO info(passport) VALUES ('$target_file')");
if($insert){
    echo 'inserted';
}else{
    echo 'not inserted';
    echo mysqli_error($connect);
}
?>