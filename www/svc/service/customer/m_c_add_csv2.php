<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";
// print_r($_POST);
// print_r($_FILES);

if(isset($_FILES['upfile']) && $_FILES['upfile']['name'] !== ""){
  $file = $_FILES['upfile'];
  $max_file_size = 5242880;

  if($file['size'] >= $max_file_size){
    echo "<script>alert('5MB 까지만 업로드 가능합니다.');</script>";
  }

  $handle = fopen($file['tmp_name'], 'r');?>
  <style>
  .fixed-table-body{
    /* width: 100%;
    height: 100%; */
    overflow-x: auto;
  }
  </style>
  <div class="container-fluid">
    <div class="jumbotron pt-3 pb-3">
      <h3 class="">업로드한 파일 내용입니다.</h3>
      <!-- <p class="lead">이 화면에서는 한꺼번에 많은 방계약들을 등록합니다.</p> -->
      <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)잘못 입력된 내용은 글자색이 빨간색이니 주의하세요.</small>
      <hr class="my-4">
      <small>
        (1) <div class="badge badge-primary text-wrap" style="width: 3rem;">구분1</div> : '입주자','거래처','기타' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.(필수값)<br>
        (2) <div class="badge badge-primary text-wrap" style="width: 3rem;">구분2</div> : '개인','개인사업자','법인사업자' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.(필수값)<br>
        (3) <div class="badge badge-primary text-wrap" style="width: 3rem;">성명</div> : 자유롭게 적어주는데 보통 사람이름을 적어주세요. <br>
        (4) <div class="badge badge-primary text-wrap" style="width: 3rem;">연락처</div> : '010-1234-1234' 형식으로 넣어주세요. 만약 유선번호일경우 반드시 지역번호 포함하여 '02-111-1234'로 '-'가 2개이며, 숫자만 입력되어야 합니다.<br>
        (5) <div class="badge badge-primary text-wrap" style="width: 3rem;">성별</div> : '남','여' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.<br>
        (6) <div class="badge badge-primary text-wrap" style="width: 3rem;">이메일</div> : @를 포함한 이메일형식으로 넣어주세요. <br>
        (7) <div class="badge badge-primary text-wrap" style="width: 6rem;">법인사업자구분</div> : '주식회사','합자회사','유한회사' 중 1개의 값만 넣으세요. 오타/띄어쓰기에 유의하여 주세요.<br>
        (8) <div class="badge badge-primary text-wrap" style="width: 4rem;">사업자명</div> : 사업자명을 적어주세요.<br>
        (9) <div class="badge badge-primary text-wrap" style="width: 4rem;">사업자번호</div> : 사업자번호를 123-12-12345 형식으로 넣어주세요. 이 형식이 아닐경우 오류발생합니다.<br>
        (10) <div class="badge badge-primary text-wrap" style="width: 3rem;">업태</div> : 사업자등록증에 기재된 업태를 자유롭게 적어주세요. <br>
        (11) <div class="badge badge-primary text-wrap" style="width: 3rem;">종목</div> : 사업자등록증에 기재된 종목을 자유롭게 적어주세요. <br>
        (12) <div class="badge badge-primary text-wrap" style="width: 4rem;">특이사항</div> : 자유롭게 적어주세요.
      </small>
    </div>
    <form method="post" action="p_cfile_upload_csv.php">
    <div class="fixed-table-container">
      <div class="fixed-table-body">
        <table class="table table-bordered text-center" fixed-header id="customerTable">
          <tr>
            <td width="5%"><span id='star' style='color:#F7BE81;'>* </span>순번</td>
            <td width="5%"><span id='star' style='color:#F7BE81;'>* </span>구분1</td>
            <td width="5%"><span id='star' style='color:#F7BE81;'>* </span>구분2</td>
            <td width="6%">성명</td>
            <td width="10%">연락처</td>
            <td width="5%">성별</td>
            <td width="14%">이메일</td>
            <td width="8%">법인사업자<br>구분</td>
            <td width="10%">사업자명</td>
            <td width="10%">사업자번호</td>
            <td width="6%">업태</td>
            <td width="6%">종목</td>
            <td width="5%">특이사항</td>
            <td width="5%"></td>
          </tr>
          <?php
            $i = 1;
            while($data = fgetcsv($handle)){
              ?>
            <tr>
              <td><?=$i?></td><!--순번-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>div1" value="<?=$data[0]?>" required>
              </td><!--구분1-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>div2" value="<?=$data[1]?>" required>
              </td><!--구분2-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>name" value="<?=$data[2]?>">
              </td><!--성명-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>contact" value="<?=$data[3]?>">
              </td><!--연락처-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>gender" value="<?=$data[4]?>">
              </td><!--성별-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>email" value="<?=$data[5]?>">
              </td><!--이메일-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>div3" value="<?=$data[6]?>" numberOnly>
              </td><!--법인사업자구분-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>companyname" value="<?=$data[7]?>">
              </td><!--사업자명-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>companyNumber" value="<?=$data[8]?>">
              </td><!--사업자번호-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="number" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>div4" value="<?=$data[9]?>">
              </td><!--업태-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>div5" value="<?=$data[10]?>">
              </td><!--종목-->
              <td class="pl-1 pr-1 pt-1 pb-1">
                <input type="text" class="form-control form-control-sm pl-1 pr-1 pt-1 pb-1 text-center" name="<?=$i?>etc" value="<?=$data[11]?>">
              </td><!--특이사항-->
              <td class="pl-1 pr-1 pt-2 pb-1">
                <img src="/svc/inc/img/svg/minus.svg" width="20" name="minus">
              </td><!--행추가/삭제-->
            </tr>
          <?php
          $i = $i + 1;
        }
          ?>
        </table>
      </div>
      <div class="d-flex justify-content-center">

        <table width="350px;">
          <tr>
            <td width="35%"><select name="building" class="form-control">
            </select></td>
            <td width="20%"><button type="button" name="saveBtn" class="btn btn-primary btn-block">등록</button></td>
            <td width="40%"><a href="m_c_add_csv1.php"><button type="button" name="button" class="btn btn-secondary mr-1">이전화면 <i class="fas fa-angle-double-right"></i></button></a></td>
          </tr>
        </table>

      </div>
    </div>
  </form>

  </div>
<?php
}
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script type="text/javascript">
  var buildingArray = <?php echo json_encode($buildingArray); ?>;
  // console.log(buildingArray);
  var groupoption;
  for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
    groupoption = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
    $('select[name=building]').append(groupoption);
  }
</script>

<script>

$(document).ready(function(){
  var customerTable = $('#customerTable');
  var div1 = ['입주자', '거래처', '기타'];
  var div2 = ['개인', '개인사업자', '법인사업자'];
  var gender = ['남', '여'];
  var div3 = ['', '주식회사', '유한회사', '합자회사', '기타'];

  var conclude = [0,0,0,0,0,0,0,0,0,0,0,0,0]; //0이 정상, 1이 오류.
  var errorVal = ['','','','','','','','','','','','','']; //여기에 에러값을 넣음
  //cdiv1, cdiv2, cname, ccontact, cgender, cemail, cdiv3, cdiv4, ccompanyname, ccompanynumber, cdiv4, cdiv5, cetc 13개의 값


  $('img[name="minus"]').on('click', function(){
    // console.log('삭제하기');
    // var deleteCheck = confirm('정말 삭제하겠습니까?');
    // if(deleteCheck){
    //   var currow = $(this).closest('tr');
    //   conclude = [0,0,0,0,0,0,0,0,0,0,0,0,0]; //0이 정상, 1이 오류.
    //   errorVal = ['','','','','','','','','','','','',''];
    //   currow.remove();
    //   // alert('삭제하였습니다');
    //   // 매번 삭제확인 너무 귀찮아서 그냥 없애기로 함
    //   //행삭제에 cunclude, errorVal 초기값을 넣는 이유가 이래야지 에전오류났던거가 지워짐...(중요)
    // }

    var currow = $(this).closest('tr');
    conclude = [0,0,0,0,0,0,0,0,0,0,0,0,0]; //0이 정상, 1이 오류.
    errorVal = ['','','','','','','','','','','','',''];
    currow.remove();
  })


  $('button[name="saveBtn"]').on('click', function(){
    var currow, ordered;

    $(".div1:input", customerTable).each(function(){
      var div11 = $(this).val();
      if(div1.indexOf(div11) === -1){
        $(this).css('color', 'red');
        conclude[0] = 1;
        errorVal[0] = div11;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".div2:input", customerTable).each(function(){
      var div21 = $(this).val();
      if(div2.indexOf(div21) === -1){
        $(this).css('color', 'red');
        conclude[1] = 1;
        errorVal[1] = div21;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".name:input", customerTable).each(function(){
      var name1 = $(this).val();
      if(name1.length > 20){
        $(this).css('color', 'red');
        conclude[2] = 1;
        errorVal[2] = name1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".contact:input", customerTable).each(function(){
      var contact1 = $(this).val();
      var contact2 = contact1.split('-');
      // console.log(contact2);
      if((Number(contact2[0]) && contact2[0].length<4) &&
         (Number(contact2[1]) && contact2[1].length<=4) &&
         (Number(contact2[2]) && contact2[2].length<=4))
      {} else {
        $(this).css('color', 'red');
        conclude[3] = 1;
        errorVal[3] = contact1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".gender:input", customerTable).each(function(){
      var gender1 = $(this).val();
      if(gender.indexOf(gender1) === -1){
        $(this).css('color', 'red');
        conclude[4] = 1;
        errorVal[4] = gender1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".email:input", customerTable).each(function(){
      var email1 = $(this).val();
      if(email1.length > 40){
        $(this).css('color', 'red');
        conclude[5] = 1;
        errorVal[5] = email1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".div3:input", customerTable).each(function(){
      var div31 = $(this).val();
      if(div3.indexOf(div31) === -1){
        $(this).css('color', 'red');
        conclude[6] = 1;
        errorVal[6] = div31;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".companyname:input", customerTable).each(function(){
      var companyname1 = $(this).val();
      if(companyname1.length > 40){
        $(this).css('color', 'red');
        conclude[7] = 1;
        errorVal[7] = companyname1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".companyNumber:input", customerTable).each(function(){
      var companyNumber1 = $(this).val().trim();
      var companyNumber2 = companyNumber1.split('-');
      // console.log(contact2);
      var condi1 = Number(companyNumber2[0]) && companyNumber2[0].length==3;
      var condi2 = Number(companyNumber2[1]) && companyNumber2[1].length==2;
      var condi3 = Number(companyNumber2[2]) && companyNumber2[2].length==5;

      console.log(condi1, condi2, condi3);

      if(companyNumber1.length===0 || companyNumber1.length===2){

      } else if(companyNumber1.length===12){
        if(!(condi1 && condi2 && condi3)){
          $(this).css('color', 'red');
          conclude[8] = 1;
          errorVal[8] = companyNumber1;
          currow = $(this).closest('tr');
          ordered = currow.children('td:eq(0)').text();
          return false;
        }
      } else {
        $(this).css('color', 'red');
        conclude[8] = 1;
        errorVal[8] = companyNumber1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }

    })

    $(".div4:input", customerTable).each(function(){
      var div41 = $(this).val();
      if(div41.length > 40){
        $(this).css('color', 'red');
        conclude[9] = 1;
        errorVal[9] = div41;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".div5:input", customerTable).each(function(){
      var div51 = $(this).val();
      if(div51.length > 40){
        $(this).css('color', 'red');
        conclude[10] = 1;
        errorVal[10] = div51;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    $(".etc:input", customerTable).each(function(){
      var etc1 = $(this).val();
      if(etc1.length > 90){
        $(this).css('color', 'red');
        conclude[11] = 1;
        errorVal[11] = etc1;
        currow = $(this).closest('tr');
        ordered = currow.children('td:eq(0)').text();
        return false;
      }
    })

    //===========중복체크부분, 일단 넣지않기로

    // var namearray = [];
    // var namecount = $('.name:input', customerTable).length;
    //
    // for (var i = 0; i < namecount; i++) {
    //   var a = $('.name:eq('+i+')').val();
    //   namearray.push(a);
    // }
    //
    // for (var i = 0; i < namearray.length; i++) {
    //   for (var j = i+1; j < namearray.length; j++) {
    //     if(namearray[i]===namearray[j]){
    //       alert(namearray[i]+' 이름이 중복되어 등록 불가합니다. 다시 확인해주세요.');
    //       return false;
    //     }
    //   }
    // }
    //
    // var contactarray = [];
    // var contactcount = $('.contact:input', customerTable).length;
    //
    // for (var i = 0; i < contactcount; i++) {
    //   var a = $('.contact:eq('+i+')').val();
    //   contactarray.push(a);
    // }
    //
    // for (var i = 0; i < contactarray.length; i++) {
    //   for (var j = i+1; j < contactarray.length; j++) {
    //     if(contactarray[i]===contactarray[j]){
    //       alert(contactarray[i]+' 연락처가 중복되어 등록 불가합니다. 다시 확인해주세요.');
    //       return false;
    //     }
    //   }
    // }

    //===========중복체크부분, 일단 넣지않기로  함 ^

    var lastconclude = conclude.indexOf(1);
    // console.log(conclude);
    // console.log(lastconclude);

    if(lastconclude == -1){
      $('form').submit();
    } else {
      alert(ordered + '행에 잘못된값이 포함되어 등록을 할 수 없습니다.');
    }
  })//saveBtn }

  $(".div1:input", customerTable).on('change', function(){
    var div11 = $(this).val();
    if(div1.indexOf(div11) === -1){
      $(this).css('color', 'red');
      conclude[0] = 1;
      errorVal[0] = div11;
    } else {
      $(this).css('color', '#495057');
      conclude[0] = 0;
      errorVal[0] = '';
    }
  })
  $(".div2:input", customerTable).on('change', function(){
    var div21 = $(this).val();
    if(div2.indexOf(div21) === -1){
      $(this).css('color', 'red');
      conclude[1] = 1;
      errorVal[1] = div21;
    } else {
      $(this).css('color', '#495057');
      conclude[1] = 0;
      errorVal[1] = '';
    }
  })
  $(".name:input", customerTable).on('change', function(){
    var name1 = $(this).val();
    if(name1.length > 20){
      $(this).css('color', 'red');
      conclude[2] = 1;
      errorVal[2] = name1;
    } else {
      $(this).css('color', '#495057');
      conclude[2] = 0;
      errorVal[2] = '';
    }
  })

  $(".contact:input", customerTable).on('change', function(){
    var contact1 = $(this).val();
    var contact2 = contact1.split('-');
    // console.log(contact2);
    if((Number(contact2[0]) && contact2[0].length<4) &&
       (Number(contact2[1]) && contact2[1].length<=4) &&
       (Number(contact2[2]) && contact2[2].length<=4))
    {
      $(this).css('color', '#495057');
      conclude[3] = 0;
      errorVal[3] = '';
    } else {
      $(this).css('color', 'red');
      conclude[3] = 1;
      errorVal[3] = contact1;
    }
  })
  $(".gender:input", customerTable).on('change', function(){
    var gender1 = $(this).val();
    if(gender.indexOf(gender1) === -1){
      $(this).css('color', 'red');
      conclude[4] = 1;
      errorVal[4] = gender1;
    } else {
      $(this).css('color', '#495057');
      conclude[4] = 0;
      errorVal[4] = '';
    }
  })
  $(".email:input", customerTable).on('change', function(){
    var email1 = $(this).val();
    if(email1.length > 40){
      $(this).css('color', 'red');
      conclude[5] = 1;
      errorVal[5] = email1;
    } else {
      $(this).css('color', '#495057');
      conclude[5] = 0;
      errorVal[5] = '';
    }
  })
  $(".div3:input", customerTable).on('change', function(){
    var div31 = $(this).val();
    if(div3.indexOf(div31) === -1){
      $(this).css('color', 'red');
      conclude[6] = 1;
      errorVal[6] = div31;
    } else {
      $(this).css('color', '#495057');
      conclude[6] = 0;
      errorVal[6] = '';
    }
  })
  $(".companyname:input", customerTable).on('click', function(){
    var companyname1 = $(this).val();
    if(companyname1.length > 40){
      $(this).css('color', 'red');
      conclude[7] = 1;
      errorVal[7] = companyname1;
    } else {
      $(this).css('color', '#495057');
      conclude[7] = 0;
      errorVal[7] = '';
    }
  })
  $(".companyNumber:input", customerTable).on('change', function(){
    var companyNumber1 = $(this).val();
    var companyNumber2 = companyNumber1.split('-');
    // console.log(contact2);
    var condi1 = Number(companyNumber2[0]) && companyNumber2[0].length==3;
    var condi2 = Number(companyNumber2[1]) && companyNumber2[1].length==2;
    var condi3 = Number(companyNumber2[2]) && companyNumber2[2].length==5;

    console.log(condi1, condi2, condi3);

    if(companyNumber1.length===0||companyNumber1.length===2){
      $(this).css('color', '#495057');
      conclude[8] = 0;
      errorVal[8] = '';
    } else if(companyNumber1.length===12){
      if(condi1 && condi2 && condi3){
        $(this).css('color', '#495057');
        conclude[8] = 0;
        errorVal[8] = '';
      } else {
        $(this).css('color', 'red');
        conclude[8] = 1;
        errorVal[8] = companyNumber1;
      }
    } else {
      $(this).css('color', 'red');
      conclude[8] = 1;
      errorVal[8] = companyNumber1;
    }
  })
  $(".div4:input", customerTable).on('change', function(){
    var div41 = $(this).val();
    if(div41.length > 40){
      $(this).css('color', 'red');
      conclude[9] = 1;
      errorVal[9] = div41;
    } else {
      $(this).css('color', '#495057');
      conclude[9] = 0;
      errorVal[9] = div41;
    }
  })
  $(".div5:input", customerTable).on('change', function(){
    var div51 = $(this).val();
    if(div51.length > 40){
      $(this).css('color', 'red');
      conclude[10] = 1;
      errorVal[10] = div51;
    } else {
      $(this).css('color', '#495057');
      conclude[10] = 0;
      errorVal[10] = div51;
    }
  })
  $(".etc:input", customerTable).on('change', function(){
    var etc1 = $(this).val();
    if(etc1.length > 100){
      $(this).css('color', 'red');
      conclude[11] = 1;
      errorVal[11] = etc1;
    } else {
      $(this).css('color', '#495057');
      conclude[11] = 0;
      errorVal[11] = etc1;
    }
  })


})//d.r }






</script>
