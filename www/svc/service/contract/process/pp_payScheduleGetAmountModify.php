<?php
//청구설정 모달안 수정버튼 누르면 실행되는거
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id= $_POST['contractId'];

$sql = "
      UPDATE paySchedule2
      SET
        pExpectedDate = '{$_POST['pExpectedDate']}',
        payKind = '{$_POST['payKind']}',
        executiveDate = '{$_POST['executiveDate']}'
      WHERE idpaySchedule2 = {$_POST['payid']}
";

// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  $sql5 = "UPDATE realContract SET
             updateTime = now()
           WHERE
             id = {$filtered_id}
          ";
  // echo $sql5;
  $result5 = mysqli_query($conn, $sql5);

  if($result5===false){
    echo json_encode('update1');
    error_log(mysqli_error($conn));
    exit();
  } else {
    include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_amount2.php";

    //echo $sql_sum;
    echo json_encode($allRows);
  }
} else {
  echo json_encode('update2');
  error_log(mysqli_error($conn));
  exit();
}


?>