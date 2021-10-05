<?php
//여러개를 청구취소하는 파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);
$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

$a = json_decode($_POST['payIdArray']);
// print_r($a);

for ($i=0; $i < count($a); $i++) {
    $sql_drop = "
                delete from paySchedule2 where idpaySchedule2={$a[$i][0]}";
    // echo $sql_drop;
    $result_drop = mysqli_query($conn, $sql_drop);
    if($result_drop){
      $sql2 = "
              update contractSchedule
              set
                payId = null,
                payIdOrder = null
              where payId = {$a[$i][0]} and realContract_id={$filtered_id}";
              //계약스케줄에서 청구번호와 청구순번 없애기
      // echo $sql2;

      $result2 = mysqli_query($conn, $sql2);

      if($result2){
        $sql3 = "UPDATE realContract SET
                   updateTime = now()
                 WHERE
                   id = {$filtered_id}
                ";
        // echo $sql5;
        $result3 = mysqli_query($conn, $sql3);

        if(!$result3){
          echo json_encode('update1');
          error_log(mysqli_error($conn));
          exit();
        }
      } else {
        echo json_encode('update2');
        error_log(mysqli_error($conn));
        exit();
      }
    } else {
      echo json_encode('update3');
      error_log(mysqli_error($conn));
      exit();
    }
}//for end

include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_amount2.php";

echo json_encode($allRows);

?>