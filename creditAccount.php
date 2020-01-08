<?php 
session_start();
require 'connect.php';
$data = json_decode(file_get_contents('php://input'),true);
$response = array();
$acct_name = $data['account'];
$amount = $data['amount'];
$debit = 0;
$value = 1;

if(isset($_SESSION['user_id'])){
$fetch = mysqli_query($connect,"SELECT * FROM acct_type WHERE info_id = '$_SESSION[user_id]' AND name = '$acct_name'");
while($r = mysqli_fetch_array($fetch)){
    $_SESSION['acct_id'] = $r['acct_id'];
    // echo '<p>'.$r['acct_id'].'</p><br/>';
      }}

if(isset($_SESSION['acct_id'])){
$inserted = mysqli_query($connect,"INSERT INTO transactions(credit,debit,acct_id,info_id) 
                        VALUES ('$amount','$debit','$_SESSION[acct_id]','$_SESSION[user_id]')");
 }
                       
    if($inserted){
        $response['success'] = true;
        $response['message'] = 'Your account has been credited with N'. $amount;
        $response['account'] = 'Your account number is '.$_SESSION['acct_num'];
    }else{
        $response['success'] = false;
        $response['message'] = mysqli_error($connect);
    }

    echo json_encode($response);
?>