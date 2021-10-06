<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";

print_r($_POST);
// print_r($_SESSION);

$fil = array(
    'etc' => mysqli_real_escape_string($conn, $_POST['etc'])
);

$filtered_id = mysqli_real_escape_string($conn, $_POST['etcContract_id']); //기타계약번호
//
$sql = "
  UPDATE etcContract
  SET
    good_in_building_id = {$_POST['good']},
    startTime = '{$_POST['startTime']}',
    endTime = '{$_POST['endTime']}',
    etc = '{$fil['etc']}',
    updateTime = now(),
    updatePerson = '{$_SESSION['manager_name']}'
  WHERE id = {$filtered_id}
";

// echo $sql;

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<script>alert('수정과정에 문제가 생겼습니다. 관리자에게 문의하세요.(1)');
        location.href = 'contractetc_edit.php?id=$filtered_id';
        </script>";
    error_log(mysqli_error($conn));
    exit();
}
//
$sql2 = "
  UPDATE paySchedule2
  SET
    pAmount = '{$_POST['pAmount']}',
    pvAmount = '{$_POST['pvAmount']}',
    ptAmount = '{$_POST['ptAmount']}',
    payKind = '{$_POST['payKind']}',
    executiveDate = '{$_POST['executiveDate']}',
    getAmount = '{$_POST['ptAmount']}'
  WHERE
    etcContract_id = {$filtered_id}";
// echo $sql2;//청구테이블에다가 입력하는거
//
$result2 = mysqli_query($conn, $sql2);
//
if (!$result2) {
    echo "<script>alert('수정과정에 문제가 생겼습니다. 관리자에게 문의하세요.(2)');
        location.href = 'contractetc_edit.php?id=$filtered_id';
        </script>";
    error_log(mysqli_error($conn));
    exit();
}

echo "<script>alert('수정하였습니다.');
      location.href = 'contractetc_edit.php?id=$filtered_id';
      </script>";
