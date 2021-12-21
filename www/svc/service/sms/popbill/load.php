<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
require_once $_SERVER['DOCUMENT_ROOT'].'/svc/popbill_common2.php';

include "sql.php";


$result = mysqli_query($conn, $sql);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

for ($i=0; $i < count($allRows); $i++) {
  $allRows[$i]['count']= $row_count[0];

  $allRows[$i]['descriptionmb'] =  mb_substr($allRows[$i]['description'],0,10,'utf-8');

  $allRows[$i]['yearmonth'] = date('Ym', strtotime($allRows[$i]['sendtime']));

  $ReceiptNum = $allRows[$i]['pb_receiptNum'];

  try {
    $result = $MessagingService->GetMessages($testCorpNum, $ReceiptNum);
  } catch (PopbillException $pe) {
    $code = $pe->getCode();
    $message = $pe->getMessage();
  }

  
}

echo json_encode($allRows);
?>