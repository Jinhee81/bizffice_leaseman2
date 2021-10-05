<?php
// n개월추가 버튼 누르면 실행되는 파일

header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);


$sql1 = "select payOrder from realContract where id={$filtered_id}";
// echo $sql1;
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
// print_r($row1);

$sql2 = "select count(*) from contractSchedule where realContract_id={$filtered_id}";
// echo $sql2;
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);

$sql3 = "select
                mEndDate, mMamount, mVmAmount, mTmAmount
         from contractSchedule
         where realContract_id={$filtered_id} and
               ordered={$row2[0]}";
// echo $sql3;
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_array($result3);

$new_order = $row2[0]+1;
$new_startDate = date("Y-n-j", strtotime($row3['mEndDate']."+1 day"));
$new_endDate = date("Y-n-j", strtotime($new_startDate."+1 month"."-1 day"));

for ($i=0; $i < (int)$_POST['addMonth']; $i++) {
  $newArray[$i] = array();
  array_push($newArray[$i], $new_order, $new_startDate, $new_endDate);

  if($row1['payOrder']==='선납'){
    $new_expectedDate = date("Y-n-j", strtotime($new_startDate."-1 day"));
  } else {
    $new_expectedDate = date("Y-n-j", strtotime($new_endDate));
  }
  array_push($newArray[$i], $new_expectedDate);

  $new_order += 1;
  $new_startDate = date("Y-n-j", strtotime($new_endDate."+1 day"));
  $new_endDate = date("Y-n-j", strtotime($new_startDate."+1 month"."-1 day"));
}

// print_r($newArray);
// echo '1111';

for ($i=0; $i < count($newArray); $i++) {
  $sql4 = "
        INSERT INTO contractSchedule (
          ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
          mExpectedDate, realContract_id)
        VALUES (
          '{$newArray[$i][0]}',
          '{$newArray[$i][1]}',
          '{$newArray[$i][2]}',
          '{$_POST['changeAmount1']}',
          '{$_POST['changeAmount2']}',
          '{$_POST['changeAmount3']}',
          '{$newArray[$i][3]}',
          {$filtered_id}
        )
  ";
//   echo $sql4;
  $result4 = mysqli_query($conn, $sql4);

  if($result4===false){
    echo json_encode('input1');//입력오류
    error_log(mysqli_error($conn));
    exit();
  }
}


$sql5 = "UPDATE realContract SET
           count2 = {$new_order}-1,
           endDate2 = '{$newArray[count($newArray)-1][2]}',
           updateTime = now()
         WHERE
           id = {$filtered_id}
        ";
// echo $sql5;
$result5 = mysqli_query($conn, $sql5);

if($result5===false){
  echo json_encode('input2');//입력오류
  error_log(mysqli_error($conn));
  exit();
}

// echo "<script>
//      location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
//      </script>";

include "../condi/sql_amount2.php";

// echo $sql_sum;

echo json_encode($allRows);
?>