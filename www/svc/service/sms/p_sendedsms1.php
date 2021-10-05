<!-- 문자상용구없음으로 문자보냈을때 처리파일 -->
<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
header("Content-Type: text/html; charset=UTF-8");
// print_r($_POST);
// print_r($_SESSION);

$a = json_decode($_POST['sendedArray1']);
// $a = json_decode(json_encode($_POST['sendedArray1']), True);
// print_r($a);
$text = $_POST['textareaOnly'];
if($_POST['timeDiv']==='reservation'){
  if(!$_POST['smsTime']){
    echo "<script>
            alert('예약전송인 경우 날짜시간을 지정해야 합니다.');
            history.back();
          </script>";
  } else {
    for ($i=0; $i < count($a); $i++) {
      $sql = "INSERT INTO sentsms
              (div1, type, byte, sendtime, customer, roomNumber, phonenumber,
               description, sentnumber, user_id)
              VALUES
              ('reservationed',
               '{$_POST['smsDiv']}',
               '{$_POST['getByte']}',
               '{$_POST['smsTime']}',
               '{$a[$i][4]->받는사람}',
               '{$a[$i][3]->방번호}',
               '{$a[$i][5]->연락처}',
               '{$_POST['textareaOnly']}',
               '{$_POST['sendphonenumber']}',
               {$_SESSION['id']}
              )";
      // echo $sql;
      $result = mysqli_query($conn, $sql);

      $sentsmsId = mysqli_insert_id($conn);



      if($_POST['getByte']>80){
          //장문
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
            '{$a[$i][5]->연락처}',
            '{$_POST['sendphonenumber']}',
            '{$_POST['smsTime']}',
            '".$text."',
            0,
            '',
            '0',
            'p',
            '11',
            '9',
            0,
            '{$sentsmsId}'
            )";

        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
      }else{

//단문
      $sql3 = "insert into SC_TRAN (
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
        '{$a[$i][5]->연락처}',
        '{$_POST['sendphonenumber']}',
        '".$text."',
        '0',
        '0'
        );";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_array($result3);

    }



      if(!$result){
        echo "<script>alert('전송과정에 문제가 생겼습니다. 관리자에게 문의하세요(1).');
                          history.back();
              </script>";
            error_log(mysqli_error($conn));
            exit();
      }
    }//예약전송 for end}
  }
} else {

  for ($i=0; $i < count($a); $i++) {
    $sql2 = "INSERT INTO sentsms
            (div1, type, byte, sendtime, customer, roomNumber, phonenumber,
             description, sentnumber, user_id)
            VALUES
            ('immediately',
             '{$_POST['smsDiv']}',
             '{$_POST['getByte']}',
             now(),
             '{$a[$i][4]->받는사람}',
             '{$a[$i][3]->방번호}',
             '{$a[$i][5]->연락처}',
             '{$_POST['textareaOnly']}',
             '{$_POST['sendphonenumber']}',
             {$_SESSION['id']}
            )";
    // echo $sql2;
    $result2 = mysqli_query($conn, $sql2);
    $sentsmsId = mysqli_insert_id($conn);


    if($_POST['getByte']>80){
        //장문
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
            '{$a[$i][5]->연락처}',
            '{$_POST['sendphonenumber']}',
            now(),
            '".$text."',
            0,
            '',
            '0',
            'p',
            '11',
            '9',
            0,
            '{$sentsmsId}'
            )";

        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
      }else{

//단문
      $sql3 = "insert into SC_TRAN (
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

        now(),
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
        );";

        // echo $sql3;
        //     exit();
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_array($result3);

    }

    if(!$result2){
      echo "<script>alert('전송과정에 문제가 생겼습니다. 관리자에게 문의하세요(2).');
                    history.back();
            </script>";
          error_log(mysqli_error($conn));
          exit();
    }
  }//즉시전송 for end}



} //else end}

echo "<script>alert('전송하였습니다.');
        history.back();
      </script>";

?>
