<?php //팝업에서 고객수정파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['id_m']);


$fil = array(
  mysqli_real_escape_string($conn, $_POST['div2_m']),
  mysqli_real_escape_string($conn, $_POST['div3_m']),
  mysqli_real_escape_string($conn, $_POST['div4_m']),
  mysqli_real_escape_string($conn, $_POST['div5_m']),
  mysqli_real_escape_string($conn, $_POST['name_m']),
  mysqli_real_escape_string($conn, $_POST['email_m']),
  mysqli_real_escape_string($conn, $_POST['etc_m']),
  mysqli_real_escape_string($conn, $_POST['companyname_m']),
  mysqli_real_escape_string($conn, $_POST['contact1_m']),
  mysqli_real_escape_string($conn, $_POST['contact2_m']),
  mysqli_real_escape_string($conn, $_POST['contact3_m']),
  mysqli_real_escape_string($conn, $_POST['cNumber1_m']),
  mysqli_real_escape_string($conn, $_POST['cNumber2_m']),
  mysqli_real_escape_string($conn, $_POST['cNumber3_m'])
);

// print_r($fil)."<br>";


//
settype($filtered_id, 'integer');
//
// // print_r($fil);

$sql = "select
          div2, name, contact1, contact2, contact3,
          div3, div4, div5,
          companyname, cNumber1, cNumber2, cNumber3,
          email, etc
        from customer
        where id={$filtered_id}";
// echo $sql;

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$fil2 = array(
  $row['div2'], $row['div3'], $row['div4'], $row['div5'],
  $row['name'], $row['email'], $row['etc'], $row['companyname'],
  $row['contact1'], $row['contact2'], $row['contact3'], $row['cNumber1'], $row['cNumber2'], $row['cNumber3']
);

// print_r($fil2)."<br>";

for ($i=0; $i < 14; $i++) {
  if($fil[$i] === $fil2[$i]){
  } else {
    $sql2 = "UPDATE customer
            SET
               div2 = '{$fil[0]}',
               name = '{$fil[4]}',
               contact1 = '{$fil[8]}',
               contact2 = '{$fil[9]}',
               contact3 = '{$fil[10]}',
               email = '{$fil[5]}',
               div3 = '{$fil[1]}',
               div4 = '{$fil[2]}',
               div5 = '{$fil[3]}',
               companyname = '{$fil[7]}',
               cNumber1 = '{$fil[11]}',
               cNumber2 = '{$fil[12]}',
               cNumber3 = '{$fil[13]}',
               etc = '{$fil[6]}',
               updated = now(),
               updatePerson = '{$_SESSION['manager_name']}'
            WHERE id = {$filtered_id}";
    // echo $sql2;
    $result2 = mysqli_query($conn, $sql2);
    if($result2){
      echo "<script>alert('수정하였습니다.');
      history.back();
      </script>";
      exit();
    } else {
      echo "<script>alert('수정 과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
      history.back();
      </script>";
      error_log(mysqli_error($conn));
      exit();
    }
  }
}

echo "<script>alert('수정내역이 없네요.다시확인해보세요.');
history.back();
</script>";

?>
