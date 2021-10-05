<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

print_r($_POST);
print_r($_SESSION);

// $sql_pay = "select pay from building where id={$_POST['buildingId']}";
// // echo $sql_pay;
// $result_pay = mysqli_query($conn, $sql_pay);
// $row_pay = mysqli_fetch_array($result_pay);
// // print_r($row_pay);
//
// $a = explode(",", $_POST['allArray']);
// // print_r($a);
//
// for ($i=0; $i < count($a)/12; $i++) {
//   $contractRow[$i]=[];
// } //$contractRow 라는 배열을 만듦
//
// for ($i=0; $i < count($a); $i++) {
//   if($i < 12){
//     array_push($contractRow[0], $a[$i]);
//   } else {
//     array_push($contractRow[floor($i/12)], $a[$i]);
//   }
// }
//
// for ($i=0; $i < count($contractRow); $i++) {
//   $contractRow[$i][2] = substr($contractRow[$i][2], -9);
// }
//
// // print_r($contractRow);
//
// for ($i=0; $i < count($contractRow); $i++) {
//   $sql = "
//       INSERT INTO realContract (
//         customer_id, building_id, group_in_building_id, r_g_in_building_id,
//         payOrder, monthCount, startDate, endDate, contractDate,
//         mAmount, mvAmount, mtAmount,
//         user_id, createTime, createPerson)
//       VALUES (
//           {$contractRow[$i][2]},
//           {$_POST['buildingId']},
//           {$_POST['groupId']},
//           {$contractRow[$i][1]},
//           '{$row_pay[0]}',
//           {$contractRow[$i][7]},
//           '{$contractRow[$i][8]}',
//           '{$contractRow[$i][9]}',
//           '{$contractRow[$i][3]}',
//           '{$contractRow[$i][4]}',
//           '{$contractRow[$i][5]}',
//           '{$contractRow[$i][6]}',
//           {$_SESSION['id']},
//           now(),
//           {$_SESSION['id']}
//           )
//   ";
//   // echo $sql;
//
//   $result = mysqli_query($conn, $sql);
//   if(!$result){
//     // echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
//     //       </script>";
//     echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(3).');
//           location.href = 'contractAll.php';
//           </script>";
//     error_log(mysqli_error($conn));
//     exit();
//   }
//
//   $id = mysqli_insert_id($conn); //방금넣은 계약번호아이디를 가져오는거
//
//   $mStartDate = $contractRow[$i][8]; //초기시작일 가져오기
//
//   for ($j=1; $j <= (int)$contractRow[$i][7]; $j++) {
//       $contractRow[$i][12][$j] = array();
//
//       $mEndDate = date("Y-m-d", strtotime($mStartDate."+1 month"."-1 day"));
//
//       if($row_pay[0]==='선불'){
//         $mExpectedDate = $mStartDate;
//       } else if($row_pay[0]==='후불'){
//         $mExpectedDate = $mEndDate;
//       }
//
//       array_push($contractRow[$i][12][$j], $j, $mStartDate, $mEndDate, $contractRow[$i][4], $contractRow[$i][5], $contractRow[$i][6], $mExpectedDate, $id);
//       $mStartDate = date("Y-m-d", strtotime($mEndDate."+1 day"));
//   }
//
//   $sql_deposit = "
//           INSERT INTO realContract_deposit
//             (inDate, inMoney, remainMoney, saved, realContract_id)
//           VALUES (
//             '{$contractRow[$i][11]}',
//             '{$contractRow[$i][10]}',
//             '{$contractRow[$i][10]}',
//             now(),
//             $id
//           )
//   ";
//   // echo $sql_deposit;
//   $result_deposit = mysqli_query($conn, $sql_deposit);
//
//   if($result_deposit===false){
//     // echo "<script>alert('보증금 저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(1).');
//     //       </script>";
//     echo "<script>alert('보증금 저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(1).');
//           location.href = 'contractAll.php';
//           </script>";
//     error_log(mysqli_error($conn));
//     exit();
//   }
// }
//
//
// // print_r($contractRow);
//
// for ($i=0; $i < count($contractRow); $i++) {
//   for ($j=1; $j <= $contractRow[$i][7]; $j++) {
//     $sql2 = "
//             INSERT INTO contractSchedule (
//               ordered, mStartDate, mEndDate, mMamount, mVmAmount, mTmAmount,
//               mExpectedDate, realContract_id)
//             VALUES (
//               {$contractRow[$i][12][$j][0]},
//               '{$contractRow[$i][12][$j][1]}',
//               '{$contractRow[$i][12][$j][2]}',
//               '{$contractRow[$i][12][$j][3]}',
//               '{$contractRow[$i][12][$j][4]}',
//               '{$contractRow[$i][12][$j][5]}',
//               '{$contractRow[$i][12][$j][6]}',
//               {$contractRow[$i][12][$j][7]}
//             )
//       ";
//     // echo $sql2;
//
//     $result2 = mysqli_query($conn, $sql2);
//
//     if($result2===false){
//       echo "<script>alert('저장과정에 문제가 생겼습니다. 관리자에게 문의하세요(2).');
//             location.href = 'contractAll.php';
//             </script>";
//       error_log(mysqli_error($conn));
//       exit();
//     }
//   }
// }//for count($contractRow) closing
//
// echo "<script>alert('계약들을 저장하였습니다.');
//       location.href = 'contract.php';
//       </script>";

 ?>
