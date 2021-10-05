<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>환경설정</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
?>

<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">환경설정화면이에요(임대관리의 필요사항을 설정하세요!)</h3>
    <p class="lead">
    (1)'도레미고시원' 또는 '두드림센터' 등 평상시 관리하는 명칭을 적어주세요.<br>
    (2) 관리호수를 등록해야 리스맨 사용이 가능합니다. (관리호수란? '101호', '102호' 등의 명칭)<br>
    <!-- (2) 직원이 있는 경우 계정추가하여 직원을 등록하세요.  -->
    </p>
    <hr class="my-4">
    <p>리스맨 회원가입후 30일동안 무료이용 가능합니다. 30일 이후 요금은 <a href="../../main/payment.php" class="badge badge-warning">요금안내</a> 페이지를 참조하세요.<br>
      <label class="red">반드시 물건등록을 해야 리스맨 사용 및 화면보기가 가능해요 ^__^</label>
    </p>
    <a class="btn btn-primary btn-lg mr-1" href="building_add.php" role="button">물건등록</a>
    <!-- <a class="btn btn-outline-primary btn-lg" href="account.php" role="button">계정추가</a> -->
  </div>
</section>

<section>
  <div class="container">
    <?php
    $sql = "select count(*) from building where user_id={$_SESSION['id']}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $b_count = (int)$row['count(*)'];
    // 건물($b_count)이 한개라도 있으면 건물테이블 보여지는거
    if($b_count < 1) {
      echo "등록된 물건이 없습니다. 물건을 등록해주세요!";
    } else {
      include "building_table.php";
    }?>

  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.betc').tooltip('show');
  })
</script>

</body>
</html>
