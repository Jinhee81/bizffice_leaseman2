<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$sql1 = "delete
         from r_g_in_building
         where group_in_building_id = {$_POST['groupId']}
        ";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "delete
         from group_in_building
         where id = {$_POST['groupId']}
        ";
$result2 = mysqli_query($conn, $sql2);

echo "<script>alert('삭제하였습니다.');
  location.href='building.php';
  </script>";
?>
