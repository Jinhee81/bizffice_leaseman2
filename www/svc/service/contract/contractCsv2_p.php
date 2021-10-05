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

$errorArray = array();

//================for i start
for ($i=0; $i < count($contractRow); $i++) {
  $j = $i+1;
  $sql1 = "
    select id, pay
    from building
    where bName='{$contractRow[$i][0]}' and
          user_id={$_SESSION['id']}";
  // echo $sql1;
  $result1 = mysqli_query($conn, $sql1);

  if(!$result1 || mysqli_num_rows($result1)===0){
    array_push($errorArray, "물건명 오류;".$j."행, ".$contractRow[$i][0]);
  }
  $row1 = mysqli_fetch_array($result1);

  $sql2 = "
    select id
    from group_in_building
    where gName='{$contractRow[$i][1]}' and
          building_id = {$row1['id']}";
  // echo $sql2;
  $result2 = mysqli_query($conn, $sql2);

  if(!$result2){
    array_push($errorArray, "그룹명 오류;".$j."행, ".$contractRow[$i][1]);
  }
  $row2 = mysqli_fetch_array($result2);

  $sql3 = "
    select id
    from r_g_in_building
    where rName='{$contractRow[$i][2]}' and
          group_in_building_id={$row2['id']}";
  // echo $sql3;
  $result3 = mysqli_query($conn, $sql3);

  if(!$result3){
    array_push($errorArray, "관리번호 오류;".$j."행, ".$contractRow[$i][2]);
  }
  $row3 = mysqli_fetch_array($result3);

  $sql4 = "
    select id
    from customer
    where name='{$contractRow[$i][3]}' and
          building_id = {$row1['id']} and
          user_id={$_SESSION['id']}";
  // echo $sql4;
  $result4 = mysqli_query($conn, $sql4);

  if(!$result4){
    array_push($errorArray, "입주자명 오류;".$j."행, ".$contractRow[$i][3]);
  }

}
//================for i end


if((int)$errorArray > 0){
  echo "오류 내용을 확인하세요.<br><br>";
  // print_r($errorArray);
  foreach ($errorArray as $key => $value) {
    echo $value."<br>";
  }
  echo "<br><br>";
  echo "물건명이 오류일 경우 전체가 오류 발생합니다. 반드시 물건명을 확인해주세요.";
} else {

  $errorArray2 = array();

  //==============================
  for ($i=0; $i < count($contractRow); $i++) {
    $sql1 = "
      select id, pay
      from building
      where bName='{$contractRow[$i][0]}' and
            user_id={$_SESSION['id']}";
    // echo $sql1;
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($result1);

    $sql2 = "
      select id
      from group_in_building
      where gName='{$contractRow[$i][1]}' and
            building_id = {$row1['id']}";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    $sql3 = "
      select id
      from r_g_in_building
      where rName='{$contractRow[$i][2]}' and
            group_in_building_id={$row2['id']}";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_array($result3);

    $sql4 = "
      select id
      from customer
      where name='{$contractRow[$i][3]}' and
            building_id = {$row1['id']} and
            user_id={$_SESSION['id']}";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_array($result4);

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
            ({$row1['id']},
            {$row2['id']},
            {$row3['id']},
            {$row4['id']},
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
      } else if($row1[$i]['pay']==='후납'){
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
              mExpectedDate, realContract_id)
            VALUES (
              {$contractRow[$i][11][$k][0]},
              '{$contractRow[$i][11][$k][1]}',
              '{$contractRow[$i][11][$k][2]}',
              '{$contractRow[$i][11][$k][3]}',
              '{$contractRow[$i][11][$k][4]}',
              '{$contractRow[$i][11][$k][5]}',
              '{$contractRow[$i][11][$k][6]}',
              {$id}
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

  if((int)$errorArray2>0){

    $content = "안녕하세요. 리스맨입니다.<br><br>"
              ."임대 계약건 저장에 관해 안내 말씀 드립니다.<br>"
              ."아래 데이터는 오류에 의해 저장하지 못하였으므로 데이터 확인 후 입력해주세요.<br><br><br>";

    foreach ($errorArray2 as $key => $value) {
      $content_detail .= $value."<br>";
    }
    $content .= $content_detail."<br><br>";
    $content .= "===========<br>
                 임대관리시스템 리스맨 (www.leaseman.co.kr)";

    // echo $content;

    $to      = 'bizffice@naver.com';
    $subject = '[리스맨]임대계약 데이터 안내건';
    // $headers = 'From: info@leaseman.co.kr' . "\r\n" .
    //     'Reply-To: info@leaseman.co.kr' . "\r\n" .
    //     'X-Mailer: PHP/' . phpversion();
    // $headers = 'Return-Path:<info@leaseman.co.kr>\n';

    $headers = 'From: info@leaseman.co.kr' . "\r\n" .
               'Reply-To: info@leaseman.co.kr' . "\r\n" .
               'Return-Path: info@leaseman.co.kr';

    mail($to, $subject, $content, $headers, "-f info@leaseman.co.kr");

    echo "아래 데이터는 저장하지 못했습니다.<br><br>";
    // print_r($errorArray);
    foreach ($errorArray2 as $key => $value) {
      echo $value."<br>";
    }
    echo "<br><br>";
    echo "나머지 데이터들은 저장 완료하였습니다. 위의 오류 내역은 이메일 ".$_SESSION['email']." 으로 발송하였으니 추후 반드시 확인하세요! ^__^<br>";
    echo "<a href='contract.php'>계약목록 바로가기</a>";
  } else {
    echo "<script>alert('계약을 저장하였습니다.');
          location.href = 'contract.php';
          </script>";
  }

}//else end}

 ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
