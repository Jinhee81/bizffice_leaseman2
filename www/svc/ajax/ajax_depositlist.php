<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_GET);
$filtered_id = mysqli_real_escape_string($conn, $_POST['id']);//계약번호

include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_deposit.php";

echo json_encode($row_deposit);
 ?>
