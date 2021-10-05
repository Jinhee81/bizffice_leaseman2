<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}

// print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>문의하기</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
?>

<style>
        @media (max-width: 990px) {
        .mobile {
          display: none;
        }
}
</style>

<section class="container">
  <div class="jumbotron pt-2 pb-2">
    <h2 class="">궁금한 것들을 자유롭게 적어주세요!</h2>
    <p class="lead">
      (1)최대한 빠르게 연락드리겠습니다.<br>
      (2)통상적으로 이메일이나 문자메시지로 회신합니다. 통화를 원하는 경우 전화달라고 적어주세요.
    </p>
    <!-- <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다.(2) 구분(대)의 값이 '세입자'이어야 방계약 등록이 가능합니다. (3)'일괄등록','csv등록'은 데스크탑 디스플레이에서 사용가능 </small> -->
    <hr class="my-4">
  </div>
</section>
<section class="container" style="max-width:700px;">
  <form method="post" action ="p_question_add.php">
    <div class="form-row">
      <div class="form-group col-md-2">
        <label>분류</label>
      </div>
      <div class="form-group col-md-4">
        <select name="div1" class="form-control">
          <option value="사용문의"<?php if($_GET['div']==='usequestion'){echo 'selected';} ?>>사용문의</option>
          <option value="결제문의"<?php if($_GET['div']==='payquestion'){echo 'selected';} ?>>결제문의</option>
          <option value="탈퇴문의"<?php if($_GET['div']==='breakquestion'){echo 'selected';} ?>>탈퇴문의</option>
          <option value="오류신고"<?php if($_GET['div']==='errorwrite'){echo 'selected';} ?>>오류신고</option>
          <option value="데이터정정"<?php if($_GET['div']==='dataModify'){echo 'selected';} ?>>데이터정정요청</option>
        </select>
      </div>
    </div>
    <!-- <div class="form-row">
      <div class="form-group col-md-2">
        <label>제목</label>
      </div>
      <div class="form-group col-md-10 text-center">
        <input type='text' name='title' class='form-control' required maxlength='30'>
      </div>
    </div> -->
    <div class="form-row">
      <div class="form-group col-md-2">
        <label>내용</label>
      </div>
      <div class="form-group col-md-10 text-center"><textarea name="description" class="form-control" rows="8" cols="80" required maxlength='500'><?php if($_GET['div']==='errorwrite'){echo '오류(에러발생)를 신고할때는 반드시 계약번호, 청구번호 등을 적어주시고 간단한 오류증상을 적어주세요.';}?></textarea></div>
    </div>
    <!-- <div class="form-row">
      <div class="form-group col-md-2">
        <label>파일첨부</label>
      </div>
      <div class="form-group col-md-10 text-center">
        <input type='file' name='file' class='form-control'>
      </div>
    </div> 이건 좀더 안정화되고나서 처리하기로 함?-->
    <div class="form-row">
      <div class="form-group col-md-2">
        <label>연락처</label>
      </div>
      <div class="form-group col-md-4 text-center">
        <input type='text' name='cellphone' class='form-control' value="<?=$_SESSION['cellphone']?>" readonly>
      </div>
      <div class="form-group col-md-2">
        <label>이메일</label>
      </div>
      <div class="form-group col-md-4 text-center">
        <input type='text' name='email' class='form-control' value="<?=$_SESSION['email']?>" readonly>
      </div>
    </div>
    <!-- <div class="form-row" id="section2">
      <div class="form-group col-md-3">
        <label>응답방식</label>
      </div>
      <div class="form-group col-md-9 text-center" id="">
        <input type='text' name='name' class='form-control' required maxlength='9'>
      </div>
    </div> 넣으려다가 안넣음-->

    <div class="row justify-content-md-center">
      <button type='submit' class='btn btn-primary mr-1'>등록하기</button>
      <button type='button' class='btn btn-secondary'>취소</button>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/admin/js/jquery-ui.min.js"></script><!--datepicker를 쓰기위해 필요함-->
<script src="/admin/js/datepicker-ko.js"></script><!--달력 api-->
<script src="/admin/js/jquery-ui-timepicker-addon.js"></script><!--달력 + 시간 api-->
<script type="text/javascript">

</script>
