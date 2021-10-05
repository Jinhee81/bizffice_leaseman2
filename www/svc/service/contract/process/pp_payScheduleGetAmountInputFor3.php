<?php
//즉시입금버튼 누르면 실행되는거
header('Content-Type: text/html; charset=UTF-8');
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

$a = json_decode($_POST['scheduleArray']);

// print_r($a);

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
    echo json_encode('update1');
    error_log(mysqli_error($conn));
    exit();
  }
}//이작업을해야지 계약스케줄의 행별로 바뀐금액이 저장이 된다
//
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
      $payExecutiveRow[$i][8]=$_POST['paykind'];//수납구분
      $payExecutiveRow[$i][9] += 1;//청구개월수

    }
  }
}

// print_r($payExecutiveRow);
for ($i=0; $i < count($payExecutiveRow); $i++) {
  if($payExecutiveRow[$i][6]===0){
    echo json_encode('logical');//0원청구불가
    exit();
  }
}

for ($i=0; $i < count($payExecutiveRow); $i++) {
  $sql = "
        INSERT INTO paySchedule2 (
          csIdArray, orderArray, pStartDate, pEndDate, pAmount,
          pvAmount, ptAmount, pExpectedDate, paykind, getAmount, executiveDate, realContract_id, building_id, user_id, monthCount)
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
          '{$payExecutiveRow[$i][6]}',
          '{$payExecutiveRow[$i][7]}',
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
        echo json_encode('update2');
           error_log(mysqli_error($conn));
           exit();
      }
    }
  } else {
    echo json_encode('input1');

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
  echo json_encode('update3');

  error_log(mysqli_error($conn));
  exit();
}

include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_amount2.php";

//echo $sql_sum;
echo json_encode($allRows);

?>