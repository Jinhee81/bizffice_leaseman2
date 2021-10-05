<?php

// print_r($_POST);

$currentDate = date('Y-m-d');
$dateDiv = 'sendtime';


$etcDate = "";
$toDate1 = strtotime($_POST['toDate']);
$toDate2 = date('Y-m-d', $toDate1);
$toDate3 = date('Y-m-d', strtotime($toDate2.'+1 days'));

if($_POST['fromDate'] && $_POST['toDate']){
  $etcDate = " and ($dateDiv >= '{$_POST['fromDate']}' and $dateDiv <= '{$toDate3}')";
} elseif($_POST['fromDate']){
  $etcDate = " and ($dateDiv >= '{$_POST['fromDate']}')";
} elseif($_POST['toDate']){
  $etcDate = " and ($dateDiv <= '{$toDate3}')";
}

if($_POST['type']==='typeAll'){
  $typeCondi = "";
} else {
  $typeCondi = " and type = '{$_POST['type']}'";
}

$etcCondi = "";
if($_POST['cText']){
  if($_POST['etcCondi']==='customer'){
    $etcCondi = " and (customer like '%".$_POST['cText']."%')";
  } elseif($_POST['etcCondi']==='contact'){
    $etcCondi = " and (phonenumber like '%".$_POST['cText']."%')";
  }
}

$sql = "select
          @num := @num + 1 as num, type, byte, sendtime, customer, phonenumber, roomNumber,
          description, sentnumber, result
        from
          (select @num:=0)a,
          sentsms
        where user_id={$_SESSION['id']}
              $typeCondi $etcCondi $etcDate
        order by
          num desc
        ";

// echo $sql;//etcDate가 젤 뒤에있는 이유는 괄호때문에 그렇다

$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

// print_r($allRows);
?>
