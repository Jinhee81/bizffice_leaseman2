<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>관계자수정</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";

// print_r($buildingArray);
?>


<?php
// print_r($_GET['id']);
$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//고객아이디
settype($filtered_id, 'integer');

$sql = "select
          div1, qDate, div2, name, contact1, contact2, contact3,
          gender, customer.email, div3, div4, div5, companyname,
          cNumber1, cNumber2, cNumber3,
          zipcode, add1, add2, add3, trim(etc), created, updated, building_id, birthday
      from customer
      where id = {$filtered_id}";

// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

// print_r($row);
$clist['num'] = htmlspecialchars($row['num']);
$clist['div1'] = htmlspecialchars($row['div1']);
$clist['div2'] = htmlspecialchars($row['div2']);
$clist['div4'] = htmlspecialchars($row['div4']);
$clist['div5'] = htmlspecialchars($row['div5']);
$clist['contact1'] = htmlspecialchars($row['contact1']);
$clist['contact2'] = htmlspecialchars($row['contact2']);
$clist['contact3'] = htmlspecialchars($row['contact3']);
$clist['email'] = htmlspecialchars($row['email']);
$clist['etc'] = htmlspecialchars($row['trim(etc)']);
$clist['name'] = htmlspecialchars($row['name']);
$clist['companyname'] = htmlspecialchars($row['companyname']);
$clist['cNumber1'] = htmlspecialchars($row['cNumber1']);
$clist['cNumber2'] = htmlspecialchars($row['cNumber2']);
$clist['cNumber3'] = htmlspecialchars($row['cNumber3']);
$clist['zipcode'] = htmlspecialchars($row['zipcode']);
$clist['add1'] = htmlspecialchars($row['add1']);
$clist['add2'] = htmlspecialchars($row['add2']);
$clist['add3'] = htmlspecialchars($row['add3']);
$clist['birthday'] = htmlspecialchars($row['birthday']);

if($clist['div1']==='입주자'){
  $sql2 = "select count(*)
           from realContract
           where customer_id={$filtered_id}";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_array($result2);
} else {
  $sql2 = "select count(*)
           from etcContract
           where customer_id={$filtered_id}";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_array($result2);
}



 ?>
<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h2 class="">관계자 수정 화면이에요.</h2>
    <!-- <p class="lead">고객이란 입주한 세입자 및 문의하는 문의고객, 거래처 등을 포함합니다. 고객등록이 되어야 임대계약 등록이 가능합니다!</p>
    <hr class="my-4">-->
    <!-- <small>(1) * 표시는 필수입력값입니다. (2) 구분(대)의 값이 '고객'이어야 임대계약 등록이 가능합니다. (3) '고객'이란 단어는 세입자 또는 입주자를 의미합니다.</small> isright 9999 -->
  </div>
</section>
<section class="container" style="max-width:700px;">
  <form method="post" action ="p_m_c_edit.php">
    <div class="form-row">
      <div class="form-group col-md-3 mb-2">
        <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>구분1</p>
        <select name="div1" class="form-control">
          <option value="입주자" <?php if($clist['div1']==='입주자'){echo "selected";}?>>입주자</option>
          <option value="거래처" <?php if($clist['div1']==='거래처'){echo "selected";}?>>거래처</option>
          <option value="기타" <?php if($clist['div1']==='기타'){echo "selected";}?>>기타</option>
        </select>
      </div>
      <div class="form-group col-md-3 mb-1">
        <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>구분2</p>
        <select name="div2" class="form-control">
          <option value="개인" <?php if($clist['div2']==='개인'){echo "selected";}?>>개인</option>
          <option value="개인사업자" <?php if($clist['div2']==='개인사업자'){echo "selected";}?>>개인사업자</option>
          <option value="법인사업자" <?php if($clist['div2']==='법인사업자'){echo "selected";}?>>법인사업자</option>
        </select>
      </div>
      <div class="form-group col-md-3 mb-1">
        <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>물건</p>
        <select name="building" class="form-control">
        <?php

        foreach ($buildingArray as $key => $value) {
          if($row['building_id']==$key){
            echo "<option value='$key' selected>".$buildingArray[$key][0]."</option>";
          } else {
            echo "<option value='$key'>".$buildingArray[$key][0]."</option>";
          }
        }
         ?>
        </select>
      </div>
    </div>
    <div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>성명</p>
          <input type='text' name='name' class='form-control' required maxlength='9' value="<?=$clist['name']?>">
          <input type='hidden' name='id' value="<?=$_GET['id']?>">
        </div>
        <div class="form-group col-md-5">
          <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>연락처</p>
          <div class='form-row'>
            <div class='form group col-md-4'>
              <input type='text' name='contact1' id='contact1' class='form-control' maxlength='3' value="<?=$clist['contact1']?>" required numberOnly>
            </div>
            <div class='form group col-md-4'>
              <input type='text' name='contact2' id='contact2' class='form-control' maxlength='4' required oninput='maxlengthCheck(this);' value="<?=$clist['contact2']?>" numberOnly>
            </div>
            <div class='form group col-md-4'>
              <input type='text' name='contact3' id='contact3' class='form-control' maxlength='4' required oninput='maxlengthCheck(this);' value="<?=$clist['contact3']?>" numberOnly>
            </div>
          </div>
        </div>
        <div class="form-group col-md-3">
          <p class="mb-1">성별</p>
          <div class='form-check form-check-inline'>
            <input class='form-check-input' type='radio' name='gender' id='inlineRadio1' value='남'<?php if($row['gender']==='남'){echo "checked";}?>>
            <label class='form-check-label'>남</label>
          </div>
          <div class='form-check form-check-inline'>
            <input class='form-check-input' type='radio' name='gender' id='inlineRadio2' value='여'<?php if($row['gender']==='여'){echo "checked";}?>>
            <label class='form-check-label'>여</label>
          </div>
        </div>
      </div>
      <hr class="mt-0 mb-2">
      <div class="form-row">
        <div class="form-group col-md-3 mb-1">
          <p class="mb-1">사업자구분</p>
          <select name="div3" class="form-control form-control-sm">
            <option value=""<?php if($row['div3']==''){
              echo "selected";
            } ?>></option>
            <option value="주식회사"<?php if($row['div3']=='주식회사'){
              echo "selected";
            } ?>>주식회사</option>
            <option value="유한회사"<?php if($row['div3']=='유한회사'){
              echo "selected";
            } ?>>유한회사</option>
            <option value="합자회사"<?php if($row['div3']=='합자회사'){
              echo "selected";
            } ?>>합자회사</option>
          </select>
        </div>
        <div class="form-group col-md-4 mb-1">
          <p class="mb-1">사업자명</p>
          <input type='text' name='companyname' class='form-control form-control-sm' maxlength='14' value="<?=$clist['companyname']?>">
        </div>
        <div class="form-group col-md-5 mb-1">
          <p class="mb-1">사업자번호</p>
          <div class='form-row'>
            <div class='form group col-md-4'>
              <input type='text' name='cNumber1' class='form-control form-control-sm' maxlength='3' oninput='maxlengthCheck(this);' value="<?=$clist['cNumber1']?>" numberOnly>
            </div>
            <div class='form group col-md-3'>
              <input type='text' name='cNumber2' class='form-control form-control-sm' maxlength='2' oninput='maxlengthCheck(this);' value="<?=$clist['cNumber2']?>" numberOnly>
            </div>
            <div class='form group col-md-5'>
              <input type='text' name='cNumber3' class='form-control form-control-sm' maxlength='5' oninput='maxlengthCheck(this);' value="<?=$clist['cNumber3']?>" numberOnly>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <p class="mb-1">업태</p>
          <input type='text' name='div4' class='form-control form-control-sm' maxlength='9' value="<?=$clist['div4']?>">
        </div>
        <div class="form-group col-md-4">
          <p class="mb-1">종목</p>
          <input type='text' name='div5' class='form-control form-control-sm' maxlength='15' value="<?=$clist['div5']?>">
        </div>
        <div class="form-group col-md-5">
          <p class="mb-1">이메일</p>
          <input type='email' name='email' class='form-control form-control-sm' maxlength='40' value="<?=$clist['email']?>">
        </div>
      </div>

      <hr class="mt-0 mb-2">

      <div class='form-group'>
        <div class='form-row'>
          <p class="mb-1">주소</p>
        </div>
        <div class='form-row'>
          <div class='form-group col-md-3 mb-1'>
            <input type='text' id='sample2_postcode' name='zipcode' placeholder='우편번호' class='form-control form-control-sm' disabled value="<?=$clist['zipcode']?>">
          </div>
          <div class='form-group col-md-3 mb-0'>
            <input type='button' onclick='sample2_execDaumPostcode()' value='우편번호 찾기' class='btn btn-outline-secondary btn-sm'><br>
          </div>
        </div>
        <div class='form-row mb-1'>
          <div class='form-group col-md-6 mb-0'>
            <input type='text' id='sample2_address' name='add1' class='form-control form-control-sm' value="<?=$clist['add1']?>">
          </div>
          <div class='form-group col-md-6 mb-0'>
            <input type='text' id='sample2_detailAddress' name='add2' class='form-control form-control-sm' value="<?=$clist['add2']?>">
          </div>
        </div>
        <div class='form-row'>
          <div class='form-group col mb-0'>
            <input type='text' id='sample2_extraAddress' name='add3' class='form-control form-control-sm' value="<?=$clist['add3']?>">
          </div>
        </div>
      </div>
      <div id='layer' style='display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;'>
        <img src='//t1.daumcdn.net/postcode/resource/images/close.png' id='btnCloseLayer' style='cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1' onclick='closeDaumPostcode()' alt='닫기 버튼'>
      </div>
      <div class='form-group'>
        <div class='form-row'>
          <div class="form-group col-md-9">
            <p class="mb-1">특이사항</p><textarea name="etc" rows="2" cols="80" class="form-control form-control-sm"><?=$clist['etc']?></textarea>
          </div>
          <div class="form-group col-md-3">
            <p class="mb-1">생년월일</p>
            <input type='text' name='birthday' class='form-control form-control-sm dateType yyyymmdd' value="<?=$clist['birthday']?>">
          </div>
        </div>
      </div>
    </div>

    <!-- 고객정보 -->
    <div class="mb-3">
      <section class="d-flex justify-content-center">
         <small class="form-text text-muted text-center">고객번호[<?=$filtered_id?>] 등록일시[<?=$row['created']?>] 수정일시[<?=$row['updated']?>] </small>
      </section>
    </div>


    <div class="row">
      <div class="col col-md-3">
        <button type='button' class='btn btn-sm btn-outline-primary' data-toggle="modal" data-target="#smsModal1" id="smsBtn"><i class="far fa-envelope"></i> 보내기</button>
      </div>
      <div class="col">
        <div class="row justify-content-end mr-0">
          <button type='button' class='btn btn-danger mr-1' name='btnDelete'>삭제하기</button>
          <button type='submit' class='btn btn-primary mr-1'>수정하기</button>
          <a href='customer.php'><button type='button' class='btn btn-secondary mr-1'><i class="fas fa-angle-double-right"></i> 관계자목록</button></a>
          <?php
          if($clist['div1']==='입주자'){
            echo "<a href='/svc/service/contract/contract_add1.php?id=".$filtered_id."'><button type='button' class='btn btn-secondary mr-1'><i class='fas fa-angle-double-right'></i> 신규계약</button></a>";
          } elseif($clist['div1']==='기타'){
            echo "<a href='/svc/service/contractetc/contractetc_add1.php?id=".$filtered_id."'><button type='button' class='btn btn-secondary mr-1'><i class='fas fa-angle-double-right'></i> 신규계약</button></a>";
          }
           ?>
          <?php
            if($clist['div1']==='입주자' && (int)$row2[0] > 0){
              echo "<a href='/svc/service/contract/contract.php?customerId=".$filtered_id."&progress=pAll'><button type='button' class='btn btn-secondary'><i class='fas fa-angle-double-right'></i> 계약보기</button></a>";
            }
            // elseif($clist['div1']==='기타' && (int)$row2[0] > 0) {
            //   echo "<a href='/svc/service/contractetc/contractetc.php?customerId=".$filtered_id."'><button type='button' class='btn btn-secondary'><i class='fas fa-angle-double-right'></i> 계약보기</button></a>";
            // }
            //기타계약은 건수가 많이 없어서 계약보기 버튼을 일단 안보이게하기로 함
           ?>
        </div>
      </div>
    </div>
  </form>
</section>

<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/service/sms/modal_sms3.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>


<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
<script src="/svc/inc/js/etc/newdate8.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/sms_noneparase4.js?<?=date('YmdHis')?>"></script>



<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="/svc/inc/js/daumAddressAPI3.js?<?=date('YmdHis')?>"></script>

<script type="text/javascript">
var buildingArray = <?php echo json_encode($buildingArray); ?>;
var customerId = <?=$filtered_id?>;

$(document).ready(function(){
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

  $(function () {
      $('[data-toggle="tooltip"]').tooltip();
  })

  $('button[name=btnDelete]').on('click', function(){
    var a = confirm('정말 삭제하시겠습니까?');
    if(a){
      goCategoryPage(customerId);

      function goCategoryPage(x){
        var frm = formCreate('customerDelete', 'post', 'p_m_c_delete.php','');
        frm = formInput(frm, 'cid', x);
        formSubmit(frm);
      }
    }
  })

  $('#smsBtn').on('click', function(){
    var buildingkey = $('select[name=building]').val();
    // console.log(buildingkey);
    var recievephonenumber = $('input[name=contact1]').val()+'-'+$('input[name=contact2]').val()+'-'+$('input[name=contact3]').val();
    var cname = $('input[name=name]').val();

    //문자발송번호
    var sendphonenumber = buildingArray[buildingkey][3] + buildingArray[buildingkey][4] + buildingArray[buildingkey][5];
    $('input[name=sendphonenumber]').val(sendphonenumber);

    //문자수신번호
    $('#recievephonenumber').text(recievephonenumber);
    $('#mcid').val(customerId);
    $('#mcname').text(cname);

    sms_noneparase();
  })
})

  function maxlengthCheck(object){
    if(object.value.length > object.maxLength){
      object.value = object.value.slice(0, object.maxLength);
    }
  }//숫자 입력개수 제한하는 함수, 연락처1,2,3/사업자번호에 사용됨

  $("input:text[numberOnly]").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
  });

</script>
</body>
</html>
