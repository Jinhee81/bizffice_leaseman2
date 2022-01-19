<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
header("Content-Type: text/html; charset=UTF-8");

$a = $_POST['payid'];

// print_r($a);

$sql = "update paySchedule2
          set
              taxSelect = null,
              taxDate = null,
              invoicerMgtKey = null
          WHERE
              idpaySchedule2 = {$a}";
//   echo $sql;

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode("error_occured");
    error_log(mysqli_error($conn));
    exit();
}

echo json_encode("success");
