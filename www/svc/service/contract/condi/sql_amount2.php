<?php

$sql_cs = "
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
// echo $sql_cs;
$result_cs = mysqli_query($conn, $sql_cs);

$allRows = array();
while ($row_cs = mysqli_fetch_array($result_cs)) {
    $allRows[] = $row_cs;
}

// echo $sql_cs;

// echo print_r($allRows);


for ($i = 0; $i < count($allRows); $i++) {

    if ($allRows[$i]['payId']) {
        $sql_pay = "
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
//        echo $sql_pay;
        $result_pay = mysqli_query($conn, $sql_pay);

        $allRows[$i]['paySchedule2'] = array();
        while ($row_pay = mysqli_fetch_array($result_pay)) {
            $allRows[$i]['paySchedule2'] = $row_pay;
        }
        // print_r($allRows[$i]['paySchedule2']); echo '111';
        $allRows[$i]['paySchedule2']['pExpectedDate'] = date('Y-n-j', strtotime($allRows[$i]['paySchedule2']['pExpectedDate']));
    }//if closing}

}//for closing}

// print_r($allRows);

$sql_sum = "select ptAmount
         from paySchedule2
         where user_id={$_SESSION['id']} and
               realContract_id = {$filtered_id} and
               getdiv(pExpectedDate, executiveDate)='not_get_delay'";
$result_sum = mysqli_query($conn, $sql_sum);

$num_rows = mysqli_num_rows($result_sum);
// var_dump($num_rows);

if ($num_rows > 0) {
    $not_get_delay_amount = array();
    while ($row4 = mysqli_fetch_array($result_sum)) {
        $not_get_delay_amount[] = $row4;
    }

    // print_r($not_get_delay_amount);

    for ($i = 0; $i < count($not_get_delay_amount); $i++) {
        $sum += str_replace(',', '', $not_get_delay_amount[$i]['ptAmount']);
    }

    // print_r($sum);

    $sum = number_format($sum);
} else {
    $sum = 0;
}

$allRows[0]['sum'] = $sum;

?>