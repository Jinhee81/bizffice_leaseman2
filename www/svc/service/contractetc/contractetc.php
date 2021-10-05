<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>기타계약</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include "good.php";
?>

<!-- 제목섹션 -->
<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">기타계약 목록이에요.</h3>
    <p class="lead">

    </p>
  </div>
</section>

<!-- 조회조건 섹션 -->
<section class="container">
  <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
    <form>
      <div class="row justify-content-md-center">
        <table>
          <tr>
            <td width="6%" class="mobile">
              <select class="form-control form-control-sm selectCall" name="dateDiv">
                <option value="executiveDate">입금일자</option>
                <option value="createTime">등록일자</option>
                <option value="updateTime">수정일자</option>
              </select><!--codi1-->
            </td>
            <td width="6%" class="mobile">
              <select class="form-control form-control-sm selectCall" name="periodDiv">
                <option value="allDate">--</option>
                <option value="nowMonth" selected>당월</option>
                <option value="pastMonth">전월</option>
                <option value="1pastMonth">1개월</option>
                <option value="3pastMonth">3개월</option>
                <option value="nowYear">당년</option>
              </select><!--codi2-->
            </td>
            <td width="6%" class="mobile">
              <input type="text" name="fromDate" value="" class="form-control form-control-sm text-center dateType yyyymmdd"><!--codi3-->
            </td>
            <td width="1%" class="mobile"> ~
            </td>
            <td width="6%" class="mobile">
              <input type="text" name="toDate" value="" class="form-control form-control-sm text-center dateType yyyymmdd"><!--codi4-->
            </td>
            <td width="6%" class="">
              <select class="form-control form-control-sm selectCall" name="building">
              </select><!--codi6-->
            </td>
            <td width="6%" class="">
              <select class="form-control form-control-sm selectCall" name="good">
                <option value="goodAll">상품전체</option>
              </select><!--codi7-->
            </td>
            <td width="6%" class="">
              <select class="form-control form-control-sm selectCall" name="etcCondi">
                <option value="customer">성명/사업자명</option>
                <option value="contact">연락처</option>
                <option value="contractId">계약번호</option>
              </select><!--codi8-->
            </td>
            <td width="10%" class="">
              <input type="text" name="cText" class="form-control form-control-sm text-center"><!--codi9-->
            </td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</section>

<!-- 삭제,등록,엑셀저장부분 -->
<section class="container mb-2">
  <div class="row justify-content-end mr-0">
    <a href="contractetc_add.php" role="button" class="btn btn-sm btn-primary">신규등록</a>
    <!-- <button type="button" class="btn btn-sm btn-danger mr-1" name="rowDeleteBtn">선택삭제</button> -->
    <!-- <button type="button" class="btn btn-info btn-sm" name="button" data-toggle="tooltip" data-placement="top" title="작업준비중입니다."><i class="far fa-file-excel"></i>엑셀저장</button> -->
  </div>
</section>

<!-- 표내용 -->
<section class="container">
  <table class="table table-hover table-bordered table-sm text-center" id="checkboxTestTbl">
    <thead>
      <tr class="table-secondary">
        <th class="mobile">
          <input type="checkbox" id="allselect">
        </th>
        <th class="">순번</th>
        <th class="">상품</th>
        <th class="">성명</th>
        <th class="">연락처</th>
        <th class="mobile">공급가액</th>
        <th class="mobile">세액</th>
        <th class="">합계</th>
        <th class="">입금일</th>
        <th class="mobile">입금구분</th>
        <th class="mobile">특이사항</th>
      </tr>
    </thead>
    <tbody id="allVals">

    </tbody>
  </table>
</section>

<!-- sql -->
<!-- <section class="container" id="allVals2">

</section> -->

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>


<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/etc/newdate8.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/checkboxtable.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  var goodBuildingArray = <?php echo json_encode($goodBuildingArray); ?>;
  console.log(buildingArray);
  console.log(goodBuildingArray);
</script>
<script type="text/javascript" src="js_building_good.js">
</script>

<script>

function maketable(){

  var mtable = $.ajax({
    url: 'ajax_etcContract_value.php',
    method: 'post',
    data: $('form').serialize(),
    success: function(data){
      data = JSON.parse(data);
      datacount = data.length;

      var returns = '';

      if(datacount===0){
        returns ="<tr><td colspan='11'>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요!</td></tr>";
      } else {
        $.each(data, function(key, value){
          returns += '<tr>';
          returns += '<td class="mobile"><input type="checkbox" name="eid" value="'+value.eid+'" class="tbodycheckbox"></td>';
          returns += '<td class="">'+datacount+'</td>';
          returns += '<td class="">'+value.goodname+'</td>';
          returns += '<td class=""><a href="/svc/service/customer/m_c_edit.php?id='+value.cid+'" data-toggle="tooltip" data-placement="top" title="'+value.cname+'">'+value.cnamemb+'</a></td>';
          returns += '<td class=""><a href="tel:'+value.contact+'">'+value.contact+'</a></td>';
          returns += '<td class="mobile">'+value.pAmount+'</td>';
          returns += '<td class="mobile">'+value.pvAmount+'</td>';
          returns += '<td class=""><a href="contractetc_edit.php?id='+value.eid+'" class=green>'+value.ptAmount+'</a></td>';
          returns += '<td class="">'+value.executiveDate+'</td>';
          returns += '<td class="mobile">'+value.payKind+'</td>';
          returns += '<td class="mobile"><label class="" data-toggle="tooltip" data-placement="top" data-title="'+value.eetc+'">'+value.etcmb+'</td>';
          returns += '</tr>';

          datacount -= 1;
        }) //each closing}
      }//if..else.. closing}
      $('#allVals').html(returns);
    } //ajax success part closing}
  }) //ajax closing}

  return mtable;

}//maketable function closing}

function msql(){
  var msqlajax = $.ajax({
    url: 'ajax_etcContract_sql2.php',
    method: 'post',
    data: $('form').serialize(),
    success: function(data){
      $('#allVals2').html(data);
    }
  });

  return msqlajax;
}




$(document).ready(function(){

  $(function () {
      $('[data-toggle="tooltip"]').tooltip()
  })

  var periodDiv = $('select[name=periodDiv]').val();
  dateinput2(periodDiv);

  maketable();
  msql();


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


}) //==================document.ready function end and the other load start!

$('select[name=dateDiv]').on('change', function(){
    maketable();
    msql();
})

$('select[name=periodDiv]').on('change', function(){
    var periodDiv = $('select[name=periodDiv]').val();
    dateinput2(periodDiv);
    maketable();
    msql();
})

$('input[name=fromDate]').on('change', function(){
    maketable();
    msql();
})

$('input[name=toDate]').on('change', function(){
    maketable();
    msql();
})

$('select[name=building]').on('change', function(){
    maketable();
    msql();
})

$('select[name=good]').on('change', function(){
    maketable();
    msql();
})


$('input[name=cText]').on('keyup', function(){
    maketable();
    msql();
})
//---------조회버튼클릭평션 end and contractArray 펑션 시작--------------//

var contractArray = [];

$(document).on('change', '#allselect', function(){

    var allCnt = $(".tbodycheckbox", table).length;
    contractArray = [];

    if($("#allselect").is(":checked")){
      for (var i = 1; i <= allCnt; i++) {
        var contractArrayEle = [];
        var colOrder = table.find("tr:eq("+i+")").find("td:eq(1)").text().trim();
        var colid = table.find("tr:eq("+i+")").find("td:eq(0)").children('input[name=eid]').val();
        contractArrayEle.push(colOrder, colid);
        contractArray.push(contractArrayEle);
      }
    } else {
      contractArray = [];
    }
  console.log(contractArray);
})

$(document).on('change', '.tbodycheckbox', function(){
    var contractArrayEle = [];

    if($(this).is(":checked")){
      var currow = $(this).closest('tr');
      var colOrder = Number(currow.find('td:eq(1)').text());
      var colid = currow.find('td:eq(0)').children('input[name=eid]').val();
      contractArrayEle.push(colOrder, colid);
      contractArray.push(contractArrayEle);
    } else {
      var currow = $(this).closest('tr');
      var colOrder = Number(currow.find('td:eq(1)').text());

      for (var i = 0; i < contractArray.length; i++) {
        if(contractArray[i][0]===colOrder){
          var index = i;
          break;
        }
      }
      contractArray.splice(index, 1);
    }
    console.log(contractArray);
    // console.log(typeof(contractArray[3]));
})



//---------contractArray펑션 end 삭제버튼펑션 시작--------------//

$('button[name=rowDeleteBtn]').on('click', function(){
  if(contractArray.length === 0){
    alert('1개 이상을 선택하여 주세요.');
    return false;
  }

  var cc = JSON.stringify(contractArray);

  goCategoryPage(cc);

  function goCategoryPage(a){
    var frm = formCreate('etcContractDelete', 'post', 'p_etcContract_delete.php','');
    frm = formInput(frm, 'contractArray', a);
    formSubmit(frm);
  }
})
</script>

</body>
</html>
