<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
settype($filtered_id, 'integer');
$sql = "select * from building where id={$filtered_id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
// print_r($row);
// print_r($_SESSION);

?>

<section class="container">
    <div class="jumbotron pt-3 pb-3">
        <h2 class=""> >> 관리물건 수정 화면입니다!</h2>
        <!-- <p class="lead">
      (1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩<br>
      (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.<br>
      (3) '형태' 변경을 원하는 경우 상단 <a href="/user/myinfo.php"><i class="fas fa-user"></i>&nbsp;나의정보</a>에서 임대유형을 수정하세요.<br>
      (4) <a href="https://www.popbill.com/Member/Form/Link" target="_blank">팝빌사이트</a>에 가입하고 사업자번호를 입력하면 전자세금계산서 연동 발행이 가능합니다.
    </p> -->
        <!-- <hr class="my-4"> -->
        <!-- <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
    </div>
</section>
<section class="container" style="max-width:500px;">
    <form action="p_building_edit.php" method="post">
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">형태(IDX)</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name"
                    value="<?=$_SESSION['lease_type'].'('.$row['id'].')'?>" disabled>
                <small>상단 <a href="/user/myinfo.php"><i class="fas fa-user"></i>&nbsp;나의정보</a>에서 형태 수정 가능합니다.</small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">명칭</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" value="<?=$row['bName']?>" required="">
                <!-- <br> -->
                <small>평상시부르는 명칭을 적어주세요 (예, 도레미고시원, 성공빌딩 등)</small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">수금방법</label>
            <div class="col-sm-9">
                <select name="pay" class="form-control">
                    <option value="선납" <?php if($row['pay']=="선납"){echo "selected";}?>>선납</option>
                    <option value="후납" <?php if($row['pay']=="후납"){echo "selected";}?>>후납</option>
                </select>
                <!-- <br> -->
                <small>임대료 받는 방식이에요. 선납 또는 후납을 선택합니다.</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label">특이사항</label>
            <div class="col-sm-9">
                <textarea name="etc" class="form-control" rows="3" cols="80"></textarea>
            </div>
        </div>

        <div class="">
            <p class="text-center text-muted">
                <small>등록일시[<?=$row['created']?>] 수정일시[<?=$row['updated']?>]</small>
            </p>
        </div>
        <div class="mt-7">
            <a class="btn btn-secondary" href="building.php" role="button">취소/돌아가기</a>
            <button type="submit" class="btn btn-primary">수정</button>
        </div>
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    function maxlengthCheck(object) {
        if (object.value.length > object.maxLength) {
            object.value = object.value.slice(0, object.maxLength);
        }
    } //숫자 입력개수 제한하는 함수, 연락처1,2,3/사업자번호에 사용됨
})
</script>

</body>

</html>