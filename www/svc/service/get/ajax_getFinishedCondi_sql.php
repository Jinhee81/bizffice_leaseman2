<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if($_POST['dateDiv']==='executiveDate') $dateDiv = 'paySchedule2.executiveDate';
else if($_POST['dateDiv']==='taxDate') $dateDiv = 'taxDate';


$etcDate = "";

if($_POST['fromDate'] && $_POST['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$_POST['fromDate']}' and '{$_POST['toDate']}')";
} elseif($_POST['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$_POST['fromDate']}')";
} elseif($_POST['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$_POST['toDate']}')";
}

if($_POST['building']==='buildingAll'){
  $buildingCondi = "";
} else {
  $buildingCondi1 = "and realContract.building_id = {$_POST['building']}";
  $buildingCondi2 = "and etcContract.building_id = {$_POST['building']}";
}

$taxCondi = "";
if($_POST['taxDiv']==='alltax'){
  $taxCondi = "";
} elseif ($_POST['taxDiv']==='taxYes') {
  $taxCondi = " and (paySchedule2.pvAmount > 0)";
} elseif ($_POST['taxDiv']==='taxNone') {
  $taxCondi = " and (paySchedule2.pvAmount = 0)";
}

$payCondi = "";
if($_POST['payKind']==='payall'){
  $payCondi = "";
} elseif ($_POST['payKind']==='계좌') {
  $payCondi = " and (paySchedule2.payKind='계좌')";
} elseif ($_POST['payKind']==='현금') {
  $payCondi = " and (paySchedule2.payKind='현금')";
} elseif ($_POST['payKind']==='카드') {
  $payCondi = " and (paySchedule2.payKind='카드')";
}





$etcCondi1 = "";//방계약에서만 사용하는 조건문
$etcCondi2 = "";//기타계약에서만 사용하는 조건문, 둘다사용하는이유가 그래야지 union이안됨

if($_POST['cText']){
  if($_POST['etcCondi']==='customer'){
    $etcCondi1 = " and (customer.name like '%".$_POST['cText']."%' or customer.companyname like '%".$_POST['cText']."%')";
    $etcCondi2 = " and (customer.name like '%".$_POST['cText']."%' or customer.companyname like '%".$_POST['cText']."%')";
  } elseif($_POST['etcCondi']==='contact'){
    $etcCondi1 = " and (customer.contact1 like '%".$_POST['cText']."%' or customer.contact2 like '%".$_POST['cText']."%' or customer.contact3 like '%".$_POST['cText']."%')";

    $etcCondi2 = " and (customer.contact1 like '%".$_POST['cText']."%' or customer.contact2 like '%".$_POST['cText']."%' or customer.contact3 like '%".$_POST['cText']."%')";

  } elseif($_POST['etcCondi']==='gName'){
    $etcCondi1 = " and group_in_building.gName like '%".$_POST['cText']."%'";
    $etcCondi2 = " and good_in_building.name like '%".$_POST['cText']."%'";
  } elseif($_POST['etcCondi']==='rName'){
    $etcCondi1 = " and r_g_in_building.rName like '%".$_POST['cText']."%'";
    $etcCondi2 = " and good_in_building.name like '%".$_POST['cText']."%'";
  } elseif($_POST['etcCondi']==='goodName'){
    $etcCondi1 = " and group_in_building.gName like '%".$_POST['cText']."%'";
    $etcCondi2 = " and good_in_building.name like '%".$_POST['cText']."%'";
  }
}


$sql = "
(select
    @roomdiv as roomdiv,
    paySchedule2.realContract_id as rid,
    realContract.building_id as rbid,
    building.bName as buildingname,
    realContract.group_in_building_id as gid,
    group_in_building.gName as groupname,
    realContract.r_g_in_building_id as roomid,
    r_g_in_building.rName as roomname,
    realContract.customer_id,
    customer.div2,
    customer.name,
    customer.contact1,
    customer.contact2,
    customer.contact3,
    customer.email,
    customer.div3,
    customer.div4,
    customer.div5,
    customer.companyname,
    customer.cNumber1,
    customer.cNumber2,
    customer.cNumber3,
    customer.add1,
    customer.add2,
    customer.add3,
    customer.id as ccid,
    realContract.startDate,
    realContract.endDate2,
    realContract.count2,
    idpaySchedule2,
    paySchedule2.monthCount,
    paySchedule2.pStartDate,
    paySchedule2.pEndDate,
    paySchedule2.pAmount,
    paySchedule2.pvAmount,
    paySchedule2.ptAmount,
    paySchedule2.pExpectedDate,
    paySchedule2.payKind,
    paySchedule2.executiveDate,
    paySchedule2.getAmount,
    paySchedule2.taxSelect,
    paySchedule2.taxDate,
    paySchedule2.building_id as bid,
    paySchedule2.invoicerMgtKey as mun
from
    (select @roomdiv:='room')a,
    paySchedule2
join realContract
    on paySchedule2.realContract_id = realContract.id
join customer
    on realContract.customer_id = customer.id
join building
    on realContract.building_id = building.id
join group_in_building
    on realContract.group_in_building_id = group_in_building.id
join r_g_in_building
    on realContract.r_g_in_building_id = r_g_in_building.id
where paySchedule2.user_id={$_SESSION['id']} and
      paySchedule2.executiveDate is not null
      $buildingCondi1 $etcDate $taxCondi $payCondi $etcCondi1)
union
(select
    @gooddiv as gooddiv,
    paySchedule2.etcContract_id as eid,
    etcContract.building_id as ebid,
    building.bName as buildingname,
    etcContract.good_in_building_id as goodid,
    good_in_building.name as goodname2,
    etcContract.good_in_building_id as goodid,
    good_in_building.name as goodname2,
    etcContract.customer_id,
    customer.div2,
    customer.name,
    customer.contact1,
    customer.contact2,
    customer.contact3,
    customer.email,
    customer.div3,
    customer.div4,
    customer.div5,
    customer.companyname,
    customer.cNumber1,
    customer.cNumber2,
    customer.cNumber3,
    customer.add1,
    customer.add2,
    customer.add3,
    customer.id as ccid,
    etcContract.startTime,
    etcContract.endTime,
    etcContract.endTime,
    idpaySchedule2,
    paySchedule2.monthCount,
    paySchedule2.pStartDate,
    paySchedule2.pEndDate,
    paySchedule2.pAmount,
    paySchedule2.pvAmount,
    paySchedule2.ptAmount,
    paySchedule2.pExpectedDate,
    paySchedule2.payKind,
    paySchedule2.executiveDate,
    paySchedule2.getAmount,
    paySchedule2.taxSelect,
    paySchedule2.taxDate,
    paySchedule2.building_id as bid,
    paySchedule2.invoicerMgtKey as mun
from
    (select @gooddiv:='good')a,
    paySchedule2
join etcContract
    on paySchedule2.etcContract_id = etcContract.id
join customer
    on etcContract.customer_id = customer.id
join building
    on etcContract.building_id = building.id
join good_in_building
    on etcContract.good_in_building_id = good_in_building.id
where paySchedule2.user_id={$_SESSION['id']} and
      paySchedule2.executiveDate is not null
      $buildingCondi2 $etcDate $taxCondi $payCondi $etcCondi2)
order by date_format(executiveDate, '%Y-%m-%d') desc
";


// echo $sql;

?>