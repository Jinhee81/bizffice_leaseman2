<!-- 관계자리스트에서 계약등록버튼누르면 계약등록하는거 -->
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>임대계약 등록</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include "building.php";
// print_r($_SESSION);
// print_r($_GET['id']);
$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//고객아이디
settype($filtered_id, 'integer');

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
            where customer.id={$filtered_id}
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

$output = $cName.' | '.$cContact;

?>

<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">임대계약을 등록하세요.(#203)</h3>
    <!-- <p class="lead">고객이란 입주한 세입자 및 문의하는 문의고객, 거래처 등을 포함합니다. 고객등록이 되어야 임대계약 등록이 가능합니다!</p> -->
    <small>(1)<span id='star' style='color:#F7BE81;'> * </span>표시는 필수 입력값입니다. (2)<b>[입주자자정보]</b>에는 입주자만 등록 가능합니다. (거래처 및 문의고객은 검색결과가 없다고 표시되니 주의하세요!) <b>[입주자정보]</b>의 제일우측 숫자는 고객번호로써 시스템데이터임을 참고하여주세요. (3)<b>[기간정보]</b>의 기간(개월수)에는 최대 72개월(6년)까지 등록 가능합니다.</small>
  </div>
</section>
<section class="container">
  <form method="post" action="p_realContract_add.php">
    <div class="form-row">
        <div class="form-group col-md-2">
              <label><b>[입주자정보]</b></label>
        </div>
        <div class="form-group col-md-10 inputWithIcon">
              <input type="text" class="form-control" name="customer" id="customer" value="<?=$output?>" disabled>
              <input type="hidden" name="customerId" value="<?=$clist['id']?>">
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
                    </select>
                </div>
                <div class="form-group col-md-2"><!--관리번호목록-->
                    <label>관리번호</label>
                    <select name="room" class="form-control">
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>최초 계약일자</label>
                    <input type="text" id="contractDate" class="form-control dateType yyyymmdd" name="contractDate" placeholder="">
                </div>
              </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2 mb-0">
            <label><b>[임대료정보]</b></label>
        </div>
        <div class="form-group col-md-10 mb-0">
          <div class="form-row">
              <div class="form-group col-md-2 mb-0">
                    <label><span id='star' style='color:#F7BE81;'>* </span>공급가액</label>
                    <input type="text" class="form-control text-right amountNumber" name="mAmount" value="0" numberOnly required>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>세액</label>
                    <input type="text" class="form-control text-right amountNumber" name="mvAmount" value="0" numberOnly required>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>합계</label>
                    <input type="text" class="form-control text-right amountNumber" name="mtAmount" placeholder="0" numberOnly readonly>
              </div>
              <div class="form-group col-md-1 mb-0"><!--선불,후불체크-->
                    <label>수납</label>
                    <select name="payOrder" class="form-control">
                      <option value="선납"<?php if($row_c['pay']=='선납')echo "selected"; ?>>선납</option>
                      <option value="후납"<?php if($row_c['pay']=='후납')echo "selected"; ?>>후납</option>
                    </select>
              </div>
              <div class="form-group col-md-1 mb-0">
                    <label><span id='star' style='color:#F7BE81;'>* </span>기간</label>
                    <input type="number" class="form-control" name="monthCount" value="12" min="1" max="72" required>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label><span id='star' style='color:#F7BE81;'>* </span>시작일자</label>
                    <input type="text" id="startDate" class="form-control dateType yyyymmdd" name="startDate" value="" placeholder="" required>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>종료일자</label>
                    <input type="text" id="endDate" class="form-control" name="endDate" placeholder="" readonly>
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
    <div class="form-row mb-2">
        <div class="form-group col-md-2 mb-0">
            <label><b>[1회차 입금]</b></label>
        </div>
        <div class="form-group col-md-10 mb-0">
          <div class="form-row">
              <div class="form-group col-md-2 mb-0">
                    <label>입금개월</label>
                    <input type="text" class="form-control text-center" name="executiveCount" value="1" numberOnly>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>입금액</label>
                    <input type="text" class="form-control text-right amountNumber" name="executiveAmount" numberOnly readonly>
              </div>
              <div class="form-group col-md-2 mb-0">
                    <label>입금일</label>
                    <input type="text" class="form-control text-center dateType" name="executiveDate">
              </div>
              <div class="form-group col-md-1 mb-0">
                    <label>입금구분</label>
                    <select name="payKind" class="form-control">
                      <option value="계좌">계좌</option>
                      <option value="현금">현금</option>
                      <option value="카드">카드</option>
                    </select>
              </div>
        </div>
        <div class="">
          <small class="form-text text-muted">입금일을 넣으면 1회차 입금처리가 됩니다.</small>
        </div>
      </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2 mb-0">
          <label><b>[보증금정보]</b></label>
        </div>
        <div class="form-group col-md-10 mb-0">
            <div class="form-row">
                <div class="form-group col-md-3 mb-0">
                    <label>금액</label>
                    <input type="text" class="form-control text-right amountNumber" name="depositInAmount" value="0" placeholder="0" numberOnly>
                </div>
                <div class="form-group col-md-3 mb-0">
                    <label>입금일자</label>
                    <input type="text" class="form-control dateType yyyymmdd" name="depositInDate" id="depositInDate" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
        </div>
        <div class="form-group col-md-10">
            <small class="form-text text-muted">보증금을 받았다면, 보증금과 날짜를 입력하세요.</small>
        </div>
    </div>
    <div class="">
      <button type='button' class='btn btn-primary' id='frmSubmit'>저장</button>
      <a href='contract.php'><button type='button' class='btn btn-secondary'><i class="fas fa-angle-double-right"></i> 계약목록</button></a>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>

<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
  var roomArray = <?php echo json_encode($roomArray); ?>;
  console.log(buildingArray);
  console.log(groupBuildingArray);
  console.log(roomArray);

  //이거는 계약등록하는 화면에서 필요한 js파일, 헷깔리지 말것 (building.js랑 비슷한데 내용이 더 많음)

  var groupoption, roomoption, buildingIdx, groupIdx, roomIdx;

  buildingIdx = $('select[name=building]').val();

  // console.log(buildingArray[buildingIdx][1]);


  for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    groupoption = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(groupoption);
    $('select[name=group]').append(groupoption);
  }
  groupIdx = $('select[name=group]').val();

  for(var key3 in roomArray[groupIdx]){
    roomoption = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
    $('select[name=room]').append(roomoption);
  }
  roomIdx = $('select[name=room]').val();


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
$(document).ready(function(){
  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    currentText: '오늘',
    closeText: '닫기'
  })

  $('.amountNumber').on('click keyup', function(){
    $(this).select();
  })

  $('input[name=monthCount]').on('click', function(){
    $(this).select();
  })

  $('input[name=executiveCount]').on('click', function(){
    $(this).select();
  })

  $("input:text[numberOnly]").number(true);

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

})//document.ready function closing}


function dateFormat(x){
  var yyyy = x.getFullYear().toString();
  var mm = (x.getMonth()+1).toString();
  var dd = x.getDate().toString();

  var date = yyyy+'-'+mm+'-'+dd;
  return date;
}

$('#contractDate').on('change', function(){
  var startDate = $(this).val();
  $('#startDate').val(startDate);
  $('#depositInDate').val(startDate);

  var monthCount = Number($('input[name=monthCount]').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  var endDate = dateFormat(eDate);

  $('#endDate').val(endDate);

}) //contractDate on change closing괄호, 최초계약일자=시작일자


$('#startDate').on('change', function(event){
  var startDate = $(input[name=startDate]).val();
  $('#startDate').val(startDate);

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
  $("input[name='executiveAmount']").val(amount12);
})

$("input[name='mvAmount']").on('keyup', function(){
  var amount1 = Number($("input[name='mAmount']").val());
  var amount2 = Number($(this).val());
  var amount12 = amount1 + amount2;
  $("input[name='mtAmount']").val(amount12);
  $("input[name='executiveAmount']").val(amount12);
})

$('input[name=executiveCount]').on('change', function(){
  var amount12 = Number($('input[name=mtAmount]').val());
  var executiveAmount = Number($(this).val()) * amount12;
  $("input[name='executiveAmount']").val(executiveAmount);
})

$('#frmSubmit').on('click', function(){
  var monthCount = $('input[name="monthCount"]').val();
  var executiveCount = $('input[name=executiveCount]').val();

  monthCount = Number(monthCount);
  executiveCount = Number(executiveCount);

  if(executiveCount > monthCount){
    alert('입금개월이 계약기간보다 클수 없습니다.');
    return false;
  }

  var amount1 = Number($("input[name='mAmount']").val());
  // if(amount1 === 0){
  //   alert('공급가액은 0보다 커야 저장됩니다.');
  //   return false;
  // }

  var amount1 = Number($("input[name='mAmount']").val());
  var amount2 = Number($("input[name='mvAmount']").val());
  var amount12 = amount1 + amount2;
  $("input[name='mtAmount']").val(amount12);



  var startDate = $('input[name=startDate]').val();
  var monthCount = Number($('input[name=monthCount]').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  var endDate = dateFormat(eDate);

  $('#endDate').val(endDate);

  $('form').submit();

})


</script>

</body>
</html>
