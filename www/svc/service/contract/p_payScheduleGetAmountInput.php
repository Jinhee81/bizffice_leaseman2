<!-- 청구설정 모달안 입금완료버튼 누르면 실행되는거 -->
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['realContract_id']);
// print_r($filtered_id);

// $_POST['pgetAmount'] = number_format($_POST['pgetAmount']); 이게 입금예정리스트화면에선 에러가 나서 주석처리했음

$sql = "
      UPDATE paySchedule2
      SET
        pExpectedDate = '{$_POST['pExpectedDate']}',
        payKind = '{$_POST['paykind']}',
        executiveDate = '{$_POST['pgetdate']}',
        getAmount = '{$_POST['pgetAmount']}'
      WHERE idpaySchedule2 = {$_POST['payid']}
";

// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){

  $sql5 = "UPDATE realContract SET
             updateTime = now()
           WHERE
             id = {$filtered_id}
          ";
  // echo $sql5;
  $result5 = mysqli_query($conn, $sql5);

  if(!$result5){
    echo "<script>alert('입금처리 과정에 문제가 생겼습니다. 관리자에게 문의하세요(2).');
          history.back();
          </script>";
    // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(2).');
    //       </script>";
    error_log(mysqli_error($conn));
    exit();
  }
} else {
  echo "<script>alert('입금처리 과정에 문제가 생겼습니다. 관리자에게 문의하세요(1).');
        history.back();
        </script>";
  error_log(mysqli_error($conn));
  exit();
}

echo "<script>
        location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
      </script>";
?>
