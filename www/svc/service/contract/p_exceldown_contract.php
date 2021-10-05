<?php
// include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";
include 'ajax_realContractSql.php';

// echo $sql_before;

$result_before = mysqli_query($conn, $sql_before);

$allRows = array();
while($row_before = mysqli_fetch_array($result_before)){
  $allRows[] = $row_before;
}

for ($i=0; $i < count($allRows); $i++){
  $sql3 = "select remainMoney from realContract_deposit where realContract_id={$allRows[$i]['rid']}";
  $result3 = mysqli_query($conn, $sql3);
  $row3 = mysqli_fetch_array($result3);

  $allRows[$i]['remainMoney'] = $row3[0];

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
    $allRows[$i]['companyname2'] = $allRows[$i]['ccomname'];
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['companyname2'] = $allRows[$i]['cdiv3'].$allRows[$i]['ccomname'];
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['companyname2'] = $allRows[$i]['cname'];
  }

  $allRows[$i]['contact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];

  $allRows[$i]['companynumber'] = $allRows[$i]['cNumber1'].'-'.$allRows[$i]['cNumber2'].'-'.$allRows[$i]['cNumber3'];
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>임대계약목록 엑셀양식</title>
  </head>
  <body>

  </body>
</html>
<style type="text/css">
.coltype1{background:yellow}
.coltype2{background:yellowgreen}
.coltype3{background:pink}
</style>

<table border="1">
  <thead>
    <tr>
      <td colspan="18"><h1>전체선택하여 엑셀시트에 복사하세요.</h1></td>
    </tr>
    <tr>
      <th rowspan="2" class="coltype1">순번</th>
      <th rowspan="2" class="coltype1">상태</th>
      <th rowspan="2" class="coltype1">물건명</th>
      <th rowspan="2" class="coltype1">그룹명</th>
      <th rowspan="2" class="coltype1">관리번호</th>
      <th colspan="4" class="coltype3">입주자정보</th>
      <th rowspan="2" class="coltype2">계약번호</th>
      <th rowspan="2" class="coltype2">계약일</th>
      <th rowspan="2" class="coltype2">계약시작일</th>
      <th rowspan="2" class="coltype2">계약종료일</th>
      <th rowspan="2" class="coltype2">계약개월</th>
      <th colspan="3" class="coltype2">월이용료</th>
      <th rowspan="2" class="coltype2">보증금</th>
    </tr>
    <tr>
      <th class="coltype3">성명(대표자명)</th>
      <th class="coltype3">사업자명</th>
      <th class="coltype3">사업자번호</th>
      <th class="coltype3">연락처</th>
      <th class="coltype2">공급가액</th>
      <th class="coltype2">세액</th>
      <th class="coltype2">합계</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $num = count($allRows);
      for ($i=0; $i < count($allRows); $i++) {
        ?>
      <tr>
        <td><?=$num?></td><!--순번-->
        <td>
          <?php
          if($allRows[$i]['status2']==='present'){
            echo "현재";
          } elseif ($allRows[$i]['status2']==='the_end') {
            echo "종료";
          } elseif ($allRows[$i]['status2']==='waiting') {
            echo "대기";
          } elseif ($allRows[$i]['status2']==='middle_end') {
            echo "중간종료";
          }
           ?>
        </td><!--상태-->
        <td><?=$allRows[$i]['bName']?></td><!--물건명-->
        <td><?=$allRows[$i]['gName']?></td><!--그룹명-->
        <td><?=$allRows[$i]['rName']?></td><!--관리번호-->
        <td><?=$allRows[$i]['cname']?></td><!--대표자명-->
        <td><?=$allRows[$i]['companyname2']?></td><!--사업자명-->
        <td><?=$allRows[$i]['companynumber']?></td><!--사업자번호-->
        <td><?=$allRows[$i]['contact']?></td><!--연락처-->
        <td>
          <?=(int)$allRows[$i]['rid']?>
        </td><!--계약번호-->
        <td><?=$allRows[$i]['contractDate']?></td><!--계약일-->
        <td><?=$allRows[$i]['startDate']?></td><!--계약시작일-->
        <td><?=$allRows[$i]['endDate2']?></td><!--계약종료일-->
        <td><?=$allRows[$i]['count2']?></td><!--계약개월-->
        <td><?=$allRows[$i]['mAmount']?></td><!--월이용료(부가세별도)-->
        <td><?=$allRows[$i]['mvAmount']?></td><!--부가세-->
        <td><?=$allRows[$i]['mtAmount']?></td><!--월이용료(부가세포함)-->
        <td><?=$allRows[$i]['remainMoney']?></td><!--보증금-->
      </tr>
      <?php
      $num -= 1;
     }
     ?>
  </tbody>
</table>
