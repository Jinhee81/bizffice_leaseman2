<?php

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
        order by ordered desc
        ";
// echo $sql2;
$result2 = mysqli_query($conn, $sql2);

$allRows = array();
while($row2 = mysqli_fetch_array($result2)){
  $allRows[] = $row2;
}

// echo $sql2;

// echo print_r($allRows);



for ($i=0; $i < count($allRows); $i++) {

  if($allRows[$i]['payId']){
    $sql3 = "
            Select
                pStartDate,
                pEndDate,
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

// print_r($allRows);

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

$allRows[0]['sum'] = $sum;

 ?>
