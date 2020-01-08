<?php
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = array();

$uname = $data['username'];
$checkPass = mysqli_query($connect, "SELECT username FROM info WHERE username ='$uname'");
$usn = mysqli_num_rows($checkPass);

if($usn >= 1){
    $response['username'] = true;
    $response['unameMessage'] = 'Username has been used, please choose another';
}if($usn == 0){
    $response['username'] = false;
    $response['unameMessage'] = '';
}

echo json_encode($response);

?>