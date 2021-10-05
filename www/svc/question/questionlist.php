<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}

print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>문의내역보기</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$sql = "
  select *
  from board_question
  where user_id={$_SESSION['id']}
  order by id desc";

$result = mysqli_query($conn, $sql);

$allRows = array();
while ($row = mysqli_fetch_array($result)) {
  $allRows[] = $row;
}

?>

<style>
        @media (max-width: 990px) {
        .mobile {
          display: none;
        }
}
</style>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4">나의 문의내역 리스트입니다!</h1>
    <p class="lead">
      <!-- (1)최대한 빠르게 연락드리겠습니다.<br>
      (2)통상적으로 이메일이나 문자메시지로 회신합니다. 통화를 원하는 경우 전화달라고 적어주세요. -->
    </p>
    <!-- <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다.(2) 구분(대)의 값이 '세입자'이어야 방계약 등록이 가능합니다. (3)'일괄등록','csv등록'은 데스크탑 디스플레이에서 사용가능 </small> -->
    <hr class="my-4">
  </div>
</section>
<section class="container">

  <table class="table table-hover text-center mt-2" id="checkboxTestTbl">
    <thead>
      <tr class="table-info">
        <th scope="col">순번</th>
        <th scope="col" class="mobile">구분</th>
        <th scope="col">제목</th>
        <th scope="col">내용</th>
        <!-- <th scope="col" class="mobile">첨부파일</th> -->
        <th scope="col" class="mobile">등록일시</th>
        <th scope="col">상태</th>
      </tr>
    </thead>
    <?php
    if(count($allRows)===0){
      echo "<tr><td colspan='7'>문의내역이 없습니다.</td></tr>";
    } else {
      $j = count($allRows);
      for ($i=0; $i < count($allRows); $i++) {?>
      <tr>
        <td><?=$j?></td>
        <td><?=$allRows[$i]['div1']?></td>
        <td><a href="questionEdit.php?id=<?=$allRows[$i]['id']?>"><?=$allRows[$i]['title']?></td>
        <td><?=$allRows[$i]['description']?></td>
        <!-- <td><?=$allRows[$i]['file']?></td> -->
        <td><?=$allRows[$i]['created']?></td>
        <td><?=$allRows[$i]['status']?></td>
      </tr>
    <?php
    $j -= 1;
      } //for closing }
    } //else closing }
     ?>
   </table>

</section>

<script src="/admin/js/jquery-ui.min.js"></script><!--datepicker를 쓰기위해 필요함-->
<script src="/admin/js/datepicker-ko.js"></script><!--달력 api-->
<script src="/admin/js/jquery-ui-timepicker-addon.js"></script><!--달력 + 시간 api-->

<script>
var starEx = "<span id='star' style='color:#F7BE81;'>* </span>";

var div3 = "<label>구분</label><br><select name='div3' class='form-control'><option value='주식회사'>주식회사</option><option value='유한회사'>유한회사</option><option value='합자회사'>합자회사</option><option value='기타'>기타</option></select>";

var div4 ="<label>업태</label><input type='text' name='div4' class='form-control' maxlength='9'>";

var div5 ="<label>업종</label><input type='text' name='div5' class='form-control' maxlength='14'>";

var gubun2 = "<div class='form-group col-md-4'><label>구분</label></div><div class='form-group col-md-8 text-center'><select name='div2' class='form-control'><option value='개인'>개인</option><option value='개인사업자'>개인사업자</option><option value='법인사업자'>법인사업자</option></select></div>";

var quest_date = "<label>문의일자</label><input type='text' name='qDate' class='form-control timeType' id='datepicker'>";

var contact ="<label>"+ starEx +"연락처</label><div class='form-row'><div class='form group col-md-4'><input type='number' name='contact1' id='contact1' class='form-control' maxlength='3' value='010' required oninput='maxlengthCheck(this);'></div><div class='form group col-md-4'><input type='number' name='contact2' id='contact2' class='form-control' maxlength='4' required oninput='maxlengthCheck(this);'></div><div class='form group col-md-4'><input type='number' name='contact3' id='contact3' class='form-control' maxlength='4' required oninput='maxlengthCheck(this);'></div></div>";

var name = "<label>" + starEx + "성명</label><input type='text' name='name' class='form-control' required maxlength='9' onmouseout='addCheck(this.value);'>";

var gender = "<label>성별</label><br><div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='gender' id='inlineRadio1' value='남'><label class='form-check-label'>남</label></div><div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='gender' id='inlineRadio2' value='여'><label class='form-check-label'>여</label></div>";

var comName = "<label>사업자명</label><input type='text' name='companyname' class='form-control' maxlength='14'>";

var corComName = "<label>"+starEx+"법인사업자명</label><input type='text' name='companyname' class='form-control' maxlength='14'>";

var corBossName = "<label>대표자명</label><input type='text' name='name' class='form-control' maxlength='9'>";

var comNumber ="<label>사업자번호</label><br><div class='form-row'><div class='form group col-md-4'><input type='number' name='cNumber1' class='form-control' maxlength='3' oninput='maxlengthCheck(this);'></div><div class='form group col-md-3'><input type='number' name='cNumber2' class='form-control' maxlength='2' oninput='maxlengthCheck(this);'></div><div class='form group col-md-5'><input type='number' name='cNumber3' class='form-control' maxlength='5' oninput='maxlengthCheck(this);'></div></div>";

var emailSmall ="<label>이메일</label><input type='email' name='email' class='form-control' maxlength='40'>";

var email ="<div class='form-row'><div class='form-group col-md-4'><label>이메일</label></div><div class='form-group col-md-8'><input type='email' name='email' class='form-control' maxlength='40'></div></div>";

var address = "<div class='form-group'><div class='form-row'><label>주소</label></div><div class='form-row'><div class='form-group col-md-3'><input type='text' id='sample2_postcode' name='zipcode' placeholder='우편번호' class='form-control' disabled></div><div class='form-group col-md-3'><input type='button' onclick='sample2_execDaumPostcode()' value='우편번호 찾기' class='btn btn-outline-secondary btn-sm'><br></div></div><div class='form-row'><div class='form-group col-md-6'><input type='text' id='sample2_address' placeholder='주소' name='add1' class='form-control'></div><div class='form-group col-md-6'><input type='text' id='sample2_detailAddress' name='add2' placeholder='상세주소' class='form-control'></div></div><div class='form-row'><div class='form-group col'><input type='text' id='sample2_extraAddress' name='add3' placeholder='참고항목' class='form-control'></div></div></div><div id='layer' style='display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;'><img src='//t1.daumcdn.net/postcode/resource/images/close.png' id='btnCloseLayer' style='cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1' onclick='closeDaumPostcode()' alt='닫기 버튼'></div>";

var etc ="<div class='form-group'><div class='form-row'><label>특이사항</label><input type='text' name='etc' class='form-control' maxlength='47'></div></div>";

var etcq ="<div class='form-group'><div class='form-row'><label>"+starEx+"문의내용</label><input type='text' name='etc' class='form-control' maxlength='47' required></div></div>";

var municom = "<div class='form-row'><div class='form-group col-md-8'>"+contact+"</div><div class='form-group col-md-4'>"+quest_date+"</div></div>";

var gaein = "<div class='form-row'><div class='form-group col-md-4'>"+name+"</div><div class='form-group col-md-5'>"+contact+"</div><div class='form-group col-md-3'>"+gender+"</div></div>";

var gaein_company1 = "<div class='form-row'><div class='form-group col-md-3'>"+name+"</div><div class='form-group col-md-4'>"+comName+"</div><div class='form-group col-md-5'>"+contact+"</div></div>";//개인사업자 첫번째라인, 성명/사업자명/연락처

var gaein_company2 = "<div class='form-row'><div class='form-group col-md-5'>"+comNumber+"</div><div class='form-group col-md-3'>"+div4+"</div><div class='form-group col-md-4'>"+div5+"</div></div>";//개인사업자 두번째라인, 사업자번호/업태/업종

var gaein_company3 = "<div class='form-row'><div class='form-group col-md-4'>"+gender+"</div><div class='form-group col-md-8'>"+emailSmall+"</div></div>";//개인사업자 세번째라인, 성별/이메일

var corporate_company1 = "<div class='form-row'><div class='form-group col-md-4'>"+div3+"</div><div class='form-group col-md-4'>"+corComName+"</div><div class='form-group col-md-4'>"+corBossName+"</div></div>";//법인사업자 첫번째라인, 구분/사업자명/대표자명

var corporate_company2 = "<div class='form-row'><div class='form-group col-md-6'>"+comNumber+"</div><div class='form-group col-md-3'>"+div4+"</div><div class='form-group col-md-3'>"+div5+"</div></div>";//법인사업자 두번째라인, 사업자번호/업태/업종

var corporate_company3 = "<div class='form-row'><div class='form-group col-md-6'>"+contact+"</div><div class='form-group col-md-6'>"+emailSmall+"</div></div>";//법인사업자 세번째라인, 연락처/이메일

var case1 = gaein + email + address + etc; // (디폴트 값) 고객, 개인

var case2 = municom + etcq; //문의고객

var case3 = gaein_company1 + gaein_company2 + gaein_company3 + address + etc; //고객, 개인사업자

var case4 = corporate_company1 + corporate_company2 + corporate_company3 + address + etc; //고객, 법인사업자

$('select[name=div1]').on('change', function(){
  var div1 = $('select[name=div1]').val();
  if(div1==='문의'){
    $('#section2').empty();
    $('#section3').html(case2);
  } else {
    $('#section2').html(gubun2);
    $('#section3').html(case1);

    $('select[name=div2]').on('change', function(){
      var div2 = $('select[name=div2]').val();

      if(div2==='개인'){
        $('#section3').html(case1);
      } else if(div2==='개인사업자'){
        $('#section3').html(case3);
      } else if(div2==='법인사업자'){
        $('#section3').html(case4);
      }
    })
  }

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
})

$('select[name=div2]').on('change', function(){
  var div2 = $('select[name=div2]').val();

  if(div2==='개인'){
    $('#section3').html(case1);
  } else if(div2==='개인사업자'){
    $('#section3').html(case3);
  } else if(div2==='법인사업자'){
    $('#section3').html(case4);
  }
})

</script>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
