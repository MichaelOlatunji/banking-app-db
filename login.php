<?php
session_start();
require 'connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$resp = array();
$usrn = $data['username'];
$pwrd = $data['password'];

$fetch = mysqli_query($connect,"SELECT * FROM info WHERE username='$usrn' AND password='$pwrd'");

$no_rows = mysqli_num_rows($fetch);
if($no_rows >= 1){
    $resp['message'] = '';
    $resp['success'] = true;
    $_SESSION['user'] = $usrn;
    $_SESSION['password'] = $pwrd;
}

else{
    $resp['message'] = 'Invalid Username or Password';
    $resp['success'] = false;
}

echo json_encode($resp);
// print_r($_SESSION['user']);
?>