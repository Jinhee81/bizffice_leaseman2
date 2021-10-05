<?php

    $conn = mysqli_connect("localhost", "leaseman", "leaseman!!22", "leaseman_svc");
    date_default_timezone_set('Asia/Seoul');

    $today = date("Y-m-d");

    if (empty($_POST))  echo '잘못된 접근 경로입니다.';

    $payment_log = implode('&', $_POST);

    // log 저장
    $insertpayment = "INSERT INTO payment (tid, moid, payment_log) VALUES ('{$_POST['no_tid']}',
     '{$_POST['no_oid']}',
     '{$payment_log}')";

    mysqli_query($conn, $insertpayment);
    // print_r($insertpayment);
    // 계좌정보 유효성 체크
    $vbankSql = "SELECT * FROM grade WHERE accountnumber = '" . $_POST["no_vacct"] . "' AND resulted = 'wait'";
    $vbankResult = mysqli_query($conn,$vbankSql);
    $vbankRow = mysqli_fetch_array($vbankResult);

    // 계좌정보가 없는 경우
    if (!$vbankRow){
        echo 'NO_ACCOUNT';
        exit;
    }

    // tid정보가 없는 경우
    $tidSql = "SELECT * FROM payment WHERE tid = '" . $_POST["no_tid"] . "'";
    $tidResult = mysqli_query($conn,$tidSql);
    $tidRow = mysqli_fetch_array($tidResult);

    if (!$tidRow){
        echo 'NO_TID';
        exit;
    }

    // moid정보가 없는 경우
    $moidSql = "SELECT * FROM payment WHERE moid = '" . $_POST["no_moid"] . "'";
    $moidResult = mysqli_query($conn,$moidSql);
    $moidRow = mysqli_fetch_array($moidResult);

    if (!$moidRow){
        echo 'NO_MOID';
        exit;
    }


    $updateGrade = "UPDATE grade SET executivedate2 = '" . $today . "', resulted = 'done' WHERE accountnumber = '" . $_POST["no_vacct"] . "' AND payhow = 'VBank' AND resulted = 'wait'";
    $updateGrade = mysqli_query($conn, $updateGrade);



echo "Ok";
?>
