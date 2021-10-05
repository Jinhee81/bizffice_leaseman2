<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
// print_r($_POST);
// print_r($_SESSION);

$a = array();

foreach ($_POST as $key => $value) {
  array_push($a, mysqli_real_escape_string($conn, $value));
}

for ($i=0; $i < count($a)/11; $i++) {
  $contractRow[$i]=array();
} //$contractRow 라는 배열을 만듦

for ($i=0; $i < count($a); $i++) {
  if($i < 11){
    array_push($contractRow[0], $a[$i]);
  } elseif($i >= 11) {
    array_push($contractRow[floor($i/11)], $a[$i]);
  }
}

// print_r($contractRow);


//==============================
for ($i=0; $i < count($contractRow); $i++) {
  $sql1 = "
    select id, pay
    from building
    where id='{$contractRow[$i][0]}' and
          user_id={$_SESSION['id']}";
  // echo $sql1;
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_array($result1);

  // print_r($row1);

  $contractDate = date("Y-n-j", strtotime($contractRow[$i][4]));
  $startDate = date("Y-n-j", strtotime($contractRow[$i][8]));
  $endDate = date("Y-n-j", strtotime($startDate."+".$contractRow[$i][7]." month"."-1 day"));
  $mAmount = number_format($contractRow[$i][5]);
  $mvAmount = number_format($contractRow[$i][6]);
  $mtAmount = number_format((int)$contractRow[$i][5]+(int)$contractRow[$i][6]);
  $row = $i+1;

  $sql = "insert into realContract
          (building_id, group_in_building_id, r_g_in_building_id, customer_id, payOrder, monthCount, startDate, endDate, contractDate,
          mAmount, mvAmount, mtAmount,
          user_id, createTime, count2, endDate2)
          VALUES
          ({$contractRow[$i][0]},
          {$contractRow[$i][1]},
          {$contractRow[$i][2]},
          {$contractRow[$i][3]},
          '{$row1['pay']}',
          {$contractRow[$i][7]},
          '{$startDate}',
          '{$endDate}',
          '{$contractDate}',
          '{$mAmount}',
          '{$mvAmount}',
          '{$mtAmount}',
          {$_SESSION['id']},
          now(),
          {$contractRow[$i][7]},
          '{$endDate}'
          )";
  // echo $sql;

  $result = mysqli_query($conn, $sql);

  if(!$result){

    array_push($errorArray2, $row."행 ".$contractRow[$i][3]." 데이터 저장과정에 문제가 생겼습니다.");
  }

  $id = mysqli_insert_id($conn); //방금넣은 계약번호아이디를 가져오는거

  $mStartDate = $startDate; //초기시작일 가져오기

  for ($j=1; $j <= (int)$contractRow[$i][7]; $j++) {
    $contractRow[$i][11][$j] = array();

    $mEndDate = date("Y-n-j", strtotime($mStartDate."+1 month"."-1 day"));

    if($row1['pay']=='선납'){
      $mExpectedDate = $mStartDate;
    } else {
      $mExpectedDate = $mEndDate;
    }

    array_push($contractRow[$i][11][$j], $j, $mStartDate, $mEndDate, $mAmount, $mvAmount, $mtAmount, $mExpectedDate);

    $mStartDate = date("Y-n-j", strtotime($mEndDate."+1 day"));
  } //for j end

  // print_r($contractRow);


  for ($k=1; $k <= (int)$contractRow[$i][7]; $k++) {
    $sqlk = "
          INSERT INTO contractSchedule (
            ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
            mExpectedDate, realContract_id, user_id)
          VALUES (
            {$contractRow[$i][11][$k][0]},
            '{$contractRow[$i][11][$k][1]}',
            '{$contractRow[$i][11][$k][2]}',
            '{$contractRow[$i][11][$k][3]}',
            '{$contractRow[$i][11][$k][4]}',
            '{$contractRow[$i][11][$k][5]}',
            '{$contractRow[$i][11][$k][6]}',
            {$id},
            {$_SESSION['id']}
          )";
    // echo $sqlk;
    $resultk = mysqli_query($conn, $sqlk);
    // echo $sql2;

    if(!$resultk){
      array_push($errorArray2, $row."행 ".$contractRow[$i][3]." 데이터 스케쥴 저장과정에 문제가 생겼습니다.");
    }
  }//for k end

  $depositInDate = date("Y-n-j", strtotime($contractRow[$i][10]));
  $depositInMoney = number_format($contractRow[$i][9]);

  $sql_deposit = "
      insert into realContract_deposit
      (inDate, inMoney, remainMoney, saved, realContract_id)
      VALUES
      (
      '{$depositInDate}',
      '{$depositInMoney}',
      '{$depositInMoney}',
      now(),
      $id)";
  // echo $sql_deposit;

  $result_deposit = mysqli_query($conn, $sql_deposit);

  if($result_deposit===false){
    array_push($errorArray2, $row."행 ".$contractRow[$i][3]." 데이터 보증금 저장과정에 문제가 생겼습니다.");
  }

}//for i end
//============================

echo "<script>alert('계약을 저장하였습니다.');
      location.href = 'contract.php';
      </script>";
 ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
