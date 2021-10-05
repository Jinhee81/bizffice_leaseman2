<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered = array(
  'gName' => mysqli_real_escape_string($conn, $_POST['gName']), //그룹명
  'id' => mysqli_real_escape_string($conn, $_POST['id']), //건물아이디
  'count' => mysqli_real_escape_string($conn, $_POST['count']) //방개수
);
for ($i=0; $i < (int)$filtered['count']; $i++) {
  $roomed['rName'.$i] = mysqli_real_escape_string($conn, $_POST['rName'.$i]);
}

$sql5 =
  "select count(*) from group_in_building where gName='{$filtered['gName']}' and building_id={$filtered['id']}";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_array($result5);

if((int)$row5[0] >= 1){
  echo "<script>
  alert('동일한 그룹명은 사용불가합니다.');
  location.href='building.php';
  </script>";
  } else {
  $sql6  = "
    INSERT INTO group_in_building (
        gName,
        count,
        created,
        building_id
    ) VALUES (
        '{$filtered['gName']}',
        '{$filtered['count']}',
        NOW(),
        {$filtered['id']}
    )";

    // echo $sql6;
  $result6 = mysqli_query($conn, $sql6); //건물안에 그룹명 생성

  $id = mysqli_insert_id($conn); //이거가 건물안에 그룹명아이디(중요,완전헷갈렸음)

  $r_order = 1;
  foreach($roomed as $key => $value){
    $sql = "
      INSERT INTO r_g_in_building (
      ordered,
      rName,
      group_in_building_id
    ) VALUES (
      {$r_order},
      '{$value}',
      {$id}
    )";
    $result = mysqli_query($conn, $sql);
    $r_order = $r_order + 1;
    // echo $sql."<br>";

    // $sql_overlap_check =
    //   "select count(*) from r_g_in_building
    //   where group_in_building_id={$id}
    //   and rName = {$value}
    //   ";
    // $result_overlap_check = mysqli_query($conn, $sql_overlap_check);
    // $row_overlap_check = mysqli_fetch_array($result_overlap_check);
    //
    // if((int)$row_overlap_check[0] >= 2 ){
    //   echo "<script>
    //   alert('동일한 관리번호는 사용 불가합니다.');</script>";
    //   goto end;
    // }//건물안 그룹명 내에 방번호 생성

  }

echo
"<script>
alert('저장하였습니다.');
location.href='building.php';
</script>";

// end :
// echo "<script>
// location.href='building.php';</script>";
}
?>
