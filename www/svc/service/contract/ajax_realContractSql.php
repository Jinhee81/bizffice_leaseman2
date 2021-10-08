<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_SESSION);
// print_r($_POST);
// echo '111';
if(isset($_POST['customerId'])){
  $getCondi = "and customer.id=".$_POST['customerId'];
} //이걸왜했지?나중에이유를 꼭 적자, 고객별로 계약리스트 추출하려고 했었네...

parse_str($_POST['form'], $a);

// print_r($a);

$currentDate = date('Y-m-d');

if($a['dateDiv']==='startDate'){
  $dateDiv = 'startDate';
} elseif($a['dateDiv']==='endDate'){
  $dateDiv = 'endDate2';
} elseif($a['dateDiv']==='contractDate'){
  $dateDiv = 'contractDate';
} elseif($a['dateDiv']==='registerDate'){
  $dateDiv = 'createTime';
}

$etcDate = "";

if($a['fromDate'] && $a['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$a['fromDate']}' and '{$a['toDate']}')";
} elseif($a['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$a['fromDate']}')";
} elseif($a['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$a['toDate']}')";
}

if(isset($_POST['progress'])){
  $etcIng = "";
} else {
  if($a['progress']==='pIng'){
    $etcIng = " and status2(startDate, endDate2, endDate3) = 'present'";
  } elseif($a['progress']==='pWaiting'){
    $etcIng = " and status2(startDate, endDate2, endDate3) = 'waiting'";
  } elseif($a['progress']==='pEnd'){
    $etcIng = " and status2(startDate, endDate2, endDate3) = 'the_end'";
  } elseif($a['progress']==='middleEnd'){
    $etcIng = " and status2(startDate, endDate2, endDate3) = 'middle_end'";
  } elseif($a['progress']==='pAll'){
    $etcIng = "";
  } elseif($a['progress']==='clear'){
    $etcIng = " and (select count(*) from paySchedule2 where realContract_id=realContract.id)=0";
  }
}

if($a['building']==='buildingAll'){
  $buildingCondi = "";
} else {
  $buildingCondi = " and (realContract.building_id = {$a['building']})";
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

$sql_count = "select count(*)
              from
                  realContract
              left join customer
                  on realContract.customer_id = customer.id
              left join building
                  on realContract.building_id = building.id
              left join group_in_building
                  on realContract.group_in_building_id = group_in_building.id
              left join r_g_in_building
                  on realContract.r_g_in_building_id = r_g_in_building.id
              where realContract.user_id = {$_SESSION['id']}
                    $buildingCondi
                    $etcDate $etcIng $groupCondi $etcCondi
                    $getCondi
              order by
                  group_in_building.id asc, r_g_in_building.id asc";

// echo $sql_count;

$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if($_POST['getPage']=='1'){
  $start = 0;
} else {
  $start = ((int)$_POST['getPage']-1) * (int)$_POST['pagerow'];
}

$firstOrder = $row_count[0] + 1;

//페이징하기전 sql을 따로 빼야함
$sql_before = "
select
    @num := @num - 1 as num,
    realContract.id as rid,
    customer.id as cid,
    customer.name as cname,
    customer.companyname as ccomname,
    customer.div2,
    customer.div3,
    customer.div4,
    customer.div5,
    customer.contact1,
    customer.contact2,
    customer.contact3,
    customer.cNumber1,
    customer.cNumber2,
    customer.cNumber3,
    customer.email,
    customer.etc,
    customer.created,
    customer.updated,
    realContract.building_id,
    building.bName,
    realContract.group_in_building_id,
    group_in_building.gName,
    realContract.r_g_in_building_id,
    r_g_in_building.rName,
    contractDate,
    payOrder,
    startDate,
    endDate2,
    endDate3,
    mAmount,
    mvAmount,
    mtAmount,
    status2(startDate, endDate2, endDate3) as status2,
    count2,
    (select count(*) from paySchedule2 where realContract_id=rid) as stepped
from
    (select @num := {$firstOrder})a,
    realContract
left join customer
    on realContract.customer_id = customer.id
left join building
    on realContract.building_id = building.id
left join group_in_building
    on realContract.group_in_building_id = group_in_building.id
left join r_g_in_building
    on realContract.r_g_in_building_id = r_g_in_building.id
where realContract.user_id = {$_SESSION['id']}
      $buildingCondi
      $etcDate $etcIng $groupCondi $etcCondi
      $getCondi
order by
    realContract.group_in_building_id asc, realContract.r_g_in_building_id asc
";

//페이징하고나서의 sql문...
$sql = $sql_before. "LIMIT {$start}, {$_POST['pagerow']}";
// echo $sql;

$result = mysqli_query($conn, $sql);

$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[] = $row;
}

?>