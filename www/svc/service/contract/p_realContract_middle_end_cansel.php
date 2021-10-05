<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


// print_r($_POST);echo "<br>";

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

$sql = "select count2 from realContract where id={$filtered_id}";
$result = mysqli_query($conn, $sql);
if(!$result){
  echo "<script>
    alert('수정과정에 문제가 생겼습니다. 하단 오류신고를 클릭하여 내용을 적어주세요.(1)');
    history.back();
    </script>";
  error_log(mysqli_error($conn));
  exit();
}
$row = mysqli_fetch_array($result);


$sql2 = "select mEndDate from contractSchedule
         where realContract_id={$filtered_id} and
               ordered = {$row['count2']}";
$result2 = mysqli_query($conn, $sql2);
if(!$result){
  echo "<script>
    alert('수정과정에 문제가 생겼습니다. 하단 오류신고를 클릭하여 내용을 적어주세요.(2)');
    history.back();
    </script>";
  error_log(mysqli_error($conn));
  exit();
}
$row2 = mysqli_fetch_array($result2);


$sql3 = "UPDATE realContract
        SET
          endDate2 = '{$row2['mEndDate']}',
          endDate3 = '',
          updateTime = now()
        WHERE
          id = {$filtered_id}";
// echo $sql;

$result3 = mysqli_query($conn, $sql3);

if(!$result3){
  echo "<script>
    alert('수정과정에 문제가 생겼습니다. 하단 오류신고를 클릭하여 내용을 적어주세요.(3)');
    history.back();
    </script>";
  error_log(mysqli_error($conn));
  exit();
} else {
  echo "<script>
        alert('중간종료 취소 하였습니다.');
        location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
        </script>";
}
 ?>
