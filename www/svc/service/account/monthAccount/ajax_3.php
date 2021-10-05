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

$sql = "
  select
        amount1, amount2, amount3
  from
        costlist
  where user_id = {$_SESSION['id']} and
        building_id = {$_POST['buildingIdx']} and
        fixflexdiv = 'fix' and
        DATE(payDate) BETWEEN '{$fromDate}' and '{$toDate}'
  ";

// echo $sql;//amount1 합계, amount2 공급가액, amount3 세엑

$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

// print_r($allRows);

$amountTotalArray = array(0,0,0);

for ($i=0; $i < count($allRows); $i++) {
  $amountTotalArray[0] += str_replace(",", "", $allRows[$i]['amount1']);
  $amountTotalArray[1] += str_replace(",", "", $allRows[$i]['amount2']);
  $amountTotalArray[2] += str_replace(",", "", $allRows[$i]['amount3']);
}

$amountTotalArray[0] = number_format($amountTotalArray[0]);
$amountTotalArray[1] = number_format($amountTotalArray[1]);
$amountTotalArray[2] = number_format($amountTotalArray[2]);

$output = "<tr class='table-secondary'>";
$output .= "<td>".count($allRows)."</td>";
$output .= "<td>".$amountTotalArray[0]."</td>";
$output .= "<td>".$amountTotalArray[1]."</td>";
$output .= "<td>".$amountTotalArray[2]."</td>";
$output .= "</tr>";

echo $output;

?>
