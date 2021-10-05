<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);//계약번호

include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_file.php";

echo json_encode($fileRows);
 ?>
