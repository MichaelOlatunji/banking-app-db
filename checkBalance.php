<?php
session_start();
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = array();
$acct_type = $data['account'];

if(isset($_SESSION['username']) || isset($_SESSION['user'])){
    
    $check = mysqli_query($connect, "SELECT info_id, username, name, acct_id, passport FROM info join acct_type 
    using(info_id) where name = '$acct_type' and username = '$_SESSION[user]'");
   
    while($r = mysqli_fetch_array($check)){
        // echo "sucessfully fetched";
        $_SESSION['user_id'] = $r['info_id'];
        $_SESSION['account_id'] = $r['acct_id'];
        $_SESSION['picture'] = $r['passport'];
        // echo $r['info_id'].$r['acct_id'].$r['passport'];
        // echo $r['info_id'];
    }
$checkBal = mysqli_query($connect,"SELECT sum(credit) - sum(debit) as balance FROM transactions WHERE acct_id='$_SESSION[account_id]' and info_id='$_SESSION[user_id]'");

    while($r = mysqli_fetch_array($checkBal)){
        $_SESSION['balance'] = $r['balance'];
    }
    if($checkBal){
        $response['success'] = true;
        $response['balance'] = $_SESSION['balance'];
    }
        }
        echo json_encode($response);
        // print_r($_SESSION['user']);

?>