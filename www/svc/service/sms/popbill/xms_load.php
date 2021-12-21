<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
require_once $_SERVER['DOCUMENT_ROOT'].'/svc/popbill_common2.php';

if($_POST['getPage']=='1'){
    $start = 0;
  } else {
    $start = ((int)$_POST['getPage']-1) * (int)$_POST['pagerow'];
  }

$sql_count = "select count(*)
              from
                xms
              where user_id={$_SESSION['id']}
              order by
                action_date desc";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);


$firstOrder = $row_count[0] + 1;

$sql = "select
          @num := @num - 1 as num,
          id, action_date, title, sent_number, popbill_receiptNum
        from
          (select @num := {$firstOrder})a,
          xms
        where user_id={$_SESSION['id']}
        order by
            action_date desc
        LIMIT {$start}, {$_POST['pagerow']}
        ";

// echo $sql;

$result = mysqli_query($conn, $sql);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

echo json_encode($allRows);

?>