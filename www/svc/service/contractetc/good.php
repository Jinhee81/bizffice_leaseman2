<?php
$sql = "select * from building where user_id = {$_SESSION['id']} order by ordered";
// echo $sql;
$result = mysqli_query($conn, $sql);
$buildingArray = array();
while($row = mysqli_fetch_array($result)){
    $buildingArray[$row['id']] = array($row['bName']);
}

foreach ($buildingArray as $key => $value) { //key는 건물아이디, value는 건물이름
  $sql2 = "select * from good_in_building where building_id={$key}"; //건물아이디로 그룹조회
  // echo $sql2;
  $result2 = mysqli_query($conn, $sql2);
  $goodBuildingArray[$key] = array();
  while($row2 = mysqli_fetch_array($result2)){
    $goodBuildingArray[$key][$row2['id']]=$row2['name'];//상품아이디
  }
}

//상품개수 구하고, 상품등록이 없으면 환경설정화면으로 이동시킴

$goodcount = 0;
foreach ($goodBuildingArray as $key => $value) {
  $goodcount += count($value);
}

// print_r($goodcount);

if($goodcount===0){
  echo "<script>
    alert('상품을 등록한 것이 없네요. 환경설정에서 상품을 등록해야 이용할 수 있어요! 먼저 상품 등록하고 들어오세요~~');
    </script>";
  echo "<meta http-equiv='refresh' content='0; url=/svc/service/setting/building.php'>";
}

// echo "building Array : "; print_r($buildingArray);
// echo "good Array : "; print_r($goodBuildingArray);
?>