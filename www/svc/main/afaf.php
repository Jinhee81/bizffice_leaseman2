<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
include $_SERVER['DOCUMENT_ROOT']."svc/view/conn.php";

//////////////////////////////////////////
// 2020.03.25 oni4jazz@fs
// 
$_SESSION['is_login'] = true;
$_SESSION['id'] = '00000001';
$_SESSION['email'] = 'info@leaseman.co.kr';
$_SESSION['user_div'] = '개인';
$_SESSION['user_name'] = '유진희';
$_SESSION['cellphone'] = '010-0000-0000';
$_SESSION['lease_type'] = '공유오피스';
$_SESSION['created'] = '2020-3-15 15:35:29';
$_SESSION['gradename'] = 'star2';
header('Location: /svc/main/main.php');
exit;
/////////////////////////////////////////////



include "password.php";

$email = $_POST['email'];
$password = $_POST['password'];

$check = "SELECT * from user WHERE email = '{$email}' LIMIT 1";
$result = mysqli_query($conn, $check);
$row = mysqli_fetch_array($result);

if($row){
  echo "<script>
  alert('이메일아이디가 조회되지 않습니다.회원가입 또는 이메일/비밀번호를 확인해주세요');
  location.href='login.php';
  </script>";
} else {
 // if ( $email === $row['email'] && password_verify($password, $row['password'])){
  $_SESSION['is_login'] = true;
  $_SESSION['id'] = $row['id'];
  $_SESSION['email'] = $email;
  $_SESSION['user_div'] = $row['user_div'];
  $_SESSION['user_name'] = $row['user_name'];
  $_SESSION['cellphone'] = $row['cellphone'];
  $_SESSION['lease_type'] = $row['lease_type'];
  $_SESSION['created'] = $row['created'];
  $_SESSION['gradename'] = $row['gradename'];
  header('Location: svc/main/main.php');
  exit();
//   } else {
//   echo "<script>
//   alert('아이디 또는 비밀번호가 일치하지 않습니다.');
//   location.href='login.php';
//   </script>";
//   }
}

//========================= 이메일인증까지 하려다가 그러면 너무 복잡해져서 사용자유입이 적어질것 같아서 삭제하기로 함 하지만 이메일성공, 실패 유무로 진짜 이메일인지 가짜 이메일인지 파악해야 해서 데이타베이스에서 이메일인증하는 부분은 남기기로 함

// $check_emailauth = "select emailauth from user
//                     where email = '{$email}' LIMIT 1";
// $result_emailauth = mysqli_query($conn, $check_emailauth);
// $row_emailauth = mysqli_fetch_array($result_emailauth);
//
// // print_r($row_emailauth);
//
// if($row_emailauth[0] === 'no'){
//   echo "<script>
//   alert('이메일인증을 완료해야 리스맨 사용이 가능합니다. 이메일을 확인하세요.');
//   location.href='login.php';
//   </script>";
// }
// ======================================

 ?>
