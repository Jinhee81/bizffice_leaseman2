<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$array = json_decode($_POST['array']);

for ($i=0; $i < count($array); $i++) {
  $array[$i][2] = substr($array[$i][2], -9);
}
// print_r($array);


for ($i=0; $i < count($array); $i++) {
  $sql = "INSERT INTO room
            (idbuilding, idgroup, idroom, idcustomer)
          VALUES (
            {$_POST['buildingId']},
            {$_POST['groupId']},
            {$array[$i][1]},
            {$array[$i][2]})";
  // echo $sql;
  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
          location.href = 'contractCustomer.php';
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}

echo "<script>alert('저장되었습니다.');
      location.href = 'contractCsv.php';
      </script>";
 ?>
