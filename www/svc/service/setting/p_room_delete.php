<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$filtered_rId = mysqli_real_escape_string($conn, $_POST['roomId']);//지우려는방의 방 아이디
$filtered_gId = mysqli_real_escape_string($conn, $_POST['groupId']);//지우려는방의 그룹 아이디

$sql1 = "select *
        from r_g_in_building
        where id = {$filtered_rId}";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

$sql2 = "select *
        from group_in_building
        where id = {$filtered_gId}";

$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);

if($row1['ordered'] != $row2['count']){
  echo "<script>
    alert('마지막 방부터 순차적으로 삭제 가능합니다.');
    history.back();
    </script>";
  exit();
}


$sql = "
        delete
        from r_g_in_building
        where id = {$filtered_rId} and
              group_in_building_id = {$filtered_gId}
       ";
// echo $sql;

$result = mysqli_query($conn, $sql);

if($result){

  $count = $row2['count']-1;

  $sql_set = "update group_in_building
              set
                count = {$count}
              where id = {$filtered_gId}
             ";
  // echo $sql_set;
  $result_set = mysqli_query($conn, $sql_set);

  if($result_set) {
    echo "<script>
    alert('삭제하였습니다.');
    history.back();
    </script>";
  } else {
    echo "<script>
    alert('오류가발생했습니다.관리자에게 문의하세요(1)');
    history.back();
    </script>";
  }
} else {
  echo "<script>
  alert('오류가발생했습니다.관리자에게 문의하세요(2)');
  history.back();
  </script>";
}


?>
