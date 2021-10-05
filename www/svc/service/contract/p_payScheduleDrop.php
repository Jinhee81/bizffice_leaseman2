<!-- 모달안에서 1개 청구취소하는 파일 -->
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['realContract_id']);//계약번호
settype($filtered_id, 'integer');

$sql = "
      DELETE from paySchedule2
      WHERE idpaySchedule2 = {$_POST['payid']}
";

// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  $sql2 = "
    UPDATE contractSchedule
    SET
      payId = null,
      payIdOrder = null
    WHERE
      realContract_id = {$filtered_id} and
      payId = {$_POST['payid']}
    ";
  // echo $sql2;
  $result2 = mysqli_query($conn, $sql2);

  if($result2){
    $sql5 = "UPDATE realContract SET
               updateTime = now()
             WHERE
               id = {$filtered_id}
            ";
    // echo $sql5;
    $result5 = mysqli_query($conn, $sql5);

    if($result5===false){
      echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
            history.back();
            </script>";
      error_log(mysqli_error($conn));
      exit();
    }

    // echo "<script>
    //         alert('청구취소하였습니다.');
    //         history.back();
    //       </script>";
    echo "<script>
            location.href='contractEdit.php?page=schedule&id=$filtered_id';
          </script>";
  } else {
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
          history.back();
          </script>";
    error_log(mysqli_error($conn));
    exit();
}


}
?>
