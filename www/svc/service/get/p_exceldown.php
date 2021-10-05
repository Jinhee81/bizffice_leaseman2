<?php
//2021.7.15 update, 이유는 물건전체가 반영이 안되어서 에러났던것 고쳤다...

header("Content-Type: text/html; charset=utf-8");
session_start();

include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
// header("Content-type: application/vnd.ms-excel; charset=UTF-8");
// Header("Content-type: charset=utf-8");
// header("Content-Disposition: attachment; filename=ctr_deposit.xls");
// Header("Content-Description: PHP3 Generated Data");
// Header("Pragma: no-cache");
// Header("Expires: 0");

// print_r($_POST);
parse_str($_POST['formArray'], $a);

// print_r($a);

if($a['dateDiv']==='executiveDate') $dateDiv = 'paySchedule2.executiveDate';
else if($a['dateDiv']==='taxDate') $dateDiv = 'taxDate';


$etcDate = "";

if($a['fromDate'] && $a['toDate']){
  $etcDate = " and (DATE($dateDiv) BETWEEN '{$a['fromDate']}' and '{$a['toDate']}')";
} elseif($a['fromDate']){
  $etcDate = " and (DATE($dateDiv) >= '{$a['fromDate']}')";
} elseif($a['toDate']){
  $etcDate = " and (DATE($dateDiv) <= '{$a['toDate']}')";
}

$taxCondi = "";
if($a['taxDiv']==='alltax'){
  $taxCondi = "";
} elseif ($a['taxDiv']==='taxYes') {
  $taxCondi = " and (paySchedule2.pvAmount > 0)";
} elseif ($a['taxDiv']==='taxNone') {
  $taxCondi = " and (paySchedule2.pvAmount = 0)";
}

$payCondi = "";
if($a['payKind']==='payall'){
  $payCondi = "";
} elseif ($a['payKind']==='계좌') {
  $payCondi = " and (paySchedule2.payKind='계좌')";
} elseif ($a['payKind']==='현금') {
  $payCondi = " and (paySchedule2.payKind='현금')";
} elseif ($a['payKind']==='카드') {
  $payCondi = " and (paySchedule2.payKind='카드')";
}

if($a['building']==='buildingAll') {
  $rbuildingCondi = "";
  $gbuildingCondi = "";
} else {
  $rbuildingCondi = "realContract.building_id = {$a['building']} and";
  $gbuildingCondi = "etcContract.building_id = {$a['building']} and";
}



$etcCondi1 = "";//방계약에서만 사용하는 조건문
$etcCondi2 = "";//기타계약에서만 사용하는 조건문, 둘다사용하는이유가 그래야지 union이안됨

if($a['cText']){
  if($a['etcCondi']==='customer'){
    $etcCondi1 = " and (customer.name like '%".$a['cText']."%' or customer.companyname like '%".$a['cText']."%')";
    $etcCondi2 = " and (customer.name like '%".$a['cText']."%' or customer.companyname like '%".$a['cText']."%')";
  } elseif($a['etcCondi']==='contact'){
    $etcCondi1 = " and (customer.contact1 like '%".$a['cText']."%' or customer.contact2 like '%".$a['cText']."%' or customer.contact3 like '%".$a['cText']."%')";

    $etcCondi2 = " and (customer.contact1 like '%".$a['cText']."%' or customer.contact2 like '%".$a['cText']."%' or customer.contact3 like '%".$a['cText']."%')";

  } elseif($a['etcCondi']==='gName'){
    $etcCondi1 = " and group_in_building.gName like '%".$a['cText']."%'";
    $etcCondi2 = " and good_in_building.name like '%".$a['cText']."%'";
  } elseif($a['etcCondi']==='rName'){
    $etcCondi1 = " and r_g_in_building.rName like '%".$a['cText']."%'";
    $etcCondi2 = " and good_in_building.name like '%".$a['cText']."%'";
  } elseif($a['etcCondi']==='goodName'){
    $etcCondi1 = " and group_in_building.gName like '%".$a['cText']."%'";
    $etcCondi2 = " and good_in_building.name like '%".$a['cText']."%'";
  }
}


$sql = "
(select
    @roomdiv as roomdiv,
    paySchedule2.realContract_id as rid,
    realContract.building_id as rbid,
    building.bName as buildingname,
    realContract.group_in_building_id as gid,
    group_in_building.gName as groupname,
    realContract.r_g_in_building_id as roomid,
    r_g_in_building.rName as roomname,
    realContract.customer_id,
    customer.div2,
    customer.name,
    customer.contact1,
    customer.contact2,
    customer.contact3,
    customer.email,
    customer.div3,
    customer.companyname,
    customer.cNumber1,
    customer.cNumber2,
    customer.cNumber3,
    customer.gender,
    customer.birthday,
    realContract.startDate,
    realContract.endDate2,
    realContract.count2,
    idpaySchedule2,
    paySchedule2.monthCount,
    paySchedule2.pStartDate,
    paySchedule2.pEndDate,
    paySchedule2.pAmount,
    paySchedule2.pvAmount,
    paySchedule2.ptAmount,
    paySchedule2.pExpectedDate,
    paySchedule2.payKind,
    paySchedule2.executiveDate,
    paySchedule2.getAmount,
    paySchedule2.taxSelect,
    paySchedule2.taxDate,
    paySchedule2.invoicerMgtKey as mun
from
    (select @roomdiv:='room')a,
    paySchedule2
join realContract
    on paySchedule2.realContract_id = realContract.id
join customer
    on realContract.customer_id = customer.id
join building
    on realContract.building_id = building.id
join group_in_building
    on realContract.group_in_building_id = group_in_building.id
join r_g_in_building
    on realContract.r_g_in_building_id = r_g_in_building.id
where paySchedule2.user_id={$_SESSION['id']} and
      $rbuildingCondi
      paySchedule2.executiveDate is not null
      $etcDate $taxCondi $payCondi $etcCondi1)
union
(select
    @gooddiv as gooddiv,
    paySchedule2.etcContract_id as eid,
    etcContract.building_id as ebid,
    building.bName as buildingname,
    etcContract.good_in_building_id as goodid,
    good_in_building.name as goodname2,
    etcContract.good_in_building_id as goodid,
    good_in_building.name as goodname2,
    etcContract.customer_id,
    customer.div2,
    customer.name,
    customer.contact1,
    customer.contact2,
    customer.contact3,
    customer.email,
    customer.div3,
    customer.companyname,
    customer.cNumber1,
    customer.cNumber2,
    customer.cNumber3,
    customer.gender,
    customer.birthday,
    etcContract.startTime,
    etcContract.endTime,
    etcContract.endTime,
    idpaySchedule2,
    paySchedule2.monthCount,
    paySchedule2.pStartDate,
    paySchedule2.pEndDate,
    paySchedule2.pAmount,
    paySchedule2.pvAmount,
    paySchedule2.ptAmount,
    paySchedule2.pExpectedDate,
    paySchedule2.payKind,
    paySchedule2.executiveDate,
    paySchedule2.getAmount,
    paySchedule2.taxSelect,
    paySchedule2.taxDate,
    paySchedule2.invoicerMgtKey as mun
from
    (select @gooddiv:='good')a,
    paySchedule2
join etcContract
    on paySchedule2.etcContract_id = etcContract.id
join customer
    on etcContract.customer_id = customer.id
join building
    on etcContract.building_id = building.id
join good_in_building
    on etcContract.good_in_building_id = good_in_building.id
where paySchedule2.user_id={$_SESSION['id']} and
      $gbuildingCondi
      paySchedule2.executiveDate is not null
      $etcDate $taxCondi $payCondi $etcCondi2)
order by date_format(executiveDate, '%Y-%m-%d') desc
";

// echo $sql;

$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

for ($i=0; $i < count($allRows); $i++) {
  if($allRows[$i]['roomdiv'] === 'room'){
    $sql2 = "select contractDate, mAmount from realContract where id={$allRows[$i]['rid']}";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    $allRows[$i]['contractDate'] = $row2['contractDate'];
    $allRows[$i]['mAmount'] = $row2['mAmount'];

    $sql3 = "select remainMoney from realContract_deposit where realContract_id={$allRows[$i]['rid']}";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_array($result3);

    $allRows[$i]['remainMoney'] = $row3[0];

    $executiveDate = strtotime($allRows[$i]['executiveDate']);
    $expectedDate = strtotime($allRows[$i]['pExpectedDate']);

    if($expectedDate >= $executiveDate){
      $allRows[$i]['a'] = '완납';
    } else {
      $allRows[$i]['a'] = '완납(연체)';
    }
  }

  if($allRows[$i]['roomdiv'] != 'room'){
    $allRows[$i]['startDate'] = '-';
    $allRows[$i]['endDate2'] = '-';
    $allRows[$i]['count2'] = '-';
    $allRows[$i]['contractDate'] = '-';
    $allRows[$i]['remainMoney'] = '0';
    $allRows[$i]['mAmount'] = '0';
    $allRows[$i]['pStartDate'] = '-';
    $allRows[$i]['pEndDate'] = '-';
    $allRows[$i]['monthCount'] = '-';
    $allRows[$i]['a'] = '완납';
  }

  if($allRows[$i]['div3']==='주식회사'){
    $allRows[$i]['cdiv3'] = '(주)';
  } elseif($allRows[$i]['div3']==='유한회사'){
    $allRows[$i]['cdiv3'] = '(유)';
  } elseif($allRows[$i]['div3']==='합자회사'){
    $allRows[$i]['cdiv3'] = '(합)';
  } elseif($allRows[$i]['div3']==='기타'){
    $allRows[$i]['cdiv3'] = '(기타)';
  }

  $allRows[$i]['companynumber'] = $allRows[$i]['cNumber1'].'-'.$allRows[$i]['cNumber2'].'-'.$allRows[$i]['cNumber3'];

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['companyname2'] = $allRows[$i]['companyname'];
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['companyname2'] = $allRows[$i]['cdiv3'].$allRows[$i]['companyname'];
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['companyname2'] = $allRows[$i]['name'];
  }

  if($allRows[$i]['mun']){
    $allRows[$i]['api']='o';
  } else {
    $allRows[$i]['api']='';
  }


  $allRows[$i]['contact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];

} //for문closing
 ?>

<style type="text/css">
.coltype1 {
    background: yellow
}

.coltype2 {
    background: yellowgreen
}

.coltype3 {
    background: pink
}
</style>

<table border="1">
    <thead>
        <tr>
            <td colspan="28">
                <h1>전체선택하여 엑셀시트에 복사하세요.</h1>
            </td>
        </tr>
        <tr>
            <th class="coltype1">순번</th>
            <th class="coltype2">계약일</th>
            <th class="coltype2">계약번호</th>
            <th class="coltype2">보증금</th>
            <th class="coltype2">계약시작일</th>
            <th class="coltype2">계약종료일</th>
            <th class="coltype2">계약개월</th>
            <th class="coltype2">월이용료(부가세별도)</th>
            <th class="coltype1">청구번호</th>
            <th class="coltype1">입금일</th>
            <th class="coltype1">청구시작일</th>
            <th class="coltype1">청구종료일</th>
            <th class="coltype1">청구개월</th>
            <th class="coltype1">공급가액</th>
            <th class="coltype1">세액</th>
            <th class="coltype1">입금액</th>
            <th class="coltype1">입금구분</th>
            <th class="coltype1">수납구분</th>
            <th class="coltype3">생년월일</th>
            <th class="coltype3">대표자명</th>
            <th class="coltype3">사업자번호</th>
            <th class="coltype3">사업자명</th>
            <th class="coltype1">그룹명</th>
            <th class="coltype1">물건명</th>
            <th class="coltype1">관리번호</th>
            <th class="coltype1">증빙구분</th>
            <th class="coltype1">증빙일자</th>
            <th class="coltype1">리스맨세금계산서여부</th>
        </tr>
    </thead>
    <tbody>
        <?php
      $num = count($allRows);
      for ($i=0; $i < count($allRows); $i++) {
        ?>
        <tr>
            <td><?=$num?></td>
            <!--순번-->
            <td><?=$allRows[$i]['contractDate']?></td>
            <!--계약일-->
            <td><?=$allRows[$i]['rid']?></td>
            <!--계약번호-->
            <td><?=$allRows[$i]['remainMoney']?></td>
            <!--보증금-->
            <td><?=$allRows[$i]['startDate']?></td>
            <!--계약시작일-->
            <td><?=$allRows[$i]['endDate2']?></td>
            <!--계약종료일-->
            <td><?=$allRows[$i]['count2']?></td>
            <!--계약개월-->
            <td><?=$allRows[$i]['mAmount']?></td>
            <!--월이용료(부가세별도)-->
            <td><?=$allRows[$i]['idpaySchedule2']?></td>
            <!--청구번호-->
            <td><?=$allRows[$i]['executiveDate']?></td>
            <!--입금일-->
            <td><?=$allRows[$i]['pStartDate']?></td>
            <!--청구시작일-->
            <td><?=$allRows[$i]['pEndDate']?></td>
            <!--청구종료일-->
            <td><?=$allRows[$i]['monthCount']?></td>
            <!--청구개월-->
            <td><?=$allRows[$i]['pAmount']?></td>
            <!--공급가액-->
            <td><?=$allRows[$i]['pvAmount']?></td>
            <!--세액-->
            <td><?=$allRows[$i]['ptAmount']?></td>
            <!--입금액-->
            <td><?=$allRows[$i]['a']?></td>
            <!--입금구분-->
            <td><?=$allRows[$i]['payKind']?></td>
            <!--수납구분-->
            <td><?=$allRows[$i]['birthday']?></td>
            <!--생년월일-->
            <td><?=$allRows[$i]['name']?></td>
            <!--입주자-->
            <td><?=$allRows[$i]['companynumber']?></td>
            <!--사업자번호-->
            <td><?=$allRows[$i]['companyname2']?></td>
            <!--사업자명-->
            <td><?=$allRows[$i]['groupname']?></td>
            <!--상품-->
            <td><?=$allRows[$i]['buildingname']?></td>
            <!--관리물건-->
            <td><?=$allRows[$i]['roomname']?></td>
            <!--방번호-->
            <td><?=$allRows[$i]['taxSelect']?></td>
            <!--증빙구분-->
            <td><?=$allRows[$i]['taxDate']?></td>
            <!--증빙일부-->
            <td><?=$allRows[$i]['api']?></td>
            <!--api여부-->
        </tr>
        <?php
      $num -= 1;
     }
     ?>
    </tbody>
</table>