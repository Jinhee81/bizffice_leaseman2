<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$DateArray = array();

for ($i=1; $i < 13; $i++) {
  $DateArrayEle = array();
  $from = $_POST['year'] .'-'.$i.'-'.'1';
  $toDate = date('t', strtotime($from));
  $to = $_POST['year'] .'-'.$i.'-'.$toDate;
  array_push($DateArrayEle, $from, $to);
  array_push($DateArray, $DateArrayEle);
}



// print_r($DateArray);
// print_r($buildingIdx);

$allRows = array();

for ($i=0; $i < count($DateArray); $i++) {

  $sql = "select ptAmount from paySchedule2
          where user_id={$_SESSION['id']} and
                building_id={$_POST['buildingIdx']} and
                DATE(executiveDate) BETWEEN '{$DateArray[$i][0]}' and '{$DateArray[$i][1]}'
          ";
  // echo $sql;

  $result = mysqli_query($conn, $sql);

  if($result){
    $allRows[$i] = array();
    while($row = mysqli_fetch_array($result)){
      $allRows[$i][]=$row;
    }
  } else {
    echo "검색값이 없습니다.";
  }

}

// print_r($allRows); echo 111;

$plusAmountArray = array(0,0,0,0,0,0,0,0,0,0,0,0);

for ($i=0; $i < count($allRows); $i++) {

  for ($j=0; $j < count($allRows[$i]); $j++) {

    $plusAmountArray[$i] += str_replace(",", "", $allRows[$i][$j]['ptAmount']);
  }
}


// print_r($plusAmountArray); echo 222;

$allRows2 = array();

for ($i=0; $i < count($DateArray); $i++) {
  $sql = "
    select
          amount1
    from
          costlist
    where user_id = {$_SESSION['id']} and
          building_id = {$_POST['buildingIdx']} and
          DATE(payDate) BETWEEN '{$DateArray[$i][0]}' and '{$DateArray[$i][1]}'
    ";

  // echo $sql;//amount1 합계, amount2 공급가액, amount3 세엑

  $result = mysqli_query($conn, $sql);

  $allRows2[$i] = array();
  while($row = mysqli_fetch_array($result)){
    $allRows2[$i][]=$row;
  }
}

// print_r($allRows2);

$minusAmountArray = array(0,0,0,0,0,0,0,0,0,0,0,0);

for ($i=0; $i < count($allRows2); $i++) {

  for ($j=0; $j < count($allRows2[$i]); $j++) {

    $minusAmountArray[$i] += str_replace(",", "", $allRows2[$i][$j]['amount1']);
  }
}

$output = array($plusAmountArray, $minusAmountArray);

echo json_encode($output);

// echo json_encode($plusAmountArray);
// echo json_encode($minusAmountArray);

?>