<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$filtered = array(
  'description' => mysqli_real_escape_string($conn, $_POST['description'])
);

$title = mb_substr($filtered['description'], 0, 10);

// $sql = "
//   insert into board_question
//     (div1, title, description, created, status, user_id)
//   VALUES (
//     '{$_POST['div1']}',
//     '{$title}',
//     '{$filtered['description']}',
//     now(),
//     '처리중',
//     {$_SESSION['id']}
//   )";
//
// echo $sql;

// $result = mysqli_query($conn, $sql);
//
// if($result){
//   echo
//   "<script>
//   alert('문의가 정상등록되었습니다. 곧 연락드리겠습니다.');
//   location.href='questionlist.php';
//   </script>";
// } else {
//   echo
//   "<script>
//   alert('문제가 생겨 문의가 등록되지 않았습니다. 하단 이메일로 문의하고, 이메일 내용에 에러발생 내용을 알려주세요.');
//   history.back();
//   </script>";
//   error_log(mysqli_error($conn));
//   exit();
// }
//db저장은 나중에 만들자. 일단 메일로만 받자.

//리스맨에게 받는 메일
$to      = 'info@leaseman.co.kr';
$subject = '[리스맨]문의 '.$title;
$content = $_POST['description'];
$headers = 'From: '.$_POST['email'];
// $headers = 'From: info@leaseman.co.kr' . "\r\n" .
//     'Reply-To: info@leaseman.co.kr' . "\r\n" .
//     'X-Mailer: PHP/' . phpversion();
// $headers = 'Return-Path:<info@leaseman.co.kr>\n';

// $headers = 'From: info@leaseman.co.kr' . "\r\n" .
//            'Reply-To: info@leaseman.co.kr' . "\r\n" .
//            'Return-Path: info@leaseman.co.kr';

// mail($to, $subject, $content, $headers, "-f info@leaseman.co.kr");

mail($to, $subject, $content, $headers);

// //보내는사람한테 자동발송메일
// $to2      = $_POST['email'];
// $subject2 = '[리스맨] 문의가 접수되었습니다.';
// $content2 = '최대한 빠르게 답변해드리겠습니다.';
// $headers2 = 'From: info@leaseman.co.kr';
// mail($to2, $subject2, $content2, $headers2);

echo "<script>alert('정상접수되었습니다. 최대한 빠르게 연락드릴께요.');
  history.back();
  </script>";
 ?>
