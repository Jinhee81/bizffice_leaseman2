<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// echo 'solme';
$filtered = array(
  'id' => mysqli_real_escape_string($conn, $_POST['groupId'])//그룹아이디
);

$sql  = "
    DELETE
      FROM group_in_building
      WHERE
        id = {$filtered['id']}
    ";
// echo $sql;
$result = mysqli_query($conn, $sql);



if($result === false){
  $sql2 = "delete from r_g_in_building where group_in_building_id={$filtered['id']}";
  $result2 = mysqli_query($conn, $sql2);
  // echo $sql2;
  if($result2){
    $sql  = "
        DELETE
          FROM group_in_building
          WHERE
            id = {$filtered['id']}
        ";
    $result = mysqli_query($conn, $sql);

    if($result){
      echo "<script>alert('삭제하였습니다.');
        location.href='building.php';
        </script>";
    } else {
      echo "<script>
          alert('삭제되지 않았습니다. 관리자에게 문의하세요.');
          history.back();
         </script>";
    }
  } else {
      echo "<script>
          alert('계약이 생성되어있어 삭제할 수 없습니다');
          history.back();
         </script>";
  }
} else {
  echo "<script>alert('삭제하였습니다.');
    location.href='building.php';
    </script>";
}
?>
