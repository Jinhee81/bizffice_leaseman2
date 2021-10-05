<?php
include 'ajax_customerLoad_sql.php';
// parse_str($_POST['formArray'], $a);
// print_r($_POST);echo "<br>";
// print_r($a);echo "<br>";
// echo $sql_before;

$result_before = mysqli_query($conn, $sql_before);

$allRows = array();
while($row_before = mysqli_fetch_array($result_before)){
  $allRows[] = $row_before;
}

for ($i=0; $i < count($allRows); $i++) {
  $allRows[$i]['contact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];

  $allRows[$i]['companynumber'] = $allRows[$i]['cNumber1'].'-'.$allRows[$i]['cNumber2'].'-'.$allRows[$i]['cNumber3'];
}

 ?>

<!-- <style type="text/css">
.coltype1{background:yellow}
.coltype2{background:yellowgreen}
.coltype3{background:pink}
</style> -->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>관계자목록 엑셀양식</title>
  </head>
  <body>
    <style type="text/css">
    .coltype1{background:yellow}
    .coltype2{background:yellowgreen}
    .coltype3{background:pink}
    </style>

    <table border="1">
      <thead>
        <tr>
          <td colspan="21"><h2>전체선택하여 엑셀시트에 복사하세요.</h2></td>
        </tr>
        <tr>
          <th rowspan="2" class="coltype1">순번</th>
          <th rowspan="2" class="coltype1">idx</th>
          <th rowspan="2" class="coltype1">소속물건</th>
          <th rowspan="2" class="coltype1">구분1</th>
          <th rowspan="2" class="coltype1">구분2</th>
          <th rowspan="2" class="coltype1">구분3</th>
          <th rowspan="2" class="coltype3">성명</th>
          <th rowspan="2" class="coltype3">연락처</th>
          <th rowspan="2" class="coltype3">이메일</th>
          <th rowspan="2" class="coltype2">사업자명</th>
          <th rowspan="2" class="coltype2">사업자번호</th>
          <th rowspan="2" class="coltype2">업태</th>
          <th rowspan="2" class="coltype2">종목</th>
          <th colspan="4" class="coltype2">주소</th>
          <th rowspan="2" class="coltype3">생년월일</th>
          <th rowspan="2" class="coltype3">특이사항/문의내용</th>
          <th rowspan="2" class="coltype2">등록일시</th>
          <th rowspan="2" class="coltype2">수정일시</th>
        </tr>
        <tr>
          <th class="coltype2">우편번호</th>
          <th class="coltype2">주소1</th>
          <th class="coltype2">주소2</th>
          <th class="coltype2">주소3</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $num = count($allRows);
          for ($i=0; $i < count($allRows); $i++) {
            ?>
          <tr>
            <td><?=$num?></td><!--순번-->
            <td><?=(int)$allRows[$i]['id']?></td><!--idx-->
            <td><?=$allRows[$i]['bName']?></td><!--소속물건-->
            <td><?=$allRows[$i]['div1']?></td><!--구분1-->
            <td><?=$allRows[$i]['div2']?></td><!--구분2-->
            <td><?=$allRows[$i]['div3']?></td><!--구분3-->
            <td><?=$allRows[$i]['name']?></td><!--성명-->
            <td><?=$allRows[$i]['contact']?></td><!--연락처-->
            <td><?=$allRows[$i]['email']?></td><!--이메일-->
            <td><?=$allRows[$i]['companyname']?></td><!--사업자명-->
            <td><?=$allRows[$i]['companynumber']?></td><!--사업자번호-->
            <td><?=$allRows[$i]['div4']?></td><!--업태-->
            <td><?=$allRows[$i]['div5']?></td><!--종목-->
            <td><?=$allRows[$i]['zipcode']?></td><!--우편번호-->
            <td><?=$allRows[$i]['add1']?></td><!--주소1-->
            <td><?=$allRows[$i]['add2']?></td><!--주소2-->
            <td><?=$allRows[$i]['add3']?></td><!--주소3-->
            <td><?=$allRows[$i]['birthday']?></td><!--생년월일-->
            <td><?=$allRows[$i]['etc']?></td><!--특이사항-->
            <td><?=$allRows[$i]['created']?></td><!--등록일시-->
            <td><?=$allRows[$i]['updated']?></td><!--수정일시-->
          </tr>
          <?php
          $num -= 1;
         }
         ?>
      </tbody>
    </table>
  </body>
</html>
