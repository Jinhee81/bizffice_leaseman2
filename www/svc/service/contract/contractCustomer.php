<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/service/contract/building.php";
?>

<!-- <script src="csaddss.js?v=<%=System.currentTimeMillis() %>"></script> -->

<style>
  .inputWithIcon input[type=search]{
    padding-left: 40px;
  }
  .inputWithIcon {
    position: relative;
  }
  .inputWithIcon i{
    position: absolute;
    left: 4px;
    top: 4px;
    padding: 9px 8px;
    color: #aaa;
    transition: .3s;
  }
  .inputWithIcon input[type=search]:focus+i{
    color: dodgerBlue;
  }
  #customerList ul {
    background-color: #eee;
    cursor: pointer;
  }
  #customerList li {
    padding: 12px;
  }
</style>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4">그룹별 세입자 등록 화면입니다!</h1>
    <!-- <p class="lead">이 화면에서는 각 방의 세입자를 등록합니다.</p> -->
    <small>
      <!-- (1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다.  -->
      (1)공실일 경우는 행삭제를 하여 없애주세요.</small>
    <hr class="my-4">
  </div>
</section>
<section class="container">
      <div class="d-flex justify-content-center">
        <!-- <label for="">물건명</label>
        <select class="form-control form-control-sm" id="select1">
        </select>
        <label for="">그룹명</label>
        <select class="form-control form-control-sm" id="select2">
        </select> -->
          <div class="form-group col-md-2 text-center">
              <label for="">물건명</label>
          </div>
          <div class="form-group col-md-2">
              <select class="form-control form-control-sm" id="select1">
              </select>
          </div>
          <div class="form-group col-md-2 text-center">
              <label for="">그룹명</label>
          </div>
          <div class="form-group col-md-2">
              <select class="form-control form-control-sm" id="select2">
              </select>
          </div>
          <!-- <div class="form-group col-md-2">
              <button type="button" name="" class="btn btn-info btn-block btn-sm">생성하기
              </button>
          </div> -->
      </div>
      <form method="post" action="p_roomCustomer_add.php">
          <div class="container" id="" style="max-width:800px;">
              <table class='table table-bordered text-center' id="table1">
              </table>
          </div>
          <div class="d-flex justify-content-center">
              <button type='button' class='btn btn-primary mr-1' name='saveBtn'>저장</button>
              <a href='contract.php'><button type='button' class='btn btn-secondary'>계약리스트화면으로</button></a>
          </div>
      </form>
</section>

<script>

    var select1option, select2option, buildingIdx, groupIdx;

    for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
        select1option = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
        $('#select1').append(select1option);
    }
    buildingIdx = $('#select1').val();

    for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
        select2option = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
        // console.log(select3option);
        $('#select2').append(select2option);
    }
    groupIdx = $('#select2').val();

    var tableTitle = "<tr><td>관리호수</td><td><span id='star' style='color:#F7BE81;'>* </span>고객정보</td></tr>";
    $('#table1').append(tableTitle);

    var tableCol2 ="<td><input type='search' name='customer' class='form-control form-control-sm text-center' required><div class='' name='customerList'></div></td>"; //고객정보

    for(var key in roomArray[groupIdx]){

        // customerSearch();

        var tableCol1 = "<tr><td><input type='hidden' value='"+key+"'><input type='text' class='form-control form-control-sm text-center' value='"+roomArray[groupIdx][key]+"' disabled><div class='badge badge-warning text-wrap' style='width: 3rem;' name='rowDeleteBtn'>행삭제</div></td>";

        var tableRow = tableCol1 + tableCol2;

        $('#table1').append(tableRow);//관리호수

    }


    $('#select1').on('change', function(event){
        buildingIdx = $('#select1').val();
        $('#select2').empty();
        for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
          select2option = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
          // console.log(select3option);
          $('#select2').append(select2option);
        }
        groupIdx = $('#select2').val();

        $('#table1').empty();
        $('#table1').append(tableTitle);
        for(var key in roomArray[groupIdx]){
            // customerSearch();
            var tableCol1 = "<tr><td><input type='hidden' value='"+key+"'><input type='text' class='form-control form-control-sm text-center' value='"+roomArray[groupIdx][key]+"' disabled><div class='badge badge-warning text-wrap' style='width: 3rem;' name='rowDeleteBtn'>행삭제</div></td>";
            var tableRow = tableCol1 + tableCol2;
            $('#table1').append(tableRow);//관리호수
        }
        $('div[name="rowDeleteBtn"]').on('click', function(){
          console.log('삭제하기');
          var currow = $(this).closest('tr');
          currow.remove();
          // alert('삭제하였습니다');
        })

    }) // select1 change function closing

    $('#select2').on('change', function(event){
        groupIdx = $('#select2').val();
        $('#table1').empty();
        $('#table1').append(tableTitle);
        for(var key in roomArray[groupIdx]){
            // customerSearch();
            var tableCol1 = "<tr><td><input type='hidden' value='"+key+"'><input type='text' class='form-control form-control-sm text-center' value='"+roomArray[groupIdx][key]+"' disabled><div class='badge badge-warning text-wrap' style='width: 3rem;' name='rowDeleteBtn'>행삭제</div></td>";
            var tableRow = tableCol1 + tableCol2;
            $('#table1').append(tableRow);//관리호수
        }
        $('div[name="rowDeleteBtn"]').on('click', function(){
          // console.log('삭제하기');
          var currow = $(this).closest('tr');
          currow.remove();
          // alert('삭제하였습니다');
        })
    }) // select2 change function closing

    $('div[name="rowDeleteBtn"]').on('click', function(){
      // console.log('삭제하기');
      var currow = $(this).closest('tr');
      currow.remove();
      // alert('삭제하였습니다');
    })

    $('.table').on('keyup', 'input[type="search"]', function(){
      var currow = $(this).closest('tr');
      var query = $(this).val();
      // console.log(query);
      if(query != ''){
        $.ajax({
                url: 'p_customer_search.php',
                method: 'post',
                data: {query : query},
                success: function(data){
                  currow.find('div[name="customerList"]').fadeIn();
                  currow.find('div[name="customerList"]').html(data);
                  }
              })
      }
  })

  $(document).on('click', 'li', function(){
      var currow = $(this).closest('tr');

      currow.find('input[name="customer"]').val($(this).text());
      currow.find('div[name="customerList"]').fadeOut();
  })

  // $('button[name="saveBtn"]').on('click', function(){
  //   $('form').submit();
  // })

$('button[name="saveBtn"]').on('click', function(){
  var allCnt = Number($('#table1 input[type="search"]').length);
  console.log(allCnt);
  var allArray = [];

  for (var i = 1; i <= allCnt; i++) {
    var currow = $('tr').eq(i);
    var curArray = [];
    var col1 = currow.find('td:eq(0)').children('input:eq(1)').val();//관리호수
    var col11 = currow.find('td:eq(0)').children('input:eq(0)').val();//관리호수 idx
    var col2 = currow.find('td:eq(1)').children('input').val();//고객정보
    if(!col2){
      alert('고객정보는 필수값입니다.');
      return false;
    }

    curArray.push(col1, col11, col2);
    allArray.push(curArray);
  }

  var aa = 'p_roomCustomer_add';
  var bb = 'p_roomCustomer_add.php';
  var cc = JSON.stringify(allArray);

  goCategoryPage(aa, bb, cc, buildingIdx, groupIdx);

  function goCategoryPage(a, b, c, d, e){
    var frm = formCreate(a, 'post', b,'');
    frm = formInput(frm, 'buildingId', d);
    frm = formInput(frm, 'groupId', e)
    frm = formInput(frm, 'array', c);
    formSubmit(frm);
  }


})

</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/view/service_footer.php";?>
