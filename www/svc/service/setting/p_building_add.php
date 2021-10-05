<?php //빌딩만드는 파일
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered = array(
  'name' => mysqli_real_escape_string($conn, $_POST['name'])
);

$query = "
  select count(*) from building
  where
    user_id={$_SESSION['id']} and bName = '{$filtered['name']}'
    ;";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$r_count = (int)$row['count(*)'];

if ($r_count === 0) {
  $sql  = "
      INSERT INTO building (
          bName,
          pay,
          user_id,
          created
      ) VALUES (
          '{$filtered['name']}',
          '{$_POST['pay']}',
          {$_SESSION['id']},
          now()
      )";
} else {
  echo "<script>alert('같은 명칭이 이미 존재합니다.');
  history.back();
  </script>";
}

$result = mysqli_query($conn, $sql);
// echo $result;
if($result === false){
  echo "<script>
          alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(1)');
          history.back();
        </script>";
  echo mysqli_error($conn);
  exit();
}

echo
  "<script>
  alert('저장되었습니다.');
  window.location.href='building.php';
  </script>";


?>
