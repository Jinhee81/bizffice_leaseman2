<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// echo $_POST;
// print_r($_POST);

$sql = "
        select
          @num := @num + 1 as num,
          fixcost.id,
          building_id,
          bName,
          title,
          amount1, amount2, amount3,
          vat
        from
          (select @num:=0)a,
          fixcost
        join building
          on fixcost.building_id = building.id
        where fixcost.user_id={$_SESSION['id']}
              and building_id = {$_POST['building']}
       ";
// echo $sql;

$result = mysqli_query($conn, $sql);
$allRows = array();

while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

// print_r($allRows);

$amountTotalArray = [0,0,0];

for ($i=0; $i < count($allRows); $i++) {
  $amountTotalArray[0] += str_replace(",", "", $allRows[$i]['amount1']);
  $amountTotalArray[1] += str_replace(",", "", $allRows[$i]['amount2']);
  $amountTotalArray[2] += str_replace(",", "", $allRows[$i]['amount3']);
}

$amountTotalArray[0] = number_format($amountTotalArray[0]);
$amountTotalArray[1] = number_format($amountTotalArray[1]);
$amountTotalArray[2] = number_format($amountTotalArray[2]);


if(count($allRows)===0){
  echo "조회값이 없습니다.";
} else {?>
  <table class="table table-hover text-center mt-2 table-sm" id="checkboxTestTbl">
    <thead>
      <tr class="table-info">
        <!-- <th scope="col"><input type="checkbox"></th> -->
        <th scope="col">순번</th>
        <th scope="col" class="mobile">관리물건</th>
        <th scope="col">내역</th>
        <th scope="col" class="mobile">금액</th>
        <th scope="col" class="mobile">공급가액</th>
        <th scope="col" class="">세액</th>
        <th scope="col" class="">부가세</th>
        <th scope="col" class="mobile"></th>
      </tr>
    </thead>
    <tbody>
      <?php
       for($i=0; $i < count($allRows); $i++){?>
         <tr>
           <td>
             <?=$allRows[$i]['num']?>
             <input type="hidden" value="<?=$allRows[$i]['id']?>">
           </td>
           <td><?=$allRows[$i]['bName']?></td>
           <td><?=$allRows[$i]['title']?></td>
           <td><?=$allRows[$i]['amount1']?></td>
           <td><?=$allRows[$i]['amount2']?></td>
           <td><?=$allRows[$i]['amount3']?></td>
           <td>
             <?php
             if($allRows[$i]['vat']==='vatYes'){
               echo "유";
             } else {
               echo "무";
             }
             ?>
           </td>
           <td>
             <button type="submit" name="edit" class="btn btn-default grey" data-toggle='modal' data-target='#editModal'>
               <i class='far fa-edit'></i>
             </button>
             <button type="submit" name="delete" class="btn btn-default grey">
               <i class='far fa-trash-alt'></i>
             </button>
           </td>
         </tr>
       <?php } ?> <!--이거가 for문닫는 대괄호-->
       <tr style="background-color:#D8D8D8;">
         <td colspan="3">
           <p class="font-italic mb-1">소계</p>
         </td>
         <td>
           <p class="font-italic mb-1">
             <?=$amountTotalArray[0]?>
           </p>
         </td>
         <td>
           <p class="font-italic mb-1">
             <?=$amountTotalArray[1]?>
           </p>
         </td>
         <td>
           <p class="font-italic mb-1">
             <?=$amountTotalArray[2]?>
           </p>
         </td>
         <td></td>
         <td></td>
       </tr>
     </tbody>
   </table>

 <?php } //이거가 else 닫는 대괄호
?>

<!-- Modal -->
<div class="modal fade bd-example-modal-sm" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">고정비 수정하기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="p_fixcost_edit.php">
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
          <button type="submit" class="btn btn-primary" id="modalEditBtn">수정하기</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal End-->


<script>


$('button[name="delete"]').on('click', function(){
  var id = $(this).parent().parent().children().children('input:eq(0)').val();

  console.log(id);

  var aa = 'fixcostDelete';
  var bb = 'p_fixcost_delete.php';

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



$('button[name="edit"]').on('click', function(){

  var id = $(this).parent().parent().children().children('input:eq(0)').val();

  console.log(id);

  $.ajax({
    url: 'ajax_fixcostModalEdit.php',
    method: 'post',
    data: {id : id},
    success: function(data){
      $('.modal-body').html(data);
    }
  })

  // $('#modalEditBtn').on('click', function(){
  //   var building =
  // })

})//edit icon click event===============================


</script>
