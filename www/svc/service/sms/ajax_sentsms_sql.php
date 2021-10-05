<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

parse_str($_POST['form'], $a);

$currentDate = date('Y-m-d');
$dateDiv = 'sendtime';
$etcDate = "";

if($a['fromDate'] && $a['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$a['fromDate']}' and '{$a['toDate']}')";
} elseif($a['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$a['fromDate']}')";
} elseif($a['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$a['toDate']}')";
}

if($a['type']==='typeAll'){
  $typeCondi = "";
} else {
  $typeCondi = " and type = '{$a['type']}'";
}

if($a['div1']==='div1all'){
  $div1Condi = "";
} else {
  $div1Condi = " and div1 = '{$a['div1']}'";
}

if($a['result']==='resultall'){
  $resultCondi = "";
} else if($a['result']==='success') {
  $resultCondi = " and result IN ('06', '1000')";
} else if($a['result']==='fail') {
  $resultCondi = " and result NOT IN ('06', '1000') or result is null";
}

$etcCondi = "";
if($a['cText']){
  if($a['etcCondi']==='customer'){
    $etcCondi = " and (customer like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='contact'){
    $etcCondi = " and (phonenumber like '%".$a['cText']."%')";
  }
}

$sql_count = "select count(*)
              from
                sentsms
              where user_id={$_SESSION['id']}
                    $div1Condi $typeCondi $resultCondi $etcCondi $etcDate
              order by
                sendtime desc";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if($_POST['getPage']=='1'){
  $start = 0;
} else {
  $start = ((int)$_POST['getPage']-1) * (int)$_POST['pagerow'];
}

$firstOrder = $row_count[0] + 1;

$sql = "select
          @num := @num - 1 as num,
          id, div1, type, byte, sendtime, customer, phonenumber, roomNumber,
          description, sentnumber, result
        from
          (select @num := {$firstOrder})a,
          sentsms
        where user_id={$_SESSION['id']}
              $div1Condi $typeCondi $resultCondi $etcCondi $etcDate
        order by
          sendtime desc
        LIMIT {$start}, {$_POST['pagerow']}
        ";

?>
