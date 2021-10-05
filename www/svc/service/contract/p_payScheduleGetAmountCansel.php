<!-- 청구설정 모달안 입금취소버튼 누르면 실행되는거 -->
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$sql = "
      UPDATE paySchedule2
      SET
        executiveDate = null,
        getAmount = null
      WHERE idpaySchedule2 = {$_POST['payid']}
";

// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){
  $sql5 = "UPDATE realContract SET
             updateTime = now()
           WHERE
             id = {$_POST['realContract_id']}
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
  //         alert('입금취소하였습니다.');
  //         location.href = 'contractEdit.php?id=$_POST[realContract_id]';
  //       </script>";
  echo "<script>
          location.href = 'contractEdit.php?page=schedule&id=$_POST[realContract_id]';
        </script>";
} else {
  echo "<script>alert('입금취소하는 과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
        history.back();
        </script>";
  error_log(mysqli_error($conn));
  exit();
}
?>
