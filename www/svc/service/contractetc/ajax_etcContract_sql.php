<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_SESSION);
// print_r($_POST);
// echo '111';

if($_POST['dateDiv']==='executiveDate'){
  $dateDiv = 'executiveDate';
} elseif($_POST['dateDiv']==='createTime'){
  $dateDiv = 'createTime';
} elseif($_POST['dateDiv']==='updateTime'){
  $dateDiv = 'updateTime';
}

$goodCondi = "";
if($_POST['good'] <> 'goodAll'){
  $goodCondi = "and etcContract.good_in_building_id = {$_POST['good']}";
}

$etcDate = "";

if($_POST['fromDate'] && $_POST['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$_POST['fromDate']}' and '{$_POST['toDate']}')";
} elseif($_POST['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$_POST['fromDate']}')";
} elseif($_POST['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$_POST['toDate']}')";
}


$etcCondi = "";
if($_POST['cText']){
  if($_POST['etcCondi']==='customer'){
    $etcCondi = " and (customer.name like '%".$_POST['cText']."%' or companyname like '%".$_POST['cText']."%')";
  } elseif($_POST['etcCondi']==='contact'){
    $etcCondi = " and (customer.contact1 like '%".$_POST['cText']."%' or customer.contact2 like '%".$_POST['cText']."%' or customer.contact3 like '%".$_POST['cText']."%')";
  } elseif($_POST['etcCondi']==='contractId'){
    $etcCondi = " and (etcContract.id like '%".$_POST['cText']."%')";
  }
}

$sql = "
  select
      etcContract.id as eid,
      customer.id as cid,
      customer.name as cname,
      customer.companyname,
      customer.div2,
      customer.div3,
      customer.contact1,
      customer.contact2,
      customer.contact3,
      building.bName as bname,
      good_in_building.name as goodname,
      paySchedule2.executiveDate,
      paySchedule2.pAmount,
      paySchedule2.pvAmount,
      paySchedule2.ptAmount,
      paySchedule2.payKind,
      etcContract.etc as eetc
  from
      etcContract
  left join customer
      on etcContract.customer_id = customer.id
  left join paySchedule2
      on etcContract.paySchedule2_id = paySchedule2.idpayschedule2
  left join building
      on etcContract.building_id = building.id
  left join good_in_building
      on etcContract.good_in_building_id = good_in_building.id
  where etcContract.user_id = {$_SESSION['id']} and
        etcContract.building_id = {$_POST['building']}
        $goodCondi $etcCondi $etcDate
  order by
      paySchedule2.executiveDate desc";


// echo $sql;

?>
