<!--  -->
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
header('Content-Type: text/html; charset=UTF-8');
// print_r($_POST);
// print_r($_SESSION);

$escaped_title = htmlspecialchars($_POST['title']);
$escaped_description = htmlspecialchars($_POST['description']);

$sql = "update sms
        set
          screen = '{$_POST['screenName']}',
          title = '{$escaped_title}',
          description = '{$escaped_description}'
        where
          id = {$_POST['id']} and
          user_id = {$_SESSION['id']}";
// echo $sql;

$result = mysqli_query($conn, $sql);

if(!$result){
  echo "<script>alert('수정과정에 문제가 생겼습니다. 관리자에게 문의하세요.')
                    location.href='smsSetting.php'
        </script>";
      error_log(mysqli_error($conn));
      exit();
}

echo "<script>
         history.back();
      </script>";

?>
