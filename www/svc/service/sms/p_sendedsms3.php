<!-- 이건 리스맨회사에서 회원들에게 문자보낼때 처리파일, 예약전송일 때 -->
<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

session_start();
include $_SERVER['DOCUMENT_ROOT']."/admin/view/aconn.php";
header("Content-Type: text/html; charset=UTF-8");
print_r($_POST);
// print_r($_SESSION);

$a = json_decode($_POST['sendedArray1']);
// $a = json_decode(json_encode($_POST['sendedArray1']), True);
print_r($a);echo "<br>";
print_r($_SESSION);echo "<br>";

$text = $_POST['textareaOnly'];
$sentnumber = '0318798003';

for ($i=0; $i < count($a); $i++) {

  $sql = "INSERT INTO sentsms_admin
        (div1, type, byte, sendtime, 
        recieve_type, recieve_div,  recieve_user_name, recieve_manager_name,
        recieve_cellphone, description, sentnumber, admin_id)
        VALUES
        ('reservation',
        '{$_POST['smsDiv']}',
        {$_POST['getByte']},
        '{$_POST['smsTime']}',
        '{$a[$i][4]->lease_type}',
        '{$a[$i][5]->user_div}',
        '{$a[$i][6]->user_name}',
        '{$a[$i][7]->manager_name}',
        '{$a[$i][2]->cellphone}',
        '{$text}',
        '{$sentnumber}',
        '{$_SESSION['id']}'
        )";
  echo $sql."<br>";
  echo "111<br>";
  $result = mysqli_query($conn, $sql);
    $sentsmsId = mysqli_insert_id($conn);

  if(!$result) {
    echo "<script>alert('error occurred-1.');</script>";
    // echo "<script>history.back();</script>";
    exit();
  }

  if((int)$_POST['getByte']>80) {
    $sql2 = "insert into MMS_MSG (
      SUBJECT,
      PHONE,
      CALLBACK,
      REQDATE,
      MSG,
      FILE_CNT,
      FILE_PATH1,
      FILE_PATH1_SIZ,
      ETC1,
      ETC2,
      ETC3,
      ETC4,
      ID

      ) value (
      '',
      '{$a[$i][2]->cellphone}',
      '{$sentnumber}',
      '{$_POST['smsTime']}',
      '{$text}',
      0,
      '',
      '0',
      'p',
      '11',
      '9',
      0,
      '{$sentsmsId}'
      )";
  } else {
    $sql2 = "insert into SC_TRAN (
      TR_SENDDATE,
      TR_ETC1,
      TR_ETC2,
      TR_ETC4,
      TR_ETC5,
      TR_ETC6,
      TR_PHONE,
      TR_CALLBACK,
      TR_MSG,
      TR_SENDSTAT,
      TR_MSGTYPE
      ) value (
      '{$_POST['smsTime']}',
      'p',
      {$sentsmsId},
      'L',
      '11',
      '9',
      '{$a[$i][2]->cellphone}',
      '{$sentnumber}',
      '".$text."',
      '0',
      '0'
      )";
  }

  echo $sql2."<br>";

  $result2 = mysqli_query($conn, $sql2);
  
  if(!$result2){
    echo "<script>alert('error occurred-2.');</script>";
    // echo "<script>history.back();</script>";
    error_log(mysqli_error($conn));
    exit();
  }
}// for end}

echo "<script>alert('전송예약했습니다. ".$_POST['smsTime']."에 전송됩니다.');</script>";
echo "<script>history.back();</script>";

?>