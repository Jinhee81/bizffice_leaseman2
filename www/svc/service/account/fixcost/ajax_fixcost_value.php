<?php

header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

include "ajax_fixcost_sql.php";

$result = mysqli_query($conn, $sql);
$allRows = array();

while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

echo json_encode($allRows);

?>
