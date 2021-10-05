<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$sql_check = "select count(*) from fixcost
              where
                user_id = {$_SESSION['id']} and
                title = '{$_POST['title']}'
                ";
// echo $sql_check;

$result_check = mysqli_query($conn, $sql_check);
$row_check = mysqli_fetch_array($result_check);


// print_r($row_check);

if((int)$row_check[0] >= 1){
  echo "<script>
        alert('내역이 이미 존재하여 저장불가합니다. 다른 이름을 적어주세요.');
        location.href='fixcost.php';
        </script>";
  exit();
}

$sql = "insert into fixcost
        (building_id, title, amount1, amount2, amount3, vat, user_id)
        values
        ({$_POST['building']},
         '{$_POST['title']}',
         '{$_POST['amount1']}',
         '{$_POST['amount2']}',
         '{$_POST['amount3']}',
         '{$_POST['inlineRadioOptions']}',
         {$_SESSION['id']})
         ";
// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('저장하였습니다.');
           location.href='fixcost.php';
        </script>";
} else {
  echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.')
                location.href='fixcost.php'
          </script>";
}
 ?>
