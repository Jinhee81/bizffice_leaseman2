<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$contractRow = json_decode($_POST['contractArray']);
// print_r($contractRow);

for ($i=0; $i < count($contractRow); $i++) {
  $sql = "
    DELETE from contractSchedule
          where realContract_id={$contractRow[$i][1]}
  ";
  // echo $sql;
  $result = mysqli_query($conn, $sql);

  $sql3 = "
    delete from realContract_deposit
          where realContract_id={$contractRow[$i][1]}
  ";
  // echo $sql3;보증금삭제
  $result3 = mysqli_query($conn, $sql3);

  if($result && $result3){
    $sql2 = "
          DELETE from realContract
            where id={$contractRow[$i][1]} and
                  user_id={$_SESSION['id']}
    ";
    // echo $sql2;계약삭제
    $result2 = mysqli_query($conn, $sql2);

    if(!$result2){
      echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(1)');
            location.href = 'contract.php';
            </script>";
      error_log(mysqli_error($conn));
      exit();
    }
  } else {
    echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(2)');
          location.href = 'contract.php';
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}

echo "<script>alert('삭제하였습니다.');
      location.href = 'contract.php';
      </script>";

 ?>
