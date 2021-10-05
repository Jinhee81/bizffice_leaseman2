<?php
session_start();
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// echo $_POST;
// print_r($_POST);

// var_dump($_POST['year']);

$fromDate = $_POST['year'] . '-' . $_POST['month'] . '-01';
$endDate = date('t', strtotime($fromDate));
$toDate = $_POST['year'] . '-' . $_POST['month'] . '-' . $endDate;

$sql = "
  (select
        paySchedule2.idpaySchedule2,
        paySchedule2.executiveDate,
        paySchedule2.ptAmount,
        paySchedule2.pAmount,
        paySchedule2.pvAmount
  from
        paySchedule2
  join realContract
      on paySchedule2.realContract_id = realContract.id
  join building
      on realContract.building_id = building.id
  where paySchedule2.user_id = {$_SESSION['id']} and
        realContract.building_id = {$_POST['buildingIdx']} and
        DATE(paySchedule2.executiveDate) BETWEEN '{$fromDate}' and '{$toDate}')
  union
  (select
        paySchedule2.idpaySchedule2,
        paySchedule2.executiveDate,
        paySchedule2.ptAmount,
        paySchedule2.pAmount,
        paySchedule2.pvAmount
  from
        paySchedule2
  join etcContract
      on paySchedule2.etcContract_id = etcContract.id
  join building
      on etcContract.building_id = building.id
  where paySchedule2.user_id = {$_SESSION['id']} and
        etcContract.building_id = {$_POST['buildingIdx']} and
        DATE(paySchedule2.executiveDate) BETWEEN '{$fromDate}' and '{$toDate}')
  ";

// echo $sql;
//
$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

// print_r($allRows);

$leftTotalArray = array(0,0,0,0);
//
for ($i=0; $i < count($allRows); $i++) {
  $leftTotalArray[1] += str_replace(",", "", $allRows[$i]['ptAmount']);
  $leftTotalArray[2] += str_replace(",", "", $allRows[$i]['pAmount']);
  $leftTotalArray[3] += str_replace(",", "", $allRows[$i]['pvAmount']);
}

// print_r($leftTotalArray);

$leftTotalArray[0] = count($allRows);
$leftTotalArray[1] = number_format($leftTotalArray[1]);
$leftTotalArray[2] = number_format($leftTotalArray[2]);
$leftTotalArray[3] = number_format($leftTotalArray[3]);

$sql2 = "
  select
        amount1, amount2, amount3
  from
        costlist
  where user_id = {$_SESSION['id']} and
        building_id = {$_POST['buildingIdx']} and
        DATE(payDate) BETWEEN '{$fromDate}' and '{$toDate}'
  ";

// echo $sql;//amount1 합계, amount2 공급가액, amount3 세엑

$result2 = mysqli_query($conn, $sql2);
// $total_rows = mysqli_num_rows($result);
$allRows2 = array();
while($row2 = mysqli_fetch_array($result2)){
  $allRows2[]=$row2;
}

// print_r($allRows);

$rightTotalArray = array(0,0,0,0);

for ($i=0; $i < count($allRows2); $i++) {
  $rightTotalArray[1] += str_replace(",", "", $allRows2[$i]['amount1']);
  $rightTotalArray[2] += str_replace(",", "", $allRows2[$i]['amount2']);
  $rightTotalArray[3] += str_replace(",", "", $allRows2[$i]['amount3']);
}

$rightTotalArray[0] = count($allRows2);
$rightTotalArray[1] = number_format($rightTotalArray[1]);
$rightTotalArray[2] = number_format($rightTotalArray[2]);
$rightTotalArray[3] = number_format($rightTotalArray[3]);


 ?>
