<?php
//  삭제버튼 누르면 실행되는거, 계약스케줄을 삭제한다 

header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

// $a = explode(",", $_POST['contractScheduleIdArray']);
$a = json_decode($_POST['contractScheduleIdArray']);

for ($i=0; $i < count($a); $i++) {
  $sql = "
        delete from contractSchedule where idcontractSchedule={$a[$i]}
  ";
//   echo $sql;
  $result = mysqli_query($conn, $sql);

  if($result===false){
    echo json_encode('delete1');//삭제오류
    error_log(mysqli_error($conn));
  }
}

$query = "select count(*) from contractSchedule where realContract_id={$filtered_id}";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

$query2 = "
    select mEndDate
    from contractSchedule
    where realContract_id={$filtered_id} and ordered = {$row[0]}
    ";
$result2 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_array($result2);

$sql5 = "UPDATE realContract SET
           count2 = {$row[0]},
           endDate2 = '{$row2[0]}',
           updateTime = now()
         WHERE
           id = {$filtered_id}
        ";
// echo $sql5;
$result5 = mysqli_query($conn, $sql5);

if($result5===false){
  echo json_encode('update1');//수정오류
  error_log(mysqli_error($conn));
  exit();
}

include "../condi/sql_amount2.php";

echo json_encode($allRows);
?>