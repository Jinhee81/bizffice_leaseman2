<!-- 계약리스트화면에서 등록버튼누르면 나오는 거 -->
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "good.php";

?>

<!-- 제목섹션 -->
<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h2 class="">기타계약 등록 화면입니다!</h2>
    <!-- <p class="lead">고객이란 입주한 세입자 및 문의하는 문의고객, 거래처 등을 포함합니다. 고객등록이 되어야 임대계약 등록이 가능합니다!</p> -->
    <!-- <small>(1)<span id='star' style='color:#F7BE81;'> * </span>표시는 필수 입력값입니다. (2)<b>[세입자정보]</b>에는 세입자만 등록 가능합니다. (거래처 및 문의고객은 검색결과가 없다고 표시되니 주의하세요!) <b>[세입자정보]</b>의 제일우측 숫자는 고객번호로써 시스템데이터임을 참고하여주세요. (3)<b>[기간정보]</b>의 기간(개월수)에는 최대 72개월(6년)까지 등록 가능합니다.</small> -->
    <hr class="my-4">
    <a class="btn btn-primary btn-sm" href="/svc/service/customer/m_c_add.php" role="button">성명등록</a>
    <a class="btn btn-primary btn-sm" href="/svc/service/setting/building.php" role="button">상품추가</a>
  </div>
</section>

<!-- 입력폼 섹션 -->
<section class="container" style="width:900px;">
  <form method="post" action="p_etcContract_add.php">
    <div class="form-row">
        <div class="form-group col-md-2">
              <label><b>[성명]</b></label>
        </div>
        <div class="form-group col-md-10 inputWithIcon">
              <input type="search" class="form-control" name="customer" id="customer" value="" required>
              <i class="fas fa-search fa-lg fa-fw" aria-hidden="true"></i>
              <div class="" id="customerList">
              </div>
              <input type="hidden" name="customer" id="customerId" value="">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label><b>[물건,금액]</b></label>
        </div>
        <div class="form-group col-md-10" id="mulgunInfo">
              <div class="form-row">
                <div class="form-group col-md-3"><!--물건목록-->
                    <label>물건명</label>
                    <select name="building" class="form-control">
                    </select>
                </div>
                <div class="form-group col-md-2"><!--그룹목록-->
                    <label>상품명</label>
                    <select name="good" class="form-control" required>
                    </select>
                </div>
                <div class="form-group col-md-2 mb-0">
                      <label><span id='star' style='color:#F7BE81;'>* </span>공급가액</label>
                      <input type="text" class="form-control text-right amountNumber" name="pAmount" value="0" numberOnly required>
                </div>
                <div class="form-group col-md-2 mb-0">
                      <label>세액</label>
                      <input type="text" class="form-control text-right amountNumber" name="pvAmount" value="0" numberOnly required>
                </div>
                <div class="form-group col-md-3 mb-0">
                      <label>합계</label>
                      <input type="text" class="form-control text-right amountNumber" name="ptAmount" value="0" numberOnly readonly>
                </div>
              </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2 mb-0">
            <label><b>[날짜]</b></label>
        </div>
        <div class="form-group col-md-10 mb-0">
          <div class="form-row">
              <div class="form-group col-md-2 mb-10">
                    <label><span id='star' style='color:#F7BE81;'>* </span>입금일자</label>
                    <input type="text" class="form-control dateType yyyymmdd" name="executiveDate" value="" placeholder="" required>
              </div>
              <div class="form-group col-md-2 mb-10">
                    <label>입금구분</label>
                    <select class="form-control" name="payKind">
                      <option value="계좌">계좌</option>
                      <option value="현금">현금</option>
                      <option value="카드">카드</option>
                    </select>
              </div>
              <div class="form-group col-md-4 mb-0">
                    <label>시작일시</label>
                    <input type="text" class="form-control timeType" name="startTime" value="" placeholder="">
              </div>
              <div class="form-group col-md-4 mb-0">
                    <label>종료일시</label>
                    <input type="text" class="form-control timeType" name="endTime">
              </div>
        </div>
      </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2 mb-0">
            <label><b>[특이사항]</b></label>
        </div>
        <div class="form-group col-md-10 mb-0">
          <input type="text" class="form-control" name="etc">
      </div>
    </div>


    <div class="mt-3">
      <button type='submit' class='btn btn-primary' id='saveBtn'>저장</button>
      <a href='contractetc.php'><button type='button' class='btn btn-secondary'>취소</button></a>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>


<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>

<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  var goodBuildingArray = <?php echo json_encode($goodBuildingArray); ?>;
  console.log(buildingArray);
  console.log(goodBuildingArray);
</script>


<script>
var customerId, buildingId, buidlingName;

function customersearch(){
  var query = $('#customer').val();
  // console.log(query);
  var customerlist;

  customerlist = $.ajax({
    url: 'ajax_customer_search2.php',
    method: 'post',
    data: {query : query},
    success: function(data){
      data = JSON.parse(data);
      datacount = data.length;

      var returns = '';
      var buildingoption = '';
      //
      if(datacount===0){
        returns ="<ul><li>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요.</li></ul>";
      } else {
        returns += '<ul class="list-unstyled">';
        $.each(data, function(key, value){
          returns += '<li>'+value.ccnn;
          returns += '<input type="hidden" name="customerId" value="'+value.cid+'">';
          returns += '<input type="hidden" name="buildingId" value="'+value.bid+'">';
          returns += '<input type="hidden" name="buildingName" value="'+value.bName+'"></li>';
        })
        returns += '</ul>';
      }

      $('#customerList').fadeIn();
      $('#customerList').html(returns);
    }//success}
  })
  return customerlist;
}

$(document).ready(function(){
  // $('#customer').keyup(function(){
  // })

  $('#customer').on('click keyup', function(){
    customersearch();
  })

  $('.timeType').datetimepicker({
    dateFormat:'yy-m-d',
    monthNamesShort:[ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
    dayNamesMin:[ '일', '월', '화', '수', '목', '금', '토' ],
    changeMonth:true,
    changeYear:true,
    showMonthAfterYear:true,
    timeFormat: 'HH:mm:ss',
    controlType: 'select',
    oneLine: true
  })

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
})

$(document).on('click', 'li', function(){
  $('#customer').val($(this).text());
  $('#customerList').fadeOut();

  var a = $(this);
  var customerId = a.children('input[name=customerId]').val();
  var buildingIdx = a.children('input[name=buildingId]').val();
  var buildingName = a.children('input[name=buildingName]').val();

  console.log(customerId, buildingIdx, buildingName);
  var buildingoption = '<option value="'+buildingIdx+'">'+buildingName+'</option>';
  var goodoption;


  $('#customerId').val(customerId);
  $('select[name=building]').html(buildingoption);

  for(var key2 in goodBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    goodoption = "<option value='"+key2+"'>"+goodBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(groupoption);
    $('select[name=good]').append(goodoption);
  }
})

$("input[name='pAmount']").on('keyup', function(){
  var amount1 = Number($(this).val());
  var amount2 = Number($("input[name='pvAmount']").val());
  var amount12 = amount1 + amount2;
  $("input[name='ptAmount']").val(amount12);
})

$("input[name='pvAmount']").on('keyup', function(){
  var amount1 = Number($("input[name='pAmount']").val());
  var amount2 = Number($(this).val());
  var amount12 = amount1 + amount2;
  $("input[name='ptAmount']").val(amount12);
})

$('#saveBtn').on('click', function(){
  var amount1 = Number($("input[name='pAmount']").val());
  var amount2 = Number($("input[name='pvAmount']").val());
  var amount12 = amount1 + amount2;
  $("input[name='ptAmount']").val(amount12);

  if(amount1 === 0){
    alert('공급가액은 0보다 커야 저장됩니다.');
    return false;
  }
})

</script>

</body>
</html>
