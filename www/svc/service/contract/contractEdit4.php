<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>임대계약상세</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "building.php";
include "contractEdit_condi.php";

 ?>
<style>

/* 세금계산서 iframe 크기 조절  */
.popup_iframe{position:fixed;left:0;right:0;top:0;bottom:0;z-index:9999;width:100%;height:100%;display:none;}

#wrap {
 position: absolute;
 width: 100%;
 height: 100%;
}

</style>

<div class="container jumbotron pt-3 pb-3 mb-2">
  <!-- <span><h3 class="">계약상세내용입니다.(#202)</h3></span><span><p>ㅋㅋ</p></span> -->
  <label for="" style="font-size:32px;">계약상세(화면번호 202)</label>
  <label class="font-italic" style="font-size:20px;color:#2E9AFE;">계약번호 <?=$filtered_id?></label>

</div>
<div class="row justify-content-center">
  <div class="col-11">

  <?php include "contractEdit_button.php";?>
  <?php include "contractEdit_ci.php";?>

  <!-- 하단 탭 -->
  <nav>
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a id="navSchedule" class="nav-link <?php if($_GET['page']==='schedule'){echo "active";} ?>" href="contractEdit.php?page=schedule&id=<?=$filtered_id?>">청구스케쥴(<?=$row['count2']?>개월)</a>
      </li>
      <li class="nav-items">
        <a id="navDeposit" class="nav-link <?php if($_GET['page']==='deposit'){echo "active";} ?>" href="contractEdit.php?page=deposit&id=<?=$filtered_id?>">보증금 <span>(<?=$row_deposit['remainMoney']?>원)</span></a>
      </li>
      <li class="nav-items">
        <a id="navFile" class="nav-link <?php if($_GET['page']==='file'){echo "active";} ?>" href="contractEdit.php?page=file&id=<?=$filtered_id?>">첨부파일(<?=count($fileRows)?>건)</a>
      </li>
      <li class="nav-items">
        <a id="navMemo" class="nav-link <?php if($_GET['page']==='memo'){echo "active";} ?>" href="contractEdit.php?page=memo&id=<?=$filtered_id?>">메모작성(<?=count($memoRows)?>건)</a>
      </li>
    </ul>
  </nav>

  <div class="">
    <?php if($_GET['page']==='schedule'){
      include "contractEdit_cs2.php";
      include "contractEdit_cs_modal_nadd.php";//n개월추가모달
      include "contractEdit_cs_modal_regist.php";//청구설정모달
    } else if($_GET['page']==='deposit'){
      include "contractEdit_deposit.php";
    } else if($_GET['page']==='file'){
      include "contractEdit_file.php";
    } else if($_GET['page']==='memo'){
      include "contractEdit_memo0.php";
    }
    ?>
  </div>

<!-- 종료일 입력 Modal -->
<div class="modal fade" id="modalEnd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">중간종료일을 입력하세요.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-md-center">
          <div class="col col-md-8">
            <input type="text" class="form-control form-control-sm text-center dateType pink" id="enddate3" value="<?=$row['endDate2']?>">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" id="enddate3btn">입력</button>
      </div>
    </div>
  </div>
</div>


  <!-- 최하단 계약정보작성자보여주기섹션 -->
  <section class="d-flex justify-content-center">
     <small class="form-text text-muted text-center">계약번호[<?=$row[0]?>] 등록일시[<?=$row['createTime']?>] 수정일시[<?=$row['updateTime']?>] </small>
  </section>

  <!-- 버튼모음 섹션 -->
  <section class="d-flex justify-content-center mt-3">
     <a class="btn btn-secondary mr-1" href="contract.php" role="button"><i class="fas fa-angle-double-right"></i> 계약목록</a>
     <a class="btn btn-outline-secondary mr-1 mobile" href="contractAll.php" role="button">일괄계약등록</a>
     <a class="btn btn-outline-secondary mr-1" href="contract_add2.php" role="button">계약등록</a>
  </section>
</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/service/customer/modal_customer.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/sms/modal_sms3.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>


<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/autosize.min.js"></script>
<script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
<script src="/svc/inc/js/etc/newdate8.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<!-- <script src="/svc/inc/js/etc/checkboxtable.js?<?=date('YmdHis')?>"></script> -->
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/uploadfile.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/sms_noneparase4.js?<?=date('YmdHis')?>"></script>

<script type="text/javascript">
   var buildingArray = <?php echo json_encode($buildingArray); ?>;
   var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
   var roomArray = <?php echo json_encode($roomArray); ?>;
   console.log(buildingArray);
   console.log(groupBuildingArray);
   console.log(roomArray);
</script>

<script>

var step = '<?=$step?>';
var customerId = <?=$row[1]?>;
var tbl = $("#checkboxTestTbl");

$(document).on('click', '.modalAsk', function(){ //청구번호클릭하는거(모달클릭)
  var currow2 = $(this).closest('tr');
  var payNumber = currow2.find('td:eq(8)').children('label:eq(0)').children('u').text();
  var filtered_id = '<?=$filtered_id?>';//계약번호
  var expectedAmount = currow2.find('td:eq(10)').children('label').text();
  var expectedDate = currow2.find('td:eq(6)').children().text();
  var executiveDiv = currow2.find('td:eq(7)').children().val();//입금구분
  var executiveDate = currow2.find('td:eq(10)').children('input').val();
  var executiveAmount = currow2.find('td:eq(10)').children('label').text();
  var payDiv = currow2.find('td:eq(9)').children().text();
  var taxMun = currow2.find('td:eq(12)').children('input[name=taxMun]').val();
  // alert(taxMun);

  var footer1 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mpayBack' class='btn btn-warning btn-sm mr-0'>청구취소</button><button type='button' id='mgetExecute' class='btn btn-primary btn-sm'>입금완료</button>";//입금대기이고 증빙이 없을때
  var footer11 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mpayBack' class='btn btn-warning btn-sm mr-0' disabled>청구취소</button><button type='button' id='mgetExecute' class='btn btn-primary btn-sm'>입금완료</button>";//입금대기이고 증빙있을때
  var footer2 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mModify' class='btn btn-warning btn-sm mr-0'>수정</button><button type='button' id='mExecuteBack' class='btn btn-warning btn-sm mr-0'>입금취소</button>";//입금완료이고 증빙일자 없을때
  var footer22 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mExecuteBack' class='btn btn-warning btn-sm mr-0' disabled>입금취소</button>";//입금완료이고 증빙일자 있을때

  // console.log(expectedAmount, expectedDate, executiveDiv, executiveDate, executiveAmount);

  $('#payId').text(payNumber);
  $('#expectedAmount').val(expectedAmount);
  $('#expectedDate').val(expectedDate);
  if(executiveDiv==='계좌'){
    $('#executiveDiv').val('계좌').prop('selected', true);
  } else if(executiveDiv==='현금'){
    $('#executiveDiv').val('현금').prop('selected', true);
  } else if(executiveDiv==='카드'){
    $('#executiveDiv').val('카드').prop('selected', true);
  }

  if(payDiv==='완납' || payDiv==='완납(연체)'){
    var expectedDate = currow2.find('td:eq(6)').children().text();
    var expectedAmount = currow2.find('td:eq(10)').children('label:eq(1)').text();
    var executiveDiv = currow2.find('td:eq(7)').children().text();//입금구분
    var executiveDate = currow2.find('td:eq(10)').children('label:eq(0)').text();

    $('#expectedDate').val(expectedDate).prop('disabled', true);
    $('#expectedAmount').val(expectedAmount).prop('disabled', true);
    // $('#executiveDiv').val(executiveDiv).prop('disabled', true);
    // $('#executiveDate').val(executiveDate).prop('disabled', true);
    $('#executiveAmount').val(expectedAmount).prop('disabled', true);//하다보니 입금수단과 입금일은 좀 수정을 하고싶어짐
    $('#executiveDiv').val(executiveDiv);
    $('#executiveDate').val(executiveDate);
    if(taxMun){
      $('.modal-footer').html(footer22);
    } else {
      $('.modal-footer').html(footer2);
    }
  } else if(payDiv==='입금대기' || payDiv==='미납'){
    $('#executiveDiv').prop('disabled', false);
    $('#executiveDate').val(expectedDate).prop('disabled', false);
    $('#executiveAmount').val(expectedAmount).prop('disabled', false);
    if(taxMun){
      $('.modal-footer').html(footer11);
    } else {
      $('.modal-footer').html(footer1);
    }
  }

}) //청구번호클릭하는거(모달클릭) closing}

$(document).ready(function(){

  $(function () {
      $('[data-toggle="tooltip"]').tooltip()
  })

  $('input[name=expecteDay]').on('click', function(){
    $(this).select();
  })

  var allCnt = $(":checkbox:not(:first)", tbl).length;

  $(".amountNumber").click(function(){
    $(this).select();
  });

  $("input:text[numberOnly]").number(true);

  $(".numberComma").number(true);

  $('#groupExpecteDay').keydown(function (event) {
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


  // 테이블 헤더에 있는 checkbox 클릭시
  $(":checkbox:first", tbl).change(function(){
    if($(":checkbox:first", tbl).is(":checked")){
      $(":checkbox", tbl).prop('checked',true);
      $(":checkbox").parent().parent().addClass("selected");
    } else {
      $(":checkbox", tbl).prop('checked',false);
      $(":checkbox").parent().parent().removeClass("selected");
    }
  })
  // 헤더에 있는 체크박스외 다른 체크박스 클릭시
  $(":checkbox:not(:first)", tbl).change(function(){
    var allCnt = $(":checkbox:not(:first)", tbl).length;
    if($(this).prop("checked")==true){
      $(this).parent().parent().addClass("selected");
      var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
      if(allCnt==checkedCnt ){
        $("#allselect").prop("checked", true);
      } else {
        $("#allselect").prop("checked", false);
      }
    } else {
      $(this).parent().parent().removeClass("selected");
      var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
      if(allCnt==checkedCnt ){
        $("#allselect").prop("checked", true);
      } else {
        $("#allselect").prop("checked", false);
      }
    }
  })

  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
    closeText: '닫기'  // 닫기 버튼 패널
  })

  $('#smsBtn').on('click', function(){
    // var buildingkey = $('input[name=building]').val();
    var buildingkey = '<?=$row['building_id']?>';
    console.log(buildingkey);
    var recievephonenumber = '<?=$cContact?>';
    var cname = '<?=$row[2]?>';

    //문자발송번호
    var sendphonenumber = buildingArray[buildingkey][3] + buildingArray[buildingkey][4] + buildingArray[buildingkey][5];
    $('input[name=sendphonenumber]').val(sendphonenumber);

    //문자수신번호
    $('#recievephonenumber').text(recievephonenumber);
    $('#mcid').val(customerId);
    $('#mcname').text(cname);

    sms_noneparase();
  })

}) //document.ready function closing}



var expectedDayArray = [];

$(":checkbox:first", tbl).click(function(){

    var allCnt = $(":checkbox:not(:first)", tbl).length;
    var table = tbl.find('tbody');
    expectedDayArray = [];

    if($(":checkbox:first", tbl).is(":checked")){
      for (var i = 0; i < allCnt; i++) {
        var expectedDayEle = [];
        expectedDayEle.push(i);//system order
        expectedDayEle.push(table.find('tbody').find("tr:eq("+i+")").find("td:eq(1)").children().text());//order
        expectedDayEle.push(table.find('tbody').find("tr:eq("+i+")").find("td:eq(0)").children('input[name=csId]').val());
        expectedDayEle.push(table.find('tbody').find("tr:eq("+i+")").find("td:eq(6)").children('input[name=expecteDay]').val());
        expectedDayArray.push(expectedDayEle);
      }
      // console.log(expectedDayArray);
    } else {
      expectedDayArray = [];
      // console.log(expectedDayArray);
    }
    console.log(expectedDayArray);
})

// $('.table').on('click',$(':checkbox:not(:first).is(":checked")'),function()

$(":checkbox:not(:first)",tbl).click(function(){
  var expectedDayEle = [];

  if($(this).is(":checked")){
    var currow = $(this).closest('tr');
    var rowid = currow.find('td:eq(1)').children('input[name=rowid]').val();
    rowid = Number(rowid);
    var colOrder = currow.find('td:eq(1)').children('label').text();
    var colid = currow.find('td:eq(0)').children('input').val();
    var colexpectDate = currow.find('td:eq(6)').children('input').val();
    expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
    expectedDayArray.push(expectedDayEle);
    // console.log(expectedDayArray);
    // console.log('체크됨');
  } else {
    var currow = $(this).closest('tr');
    var colOrder = currow.find('td:eq(1)').children('label').text();

    for (var i = 0; i < expectedDayArray.length; i++) {
      if(expectedDayArray[i][1]===colOrder){
        var index = i;
        break;
      }
    }

    expectedDayArray.splice(index, 1);
  }
  console.log(expectedDayArray);
})

$('.table').on('keyup', '.amountNumber:input[type="text"]', function(){
  var currow = $(this).closest('tr');
  var colOrder = Number(currow.find('td:eq(1)').text());
  console.log($(this).val());

  // console.log(colOrder);

  var colmAmount = Number(currow.find('td:eq(4)').children('input:eq(0)').val());

  var colmvAmount = Number(currow.find('td:eq(4)').children('input:eq(1)').val());

  var colmtAmount = colmAmount + colmvAmount;
  currow.find('td:eq(5)').children('input').val(colmtAmount);

})



$('#groupExpecteDay').change(function(){ //입금예정일 변경버튼 이벤트
  var expectedDayGroup = $('#groupExpecteDay').val();
  var table = tbl.find('tbody');

  if(expectedDayArray.length >= 1) {
    for (var i in expectedDayArray) {
       table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(6)").children('input').val(expectedDayGroup);
      // console.log(expectedDayArray[i][0], a);
    }
  }
})

$('#paykind').change(function(){ //입금수단 변경버튼 이벤트
  var a = $(this).val();
  if(expectedDayArray.length >= 1) {
    for (var i in expectedDayArray) {
       table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(6)").children('select').val(a).prop('selected', true);
      // console.log(expectedDayArray[i][0], a);
    }
  }
})

$('#button1').click(function(){ //청구설정버튼 클릭시
  var paykind = $('#paykind option:selected').text();

  expectedDayArray = expectedDayArray.sort(function(a,b){
    return a[0] - b[0];
  })//순번대로 정렬함(오름차순), 이거 중요함, 그런데 이거하고나니 엄청 느려짐 ㅠㅠ

  var paySchedule = [];

  for (var i = 0; i < expectedDayArray.length; i++) {
    var table = tbl.find('tbody');
    var payId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(8)').children('label:eq(0)').children('u').text(); //청구번호

    console.log(payId);
    if(payId){
      alert('청구번호가 존재하여, 청구설정을 못합니다. 다시 확인해주세요.');
      return false;
    }

    table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(7)").text(paykind);
    // console.log(expectedDayArray[i][0], a);
    // 입금구분을 변경시키는 것
    var payScheduleEle = [];
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(0)').children('input').val()); //계약번호
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(1)').children('label').text()); //순번
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(2)').children('label:eq(0)').text()); //시작일
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(3)').children('label:eq(0)').text()); //종료일
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(4)').children('input:eq(0)').val()); //공급가액
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(4)').children('input:eq(1)').val()); //세액
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(5)').children('input:eq(0)').val()); //합계금액
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(6)').children('input:eq(0)').val()); //예정일
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(7)').text()); //입금구분

    paySchedule.push(payScheduleEle);
  }
  console.log(paySchedule);

  var paySchedule11 = JSON.stringify(paySchedule);

  var contractId = '<?=$filtered_id?>';
  var buildingId = $('input[name=building]').val();

  if(expectedDayArray.length === 0){
    alert('한개 이상을 선택해야 청구가 됩니다.');
    return false;

  } else if (expectedDayArray.length <= 72) {

    goCategoryPage(paySchedule11, contractId, buildingId);

    function goCategoryPage(a, b, c){
      var frm = formCreate('payScheduleAdd', 'post', 'p_payScheduleAdd1.php','');
      frm = formInput(frm, 'scheduleArray', a);
      frm = formInput(frm, 'contractId', b);
      frm = formInput(frm, 'buildingId', c);
      formSubmit(frm);
    }

  }
})

$('#button2').click(function(){ //청구취소버튼 클릭시

  if(expectedDayArray.length===0){
    alert('선택한 내역이 없습니다.');
    return false;
  }

  var payIdArray = [];
  var table = tbl.find('tbody');

  for (var i = 0; i < expectedDayArray.length; i++) {

    var payIdArrayEle = [];
    var payId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(8)').children('label:eq(0)').children('u').text();//청구번호
    var csCheck = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(9)').children().text();//수납구분
    // console.log(csCheck);
    var taxMun = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(12)').children('input[name=taxMun]').val();

    if(payId==''){
      alert('청구번호가 존재해야 청구취소 가능합니다.');
      return false;
    }

    if(csCheck == '완납' || csCheck == '완납(연체)'){
      alert('완납상태여서 청구취소 불가합니다. 입금취소부터 해주세요.');
      return false;
    }

    if(taxMun){
      alert('청구세금계산서가 발행된 상태이므로 청구취소 불가합니다. 내용을 다시 확인하거나 만일 반드시 청구취소해야 한다면, 데이터정정요청 버튼을 클릭하세요.');
      return false;
    }

    payIdArrayEle.push(payId, csCheck);
    payIdArray.push(payIdArrayEle);
  }
  // console.log(payIdArray);

  var contractId = '<?=$filtered_id?>';
  payIdArray = JSON.stringify(payIdArray);

  goCategoryPage(payIdArray, contractId);

  function goCategoryPage(a, b){
    var frm = formCreate('payScheduleDrop', 'post', 'p_payScheduleDropFor.php','');
    frm = formInput(frm, 'payIdArray', a);
    frm = formInput(frm, 'contractId', b);
    formSubmit(frm);
  }

})


$('#button3').click(function(){ //일괄입금버튼 클릭시

  var payIdArray = [];
  var table = tbl.find('tbody');

  // console.log(expectedDayArray);

  if(expectedDayArray.length===0){
    alert('청구설정된것을 선택해야 일괄입금처리가 가능합니다.');
    return false;
  }

  for (var i = 0; i < expectedDayArray.length; i++) {
    var payIdArrayEle = [];

    var psId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(8)').children('label').children('u').text();//청구번호
    // console.log(psId); //제이쿼리로 트림을 하니 더 이상해져서 안하기로함
    if(psId.trim()===""){ //trim()이거를 안넣으니 빈문자열로 인식이 안되어서 이거넣음
      alert('청구번호가 존재해야 일괄입금처리가 가능합니다.');
      window.location.reload();
      return false;
    }

    var csCheck = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(9)').children().text();//수납구분
    if(csCheck == '완납' || csCheck == '완납(연체)'){
      alert('이미 입금처리가 되어있습니다.');
      return false;
    }

    var payKind = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(7)').children().val();//입금구분
    var executiveDate = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(10)').children('input').val();
    var executiveAmount = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(5)').children('label').text();

    payIdArrayEle.push(psId, payKind, executiveDate, executiveAmount);
    payIdArray.push(payIdArrayEle);
  }
  console.log(payIdArray);

  var contractId = '<?=$filtered_id?>';
  payIdArray = JSON.stringify(payIdArray);

  goCategoryPage(payIdArray, contractId);

  function goCategoryPage(a, b){
    var frm = formCreate('getAmountInput', 'post', 'p_payScheduleGetAmountInputFor.php','');
    frm = formInput(frm, 'payIdArray', a);
    frm = formInput(frm, 'contractId', b);
    formSubmit(frm);
  }

})

$('#button4').click(function(){ //일괄입금취소버튼 클릭시

  var payIdArray = [];
  var table = tbl.find('tbody');

  if(expectedDayArray.length===0){
    alert('선택된것이 없습니다. 먼저 체크박스로 데이터를 선택해주세요.');
    return false;
  }

  for (var i = 0; i < expectedDayArray.length; i++) {

    var psId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(8)').children('label').children('u').text();//청구번s

    if(psId===""){ //trim()이거를 안넣으니 빈문자열로 인식이 안되어서 이거넣음
      alert('청구번호가 존재해야 일괄입금취소 처리가 가능합니다.');
      window.location.reload();
      return false;
    }

    var csCheck = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(9)').children().text();//수납구분
    if(csCheck == '입금대기' || csCheck == '미납'){
      alert('아직 입금처리가 되어있지 않으므로 입금취소 불가합니다.');
      return false;
    }

    var taxMun = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(12)').children('input[name=taxMun]').val();
    if(taxMun){
      alert('세금계산서가 발행된 상태이므로 입금취소 불가합니다. 내용을 다시 확인하거나 만일 반드시 입금취소해야 한다면, 하단 이메일(info@leaseman.co.kr)로 데이터정정을 요청해주세요.');
      return false;
    }

    payIdArray.push(psId);
  }
  // console.log(contractScheduleArray);

  var contractId = '<?=$filtered_id?>';
  payIdArray = JSON.stringify(payIdArray);

  goCategoryPage(payIdArray, contractId);

  function goCategoryPage(a,b){
    var frm = formCreate('getAmountDrop', 'post', 'p_payScheduleGetAmountCanselFor.php','');
    frm = formInput(frm, 'payIdArray', a);
    frm = formInput(frm, 'contractId', b);
    formSubmit(frm);
  }

})

$('#button7').click(function(){ //삭제버튼 클릭시

    var contractScheduleArray = [];
    var allCnt = $(":checkbox:not(:first)", tbl).length;
    var table = tbl.find('tbody');
    // console.log(allCnt);

    if(expectedDayArray.length===0){
      alert('한개 이상을 선택해야 삭제 가능합니다.');
      return false;
    }

    for (var i = 0; i < expectedDayArray.length; i++) {

      contractScheduleArray[i] = [];

      var csId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(0)').children('input').val();

      var csOrder = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(1)').children('label').text();

      var psId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(8)').children('label').children('u').text();

      if(psId){
        alert('청구번호가 존재하면 삭제할수 없습니다.');
        return false;
      }

      contractScheduleArray[i].push(csId, csOrder, psId);
    }
    // console.log(contractScheduleArray);

    var selectedOrderArray = [];
    for (var i = 0; i < expectedDayArray.length; i++) {
      selectedOrderArray.push(Number(expectedDayArray[i][1]));
    }
    selectedOrderArray.sort(function(a,b) {
      return a-b;
    }); //선택한순번들을 오름차순으로 정렬해주는것
    // console.log(selectedOrderArray);

    var regularOrderArray=[];
    for (var i = 0; i < contractScheduleArray.length; i++) {
      var ele = allCnt - i;
      regularOrderArray.push(ele);
    }
    regularOrderArray.sort(function(a,b) {
      return a-b;
    }); //정해진순번들을 오름차순으로 정렬해주는것
    // console.log(regularOrderArray);

    if(!selectedOrderArray.includes(allCnt)){
      console.log(selectedOrderArray);
      console.log(allCnt);
      alert('스케줄 중간을 삭제할 수 없습니다.');
      return false;
    }

    if(selectedOrderArray.includes(1)){
      alert('순번1은 삭제할 수 없습니다. 1개이상의 스케쥴은 존재해야 합니다.');
      return false;
    }

    for (var i = 0; i < regularOrderArray.length; i++) {
      if(!((regularOrderArray[i]-selectedOrderArray[i])===0)){
        alert('스케줄은 순차적으로 삭제되어야 합니다.');
        return false;
      }
    }

    var contractScheduleIdArray = [];
    for (var i = 0; i < contractScheduleArray.length; i++) {
      contractScheduleIdArray.push(contractScheduleArray[i][0]);
    }

    // console.log(contractScheduleIdArray);

    var aa = 'contractScheduleDrop';
    var bb = 'p_contractScheduleDrop.php';
    var contractId = '<?=$filtered_id?>';

    goCategoryPage(aa, bb, contractId, contractScheduleIdArray);

    function goCategoryPage(a, b, c, d){
      var frm = formCreate(a, 'post', b,'');
      frm = formInput(frm, 'contractId', c);
      frm = formInput(frm, 'contractScheduleIdArray', d);
      formSubmit(frm);
    }


}) //삭제버튼 클릭시

$('#button5').click(function(){ //1개월추가 버튼클릭
  var allCnt = $(":checkbox:not(:first)", tbl).length;
  var aa = 'contractScheduleAppend';
  var bb = 'p_contractScheduleAppend.php';
  var contractId = '<?=$filtered_id?>';

  if(allCnt===72){
    alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
    return false;
  }

  goCategoryPage(aa,bb,contractId);

  function goCategoryPage(a,b,c){
    var frm = formCreate(a, 'post', b,'');
    frm = formInput(frm, 'contractId', c);
    formSubmit(frm);
  }
}); //1개월추가 버튼

$('#memoButton').click(function(){
    var memoInputer = $('#memoInputer').val();
    var memoContent = $('#memoContent').val();

    if(!memoContent){
        alert('내용을 입력해야 합니다.');
        return false;
    }
    // console.log(memoInputer, memoContent);

    var aa = 'memoAppend';
    var bb = 'p_memoAppend.php';
    var contractId = '<?=$filtered_id?>';

    goCategoryPage(aa,bb,contractId,memoInputer,memoContent);

    function goCategoryPage(a,b,c,d,e){
        var frm = formCreate(a, 'post', b,'');
        frm = formInput(frm, 'contractId', c);
        frm = formInput(frm, 'memoInputer', d);
        frm = formInput(frm, 'memoContent', e);
        formSubmit(frm);
    }

});

$("label[name='memoEdit']").click(function(){
    var contractId = '<?=$filtered_id?>';
    var memoid = $(this).parent().parent().find('td:eq(0)').children('input[name=memoid]').val();
    var memoCreator = $(this).parent().parent().find('td:eq(1)').children('input').val();
    var memoContent = $(this).parent().parent().children().children('textarea').val();
    // console.log(memoid, memoCreator, memoContent);
    console.log(memoid, memoCreator, memoContent);

    goCategoryPage(contractId,memoid,memoCreator,memoContent);

    function goCategoryPage(a,b,c,d){
        var frm = formCreate('memoEdit', 'post', 'p_memoEdit.php','');
        frm = formInput(frm, 'contractId', a);
        frm = formInput(frm, 'memoid', b);
        frm = formInput(frm, 'memoCreator', c);
        frm = formInput(frm, 'memoContent', d);
        formSubmit(frm);
    }
});


$("label[name='memoDelete']").click(function(){

  var c = confirm('정말 삭제하시겠습니까?');

  if(c){
    var memoid = $(this).parent().parent().children().children('input:eq(0)').val();
    var contractId = '<?=$filtered_id?>';

    goCategoryPage(contractId,memoid);
    function goCategoryPage(a,b){
        var frm = formCreate('memoDelete', 'post', 'p_memoDelete.php','');
        frm = formInput(frm, 'contractId', a);
        frm = formInput(frm, 'memoid', b);
        formSubmit(frm);
    }
  }

});

$("button[name='fileDelete']").click(function(){
    var fileid = $(this).parent().parent().children().children('input:eq(0)').val();

    // console.log('메모삭제', memoid);

    var contractId = '<?=$filtered_id?>';
    var aa = 'fileDelete';
    var bb = 'p_fileDelete.php';
    //
    goCategoryPage(aa,bb,contractId,fileid);

    function goCategoryPage(a,b,c,d){
        var frm = formCreate(a, 'post', b,'');
        frm = formInput(frm, 'contractId', c);
        frm = formInput(frm, 'fileid', d);
        formSubmit(frm);
    }
});


$("button[name='contractDelete']").on('click', function(){
  var contractId = '<?=$filtered_id?>';
  var memocount = '<?=count($memoRows)?>';
  var filecount = '<?=count($fileRows)?>';

  if(step==='청구'){
    alert('청구정보를 삭제해야 계약삭제 가능합니다.체크박스 선택 후 청구취소버튼을 누르세요.');
    return false;
  }

  if(step==='입금'){
    alert('입금정보를 삭제해야 계약삭제 가능합니다.체크박스 선택 후 입금취소버튼을 누르세요.');
    return false;
  }

  if(Number(memocount)>0){
    alert('메모를 삭제해야 계약삭제 가능합니다.');
    return false;
  }

  if(Number(filecount)>0){
    alert('파일을 삭제해야 계약삭제 가능합니다.');
    return false;
  }

  var aa = 'contractDelete';
  var bb = 'p_realContract_delete.php';

  var deleteCheck = confirm('정말 삭제하겠습니까?');
  if(deleteCheck){
    goCategoryPage(aa,bb,contractId);

    function goCategoryPage(a,b,c){
      var frm = formCreate(a, 'post', b,'');
      frm = formInput(frm, 'contractId', c);
      formSubmit(frm);
    }
  }
})//메모개수와 파일개수가 0이어야 삭제가 됨

$("input[name='modalAmount1']").on('keyup', function(){
    var changeAmount1 = Number($(this).val());
    var changeAmount2 = Number($("input[name='modalAmount2']").val());
    var changeAmount3 = changeAmount1 + changeAmount2;
    var monthCount = Number($('input[name=addMonth]').val());
    var executiveAmount = monthCount * changeAmount3;

    $("input[name='modalAmount3']").val(changeAmount3);
    $('#mexecutiveAmount2').val(executiveAmount);
});

$("input[name='modalAmount2']").on('keyup', function(){
    var changeAmount2 = Number($(this).val());
    var changeAmount1 = Number($("input[name='modalAmount1']").val());
    var changeAmount3 = changeAmount1 + changeAmount2;
    var monthCount = Number($('input[name=addMonth]').val());
    var executiveAmount = monthCount * changeAmount3;
    $("input[name='modalAmount3']").val(changeAmount3);
    $('#mexecutiveAmount2').val(executiveAmount);
});

$('#button6').click(function(){ //n개월추가 버튼, 모달클릭으로 바뀜
    var allCnt = $(":checkbox:not(:first)", tbl).length;
    var addMonth = Number($("input[name='addMonth']").val());
    var changeAmount1 = $("input[name='modalAmount1']").val()
    var changeAmount2 = $("input[name='modalAmount2']").val()
    var changeAmount3 = $("input[name='modalAmount3']").val()


    if(Number(addMonth)+allCnt > 72){
        alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
        return false;
    }

    var aa = 'contractScheduleAppendM';
    var bb = 'p_contractScheduleAppendM.php';
    var contractId = '<?=$filtered_id?>';

    goCategoryPage(aa,bb,contractId,addMonth,changeAmount1,changeAmount2,changeAmount3);

    function goCategoryPage(a,b,c,d,e,f,g){
        var frm = formCreate(a, 'post', b,'');
        frm = formInput(frm, 'contractId', c);
        frm = formInput(frm, 'addMonth', d);
        frm = formInput(frm, 'changeAmount1', e);
        frm = formInput(frm, 'changeAmount2', f);
        frm = formInput(frm, 'changeAmount3', g);
        formSubmit(frm);
    }
}); //n개월추가

// $(document).on('click', '#navDeposit', function(){
//   $(this).addClass('active');
//   console.log('active');
// })

//========================

$(document).on('click', '#mgetExecute', function(){ //입금완료버튼(모달안버튼) 클릭

  // console.log('solmi');
  var aa1 = 'payScheduleInput';
  var bb1 = 'p_payScheduleGetAmountInput.php';
  var contractId = '<?=$filtered_id?>';

  var pExpectedDate = $('#expectedDate').val(); //입금예정일

  var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)').text(); //청구번호

  var ppayKind = $(this).parent().prev().children().children(':eq(2)').children(':eq(1)').children().val(); //입금구분

  var pgetDate = $(this).parent().prev().children().children(':eq(3)').children(':eq(1)').children().val(); //입금일

  var pgetAmount = $(this).parent().prev().children().children(':eq(4)').children(':eq(1)').children().val(); //입금액

  var pExpectedAmount = $(this).parent().prev().children().children(':eq(0)').children(':eq(1)').children().val(); //예정금액

  console.log(pExpectedDate);

  if(pgetAmount != pExpectedAmount){
    alert('입금액과 예정금액은 같아야 합니다.');
    return false;
  }

  goCategoryPage(contractId, pid, ppayKind, pgetDate, pgetAmount, pExpectedDate);

  function goCategoryPage(a,b,c,d,e,f){
    var frm = formCreate('payScheduleInput', 'post', 'p_payScheduleGetAmountInput.php','');
    frm = formInput(frm, 'realContract_id', a);
    frm = formInput(frm, 'payid', b);
    frm = formInput(frm, 'paykind', c);
    frm = formInput(frm, 'pgetdate', d);
    frm = formInput(frm, 'pgetAmount', e);
    frm = formInput(frm, 'pExpectedDate', f);
    formSubmit(frm);
  }
})

//=======================
$(document).on('click', '#mExecuteBack', function(){ //입금취소버튼(모달안버튼) 클릭
  var aa1 = 'payScheduleGetAmountCansel';
  var bb1 = 'p_payScheduleGetAmountCansel.php';
  var contractId = '<?=$filtered_id?>';

  var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)').text(); //청구번호

  // console.log(pid, contractId);

  goCategoryPage(aa1, bb1, contractId, pid);

  function goCategoryPage(a, b, c, d){
    var frm = formCreate(a, 'post', b,'');
    frm = formInput(frm, 'realContract_id', c);
    frm = formInput(frm, 'payid', d);
    formSubmit(frm);
  }

})

//=======================
$(document).on('click', '#mModify', function(){ //수정버튼(모달안버튼) 클릭

  var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)').text(); //청구번호
  var contractId = '<?=$filtered_id?>';
  var payDiv = $('#executiveDiv').val(); //입금수단, 계좌/현금/카드
  var executiveDate = $('#executiveDate').val(); //입금금액


  goCategoryPage(pid, payDiv, executiveDate, contractId);

  function goCategoryPage(a, b, c, d){
    var frm = formCreate('payScheduleGetAmountModify', 'post', 'p_payScheduleGetAmountModify.php', '');
    frm = formInput(frm, 'payid', a);
    frm = formInput(frm, 'payKind', b);
    frm = formInput(frm, 'executiveDate', c);
    frm = formInput(frm, 'realContract_id', d);
    formSubmit(frm);
  }

})

//=======================

$(document).on('click', '#mpayBack', function(){ //청구취소(삭제)버튼(모달안버튼) 클릭
  var aa1 = 'payScheduleDrop';
  var bb1 = 'p_payScheduleDrop.php';
  var contractId = '<?=$filtered_id?>'

  var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)').text(); //청구번호

  // console.log(pid, contractId);

  goCategoryPage(aa1, bb1, contractId, pid);

  function goCategoryPage(a, b, c, d){
    var frm = formCreate(a, 'post', b,'');
    frm = formInput(frm, 'realContract_id', c);
    frm = formInput(frm, 'payid', d);
    formSubmit(frm);
  }

})
//========================

$(document).on('keyup', "input[name='depositInAmount']", function(){
    var depositInAmount = Number($(this).val());
    var depositOutAmount = Number($("input[name='depositOutAmount']").val());
    var depositMoney = depositInAmount - depositOutAmount;
    $("input[name='depositMoney']").val(depositMoney);
});

$(document).on('keyup', "input[name='depositOutAmount']", function(){
    var depositInAmount = Number($("input[name='depositInAmount']").val());
    var depositOutAmount = Number($(this).val());
    var depositMoney = depositInAmount - depositOutAmount;
    $("input[name='depositMoney']").val(depositMoney);
});

$("button[name='depositSaveBtn']").on('click', function(){
    var depositInDate = $("input[name='depositInDate']").val();
    var depositInAmount = Number($("input[name='depositInAmount']").val());
    var depositOutDate = $("input[name='depositOutDate']").val();
    var depositOutAmount = Number($("input[name='depositOutAmount']").val());
    var depositMoney = Number($("input[name='depositMoney']").val());

    var contractId = '<?=$filtered_id?>';
    var aa = 'depositSave';
    var bb = 'p_depositSave.php';

    goCategoryPage(aa,bb,contractId,depositInDate,depositInAmount,depositOutDate,depositOutAmount,depositMoney);

    function goCategoryPage(a,b,c,d,e,f,g,h){
        var frm = formCreate(a, 'post', b,'');
        frm = formInput(frm, 'contractId', c);
        frm = formInput(frm, 'depositInDate', d);
        frm = formInput(frm, 'depositInAmount', e);
        frm = formInput(frm, 'depositOutDate', f);
        frm = formInput(frm, 'depositOutAmount', g);
        frm = formInput(frm, 'depositMoney', h);
        formSubmit(frm);
    }
})

//===================================

$('input[name=addMonth]').on('change', function(){
  var monthCount = Number($(this).val());
  var changeAmount3 = Number($("input[name='modalAmount3']").val());
  var executiveAmount = monthCount * changeAmount3;

  console.log(monthCount, changeAmount3, executiveAmount);

  $('#mexecutiveAmount2').val(executiveAmount);
})

$('#mpExpectedDate2').on('click', function(){
  $(this).select();
})

$('#mexecutiveDate2').on('click', function(){
  $(this).select();
})

$(document).on('click', '#buttonm2', function(){//n개월 추가모달에서 청구설정하는거

  var allCnt = $(":checkbox:not(:first)", tbl).length;
  var addMonth = Number($("input[name='addMonth']").val());

  if(!addMonth){
    alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
    return false;
  }

  if(Number(addMonth)+allCnt > 72){
      alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
      return false;
  }

  var contractId = '<?=$filtered_id?>';
  var buildingId = $('input[name=building]').val();
  var changeAmount1 = $("input[name='modalAmount1']").val()
  var changeAmount2 = $("input[name='modalAmount2']").val()
  var changeAmount3 = $("input[name='modalAmount3']").val()
  var expectedDate = $('#mpExpectedDate2').val();
  var payKind = $('#executiveDiv2').val();

  goCategoryPage(contractId,addMonth,changeAmount1,changeAmount2,changeAmount3, expectedDate, payKind, buildingId);

  function goCategoryPage(a,b,c,d,e,f,g,h){
      var frm = formCreate('cspsAppendM', 'post', 'p_payScheduleAdd2.php','');
      frm = formInput(frm, 'contractId', a);
      frm = formInput(frm, 'addMonth', b);
      frm = formInput(frm, 'changeAmount1', c);
      frm = formInput(frm, 'changeAmount2', d);
      frm = formInput(frm, 'changeAmount3', e);
      frm = formInput(frm, 'expectedDate', f);
      frm = formInput(frm, 'payKind', g);
      frm = formInput(frm, 'buildingId', h);
      formSubmit(frm);
  }

})

$(document).on('click', '#buttonm1', function(){//n개월 추가모달에서 입금완료 하는거

  var allCnt = $(":checkbox:not(:first)", tbl).length;
  var addMonth = Number($("input[name='addMonth']").val());

  if(!addMonth){
    alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
    return false;
  }

  if(Number(addMonth)+allCnt > 72){
      alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
      return false;
  }

  var contractId = '<?=$filtered_id?>';
  var buildingId = $('input[name=building]').val();
  var changeAmount1 = $("input[name='modalAmount1']").val()
  var changeAmount2 = $("input[name='modalAmount2']").val()
  var changeAmount3 = $("input[name='modalAmount3']").val()
  var expectedDate = $('#mpExpectedDate2').val();
  var executiveDate = $('#mexecutiveDate2').val();
  var executiveAmount = $('#mexecutiveAmount2').val();
  var payKind = $('#executiveDiv2').val();

  if(expectedDate){
    if(!executiveDate){
      alert('입금예정일 또는 입금완료일을 둘다 넣어주거나 아니면 둘다 넣지 않아야 합니다. 둘 중 한개만 넣으면 처리되지 않습니다.');
      return false;
    }
  }

  if(executiveDate){
    if(!expectedDate){
      alert('입금예정일 또는 입금완료일을 둘다 넣어주거나 아니면 둘다 넣지 않아야 합니다. 둘 중 한개만 넣으면 처리되지 않습니다.');
      return false;
    }
  }

  goCategoryPage(contractId,addMonth,changeAmount1,changeAmount2,changeAmount3, expectedDate, payKind, buildingId, executiveDate, executiveAmount);

  function goCategoryPage(a,b,c,d,e,f,g,h,i,j){
      var frm = formCreate('cspsAmountInputM', 'post', 'p_payScheduleGetAmountInputFor2.php','');
      frm = formInput(frm, 'contractId', a);
      frm = formInput(frm, 'addMonth', b);
      frm = formInput(frm, 'changeAmount1', c);
      frm = formInput(frm, 'changeAmount2', d);
      frm = formInput(frm, 'changeAmount3', e);
      frm = formInput(frm, 'expectedDate', f);
      frm = formInput(frm, 'payKind', g);
      frm = formInput(frm, 'buildingId', h);
      frm = formInput(frm, 'executiveDate', i);
      frm = formInput(frm, 'executiveAmount', j);
      formSubmit(frm);
  }

})

$('#buttonDirect').on('click', function(){
  var paykind = $('#paykind option:selected').text();
  var table = tbl.find('tbody');

  if(expectedDayArray.length === 0){
    alert('한개 이상을 선택해야 즉시입금 가능합니다.');
    return false;
  }

  expectedDayArray = expectedDayArray.sort(function(a,b){
    return a[0] - b[0];
  })//순번대로 정렬함(오름차순), 이거 중요함, 그런데 이거하고나니 엄청 느려짐 ㅠㅠ

  var paySchedule = [];

  for (var i = 0; i < expectedDayArray.length; i++) {
    var psId = table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(8)').children('label:eq(0)').text(); //수납구분
    if(psId){
      alert('청구번호가 있는경우 즉시입금이 불가합니다. 청구번호없는 아무것도 없는 상태에서 청구와 입금처리가 동시에 되는거에요.');
      return false;
    }

    table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(7)").text(paykind);
    // console.log(expectedDayArray[i][0], a);
    // 입금구분을 변경시키는 것
    var payScheduleEle = [];
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(0)').children('input').val()); //계약번호
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(1)').children('label').text()); //순번
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(2)').children('label:eq(0)').text()); //시작일
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(3)').children('label:eq(0)').text()); //종료일
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(4)').children('input:eq(0)').val()); //공급가액
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(4)').children('input:eq(1)').val()); //세액
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(5)').children('input:eq(0)').val()); //합계금액
    payScheduleEle.push(table.find("tr:eq("+expectedDayArray[i][0]+")").find('td:eq(6)').children('input:eq(0)').val()); //예정일

    paySchedule.push(payScheduleEle);
  }

  console.log(paySchedule);

  var paySchedule11 = JSON.stringify(paySchedule);

  var contractId = '<?=$filtered_id?>';
  var buildingId = $('input[name=building]').val();


  goCategoryPage(paySchedule11, contractId, buildingId, paykind);

  function goCategoryPage(a, b, c, d){
    var frm = formCreate('cspsAmountInputM', 'post', 'p_payScheduleGetAmountInputFor3.php','');
    frm = formInput(frm, 'scheduleArray', a);
    frm = formInput(frm, 'contractId', b);
    frm = formInput(frm, 'buildingId', c);
    frm = formInput(frm, 'paykind', d);
    formSubmit(frm);
  }


})

function taxInfo2(bid,mun,ccid) {
  var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
  $("body").append(tmps);
  //alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );

  $("#ifm_pops_21").attr("src","/svc/service/get/tax_invoice.php?building_idx="+bid+"&mun="+mun+"&id="+ccid+"&flag=expected");
  $('#ifm_pops_21').show();
  $('.pops_wrap, .pops_21').show();

}

$('#enddate3btn').on('click', function(){
  var contractId = '<?=$filtered_id?>';
  var original_enddate = '<?=$row['endDate2']?>';
  var startDate = '<?=$row['startDate']?>';
  var enddate3 = $('#enddate3').val();

  original_enddate = new Date(original_enddate);
  startDate = new Date(startDate);
  enddate3 = new Date(enddate3);

  // console.log(original_enddate, startDate, enddate3);

  if(step != '입금'){
    alert('현재 단계가 '+step+' 상태여서 중간종료처리를 할 필요가 없어요. 계약기간 등을 수정하면 됩니다.');
    return false;
  }

  if(original_enddate === enddate3){
    alert('종료일과 같으면 중간종료가 아닙니다. 중간종료일을 다시 확인하세요');
    return false;
  }

  if(enddate3 <= startDate){
    alert('시작일보다 작거나 같으면 중간종료가 아닙니다. 날짜를 다시 확인해주세요.');
    return false;
  }

  if(enddate3 >= original_enddate){
    alert('종료일보다 크거나 같으면 중간종료가 아닙니다. 날짜를 다시 확인해주세요.');
    return false;
  }

  enddate3 = $('#enddate3').val();;

  goCategoryPage(contractId, enddate3);

  function goCategoryPage(a,b){
    var frm = formCreate('contractMiddleEnd', 'post', 'p_realContract_middle_end.php', '');
    frm = formInput(frm, 'contractId', a);
    frm = formInput(frm, 'enddate3', b);
    formSubmit(frm);
  }

})

$('button[name=middleEndCansel]').on('click', function(){
  var contractId = '<?=$filtered_id?>';

  goCategoryPage(contractId);

  function goCategoryPage(a){
    var frm = formCreate('contractMiddleEndCansel', 'post', 'p_realContract_middle_end_cansel.php', '');
    frm = formInput(frm, 'contractId', a);
    formSubmit(frm);
  }
})

autosize($('textarea[name=memoContent]'));

$(document).on('click', '.eachpop', function(){

  // var cid = $(this).siblings('input[name=customerId]').val();
  // var cid = $(this);
  var cid = $(this).children('input:eq(1)').val();
  // console.log(cid);

  $.ajax({
    url: '../customer/ajax_customer.php',
    method: 'post',
    data: {'cid' : cid},
    success: function(data){
      data = JSON.parse(data);
      // console.log(data);
      $('input[name=id_m]').val(cid);
      $('input[name=name_m]').val(data.name);
      $('input[name=contact1_m]').val(data.contact1);
      $('input[name=contact2_m]').val(data.contact2);
      $('input[name=contact3_m]').val(data.contact3);
      $('input[name=companyname_m]').val(data.companyname);
      $('input[name=cNumber1_m]').val(data.cNumber1);
      $('input[name=cNumber2_m]').val(data.cNumber2);
      $('input[name=cNumber3_m]').val(data.cNumber3);
      $('input[name=email_m]').val(data.email);
      $('input[name=div4_m]').val(data.div4);
      $('input[name=div5_m]').val(data.div5);
      $('textarea[name=etc_m]').val(data.etc);
      $('span[name=id_m]').text(cid);
      $('span[name=created_m]').text(data.created);
      $('span[name=updated_m]').text(data.updated);

      if(data.div2==='개인'){
        $('option[name=kind1]').attr('selected',true);
      } else if(data.div2==='개인사업자'){
        $('option[name=kind2]').attr('selected',true);
      } else if(data.div2==='법인사업자'){
        $('option[name=kind3]').attr('selected',true);
      }

      if(data.div3==='주식회사'){
        $('option[name=a2]').attr('selected',true);
      } else if(data.div3==='유한회사'){
        $('option[name=a3]').attr('selected',true);
      } else if(data.div3==='합자회사'){
        $('option[name=a4]').attr('selected',true);
      } else if(data.div3==='기타'){
        $('option[name=a5]').attr('selected',true);
      } else {
        $('option[name=a1]').attr('selected',true);
      }
    }
  })//ajax}

})

autosize($('textarea[name=etc_m]'));

</script>


</body>
</script>
