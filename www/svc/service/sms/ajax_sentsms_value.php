<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
include "ajax_sentsms_sql.php";

$result = mysqli_query($conn, $sql);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

for ($i=0; $i < count($allRows); $i++) {
  $allRows[$i]['count']= $row_count[0];

  $allRows[$i]['customermb'] =  mb_substr($allRows[$i]['customer'],0,10,'utf-8');
  $allRows[$i]['descriptionmb'] =  mb_substr($allRows[$i]['description'],0,10,'utf-8');

  $allRows[$i]['yearmonth'] = date('Ym', strtotime($allRows[$i]['sendtime']));

  if($allRows[$i]['type']==='sms'){
    $sql2 = "select TR_RSLTSTAT
             from SC_LOG_".$allRows[$i]['yearmonth']."
             where TR_ETC2={$allRows[$i]['id']}";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    if($row2[0]==='06'){
      $allRows[$i]['result2']='전송성공';
    } else {
      $allRows[$i]['result2']='전송실패('.$row2[0].')';
    }

    $sql3 = "update sentsms
             set
              result = '{$row2[0]}'
             where id={$allRows[$i]['id']}";
    $result3 = mysqli_query($conn, $sql3);

  } else if($allRows[$i]['type']==='mms'){
    $sql2 = "select RSLT
             from MMS_LOG_".$allRows[$i]['yearmonth']."
             where id='{$allRows[$i]['id']}'
             ";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    if($row2[0]==='1000'){
      $allRows[$i]['result2']='전송성공';
    } else {
      $allRows[$i]['result2']='전송실패('.$row2[0].')';
    }

    $sql3 = "update sentsms
             set
              result = '{$row2[0]}'
             where id={$allRows[$i]['id']}";
    $result3 = mysqli_query($conn, $sql3);

  }
}

echo json_encode($allRows);
?>
