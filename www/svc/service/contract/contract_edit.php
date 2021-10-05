<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "building.php";

// print_r($_SESSION);
// print_r($_GET['id']);
$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//계약번호
settype($filtered_id, 'integer');

$sql_a = "select customer_id from realContract where id={$filtered_id}";
$result_a = mysqli_query($conn, $sql_a);
$row_a = mysqli_fetch_array($result_a);

$sql_c = "
          select
              customer.id as cid,
              customer.name,
              customer.div2,
              customer.div3,
              customer.companyname as comname,
              customer.contact1 as c1,
              customer.contact2 as c2,
              customer.contact3 as c3,
              customer.cNumber1 as companyn1,
              customer.cNumber2 as companyn2,
              customer.cNumber3 as companyn3,
              building.id as bid,
              building.bName,
              building.pay
            from customer
            left join building
                on customer.building_id = building.id
            where customer.id={$row_a[0]}
    ";
// echo $sql_c;
$result_c = mysqli_query($conn, $sql_c);
$row_c = mysqli_fetch_array($result_c);

$clist['id'] = htmlspecialchars($row_c['cid']);
$clist['div2'] = htmlspecialchars($row_c['div2']);
$clist['contact1'] = htmlspecialchars($row_c['c1']);
$clist['contact2'] = htmlspecialchars($row_c['c2']);
$clist['contact3'] = htmlspecialchars($row_c['c3']);
$clist['name'] = htmlspecialchars($row_c['name']);
$clist['companyname'] = htmlspecialchars($row_c['comname']);
$clist['cNumber1'] = htmlspecialchars($row_c['companyn1']);
$clist['cNumber2'] = htmlspecialchars($row_c['companyn2']);
$clist['cNumber3'] = htmlspecialchars($row_c['companyn3']);

// print_r($clist);

$cNumber = $clist['cNumber1'].'-'.$clist['cNumber2'].'-'.$clist['cNumber3'];
$cContact = $clist['contact1'].'-'.$clist['contact2'].'-'.$clist['contact3'];

if($row_c['div3']==='주식회사'){
  $cDiv3 = '(주)';
} elseif($row_c['div3']==='유한회사'){
  $cDiv3 = '(유)';
} elseif($row_c['div3']==='합자회사'){
  $cDiv3 = '(합)';
} elseif($row_c['div3']==='기타'){
  $cDiv3 = '(기타)';
}

if($clist['div2']==='개인사업자'){
  $cName = $clist['name'].'('.$clist['companyname'].','.$cNumber.')';
} else if($clist['div2']==='법인사업자'){
  $cName = $cDiv3.$clist['companyname'].'('.$clist['name'].','.$cNumber.')';
} else if($clist['div2']==='개인'){
  $cName = $clist['name'];
}

$output = $cName.' | '.$cContact.' | '.$clist['id'];

$sql_main = "select * from realContract where id={$filtered_id}";
$result_main = mysqli_query($conn, $sql_main);
$row_main = mysqli_fetch_array($result_main);

// print_r($row_main);

$currentDate = date('Y-m-d');
// echo $currentDate;
if($currentDate >= date('Y-m-d', strtotime($row_main['startDate'])) && $currentDate <= date('Y-m-d', strtotime($row_main['endDate2']))){
  $status = '현재';
} elseif ($currentDate < date('Y-m-d', strtotime($row_main['startDate']))) {
  $status = '대기';
} elseif ($currentDate > date('Y-m-d', strtotime($row_main['endDate2']))) {
  $status = '종료';
}

$sql_step = "select count(*) from paySchedule2 where realContract_id={$filtered_id}";
$result_step = mysqli_query($conn, $sql_step);
$row_step = mysqli_fetch_array($result_step);

if((int)$row_step[0]===0){
  $step = "clear";
} else {
  $sql_step2 = "select getAmount from paySchedule2 where realContract_id={$filtered_id}";
  // echo $sql_step2;
  $result_step2 = mysqli_query($conn, $sql_step2);
  $getAmount = 0;
  while($row_step2 = mysqli_fetch_array($result_step2)){
    $getAmount = $getAmount + (int)$row_step2[0];
  }

  if($getAmount > 0) {
    $step = "입금";
  } else {
    $step = "청구";
  }
}
?>


<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">임대계약 수정 화면입니다!</h3>
    <p class="lead">단계가 청구 또는 입금 상태이면 월세정보 수정이 불가합니다. 청구스케쥴의 청구번호를 제거하면 월세정보 수정이 가능합니다.^^</p>

    <hr class="my-4">
    <span>
      <?php if($status==="현재"){
      echo '<div class="badge badge-info text-wrap mr-1" style="width: 3rem;">현재</div>';
    } elseif($status==="대기"){
      echo '<div class="badge badge-warning text-wrap mr-1" style="width: 3rem;">대기</div>';
    } elseif($status==="종료"){
      echo '<div class="badge badge-danger text-wrap mr-1" style="width: 3rem;">종료</div>';
    }

    if($step === "clear"){
      echo "<div class='badge badge-warning text-light' style='width: 3rem;'>clear</div>";
    } elseif($step === "청구"){
      echo "<div class='badge badge-warning text-primary' style='width: 3rem;'>청구</div>";
    } elseif($step === "입금"){
      echo "<div class='badge badge-warning text-info' style='width: 3rem;'>입금</div>";
    } ?>
  </span>
  </div>
</section>

<section class="container">
  <form method="post" action="p_realContract_edit.php">
    <div class="form-row">
        <div class="form-group col-md-2">
              <label><b>[입주자정보]</b></label>
        </div>
        <div class="form-group col-md-10 inputWithIcon">
              <input type="text" class="form-control" name="customer" id="customer" value="<?=$output?>" disabled>
              <input type="hidden" name="customer2" value="<?=$clist['id']?>">
              <input type="hidden" name="contract" value="<?=$filtered_id?>">
              <input type="hidden" name="step" value="<?=$step?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label><b>[물건정보]</b></label>
        </div>
        <div class="form-group col-md-10" id="mulgunInfo">
              <div class="form-row">
                <div class="form-group col-md-2"><!--물건목록-->
                    <label>물건명</label>
                    <select name="building" class="form-control">
                      <option value="<?=$row_c['bid']?>"><?=$row_c['bName']?></option>
                    </select>
                </div>
                <div class="form-group col-md-2"><!--그룹목록-->
                    <label>그룹명</label>
                    <select name="group" class="form-control">
                       <?php
                       $sql = "select id, gName from group_in_building where building_id={$row_c['bid']}";
                       $result = mysqli_query($conn, $sql);
                       while($row = mysqli_fetch_array($result)){?>
                         <option value="<?=$row['id']?>"<?php if($row['id']===$row_main['group_in_building_id']){ echo "selected";} ?>><?=$row['gName']?></option>
                      <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-2"><!--관리번호목록-->
                    <label>관리호수</label>
                    <select name="room" class="form-control">
                      <?php
                      $sql = "select id, rName from r_g_in_building where group_in_building_id={$row_main['group_in_building_id']}";
                      $result = mysqli_query($conn, $sql);
                      while($row = mysqli_fetch_array($result)){?>
                        <option value="<?=$row['id']?>"<?php if($row['id']===$row_main['r_g_in_building_id']){ echo "selected";} ?>><?=$row['rName']?></option>
                     <?php }?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>최초 계약일자</label>
                    <input type="text" id="contractDate" class="form-control dateType yyyymmdd" name="contractDate" value="<?=$row_main['contractDate']?>">
                </div>
              </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2 mb-0">
            <label><b>[월세정보]</b></label>
        </div>
        <div class="form-group col-md-10 mb-0">
          <div class="form-row">
              <div class="form-group col-md-2 mb-0">
                    <label><span id='star' style='color:#F7BE81;'>* </span>공급가액</label>
                    <input type="text" class="form-control text-right amountNumber" name="mAmount" value="<?=$row_main['mAmount']?>" numberOnly required <?php if($step!='clear'){ echo "disabled";} ?>>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>세액</label>
                    <input type="text" class="form-control text-right amountNumber" name="mvAmount" value="<?=$row_main['mvAmount']?>" numberOnly required <?php if($step!='clear'){ echo "disabled";} ?>>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>합계</label>
                    <input type="text" class="form-control text-right amountNumber" name="mtAmount" value="<?=$row_main['mtAmount']?>" numberOnly readonly>
              </div>
              <div class="form-group col-md-1 mb-0"><!--선불,후불체크-->
                    <label>수납</label>
                    <select name="payOrder" class="form-control" <?php if($step!='clear'){ echo "disabled";} ?>>
                      <option value="선납"<?php if($row_c['pay']=='선납')echo "selected"; ?>>선납</option>
                      <option value="후납"<?php if($row_c['pay']=='후납')echo "selected"; ?>>후납</option>
                    </select>
              </div>
              <div class="form-group col-md-1 mb-0">
                    <label><span id='star' style='color:#F7BE81;'>* </span>기간</label>
                    <input type="number" class="form-control" name="monthCount" value="<?=$row_main['monthCount']?>" min="1" max="72" required <?php if($step!='clear'){ echo "disabled";} ?>>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label><span id='star' style='color:#F7BE81;'>* </span>시작일자</label>
                    <input type="text" class="form-control dateType" name="startDate" value="<?=$row_main['startDate']?>" placeholder="" required <?php if($step!='clear'){ echo "disabled";} ?>>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>종료일자</label>
                    <input type="text" id="endDate" name="endDate" class="form-control" value="<?=$row_main['endDate']?>" readonly>
              </div>
        </div>
      </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
        </div>
        <div class="form-group col-md-10">
            <small class="form-text text-muted">매월 받아야하는 임대료(월세)를 입력합니다.</small>
        </div>
    </div>

    <div class="">
      <button type='submit' id="submitbtn" class='btn btn-primary'>수정</button>
      <a href='contract.php'><button type='button' class='btn btn-secondary'><i class="fas fa-angle-double-right"></i>임대계약목록</button></a>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>

<script type="text/javascript">

  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
  var roomArray = <?php echo json_encode($roomArray); ?>;
  console.log(buildingArray);
  console.log(groupBuildingArray);
  console.log(roomArray);

  var roomoption, groupIdx, roomIdx;


  $('select[name=group]').on('change', function(event){
    groupIdx = $('select[name=group]').val();
    $('select[name=room]').empty();
    for(var key3 in roomArray[groupIdx]){
      roomoption = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
      $('select[name=room]').append(roomoption);
    }
  })

  // console.log(buildingIdx, groupIdx, roomIdx);

</script>

<script>
$('.amountNumber').on('click keyup', function(){
  $(this).select();
})

$('input[name=monthCount]').on('click', function(){
  $(this).select();
})

$("input:text[numberOnly]").number(true);



var select2option, select3option, select4option, select5option, buildingIdx, groupIdx;
var pay = ["선납", "후납"];



$('#select2').on('change', function(event){
  buildingIdx = $('#select2').val();
  $('#select3').empty();
  for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    select3option = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(select3option);
    $('#select3').append(select3option);
  }
  groupIdx = $('#select3').val();

  $('#select4').empty();
  for(var key3 in roomArray[groupIdx]){
    select4option = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
    $('#select4').append(select4option);
  }

  $('#select5').empty();
  select5option = "<option value='"+buildingArray[buildingIdx][1]+"'>"+buildingArray[buildingIdx][1]+"</option>";
  $('#select5').append(select5option);

  for (var i in pay){
    if(pay[i] != buildingArray[buildingIdx][1]){
      select5option = "<option value='"+pay[i]+"'>"+pay[i]+"</option>";
      $('#select5').append(select5option);
    }
  }
})

$('#select3').on('change', function(event){
  groupIdx = $('#select3').val();
  $('#select4').empty();
  for(var key3 in roomArray[groupIdx]){
    select4option = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
    $('#select4').append(select4option);
  }
})

// console.log(buildingIdx, groupIdx, roomIdx);

function dateFormat(x){
  var yyyy = x.getFullYear().toString();
  var mm = (x.getMonth()+1).toString();
  var dd = x.getDate().toString();

  var date = yyyy+'-'+mm+'-'+dd;
  return date;
}

$('#contractDate').on('change', function(){
  var startDate = $(this).val();
  $('input[name=startDate]').val(startDate);
  $('#depositInDate').val(startDate);

  var monthCount = Number($('input[name=monthCount]').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  var endDate = dateFormat(eDate);

  $('#endDate').val(endDate);

}) //contractDate on change closing괄호, 최초계약일자=시작일자


$('input[name=startDate]').on('change', function(event){
  var startDate = $(this).val();
  var monthCount = Number($('input[name=monthCount]').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  var endDate = dateFormat(eDate);

  $('#endDate').val(endDate);
})

$('input[name="monthCount"]').on('change', function(event){
  var startDate = $('input[name=startDate]').val();
  var monthCount = Number($('input[name=monthCount]').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  var endDate = dateFormat(eDate);

  $('#endDate').val(endDate);
})

$("input[name='mAmount']").on('keyup', function(){
  var amount1 = Number($(this).val());
  var amount2 = Number($("input[name='mvAmount']").val());
  var amount12 = amount1 + amount2;
  $("input[name='mtAmount']").val(amount12);
})

$("input[name='mvAmount']").on('keyup', function(){
  var amount1 = Number($("input[name='mAmount']").val());
  var amount2 = Number($(this).val());
  var amount12 = amount1 + amount2;
  $("input[name='mtAmount']").val(amount12);
})

$('#submitbtn').on('click', function(){
  var startDate = $('input[name=startDate]').val();
  var monthCount = Number($('input[name=monthCount]').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  var endDate = dateFormat(eDate);

  $('#endDate').val(endDate);
  $('form').submit();
})

$('.dateType').datepicker({
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
  currentText: '오늘',
  closeText: '닫기'
})

$('.yyyymmdd').keydown(function (event) {
 var key = event.charCode || event.keyCode || 0;
 $text = $(this);
 if (key !== 8 && key !== 9) {
     if ($text.val().length === 4) {
         $text.val($text.val() + '-');
     }
     if ($text.val().length === 7) {
         $text.val($text.val() + '-');
     }
 }

 return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
// Key 8번 백스페이스, Key 9번 탭, Key 46번 Delete 부터 0 ~ 9까지, Key 96 ~ 105까지 넘버패트
// 한마디로 JQuery 0 ~~~ 9 숫자 백스페이스, 탭, Delete 키 넘버패드외에는 입력못함
})

</script>

</body>
</html>
