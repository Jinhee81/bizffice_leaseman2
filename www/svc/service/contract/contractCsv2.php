<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
?>

<style media="screen">
  .italic{
    font-style: italic;
    color: blue;
  }
</style>


<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">업로드한 파일 내용입니다.</h3>
    <p class="lead">이 화면에서는 엑셀업로드 형식으로 임대계약을 등록합니다.</p>
    <small>
      (1)(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)잘못 입력된 내용은 글자색이 빨간색이니 주의하세요.
    </small>

    <hr class="my-4">
1122234
  </div>
</section>

<?php
if(isset($_FILES['upfile']) && $_FILES['upfile']['name'] !== ""){
  $file = $_FILES['upfile'];
  $max_file_size = 5242880;

  if($file['size'] >= $max_file_size){
    echo "<script>alert('5MB 까지만 업로드 가능합니다.');</script>";
  }

  $handle = fopen($file['tmp_name'], 'r');?>

<section class="container">
  <form method="post" action="contractCsv2_p0.php">
    <table class="table table-bordered text-center">
      <tr>
        <td>순번</td>
        <td><span style='color:#F7BE81;'>* </span>물건idx</td>
        <td><span style='color:#F7BE81;'>* </span>그룹idx</td>
        <td><span style='color:#F7BE81;'>* </span>호수idx</td>
        <td><span style='color:#F7BE81;'>* </span>입주자idx</td>
        <td>계약일</td>
        <td><span style='color:#F7BE81;'>* </span>공급가액</td>
        <td><span style='color:#F7BE81;'>* </span>세액</td>
        <td><span style='color:#F7BE81;'>* </span>개월수</td>
        <td><span style='color:#F7BE81;'>* </span>시작일</td>
        <td>보증금</td>
        <td>보증금입금일</td>
        <td></td>
      </tr>
      <?php
        $i = 1;
        while($data = fgetcsv($handle)){
          // $data = array_map("utf8_encode", $data);
          ?>
        <tr>
          <td><?=$i?></td>
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center div1" name="<?=$i?>building" value="<?=$data[0]?>" required></td><!--물건명-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center div2" name="<?=$i?>group" value="<?=$data[1]?>" required></td><!--그룹명-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center name" name="<?=$i?>room" value="<?=$data[2]?>" required maxLength="9"></td><!--관리번호-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center contact" name="<?=$i?>name" value="<?=$data[3]?>" required></td><!--성명-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center gender" name="<?=$i?>contractDate" value="<?=$data[4]?>"></td><!--계약일자-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="email" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center email" name="<?=$i?>mAmount" value="<?=$data[5]?>" maxLength="40"></td><!--공급가액-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center div3" name="<?=$i?>mvAmount" value="<?=$data[6]?>"></td><!--세액-->

          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center companyname" name="<?=$i?>monthCount" value="<?=$data[7]?>" maxLength="14"></td><!--개월수-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center companyNumber" name="<?=$i?>startDate" value="<?=$data[8]?>"></td><!--시작일-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center div4" name="<?=$i?>depositMoney" value="<?=$data[9]?>" maxLength="9"></td><!--보증금-->
          <td class="pl-1 pr-1 pt-1 pb-1"><input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center div5" name="<?=$i?>depositInDate" value="<?=$data[10]?>" maxLength="14"></td><!--보증금입금일-->
          <td class="pl-1 pr-1 pt-2 pb-1">
            <img src="/svc/inc/img/svg/minus.svg" width="20" name="minus">
          </td><!--행추가/삭제-->
        </tr>
      <?php
      $i = $i + 1;
    }
      ?>
    </table>
    <div class="d-flex justify-content-center">

      <table width="350px;">
        <tr>
          <td width="20%"><button type="button" name="saveBtn" class="btn btn-primary btn-block">등록</button></td>
          <td width="40%"><a href="contractCsv.php"><button type="button" name="button" class="btn btn-secondary mr-1">이전화면 <i class="fas fa-angle-double-right"></i></button></a></td>
        </tr>
      </table>

    </div>
  </form>
</section>
<?php
}
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){

  $('button[name=saveBtn]').on('click', function(){
    $('form').submit();
  })

  $('img[name="minus"]').on('click', function(){
    // console.log('삭제하기');
    var deleteCheck = confirm('정말 삭제하겠습니까?');
    if(deleteCheck){
      var currow = $(this).closest('tr');
      currow.remove();
      alert('삭제하였습니다');
      //행삭제에 cunclude, errorVal 초기값을 넣는 이유가 이래야지 에전오류났던거가 지워짐...(중요)
    }
  })


})//docu.ready }


</script>
</body>
</html>
