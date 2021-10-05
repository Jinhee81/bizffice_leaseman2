<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);echo "<br>";

$a = json_decode($_POST['roomArray']);

// print_r($a);echo "<br>";

$filtered = array(
  'gid' => mysqli_real_escape_string($conn, $_POST['groupId']) //그룹아이디
);

settype($filtered['gid'],'integer');


$count = count($a);

for ($i=0; $i < $count; $i++) {
  $order = $i + 1;
  if($a[$i][1]){
    $sql2 = "
            UPDATE r_g_in_building
            SET
              rName = '{$a[$i][0]}',
              ordered = {$order}
            WHERE
              id = {$a[$i][1]}
            ";
    // echo $sql2."<br>";
    $result2 = mysqli_query($conn, $sql2);

    if(!$result2){
      "<script>
      alert('관리번호 수정에 문제가 생겼습니다. 관리자에게 문의하세요(2).');
      history.back();
      </script>";
    }
  } else {
    $sql2 = "
            INSERT INTO r_g_in_building
            (ordered, rName, group_in_building_id)
            VALUES
            ('{$order}', '{$a[$i][0]}',{$filtered['gid']}
            )
            ";
    // echo $sql2."<br>";
    $result2 = mysqli_query($conn, $sql2);

    if(!$result2){
      "<script>
      alert('관리번호 수정에 문제가 생겼습니다. 관리자에게 문의하세요(3).');
      history.back();
      </script>";
    }
  }
}


$sql1 = "UPDATE group_in_building
         SET
            count = {$count},
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
