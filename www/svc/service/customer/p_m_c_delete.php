<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$filtered = array(
  'cid' => mysqli_real_escape_string($conn, $_POST['cid']), //고객아이디
  'sid' => mysqli_real_escape_string($conn, $_SESSION['id']) //세션,로그인아이디
);

settype($filtered['cid'], 'integer');
settype($filtered['sid'], 'integer');

$sql_check = "select count(*)
              from realContract
              where customer_id={$filtered['cid']}";
$result_check = mysqli_query($conn, $sql_check);
$row_check = mysqli_fetch_array($result_check);

if((int)$row_check[0]>0){
  echo "<script>alert('계약이 존재하여 삭제할 수 없습니다.');
  history.back();</script>";
  exit();
} else {
  $sql = "DELETE from customer where
          id = {$filtered['cid']} and user_id={$filtered['sid']}";
  // echo $sql;
  $result = mysqli_query($conn, $sql);
  if ($result){
    echo "<script>alert('삭제하였습니다');
    location.href='customer.php';</script>";
  } else {
    echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
    history.back();</script>";
    error_log(mysqli_error($conn));
  }
}


?>
