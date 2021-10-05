<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);echo "<br>";


$filtered = array(
  'rid' => mysqli_real_escape_string($conn, $_POST['roomId']),   'rName' => mysqli_real_escape_string($conn, $_POST['roomName'])
);

settype($filtered['rid'],'integer');
//
$sql1 = "
         select rName from r_g_in_building where id={$filtered['rid']}
        ";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

// var_dump($row1[0]);
// var_dump($filtered['rName']);


if($row1[0]===$filtered['rName']){
  echo "<script>
  alert('기존이름과 동일합니다. 다시 확인하세요.');
  history.back();
  </script>";
  echo mysqli_error($conn);
  exit();
}
//
$sql2 = "UPDATE r_g_in_building
         SET
            rName = '{$filtered['rName']}'
         where id={$filtered['rid']}
        ";
// echo $sql2;
$result2 = mysqli_query($conn, $sql2);
//
if(!$result2){
  "<script>
  alert('수정과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
  history.back();
  </script>";
  echo mysqli_error($conn);
  exit();
}

// print_r($count);

echo "<script>
alert('수정하였습니다.');
history.back();
</script>";


?>
