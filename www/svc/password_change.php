<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>비밀번호를 변경합니다</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_SESSION);
$sql = "select
          email, user_div, user_name, cellphone, lease_type, created
        from user
        where id={$_SESSION['id']}";
// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

 ?>
<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">비밀번호를 변경합니다.</h3>
    <hr class="my-4">
    <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
 </div>
</section>

<div class="container" style="max-width:500px;">
  <form class="" action="p_password_change.php" method="post">

    <div class="form-group row">
      <label for="" class="col-sm-4 col-form-label"><b>변경할 비밀번호</b></label>
      <div class="col-sm-8">
        <input type="password" class="form-control" name="password1">
      </div>
    </div>
    <div class="form-group row">
      <label for="" class="col-sm-4 col-form-label"><b>비밀번호 확인</b></label>
      <div class="col-sm-8">
        <input type="password" class="form-control" name="password2">
        <div name="pscheck">

        </div>
      </div>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-sm btn-outline-info">수정하기</button>
    </div>
  </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";
?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script>
var pscheckval = false;

$('input[name=password2]').on('blur', function(){
  var ps1 = $('input[name=password1]').val();
  var ps2 = $(this).val();

  if(ps1 === ps2){
    $('div[name=pscheck]').text('비밀번호가 일치합니다.');
    pscheckval = true;
  } else {
    $('div[name=pscheck]').text('비밀번호가 일치하지 않습니다. 다시 확인해주세요.');
    pscheckval = false;
  }
})

$('button[type=submit]').on('click', function(){
  var f = $('form');

  if(pscheckval===true){
    f.submit();
  } else {
    alert('비밀번호가 일치하지 않습니다. 다시 확인하세요');
    return false;
  }
})


</script>
