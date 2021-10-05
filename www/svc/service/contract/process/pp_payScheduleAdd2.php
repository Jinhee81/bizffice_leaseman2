<?php
//n개월추가 모달에서 청구설정버튼누르면 청구되는거, 계약스케줄에 청구번호추가되는거

header('Content-Type: text/html; charset=UTF-8');
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$mAmount = str_replace(',', '', $_POST['changeAmount1']);
$mvAmount = str_replace(',', '', $_POST['changeAmount2']);
$mtAmount = str_replace(',', '', $_POST['changeAmount3']);
$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
// print_r($filtered_id);

//================날짜유효성 체크
if($_POST['expectedDate']){
  if(!strtotime($_POST['expectedDate'])){
    echo json_encode('datetype1');
    exit();
  }
  
  $b = explode('-', $_POST['expectedDate']);
  
  $c = checkdate((int)$b[1], (int)$b[2], (int)$b[0]);
  // var_dump($b);
  
  if(!$c){
    echo json_encode('datetype2');
    exit();
  }
}
//입금예정일이 존재하는 경우 이렇게 반드시 날짜 유효성체크를 해야한다. 안그러면 에러남.



$sql1 = "select payOrder from realContract where id={$filtered_id}";
// echo $sql1;
$result1 = mysqli_query($conn, $sql1);
if(!$result1){
  echo json_encode('select1');
  error_log(mysqli_error($conn));
  exit();
}
$row1 = mysqli_fetch_array($result1);

$sql2 = "select count(*)
from contractSchedule
where realContract_id={$filtered_id}";
$result2 = mysqli_query($conn, $sql2);
if(!$result2){
  echo json_encode('select2');
  error_log(mysqli_error($conn));
  exit();
}
$row2 = mysqli_fetch_array($result2);

$sql3 = "select mEndDate
from contractSchedule
where realContract_id={$filtered_id} and
ordered = {$row2[0]}";
$result3 = mysqli_query($conn, $sql3);
if(!$result3){
  echo json_encode('select3');
  error_log(mysqli_error($conn));
  exit();
}
$row3 = mysqli_fetch_array($result3);

$new_order = $row2[0]+1;
$new_startDate = date("Y-n-j", strtotime($row3['mEndDate']."+1 day"));
$new_endDate = date("Y-n-j", strtotime($new_startDate."+1 month"."-1 day"));

if(!$_POST['expectedDate']){//예정일이 없이 넘어온 경우
  for ($i=0; $i < (int)$_POST['addMonth']; $i++) {
    $newArray[$i] = array();
    array_push($newArray[$i], $new_order, $new_startDate, $new_endDate);

    if($row1['payOrder']==='선납'){
      $new_expectedDate = date("Y-n-j", strtotime($new_startDate."-1 day"));
    } else {
      $new_expectedDate = date("Y-n-j", strtotime($new_endDate."+1 day"));
    }

    array_push($newArray[$i], $new_expectedDate);

    $new_order += 1;
    $new_startDate = date("Y-n-j", strtotime($new_endDate."+1 day"));
    $new_endDate = date("Y-n-j", strtotime($new_startDate."+1 month"."-1 day"));
  }

  for ($i=0; $i < count($newArray); $i++) {
    $sql4 = "
          INSERT INTO contractSchedule (
            ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
            mExpectedDate, realContract_id)
          VALUES (
            '{$newArray[$i][0]}',
            '{$newArray[$i][1]}',
            '{$newArray[$i][2]}',
            '{$mAmount}',
            '{$mvAmount}',
            '{$mtAmount}',
            '{$newArray[$i][3]}',
            {$filtered_id}
          )
    ";
    // echo $sql4;
    $result4 = mysqli_query($conn, $sql4);

    if($result4===false){
      echo json_encode('input1');
      // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(4)');
      //       history.back();
      //       </script>";
      error_log(mysqli_error($conn));
      exit();
    }

    $id4 = mysqli_insert_id($conn);//csid 추출

    $sql5 = "
          INSERT INTO paySchedule2 (
            csIdArray, orderArray, pStartDate, pEndDate, pAmount,
            pvAmount, ptAmount, pExpectedDate, paykind, getAmount, realContract_id, building_id, user_id, monthCount)
          VALUES (
            '{$id}',
            '{$newArray[$i][0]}',
            '{$newArray[$i][1]}',
            '{$newArray[$i][2]}',
            '{$mAmount}',
            '{$mvAmount}',
            '{$mtAmount}',
            '{$newArray[$i][3]}',
            '{$_POST['payKind']}',
            0,
            {$filtered_id},
            {$_POST['buildingId']},
            {$_SESSION['id']},
            1
          )";
    // echo $sql5;
    $result5 = mysqli_query($conn, $sql5);
    if($result5===false){
      echo json_encode('input2');

      // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(5)');
      //       history.back();
      //       </script>";
      error_log(mysqli_error($conn));
      exit();
    } else {
      $id5 = mysqli_insert_id($conn);//payid추$

      $sql6 = "
              UPDATE contractSchedule
              SET
                payId = {$id5},
                payIdOrder = 0
              WHERE idcontractSchedule = {$id4}
              ";
//      echo $sql6; //청구번호를 계약스케줄번호에 넣음
      $result6 = mysqli_query($conn, $sql6);
      if(!$result6){
        echo json_encode('update1');
        // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(6)');
        //          location.href='contractEdit.php?page=schedule&id=$filtered_id';
        //    </script>";
           error_log(mysqli_error($conn));
           exit();
      }
    }
  }
} else { //입금예정일이 없는 경우 끝나고 입금예정일 있는거 시작
  for ($i=0; $i < (int)$_POST['addMonth']; $i++) {
    $newArray[$i] = array();
    array_push($newArray[$i], $new_order, $new_startDate, $new_endDate);

    $new_expectedDate = $_POST['expectedDate'];

    array_push($newArray[$i], $new_expectedDate);

    $new_order += 1;
    $new_startDate = date("Y-n-j", strtotime($new_endDate."+1 day"));
    $new_endDate = date("Y-n-j", strtotime($new_startDate."+1 month"."-1 day"));
  }

  $contractScheduleIdArray = array();
  $orderedArray = array();
  $pAmountAccumulate = 0;
  $pvAmountAccumulate = 0;
  $ptAmountAccumulate = 0;

  for ($i=0; $i < count($newArray); $i++) {
    $sql4 = "
          INSERT INTO contractSchedule (
            ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
            mExpectedDate, realContract_id)
          VALUES (
            '{$newArray[$i][0]}',
            '{$newArray[$i][1]}',
            '{$newArray[$i][2]}',
            '{$mAmount}',
            '{$mvAmount}',
            '{$mtAmount}',
            '{$newArray[$i][3]}',
            {$filtered_id}
          )
    ";
    // echo $sql4;
    $result4 = mysqli_query($conn, $sql4);

    if($result4===false){
      echo json_encode('input3');

      // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(7)');
      //       history.back();
      //       </script>";
      error_log(mysqli_error($conn));
      exit();
    } else {
      $id = mysqli_insert_id($conn);
      array_push($contractScheduleIdArray, $id);
      array_push($orderedArray, $i);
      $pAmountAccumulate += (int)$mAmount;
      $pvAmountAccumulate += (int)$mvAmount;
      $ptAmountAccumulate += (int)$mtAmount;
    }
  }

  $pEndDateI = (int)$_POST['addMonth'] - 1;

  $contractScheduleIdArray2=implode(',', $contractScheduleIdArray);
  $orderedArray2=implode(',', $orderedArray);

  $sql5 = "
        INSERT INTO paySchedule2 (
          csIdArray, orderArray, pStartDate, pEndDate, pAmount,
          pvAmount, ptAmount, pExpectedDate, paykind, getAmount, realContract_id, building_id, user_id, monthCount)
        VALUES (
          '{$contractScheduleIdArray2}',
          '{$orderedArray2}',
          '{$newArray[0][1]}',
          '{$newArray[$pEndDateI][2]}',
          '{$pAmountAccumulate}',
          '{$pvAmountAccumulate}',
          '{$ptAmountAccumulate}',
          '{$_POST['expectedDate']}',
          '{$_POST['payKind']}',
          0,
          {$filtered_id},
          {$_POST['buildingId']},
          {$_SESSION['id']},
          {$_POST['addMonth']}
        )
      ";
  // echo $sql5;
  $result5 = mysqli_query($conn, $sql5);
  if(!$result5){
    echo json_encode('input4');

    // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(8)');
    //          location.href='contractEdit.php?page=schedule&id=$filtered_id';
    //    </script>";
       error_log(mysqli_error($conn));
       exit();
  } else {
    $id5 = mysqli_insert_id($conn);
    for ($i=0; $i < count($contractScheduleIdArray); $i++) {
      $sql6 = "
              UPDATE contractSchedule
              SET
                payId = '{$id5}',
                payIdOrder = {$orderedArray[$i]}
              WHERE idcontractSchedule = {$contractScheduleIdArray[$i]}
              ";
      // echo $sql2; //청구번호를 계약스케줄번호에 넣음
      $result6 = mysqli_query($conn, $sql6);
      if(!$result6){
        echo json_encode('update2');

        // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(9)');
        //          location.href='contractEdit.php?page=schedule&id=$filtered_id';
        //    </script>";
           error_log(mysqli_error($conn));
           exit();
      }
    }
  }

}//입금예정일 있는거 the end

$count2 = $row2[0] + (int)$_POST['addMonth'];
$sql7 = "select mEndDate
         from contractSchedule
         where realContract_id={$filtered_id} and
               ordered = {$count2}";
$result7 = mysqli_query($conn, $sql7);
if($result7===false){
  echo json_encode('select4');
  // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(10)');
  //       location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
  //       </script>";
  error_log(mysqli_error($conn));
  exit();
}
$row7 = mysqli_fetch_array($result7);

$sql8 = "UPDATE realContract SET
           count2 = {$count2},
           endDate2 = '{$row7['mEndDate']}',
           updateTime = now()
         WHERE
           id = {$filtered_id}
        ";
// echo $sql5;
$result8 = mysqli_query($conn, $sql8);
if($result8===false){
  echo json_encode('update3');
  // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(10)');
  //       location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
  //       </script>";
  error_log(mysqli_error($conn));
  exit();
}

echo json_encode('success');

// echo "<script>
//         location.href='contractEdit.php?page=schedule&id=$filtered_id';
//       </script>";


 ?>