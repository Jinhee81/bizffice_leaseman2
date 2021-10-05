<!-- 청구설정버튼누르면 청구되는거, 계약스케줄에 청구번호추가되는거 -->

<?php
header('Content-Type: text/html; charset=UTF-8');
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);
$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
// print_r($filtered_id);

$a = json_decode($_POST['scheduleArray']);
// print_r($a);
//
for ($i=0; $i < count($a); $i++) {
  $sql3 = "
          UPDATE contractSchedule
            SET
              mMamount = {$a[$i][4]},
              mVmAmount = {$a[$i][5]},
              mTmAmount = {$a[$i][6]}
            WHERE
              idcontractSchedule = {$a[$i][0]}";
  // echo $sql3;
  $result3 = mysqli_query($conn, $sql3);
  if($result3===false){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(1)')
                  location.href='contractEdit.php?page=schedule&id=$filtered_id'
            </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}//이작업을해야지 계약스케줄의 행별로 바뀐금액이 저장이 된다



$expectedDateArray = array(); //입금예정일만 모인 배열을 만듦
for ($i=0; $i < count($a); $i++) {
  array_push($expectedDateArray, $a[$i][7]);
}

// print_r($expectedDateArray);
//
$expectedDateArray2= array_keys(array_count_values($expectedDateArray)); //입금예정일만 모인 배열에서 중복된 값 제거함
//
// // print_r($expectedDateArray2);
//
//
for ($i=0; $i < count($expectedDateArray2); $i++) {
  $contractScheduleIdArray = array();
  $orderedArray = array();
  $startDate = array();
  $pAmountAccumulate = 0;
  $pvAmountAccumulate = 0;
  $ptAmountAccumulate = 0;

  for ($j=0; $j < count($a); $j++) {
    if($a[$j][7] == $expectedDateArray2[$i]){

      array_push($contractScheduleIdArray, $a[$j][0]);
      array_push($orderedArray, $a[$j][1]);
      array_push($startDate, $a[$j][2]);

      $payExecutiveRow[$i][0]=implode(',', $contractScheduleIdArray);
      $payExecutiveRow[$i][1]=implode(',', $orderedArray);

      $payExecutiveRow[$i][2]=$startDate[0];//시작일
      $payExecutiveRow[$i][3]=$a[$j][3];//종료일

      $pAmountAccumulate += $a[$j][4];
      $pvAmountAccumulate += $a[$j][5];
      $ptAmountAccumulate += $a[$j][6];

      $payExecutiveRow[$i][4]=number_format($pAmountAccumulate);//공급가액
      $payExecutiveRow[$i][5]=number_format($pvAmountAccumulate);//세액
      $payExecutiveRow[$i][6]=number_format($ptAmountAccumulate);//합계

      $payExecutiveRow[$i][7]=$a[$j][7];//예정일
      $payExecutiveRow[$i][8]=$a[$j][8];//입금구분
      $payExecutiveRow[$i][9] += 1;//청구개월수

    }
  }
}

// print_r($payExecutiveRow);
for ($i=0; $i < count($payExecutiveRow); $i++) {
  if($payExecutiveRow[$i][6]===0){
    echo "<script>
            alert('0원은 청구 불가합니다.');
            location.href='contractEdit.php?page=schedule&id=$filtered_id';
          </script>";
    exit();
  }
}

for ($i=0; $i < count($payExecutiveRow); $i++) {
  $sql = "
        INSERT INTO paySchedule2 (
          csIdArray, orderArray, pStartDate, pEndDate, pAmount,
          pvAmount, ptAmount, pExpectedDate, paykind, getAmount, realContract_id, building_id, user_id, monthCount)
        VALUES (
          '{$payExecutiveRow[$i][0]}',
          '{$payExecutiveRow[$i][1]}',
          '{$payExecutiveRow[$i][2]}',
          '{$payExecutiveRow[$i][3]}',
          '{$payExecutiveRow[$i][4]}',
          '{$payExecutiveRow[$i][5]}',
          '{$payExecutiveRow[$i][6]}',
          '{$payExecutiveRow[$i][7]}',
          '{$payExecutiveRow[$i][8]}',
          0,
          {$filtered_id},
          {$_POST['buildingId']},
          {$_SESSION['id']},
          {$payExecutiveRow[$i][9]}
        )
      ";
  // echo $sql;
  $result = mysqli_query($conn, $sql);
  if($result === true){
    $paySid = mysqli_insert_id($conn); //방금넣은 청구번호아이디를 가져오는거
    $contractScheduleIdArray2 = explode(',', $payExecutiveRow[$i][0]);

    for ($j=0; $j < count($contractScheduleIdArray2); $j++) {
      // code...
      $sql2 = "
              UPDATE contractSchedule
              SET
                payId = '{$paySid}',
                payIdOrder = {$j}
              WHERE idcontractSchedule = {$contractScheduleIdArray2[$j]}
              ";
      // echo $sql2; //청구번호를 계약스케줄번호에 넣음
      $result2 = mysqli_query($conn, $sql2);
      if(!$result2){
        echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(4)');
                 location.href='contractEdit.php?page=schedule&id=$filtered_id';
           </script>";
           error_log(mysqli_error($conn));
           exit();
      }
    }
  } else {
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(2)');
             location.href='contractEdit.php?page=schedule&id=$filtered_id';
       </script>";
       error_log(mysqli_error($conn));
       exit();
  }
}

$sql5 = "UPDATE realContract SET
           updateTime = now()
         WHERE
           id = {$filtered_id}
        ";
// echo $sql5;
$result5 = mysqli_query($conn, $sql5);

if($result5===false){
  echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(3)');
        location.href = 'contractEdit.php?page=schedule&id=$filtered_id';
        </script>";
  error_log(mysqli_error($conn));
  exit();
}

echo "<script>
        location.href='contractEdit.php?page=schedule&id=$filtered_id';
      </script>";
 ?>
