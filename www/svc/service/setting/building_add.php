<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
?>

<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class=""> >> 관리물건 등록 화면입니다!</h3>
    <!-- <p class="lead">관리물건이란 </p> -->
    <hr class="my-4">
    <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small>
  </div>
</section>
<section class="container" style="max-width:500px;">
  <form action="p_building_add.php" method="post">
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-3 col-form-label">형태</label>
      <div class="col-sm-9">
        <select name="lease_type" class="form-control" disabled="">
          <option disabled="disabled" value="공유오피스" <?php if($_SESSION['lease_type']=="공유오피스"){echo "selected";}?>>공유오피스</option>
          <option value="원룸" <?php if($_SESSION['lease_type']=="원룸"){echo "selected";}?>>원룸</option>
          <option value="빌딩" <?php if($_SESSION['lease_type']=="빌딩"){echo "selected";}?>>빌딩</option>
          <option value="고시원" <?php if($_SESSION['lease_type']=="고시원"){echo "selected";}?>>고시원</option>
          <option value="창고" <?php if($_SESSION['lease_type']=="창고"){echo "selected";}?>>창고</option>
          <option value="임대관리회사" <?php if($_SESSION['lease_type']=="임대관리회사"){echo "selected";}?>>임대관리회사</option>
          <option value="기타" <?php if($_SESSION['lease_type']=="기타"){echo "selected";}?>>기타</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">명칭</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" value="<?=$_SESSION['user_name']?>" required="">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">수금방법</label>
      <div class="col-sm-9">
        <select name="pay" class="form-control">
          <option value="선납">선납</option>
          <option value="후납">후납</option>
        </select>
      </div>
    </div>
    <div class="mt-7">
      <a class="btn btn-secondary" href="building.php" role="button">취소/돌아가기</a>
      <button type="submit" class="btn btn-primary">저장</button>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
