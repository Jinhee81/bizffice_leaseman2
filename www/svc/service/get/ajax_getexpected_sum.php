<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
include "ajax_getexpectedCondi_sql.php";


// echo $sql_before;

$result_before = mysqli_query($conn, $sql_common.$sql_where);

$allRowsBefore = array();
while($row_before = mysqli_fetch_array($result_before)){
  $allRowsBefore[] = $row_before;
}

// print_r($allRowsBefore);

$amount1 = 0;
$amount2 = 0;
$amount2 = 0;

for ($i=0; $i < count($allRowsBefore); $i++){


  $amount1 += str_replace(',', '', $allRowsBefore[$i]['pAmount']);
  // $amount1 = (int)$amount1;

  $amount2 += str_replace(',', '', $allRowsBefore[$i]['pvAmount']);

  $amount3 += str_replace(',', '', $allRowsBefore[$i]['ptAmount']);

}

$amount1 = number_format($amount1);
$amount2 = number_format($amount2);
$amount3 = number_format($amount3);

echo "전체 ".count($allRowsBefore)."건, 공급가액 ".$amount1."원, 세액 ".$amount2."원, 합계 ".$amount3."원";

 ?>
