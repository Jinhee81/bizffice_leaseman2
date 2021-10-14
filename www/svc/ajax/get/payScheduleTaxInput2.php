<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
header("Content-Type: text/html; charset=UTF-8");

$a = json_decode($_POST['taxArray']);

// print_r($a);

for ($i=0; $i < count($a); $i++) {
  $sql = "update paySchedule2
          set
              taxSelect = '{$_POST['taxSelect']}',
              taxDate = '{$_POST['taxDate']}'
          WHERE
              idpaySchedule2 = {$a[$i][1]->청구번호}";
//   echo $sql;

  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo json_encode("error_occured");
    error_log(mysqli_error($conn));
    exit();
  }
}

echo json_encode("success");


 ?>