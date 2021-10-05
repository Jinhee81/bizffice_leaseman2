<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "password.php";

// $password = $_POST['password'];
// $hash = password_hash($password, PASSWORD_DEFAULT);

// print_r($_POST);

$sql = "select password from user where id={$_POST['email']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if(password_verify($_POST['password2'], $row[0])){
  echo "<script>
  alert('기존 비밀번호와 동일해서 변경 불가합니다.');
  location.href='password_change.php';
  </script>";
} else {
  $password = $_POST['password2'];
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = "update user set password = '{$hash}' where id={$_SESSION['id']}";

  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>
    alert('비밀번호를 변경하였습니다.');
    location.href='myinfo.php';
    </script>";
  }
}

?>