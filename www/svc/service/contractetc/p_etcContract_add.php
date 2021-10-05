<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);


$sql = "
  INSERT INTO etcContract (
    customer_id, building_id, good_in_building_id,
    startTime, endTime, etc,
    createTime, createPerson, user_id)
  VALUES (
    {$_POST['customer']},
    {$_POST['building']},
    {$_POST['good']},
    '{$_POST['startTime']}',
    '{$_POST['endTime']}',
    '{$_POST['etc']}',
    now(),
    '{$_SESSION['manager_name']}',
    {$_SESSION['id']}
  )";
// echo $sql;//기타계약테이블에 입력

$result = mysqli_query($conn, $sql);

if(!$result){
  echo "<script>alert('저장과정에 문제가 생겼습니다. 하단에 표시된 이메일 info@leaseman.co.kr로 에러내용을 화면 캡쳐하여 보내주세요.(1)');
        history.back();
        </script>";
  error_log(mysqli_error($conn));
  exit();
} else {
  $id = mysqli_insert_id($conn); //방금넣은 계약번호아이디를 가져오는거
  // print_r($id);

  $sql2 = "
    INSERT INTO paySchedule2 (
      pAmount, pvAmount, ptAmount,
      payKind, executiveDate,
      etcContract_id, building_id, user_id)
    VALUES (
      '{$_POST['pAmount']}',
      '{$_POST['pvAmount']}',
      '{$_POST['ptAmount']}',
      '{$_POST['payKind']}',
      '{$_POST['executiveDate']}',
      {$id},
      {$_POST['building']},
      {$_SESSION['id']}
    )
  ";
  // echo $sql2;//청구테이블에다가 입력하는거

  $result2 = mysqli_query($conn, $sql2);

  if($result2){
    $payid = mysqli_insert_id($conn);

    $sql3 = "update etcContract
             set paySchedule2_id = {$payid}
             where id = {$id}
            ";
    // echo $sql3;
    $result3 = mysqli_query($conn, $sql3);

    if($result3){
      echo "<script>alert('저장하였습니다.');
            location.href='contractetc.php';
            </script>";
      exit();
    } else {
      echo "<script>alert('저장과정에 문제가 생겼습니다. 하단에 표시된 이메일 info@leaseman.co.kr로 에러내용을 화면 캡쳐하여 보내주세요.(3)');
            history.back();
            </script>";
      error_log(mysqli_error($conn));
      exit();
    }
  } else {
    echo "<script>alert('저장과정에 문제가 생겼습니다. 하단에 표시된 이메일 info@leaseman.co.kr로 에러내용을 화면 캡쳐하여 보내주세요.(2)');
          history.back();
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}



 ?>
