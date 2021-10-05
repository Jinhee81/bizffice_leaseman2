<?php //고객생성 파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$fil = array(
  'etc' => mysqli_real_escape_string($conn, $_POST['etc'])
);

// print_r($fil);


$addCheck2 = "
  select count(*) from customer
  where
    user_id={$_SESSION['id']} and
    contact1 = '{$fil['contact1']}' and
    contact2 = '{$fil['contact2']}' and
    contact3 = '{$fil['contact3']}' and
    building_id = {$_POST['building']}
    ";
// echo $addCheck2; check1은 필요없다. 이유는 문의여서 성명정보가 없기 때문에, 전화번호만 확인하면 된다.

$result_addCheck2 = mysqli_query($conn, $addCheck2);
$row_addCheck2 = mysqli_fetch_array($result_addCheck2);

if((int)$row_addCheck2[0]>0){
  echo "<script>alert('중복된 연락처가 존재합니다. 중복된 연락처는 저장이 안돼요.');
        history.back();</script>";
  exit();
}


$sql = "
  INSERT INTO customer (
    div1, qDate, name, contact1, contact2, contact3, etc, created, createPerson, user_id, building_id
    ) VALUES (
    '문의', '{$_POST['qDate']}', '문의', '{$_POST['contact1']}', '{$_POST['contact2']}', '{$_POST['contact3']}', '{$fil['etc']}', now(), '{$_SESSION['manager_name']}', {$_SESSION['id']}, {$_POST['building']}
    )
";

// echo $sql;
$result = mysqli_query($conn, $sql);
if($result){
  echo "<script>alert('저장되었습니다.');
  location.href = 'customer.php';
  </script>";
} else {
  echo "<script>alert('저장과정에 문제가 생겼습니다. 화면을 캡쳐하여 하단 이메일 info@leaseman.co.kr로 내용을 보내주세요.');
  history.back();
  </script>";
  error_log(mysqli_error($conn));
}
?>
