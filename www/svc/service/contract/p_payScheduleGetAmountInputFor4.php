<!-- 납부예정화면에서 입금처리 누르면 실행되는거 -->
<?php
header('Content-Type: text/html; charset=UTF-8');
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

print_r($_POST);
print_r($_SESSION);

$a = json_decode($_POST['psArray']);

print_r($a);

for ($i=0; $i < count($a); $i++) {
  if(!strtotime($a[$i][2])){
    echo "<script>
          alert('입금일 ".$a[$i][2]."은 날짜형식이 아닙니다. 날짜형식에 맞추어서 입력해주세요 (날짜형식:yyyy-mm-dd)');
          history.back();
          </script>";
    exit();
  }

  $b = explode('-',$a[$i][2]);

  $c = checkdate((int)$b[1], (int)$b[2], (int)$b[0]);
  // var_dump($b);

  if(!$c){
    echo "<script>
          alert('입금일 ".$a[$i][2]."날짜는 존재하지 않습니다. 다시 확인해주세요.');
          history.back();
          </script>";
    exit();
  }

  $sql_u = "update paySchedule2
            set
              payKind = '{$a[$i][4]}',
              executiveDate = '{$a[$i][2]}',
              getAmount = '{$a[$i][3]}'
            where idpaySchedule2 = {$a[$i][1]}
  ";
  // echo $sql_u;
  $result_u = mysqli_query($conn, $sql_u);

  if($result_u){
    $sql = "UPDATE realContract SET
               updateTime = now()
             WHERE
               id = {$a[$i][5]}
            ";
    // echo $sql5;
    $result = mysqli_query($conn, $sql);

    if($result===false){
      echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.(2)');
            history.back();
            </script>";
      error_log(mysqli_error($conn));
      exit();
    }
  } else {
    echo "<script>alert('입금처리에 문제가 생겼습니다. 관리자에게 문의하세요.(1)');
          history.back();
          </script>";
    error_log(mysqli_error($conn));
  }
}//for end}

echo "<script>
        alert('납부완료하였습니다.');
        location.href = '../get/getexpected.php';
      </script>";

?>
