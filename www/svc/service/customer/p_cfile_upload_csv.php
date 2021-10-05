<?php //고객생성 파일
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
header('Content-Type: text/html; charset=UTF-8');

include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


// ini_set('max_input_vars', 50000); 이거 암만해도 안되서 일단 포기함
// phpinfo();
// print_r($_POST);
// print_r($_SESSION);

$a = array();

foreach ($_POST as $key => $value) {
  if($key != 'building'){
    array_push($a, mysqli_real_escape_string($conn, $value));
  }
}

for ($i=0; $i < count($a)/12; $i++) {
  $customerRow[$i] = array();
} //$customerRow 라는 배열을 만듦

for ($i=0; $i < count($a); $i++) {
  if($i < 12){
    array_push($customerRow[0], $a[$i]);
  } elseif($i >= 12) {
    array_push($customerRow[floor($i/12)], $a[$i]);
  }
}

for ($i=0; $i < count($customerRow); $i++) {
  $customerRow[$i][3] = explode('-', $customerRow[$i][3]);
  $customerRow[$i][8] = explode('-', $customerRow[$i][8]);
}

// print_r($customerRow);

// for ($i=0; $i < count($customerRow); $i++) {
//
//   $addCheck1 = "
//     select count(*) from customer
//     where
//       user_id={$_SESSION['id']}
//       and name = '{$customerRow[$i][2]}'
//       and building_id = {$_POST['building']}
//       ";
//   // echo $addCheck1;
//   $result_addCheck1 = mysqli_query($conn, $addCheck1);
//   $row_addCheck1 = mysqli_fetch_array($result_addCheck1);
//
//   if((int)$row_addCheck1[0] >= 1){
//     echo "<script>alert('".$customerRow[$i][2]."이름이 이미 존재합니다. 다른 이름으로 저장하거나 다시 확인해주세요.');
//           history.back();</script>";
//     exit();
//   }
//
//
//   $addCheck2 = "
//     select count(*) from customer
//     where
//       user_id={$_SESSION['id']} and
//       contact1 = '{$customerRow[$i][3][0]}' and
//       contact2 = '{$customerRow[$i][3][1]}' and
//       contact3 = '{$customerRow[$i][3][2]}'
//       and building_id = {$_POST['building']}
//       ";
//   // echo $addCheck2;
//   $result_addCheck2 = mysqli_query($conn, $addCheck2);
//   $row_addCheck2 = mysqli_fetch_array($result_addCheck2);
//
//   if((int)$row_addCheck2[0] >= 1){
//     echo "<script>alert('".$customerRow[$i][2]."이름의 연락처 ".$customerRow[$i][3][0].$customerRow[$i][3][1].$customerRow[$i][3][2]." 번호가 존재합니다. 중복된 연락처는 저장이 안돼요.');
//           history.back();</script>";
//     exit();
//   }
// }
//정말 고민하다가 엑셀업로드에서는 그냥 다 넣기로 함, 중복체크 안하기로 함

for ($i=0; $i < count($customerRow); $i++) {
  $sql = "
    INSERT INTO
      customer
      (div1, div2, name, contact1, contact2, contact3,
      gender, email, div3, companyname, cNumber1, cNumber2, cNumber3, div4, div5, etc, created, createPerson, user_id, building_id)
      VALUES
      ('{$customerRow[$i][0]}',
      '{$customerRow[$i][1]}',
      '{$customerRow[$i][2]}',
      '{$customerRow[$i][3][0]}',
      '{$customerRow[$i][3][1]}',
      '{$customerRow[$i][3][2]}',
      '{$customerRow[$i][4]}',
      '{$customerRow[$i][5]}',
      '{$customerRow[$i][6]}',
      '{$customerRow[$i][7]}',
      '{$customerRow[$i][8][0]}',
      '{$customerRow[$i][8][1]}',
      '{$customerRow[$i][8][2]}',
      '{$customerRow[$i][9]}',
      '{$customerRow[$i][10]}',
      '{$customerRow[$i][11]}',
      now(),
      '{$_SESSION['manager_name']}',
      {$_SESSION['id']},
      {$_POST['building']}
      )
  ";

  // echo $sql;

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
    history.back();
    </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}

echo "<script>alert('저장되었습니다.');
location.href = 'customer.php';
</script>";


?>
