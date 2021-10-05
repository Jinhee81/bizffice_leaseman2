<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$cell = json_decode($_POST['cellphone']);

$sql = "select email from user where cellphone = '{$cell}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);


$index1 = strpos($row[0],"@");
$index2 = strpos($row[0],".");

$indexArray = array($index1, $index1+1, $index1+2, $index1+3, $index2);

$length = mb_strlen($row[0]);

$findemail = $row[0];

for($i=3; $i < $length; $i++) {
    if(!in_array($i, $indexArray)) {
        $findemail = substr_replace($findemail, "*", $i, 1);
    } 
}
// print_r($findemail);echo "<br>127";

echo json_encode($findemail);

?>