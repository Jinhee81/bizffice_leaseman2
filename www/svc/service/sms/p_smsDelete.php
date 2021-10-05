<!-- 문자상용구등록 처리파일 -->
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
header('Content-Type: text/html; charset=UTF-8');
// print_r($_POST);
// print_r($_SESSION);


$sql = "delete from sms
        where
         user_id = {$_SESSION['id']} and
         id = {$_POST['smsid']}";
// echo $sql;

$result = mysqli_query($conn, $sql);

if(!$result){
  echo "<script>alert('삭제 과정에 문제가 생겼습니다. 관리자에게 문의하세요.')
                    location.href='smsSetting.php'
        </script>";
      error_log(mysqli_error($conn));
      exit();
}

echo "<script>alert('삭제하였습니다.');
         location.href='smsSetting.php';
      </script>";

?>
