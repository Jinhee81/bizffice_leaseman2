<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";
?>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4"> >> 부계정리스트 등록 화면입니다!</h1>
    <p class="lead">직원이 있는경우 부계정을 등록하세요 </p>
    <hr class="my-4">
    <!-- <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
  </div>
</section>
<section class="container" style="max-width:500px;">
  <form action="p_account_add.php" method="post">

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">이름</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="이름 혹은 별명을 넣어주세요" required="">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">아이디</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="nickid" placeholder="영문만 입력합니다." required="">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">패스워드</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="password" placeholder="" required="">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">특이사항</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="etc"></textarea>
      </div>
    </div>
    <div class="mt-7">
      <a class="btn btn-secondary" href="building.php" role="button">취소/돌아가기</a>
      <button type="submit" class="btn btn-primary">저장</button>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/view/service_footer.php";?>
