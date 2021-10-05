<!-- 처음에 만들때는 구분2가 있었는데 그거 자체를 삭제하고 다시 만듬 -->
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>관계자일괄등록</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";
?>

<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">일괄등록 화면입니다!</h3>
    <p class="lead">이 화면에서는 한꺼번에 많은 사람들을 등록합니다.</p>
    <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)연락처는 010으로 시작하는 핸드폰번호 기준입니다.(지역번호 02로 시작하는 번호 또는 031로 시작하는 번호는 고객상세화면에서 수정하세요)</small>
    <hr class="my-4">
    <a class="btn btn-primary btn-sm mobile" href="m_c_add_csv1.php" role="button">csv등록</a>
  </div>
</section>

<section class="container" style="max-width:1200px;">
  <form method="post" action ="p_m_c_adds.php">
    <div class="form-group row justify-content-md-center">
      <table width="500px">
        <tr class="text-center">
          <td width="25%"><label>구분(대)</label></td>
          <td width="30%">
            <select name="div1" class="form-control">
              <option value="입주자">입주자</option>
              <option value="거래처">거래처</option>
              <option value="기타">기타</option>
            </select>
          </td>
          <td width="15%"><label>물건</label></td>
          <td width="30%">
            <select name="building" class="form-control">
            </select>
          </td>
        </tr>
      </table>
    </div>

    <table id="centerSection" class='table table-bordered text-center'>
    </table>
    <table class='table table-bordered text-center table-sm' id='table1'>
      <thead>
        <tr>
          <td width="5%">순번</td>
          <td width="10%"><span id='star' style='color:#F7BE81;'>* </span>성명</td>
          <td width="10%"><span id='star' style='color:#F7BE81;'>* </span>연락처</td>
          <td width="5%">구분</td>
          <td width="10%">사업자명</td>
          <td width="10%">사업자번호</td>
          <td width="10%">이메일</td>
          <td width="10%">특이사항</td>
          <td width="5%"></td>
        </tr>
      </thead>
      <tbody>
        <?php  for ($i=1; $i < 11 ; $i++) { ?>
          <tr>
            <td>
              <label class="mt-1"><?=$i?></label>
            </td><!--순번-->
            <td><input type='text' class='form-control form-control-sm text-center' name='name<?=$i?>'></td><!--성명-->

            <td><input type=text name='num<?=$i?>' class='form-control form-control-sm phonenumber' maxlength="13" value="010-" ></td>
            <!--연락처-->
            <td>
              <select class="form-control form-control-sm" name="div3<?=$i?>">
                <option value=""></option>
                <option value="주식회사">주식회사</option>
                <option value="유한회사">유한회사</option>
                <option value="합자회사">합자회사</option>
                <option value="기타">기타</option>
              </select>
            </td><!--구분-->
            <td><input type='text' class='form-control form-control-sm text-center' name='companyname<?=$i?>'></td><!--사업자명-->
            <!-- <td><input type='text' class='form-control form-control-sm numberonly' name='cNumber<?=$i?>'></td> -->
            <td><input type=text name='cNumber<?=$i?>' class='form-control form-control-sm companynumber text-center' maxlength=12></td>
            <!--사업자번호-->
            <td><input type='email' class='form-control form-control-sm text-center' name='email<?=$i?>'></td><!--이메일-->
            <td><input type='text' class='form-control form-control-sm text-center' name='etc<?=$i?>'></td><!--특이사항-->
            <td class="pt-2">
              <div class='badge badge-warning text-wrap' style='width: 3rem;' name='rowDeleteBtn'>행삭제</div>
            </td><!--행삭제-->
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div class="row justify-content-center">
      <button type='button' class='btn btn-primary mr-1' id='frmSubmit'>저장</button>
      <a href='customer.php'><button type='button' class='btn btn-secondary'><i class="fas fa-angle-double-right"></i> 관계자리스트</button></a>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>

<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  // console.log(buildingArray);
  var groupoption;
  for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
    groupoption = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
    $('select[name=building]').append(groupoption);
  }
</script>

<script type="text/javascript">
$(document).ready(function () {
   $(function () {

            $('.companynumber').keydown(function (event) {
             var key = event.charCode || event.keyCode || 0;
             $text = $(this);
             if (key !== 8 && key !== 9) {
                 if ($text.val().length === 3) {
                     $text.val($text.val() + '-');
                 }
                 if ($text.val().length === 6) {
                     $text.val($text.val() + '-');
                 }
             }

             return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
			 // Key 8번 백스페이스, Key 9번 탭, Key 46번 Delete 부터 0 ~ 9까지, Key 96 ~ 105까지 넘버패트
			 // 한마디로 JQuery 0 ~~~ 9 숫자 백스페이스, 탭, Delete 키 넘버패드외에는 입력못함
         })

         $('.phonenumber').keydown(function (event) {
          var key = event.charCode || event.keyCode || 0;
          $text = $(this);
          if (key !== 8 && key !== 9) {
              if ($text.val().length === 3) {
                  $text.val($text.val() + '-');
              }
              if ($text.val().length === 8) {
                  $text.val($text.val() + '-');
              }
          }

          return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
    // Key 8번 백스페이스, Key 9번 탭, Key 46번 Delete 부터 0 ~ 9까지, Key 96 ~ 105까지 넘버패트
    // 한마디로 JQuery 0 ~~~ 9 숫자 백스페이스, 탭, Delete 키 넘버패드외에는 입력못함
      })
   });

});

$('div[name="rowDeleteBtn"]').on('click', function(){
  // console.log('삭제하기');
  var currow = $(this).closest('tr');
  currow.remove();
  // alert('삭제하였습니다');
})

$('#frmSubmit').on('click', function(){
  var rows = $('#table1 tbody').length;
  var table = $('#table1 tbody');

  for (var i = 0; i < rows ; i++) {
    var name = table.find("tr:eq("+i+")").find("td:eq(1)").children().val();
    var contact = table.find("tr:eq("+i+")").find("td:eq(2)").children().val();

    if(name){
      if(!contact){
        alert('성명, 연락처 중 1개만 넣으면 안됩니다. 둘다 입력 또는 둘다 입력하지 않아야 합니다.')
        return false;
      }
    }

    if(!name){
      if(contact){
        alert('성명, 연락처 중 1개만 넣으면 안됩니다. 둘다 입력 또는 둘다 입력하지 않아야 합니다.')
        return false;
      }
    }
  }

  $('form').submit();
})



</script>

</body>
</html>
