<!-- 문자상용구등록 처리파일 -->
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$escaped_title = htmlspecialchars($_POST['title']);
$escaped_description = htmlspecialchars($_POST['description']);

$sql1 = "select count(*)
         from sms
         where user_id={$_SESSION['id']} and
               screen = '{$_POST['screenName']}' and
               title = '{$escaped_title}'";
// echo $sql1;

$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

if((int)$row1[0]===1){
  echo "<script>
          alert('".$_POST['screenName']."에서 ".$escaped_title." 제목은 이미 존재합니다. 다른 제목을 넣어주세요.');
          history.back();
        </script>";
        error_log(mysqli_error($conn));
        exit();
}

$sql = "insert into sms
        (screen, title, description, user_id)
        VALUES
        ('{$_POST['screenName']}',
         '{$escaped_title}',
         '{$escaped_description}',
         {$_SESSION['id']})";
// echo $sql;

$result = mysqli_query($conn, $sql);

if(!$result){
  echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.')
                    location.href='smsSetting.php'
        </script>";
      error_log(mysqli_error($conn));
      exit();
}

echo "<script>
         history.back();
      </script>";

?>
