<?php
$sql = "select * from building where user_id = {$_SESSION['id']} order by ordered";
// echo $sql;
$result = mysqli_query($conn, $sql);
$buildingArray = array();
while($row = mysqli_fetch_array($result)){
  $buildingArray[$row['id']] =
                array($row['bName'],
                      $row['pay']
                    );
}

$buildingcount = 0;
foreach ($buildingArray as $key => $value) {
  $buildingcount += count($value);
}

// print_r($buildingcount);

if($buildingcount===0){
  echo "<script>
    alert('물건을 등록한 것이 없네요. 환경설정에서 물건을 등록해야 이용할 수 있어요!');
    </script>";
  echo "<meta http-equiv='refresh' content='0; url=/svc/service/setting/building.php'>";
}

foreach ($buildingArray as $key => $value) { //key는 건물아이디, value는 건물이름
  $sql2 = "select * from group_in_building where building_id={$key}"; //건물아이디로 그룹조회
  // echo $sql2;
  $result2 = mysqli_query($conn, $sql2);
  $groupBuildingArray[$key] = array();
  while($row2 = mysqli_fetch_array($result2)){
    $groupBuildingArray[$key][$row2['id']]=$row2['gName'];//그룹아이디
  }
}

foreach ($groupBuildingArray as $key => $value) {
  $sql3 = "select id from group_in_building where building_id={$key}"; //건물아이디로 그룹조회 (건물아이디가 키값)
  // echo $sql3;
  $result3 = mysqli_query($conn, $sql3);
  while($row3 = mysqli_fetch_array($result3)){
    $sql4 = "select id, rName from r_g_in_building where group_in_building_id={$row3['id']}";
    // echo $sql4;다시 그룹아이디로 방번호조회
    $result4 = mysqli_query($conn, $sql4);
    $roomArray[$row3['id']] = array();
    while($row4 = mysqli_fetch_array($result4)){
      $roomArray[$row3['id']][$row4['id']]=$row4['rName'];
    }
  }
}

//room 개수 구하고, room 등록이 없으면 환경설정화면으로 이동시킴

$roomcount = 0;
foreach ($roomArray as $key => $value) {
  $roomcount += count($value);
}

// print_r($roomArray);

if($roomcount===0){
  echo "<script>
    alert('관리호수를 등록한 것이 없네요. 환경설정에서 관리호수를 등록해야 이용할 수 있어요!');
    </script>";
  echo "<meta http-equiv='refresh' content='0; url=/svc/service/setting/building.php'>";
}

 ?>