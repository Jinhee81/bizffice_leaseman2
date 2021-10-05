<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$sql = "delete from fixcost
        where id={$_POST['id']} and
              user_id={$_SESSION['id']}
         ";
// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('삭제하였습니다.');
           location.href='fixcost.php';
        </script>";
} else {
  echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.')
                location.href='fixcost.php'
          </script>";
}
 ?>
