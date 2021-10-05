<!-- 이거는 지출입력화면에서의 ajax파일, 고정비입력화면에서의 ajax파일과 혼동하지 말것 -->
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// echo $_POST;
// print_r($_POST);

// var_dump($_POST['year']);

$fromDate = $_POST['year'] . '-' . $_POST['month'] . '-01';
$endDate = date('t', strtotime($fromDate));
$toDate = $_POST['year'] . '-' . $_POST['month'] . '-' . $endDate;

$sql1 = "
        select id, name
        from good_in_building
        where building_id = {$_POST['buildingIdx']}
        ";
// echo $sql1;

$result1 = mysqli_query($conn, $sql1);

while($row1 = mysqli_fetch_array($result1)){
  $allRows[] = $row1;
}

for ($i=0; $i < count($allRows); $i++) {
      $sql2 = "
        select
              idpaySchedule2,
              etcContract.building_id,
              good_in_building.name,
              paySchedule2.ptAmount,
              paySchedule2.pAmount,
              paySchedule2.pvAmount
        from paySchedule2
        join etcContract
            on paySchedule2.etcContract_id = etcContract.id
        join good_in_building
            on etcContract.good_in_building_id = good_in_building.id
        where paySchedule2.user_id = {$_SESSION['id']} and
              etcContract.building_id = {$_POST['buildingIdx']} and
              etcContract.good_in_building_id = {$allRows[$i]['id']} and
              DATE(paySchedule2.executiveDate) BETWEEN '{$fromDate}' and '{$toDate}'
        ";

      // echo $sql2;

      $result2 = mysqli_query($conn, $sql2);

      $allRows[$i]['name'] = array();
      while($row2 = mysqli_fetch_array($result2)){
        $allRows[$i]['name'][] = $row2;
      }
}

// print_r($allRows);


for ($i=0; $i < count($allRows); $i++) {

  $amountGroupArray[$i] = array(0,0,0);
  for ($j=0; $j < count($allRows[$i]['name']); $j++) {

    $amountGroupArray[$i][0] += str_replace(",", "", $allRows[$i]['name'][$j]['ptAmount']);
    $amountGroupArray[$i][1] += str_replace(",", "", $allRows[$i]['name'][$j]['pAmount']);
    $amountGroupArray[$i][2] += str_replace(",", "", $allRows[$i]['name'][$j]['pvAmount']);
  }
}

$amountTotalArray = array(0,0,0,0);

for ($i=0; $i < count($allRows); $i++) {
  $amountTotalArray[0] += count($allRows[$i]['name']);
}

for ($i=0; $i < count($amountGroupArray); $i++) {
  $amountTotalArray[1] += $amountGroupArray[$i][0];
  $amountTotalArray[2] += $amountGroupArray[$i][1];
  $amountTotalArray[3] += $amountGroupArray[$i][2];
}


for ($i=0; $i < count($amountGroupArray); $i++) {
  $amountGroupArray[$i][0] = number_format($amountGroupArray[$i][0]);
  $amountGroupArray[$i][1] = number_format($amountGroupArray[$i][1]);
  $amountGroupArray[$i][2] = number_format($amountGroupArray[$i][2]);
}

$amountTotalArray[0] = number_format($amountTotalArray[0]);
$amountTotalArray[1] = number_format($amountTotalArray[1]);
$amountTotalArray[2] = number_format($amountTotalArray[2]);
$amountTotalArray[3] = number_format($amountTotalArray[3]);



// print_r($amountGroupArray);
// echo 222;

for ($i=0; $i < count($allRows); $i++) {
  $j = $i+1;
  $output = ".<tr>";
  $output .= "<td>".$j."</td>";
  $output .= "<td>".$allRows[$i][1]."</td>";
  $output .= "<td>".count($allRows[$i]['name'])."</td>";
  $output .= "<td>".$amountGroupArray[$i][0]."</td>";
  $output .= "<td>".$amountGroupArray[$i][1]."</td>";
  $output .= "<td>".$amountGroupArray[$i][2]."</td>";
  $output .= "</tr>";

  echo $output;
}

$output = ".<tr class='table-secondary'>";
$output .= "<td colspan='2'>소계</td>";
$output .= "<td>".$amountTotalArray[0]."</td>";
$output .= "<td>".$amountTotalArray[1]."</td>";
$output .= "<td>".$amountTotalArray[2]."</td>";
$output .= "<td>".$amountTotalArray[3]."</td>";
$output .= "</tr>";

echo $output;



?>
