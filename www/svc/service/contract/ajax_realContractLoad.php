<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
include "ajax_realContractSql.php";

// print_r($_POST);echo "<br>";
// echo $sql;echo "<br>";
//
// print_r($allRows);


for ($i=0; $i < count($allRows); $i++) {

  $allRows[$i]['count']= $row_count[0];

  $allRows[$i]['cNumber'] = $allRows[$i]['cNumber1'].'-'.$allRows[$i]['cNumber2'].'-'.$allRows[$i]['cNumber3'];

  if($allRows[$i]['div3']==='주식회사'){
    $allRows[$i]['cdiv3'] = '(주)';
  } elseif($allRows[$i]['div3']==='유한회사'){
    $allRows[$i]['cdiv3'] = '(유)';
  } elseif($allRows[$i]['div3']==='합자회사'){
    $allRows[$i]['cdiv3'] = '(합)';
  } elseif($allRows[$i]['div3']==='기타'){
    $allRows[$i]['cdiv3'] = '(기타)';
  }

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['ccnn'] = $allRows[$i]['cname'].'('.$allRows[$i]['ccomname'].','.$allRows[$i]['cNumber'].')';
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['ccnn'] = $allRows[$i]['cdiv3'].$allRows[$i]['ccomname'].'('.$allRows[$i]['cname'].','.$allRows[$i]['cNumber'].')';
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['ccnn'] = $allRows[$i]['cname'];
  }

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['ccnn2'] = $allRows[$i]['cname'].'('.$allRows[$i]['ccomname'].')';
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['ccnn2'] = $allRows[$i]['cdiv3'].$allRows[$i]['ccomname'].'('.$allRows[$i]['cname'].')';
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['ccnn2'] = $allRows[$i]['cname'];
  }

  $allRows[$i]['ccomname2'] = mb_substr($allRows[$i]['cdiv3'].$allRows[$i]['ccomname'],0,10,'utf-8');

  $allRows[$i]['ccnnmb'] = mb_substr($allRows[$i]['ccnn'],0,10,'utf-8');

  $allRows[$i]['contact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];

  $allRows[$i]['startDate'] = date('Y-n-j', strtotime($allRows[$i]['startDate']));
  $allRows[$i]['endDate2'] = date('Y-n-j', strtotime($allRows[$i]['endDate2']));

  $sql_step = "select idpaySchedule2 from paySchedule2 where realContract_id = {$allRows[$i]['rid']}";
  // echo $sql_step;
  $result_step = mysqli_query($conn, $sql_step);
  if ($result_step->num_rows === 0) {
    $allRows[$i]['step'] = 'clear';
  } else {
    $sql_step2 = "select getAmount from paySchedule2 where realContract_id = {$allRows[$i]['rid']}";
    // echo $sql_step2;
    $result_step2 = mysqli_query($conn, $sql_step2);
    $getAmount = 0;
    while($row_step2 = mysqli_fetch_array($result_step2)){
      $getAmount = $getAmount + (int)$row_step2[0];
    }
    // echo $getAmount;

    if($getAmount > 0) {
      $allRows[$i]['step'] = 'recieved';
    } else {
        $allRows[$i]['step'] = 'recieving';
    }
  }

  $sql_file_c = "select count(*) from upload_file where realContract_id={$allRows[$i]['rid']}";
  // echo $sql_file_c;
  $result_file_c = mysqli_query($conn, $sql_file_c);
  $row_file_c = mysqli_fetch_array($result_file_c);

  $allRows[$i]['filecount'] = (int)$row_file_c[0];


  $sql_memo_c = "select count(*) from realContract_memo where realContract_id={$allRows[$i]['rid']}";
  $result_memo_c = mysqli_query($conn, $sql_memo_c);
  $row_memo_c = mysqli_fetch_array($result_memo_c);

  $allRows[$i]['memocount'] = (int)$row_memo_c[0];

  $sql_deposit = "select remainMoney from realContract_deposit where realContract_id={$allRows[$i]['rid']}";
  $result_deposit = mysqli_query($conn, $sql_deposit);
  $row_deposit = mysqli_fetch_array($result_deposit);

  $allRows[$i]['deposit'] = $row_deposit[0];

} //for문closing

// print_r($allRows);

echo json_encode($allRows);
?>
