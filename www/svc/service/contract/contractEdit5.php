<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>임대계약상세</title>
    <link rel="icon" type="image/x-icon" href="/svc/inc/img/icon/checkround.png">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no">

    <!-- 부트스트랩 css -->
    <link rel="stylesheet" href="/svc/inc/css/bootstrap.min.css">


    <!-- 달력 css -->
    <link rel="stylesheet" href="/svc/inc/css/jquery-ui.min.css">

    <!-- 세금계산서 css -->
    <link rel="stylesheet" href="/svc/inc/css/pops.css">

    <!-- 폰트어썸 css -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- 커스텀 css -->
    <link rel="stylesheet" href="/svc/inc/css/customizing.css?<?=date('YmdHis')?>">

    <!-- fullCalendar css -->
    <link rel="stylesheet" href="/svc/inc/css/fullcalendar.css?<?=date('YmdHis')?>">
    <link rel="stylesheet" href="/svc/inc/css/fullcalendar.min.css?<?=date('YmdHis')?>">
  </head>
<?php
// include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "building.php";
include "./condi/sql_all.php";
include "./condi/sql_deposit.php";
include "./condi/sql_file.php";
include "./condi/sql_memo.php";
include "contractEdit_cs_modal_nadd.php";//n개월추가모달
include "contractEdit_cs_modal_regist.php";//청구설정모달
 ?>
<style>

/* 세금계산서 iframe 크기 조절  */
.popup_iframe{position:fixed;left:0;right:0;top:0;bottom:0;z-index:9999;width:100%;height:100%;display:none;}

#wrap {
 position: absolute;
 width: 100%;
 height: 100%;
}

</style>

<section class="container jumbotron pt-3 pb-3 mb-2">
  <label for="" style="font-size:32px;">임대계약상세(화면번호 202)</label>
  <label class="font-italic" style="font-size:20px;color:#2E9AFE;">계약번호 <?=$filtered_id?></label>
</section>

<section>
  <div class="row justify-content-center">
    <div class="col-11">
    <?php include "./edit/1_button.php";?>
    <?php include "./edit/2_ci.php";?>
    </div>
  </div>
</section>

<!-- 하단 탭 -->
<section class="container">
  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">임대료목록(<?=$row['count2']?>개월)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/3_schedule.php";
    include "../modal/modal_nadd.php";//n개월추가모달
    include "../modal/modal_regist.php";//청구설정모달
    ?>
  </div>

  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">보증금 (<span name="depositMoney"></span>원)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/4_deposit.php";
    ?>
  </div>

  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">첨부파일(<?=count($fileRows)?>건)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/5_file.php";
    ?>
  </div>

  <nav class="">
    <ul class="nav nav-tabs">
      <li class="nav-items">
        <a id="navMemo" class="nav-link" href="contractEdit.php?id=<?=$filtered_id?>">메모작성(<?=count($memoRows)?>건)</a>
      </li>
    </ul>
  </nav>
  <div class="">
    <?php
    include "./edit/6_memo.php";
    ?>
  </div>
</section>


<!-- 종료일 입력 Modal -->
<div class="modal fade" id="modalEnd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">중간종료일을 입력하세요.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-md-center">
          <div class="col col-md-8">
            <input type="text" class="form-control form-control-sm text-center dateType pink" id="enddate3" value="<?=$row['endDate2']?>">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" id="enddate3btn">입력</button>
      </div>
    </div>
  </div>
</div>


  <!-- 최하단 계약정보작성자보여주기섹션 -->
  <section class="d-flex justify-content-center">
     <small class="form-text text-muted text-center">계약번호[<?=$row[0]?>] 등록일시[<?=$row['createTime']?>] 수정일시[<?=$row['updateTime']?>] </small>
  </section>

</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/service/customer/modal_customer.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/sms/modal_sms3.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>


<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/autosize.min.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/uploadfile.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/sms_noneparase4.js?<?=date('YmdHis')?>"></script>
<script src="j_checksum_cd.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/customer.js?<?=date('YmdHis')?>"></script>
<script src="/svc/inc/js/etc/ce_pl_f.js?<?=date('YmdHis')?>"></script>

<script type="text/javascript">
   var buildingArray = <?php echo json_encode($buildingArray); ?>;
   var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
   var roomArray = <?php echo json_encode($roomArray); ?>;
   console.log(buildingArray);
   console.log(groupBuildingArray);
   console.log(roomArray);
</script>

<script>

let contractId = <?=$_GET['id']?>;

$(document).on('click', '.dateType', function(){
  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
    closeText: '닫기'  // 닫기 버튼 패널
  })
})

$(document).ready(function(){
  autosize($('textarea[name=memoContent]'));

  $('.dateType').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
    closeText: '닫기'  // 닫기 버튼 패널
  })

  $(".amountNumber").click(function(){
    $(this).select();
  });

  $("input:text[numberOnly]").number(true);

  $(".numberComma").number(true);

})

depositlist(contractId);
memolist(contractId);
filelist(contractId);
amountlist(contractId);



</script>


</body>
</script>
