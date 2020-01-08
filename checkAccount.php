<?php
session_start();
require_once 'connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = array();
$acct_num = $data['acctNumber'];

$query = "SELECT surname, mid_name, last_name FROM info
          WHERE info_id = (SELECT info_id FROM acct_type WHERE acct_number = '$acct_num')";
$check = mysqli_query($connect,$query);
$fetched = false;

while($row = mysqli_fetch_assoc($check)){
    $_SESSION['acct_name'] = $row['surname'];
    $_SESSION['acct_mid'] = $row['mid_name'];
    $_SESSION['acct_last'] = $row['last_name'];
    $fetched = true;
    // $user_id = $row['info_id'];
}
if($fetched){
    $response['success'] = true;
    $response['surname'] = $_SESSION['acct_name'];
    $response['midname'] = $_SESSION['acct_mid'];
    $response['lastname'] = $_SESSION['acct_last'];
}else{
    $response['success'] = false;
    $response['message'] = mysqli_error($connect);
}

echo json_encode($response);
?>