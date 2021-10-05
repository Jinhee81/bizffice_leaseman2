<?php
//메모입력하면 실행되는파일, 이거저장한다고 일부러 계약을 업데이트하지 않았다. 계약에 물려있는 업데이트가 많아서 이것까지하면 오히려 헷갈림 
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$filtered_inputer = mysqli_real_escape_string($conn, $_POST['memoInputer']);
$filtered_content = mysqli_real_escape_string($conn, $_POST['memoContent']);

$sql = "INSERT INTO realContract_memo
        (memoCreator, memoContent, created, realContract_id)
        VALUES
        (
        '{$filtered_inputer}',
        '{$filtered_content}',
         now(),
         {$filtered_id}
        )
        ";
// echo $sql;
$result = mysqli_query($conn, $sql);

if($result){
    include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_memo.php";

    //echo $sql_sum;
    echo json_encode($memoRows);
} else {
  echo json_encode('input1');
  error_log(mysqli_error($conn));
}
 ?>