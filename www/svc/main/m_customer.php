<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$sql = "select id, bName
        from building
        where user_id={$_SESSION['id']}";

$result = mysqli_query($conn, $sql);

$div1 = array('입주자', '거래처', '기타', '문의');

$customerRows = array();

while($row = mysqli_fetch_array($result)){

  $customerRowsEle = array();

  array_push($customerRowsEle, $row['bName']);

  for ($i=0; $i < count($div1); $i++) {
    $sql2 = "select count(*)
            from customer
            where user_id={$_SESSION['id']} and
                  building_id={$row['id']} and
                  div1='{$div1[$i]}'";
    // echo $sql2."<br>";

    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);
    array_push($customerRowsEle, $row2[0]);
  }
  array_push($customerRows, $customerRowsEle);

}

// print_r($customerRows);

 ?>
