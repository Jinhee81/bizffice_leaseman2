<!-- 고객리스트에서 기타계약버튼 클릭하면 나오는 화면 그래서 get이 있다 -->
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "good.php";

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


<!-- 제목섹션 -->
<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">기타계약 등록 화면입니다!</h3>
    <!-- <p class="lead">고객이란 입주한 세입자 및 문의하는 문의고객, 거래처 등을 포함합니다. 고객등록이 되어야 임대계약 등록이 가능합니다!</p> -->
    <!-- <small>(1)<span id='star' style='color:#F7BE81;'> * </span>표시는 필수 입력값입니다. (2)<b>[세입자정보]</b>에는 세입자만 등록 가능합니다. (거래처 및 문의고객은 검색결과가 없다고 표시되니 주의하세요!) <b>[세입자정보]</b>의 제일우측 숫자는 고객번호로써 시스템데이터임을 참고하여주세요. (3)<b>[기간정보]</b>의 기간(개월수)에는 최대 72개월(6년)까지 등록 가능합니다.</small> -->
    <hr class="my-4">
    <a class="btn btn-primary btn-sm" href="/service/customer/m_c_add.php" role="button">성명등록</a>
    <a class="btn btn-primary btn-sm" href="/service/setting/building.php" role="button">상품추가</a>
  </div>
</section>

<!-- 입력폼 섹션 -->
<section class="container">
  <form method="post" action="p_etcContract_add.php">
    <div class="form-row">
        <div class="form-group col-md-2">
              <label><b>[성명]</b></label>
        </div>
        <div class="form-group col-md-10 inputWithIcon">
              <input type="text" class="form-control" name="customer" id="customer" value="<?=$output?>" disabled>
              <input type="hidden" name="customer" value="<?=$clist['id']?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label><b>[물건,금액]</b></label>
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
                    <label>상품명</label>
                    <select name="good" class="form-control">
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
                <div class="form-group col-md-2 mb-0">
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

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  var goodBuildingArray = <?php echo json_encode($goodBuildingArray); ?>;
  console.log(buildingArray);
  console.log(goodBuildingArray);

  //이거는 계약등록하는 화면에서 필요한 js파일, 헷깔리지 말것 (building.js랑 비슷한데 내용이 더 많음)

  var goodoption, buildingIdx, goodIdx;

  buildingIdx = $('select[name=building]').val();

  // console.log(buildingArray[buildingIdx][1]);


  for(var key2 in goodBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    goodoption = "<option value='"+key2+"'>"+goodBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(groupoption);
    $('select[name=good]').append(goodoption);
  }
  goodIdx = $('select[name=good]').val();

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

  $('.timeType').datetimepicker({
    dateFormat:'yy-mm-dd',
    monthNamesShort:[ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
    dayNamesMin:[ '일', '월', '화', '수', '목', '금', '토' ],
    changeMonth:true,
    changeYear:true,
    showMonthAfterYear:true,

    timeFormat: 'HH:mm:ss',
    controlType: 'select',
    oneLine: true
  })

  $('.amountNumber').on('click keyup', function(){
    $(this).select();
  })

  $("input:text[numberOnly]").number(true);
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
