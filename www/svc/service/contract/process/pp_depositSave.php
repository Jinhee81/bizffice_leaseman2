<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);
$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

$_POST['depositInAmount'] = number_format($_POST['depositInAmount']);
$_POST['depositOutAmount'] = number_format($_POST['depositOutAmount']);
$_POST['depositMoney'] = number_format($_POST['depositMoney']);
$sql = "update
          realContract_deposit set
            inDate = '{$_POST['depositInDate']}',
            inMoney = '{$_POST['depositInAmount']}',
            outDate = '{$_POST['depositOutDate']}',
            outMoney = '{$_POST['depositOutAmount']}',
            remainMoney = '{$_POST['depositMoney']}',
            saved = now()
          where realContract_id = {$filtered_id}
       ";
// echo $sql;
$result = mysqli_query($conn, $sql);
if($result){
  include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_amount2.php";

  //echo $sql_sum;
  echo json_encode($allRows);
} else {
  echo json_encode('update1');//수정오류
  error_log(mysqli_error($conn));
}
 ?>