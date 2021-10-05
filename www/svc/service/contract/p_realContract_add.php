<!-- 이거는 고객등록하자마자 계약등록할 때 처리하는 프로세스파일 -->
<?php
//업데이트 - 20.8.11, 종료일에 스케쥴종료일을 맞추어버림


header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$customer_id = $_POST['customerId'];

if(!$_POST['group']){
  echo "<script>
        alert('그룹명이 입력되어야 합니다. 환경설정에서 물건정보를 완성하세요.');
        location.href = '../setting/building.php';
        </script>";
  exit();
}

if(!$_POST['room']){
  echo "<script>
        alert('관리호수가 입력되어야 합니다. 환경설정에서 물건정보를 완성하세요.');
        location.href = '../setting/building.php';
        </script>";
  exit();
}

$date = array($_POST['contractDate'], $_POST['startDate'], $_POST['endDate'], $_POST['executiveDate']);

for ($i=0; $i < count($date); $i++) {
  if($date[$i]){
    if(!strtotime($date[$i])){
      echo "<script>
            alert('$date[$i]은 날짜형식이 아닙니다. 날짜형식에 맞추어서 입력해주세요 (날짜형식:yyyy-mm-dd)');
            history.back();
            </script>";
      exit();
    }

    $b = explode('-', $date[$i]);

    $c = checkdate((int)$b[1], (int)$b[2], (int)$b[0]);
    // var_dump($b);

    if(!$c){
      echo "<script>
            alert('$date[$i] 날짜는 존재하지 않습니다. 다시 확인해주세요.');
            history.back();
            </script>";
      exit();
    }
  }
}


$currentDateTime = date('Y-m-d H:i:s');
// echo $currentDateTime;

$sql = "
  INSERT INTO realContract (
    customer_id, building_id, group_in_building_id, r_g_in_building_id,
    payOrder, monthCount, startDate, endDate, contractDate,
    mAmount, mvAmount, mtAmount,
    user_id, createTime, count2, endDate2)
  VALUES (
    {$customer_id},
    {$_POST['building']},
    {$_POST['group']},
    {$_POST['room']},
    '{$_POST['payOrder']}',
    {$_POST['monthCount']},
    '{$_POST['startDate']}',
    '{$_POST['endDate']}',
    '{$_POST['contractDate']}',
    '{$_POST['mAmount']}',
    '{$_POST['mvAmount']}',
    '{$_POST['mtAmount']}',
    {$_SESSION['id']},
    now(),
    {$_POST['monthCount']},
    '{$_POST['endDate']}'
  )
";

// echo $sql."<br>";
//
$result = mysqli_query($conn, $sql);

if(!$result){
  echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(화면캡쳐하고 관련내용을 이메일 info@leaseman.co.kr로 보내주세요).(1)');
        history.back();
        </script>";
  error_log(mysqli_error($conn));
  exit();
}

$id = mysqli_insert_id($conn); //방금넣은 계약번호아이디를 가져오는거

$sql_deposit = "
        INSERT INTO realContract_deposit
          (inDate, inMoney, remainMoney, saved, realContract_id)
        VALUES (
          '{$_POST['depositInDate']}',
          '{$_POST['depositInAmount']}',
          '{$_POST['depositInAmount']}',
          now(),
          $id
        )
";
// echo $sql_deposit;
$result_deposit = mysqli_query($conn, $sql_deposit);

if($result_deposit===false){
  echo "<script>alert('보증금 저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(화면캡쳐하고 관련내용을 이메일 info@leaseman.co.kr로 보내주세요).');
        history.back();
        </script>";
  error_log(mysqli_error($conn));
  exit();
}

$mStartDate = date("Y-n-j", strtotime($_POST['startDate'])); //초기시작일 가져오기

for ($i=1; $i <= (int)$_POST['monthCount']; $i++) {

    $contractRow[$i] = array();
    $mEndDate = date("Y-n-j", strtotime($mStartDate."+1 month"."-1 day"));

    if($_POST['payOrder']==='선납'){
      $mExpectedDate = date("Y-n-j", strtotime($mStartDate."-1 day"));
    } else if($_POST['payOrder']==='후납'){
      $mExpectedDate = date("Y-n-j", strtotime($mEndDate."+1 day"));
    }

    array_push($contractRow[$i], $i, $mStartDate, $mEndDate, $_POST['mAmount'], $_POST['mvAmount'], $_POST['mtAmount'], $mExpectedDate);
    // print_r($i);
    $mStartDate = date("Y-n-j", strtotime($mEndDate."+1 day"));
}

// echo 'bbbbb';

if ($_POST['endDate'] != $mEndDate){
  // echo '정상적으로 스케쥴 생성되지 않았음<br>';
  $last_month = (int)$_POST['monthCount'];
  // print_r($last_month); echo "<br>";
  $contractRow[$last_month][2] = $date[2];
  // print_r($contractRow[$last_month][2]);echo "<br>";

} //우와 2020년에 윤달이 있어서 종료일자가 안맞음, 그래서 이걸로 확인체크하는것은 없애기로 함

// print_r($contractRow);

$contractScheduleIdArray = array();
$orderedArray = array();
$pAmountAccumulate = 0;
$pvAmountAccumulate = 0;
$ptAmountAccumulate = 0;

for ($i=1; $i <= count($contractRow); $i++) {
  $sql2 = "
        INSERT INTO contractSchedule (
          ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
          mExpectedDate, realContract_id)
        VALUES (
          {$contractRow[$i][0]},
          '{$contractRow[$i][1]}',
          '{$contractRow[$i][2]}',
          '{$contractRow[$i][3]}',
          '{$contractRow[$i][4]}',
          '{$contractRow[$i][5]}',
          '{$contractRow[$i][6]}',
          {$id}
        )
  ";
  // echo $sql2;
  $result2 = mysqli_query($conn, $sql2);


  if($result2===false){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(화면캡쳐하고 관련내용을 이메일 info@leaseman.co.kr로 보내주세요).(2)');
          history.back();
          </script>";
    error_log(mysqli_error($conn));
    exit();
  } else {
    $id2 = mysqli_insert_id($conn);
    array_push($contractScheduleIdArray, $id2);
    array_push($orderedArray, $i);
  }
}

if($_POST['executiveDate']){//입금일이 있을때
  $contractScheduleIdArray2 = array();
  $orderedArray2 = array();
  for ($i=0; $i < (int)$_POST['executiveCount']; $i++) {
    array_push($contractScheduleIdArray2, $contractScheduleIdArray[$i]);
    array_push($orderedArray2, $orderedArray[$i]);
  }
  $contractScheduleIdArray3=implode(',', $contractScheduleIdArray2);
  $orderedArray3=implode(',', $orderedArray2);

  $a = (int)$_POST['executiveCount'] - 1;

  $sql3 = "select mEndDate
           from contractSchedule
           where idcontractSchedule = $contractScheduleIdArray[$a]";
  $result3 = mysqli_query($conn, $sql3);

  if(!$result3){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(화면캡쳐하고 관련내용을 이메일 info@leaseman.co.kr로 보내주세요).(3)');
          history.back();
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }

  $row3 = mysqli_fetch_array($result3);

  $pAmount = (int)str_replace(',', '', $_POST['mAmount']);
  $pvAmount = (int)str_replace(',', '', $_POST['mvAmount']);
  $ptAmount = (int)str_replace(',', '', $_POST['mtAmount']);

  $pAmount = $pAmount * (int)$_POST['executiveCount'];
  $pvAmount = $pvAmount * (int)$_POST['executiveCount'];
  $ptAmount = $ptAmount * (int)$_POST['executiveCount'];

  $pAmount = number_format($pAmount);
  $pvAmount = number_format($pvAmount);
  $ptAmount = number_format($ptAmount);

  $sql4 = "
          INSERT INTO paySchedule2 (
            csIdArray, orderArray, pStartDate, pEndDate, pAmount,
            pvAmount, ptAmount, pExpectedDate, paykind, executiveDate, getAmount, realContract_id, building_id, user_id, monthCount)
          VALUES (
            '{$contractScheduleIdArray3}',
            '{$orderedArray3}',
            '{$_POST['startDate']}',
            '{$row3[0]}',
            '{$pAmount}',
            '{$pvAmount}',
            '{$ptAmount}',
            '{$_POST['executiveDate']}',
            '{$_POST['payKind']}',
            '{$_POST['executiveDate']}',
            '{$ptAmount}',
            {$id},
            {$_POST['building']},
            {$_SESSION['id']},
            {$_POST['executiveCount']}
          )";
  // echo $sql4;
  $result4 = mysqli_query($conn, $sql4);

  if(!$result4){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(화면캡쳐하고 관련내용을 이메일 info@leaseman.co.kr로 보내주세요).(4)');
          history.back();
          </script>";
    error_log(mysqli_error($conn));
    exit();
  } else {
    $id3 = mysqli_insert_id($conn);
    for ($i=0; $i < (int)$_POST['executiveCount']; $i++) {
      $sql5 = "
              UPDATE contractSchedule
              SET
                payId = '{$id3}',
                payIdOrder = {$i}
              WHERE idcontractSchedule = {$contractScheduleIdArray[$i]}
              ";
      // echo $sql2; //청구번호를 계약스케줄번호에 넣음
      $result5 = mysqli_query($conn, $sql5);
      if(!$result5){
        echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(화면캡쳐하고 관련내용을 이메일 info@leaseman.co.kr로 보내주세요).(5)');
              history.back();
              </script>";
           error_log(mysqli_error($conn));
           exit();
      }
    }
  }
}

echo "<script>
      location.href = 'contractEdit.php?page=schedule&id=$id';
      </script>";


 ?>
