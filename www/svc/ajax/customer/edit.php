<?php //팝업에서 고객수정파일
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['customer']['cid']);


$fil = array(
  mysqli_real_escape_string($conn, $_POST['customer']['div2']),
  mysqli_real_escape_string($conn, $_POST['customer']['div3']),
  mysqli_real_escape_string($conn, $_POST['customer']['div4']),
  mysqli_real_escape_string($conn, $_POST['customer']['div5']),
  mysqli_real_escape_string($conn, $_POST['customer']['name']),
  mysqli_real_escape_string($conn, $_POST['customer']['email']),
  mysqli_real_escape_string($conn, $_POST['customer']['etc']),
  mysqli_real_escape_string($conn, $_POST['customer']['companyname']),
  mysqli_real_escape_string($conn, $_POST['customer']['contact1']),
  mysqli_real_escape_string($conn, $_POST['customer']['contact2']),
  mysqli_real_escape_string($conn, $_POST['customer']['contact3']),
  mysqli_real_escape_string($conn, $_POST['customer']['cNumber1']),
  mysqli_real_escape_string($conn, $_POST['customer']['cNumber2']),
  mysqli_real_escape_string($conn, $_POST['customer']['cNumber3']),
  mysqli_real_escape_string($conn, $_POST['customer']['add1']),
  mysqli_real_escape_string($conn, $_POST['customer']['add2']),
  mysqli_real_escape_string($conn, $_POST['customer']['add3']),
  mysqli_real_escape_string($conn, $_POST['customer']['zipcode'])
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
          email, etc,
          zipcode, add1, add2, add3
        from customer
        where id={$filtered_id}";
// echo $sql;

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$fil2 = array(
  $row['div2'], $row['div3'], $row['div4'], $row['div5'],
  $row['name'], $row['email'], $row['etc'], $row['companyname'],
  $row['contact1'], $row['contact2'], $row['contact3'], $row['cNumber1'], $row['cNumber2'], $row['cNumber3'],
  $row['add1'], $row['add2'], $row['add3'], $row['zipcode']
);

// print_r($fil2)."<br>";

for ($i=0; $i < 18; $i++) {
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
               zipcode = '{$fil[17]}',
               add1 = '{$fil[14]}',
               add2 = '{$fil[15]}',
               add3 = '{$fil[16]}',
               updated = now(),
               updatePerson = '{$_SESSION['manager_name']}'
            WHERE id = {$filtered_id}";
    // echo $sql2;
    $result2 = mysqli_query($conn, $sql2);
    if($result2){
      echo json_encode("success");
      exit();
    } else {
      echo json_encode("error_occured");
      error_log(mysqli_error($conn));
      exit();
    }
  }
}

echo json_encode("none_changes");

?>