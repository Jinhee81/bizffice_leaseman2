<!-- 이거는 지출입력화면에서의 ajax파일, 고정비입력화면에서의 ajax파일과 혼동하지 말것 -->
<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// echo $_POST;
// print_r($_POST);

$fromDate = $_POST['year'] . '-' . $_POST['month'] . '-01';
$endDate = date('t', strtotime($fromDate));
$toDate = $_POST['year'] . '-' . $_POST['month'] . '-' . $endDate;

$sql = "
  select
        @num := @num + 1 as num,
        id,
        title,
        amount1, amount2, amount3,
        payDate,
        taxDate,
        etc
  from
        (select @num :=0)a, costlist
  where user_id = {$_SESSION['id']} and
        building_id = {$_POST['buildingIdx']} and
        fixflexdiv = 'flex' and
        DATE(payDate) BETWEEN '{$fromDate}' and '{$toDate}'
  order by
      id asc
  ";

// echo $sql;

$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

// print_r($allRows);
$amountTotalArray = array(0,0,0);

for ($i=0; $i < count($allRows); $i++) {
  $amountTotalArray[0] += str_replace(",", "", $allRows[$i]['amount1']);
  $amountTotalArray[1] += str_replace(",", "", $allRows[$i]['amount2']);
  $amountTotalArray[2] += str_replace(",", "", $allRows[$i]['amount3']);
}

$amountTotalArray[0] = number_format($amountTotalArray[0]);
$amountTotalArray[1] = number_format($amountTotalArray[1]);
$amountTotalArray[2] = number_format($amountTotalArray[2]);
?>

<table class="table table-hover text-center mt-2 table-sm" id="flexcostTable">
  <thead>
    <tr class="table-info">
      <th width="5%" class="">순번</th>
      <th width="10%" class="">내역</th>
      <th width="10%" class="">금액</th>
      <th width="10%" class="mobile">공급가액</th>
      <th width="10%" class="mobile">세액</th>
      <th width="10%" class="">지출일자</th>
      <th width="10%" class="mobile">증빙일자</th>
      <th width="10%" class="mobile">특이사항</th>
      <th width="5%" class=""></th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(count($allRows)===0){
      echo "<tr><td colspan='9'>입력값이 없습니다.</td><tr>";
    } else {
      for ($i=0; $i < count($allRows); $i++) {?>
        <tr>
          <td>
            <?=$allRows[$i]['num']?>
            <input type="hidden" name="id" value="<?=$allRows[$i]['id']?>">
            <input type="hidden" name="editable" value="<?=$allRows[$i]['editable']?>">
          </td><!--순번-->
          <td>
            <input type="text" class="form-control form-control-sm text-center" value="<?=$allRows[$i]['title']?>">
          </td><!--내역-->
          <td>
            <input type="text" class="form-control form-control-sm text-right amountNumber numberComma" value="<?=$allRows[$i]['amount1']?>">
          </td><!--금액-->
          <td>
            <input type="text"  class="form-control form-control-sm text-right amountNumber numberComma" value="<?=$allRows[$i]['amount2']?>">
          </td><!--공급가액-->
          <td>
            <input type="text"  class="form-control form-control-sm text-right amountNumber numberComma" value="<?=$allRows[$i]['amount3']?>">
          </td><!--세액-->
          <td class="mobile">
            <input type="text"  class="form-control form-control-sm dateType text-center" value="<?=$allRows[$i]['payDate']?>">
          </td><!--지출일자-->
          <td class="mobile">
            <input type="text"  class="form-control form-control-sm dateType text-center" value="<?=$allRows[$i]['taxDate']?>">
          </td><!--증빙일자-->
          <td class="mobile">
            <input type="text"  class="form-control form-control-sm text-center" value="<?=$allRows[$i]['etc']?>">
          </td><!--특이사항-->
          <td>
            <button type="submit" name="delete" class="btn btn-default grey">
              <i class='far fa-trash-alt'></i>
            </button>
          </td><!--관리-->
        </tr>
      <?php } ?>
      <tr style="background-color:#D8D8D8;">
        <td colspan="2">
          <p class="font-italic mb-1">소계</p>
        </td>
        <td>
          <p class="text-right font-italic mb-1">
            <?=$amountTotalArray[0]?>
          </p>
        </td>
        <td>
          <p class="text-right font-italic mb-1">
            <?=$amountTotalArray[1]?>
          </p>
        </td>
        <td>
          <p class="text-right font-italic mb-1">
            <?=$amountTotalArray[2]?>
          </p>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php }?>
  </tbody>
</table>

<script type="text/javascript">
$('.dateType').datepicker({
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
  currentText: '오늘',
  closeText: '닫기'
});

$(".amountNumber").click(function(){
  $(this).select();
});

$(".amountNumber").number(true);

$('button[name="delete"]').on('click', function(){
  var id = $(this).parent().parent().children().children('input[name=id]').val();

  console.log(id);

  var aa = 'flexCostDelete';
  var bb = 'p_costlist_delete.php';

  var deleteCheck = confirm('정말 삭제하겠습니까?');
  if(deleteCheck){
    goCategoryPage(aa,bb,id);

    function goCategoryPage(a,b,c){
      var frm = formCreate(a, 'post', b,'');
      frm = formInput(frm, 'id', c);
      formSubmit(frm);
    }
  }
})//삭제하기버튼 클릭
</script>
