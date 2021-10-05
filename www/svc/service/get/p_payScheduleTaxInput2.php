<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
header("Content-Type: text/html; charset=UTF-8");

$a = json_decode($_POST['taxArray']);

print_r($a);

for ($i=0; $i < count($a); $i++) {
  $sql = "update paySchedule2
          set
              taxSelect = '{$_POST['taxSelect']}',
              taxDate = '{$_POST['taxDate']}'
          WHERE
              idpaySchedule2 = {$a[$i][1]->청구번호}";
  // echo $sql;

  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "<script>alert('발행과정에 문제가 생겼습니다. 화면을 캡쳐하여 하단 이메일 info@leaseman.co.kr로 내용을 보내주세요');
                  history.back();
            </script>";
    error_log(mysqli_error($conn));
    exit();
  }
}

echo "<script>alert('입력하였습니다.');
history.back();
</script>";


 ?>
