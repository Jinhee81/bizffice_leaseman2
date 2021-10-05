<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
?>

<!-- <script src="csaddss.js?v=<%=System.currentTimeMillis() %>"></script> -->
<style media="screen">
  .italic{
    font-style: italic;
    color: blue;
  }
</style>


<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">계약등록 csv화면입니다</h3>
    <p class="lead">이 화면에서는 엑셀업로드 형식으로 임대계약을 등록합니다.</p>
    <small>
      (1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)엑셀프로그램이 없다면 구글스프레드시트에서 작업하고 링크 주소를 아래 메일로 보내주세요. <a href="https://docs.google.com/spreadsheets/d/1VVLH_oyEs4GmCK3Um7gvifQR-vKJ6t0E4z7n6AYlN8A/edit#gid=0" target="_blank" class="badge badge-success">구글스프레드시트 바로가기</a><br>
      (3)계약일자, 시작일, 보증금입금일은 날짜형식입니다. 'yyyy-mm-dd'형식으로 업로드하여 주세요. <br>
      (4)공급가액, 세액, 보증금은 숫자형식입니다. 숫자사이의 천단위 콤마(,)를 제외하여 업로드하여 주세요.
    </small>

    <hr class="my-4">
    <form name="uploadForm" id="uploadForm" method="post" action="contractCsv2.php" enctype="multipart/form-data">
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
        <td><span id='star' style='color:#F7BE81;'>* </span>물건IDX</td>
        <td><span id='star' style='color:#F7BE81;'>* </span>그룹IDX</td>
        <td><span id='star' style='color:#F7BE81;'>* </span>관리호수IDX</td>
        <td><span id='star' style='color:#F7BE81;'>* </span>관계자IDX</td>
        <td>계약일자</td>
        <td>공급가액</td>
        <td>세액</td>
        <td>개월수</td>
        <td>시작일</td>
        <td>보증금</td>
        <td>보증금입금일</td>
      </tr>
      <tr>
        <td></td><!--물건명-->
        <td></td><!--그룹명-->
        <td></td><!--관리번호-->
        <td></td><!--성명-->
        <td></td><!--계약일자-->
        <td></td><!--공급가액-->
        <td></td><!--세액-->
        <td></td><!--개월수-->
        <td></td><!--시작일-->
        <td></td><!--보증금-->
        <td></td><!--보증금입금일-->
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
      </tr>
      <tr class="italic">
        <td>도레미고시원</td>
        <td>9층</td>
        <td>901호</td>
        <td>이효리</td>
        <td>2020-01-01</td>
        <td>500000</td>
        <td>0</td>
        <td>12</td>
        <td>2020-01-01</td>
        <td>500000</td>
        <td>2020-01-01</td>
      </tr>
      <tr class="italic">
        <td>도레미고시원</td>
        <td>10층</td>
        <td>1001호</td>
        <td>이상순</td>
        <td>2020-01-01</td>
        <td>300000</td>
        <td>0</td>
        <td>12</td>
        <td>2020-01-01</td>
        <td>300000</td>
        <td>2020-01-01</td>
      </tr>
      <tr>
        <!-- <td colspan="11" class="text-left font-weight-light">
          *주의사항<br>
          물건명, 그룹명, 관리번호는 반드시 환경설정에서 등록한 이름 그대로 사용해주세요(안그러면 인식을 못합니다)<br>
          성명에는 반드시 관계자에서 등록한 이름 그대로 사용해주세요 (안그러면 인식을 못합니다.)<br>
          공급가액, 세액, 보증금 항목은 콤마(,)를 제거하여 숫자만 넣어주세요.
          날짜 입력시 yyyy-mm-dd형식으로 입력해주세요. 7월4일 이런식으로 글자가 들어가면 오류 발생합니다.<br><br>

          이 작업이 어렵고 번거롭지만, 이것만 해내면 정말 편리한 임대관리시스템을 만날 수 있으니 힘내세요!

        </td> -->
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
