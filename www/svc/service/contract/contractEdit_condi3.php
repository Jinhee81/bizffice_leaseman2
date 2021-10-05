<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//계약번호
settype($filtered_id, 'integer');

$sql = "
      select
          realContract.id,
          customer.id,
          customer.name,
          customer.companyname,
          customer.div2,
          customer.div3,
          customer.contact1,
          customer.contact2,
          customer.contact3,
          customer.etc,
          realContract.building_id,
          (select bName from building where id=realContract.building_id) as bname,
          group_in_building_id,
          (select gName from group_in_building where id=group_in_building_id) as gname,
          r_g_in_building_id,
          (select rName from r_g_in_building where id=r_g_in_building_id) as rname,
          payOrder,
          monthCount,
          startDate,
          endDate,
          contractDate,
          mAmount,
          mvAmount,
          mtAmount,
          count2,
          endDate2,
          endDate3,
          realContract.createTime,
          realContract.updateTime
      from
          realContract
      left join customer
          on realContract.customer_id = customer.id
      where realContract.id = {$filtered_id} and
            realContract.user_id = {$_SESSION['id']}
";
// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($result->num_rows === 0) {
  echo "<script>
          alert('세션에 포함된 계약이 아니어서 조회 불가합니다.');
          location.href = 'contract.php';
        </script>";
  error_log(mysqli_error($conn));
}

// print_r($row);
// print_r($_SESSION);

$cContact = $row['contact1'].'-'.$row['contact2'].'-'.$row['contact3'];

if($row['div3']==='주식회사'){
  $cDiv3 = '(주)';
} elseif($row['div3']==='유한회사'){
  $cDiv3 = '(유)';
} elseif($row['div3']==='합자회사'){
  $cDiv3 = '(합)';
} elseif($row['div3']==='기타'){
  $cDiv3 = '(기타)';
}

if($row['div2']==='개인사업자'){
  $cName = $row['name'].'('.$row['companyname'].')';
} else if($row['div2']==='법인사업자'){
  $cName = $cDiv3.$row['companyname'].'('.$row['name'].')';
} else if($row['div2']==='개인'){
  $cName = $row['name'];
}

$original_period = array($row['monthCount'],  $row['startDate'], $row['endDate']);

$edited_period = array($row['count2'], $row['startDate'], $row['endDate2']);

// print_r($edited_period);
// print_r($original_period);

$difference = count(array_diff_assoc($edited_period, $original_period));

$currentDate = date('Y-m-d');
// echo $currentDate;
if($row['endDate3']){
  $status = '중간종료';
} elseif($currentDate >= date('Y-m-d', strtotime($row['startDate'])) && $currentDate <= date('Y-m-d', strtotime($row['endDate2']))){
  $status = '현재';
} elseif ($currentDate < date('Y-m-d', strtotime($row['startDate']))) {
  $status = '대기';
} elseif ($currentDate > date('Y-m-d', strtotime($edited_period[2]))) {
  $status = '종료';
}
// print_r($status);

$sql_step = "select count(*) from paySchedule2 where realContract_id={$filtered_id}";
$result_step = mysqli_query($conn, $sql_step);
$row_step = mysqli_fetch_array($result_step);

if((int)$row_step[0]===0){
  $step = "clear";
} else {
  $sql_step2 = "select getAmount from paySchedule2 where realContract_id={$filtered_id}";
  // echo $sql_step2;
  $result_step2 = mysqli_query($conn, $sql_step2);
  $getAmount = 0;
  while($row_step2 = mysqli_fetch_array($result_step2)){
    $getAmount = $getAmount + (int)$row_step2[0];
  }

  if($getAmount > 0) {
    $step = "입금";
  } else {
    $step = "청구";
  }
}

$sql_deposit = "
      select
            inDate, inMoney,
            outDate, outMoney, remainMoney,
            saved
      from realContract_deposit where realContract_id={$filtered_id}";
// echo $sql_deposit;
$result_deposit = mysqli_query($conn, $sql_deposit);
$row_deposit = mysqli_fetch_array($result_deposit);

$sql_file = "
    select
      @num := @num + 1 as num,
      file_id,
      name_orig,
      size,
      reg_time
    FROM
      (select @num := 0)a,
      upload_file
    WHERE
      realContract_id = {$filtered_id}
    ORDER BY
      reg_time asc";
// echo $sql_file;
$result_file = mysqli_query($conn, $sql_file);

$fileRows = array();
while($row_file = mysqli_fetch_array($result_file)){
  $fileRows[]=$row_file;
}

for ($i=0; $i < count($fileRows); $i++) {
  if($fileRows[$i]['size'] >= 1073741824){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size'] / 1073741824, 2) . ' GB';
  } elseif($fileRows[$i]['size'] >= 1048576){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size'] / 1048576, 2) . ' MB';
  } elseif($fileRows[$i]['size'] >= 1024){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size'] / 1024, 2) . ' KB';
  } elseif($fileRows[$i]['size'] >= 1){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size']).' bytes';
  }
}

$sql_count = "select count(*)
              from realContract_memo
              where realContract_id={$filtered_id}";
// echo $sql_count;
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);

// print_r($row_count);echo '11';

$memoLength = $row_count[0] + 1;

// print_r($memoLength);


$sql_memoS = "select
                @num := @num - 1 as num,
                idrealContract_memo,
                memoCreator,
                memoContent,
                created,
                updated
              from
                (select @num :={$memoLength})a,
                realContract_memo
              where realContract_id={$filtered_id}
              order by
                created desc";
// echo $sql_memoS;
$result_memoS = mysqli_query($conn, $sql_memoS);

$memoRows = array();
while($row_memoS=mysqli_fetch_array($result_memoS)) {
  $memoRows[] = $row_memoS;
}

$sql2 = "
        SELECT
            idcontractSchedule,
            ordered,
            mStartDate,
            mEndDate,
            mMamount,
            mVmAmount,
            mTmAmount,
            mExpectedDate,
            payId,
            payIdOrder,
            realContract_id
        FROM contractSchedule
        WHERE realContract_id = {$filtered_id}
        order by ordered
        ";
// echo $sql2;
$result2 = mysqli_query($conn, $sql2);

$allRows = array();
while($row2 = mysqli_fetch_array($result2)){
  $allRows[] = $row2;
}

// echo print_r($allRows);



for ($i=0; $i < count($allRows); $i++) {

  if($allRows[$i]['payId']){
    $sql3 = "
            Select
                pExpectedDate,
                ptAmount,
                payKind,
                executiveDate,
                getAmount,
                monthCount,
                TIMESTAMPDIFF(day, pExpectedDate, curdate()) as delaycount1,
                TIMESTAMPDIFF(day, pExpectedDate, executiveDate) as delaycount2,
                getdiv(pExpectedDate, executiveDate) as getdiv2,
                taxSelect,
                taxDate,
                building_id as bid,
                invoicerMgtKey as mun
            from paySchedule2
            where
                idpaySchedule2={$allRows[$i]['payId']}";
    // echo $sql3;
    $result3 = mysqli_query($conn, $sql3);

    $allRows[$i]['paySchedule2'] = array();
    while($row3 = mysqli_fetch_array($result3)){
      $allRows[$i]['paySchedule2'] = $row3;
    }
    // print_r($allRows[$i]['paySchedule2']); echo '111';
    $allRows[$i]['paySchedule2']['pExpectedDate'] = date('Y-n-j', strtotime($allRows[$i]['paySchedule2']['pExpectedDate']));
  }//if closing}

}//for closing}

$sql4 = "select ptAmount
         from paySchedule2
         where user_id={$_SESSION['id']} and
               realContract_id = {$filtered_id} and
               getdiv(pExpectedDate, executiveDate)='not_get_delay'";
$result4 = mysqli_query($conn, $sql4);

$num_rows = mysqli_num_rows($result4);
// var_dump($num_rows);

if($num_rows > 0){
  $not_get_delay_amount = array();
  while($row4 = mysqli_fetch_array($result4)){
    $not_get_delay_amount[] = $row4;
  }

  // print_r($not_get_delay_amount);

  for ($i=0; $i < count($not_get_delay_amount); $i++) {
    $sum += str_replace(',', '', $not_get_delay_amount[$i]['ptAmount']);
  }

  // print_r($sum);

  $sum = number_format($sum);
} else {
  $sum = 0;
}



// echo '------------';
// print_r($allRows[17]);


 ?>
