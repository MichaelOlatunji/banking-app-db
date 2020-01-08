<?php
require 'connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = array();

$mail = $data['email'];

// $usn; $mal;

$checkMail = mysqli_query($connect, "SELECT email FROM info WHERE email ='$mail'");

$mal = mysqli_num_rows($checkMail);
//checks if username has been used


//checks if email has been used
if($mal >= 1){
    $response['email'] = true;
    $response['emailMessage'] = 'Email has already been used, please use another Email';
}if($mal == 0){
    $response['email'] = false;
    $response['emailMessage'] = '';
}

echo json_encode($response);
?>