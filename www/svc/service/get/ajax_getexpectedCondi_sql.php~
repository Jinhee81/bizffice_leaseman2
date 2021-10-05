<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$currentDate = date('Y-m-d');
// print_r($_POST);

parse_str($_POST['form'], $a);

if($a['dateDiv']==='pExpectedDate'){
  $dateDiv = 'pExpectedDate';
}

$etcDate = "";

if($a['fromDate'] && $a['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$a['fromDate']}' and '{$a['toDate']}')";
} elseif($a['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$a['fromDate']}')";
} elseif($a['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$a['toDate']}')";
}


if($a['group']==='groupAll'){
  $groupCondi = "";
} else {
  $groupCondi = " and (realContract.group_in_building_id = {$a['group']})";
}

$etcCondi = "";
if($a['cText']){
  if($a['etcCondi']==='customer'){
    $etcCondi = " and (name like '%".$a['cText']."%' or companyname like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='contact'){
    $etcCondi = " and (customer.contact1 like '%".$a['cText']."%' or customer.contact2 like '%".$a['cText']."%' or customer.contact3 like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='contractId'){
    $etcCondi = " and (realContract.id like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='roomId'){
    $etcCondi = " and (r_g_in_building.rName like '%".$a['cText']."%')";
  }
}

$sql_where = "
      where paySchedule2.user_id={$_SESSION['id']} and
            realContract.building_id = {$a['building']} and
            paySchedule2.executiveDate is null
            $groupCondi $etcCondi $etcDate
      order by
            date_format(pExpectedDate, '%Y-%m-%d') asc";

$sql_count = "select count(*)
              from paySchedule2
              where user_id={$_SESSION['id']} and
                    building_id = {$a['building']} and
                    executiveDate is null
                    $groupCondi $etcCondi $etcDate
              ";

$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if($_POST['getPage']=='1'){
  $start = 0;
} else {
  $start = ((int)$_POST['getPage']-1) * (int)$_POST['pagerow'];
}

$firstOrder = $row_count[0];

$sql_common = "
  select
      @num := @num - 1 as num,
      realContract_id as rid,
      realContract.building_id as rbid,
      building.bName as bname,
      realContract.group_in_building_id as gid,
      group_in_building.gName as gname,
      realContract.r_g_in_building_id as roomid,
      r_g_in_building.rName as roomname,
      realContract.customer_id as cid,
      customer.div2,
      customer.name as ccname,
      customer.contact1,
      customer.contact2,
      customer.contact3,
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
      customer.email,
      idpaySchedule2,
      paySchedule2.monthCount,
      paySchedule2.pStartDate,
      paySchedule2.pEndDate,
      paySchedule2.pAmount,
      paySchedule2.pvAmount,
      paySchedule2.ptAmount,
      paySchedule2.pExpectedDate,
      paySchedule2.payKind,
      paySchedule2.taxSelect,
      paySchedule2.taxDate,
      TIMESTAMPDIFF(day, pExpectedDate, curdate()) as delaycount
  from
      (select @num := {$firstOrder})a,
      paySchedule2
  left join realContract
      on paySchedule2.realContract_id = realContract.id
  left join customer
      on realContract.customer_id = customer.id
  left join building
      on realContract.building_id = building.id
  left join group_in_building
      on realContract.group_in_building_id = group_in_building.id
  left join r_g_in_building
      on realContract.r_g_in_building_id = r_g_in_building.id";

$sql = $sql_common.$sql_where." LIMIT {$start}, {$_POST['pagerow']}";

?>
