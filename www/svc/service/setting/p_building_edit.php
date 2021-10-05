<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered = array(
  'id' => mysqli_real_escape_string($conn, $_POST['id']),
  'name' => mysqli_real_escape_string($conn, $_POST['name']),
  'pay' => mysqli_real_escape_string($conn, $_POST['pay']),
  'popbillid' => mysqli_real_escape_string($conn, $_POST['popbillid']),
  'cNumber1' => mysqli_real_escape_string($conn, $_POST['cNumber1']),
  'cNumber2' => mysqli_real_escape_string($conn, $_POST['cNumber2']),
  'cNumber3' => mysqli_real_escape_string($conn, $_POST['cNumber3']),
  'contact1' => mysqli_real_escape_string($conn, $_POST['contact1']),
  'contact2' => mysqli_real_escape_string($conn, $_POST['contact2']),
  'contact3' => mysqli_real_escape_string($conn, $_POST['contact3']),
  'etc' => mysqli_real_escape_string($conn, $_POST['etc'])
);

$sql  = "
    UPDATE building
    SET
      bName = '{$filtered['name']}',
      pay = '{$filtered['pay']}',
      popbillid = '{$filtered['popbillid']}',
      cnumber1 = '{$filtered['cNumber1']}',
      cnumber2 = '{$filtered['cNumber2']}',
      cnumber3 = '{$filtered['cNumber3']}',
      contact1 = '{$filtered['contact1']}',
      contact2 = '{$filtered['contact2']}',
      contact3 = '{$filtered['contact3']}',
      etc = '{$filtered['etc']}',
      updated = now()
    WHERE
      id = {$_POST['id']}
    ";
// echo $sql;
// var_dump($_POST['id']);

$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('수정하였습니다.');
  location.href='building.php';
  </script>";
} else {
  echo "<script>alert('수정과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
  location.href='building.php';
  </script>";
}


?>
