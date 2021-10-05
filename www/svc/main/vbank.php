<!-- 도로 정기결제 가져옴, 이 파일이 엄청 중요함, 이걸로 작업 예정, 절대 지우면 안됌 ㅠ-->

<?php

session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>무통장입금</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

 ?>
<h1>무통장입금해야 이용가능합니다.</h1>
</body>
<html>
