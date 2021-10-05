<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered = array(
  'id' => mysqli_real_escape_string($conn, $_POST['id'])
);

$sql  = "
    DELETE
      FROM building
      WHERE
        id = {$filtered['id']}
    ";

$result = mysqli_query($conn, $sql);

if($result === false){
  echo "<script>
  alert('삭제할 수 없습니다. 건물안 그룹이 존재합니다.');
  location.href='building.php';
  </script>";
  // echo mysqli_error($conn);
} else {
  echo "<script>alert('삭제하였습니다.');
  location.href='building.php';
  </script>";
}
?>
