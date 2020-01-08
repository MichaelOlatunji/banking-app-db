<?php
session_start();
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'),true);
$response = array();
$acct_type = $data['account'];
$acct_num = $data['account_number'];
$amount = $data['money'];
$value = 0;

if(isset($_SESSION['balance'])){
    $balance = $_SESSION['balance'];

//balance fetched

$receipient = mysqli_query($connect, "SELECT info_id, acct_id FROM acct_type WHERE acct_number = '$acct_num'");

while($row = mysqli_fetch_array($receipient)){
    $receipient_info_id = $row['info_id'];
    $receipient_acct_id = $row['acct_id'];
}

if($balance > $amount){
    $deduct = mysqli_query($connect, "INSERT INTO transactions (credit,debit,acct_id,info_id)
                            VALUES ('$value','$amount','$_SESSION[account_id]','$_SESSION[user_id]')");

    $credits = mysqli_query($connect, "INSERT INTO transactions (credit,debit,acct_id,info_id) 
                             VALUES ('$amount','$value','$receipient_acct_id','$receipient_info_id')");
    if($deduct){
        $response['success'] = true;
        $response['message'] = "A sum of ".$amount." has been successfully transfered.";
    }else{
        echo mysqli_error($connect);
    }
    if($credits){
        $response['successRep'] = true;
        $response['messageRep'] = $_SESSION['acct_name']." ".$_SESSION['acct_mid']." ".$_SESSION['acct_last'].
                                    " has been credited with ".$amount;
    }else{
        echo mysqli_error($connect);
    }

}else{
    $response['success'] = false;
    $response['message'] = "The amount you have in your account is not sufficient";
    $response['error'] = mysqli_error($connect);
    // $response['balance'] = $balance;
}
}

    echo json_encode($response);

?>