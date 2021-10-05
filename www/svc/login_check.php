<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include "view/conn.php";

$email = $_POST['email'];
$password = $_POST['password'];

$check = "SELECT * from user WHERE email = '{$email}' LIMIT 1";
$result = mysqli_query($conn, $check);
$row = mysqli_fetch_array($result);

if(!$row){
  echo "<script>
  alert('이메일이 조회되지 않습니다. 회원가입 또는 이메일/비밀번호를 확인해주세요');
  history.back();
  </script>";
} else {
  if ( $email == $row['email'] && $password == $row['password']){
      $_SESSION['is_login'] = true;
      $_SESSION['id'] = $row['id'];
      $_SESSION['email'] = $email;
      $_SESSION['user_div'] = $row['user_div'];
      $_SESSION['user_name'] = $row['user_name'];
      $_SESSION['manager_name'] = $row['manager_name'];
      $_SESSION['cellphone'] = $row['cellphone'];
      $_SESSION['smsnumber'] = $row['smsnumber'];
      $_SESSION['lease_type'] = $row['lease_type'];
      $_SESSION['created'] = $row['created'];
      $_SESSION['gradename'] = $row['gradename'];
      $_SESSION['popbillid'] = $row['popbillid'];
      $_SESSION['companynumber'] = $row['companynumber'];
      header('Location: /svc/main/main.php');
      exit();
    } else {
      echo "<script>
      alert('아이디 또는 비밀번호가 일치하지 않습니다.');
      history.back();
      </script>";

      // print_r($password);echo "<br>";
      // print_r($row['password']);
    }
}

 ?>