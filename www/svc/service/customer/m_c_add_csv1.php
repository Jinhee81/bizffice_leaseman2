<?php
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
    <h3 class="">CSV파일등록 화면입니다!</h3>
    <p class="lead">이 화면에서는 엑셀업로드형식으로 입주자를 등록합니다. </p>
    <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)엑셀프로그램이 없다면 구글스프레드시트에서 작업하고 링크 주소를 아래 메일로 보내주세요. <a href="https://docs.google.com/spreadsheets/d/1VVLH_oyEs4GmCK3Um7gvifQR-vKJ6t0E4z7n6AYlN8A/edit#gid=0" target="_blank" class="badge badge-success">구글스프레드시트 바로가기</a></small>
    <hr class="my-4">
    <!-- <div class="input-group mb-3">
      <div class="custom-file">
        <input type="file" class="custom-file-input" id="inputGroupFile02">
        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
      </div>
      <div class="input-group-append">
        <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
      </div>
    </div> -->
    <form name="uploadForm" id="uploadForm" method="post" action="m_c_add_csv2.php" enctype="multipart/form-data">
      <label for="">첨부파일</label>
      <input type="file" name="upfile" id="upfile">
      <input type="button" name="uploadBtn" value="업로드">
    </form>
  </div>
</section>

<section class="container">
  <div class="example">
    <table class="table table-bordered text-center">
      <tr>
        <td><span id='star' style='color:#F7BE81;'>* </span>구분</td>
        <td><span id='star' style='color:#F7BE81;'>* </span>구분2</td>
        <td>성명</td>
        <td>연락처</td>
        <td>성별</td>
        <td>이메일</td>
        <td>사업자구분</td>
        <td>사업자명</td>
        <td>사업자번호</td>
        <td>업태</td>
        <td>종목</td>
        <td>특이사항</td>
      </tr>
      <tr>
        <td>
          입주자,<br>
          거래처,<br>
          기타
        </td><!--구분1-->
        <td>
          개인,<br>
          개인사업자,<br>
          법인사업자
        </td><!--구분2-->
        <td></td><!--성명-->
        <td>010-111-1111형식</td><!--연락처-->
        <td>남,여</td><!--성별-->
        <td>@포함해야</td><!--이메일-->
        <td>
          주식회사,<br>
          합자회사,<br>
          유한회사,<br>
          기타
        </td><!--법인사업자구분-->
        <td></td><!--사업자명-->
        <td>123-12-12345형식</td><!--사업자번호-->
        <td></td><!--업태-->
        <td></td><!--업종-->
        <td></td><!--특이사항-->
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="italic">
        <td>예시)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="italic">
        <td>입주자</td>
        <td>개인</td>
        <td>원빈</td>
        <td>010-1234-1234</td>
        <td>남</td>
        <td>bin@hanmail.net</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="italic">
        <td>입주자</td>
        <td>개인사업자</td>
        <td>박보검</td>
        <td>010-1234-1234</td>
        <td>남</td>
        <td>bo@hanmail.net</td>
        <td></td>
        <td>리스맨소프트</td>
        <td>123-12-12345</td>
        <td>서비스</td>
        <td>시스템</td>
        <td></td>
      </tr>
      <tr class="italic">
        <td>입주자</td>
        <td>법인사업자</td>
        <td>싸이</td>
        <td>010-1234-1234</td>
        <td>남</td>
        <td>psy@hanmail.net</td>
        <td>주식회사</td>
        <td>싸이터스</td>
        <td>123-12-12345</td>
        <td>서비스</td>
        <td>연예기획</td>
        <td></td>
      </tr>
      <tr class="italic">
        <td>거래처</td>
        <td>개인사업자</td>
        <td>공유</td>
        <td>010-1234-1234</td>
        <td>남</td>
        <td>kong@hanmail.net</td>
        <td></td>
        <td>공유청소</td>
        <td>123-12-12345</td>
        <td>서비스</td>
        <td>환경관리</td>
        <td></td>
      </tr>

      <tr>
        <td colspan="12" class="text-left font-weight-light">
          (1) <div class="badge badge-primary text-wrap" style="width: 3rem;">구분1</div> : '입주자','거래처','기타' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.(필수값)<br>
          (2) <div class="badge badge-primary text-wrap" style="width: 3rem;">구분2</div> : '개인','개인사업자','법인사업자' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.(필수값)<br>
          (3) <div class="badge badge-primary text-wrap" style="width: 3rem;">성명</div> : 자유롭게 적어주는데 보통 사람이름을 적어주세요.<br>
          (4) <div class="badge badge-primary text-wrap" style="width: 3rem;">연락처</div> : '010-1234-1234' 형식으로 넣어주세요. 만약 유선번호일경우 반드시 지역번호 포함하여 '02-111-1234'로 '-'가 2개이며, 숫자만 입력되어야 합니다.<br>
          (5) <div class="badge badge-primary text-wrap" style="width: 3rem;">성별</div> : '남','여' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.<br>
          (6) <div class="badge badge-primary text-wrap" style="width: 3rem;">이메일</div> : @를 포함한 이메일형식으로 넣어주세요.<br>
          (7) <div class="badge badge-primary text-wrap" style="width: 6rem;">법인사업자구분</div> : '주식회사','합자회사','유한회사' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.<br>
          (8) <div class="badge badge-primary text-wrap" style="width: 4rem;">사업자명</div> : 사업자명을 적어주세요.<br>
          (9) <div class="badge badge-primary text-wrap" style="width: 4rem;">사업자번호</div> : 사업자번호를 123-12-12345 형식으로 넣어주세요. 이 형식이 아닐경우 오류발생합니다.<br>
          (10) <div class="badge badge-primary text-wrap" style="width: 3rem;">업태</div> : 사업자등록증에 기재된 업태를 자유롭게 적어주세요.<br>
          (11) <div class="badge badge-primary text-wrap" style="width: 3rem;">종목</div> : 사업자등록증에 기재된 종목을 자유롭게 적어주세요.<br>
          (12) <div class="badge badge-primary text-wrap" style="width: 4rem;">특이사항</div> : 자유롭게 적어주세요.
        </td>
      </tr>
    </table>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){

  $('input[name=uploadBtn]').on('click', function(){
    var extArray = new Array('csv');
    var path = $('#upfile').val();
    console.log(path);

    if(path===""){
      alert('파일을 선택해주세요.');
      return false;
    }

    var pos = path.lastIndexOf(".");
    if(pos < 0){
      alert('확장자가 없는 파일입니다.');
      return false;
    }

    var ext = path.slice(path.lastIndexOf(".")+1).toLowerCase();
    var checkExt = false;
    for (var i = 0; i < extArray.length; i++) {
      if(ext === extArray[i]){
        checkExt = true;
        break;
      }
    }
    // console.log(ext, checkExt);

    if(checkExt === false){
      alert('csv확장자만 업로드 가능합니다.');
      return false;
    }

    var f = $('#uploadForm');
    f.submit();
  })

})//docu.ready }

</script>

</body>
</html>
