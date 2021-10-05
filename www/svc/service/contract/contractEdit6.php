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
    <link rel="icon" type="image/x-icon" href="/svc/inc/img/icon/checkround.png">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no">

    <!-- 부트스트랩 css -->
    <link rel="stylesheet" href="/svc/inc/css/bootstrap.min.css">


    <!-- 달력 css -->
    <link rel="stylesheet" href="/svc/inc/css/jquery-ui.min.css">

    <!-- 세금계산서 css -->
    <link rel="stylesheet" href="/svc/inc/css/pops.css">

    <!-- 폰트어썸 css -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- 커스텀 css -->
    <link rel="stylesheet" href="/svc/inc/css/customizing.css?<?=date('YmdHis')?>">

    <!-- fullCalendar css -->
    <link rel="stylesheet" href="/svc/inc/css/fullcalendar.css?<?=date('YmdHis')?>">
    <link rel="stylesheet" href="/svc/inc/css/fullcalendar.min.css?<?=date('YmdHis')?>">
  </head>
<?php
// include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "building.php";
include "./condi/sql_all.php";
include "./condi/sql_deposit.php";
include "./condi/sql_file.php";
include "./condi/sql_memo.php";
include "contractEdit_cs_modal_nadd.php";//n개월추가모달
include "contractEdit_cs_modal_regist.php";//청구설정모달
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

<section class="container jumbotron pt-3 pb-3 mb-2">
  <label for="" style="font-size:32px;">임대계약상세(화면번호 202)</label>
  <label class="font-italic" style="font-size:20px;color:#2E9AFE;">계약번호 <?=$filtered_id?></label>
</section>

<section>
  <div class="row justify-content-center">
    <div class="col-11">
    <?php include "./edit/1_button.php";?>
    <?php include "./edit/2_ci.php";?>
    </div>
  </div>
</section>

<!-- 하단 탭 -->
<section class="container">
  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">임대료목록(<?=$row['count2']?>개월)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/3_schedule.php";
    include "../modal/modal_nadd.php";//n개월추가모달
    include "../modal/modal_regist.php";//청구설정모달
    ?>
  </div>

  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">보증금 (<span name="depositMoney"></span>원)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/4_deposit.php";
    ?>
  </div>

  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">첨부파일(<?=count($fileRows)?>건)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/5_file.php";
    ?>
  </div>

  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a id="navMemo" class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">메모작성(<?=count($memoRows)?>건)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/6_memo.php";
    ?>
  </div>
</section>


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
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/uploadfile.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/sms_noneparase4.js?<?=date('YmdHis')?>"></script>
<script src="j_checksum_cd.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/customer.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/ce_pl_f2.js?<?=date('YmdHis')?>"></script>



<script type="text/javascript">
   var buildingArray = <?php echo json_encode($buildingArray); ?>;
   var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
   var roomArray = <?php echo json_encode($roomArray); ?>;
   console.log(buildingArray);
   console.log(groupBuildingArray);
   console.log(roomArray);
</script>

<script>

let contractId = <?=$filtered_id?>;
let tbl = $("#checkboxTestTbl");
let customerId = <?=$row[1]?>;
let step = '<?=$step?>';
let url = '../../ajax/ajax_amountlist.php';

$(document).on('click', '.dateType', function(){
  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
    closeText: '닫기'  // 닫기 버튼 패널
  })
})

$(document).ready(function(){
  $(function () {
      $('[data-toggle="tooltip"]').tooltip()
  })

  $('input[name=expecteDay]').on('click', function(){
    $(this).select();
  })

  autosize($('textarea[name=memoContent]'));

  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
    closeText: '닫기'  // 닫기 버튼 패널
  })

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
  $(document).on('change', '.tbodycheckbox', function(){
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

})//document.ready function closing}

var expectedDayArray = [];

$(":checkbox:first", tbl).click(function(){

    var allCnt = $(":checkbox:not(:first)", tbl).length;
    var table = tbl.find('tbody');
    expectedDayArray = [];


    if($(":checkbox:first", tbl).is(":checked")){
      for (var i = 0; i < allCnt; i++) {
        var expectedDayEle = [];
        var rowid = i;//system order
        var colOrder = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=order]").children('span[name=ordered]').text();//order
        var colid = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=checkbox]").children('input[name=csId]').val();//csId
        var colexpectDate = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('input[name=mExpectedDate]').val();

        expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
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

$(document).on('click', '.tbodycheckbox', function(){
  var expectedDayEle = [];

  if($(this).is(":checked")){
    var currow = $(this).closest('tr');
    var rowid = currow.find('td[name=order]').children('input[name=rowid]').val();
    rowid = Number(rowid);
    var colOrder = currow.find('td[name=order]').children('span[name=ordered]').text();
    var colid = currow.find('td[name=checkbox]').children('input[name=csId]').val();
    var colexpectDate = currow.find('td[name=detail]').find('input[name=mExpectedDate]').val();
    expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
    expectedDayArray.push(expectedDayEle);
    // console.log(expectedDayArray);
    // console.log('체크됨');
  } else {
    var currow = $(this).closest('tr');
    var colOrder = currow.find('td[name=order]').children('span[name=ordered]').text();

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

depositlist(contractId);
memolist(contractId);
filelist(contractId);
amountlist(contractId, url);

$('.table').on('keyup', '.amountNumber:input[type="text"]', function(){
  var currow = $(this).closest('table').parent().closest('tr');

  // console.log(colOrder);

  var colmAmount = Number(currow.find('td[name=detail]').find('input[name=mAmount]').val());

  var colmvAmount = Number(currow.find('td[name=detail]').find('input[name=mvAmount]').val());

  var colmtAmount = colmAmount + colmvAmount;
  currow.find('td[name=detail]').find('input[name=mtAmount]').val(colmtAmount);

  // console.log(colmAmount, colmvAmount, colmtAmount)

})

$('#groupExpecteDay').change(function(){ //입금예정일 변경버튼 이벤트
  var expectedDayGroup = $('#groupExpecteDay').val();
  var table = tbl.find('tbody');

  if(expectedDayArray.length >= 1) {
    for (var i in expectedDayArray) {
       table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find("td[name=detail]").find('input[name=mExpectedDate]').val(expectedDayGroup);
      // console.log(expectedDayArray[i][0], a);
    }
  }
})

$('#paykind').change(function(){ //입금수단 변경버튼 이벤트
  var a = $(this).val();
  var table = tbl.find('tbody');

  if(expectedDayArray.length >= 1) {
    for (var i in expectedDayArray) {
       table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find("td[name=detail]").find('select[name=payKind]').val(a).prop('selected', true);
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
    var payId = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=payId]').val(); //청구번호

    // console.log(payId);
    if(!(payId==='null')){
      alert('청구번호가 존재하여, 청구설정을 못합니다. 다시 확인해주세요.');
      return false;
    }

    // table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(7)").text(paykind);이게 왜있지? 20.11.12
    // console.log(expectedDayArray[i][0], a);
    // 입금구분을 변경시키는 것
    var payScheduleEle = [];
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=csId]').val()); //계약번호
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=order]').children('span[name=ordered]').text()); //순번
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=date]').find('span[name=mStartDate]').text()); //시작일
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=date]').find('span[name=mEndDate]').text()); //종료일
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mAmount]').val()); //공급가액
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mvAmount]').val()); //세액
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mtAmount]').val()); //합계금액
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mExpectedDate]').val()); //예정일
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('select[name=payKind]').val()); //입금구분

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
      var frm = formCreate('payScheduleAdd', 'post', 'p_payScheduleAdd0.php','');
      frm = formInput(frm, 'scheduleArray', a);
      frm = formInput(frm, 'contractId', b);
      frm = formInput(frm, 'buildingId', c);
      formSubmit(frm);
    }

  }
})//button1}


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

      var csId = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=csId]').val();

      var csOrder = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=order]').children('span[name=ordered]').text();

      var psId = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=payId]').val();

      if(psId != 'null'){
        alert('청구번호는 '+psId+' 입니다. 청구번호가 존재하면 삭제할수 없습니다.');
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

$(document).on('click', '#memoButton', function(){
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

$(document).on('click',"label[name='memoEdit']", function(){
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


$(document).on('click', 'label[name=memoDelete]', function(){

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

$(document).on('click', 'button[name=fileDelete]', function(){
    let cc = confirm('정말 삭제하시겠습니까?');

    if(cc){
        var fileid = $(this).parent().parent().children().children('input:eq(0)').val();

        var contractId = '<?=$filtered_id?>';
        var aa = 'fileDelete';
        var bb = 'p_fileDelete.php';
    
        goCategoryPage(aa,bb,contractId,fileid);
    } else {
        return false;
    }
    

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

$('#button6').click(function(){ //n개월추가 모달 안에 추가하기 버튼
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




</script>

<script src="/svc/inc/js/etc/ce_mo_f.js?<?=date('YmdHis')?>"></script>

<script>
$(document).on('click', '#mgetExecute', function(){ //in pPay modal, 입금완료버튼(모달안버튼) 클릭
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

    console.log(contractId, pid, ppayKind, pgetDate, pgetAmount, pExpectedDate);

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
})//입금완료버튼(모달안버튼) }

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
    var psId = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=payId]').val(); //청구번호
    if(psId != 'null'){
      alert('청구번호가 있는경우 즉시입금이 불가합니다. 청구번호없는 아무것도 없는 상태에서 청구와 입금처리가 동시에 되는거에요.');
      return false;
    }

    // table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(7)").text(paykind);이게왜있나??
    // console.log(expectedDayArray[i][0], a);
    // 입금구분을 변경시키는 것
    var payScheduleEle = [];
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=csId]').val()); //계약번호
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=order]').children('span[name=ordered]').text()); //순번
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=date]').find('span[name=mStartDate]').text()); //시작일
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=date]').find('span[name=mEndDate]').text()); //종료일
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mAmount]').val()); //공급가액
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mvAmount]').val()); //세액
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mtAmount]').val()); //합계금액
    payScheduleEle.push(table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=detail]').find('input[name=mExpectedDate]').val()); //예정일

    paySchedule.push(payScheduleEle);
  }

  // console.log(paySchedule);

  var paySchedule11 = JSON.stringify(paySchedule);

  var contractId = '<?=$filtered_id?>';
  var buildingId = $('input[name=building]').val();

  // console.log(paySchedule11, contractId, buildingId, paykind);
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

function taxInfo2(bid,mun,ccid) {
  var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
  $("body").append(tmps);
  //alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );

  $("#ifm_pops_21").attr("src","/svc/service/get/tax_invoice.php?building_idx="+bid+"&mun="+mun+"&id="+ccid+"&flag=expected");
  $('#ifm_pops_21').show();
  $('.pops_wrap, .pops_21').show();

}

$(document).on('click', '.taxDate', function(){
  var mun = $(this).siblings('input[name=taxMun]').val();
  var bid = $(this).siblings('input[name=buildingId]').val();
  var cid = $('input[name=customerId]').val();

  console.log(mun, bid, cid);

  taxInfo2(bid, mun, cid);
})

</script>


</body>
</script>
