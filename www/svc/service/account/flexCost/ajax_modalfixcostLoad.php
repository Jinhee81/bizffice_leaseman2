<?php
session_start();
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
              and building_id = {$_POST['buildingIdx']}
       ";
// echo $sql;

$result = mysqli_query($conn, $sql);
$allRows = array();

while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}
?>
<table class="table table-hover text-center mt-2 table-sm" id="modalTable">
  <thead>
    <tr class="table-info">
      <th scope="col"><input type="checkbox" id="allselect"></th>
      <th scope="col">순번</th>
      <th scope="col">관리물건</th>
      <th scope="col">내역</th>
      <th scope="col">금액</th>
      <th scope="col">공급가액</th>
      <th scope="col">세액</th>
    </tr>
  </thead>
  <tbody>

<?php
// print_r($allRows);

if(count($allRows)===0){
  echo "<tr><td colspan='7'>저장된 고정비내역이 없네요. 상단의 <span class='badge badge-danger'>new 생성하기</span> 눌러서 관리물건의 고정비를 생성하세요.</td></tr>";
} else {?>
      <?php
       for($i=0; $i < count($allRows); $i++){?>
         <tr>
           <td>
             <input type="checkbox" class="tbodycheckbox" value="<?=$allRows[$i]['id']?>">
           </td>
           <td>
             <?=$allRows[$i]['num']?>
           </td>
           <td><?=$allRows[$i]['bName']?></td>
           <td><?=$allRows[$i]['title']?></td>
           <td><?=$allRows[$i]['amount1']?></td>
           <td><?=$allRows[$i]['amount2']?></td>
           <td><?=$allRows[$i]['amount3']?></td>
         </tr>
       <?php } ?> <!--이거가 for문닫는 대괄호-->
     </tbody>
   </table>

 <?php } //이거가 else 닫는 대괄호

?>


<script>

var table1 = $("#modalTable");

$("#allselect").change(function(){
  if($(this).is(":checked")){
    $(".tbodycheckbox").prop('checked',true);
    $(".tbodycheckbox").parent().parent().addClass("selected");
    // console.log('맨위체크박스 체크함');
  } else {
    $(".tbodycheckbox").prop('checked',false);
    $(".tbodycheckbox").parent().parent().removeClass("selected");
    // console.log('맨위체크박스 체크취소');
  }

})

$(document).on('change', '.tbodycheckbox', function(){
  var allCnt = $(".tbodycheckbox").length;
  var checkedCnt = $(".tbodycheckbox").filter(":checked").length;

  // console.log(allCnt, checkedCnt);

  if($(this).is(":checked")){
    $(this).prop('checked',true);
    $(this).parent().parent().addClass("selected");
  } else {
    $(this).prop('checked',false);
    $(this).parent().parent().removeClass("selected");
  }

  if( allCnt==checkedCnt ){
    $("#allselect").prop("checked", true);
  } else {
    $("#allselect").prop("checked", false);
  }
})



</script>
