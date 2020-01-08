<?php 
session_start();
// $data = json_decode(file_get_contents('php://input'),true);
// $response = array();
// $usrn = $data['username'];
// $pass = $data['password'];

if(isset($_SESSION['user']) && isset($_SESSION['password'])){
    echo '{"status": true}';
}
else{
    echo '{"status": false}';
}
?>