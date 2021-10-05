<!-- 이 파일도 대대적으로 손질됨. 이유는 정기결제가 빠지면서 손질되었음 -->
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$fil['session_id'] = mysqli_real_escape_string($conn, $_SESSION['id']);

$sql = "select count(*) from grade where user_id={$fil['session_id']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$ordered = (int)$row[0] + 1;

if($_POST['paydiv']==='yearonly'){
  $sql2 = "insert into grade
           (gradename, executivedate, startdate, enddate,
            formonth, payamount, ordered, user_id)
           VALUES
           ('{$_POST['gradename']}',
            '{$_POST['today']}',
            '{$_POST['today']}',
            '{$_POST['year1later']}',
            12,
            {$_POST['amount']},
            {$ordered},
            {$fil['session_id']}
           )
           ";
  // echo $sql2;

  $result2 = mysqli_query($conn, $sql2);

  if(!$result2){
    echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(1)');
    location.href = 'payment.php';
    </script>";
    error_log(mysqli_error($conn));
  } else {
    $sql3 = "update user
             set
                gradename='{$_POST['gradename']}'
             where id = {$fil['session_id']}";
    $result3 = mysqli_query($conn, $sql3);

    if(!$result3){
      echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(2)');
      location.href = 'payment.php';
      </script>";
      error_log(mysqli_error($conn));
    }
  }
}


if($_POST['paydiv']==='monthonly') {
  $sql3 = "insert into grade
           (gradename, executivedate, startdate, enddate,
            formonth, payamount, ordered, user_id)
           VALUES
           ('{$_POST['gradename']}',
            '{$_POST['today']}',
            '{$_POST['today']}',
            '{$_POST['month1later']}',
            1,
            {$_POST['amount']},
            {$ordered},
            {$fil['session_id']}
           )
           ";
  // echo $sql2;

  $result3 = mysqli_query($conn, $sql3);

  if(!$result3){
    echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(3)');
    location.href = 'payment.php';
    </script>";
    error_log(mysqli_error($conn));
  } else {
    $sql4 = "update user
             set
                gradename='{$_POST['gradename']}'
             where id = {$fil['session_id']}";
    $result4 = mysqli_query($conn, $sql4);

    if(!$result4){
      echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(4)');
      location.href = 'payment.php';
      </script>";
      error_log(mysqli_error($conn));
    }
  }
}

if($_POST['paydiv']==='monthly') {

  $sql5 = "insert into grade
           (gradename, executivedate, startdate, enddate,
            formonth, payamount, ordered, user_id)
           VALUES
           ('{$_POST['gradename']}(s)',
            '{$_POST['today']}',
            '{$_POST['today']}',
            '{$_POST['month1later']}',
            1,
            {$_POST['amount']},
            {$ordered},
            {$fil['session_id']}
           )
           ";
  // echo $sql5;

  $result5 = mysqli_query($conn, $sql5);

  if(!$result5){
    echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(5)');
    location.href = 'payment.php';
    </script>";
    error_log(mysqli_error($conn));
  } else {
    $sql6 = "update user
             set
                gradename='{$_POST['gradename']}'
             where id = {$fil['session_id']}";
    $result6 = mysqli_query($conn, $sql6);

    if(!$result6){
      echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(6)');
      location.href = 'payment.php';
      </script>";
      error_log(mysqli_error($conn));
    } else {

      $nextstartdate = date('Y-m-d', strtotime($_POST['month1later'].'+1 days'));
      $nextenddate = date('Y-m-d', strtotime($nextstartdate.'+1 month -1 days'));

      $sql7 = "insert into subscription
              (expecteddate, startdate, enddate, gradename, payamount, user_id)
              VALUES
              ('{$_POST['month1later']}',
               '{$nextstartdate}',
               '{$nextenddate}',
               '{$_POST['gradename']}(s)',
               '{$_POST['amount']}',
               {$fil['session_id']}
              )";

        $result7 = mysqli_query($conn, $sql7);

        if(!$result7){
          echo "<script>alert('결제과정에 문제가 생겼습니다. 관리자에게 문의하세요.(7)');
          location.href = 'payment.php';
          </script>";
          error_log(mysqli_error($conn));

    }
  }
}
}

echo "<script>alert('결제하였습니다.');
location.href = 'main.php';
</script>";





 ?>
