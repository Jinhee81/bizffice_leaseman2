<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
include "ajax_realContractSql.php";


// echo $sql_before;

$result_before = mysqli_query($conn, $sql_before);

$allRowsBefore = array();
while($row_before = mysqli_fetch_array($result_before)){
  $allRowsBefore[] = $row_before;
}

// print_r($allRowsBefore);

$amount1 = 0;
$amount2 = 0;

for ($i=0; $i < count($allRowsBefore); $i++){

  $sql_deposit = "select remainMoney from realContract_deposit where realContract_id={$allRowsBefore[$i]['rid']}";
  // echo $sql_deposit;

  $result_deposit = mysqli_query($conn, $sql_deposit);
  $row_deposit = mysqli_fetch_array($result_deposit);

  $allRowsBefore[$i]['deposit'] = $row_deposit[0];

  $amount1 += str_replace(',', '', $allRowsBefore[$i]['mtAmount']);
  // $amount1 = (int)$amount1;

  $amount2 += str_replace(',', '', $allRowsBefore[$i]['deposit']);

}

$amount1 = number_format($amount1);
$amount2 = number_format($amount2);

echo "전체 ".count($allRowsBefore)."건, 임대료 ".$amount1."원, 보증금 ".$amount2."원";

 ?>
