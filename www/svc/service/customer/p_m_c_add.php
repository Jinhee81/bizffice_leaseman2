<?php //고객생성 파일
//업데이트 - 20.8.7 중복된연락처 수정하기로 함 이름+연락처3+사업자명까지 일치하면 저장안하기로 로직을 수정했음


header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$fil = array(
  'name' => mysqli_real_escape_string($conn, $_POST['name']),
  'email' => mysqli_real_escape_string($conn, $_POST['email']),
  'etc' => mysqli_real_escape_string($conn, $_POST['etc']),
  'companyname' => mysqli_real_escape_string($conn, $_POST['companyname']),
  'contact1' => mysqli_real_escape_string($conn, $_POST['contact1']),
  'contact2' => mysqli_real_escape_string($conn, $_POST['contact2']),
  'contact3' => mysqli_real_escape_string($conn, $_POST['contact3']),
  'cNumber1' => mysqli_real_escape_string($conn, $_POST['cNumber1']),
  'cNumber2' => mysqli_real_escape_string($conn, $_POST['cNumber2']),
  'cNumber3' => mysqli_real_escape_string($conn, $_POST['cNumber3']),
  'add1' => mysqli_real_escape_string($conn, $_POST['add1']),
  'add2' => mysqli_real_escape_string($conn, $_POST['add2']),
  'add3' => mysqli_real_escape_string($conn, $_POST['add3'])
);

// print_r($fil);

$addCheck1 = "
  select count(*) from customer
  where
    user_id={$_SESSION['id']}
    and name = '{$fil['name']}'
    and contact3 = '{$fil['contact3']}'
    and companyname = '{$fil['companyname']}'
    and building_id = {$_POST['building']}
    ";
// echo $addCheck1;
$result_addCheck1 = mysqli_query($conn, $addCheck1);
$row_addCheck1 = mysqli_fetch_array($result_addCheck1);

if((int)$row_addCheck1[0]>0){
  echo "<script>alert('중복된 내역이 존재합니다. 성명+연락처+사업자명까지 일치하면 저장되지 않아요.');
        history.back();</script>";
  exit();
}

// $addCheck2 = "
//   select count(*) from customer
//   where
//     user_id={$_SESSION['id']} and
//     contact1 = '{$fil['contact1']}' and
//     contact2 = '{$fil['contact2']}' and
//     contact3 = '{$fil['contact3']}' and
//     building_id = {$_POST['building']}
//     ";
// // echo $addCheck2;
// $result_addCheck2 = mysqli_query($conn, $addCheck2);
// $row_addCheck2 = mysqli_fetch_array($result_addCheck2);
//
// if((int)$row_addCheck2[0]>0){
//   echo "<script>alert('중복된 연락처가 존재합니다. 중복된 연락처는 저장이 안돼요.');
//         history.back();</script>";
//   exit();
// }//고민하다가 이거를 빼기로 함


$sql = "
  INSERT INTO customer (
    div1, div2, name, contact1, contact2, contact3,
    gender, email, div3, div4, div5, companyname, cNumber1, cNumber2, cNumber3, zipcode, add1, add2, add3, etc, created, createPerson, user_id, building_id
    ) VALUES (
    '{$_POST['div1']}', '{$_POST['div2']}', '{$fil['name']}', '{$fil['contact1']}', '{$fil['contact2']}', '{$fil['contact3']}', '{$_POST['gender']}', '{$fil['email']}', '{$_POST['div3']}', '{$_POST['div4']}', '{$_POST['div5']}', '{$fil['companyname']}',
    '{$fil['cNumber1']}', '{$fil['cNumber2']}','{$fil['cNumber3']}', '{$_POST['zipcode']}', '{$fil['add1']}','{$fil['add2']}', '{$fil['add3']}', '{$fil['etc']}', now(), '{$_SESSION['manager_name']}', {$_SESSION['id']}, {$_POST['building']}
    )
";

// echo $sql;
$result = mysqli_query($conn, $sql);
if($result){
  echo "<script>alert('저장되었습니다.');
  location.href = 'customer.php';
  </script>";
} else {
  echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
  history.back();
  </script>";
  error_log(mysqli_error($conn));
}
?>
