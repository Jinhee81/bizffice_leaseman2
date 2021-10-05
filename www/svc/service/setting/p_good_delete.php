<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$filtered = array(
  // 'building_id' => mysqli_real_escape_string($conn, $_POST['building_id']), //건물아이디
  'id' => mysqli_real_escape_string($conn, $_POST['id']), //상품아이디
  // 'good' => mysqli_real_escape_string($conn, $_POST['good']) //상품명
);
// settype($filtered['building_id'], 'integer');
settype($filtered['id'], 'integer');
//
$sql = "DELETE from good_in_building where id = {$filtered['id']}";
// echo $sql;
$result = mysqli_query($conn, $sql);
if ($result){
  echo "<script>alert('삭제하였습니다');
  location.href='building.php';</script>";
} else {
  echo "삭제할 수 없습니다.";
  error_log(mysqli_error($conn));
}
?>
