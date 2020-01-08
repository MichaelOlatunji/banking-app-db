<?php
session_start();
require_once 'connect.php';
$response = array();

if(isset($_SESSION['user'])){
    $fetch = mysqli_query($connect,"SELECT credit,debit FROM info JOIN transactions 
                            USING(info_id) WHERE username='$_SESSION[user]'");

    // while($r = mysqli_fetch_array($fetch)){
    //     array_push($response,$r['credit'],$r['debit']);
    //     print_r($response);
    //     // $response['credit'] = $r['credit'];
    //     // $response['debit'] = $r['debit'];
        
    // }
    $data = mysqli_fetch_all($fetch,MYSQLI_ASSOC);
    
}
echo json_encode($data);
// echo json_encode($response);
?>