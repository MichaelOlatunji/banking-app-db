<?php
session_start();
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'),true);
$response = array();
$acct_name = $data['account'];
$amount = $data['amount'];
$_SESSION['acct_num'] = mt_rand();
if(isset($_SESSION['username'])){
$fetch = mysqli_query($connect, "SELECT * FROM info WHERE username = '$_SESSION[username]'");

while($r = mysqli_fetch_array($fetch)){
    $_SESSION['user_id'] = $r['info_id'];
    $_SESSION['picture'] = $r['passport'];
    }   
 }

$insert = mysqli_query($connect,"INSERT INTO acct_type(name, acct_number, info_id) VALUES ('$acct_name','$_SESSION[acct_num]','$_SESSION[user_id]')");

if($insert){
    $response['success'] = true;
}else{
    $response['success'] = false;
    $response['message'] = mysqli_error($connect);
}

// if(isset($_SESSION['user_id'])){
//     $fetch = mysqli_query($connect,"SELECT * FROM acct_type WHERE info_id = '$_SESSION[user_id]' AND name = '$acct_name'");
//     while($r = mysqli_fetch_array($fetch)){
//         $acct_id = $r['acct_id'];
//         // echo '<p>'.$r['acct_id'].'</p><br/>';
//     }
    
//     // if(isset($_SESSION['acct_id'])){})
//     $inserted = mysqli_query($connect,"INSERT INTO transactions(credit,acct_id,info_id) 
//                             VALUES ('$amount','$acct_id','$_SESSION[user_id]'");
     
//     }                       
//         if($inserted){
//             $response['successAm'] = true;
//             $response['messageAm'] = 'Your account has been credited with N'. $amount;
//         }else{
//             $response['successAm'] = false;
//             $response['messageAm'] = mysqli_error($connect);
//         }

echo json_encode($response);
?>