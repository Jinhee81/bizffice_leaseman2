<!-- 메모수정하는 파일 -->

<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$filtered_memoid = mysqli_real_escape_string($conn, $_POST['memoid']);
$filtered_creater = mysqli_real_escape_string($conn, $_POST['memoCreator']);
$filtered_content = mysqli_real_escape_string($conn, $_POST['memoContent']);
//
$sql = "UPDATE realContract_memo
        SET
            memoCreator = '{$filtered_creater}',
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
  echo "<script>
           location.href='contractEdit.php?page=memo&id=$filtered_id'
        </script>";
} else {
  echo "<script>alert('메모 수정 과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
        location.href = 'contractEdit.php?page=memo&id=$filtered_id';
        </script>";
  error_log(mysqli_error($conn));
}
 ?>
