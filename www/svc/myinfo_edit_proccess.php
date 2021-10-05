<!-- 담당자명 항목이 있었는데 없애서 담당자명 부분을 주석처리함 -->
<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$filtered = array(
  'user_name' => mysqli_real_escape_string($conn, $_POST['user_name']),
  'manager_name' => mysqli_real_escape_string($conn, $_POST['manager_name'])
);

// 'damdangga_name' => mysqli_real_escape_string($conn, $_POST['damdangga_name'])

$sql  = "
    UPDATE user
    SET
      user_div = '{$_POST['user_div']}',
      user_name = '{$filtered['user_name']}',
      manager_name = '{$filtered['manager_name']}',
      cellphone = '{$_POST['cellphone']}',
      lease_type = '{$_POST['lease_type']}',
      popbillid = '{$_POST['popbillid']}',
      companynumber = '{$_POST['companynumber']}',
      updated = NOW()
    WHERE
      id = {$_SESSION['id']}
    ";

// echo $sql;
$result = mysqli_query($conn, $sql);


$sql2 = "SELECT * FROM user WHERE id = {$_SESSION['id']}";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);
$_SESSION['user_div'] = $row2['user_div'];
$_SESSION['user_name'] = $row2['user_name'];
// $_SESSION['damdangga_name'] = $row['damdangga_name'];
$_SESSION['cellphone'] = $row2['cellphone'];
$_SESSION['lease_type'] = $row2['lease_type'];
$_SESSION['popbillid'] = $row2['popbillid'];
$_SESSION['companynumber'] = $row2['companynumber'];

// echo $_SESSION['user_div'];
// echo $_SESSION['user_name'];
// echo $_SESSION['damdangga_name'];
// echo $_SESSION['cellphone'];
// echo $_SESSION['lease_type'];


if($result2 === false){
    echo mysqli_error($conn);
} else {
  echo "<script>
  alert('수정되었습니다.');
  window.location.href='myinfo.php';
  </script>";
}
mysqli_close($conn);

?>