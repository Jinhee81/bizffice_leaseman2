<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>월별회계조회</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/account/flexCost/yearMonth.php";
?>
<!-- <style>
        #modalTable tr.selected{background-color: #A9D0F5;}
        #checkboxTestTbl tr.selected{background-color: #A9D0F5;}
        select .selectCall{background-color: #A9D0F5;}

        @media (max-width: 990px) {
        .mobile {
          display: none;
        }
}
</style> -->
<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h2 class="">월별회계조회 화면입니다!</h1>
    <p class="lead">
      <!-- (1) 상태(진행 - 현재 계약 진행 중), (대기 - 곧 계약시작임), (종료 - 종료된 계약)로 구분합니다.<br>
      (2) 월이용료를 클릭하면 해당 계약의 상세페이지가 나옵니다.<br>
      (3) 단계는 (clear-계약을 입력하자마자), (청구- 언제돈입금예정인지 설정), 입금(이용료(임대료)가 입금되고있는 상태)로 구분됩니다. -->
    </p>
  </div>
</section>


<section class="container"><!--조회조건 섹<-->
  <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
      <form name="building">
        <div class="form-group row justify-content-md-center">
            <div class="col-sm-2 pl-0 pr-1">
              <select class="form-control form-control-sm selectCall" name="building">
              </select><!---->
            </div>
            <div class="col-sm-2 pl-0 pr-1">
              <select class="form-control form-control-sm selectCall" name="year">
                <option value="<?=$yearArray[0]?>">
                  <?=$yearArray[0].'년'?>
                </option>
                <option value="<?=$yearArray[1]?>">
                  <?=$yearArray[1].'년'?>
                </option>
                <option value="<?=$yearArray[2]?>" selected>
                  <?=$yearArray[2].'년'?>
                </option>
                <option value="<?=$yearArray[3]?>">
                  <?=$yearArray[3].'년'?>
                </option>
              </select><!---->
            </div>
            <div class="col-sm-2 pl-0 pr-1">
              <select class="form-control form-control-sm selectCall" name="month">
                <option value="1"<?php if($currentMonth=="1"){echo "selected";}?>>1월</option>
                <option value="2"<?php if($currentMonth=="2"){echo "selected";}?>>2월</option>
                <option value="3"<?php if($currentMonth=="3"){echo "selected";}?>>3월</option>
                <option value="4"<?php if($currentMonth=="4"){echo "selected";}?>>4월</option>
                <option value="5"<?php if($currentMonth=="5"){echo "selected";}?>>5월</option>
                <option value="6"<?php if($currentMonth=="6"){echo "selected";}?>>6월</option>
                <option value="7"<?php if($currentMonth=="7"){echo "selected";}?>>7월</option>
                <option value="8"<?php if($currentMonth=="8"){echo "selected";}?>>8월</option>
                <option value="9"<?php if($currentMonth=="9"){echo "selected";}?>>9월</option>
                <option value="10"<?php if($currentMonth=="10"){echo "selected";}?>>10월</option>
                <option value="11"<?php if($currentMonth=="11"){echo "selected";}?>>11월</option>
                <option value="12"<?php if($currentMonth=="12"){echo "selected";}?>>12월</option>
              </select><!---->
            </div>
        </div>
      </form>
  </div>
</section><!--조회조건 섹션 end-->
<section class="container">
  <div class="row">
    <div class="col">
      <h3 class="text-center" id="href_sell" style="color:#819FF7;"># <u>매출액 전체</u></h3>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr class="table-warning">
            <td width="10%">건수</td>
            <td width="30%">금액</td>
            <td width="30%">공급가액</td>
            <td width="30%">세액</td>
          </tr>
        </thead>
        <tbody id="leftTotal">

        </tbody>
      </table>
      <h5 class="text-center">임대계약</h5>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr>
            <td>순번</td>
            <td>그룹</td>
            <td>건수</td>
            <td>금액</td>
            <td>공급가액</td>
            <td>세액</td>
          </tr>
        </thead>
        <tbody id="tbody1">

        </tbody>
      </table>
      <h5 class="text-center">기타계약</h5>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr>
            <td>순번</td>
            <td>상품명</td>
            <td>건수</td>
            <td>금액</td>
            <td>공급가액</td>
            <td>세액</td>
          </tr>
        </thead>
        <tbody id="tbody2">

        </tbody>
      </table>
    </div>
    <div class="col">
      <!-- <h3 style="background-color:#;" class="pt-2 pb-2 pl-1"># 매입액</h3> -->
      <h3 class="text-center" id="href_cost" style="color:#819FF7;"># <u>매입액 전체</u></h3>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr class="table-warning">
            <td width="10%">건수</td>
            <td width="30%">금액</td>
            <td width="30%">공급가액</td>
            <td width="30%">세액</td>
          </tr>
        </thead>
        <tbody id="rightTotal">

        </tbody>
      </table>
      <h5 class="text-center">고정비</h5>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr>
            <td width="10%">건수</td>
            <td width="30%">금액</td>
            <td width="30%">공급가액</td>
            <td width="30%">세액</td>
          </tr>
        </thead>
        <tbody id="tbody3">

        </tbody>
      </table>
      <h5 class="text-center">변동비</h5>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr>
            <td width="10%">건수</td>
            <td width="30%">금액</td>
            <td width="30%">공급가액</td>
            <td width="30%">세액</td>
          </tr>
        </thead>
        <tbody id="tbody4">

        </tbody>
      </table>
      <h3 class="text-center" id="calcurate" style="color:#819FF7;"># <u>매출액 대비 매입액 산출</u></h3>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr class="table-warning">
            <td width="10%">건수</td>
            <td width="30%">금액</td>
            <td width="30%">공급가액</td>
            <td width="30%">세액</td>
          </tr>
        </thead>
        <tbody id="bottomArea">
          <tr class="table-warning">
            <td id="bottomArea1"></td>
            <td id="bottomArea2"></td>
            <td id="bottomArea3"></td>
            <td id="bottomArea4"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col">

    </div>
    <div class="col">
      <!-- <h3 class="text-center" id="calcurate" style="color:#819FF7;"># <u>매출액 대비 매입액 산출</u></h3>
      <table class="table table-bordered table-sm text-center">
        <thead>
          <tr class="table-warning">
            <td width="10%">건수</td>
            <td width="30%">금액</td>
            <td width="30%">공급가액</td>
            <td width="30%">세액</td>
          </tr>
        </thead>
        <tbody id="bottomArea">
          <tr class="table-warning">
            <td id="bottomArea1"></td>
            <td id="bottomArea2"></td>
            <td id="bottomArea3"></td>
            <td id="bottomArea4"></td>
          </tr>
        </tbody>
      </table> -->
    </div>
  </div>
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
</script>
<script src="/svc/inc/js/etc/building.js?<?=date('YmdHis')?>"></script>

<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

<script>
// var select1option;

// for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
//   select1option = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
//   $('select[name=building]').append(select1option);//문서위건물목록
// }
//---- ^ 건물출력 ^------//

var buildingIdx = $('select[name=building]').val();
var building = $('select[name=building] :selected').text();
var year = $('select[name=year]').val();
var month = $('select[name=month]').val();
//---- ^ buildingIdx 전역변수 선언 ^------//


$(document).ready(function(){
      $.ajax({
        url: 'ajax_12.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#leftTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_1.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody1').html(data);
        }
      })

      $.ajax({
        url: 'ajax_2.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody2').html(data);
        }
      })

      $.ajax({
        url: 'ajax_34.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#rightTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_3.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody3').html(data);
        }
      })

      $.ajax({
        url: 'ajax_4.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody4').html(data);
        }
      })
})//------------ ^ document.ready ^------//

$('select[name=building]').on('change', function(){
      var buildingIdx = $('select[name=building]').val();
      var building = $('select[name=building] :selected').text();
      var year = $('select[name=year]').val();
      var month = $('select[name=month]').val();

      $.ajax({
        url: 'ajax_12.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#leftTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_1.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody1').html(data);
        }
      })

      $.ajax({
        url: 'ajax_2.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody2').html(data);
        }
      })

      $.ajax({
        url: 'ajax_34.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#rightTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_3.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody3').html(data);
        }
      })

      $.ajax({
        url: 'ajax_4.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody4').html(data);
        }
      })
})//------------ ^ building change function ^------//


$('select[name=year]').on('change', function(){
      var buildingIdx = $('select[name=building]').val();
      var building = $('select[name=building] :selected').text();
      var year = $('select[name=year]').val();
      var month = $('select[name=month]').val();

      $.ajax({
        url: 'ajax_12.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#leftTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_1.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody1').html(data);
        }
      })

      $.ajax({
        url: 'ajax_2.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody2').html(data);
        }
      })

      $.ajax({
        url: 'ajax_34.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#rightTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_3.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody3').html(data);
        }
      })

      $.ajax({
        url: 'ajax_4.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody4').html(data);
        }
      })
})//------------ ^ year change function ^------//

$('select[name=month]').on('change', function(){
      var buildingIdx = $('select[name=building]').val();
      var building = $('select[name=building] :selected').text();
      var year = $('select[name=year]').val();
      var month = $('select[name=month]').val();

      $.ajax({
        url: 'ajax_12.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#leftTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_1.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody1').html(data);
        }
      })

      $.ajax({
        url: 'ajax_2.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody2').html(data);
        }
      })

      $.ajax({
        url: 'ajax_34.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#rightTotal').html(data);
        }
      })

      $.ajax({
        url: 'ajax_3.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody3').html(data);
        }
      })

      $.ajax({
        url: 'ajax_4.php',
        method: 'post',
        data: {buildingIdx:buildingIdx, year:year, month:month},
        success: function(data){
          $('#tbody4').html(data);
        }
      })
})//------------ ^ year change function ^------//



$('#href_cost').on('click', function(){
  var newWindow = window.open("about:blank");
  newWindow.location.href='/service/account/flexcost/flexcost1.php?buildingIdx='+buildingIdx+'&building='+building+'&year='+year+'&month='+month;
})

$('#href_sell').on('click', function(){
  var newWindow = window.open("about:blank");
  newWindow.location.href='/service/get/getfinished.php';
})

$('#calcurate').on('click', function(){
  var leftArea1 = $('#leftArea1').text();
  var leftArea2 = $('#leftArea2').text();
  var leftArea3 = $('#leftArea3').text();
  var leftArea4 = $('#leftArea4').text();

  var rightArea1 = $('#rightArea1').text();
  var rightArea2 = $('#rightArea2').text();
  var rightArea3 = $('#rightArea3').text();
  var rightArea4 = $('#rightArea4').text();

  var bottomArea1 = Number(leftArea1) - Number(rightArea1);
  var bottomArea2 = parseFloat(leftArea2.replace(/,/g,'')) - parseFloat(rightArea2.replace(/,/g,''));
  var bottomArea3 = parseFloat(leftArea3.replace(/,/g,'')) - parseFloat(rightArea3.replace(/,/g,''));
  var bottomArea4 = parseFloat(leftArea4.replace(/,/g,'')) - parseFloat(rightArea4.replace(/,/g,''));

  Number.prototype.format = function(){
    if(this==0) return 0;

  	var reg = /(^[+-]?\d+)(\d{3})/;
  	var n = (this + '');

  	while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

  	return n;
  };

  $('#bottomArea1').text(bottomArea1);
  $('#bottomArea2').text(bottomArea2.format());
  $('#bottomArea3').text(bottomArea3.format());
  $('#bottomArea4').text(bottomArea4.format());


})


</script>


<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
