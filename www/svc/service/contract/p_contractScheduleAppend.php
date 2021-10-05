<!-- 1개월추가 버튼 누르면 실행되는 파일 -->
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);


$sql1 = "select payOrder from realContract where id={$filtered_id}";
// echo $sql1;
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

$sql2 = "select count(*) from contractSchedule where realContract_id={$filtered_id}";
// echo $sql2;
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);

$sql3 = "select
                mEndDate, mMamount, mVmAmount, mTmAmount
         from contractSchedule
         where realContract_id={$filtered_id} and
               ordered={$row2[0]}";
// echo $sql3;
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_array($result3);

$new_order = $row2[0]+1;
$new_startDate = date("Y-n-j", strtotime($row3['mEndDate']."+1 day"));
$new_endDate = date("Y-n-j", strtotime($new_startDate."+1 month"."-1 day"));

if($row1[0]==='선납'){
  $new_expectedDate = date("Y-n-j", strtotime($new_startDate."-1 day"));
} else if($row1[0]==='후납'){
  $new_expectedDate = date("Y-n-j", strtotime($new_endDate));
}

$sql4 = "
      INSERT INTO contractSchedule (
        ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
        mExpectedDate, realContract_id)
      VALUES (
        $new_order,
        '{$new_startDate}',
        '{$new_endDate}',
        '{$row3['mMamount']}',
        '{$row3['mVmAmount']}',
        '{$row3['mTmAmount']}',
        '{$new_expectedDate}',
        {$filtered_id}
      )
";
// echo $sql4;
$result4 = mysqli_query($conn, $sql4);

if($result4){
  $sql5 = "UPDATE realContract SET
             count2 = {$new_order},
             endDate2 = '{$new_endDate}',
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

  echo "<script>
            location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
        </script>";
} else {
  echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
        history.back()';
        </script>";
  error_log(mysqli_error($conn));
}



?>
