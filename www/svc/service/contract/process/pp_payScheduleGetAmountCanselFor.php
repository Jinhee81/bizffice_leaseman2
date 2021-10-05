<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

$a = json_decode($_POST['payIdArray']);
// $b = explode(',', $a);

// print_r($a);
// var_dump($a);


for ($i=0; $i < count($a); $i++) {


  $sql_u = "update paySchedule2
            set
              executiveDate = null,
              getAmount = null
            where idpaySchedule2 = {$a[$i]}
  ";
  // echo $sql_u;
  $result_u = mysqli_query($conn, $sql_u);

  if($result_u){
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
  } else {
    echo json_encode('update2');
    error_log(mysqli_error($conn));
    exit();
  }
}

include "../condi/sql_amount2.php";

echo json_encode($allRows);

?>