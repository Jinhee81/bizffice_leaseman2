<?php
//모달안에서 1개 청구취소하는 파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);//계약번호
settype($filtered_id, 'integer');

$sql = "
      DELETE from paySchedule2
      WHERE idpaySchedule2 = {$_POST['payId']}
";

// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  $sql2 = "
    UPDATE contractSchedule
    SET
      payId = null,
      payIdOrder = null
    WHERE
      realContract_id = {$filtered_id} and
      payId = {$_POST['payId']}
    ";
  // echo $sql2;
  
  $result2 = mysqli_query($conn, $sql2);

  if($result2){
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
    }

    include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_amount2.php";

    //echo $sql_sum;

    echo json_encode($allRows);

  } else {
    echo json_encode('update2');
    error_log(mysqli_error($conn));
    exit();
  }
}

?>