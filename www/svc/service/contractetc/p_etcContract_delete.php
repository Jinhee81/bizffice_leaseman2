<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

print_r($_POST);
print_r($_SESSION);

$a = json_decode($_POST['contractArray']);

for ($i=0; $i < count($a); $i++) {
  $sql = "delete from etcContract
          where id = {$a[$i][1]}
          ";
  echo $sql;
  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(1)');
          location.href = 'contractetc_edit.php?id=$filtered_id';
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }

  $sql2 = "delete from paySchedule2
           where etcContract_id={$a[$i][1]} and
                 taxDate is null";
  echo $sql2;
  $result2 = mysqli_query($conn, $sql2);

  if(!$result2){
    echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(2)');
          location.href = 'contractetc_edit.php?id=$filtered_id';
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}

echo "<script>alert('삭제하였습니다.');
      location.href = 'contractetc.php';
      </script>";
 ?>
