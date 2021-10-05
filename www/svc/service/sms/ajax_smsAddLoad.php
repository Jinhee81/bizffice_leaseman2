<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
// print_r($_SESSION);
// print_r($_POST);

if($_POST['screenName']==='all'){
  $etcCondi = "";
} else {
  $etcCondi = "and screen='{$_POST['screenName']}'";
}

$sql = "select
          id, screen, title, description
        from sms
        where user_id={$_SESSION['id']} $etcCondi";

$result = mysqli_query($conn, $sql);

$allRows = array();
while($row = mysqli_fetch_array($result)){
    $allRows[] = $row;
}
?>

<table class="table table-hover text-center">
  <tr class="table-primary">
    <td width="7%">순번</td>
    <td width="15%">화면</td>
    <td width="20%">제목</td>
    <td width="43%">내용</td>
    <td width="15%">관리</td>
  </tr>
  <?php
    for ($i=0; $i < count($allRows); $i++) {
      $j = $i + 1;?>
  <tr>
    <td><?=$j?><input type="hidden" value="<?=$allRows[$i]['id']?>"></td>
    <td>
        <select class="form-control" name="screenName" disabled>
            <option value="관계자화면"<?php if($allRows[$i]['screen']==='관계자화면'){echo "selected";}?>>관계자화면</option>
            <option value="임대계약화면"<?php if($allRows[$i]['screen']==='임대계약화면'){echo "selected";}?>>임대계약화면</option>
            <option value="납부예정화면"<?php if($allRows[$i]['screen']==='납부예정화면'){echo "selected";}?>>납부예정화면</option>
            <option value="납부완료화면"<?php if($allRows[$i]['screen']==='납부완료화면'){echo "selected";}?>>납부완료화면</option>
        </select>
    </td>
    <td><?=$allRows[$i]['title']?>
      <!-- <input type="text" class="form-control" value="<?=$allRows[$i]['title']?>" name="title" disabled> -->
    </td>
    <td><?=$allRows[$i]['description']?>
      <!-- <textarea name="description" class="form-control"  cols='80' rows='8' disabled><?=$allRows[$i]['description']?> -->
      <!-- </textarea> -->
    </td>
    <td>
      <button type="submit" name="edit" class="btn btn-default grey">
        <i class='far fa-edit'></i>
      </button>
      <button type="submit" name="delete" class="btn btn-default grey">
        <i class='far fa-trash-alt'></i>
      </button>
    </td>
  </tr>
  <?php  }
   ?>
  <tr id="lastRow1">

  </tr>
  <tr id="lastRow2" class="text-left">

  </tr>
  <tr id="lastRow3">
     <td colspan="5">
       <button type="button" class="btn btn-primary" id="addstring">추가하기</button>
     </td>
  </tr>
</table>

<script>
var newTr2 = "<td colspan='5' style='padding-left:20px;'><p class='grey'>*상용구항목<br>관계자화면 : {받는사람},{이메일}<br>임대계약화면 : {받는사람},{이메일},{계약일},{종료일}<br>납부예정화면 : {받는사람},{이메일},{예정일},{합계},{시작일},{종료일},{개월수},{연체일수},{연체이자},{사업자명},{방번호}<br>납부완료화면 : {받는사람},{이메일},{납부일},{증빙일},{공급가액},{세액},{합계},{사업자명},{방번호}<br></p></td>";


$('#addstring').on('click', function(){
    var td1 = "<td></td>";
    var td2 = "<td><select name='screen' class='form-control'><option value='관계자화면'>관계자화면</option><option value='임대계약화면'>임대계약화면</option><option value='납부예정화면'>납부예정화면</option><option value='납부완료화면'>납부완료화면</option></select></td>";
    var td3 = "<td><input type='text' class='form-control' name='title' required></td>";
    var td4 = "<td><textarea name='description' cols='80' rows='8' class='form-control' required></textarea></td>";
    var td5 = "<td><button type='submit' name='stringSave' class='btn btn-primary btn-sm mr-1'>저장</button><button type='button' name='stringCancel' class='btn btn-danger btn-sm'>취소</button></td>";

    var newTr1 =  td1 + td2 + td3 + td4 + td5;

    $('#lastRow1').append(newTr1);
    $('#lastRow2').append(newTr2);
    $('#lastRow3').hide();

    $('button[name="stringSave"]').on('click', function(){
      var screenName = $('select[name="screen"]').val();
      var title = $('input[name="title"]').val();
      var description = $('textarea[name="description"]').val();

      // console.log(screenName, title, description);

      if(title.length === 0){
        alert('제목은 필수 입력값입니다.');
        return false;
      }

      if(description.length === 0){
        alert('내용은 반드시 들어가야 합니다.');
        return false;
      }

      var aa = 'smsAdd';
      var bb = 'p_smsAdd.php';

      goCategoryPage(aa, bb, screenName, title, description);

      function goCategoryPage(a,b,c,d,e){
          var frm = formCreate(a, 'post', b,'');
          frm = formInput(frm, 'screenName', c);
          frm = formInput(frm, 'title', d);
          frm = formInput(frm, 'description', e);
          formSubmit(frm);
      }
    })//저장버튼클릭

    $('button[name="stringCancel"]').on('click', function(){
        $('#lastRow1').empty();
        $('#lastRow2').empty();
        $('#lastRow3').show();
    })//취소버튼 클릭

})//추가하기버튼 클릭

$('button[name="delete"]').on('click', function(){
  var smsid = $(this).parent().parent().children().children('input:eq(0)').val();

  // console.log(smsid);

  var aa = 'smsDelete';
  var bb = 'p_smsDelete.php';

  var deleteCheck = confirm('정말 삭제하겠습니까?');
  if(deleteCheck){
    goCategoryPage(aa,bb,smsid);

    function goCategoryPage(a,b,c){
      var frm = formCreate(a, 'post', b,'');
      frm = formInput(frm, 'smsid', c);
      formSubmit(frm);
    }
  }
})//삭제하기버튼 클릭

$('button[name="edit"]').on('click', function(){
  var smsid = $(this).parent().parent().children().children('input:eq(0)').val();
  var title = $(this).parent().parent().find('td:eq(2)').text().trim();
  var description = $(this).parent().parent().find('td:eq(3)').text().trim();
  console.log(title, description);

  var titleTag = "<input type='text' class='form-control' value='"+title+"' name='title'>";
  var descriptionTag = "<textarea name='description' cols='80' rows='8' class='form-control' required>"+description+"</textarea>";

  var smallEditButton = "<button type='button' name='smallEditButton' class='btn btn-secondary btn-sm mr-1'>수정</button><button type='button' name='smallEditButtonCancel' class='btn btn-secondary btn-sm'>취소</button>";

  // $(this).parent().parent().find('td:eq(2)').text('');
  $(this).parent().parent().find('td:eq(1)').find('select').attr('disabled',false);
  $(this).parent().parent().find('td:eq(2)').html(titleTag);
  $(this).parent().parent().find('td:eq(3)').html(descriptionTag+smallEditButton);
  $(this).hide();
  $(this).next().hide();
  $('#lastRow2').append(newTr2);

  // console.log('solmi');

  $("button[name='smallEditButton']").click(function(){
      // console.log('작은버튼클릭');
      var aa = 'smsEdit';
      var bb = 'p_smsEdit.php';
      var id = $(this).parent().parent().find('td:eq(0)').children('input:eq(0)').val();
      var screenName = $(this).parent().parent().find('td:eq(1)').children('select').val();
      var title = $(this).parent().parent().find('td:eq(2)').children('input').val();
      var description = $(this).parent().parent().find('td:eq(3)').children('textarea').val();
      console.log(id, screenName, title, description);
      console.log('siwon');

      goCategoryPage(aa, bb, id, screenName, title, description);

      function goCategoryPage(a,b,c,d,e,f){
          var frm = formCreate(a, 'post', b,'');
          frm = formInput(frm, 'id', c);
          frm = formInput(frm, 'screenName', d);
          frm = formInput(frm, 'title', e);
          frm = formInput(frm, 'description', f);
          formSubmit(frm);
      }
  })//수정작은버튼 클릭

  $("button[name='smallEditButtonCancel']").on('click', function(){
    location.reload();
  })



})//수정하기버튼 클릭

</script>
