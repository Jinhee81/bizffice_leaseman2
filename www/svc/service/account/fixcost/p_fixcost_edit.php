<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$sql = "update fixcost
        set
          building_id = {$_POST['buildingE']},
          title = '{$_POST['titleE']}',
          amount1 = '{$_POST['amount1E']}',
          amount2 = '{$_POST['amount2E']}',
          amount3 = '{$_POST['amount3E']}',
          vat = '{$_POST['inlineRadioOptionsE']}'
        where id = {$_POST['fixcostid']}
         ";
// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('수정하였습니다.');
           location.href='fixcost.php';
        </script>";
} else {
  echo "<script>alert('수정과정에 문제가 생겼습니다. 관리자에게 문의하세요.')
                location.href='fixcost.php'
          </script>";
}
 ?>
