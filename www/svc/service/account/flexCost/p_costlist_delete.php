<!-- 지출입력화면에서 고정비를 추가하는 프로세스파일 -->
<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

print_r($_POST);

$sql = "delete from costlist
        where id={$_POST['id']}";

echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('삭제하였습니다.');
           location.href='flexCost.php';
        </script>";
} else {
  echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
                    history.back();
        </script>";
      error_log(mysqli_error($conn));
      exit();
}

 ?>
