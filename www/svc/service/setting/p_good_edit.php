<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST)."<br>";

$filtered = array(
  'gId' => mysqli_real_escape_string($conn, $_POST['gId']), //상품아이디
  'good' => mysqli_real_escape_string($conn, $_POST['good']), //상품명
  'bId' => mysqli_real_escape_string($conn, $_POST['bId']) //건물아이디
);

settype($filtered['gId'], 'integer');
settype($filtered['bId'], 'integer');

$sql_count = "
  select count(*) from good_in_building
    where building_id={$filtered['bId']}
      and name='{$filtered['good']}'";
// echo $sql_count;
$result_count = mysqli_query($conn, $sql_count);
$row = mysqli_fetch_array($result_count);
// echo $row[0];
//
if($row[0]>=1){
  echo "<script>alert('동일한 그룹명은 사용 불가합니다.');
     location.href='building.php';
     </script>";
} else {
  $sql = "UPDATE good_in_building
    SET
    name = '{$filtered['good']}',
    updated = NOW()
  WHERE
    id = {$filtered['gId']} and
    building_id = {$filtered['bId']}";
  // echo $sql;
  $result = mysqli_query($conn, $sql);

  if($result){
  echo "<script>alert('수정하였습니다.');
    location.href = 'building.php';
    </script>";
  } else {
  echo "<script>alert('수정에 문제가 생겼습니다. 관리자에게 문의해주세요.');
     location.href='building.php';
     </script>";
  error_log(mysqli_error($conn));
  }
}
?>