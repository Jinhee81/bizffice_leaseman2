<?php
session_start();
include("../view/conn.php");


print_r($_POST);

$filtered = array(
  'title' => mysqli_real_escape_string($conn, $_POST['title']),
  'description' => mysqli_real_escape_string($conn, $_POST['description'])
);

// $sql = "
//   insert into board_question
//     (div1, title, description, created, status, user_id)
//   VALUES (
//     '{$_POST['div1']}',
//     '{$filtered['title']}',
//     '{$filtered['description']}',
//     now(),
//     '처리중',
//     {$_SESSION['id']}
//   )";
//
// echo $sql;
//
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
 ?>
