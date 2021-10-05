<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>일괄계약등록</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "building.php";
?>

<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">계약일괄등록 화면입니다!</h3>
    <p class="lead">이 화면에서는 그룹별 방계약을 등록합니다.</p>
    <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)공실일 경우는 행삭제를 하여 없애주세요.</small>
    <hr class="my-4">
    <!-- <a class="btn btn-primary btn-sm" href="contractAll2.php" role="button">일괄계약등록(2)</a> -->
    <a class="btn btn-primary btn-sm" href="contractCsv.php" role="button">대량등록(csv등록)</a>
  </div>
</section>

<section class="container-fluid">
      <div class="container form-row justify-content-center">
          <div class="form-group col-md-2 text-center">
              <label for="">물건명</label>
          </div>
          <div class="form-group col-md-2">
              <select class="form-control form-control-sm" name="building">
              </select>
          </div>
          <div class="form-group col-md-2 text-center">
              <label for="">그룹명</label>
          </div>
          <div class="form-group col-md-2">
              <select class="form-control form-control-sm" name="group">
              </select>
          </div>
          <!-- <div class="form-group col-md-2">
              <button type="button" name="" class="btn btn-info btn-block btn-sm">생성하기
              </button>
          </div> -->
      </div>

      <div class="">
        <table class='table table-bordered text-center' id="table1">

        </table>
      </div>

      <div class="bolowButtons text-center">
        <button type='button' class='btn btn-primary' id='saveBtn'>저장</button>
        <a href='contract.php'><button type='button' class='btn btn-secondary'><i class="fas fa-angle-double-right"></i> 계약목록</button></a>
      </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
  var roomArray = <?php echo json_encode($roomArray); ?>;
  console.log(buildingArray);
  console.log(groupBuildingArray);
  console.log(roomArray);
</script>

<script>

var buildingoption, groupoption, buildingIdx, groupIdx;

for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
    buildingoption = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
    $('select[name=building]').append(buildingoption);
}
buildingIdx = $('select[name=building]').val();

for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    groupoption = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(select3option);
    $('select[name=group]').append(groupoption);
}
groupIdx = $('select[name=group]').val();

var tableTitle = "<tr><td>관리번호</td><td><span id='star' style='color:#F7BE81;'>* </span>입주자</td><td>계약일자</td><td><span id='star' style='color:#F7BE81;'>* </span>공급가액/세액</td><td><span id='star' style='color:#F7BE81;'>* </span>기간</td><td><span id='star' style='color:#F7BE81;'>* </span>시작일(종료일)</td><td>보증금</td><td>보증금입금일</td></tr>";

$('#table1').append(tableTitle);

var tableCol2 ="<td><input type='search' name='customer' class='form-control form-control-sm text-center' required><input type='hidden' name='customerId2'><input type='hidden' name='buildingPay2'><div class='' name='customerList'></div></td>"; //고객정보

var tableCol3 ="<td><input type='text' name='contractDate' class='form-control form-control-sm text-center dateType yyyymmdd'  maxlength=10></td>"; //계약일자

var tableCol4 ="<td><input type='text' class='form-control form-control-sm text-right amountNumber' value='0' numberOnly><input type='text' class='form-control form-control-sm text-right amountNumber' value='0' numberOnly><input type='text' class='form-control form-control-sm text-right amountNumber' value='0' disabled numberOnly></td>"; //공급가액/세액/합계

var tableCol5 ="<td><input type='number' class='form-control form-control-sm text-center' value='12' min='1' max='72' name='monthCount'></td>"; //기간

var tableCol6 ="<td><input type='text' class='form-control form-control-sm text-center dateType yyyymmdd' name='startDate'  maxlength=10><input type='text' class='form-control form-control-sm text-center dateType' name='endDate' disabled></td>"; //시작일(종료일)

var tableCol7 ="<td><input type='text' class='form-control form-control-sm text-center amountNumber' value='0' numberOnly></td>"; //보증금

var tableCol8 ="<td><input type='text' class='form-control form-control-sm text-center dateType yyyymmdd' maxlength=10 name='depositInDate'></td></tr>"; //보증금입금일자


for(var key in roomArray[groupIdx]){

    // customerSearch();
    // console.log('solmi');

    var tableCol1 = "<tr><td><input type='hidden' value='"+key+"'><input type='text' class='form-control form-control-sm text-center' value='"+roomArray[groupIdx][key]+"' disabled></td>";

    var tableRow = tableCol1 + tableCol2 + tableCol3 + tableCol4 + tableCol5 + tableCol6 + tableCol7 + tableCol8;

    $('#table1').append(tableRow);//관리호수

}



$(document).ready(function(){
  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    // showOn: "button",
    buttonImage: "/img/calendar.svg",
    buttonImageOnly: false
  });

  $(".amountNumber").on('click keyup', function(){
    $(this).select();
  });

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
}) //document.ready function closing}




    $('select[name=building]').on('change', function(){
        // console.log('solmi');
        buildingIdx = $('select[name=building]').val();
        $('select[name=group]').empty();
        for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
          groupoption = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
          // console.log(select3option);
          $('select[name=group]').append(groupoption);
        }
        groupIdx = $('select[name=group]').val();

        $('#table1').empty();
        $('#table1').append(tableTitle);
        for(var key in roomArray[groupIdx]){

            // customerSearch();

            var tableCol1 = "<tr><td><input type='hidden' value='"+key+"'><input type='text' class='form-control form-control-sm text-center' value='"+roomArray[groupIdx][key]+"' disabled></td>";

            var tableRow = tableCol1 + tableCol2 + tableCol3 + tableCol4 + tableCol5 + tableCol6 + tableCol7 + tableCol8;

            $('#table1').append(tableRow);//관리호수

        }


        $('.dateType').datepicker({
          changeMonth: true,
          changeYear: true,
          showButtonPanel: true,
          // showOn: "button",
          buttonImage: "/img/calendar.svg",
          buttonImageOnly: false
        });

        $(".amountNumber").click(function(){
          $(this).select();
        });

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

    $('select[name=group]').on('change', function(event){
        groupIdx = $('select[name=group]').val();
        $('#table1').empty();
        $('#table1').append(tableTitle);
        for(var key in roomArray[groupIdx]){

            // customerSearch();

            var tableCol1 = "<tr><td><input type='hidden' value='"+key+"'><input type='text' class='form-control form-control-sm text-center' value='"+roomArray[groupIdx][key]+"' disabled></td>";

            var tableRow = tableCol1 + tableCol2 + tableCol3 + tableCol4 + tableCol5 + tableCol6 + tableCol7 + tableCol8;

            $('#table1').append(tableRow);//관리호수


        }

        $('.dateType').datepicker({
          changeMonth: true,
          changeYear: true,
          showButtonPanel: true,
          // showOn: "button",
          buttonImage: "/img/calendar.svg",
          buttonImageOnly: false
        });

        $(".amountNumber").click(function(){
          $(this).select();
        });

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


    $('.table').on('keyup', 'input[type="search"]', function(){
      var currow = $(this).closest('tr');

      var query = $(this).val();
      var building = $('select[name=building]').val();
      // console.log(query);
      if(query != ''){
        $.ajax({
                url: 'ajax_customer_search.php',
                method: 'post',
                data: {query : query, 'building':building},
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
                      returns += '<input type="hidden" name="buildingName" value="'+value.bName+'">';
                      returns += '<input type="hidden" name="buildingPay" value="'+value.pay+'"></li>';
                    })
                    returns += '</ul>';
                  }
                  currow.find('div[name="customerList"]').fadeIn();
                  currow.find('div[name="customerList"]').html(returns);
                }//success}
              })
      }
  })

  $(document).on('click', 'li', function(){
      var currow = $(this).closest('tr');

      currow.find('input[name="customer"]').val($(this).text());
      currow.find('div[name="customerList"]').fadeOut();

      var a = $(this);
      var customerId = a.children('input[name=customerId]').val();
      var buildingPay = a.children('input[name=buildingPay]').val();

      currow.find('input[name="customerId2"]').val(customerId);
      currow.find('input[name="buildingPay2"]').val(buildingPay);
  })

$('.table').on('keyup', '.amountNumber:input[type="text"]', function(){
  // console.log('hello');
  var currow = $(this).closest('tr');

  var colmAmount = Number(currow.find('td:eq(3)').children('input:eq(0)').val());
  var colmvAmount = Number(currow.find('td:eq(3)').children('input:eq(1)').val());

  var colmtAmount = colmAmount + colmvAmount;
  currow.find('td:eq(3)').children('input:eq(2)').val(colmtAmount);
  // console.log(colmAmount);

  $("input:text[numberOnly]").number(true);
})

function dateFormat(x){
    var yyyy = x.getFullYear().toString();
    var mm = (x.getMonth()+1).toString();
    var dd = x.getDate().toString();
    var dateee = yyyy+'-'+mm+'-'+dd;
    return dateee;
}

$('.table').on('change', 'input[name="contractDate"]', function(){
  // console.log('hellostartdate');
    var contractDate = $(this).val();
    var currow = $(this).closest('tr');
    currow.find('td:eq(5)').children('input:eq(0)').val(contractDate);
    currow.find('td:eq(7)').children('input:eq(0)').val(contractDate);

    var monthCount = Number(currow.find('td:eq(4)').children('input').val());

    var arr1 = contractDate.split('-');
    var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
    var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

    currow.find('td:eq(5)').children('input:eq(1)').val(dateFormat(eDate));
})


$('.table').on('change', 'input[name="startDate"]', function(){
  // console.log('hellostartdate');
  var startDate = $(this).val();
  var currow = $(this).closest('tr');
  var monthCount = Number(currow.find('td:eq(4)').children('input').val());

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  currow.find('td:eq(5)').children('input:eq(1)').val(dateFormat(eDate));
})

$('.table').on('change', 'input[name="monthCount"]', function(){
  // console.log('hellostartdate');
  var monthCount = Number($(this).val());
  var currow = $(this).closest('tr');
  var startDate = currow.find('td:eq(5)').children('input:eq(0)').val();

  var arr1 = startDate.split('-');
  var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
  var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + monthCount, sDate.getDate()-1);

  currow.find('td:eq(5)').children('input:eq(1)').val(dateFormat(eDate));
})

$('#saveBtn').on('click', function(){
  var allCnt = Number($('#table1 input[type="search"]').length);
  console.log(allCnt);
  var allArray = [];

  for (var i = 1; i <= allCnt; i++) {
    var currow = $('tr').eq(i);
    var curArray = [];
    var col1 = currow.find('td:eq(0)').children('input:eq(1)').val();//관리호수
    var col11 = currow.find('td:eq(0)').children('input:eq(0)').val();//관리호수 idx
    var col2 = currow.find('td:eq(1)').children('input').val();//고객정보
    var col21 = currow.find('td:eq(1)').children('input[name=customerId2]').val();
    var col22 = currow.find('td:eq(1)').children('input[name=buildingPay2]').val();//

    var col3 = currow.find('td:eq(2)').children('input').val();//계약일자

    if(col2){
      var col41 = currow.find('td:eq(3)').children('input:eq(0)').val();//공급가액
      if(Number(col41) <= 0){
        alert(col1+'행의 공급가액은 반드시 0보다 커야 합니다.');
        return false;
      }

      var col42 = currow.find('td:eq(3)').children('input:eq(1)').val();//세액
      if(Number(col42) < 0){
        alert(col1+'행의 세액은 반드시 0보다 커야 합니다.');
        return false;
      }

      var col43 = Number(col41) + Number(col42);//합계
      var col5 = currow.find('td:eq(4)').children('input').val();//기간
      if(!col5){
        alert(col1+'행의 기간은 필수값입니다.개월수이므로 숫자로 입력해야 합니다.');
        return false;
      }
      if(col5>72){
        alert(col1+'행의 계약기간은 72 이하여야 합니다.(72개월 즉 6년까지의 계약만 가능함)');
        return false;
      }

      var col61 = currow.find('td:eq(5)').children('input:eq(0)').val();//시작일
      if(!col61){
        alert(col1+'행의 시작일은 필수값입니다.');
        return false;
      }

      var arr1 = col61.split('-');
      var sDate = new Date(arr1[0], arr1[1]-1, arr1[2]);
      var eDate = new Date(sDate.getFullYear(), sDate.getMonth() + Number(col5), sDate.getDate()-1);

      var col62 = dateFormat(eDate);//종료일
      var col7 = currow.find('td:eq(6)').children('input').val();//보증금
      if(Number(col7) < 0){
        alert(col1+'행의 보증금은 반드시 0 이상이어야 합니다(음수불가).');
        return false;
      }

      var col8 = currow.find('td:eq(7)').children('input').val();//보증금입금일
      curArray.push(col1, col11, col21, col22, col3, col41, col42, col43, col5, col61, col62, col7, col8);
      allArray.push(curArray);
    }

  }

  console.log(allArray);
  // console.log(typeof(col41), col42, col43);

  var aa = 'p_realContract_add_for';
  var bb = 'p_realContract_add_for.php';
  var cc = 'allArray';

  goCategoryPage(aa, bb, cc, allArray, buildingIdx, groupIdx);

  function goCategoryPage(a, b, c, d, e, f){
    var frm = formCreate(a, 'post', b,'');
    frm = formInput(frm, 'buildingId', e);
    frm = formInput(frm, 'groupId', f)
    frm = formInput(frm, c, d);
    formSubmit(frm);
  }


})

</script>
</body>
</html>
