<!-- 이거만들었다가 지웠음 -->

<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$smsAdd = array(
      '고객화면'=> ['세입자','이메일'],
      '방계약화면'=> ['세입자','이메일','계약일','종료일'],
      '입금예정화면'=> ['세입자','이메일','예정일','예정금액','시작일','종료일','개월','연체일수','연체이자'],
      '입금완료화면'=> ['세입자','이메일','입금일','발행일']
    );

// print_r($smsAdd);
?>

<script type="text/javascript">
  var smsAddArray = <?php echo json_encode($smsAdd); ?>;
</script>

<style>
        #checkboxTestTbl tr.selected{background-color: #A9D0F5;}
        select .selectCall{background-color: #A9D0F5;}

        @media (max-width: 990px) {
        .mobile {
          display: none;
        }
        .green{
          color: #04B486;
        }

        .pink{
          color: #F7819F;
        }
        .appi{
          color:#F7819F;
        }
}
</style>
<section class="container">
  <div class="jumbotron pt-4 pb-3">
    <h1 class="display-4">상용구 등록하기</h1>
    <p class="lead">

    </p>
  </div>
</section>

<section class="container" style="width:500px;">
  <form class="" action="p_smsAdd.php" method="post">
    <div class="form-group row">
      <div class="col col-md-3">
        <label for="">사용화면</label>
      </div>
      <div class="col col-md-9">
        <select class="form-control" name="screen">
          <?php
            foreach ($smsAdd as $key => $value) {
              echo "<option value='$key'>".$key."</option>";
            }
           ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <div class="col col-md-3">
        <label for="">항목<label>
      </div>
      <div class="col col-md-9">
        <textarea name="screenItem" rows="2" cols="80" class="form-control" disabled></textarea>
      </div>
    </div>
    <div class="form-group row">
      <div class="col col-md-3">
        <label for="">제목</label>
      </div>
      <div class="col col-md-9">
        <input type="text" name="title" value="" class="form-control" required>
      </div>
    </div>
    <div class="form-group row">
      <div class="col col-md-3">
        <label for="">내용</label>
      </div>
      <div class="col col-md-9">
        <textarea name="description" rows="8" cols="80" class="form-control" required></textarea>
      </div>
    </div>
    <button type="submit" name="button" class="btn btn-primary">저장</button>
  </form>
</section>

<script>
var screen = $('select[name="screen"]').val();
var screenItem = smsAddArray[screen];

$('textarea[name="screenItem"]').text(screenItem);
// console.log(screenItem);

$('select[name="screen"]').on('change', function(){
    var screen = $('select[name="screen"]').val();
    var screenItem = smsAddArray[screen];

    $('textarea[name="screenItem"]').text(screenItem);
})

</script>



<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
