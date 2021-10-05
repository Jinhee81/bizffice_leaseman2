<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST)."<br>";

$filtered = array(
  'id' => mysqli_real_escape_string($conn, $_POST['id']), //건물아이디
  'good' => mysqli_real_escape_string($conn, $_POST['good']) //상품명
);
settype($filtered['building_id'], 'integer');

$sql_count = "select count(*) from good_in_building where building_id={$filtered['building_id']} and name='{$filtered['good']}'";
// echo $sql_count;
$result_count = mysqli_query($conn, $sql_count);
$row = mysqli_fetch_array($result_count);
// echo $row[0];

if($row[0]>=1){
  echo "<script>alert('동일한 상품명은 사용 불가합니다.');
     location.href='building.php';
     </script>";
} else {
  $sql = "INSERT INTO good_in_building (name, created, building_id) VALUES
    ('{$filtered['good']}',
      now(),
      {$filtered['id']}
    )";
  // echo $sql;
  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>alert('추가하였습니다.');
    location.href = 'building.php';
    </script>";
  } else {
    echo "<script>alert('저장과정에 문제가 발생했습니다. 관리자에게 문의하세요.');
    location.href = 'building.php';
    </script>";
    error_log(mysqli_error($conn));
  }
}
?>
