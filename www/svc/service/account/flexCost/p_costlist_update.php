<!-- 지출입력화면에서 실제로는 고정비를 업데이트하는 프로세스파일-->
<!-- 원래 고정비,변동비 저장이 따로있었는데 그럴필요가 없어서 한개로 통일했음 -->
<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// echo 111;

$a = json_decode($_POST['costlistArray1']);
$b = json_decode($_POST['costlistArray2']);

// print_r($a);

for ($i=0; $i < count($a); $i++) {
  $amount1 = number_format((int)$a[$i][2]);
  $amount2 = number_format((int)$a[$i][3]);
  $amount3 = number_format((int)$a[$i][4]);
  // print_r($amount1);

  $sql = "
         update costlist
         set
            amount1 = '{$amount1}',
            amount2 = '{$amount2}',
            amount3 = '{$amount3}',
            payDate = '{$a[$i][5]}',
            taxDate = '{$a[$i][6]}',
            etc = '{$a[$i][7]}'
         where id = {$a[$i][0]}
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

for ($i=0; $i < count($b); $i++) {
  $amount1 = number_format((int)$b[$i][2]);
  $amount2 = number_format((int)$b[$i][3]);
  $amount3 = number_format((int)$b[$i][4]);
  // print_r($amount1);

  $sql2 = "
         update costlist
         set
            amount1 = '{$amount1}',
            amount2 = '{$amount2}',
            amount3 = '{$amount3}',
            payDate = '{$b[$i][5]}',
            taxDate = '{$b[$i][6]}',
            etc = '{$b[$i][7]}'
         where id = {$b[$i][0]}
  ";

  // echo $sql;
  $result2 = mysqli_query($conn, $sql2);
  if(!$result2){
    echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
                      history.back();
          </script>";
        error_log(mysqli_error($conn));
        exit();
  }
}

echo "<script>alert('저장하였습니다.');
      history.back();
      </script>";

 ?>
