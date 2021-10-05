<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$currentDate = date('Y-m-d');
// $tomorrowDate1 = strtotime($currentDate, "+1 days");
$tomorrowDate = date('Y-m-d', strtotime("+1 days"));

$sql_today = "
       select count(*)
       from events
       where user_id={$_SESSION['id']} and
             DATE(start_event) = '{$currentDate}'
";

// echo $sql_today;

$result_today = mysqli_query($conn, $sql_today);
$row_today = mysqli_fetch_array($result_today);

$allRows_today_title = array();

if((int)$row_today >= 1 ){
  $sql_today_title = "
          select title
          from events
          where user_id={$_SESSION['id']} and
                DATE(start_event) = '{$currentDate}'
  ";
  // echo $sql_today_title;
  $result_today_title = mysqli_query($conn, $sql_today_title);
  while($row_today_title = mysqli_fetch_array($result_today_title)){
    $allRows_today_title[]=$row_today_title;
  }

}

// print_r($allRows_today_title);

$todaySchedule = array();
for ($i=0; $i < count($allRows_today_title); $i++) {
  array_push($todaySchedule, $allRows_today_title[$i]['title']);
}

// print_r($todaySchedule);

$todayScheduleStr = implode(', ', $todaySchedule);

// print_r($todayScheduleStr);

$sql_tomorrow = "
       select count(*)
       from events
       where user_id={$_SESSION['id']} and
             DATE(start_event) = '{$tomorrowDate}'
";

// echo $sql_tomorrow;

$result_tomorrow = mysqli_query($conn, $sql_tomorrow);
$row_tomorrow = mysqli_fetch_array($result_tomorrow);

$allRows_tomorrow_title = array();

if((int)$row_tomorrow >= 1 ){
  $sql_tomorrow_title = "
          select title
          from events
          where user_id={$_SESSION['id']} and
                DATE(start_event) = '{$tomorrowDate}'
  ";
  // echo $sql_tomorrow_title;
  $result_tomorrow_title = mysqli_query($conn, $sql_tomorrow_title);
  while($row_tomorrow_title = mysqli_fetch_array($result_tomorrow_title)){
    $allRows_tomorrow_title[]=$row_tomorrow_title;
  }

}

// print_r($allRows_tomorrow_title);

$tomorrowSchedule = array();
for ($i=0; $i < count($allRows_tomorrow_title); $i++) {
  array_push($tomorrowSchedule, $allRows_tomorrow_title[$i]['title']);
}

// print_r($todaySchedule);

$tomorrowScheduleStr = implode(', ', $tomorrowSchedule);

// print_r($tomorrowScheduleStr);
 ?>
