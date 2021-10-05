<?php
// 문자상용구없음으로 문자보냈을때 처리파일, ajax
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
header("Content-Type: text/html; charset=UTF-8");
print_r($_POST);
// print_r($_SESSION);

$a = json_decode($_POST['sendedArray1']);
$text = $_POST['textareaOnly'];

if($_POST['timeDiv']==='reservation') {
  if(!$_POST['smsTimeValue']){
    echo json_encode('date_not_exist');
    error_log(mysqli_error($conn));
    exit();
  }

  $sendtime = $_POST['smsTimeValue'];
} else {
  $sendtime = 'now()';
}

for ($i=0; $i < count($a); $i++) {
  $sql = "INSERT INTO sentsms
          (div1, type, byte, sendtime, customer, roomNumber, phonenumber,
           description, sentnumber, user_id)
          VALUES
          ('{$_POST['smsTime']}',
           '{$_POST['smsDiv']}',
           '{$_POST['getByte']}',
           $sendtime,
           '{$a[$i][4]->받는사람}',
           '{$a[$i][3]->방번호}',
           '{$a[$i][5]->연락처}',
           '{$_POST['textareaOnly']}',
           '{$_POST['sendphonenumber']}',
           {$_SESSION['id']}
          )";
  echo $sql;
  $result = mysqli_query($conn, $sql);

  if(!$result) {
    echo json_encode('insert_error1');
    error_log(mysqli_error($conn));
    exit;
  } else {
    $sentsmsId = mysqli_insert_id($conn);

    if($_POST['getByte']>80){    //장문
      $sql2 = "insert into MMS_MSG (
          SUBJECT,PHONE,CALLBACK,REQDATE,MSG,
          FILE_CNT,FILE_PATH1,FILE_PATH1_SIZ,
          ETC1,ETC2,ETC3,ETC4,ID)
          value
          ('',
          '{$a[$i][5]->연락처}',
          '{$_POST['sendphonenumber']}',
          $sendtime',
          '".$text."',
          0,
          '',
          '0',
          'p',
          '11',
          '9',
          0,
          '{$sentsmsId}')";
      
      echo $sql2;
      $result2 = mysqli_query($conn, $sql2);

      if(!$result2){
        echo json_encode('insert_error2');
        error_log(mysqli_error($conn));
        exit();
      } 
    } else { //단문
      $sql3 = "insert into SC_TRAN (
      TR_SENDDATE,TR_ETC1,TR_ETC2,TR_ETC4,
      TR_ETC5,TR_ETC6,TR_PHONE,
      TR_CALLBACK,TR_MSG,TR_SENDSTAT,TR_MSGTYPE
      ) value (
      {$sendtime},
      'p',
      {$sentsmsId},
      'L',
      '11',
      '9',
      '{$a[$i][5]->연락처}',
      '{$_POST['sendphonenumber']}',
      '".$text."',
      '0',
      '0'
      )";

      echo $sql3;

      $result3 = mysqli_query($conn, $sql3);

      if(!$result3){
        echo json_encode('insert_error3');
        error_log(mysqli_error($conn));
        exit();
      } 
    }
  }
}
// echo json_encode('success');
?>