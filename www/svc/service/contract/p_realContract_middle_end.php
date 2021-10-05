<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


// print_r($_POST);echo "<br>";

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$filtered_enddate3 = mysqli_real_escape_string($conn, $_POST['enddate3']);

$sql = "UPDATE realContract
        SET
          endDate2 = '{$filtered_enddate3}',
          endDate3 = '{$filtered_enddate3}',
          updateTime = now()
        WHERE
          id = {$filtered_id}";
// echo $sql;

$result = mysqli_query($conn, $sql);

if(!$result){
  echo "<script>
    alert('수정과정에 문제가 생겼습니다. 하단 오류신고를 클릭하여 내용을 적어주세요.');
    history.back();
    </script>";
  error_log(mysqli_error($conn));
  exit();
} else {
  echo "<script>
        alert('중간종료처리 완료하였습니다.');
        location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
        </script>";
}
 ?>
