<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);echo "<br>";


$filtered = array(
  'gid' => mysqli_real_escape_string($conn, $_POST['groupId']), //그룹아이디
  'gName' => mysqli_real_escape_string($conn, $_POST['groupName']) //그룹명
);

settype($filtered['gid'],'integer');


$sql1 = "UPDATE group_in_building
         SET
            gName = '{$filtered['gName']}',
            updated = now()
         where id={$filtered['gid']}
        ";
$result1 = mysqli_query($conn, $sql1);

if(!$result1){
  "<script>
  alert('그룹정보 수정에 문제가 생겼습니다. 관리자에게 문의하세요(4).');
  history.back();
  </script>";
}

// print_r($count);

echo "<script>
alert('수정하였습니다.');
history.back();
</script>";


?>
