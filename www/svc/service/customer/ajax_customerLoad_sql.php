<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

parse_str($_POST['form'], $a);

// print_r($a);

// echo 111;

if($a['dateDiv']==='registerDate'){
  $dateDiv = 'customer.created';
} elseif($a['dateDiv']==='updateDate'){
  $dateDiv = 'customer.updated';
}

$etcDate = "";

if($a['fromDate'] && $a['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$a['fromDate']}' and '{$a['toDate']}')";
} elseif($a['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$a['fromDate']}')";
} elseif($a['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$a['toDate']}')";
}

if($a['building']==='bAll'){
  $building_sql = "";
} else {
  $building_sql = "and customer.building_id={$a['building']}";
}

$div1 = "";
if($a['customerDiv']==='customerAll'){
  $div1 = "";
} else {
  $div1 = " and div1 = '{$a['customerDiv']}'";
}

$etcCondi = "";
if($a['cText']){
  if($a['etcCondi']==='customer'){
    $etcCondi = " and (name like '%".$a['cText']."%' or companyname like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='contact'){
    $etcCondi = " and (customer.contact1 like '%".$a['cText']."%' or customer.contact2 like '%".$a['cText']."%' or customer.contact3 like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='email'){
    $etcCondi = " and (email like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='etc'){
    $etcCondi = " and (customer.etc like '%".$a['cText']."%')";
  }
}

$sql_count = "select count(*) from customer
        where user_id={$_SESSION['id']}
        $building_sql $etcDate $div1 $etcCondi";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if($_POST['getPage']=='1'){
  $start = 0;
} else {
  $start = ((int)$_POST['getPage']-1) * (int)$_POST['pagerow'];
}

$firstOrder = $row_count[0] + 1;

$sql_before = "select
          @num := @num - 1 as num,
          customer.id,
          customer.div1,
          customer.div2,
          customer.name,
          customer.div3,
          customer.div4,
          customer.div5,
          customer.companyname,
          customer.cNumber1,
          customer.cNumber2,
          customer.cNumber3,
          customer.contact1,
          customer.contact2,
          customer.contact3,
          customer.email,
          customer.zipcode,
          customer.add1,
          customer.add1,
          customer.add2,
          customer.add3,
          customer.etc,
          customer.birthday,
          customer.created,
          customer.updated,
          building_id,
          building.bName
        from
          (select @num := {$firstOrder})a,
          customer
        left join building
          on customer.building_id = building.id
        where customer.user_id={$_SESSION['id']} 
          $building_sql $etcDate $div1 $etcCondi
        order by created desc";

$sql = $sql_before." LIMIT {$start}, {$_POST['pagerow']}";

?>