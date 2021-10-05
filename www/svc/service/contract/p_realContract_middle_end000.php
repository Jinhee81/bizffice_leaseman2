<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


// print_r($_POST);echo "<br>";

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$filtered_enddate3 = mysqli_real_escape_string($conn, $_POST['enddate3']);//중간종료일
$filtered_enddate4 = mysqli_real_escape_string($conn, $_POST['enddate4']);//환불일자
$amount = mysqli_real_escape_string($conn, $_POST['middleEndAmount']);
$avamount = mysqli_real_escape_string($conn, $_POST['middleEndAvmount']);
$atamount = mysqli_real_escape_string($conn, $_POST['middleEndAtmount']);
$executiveDiv2 = mysqli_real_escape_string($conn, $_POST['executiveDiv2']);
$buildingId = mysqli_real_escape_string($conn, $_POST['buildingId']);

$amount = (int)str_replace(',', '', $amount);
$avamount = (int)str_replace(',', '', $avamount);
$atamount = (int)str_replace(',', '', $atamount);

$sql1 = "update realContract set
          endDate3 = '{$filtered_enddate3}',
          rAmount = {$amount},
          rvAmount = {$avamount},
          rtAmount = {$atamount},
          rKind = '{$executiveDiv2}',
          rDate = '{$filtered_enddate4}',
          updateTime = now()
         where id={$filtered_id}
        ";
// echo $sql1;

$result1 = mysqli_query($conn, $sql1);

if(!$result1){
  echo json_encode("error_occured_1");
  exit();
}

if($atamount > 0) {
  $sql2 = "insert into paySchedule2
  (pAmount, pvAmount, ptAmount, executiveDate, payKind, getAmount, realContract_id, building_id, user_id)
 values
   (
   '-{$amount}',
   '-{$avamount}',
   '-{$atamount}',
   '{$filtered_enddate4}',
   '{$executiveDiv2}',
   '-{$atamount}',
   {$filtered_id},
   {$buildingId},
   {$_SESSION['id']}
  )
  ";
// echo $sql2;
  $result2 = mysqli_query($conn, $sql2);

  if(!$result2){
  echo json_encode("error_occured_2");
  exit();
  }

  $rPayid = mysqli_insert_id($conn);

  $sql3 = "
          update realContract 
          set rPayid={$rPayid} 
          where id={$filtered_id}
          ";
  $result3 = mysqli_query($conn, $sql3);

  if(!$result3) {
    echo json_encode("error_occured_3");
    exit();
  }

}

echo json_encode('success');
 ?>