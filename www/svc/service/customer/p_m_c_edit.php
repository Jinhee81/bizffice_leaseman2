<?php //고객수정파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['id']);


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
  'postcode' => mysqli_real_escape_string($conn, $_POST['postcode']),
  'add1' => mysqli_real_escape_string($conn, $_POST['add1']),
  'add2' => mysqli_real_escape_string($conn, $_POST['add2']),
  'add3' => mysqli_real_escape_string($conn, $_POST['add3']),
  'birthday' => mysqli_real_escape_string($conn, $_POST['birthday']),
);

settype($filtered_id, 'integer');

// print_r($fil);

if($_POST['div3']){
  $div2 = '법인사업자';
} else {
  if($fil['companyname']){
    $div2 = '개인사업자';
  } else {
    $div2 = '개인';
  }
}


$sql = "
  UPDATE customer
  SET
    building_id = {$_POST['building']},
    div1 = '{$_POST['div1']}',
    div2 = '{$div2}',
    name = '{$fil['name']}',
    contact1 = '{$fil['contact1']}',
    contact2 = '{$fil['contact2']}',
    contact3 = '{$fil['contact3']}',
    gender = '{$_POST['gender']}',
    email = '{$fil['email']}',
    div3 = '{$_POST['div3']}',
    div4 = '{$_POST['div4']}',
    div5 = '{$_POST['div5']}',
    companyname = '{$fil['companyname']}',
    cNumber1 = '{$fil['cNumber1']}',
    cNumber2 = '{$fil['cNumber2']}',
    cNumber3 = '{$fil['cNumber3']}',
    zipcode = '{$fil['postcode']}',
    add1 = '{$fil['add1']}',
    add2 = '{$fil['add2']}',
    add3 = '{$fil['add3']}',
    etc = '{$fil['etc']}',
    birthday = '{$fil['birthday']}',
    updated = now(),
    updatePerson = '{$_SESSION['manager_name']}'
  WHERE id = {$filtered_id}
";

// echo $sql;

$result = mysqli_query($conn, $sql);
if($result){
  echo "<script>alert('수정하였습니다.');
  history.back();
  </script>";
} else {
  echo "<script>alert('수정 과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
  history.back();
  </script>";
  error_log(mysqli_error($conn));
}

?>
