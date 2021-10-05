<!-- 지출입력화면에서 고정비를 추가하는 프로세스파일 -->
<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
$fromDate = $_POST['year'] . '-' . $_POST['month'] . '-01';
$endDate = date('t', strtotime($fromDate));
$toDate = $_POST['year'] . '-' . $_POST['month'] . '-' . $endDate;

$a = json_decode($_POST['fixcostArray']);

for ($i=0; $i < count($a); $i++) {

  $exist_check = "select count(*)
                  from costlist
                  where user_id = {$_SESSION['id']} and
                        building_id = {$_POST['buildingIdx']} and
                        fixflexdiv = 'fix' and
                        title = '{$a[$i][1]}' and
                        DATE(payDate) BETWEEN '{$fromDate}' and '{$toDate}'
                  ";
  // echo $exist_check;

  $result_check = mysqli_query($conn, $exist_check);
  $row_check = mysqli_fetch_array($result_check);

  echo (int)$row_check[0];

  if((int)$row_check[0] >= 1){
    echo "<script>
          alert('".$a[$i][1]."은(는) 이미 입력되었으므로 넣기가 불가능합니다.');
          location.href='flexCost.php';
          </script>";
    exit();
  } else {
    $sql = "insert into costlist
            (fixflexdiv, title, amount1, amount2, amount3, payDate, building_id, user_id)
            values
            ('fix',
             '{$a[$i][1]}',
             '{$a[$i][2]}',
             '{$a[$i][3]}',
             '{$a[$i][4]}',
             '{$_POST['payDate']}',
             {$_POST['buildingIdx']},
             {$_SESSION['id']})
             ";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(1).');
                        history.back();
            </script>";
          error_log(mysqli_error($conn));
          exit();
    }
  }


}

echo "<script>alert('입력하였습니다.');
         history.back();
         console.log('minsun');
      </script>";

 ?>
