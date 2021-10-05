

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
        fixflexdiv = 'fix' and
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

<table class="table table-hover text-center mt-2 table-sm" id="fixcostTable">
  <thead>
    <tr class="table-info">
      <!-- <th scope="col"><input type="checkbox"></th> -->
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

<?php
if(count($allRows)===0){
  echo "<tr><td colspan=9>입력값이 없습니다.</td></tr>";
} else {?>
    <tbody>
      <?php
       for($i=0; $i < count($allRows); $i++){?>
         <tr>
           <td>
             <?=$allRows[$i]['num']?>
             <input type="hidden" value="<?=$allRows[$i]['id']?>">
           </td>
           <td><?=$allRows[$i]['title']?></td>
           <td><input type="text" class="form-control form-control-sm amountNumber text-right" name="amount1" value="<?=$allRows[$i]['amount1']?>"></td>
           <td><input type="text" class="form-control form-control-sm amountNumber text-right" name="amount2" value="<?=$allRows[$i]['amount2']?>"></td>
           <td><input type="text" class="form-control form-control-sm amountNumber text-right" name="amount3" value="<?=$allRows[$i]['amount3']?>"></td>
           <td><input type="text" class="form-control form-control-sm dateType text-center" name="payDate" value="<?=$allRows[$i]['payDate']?>"></td>
           <td><input type="text" class="form-control form-control-sm dateType text-center" name="taxDate" value="<?=$allRows[$i]['taxDate']?>"></td>
           <td><input type="text" class="form-control form-control-sm text-center" name="etc" value="<?=$allRows[$i]['etc']?>"></td>
           <td>
             <button type="submit" name="delete" class="btn btn-default grey">
               <i class='far fa-trash-alt'></i>
             </button>
           </td>
         </tr>
       <?php } ?> <!--이거가 for문닫는 대괄호-->
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
     </tbody>
   </table>

 <?php } //이거가 else 닫는 대괄호
?>


<script>

$('.amountNumber').on('click', function(){
  $(this).select();
})

$('.amountNumber').number(true);

$('.dateType').datepicker({
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
  currentText: '오늘',
  closeText: '닫기'
});

$('button[name="delete"]').on('click', function(){
  var id = $(this).parent().parent().children().children('input:eq(0)').val();

  console.log(id);

  var aa = 'fixcostDelete';
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
})//삭제하기버튼 클릭=================================

</script>
