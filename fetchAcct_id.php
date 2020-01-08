<?php
session_start();
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'),true);
$response = array();
$acct_name = $data['account'];
$amount = $data['amount'];
$fetched = false;

if(isset($_SESSION['user_id'])){
$fetch = mysqli_query($connect,"SELECT * FROM acct_type WHERE info_id = '$_SESSION[user_id]' AND name = '$acct_name'");
while($r = mysqli_fetch_array($fetch)){
    $_SESSION['acct_id'] = $r['acct_id'];
    // echo '<p>'.$r['acct_id'].'</p><br/>';
    $fetched = true;
    }}
    if($fetched){
        $response['fetched'] = 'has been fetched';
        $response['success'] = true;
    }else{
        $response['success'] = false;
        $response['message'] = mysqli_error($connect);
    }

    echo json_encode($response);

    ?>