<?php
session_start();
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = array();
$acct_type = $data['account'];
$amount = $data['amount'];
$debit = 0;

if(isset($_SESSION['username']) || isset($_SESSION['user'])){
    
    $check = mysqli_query($connect, "SELECT info_id, username, name, acct_id, passport FROM info join acct_type 
    using(info_id) where name = '$acct_type' and username = '$_SESSION[user]'");
   
    while($r = mysqli_fetch_array($check)){ 
        $_SESSION['user_id'] = $r['info_id'];
        $_SESSION['account_id'] = $r['acct_id'];
        $_SESSION['picture'] = $r['passport'];
        
    }
    // $add = mysqli_query($connect, "SELECT credit from transactions
    //                     WHERE acct_id='$_SESSION[account_id]' AND info_id='$_SESSION[user_id]'");
    //     while($r = mysqli_fetch_array($add)){
    //         $initial = $r['credit'];
    //         $response['initialMoneyInAccount'] = $r['credit'];
    //     }
    //     $current = $initial + $amount;

        $deposit = mysqli_query($connect,"INSERT INTO transactions(credit,debit,acct_id,info_id)
                                            VALUES('$amount','$debit','$_SESSION[account_id]','$_SESSION[user_id]')");
        
    if($deposit){
        $response['success'] = true;
        $response['message'] = $amount;
    }else{
        $response['success'] = false;
        $response['message'] = mysqli_error($deposit);
    }
    }
        echo json_encode($response);
        // print_r($_SESSION['user']);

?>