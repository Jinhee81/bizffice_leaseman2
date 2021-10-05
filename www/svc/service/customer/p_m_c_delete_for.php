<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$a = explode(",", $_POST['customerArray']);
// print_r($a);

for ($i=0; $i < count($a)/3; $i++) {
  $customerRow[$i]=array();
} //$customerRow 라는 배열을 만듦

for ($i=0; $i < count($a); $i++) {
  if($i < 3){
    array_push($customerRow[0], $a[$i]);
  } else {
    array_push($customerRow[floor($i/3)], $a[$i]);
  }
}
// print_r($customerRow);

for ($i=0; $i < count($customerRow); $i++) {
  $sql = "
        DELETE from customer
          where id={$customerRow[$i][1]} and
                user_id={$_SESSION['id']}
  ";
  // echo $sql;
  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "<script>alert('삭제과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
          location.href = 'customer.php';
          </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}

echo "<script>alert('삭제하였습니다.');
      location.href = 'customer.php';
      </script>";

?>
