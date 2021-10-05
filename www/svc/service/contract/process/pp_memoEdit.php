<?php
//메모수정하는 파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$filtered_memoid = mysqli_real_escape_string($conn, $_POST['memoId']);
$filtered_creator = mysqli_real_escape_string($conn, $_POST['memoCreator']);
$filtered_content = mysqli_real_escape_string($conn, $_POST['memoContent']);
//
$sql = "UPDATE realContract_memo
        SET
            memoCreator = '{$filtered_creator}',
            memoContent = '{$filtered_content}',
            updated = now()
        where
            idrealContract_memo = {$filtered_memoid} and
            realContract_id = {$filtered_id}
        ";
// echo $sql;
$result = mysqli_query($conn, $sql);
//
if($result){
    include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_memo.php";

    //echo $sql_sum;
    echo json_encode($memoRows);
} else {
  echo json_encode('update1');
  error_log(mysqli_error($conn));
}
 ?>