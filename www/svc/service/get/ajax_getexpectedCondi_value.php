<?php
header('Content-Type: text/html; charset=UTF-8');

include "ajax_getexpectedCondi_sql.php";

$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

for ($i=0; $i < count($allRows); $i++) {
  $allRows[$i]['count']= $row_count[0];

  if($allRows[$i]['div3']==='주식회사'){
    $allRows[$i]['cdiv3'] = '(주)';
  } elseif($allRows[$i]['div3']==='유한회사'){
    $allRows[$i]['cdiv3'] = '(유)';
  } elseif($allRows[$i]['div3']==='합자회사'){
    $allRows[$i]['cdiv3'] = '(합)';
  } elseif($allRows[$i]['div3']==='기타'){
    $allRows[$i]['cdiv3'] = '';
  }

  $allRows[$i]['companynumber'] = $allRows[$i]['cNumber1'].'-'.$allRows[$i]['cNumber2'].'-'.$allRows[$i]['cNumber3'];

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['cname'] = $allRows[$i]['ccname'].'('.$allRows[$i]['companyname'].','.$allRows[$i]['companynumber'].')';
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['cname'] = $allRows[$i]['cdiv3'].$allRows[$i]['companyname'].'('.$allRows[$i]['ccname'].','.$allRows[$i]['companynumber'].')';
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['cname'] = $allRows[$i]['ccname'];
  }

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['ccompanyname'] = $allRows[$i]['companyname'];
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['ccompanyname'] = $allRows[$i]['cdiv3'].$allRows[$i]['companyname'];
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['ccompanyname'] = '';
  }

  $allRows[$i]['cnamemb'] = mb_substr($allRows[$i]['cname'],0,10,"utf-8");

  $allRows[$i]['contact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];


  $allRows[$i]['address'] = $allRows[$i]['add1'].', '.$allRows[$i]['add2'].' '.$allRows[$i]['add3'];


  if($allRows[$i]['delaycount'] < 0){
    $allRows[$i]['delaycount'] = 0;
    $allRows[$i]['delayinterest'] = 0; //연체일수가 0일이어서 이자없음
  } elseif($allRows[$i]['delaycount'] >= 0) {
    $allRows[$i]['delayinterest'] = $allRows[$i]['pAmount'] * ($allRows[$i]['delaycount'] / 365) * 0.27; //연체일수 생기니 이자 생
  }

  // $allRows[$i]['pAmount'] = number_format($allRows[$i]['pAmount']);
  // $allRows[$i]['pvAmount'] = number_format($allRows[$i]['pvAmount']);
  // $allRows[$i]['ptAmount'] = number_format($allRows[$i]['ptAmount']);
  $allRows[$i]['delayinterest'] = number_format($allRows[$i]['delayinterest']);

  $allRows[$i]['cnamecontactmb'] = mb_substr($allRows[$i]['cnamecontact'],0,5,"utf-8");

  if($allRows[$i]['taxSelect']===null){
    $allRows[$i]['taxSelect'] = '';
  }

  if($allRows[$i]['taxDate']===null){
    $allRows[$i]['taxDate'] = '';
  }

  if($allRows[$i]['div4']===null){
    $allRows[$i]['div4'] = '';
  }

  if($allRows[$i]['div5']===null){
    $allRows[$i]['div5'] = '';
  }
  $allRows[$i]['pStartDate'] = date('Y-n-j', strtotime($allRows[$i]['pStartDate']));
  $allRows[$i]['pEndDate'] = date('Y-n-j', strtotime($allRows[$i]['pEndDate']));
  $allRows[$i]['pExpectedDate'] = date('Y-n-j', strtotime($allRows[$i]['pExpectedDate']));
} //for문closing

// print_r($allRows);

echo json_encode($allRows);
?>
