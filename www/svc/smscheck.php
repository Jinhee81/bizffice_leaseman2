<?php

// error_reporting(E_ALL);

// ini_set("display_errors", 1);
header("Content-Type: text/html; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
$phone = $_POST['phone'];
$rand = $_POST['rand'];
$sql = "insert into sms_check(checknumber,phonenumber) values ('".$rand."','".$phone."')";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
//subject = 빈칸
//phone 받는사람
//callback 보내는사람 폰번호
//REQDATE now()
//MSG 메세지
//file_cnt 0
//file_path1 빈칸
//file_path1_siz 0
//etc1 p? m? 머지
//etc2,3 숫자
//etc4 L?M?P? 머지
// $sql2 = "insert into MMS_MSG (
//                             SUBJECT,
//                             PHONE,
//                             CALLBACK,
//                             REQDATE, 
//                             MSG, 
//                             FILE_CNT, 
//                             FILE_PATH1, 
//                             FILE_PATH1_SIZ, 
//                             ETC1, 
//                             ETC2, 
//                             ETC3, 
//                             ETC4

//                             ) value ( 

//                             '', 
//                             '01041075293',
//                             '01041075293',
//                             now(),
//                             '미안하다 이거 보여주려고 어그로 끌었다.',
//                             0,
//                             '',
//                             '0',
//                             'p',
//                             '11',
//                             '9',
//                             'L'
//                             )";
// $result2 = mysqli_query($conn, $sql2);
// $row2 = mysqli_fetch_array($result2);

//TR_SENDDATE now()
//TR_ETC1 p
//TR_ETC4 L?M머지
// TR_ETC5,6 숫자
//TR_PHONE 받는사람
//TR_CALLBACK 보내는사람폰번호
//TR_MSG 메세지
//_TR_SENDSTAT 2
//TR_MSGTYPE 0

$sql3 = "insert into SC_TRAN (
                            TR_SENDDATE, 
                            TR_ETC1, 
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
                            'L',
                            '11',
                            '9',
                            '".$phone."',
                            '01068135825',
                            '인증번호 [".$rand."]를 입력해주시길 바랍니다. -리스맨-',
                            '0',
                            '0'
                            );";
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_array($result3);
echo $sql3;
?>
