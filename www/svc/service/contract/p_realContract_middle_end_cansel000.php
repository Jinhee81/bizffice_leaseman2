<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


// print_r($_POST);echo "<br>";

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$rPayid = mysqli_real_escape_string($conn, $_POST['rPayid']);

// var_dump($rPayid);echo "<br>";

$sql = "select count2 from realContract where id={$filtered_id}";
$result = mysqli_query($conn, $sql);
if(!$result){
  echo json_encode("error_occured1");
  error_log(mysqli_error($conn));
  exit();
}
$row = mysqli_fetch_array($result);


$sql2 = "select mEndDate from contractSchedule
         where realContract_id={$filtered_id} and
               ordered = {$row['count2']}";
$result2 = mysqli_query($conn, $sql2);
if(!$result){
  echo json_encode("error_occured2");
  error_log(mysqli_error($conn));
  exit();
}
$row2 = mysqli_fetch_array($result2);

if((int)$rPayid > 0){
    $sql4 = "delete from paySchedule2 where idpaySchedule2 = {$rPayid}";
    // echo $sql4;

    $result4 = mysqli_query($conn, $sql4);
    if(!$result4){
      echo json_encode("error_occured4");
      error_log(mysqli_error($conn));
      exit();
    }
}

// echo 11;

$sql3 = "UPDATE realContract
        SET
          endDate2 = '{$row2['mEndDate']}',
          endDate3 = null,
          rAmount = null,
          rvAmount = null,
          rtAmount = null,
          rKind = null,
          rDate = null,
          rPayid = null,
          updateTime = now()
        WHERE
          id = {$filtered_id}";
// echo $sql;

$result3 = mysqli_query($conn, $sql3);

if(!$result3){
  echo json_encode("error_occured3");
  error_log(mysqli_error($conn));
  exit();
} else {
  echo json_encode("success");
}
 ?>