<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$sql = "select
          div2, name,
          contact1, contact2, contact3,
          div3, div4, div5,
          companyname, cNumber1, cNumber2, cNumber3,
          email, etc, created, updated
        from customer
        where id={$_POST['cid']}";
// echo $sql;

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

echo json_encode($row);
 ?>
