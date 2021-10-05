<!-- 지출입력화면에서 변동비를 추가하는 프로세스파일 -->
<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$sql = "insert into costlist
        (fixflexdiv, title, amount1, amount2, amount3, payDate, taxDate, etc, building_id, user_id)
        values
        ('flex',
         '{$_POST['title']}',
         '{$_POST['mamount1']}',
         '{$_POST['mamount2']}',
         '{$_POST['mamount3']}',
         '{$_POST['payDate']}',
         '{$_POST['taxDate']}',
         '{$_POST['etc']}',
         {$_POST['modalbuilding']},
         {$_SESSION['id']})
         ";
// echo $sql;

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "<script>alert('입력과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
                    history.back();
        </script>";
      error_log(mysqli_error($conn));
      exit();
}

echo "<script>alert('입력하였습니다.');
         location.href='flexCost.php';
      </script>";


 ?>
