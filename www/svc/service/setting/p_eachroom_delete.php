<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

print_r($_POST);echo "<br>";


if($_POST['count'] === $_POST['roomOrder']){
  $sql1 = "
           delete from r_g_in_building where id={$_POST['roomId']}
          ";
  $result1 = mysqli_query($conn, $sql1);

  if(!$result1){
    echo "<script>
    alert('관리번호 삭제에 문제가 생겼습니다. 관리자에게 문의하세요(1).');
    history.back();
    </script>";
    error_log(mysqli_error($conn));
    exit();
  }
} else {

  $sql1 = "
           delete from r_g_in_building where id={$_POST['roomId']}
          ";
  $result1 = mysqli_query($conn, $sql1);

  if($result1){
    for ($i=(int)$_POST['roomOrder']; $i < (int)$_POST['count'] ; $i++) {
      $j = $i + 1;
      $sql2 = "select id, ordered
               from r_g_in_building
               where ordered = {$j} and
                     group_in_building_id = {$_POST['groupId']}";
      echo $sql2."<br>";

      $result2 = mysqli_query($conn, $sql2);

      if(!$result2){
        echo "<script>
        alert('관리번호 삭제에 문제가 생겼습니다. 관리자에게 문의하세요(2).');
        history.back();
        </script>";
        error_log(mysqli_error($conn));
        exit();
      }

      $row2 = mysqli_fetch_array($result2);

      $newOrder = (int)$row2['ordered'] - 1;

      $sql3 = "update r_g_in_building
               set
                 ordered = {$newOrder}
               where
                 id = {$row2['id']}
              ";
      echo $sql3."<br>";

      $result3 = mysqli_query($conn, $sql3);

      if(!$result3){
        echo "<script>
        alert('관리번호 삭제에 문제가 생겼습니다. 관리자에게 문의하세요(3).');
        history.back();
        </script>";
        error_log(mysqli_error($conn));
        exit();
      }
    } //for }


  } else {
    echo "<script>
    alert('관리번호 삭제에 문제가 생겼습니다. 관리자에게 문의하세요(4).');
    history.back();
    </script>";
    error_log(mysqli_error($conn));
    exit();
  }//result1이 참이 아닐때
}//roomOrder가 마지막이 아닐 때

$newCount = (int)$_POST['count'] - 1;

$sql4 = "update group_in_building
         set
            count = {$newCount},
            updated = now()
         where id={$_POST['groupId']}";
$result4 = mysqli_query($conn, $sql4);

if(!$result4){
  echo "<script>
  alert('관리번호 삭제에 문제가 생겼습니다. 관리자에게 문의하세요(5).');
  history.back();
  </script>";
  error_log(mysqli_error($conn));
  exit();
}

echo "<script>
alert('삭제하였습니다.');
history.back();
</script>";



?>
