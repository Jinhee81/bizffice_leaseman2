<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


// print_r($_POST);echo "<br>";

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);
$filtered_enddate3 = mysqli_real_escape_string($conn, $_POST['enddate3']);//중간종료일
$filtered_enddate4 = mysqli_real_escape_string($conn, $_POST['enddate4']);//환불일자
$amount = mysqli_real_escape_string($conn, $_POST['middleEndAmount']);
$avamount = mysqli_real_escape_string($conn, $_POST['middleEndAvmount']);
$atamount = mysqli_real_escape_string($conn, $_POST['middleEndAtmount']);
$executiveDiv2 = mysqli_real_escape_string($conn, $_POST['executiveDiv2']);
$buildingId = mysqli_real_escape_string($conn, $_POST['buildingId']);
$rPayid = mysqli_real_escape_string($conn, $_POST['rPayid']);

$amount = (int)str_replace(',', '', $amount);
$avamount = (int)str_replace(',', '', $avamount);
$atamount = (int)str_replace(',', '', $atamount);

$sql1 = "update realContract set
          endDate3 = '{$filtered_enddate3}',
          rAmount = {$amount},
          rvAmount = {$avamount},
          rtAmount = {$atamount},
          rKind = '{$executiveDiv2}',
          rDate = '{$filtered_enddate4}',
          updateTime = now()
         where id={$filtered_id}
        ";
// echo $sql1;

$result1 = mysqli_query($conn, $sql1);

if(!$result1){
  echo json_encode("error_occured_1");
  exit();
}

if($rPayid === '0'){ //원래청구번호가 없었는데
    if($atamount > 0) { //환불금액이 생길때는 새로 입력합
        $sql2 = "insert into paySchedule2
        (pAmount, pvAmount, ptAmount, executiveDate, payKind, getAmount, realContract_id, building_id, user_id)
       values
         (
         '-{$amount}',
         '-{$avamount}',
         '-{$atamount}',
         '{$filtered_enddate4}',
         '{$executiveDiv2}',
         '-{$atamount}',
         {$filtered_id},
         {$buildingId},
         {$_SESSION['id']}
        )
        ";

      $result2 = mysqli_query($conn, $sql2);
    
      if(!$result2){
      echo json_encode("error_occured_2");
      exit();
      }

      $rPayid = mysqli_insert_id($conn);

      $sql3 = "
          update realContract 
          set rPayid={$rPayid} 
          where id={$filtered_id}
          ";
      $result3 = mysqli_query($conn, $sql3);

      if(!$result3) {
            echo json_encode("error_occured_3");
            exit();
      }
    } //원래 청구번호가 없었는데 환불금액이 0원일때는 새로입력,수정아무것도 없음
} else { //원래청구번호가 있었는데
    if($atamount > 0) { //환불금액이 생길때는 수정처리가 됨
        $sql2 = "
                update paySchedule2
                set
                    pAmount = '-{$amount}',
                    pvAmount = '-{$avamount}',
                    ptAmount = '-{$atamount}',
                    executiveDate = '{$filtered_enddate4}',
                    payKind = '{$executiveDiv2}',
                    getAmount = '-{$atamount}'
                where idpaySchedule2 = {$rPayid}
                ";
                
        $result2 = mysqli_query($conn, $sql2);
    } else { //그런데 원래청구번호가 있었는데 환불금액이 0원이 되면 청구데이터는 삭제가 됨
        $sql2 = "delete from paySchedule2
                where idpaySchedule2 = {$rPayid};
                ";
        $result2 = mysqli_query($conn, $sql2);
        
        $sql3 = "
          update realContract 
          set rPayid=null
          where id={$filtered_id}
          ";
        $result3 = mysqli_query($conn, $sql3);

        if(!$result3) {
            echo json_encode("error_occured_3");
            exit();
        }
    }
}


echo json_encode('success');
 ?>