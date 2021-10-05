<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";
?>

<style>
        @media (max-width: 990px) {
        .mobile {
          display: none;
        }
}
</style>


<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4">세입자 등록 화면입니다!</h1>
    <p class="lead">입주한 세입자 뿐만아니라 문의하는 사람, 거래처도 등록할 수 있습니다.</p>
    <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다.(2) 구분(대)의 값이 '세입자'이어야 방계약 등록이 가능합니다. (3)'일괄등록'은 데스크탑화면에서 가능합니다 (모바일화면 사용불가) (4)'csv등록'은 데스크탑화면에서 가능합니다. </small>
    <hr class="my-4">
    <a class="btn btn-primary btn-sm mobile" href="m_c_adds.php" role="button">일괄등록</a>
    <a class="btn btn-primary btn-sm mobile" href="m_c_add_csv1.php" role="button">csv등록</a>
  </div>
</section>
<section class="container" style="max-width:700px;">
  <form method="post" action ="p_m_c_add.php">
    <div class="form-row">
      <div class="form-group col-md-4">
        <label>구분(대)</label>
      </div>
      <div class="form-group col-md-8">
        <select id="customer_div1" name="div1" class="form-control">
          <option value="문의">문의</option>
          <option value="세입자" selected>세입자</option>
          <option value="거래처">거래처</option>
          <option value="기타">기타</option>
        </select>
      </div>
    </div>
    <div class="form-row" id="idDiv2Large">
      <div class="form-group col-md-4">
        <label>구분(소)</label>
      </div>
      <div class="form-group col-md-8 text-center">
        <select id="idDiv2" name="div2" class="form-control">
          <option value="개인">개인</option>
          <option value="개인사업자">개인사업자</option>
          <option value="법인사업자">법인사업자</option>
        </select>
      </div>
    </div>
    <div id="gubun2Id">
    </div>
    <div id="centerSection">
    </div>
    <div class="">
      <button type='submit' class='btn btn-primary'>저장</button>
      <a href='customer.php'><button type='button' class='btn btn-secondary'>세입자리스트화면으로</button></a>
    </div>
  </form>
</section>

<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-ko.js"></script>
<script src="cadd11.js?v=<%=System.currentTimeMillis()%>"></script>

<?php include $_SERVER['DOCUMENT_ROOT']."/view/service_footer.php";?>
