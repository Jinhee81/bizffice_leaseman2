<?php //고객수정파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['cid']);


settype($filtered_id, 'integer');

// print_r($fil);


$sql = "
  UPDATE customer
  SET
    qDate = '{$_POST['qDate']}',
    contact1 = '{$_POST['contact1']}',
    contact2 = '{$_POST['contact2']}',
    contact3 = '{$_POST['contact3']}',
    etc = '{$_POST['etc']}',
    updated = now(),
    updatePerson = '{$_SESSION['manager_name']}'
  WHERE id = {$filtered_id}
";

// echo $sql;

$result = mysqli_query($conn, $sql);
if($result){
  echo "<script>alert('수정하였습니다.');
  history.back();
  </script>";
} else {
  echo "<script>alert('수정 과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
  history.back();
  </script>";
  error_log(mysqli_error($conn));
}

?>
