<?php
//예전버전, 이건 삭제하기로 함
session_start();
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>그룹/관리호수 수정</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//그룹아이디?
settype($filtered_id, 'integer');
$sql = "
    SELECT
        group_in_building.id,
        group_in_building.created,
        group_in_building.updated,
        gName,
        count,
        building.bName,
        building.id as bid
    FROM group_in_building
    LEFT JOIN building
      ON group_in_building.building_id = building.id
    WHERE group_in_building.id={$filtered_id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
// echo $sql;
// print_r($row);
// print_r($_SESSION);

// error_reporting(E_ALL);
//
// ini_set("display_errors", 1);

?>

<section class="container">
  <div class="jumbotron pt-3 pb-3">
    <h3 class="">>> 그룹 및 관리호수 수정 화면입니다!</h3>
    <hr class="my-4">
    <!-- <p class="lead">관리번호 추가하기는 1개씩 가능합니다. 만약 다량으로 추가를 윈하는 경우는 그룹삭제 후 다시 그룹 생성해주세요.<br>
    </p> -->
    <!-- <hr class="my-4">
    <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
  </div>
</section>
<section class="container" style="max-width:600px;">
  <form action="p_group_room_edit.php" method="post">
    <input type="hidden" name="id" value="<?=$row['id']?>">
    <table class="table table-bordered text-center">
      <tr>
        <td scope="col col-md-4">물건명(IDX)</td>
        <td scope="col col-md-8"><input class="form-control text-center" type="text" name="building_name" value="<?=$row['bName'].'('.$row['bid'].')'?>" disabled></td>
      </tr>
      <tr>
        <td scope="col col-md-4">그룹명</td>
        <td scope="col col-md-8"><input class="form-control text-center" type="text" name="gName" required="" value="<?=$row['gName']?>"></td>
      </tr>
      <tr>
        <td scope="col col-md-4">호수개수(숫자)</td>
        <td scope="col col-md-8"><input class="form-control text-center" type="text" min="1" max="100" name="count" disabled value="<?=$row['count']?>"></td> <!--disabled속성이 있으면 post로 데이터전송이 안된다-->
      </tr>
      <tr>
        <td colspan="2"><small>등록일시[<?=$row['created']?>] 수정일시[<?=$row['updated']?>]</small></td>
      </tr>
    </table>
    <?php
    $sql7 = "select *
             from r_g_in_building
             where group_in_building_id = {$row['id']}
             order by ordered";
    // echo $sql7;

    $result7 = mysqli_query($conn, $sql7);

    $editRooms = array();
    while($row7 = mysqli_fetch_array($result7)){
      $editRooms[] = $row7;
      // array_push($editRooms, $row7['id'], $row7['rName']);
    }
    // print_r($editRooms);
    $table2 = "<table class='table table-borderless table-sm text-center' id='roomList'";

    $startTrArray = array(0,3,6,9,12,15,18,21,24,27,30,33,36,39,42,45,48, 51,54,57,60,63,66,69,72,75,78,81,84,87,90,93,96,99);

    $closeTrArray = array(2,5,8,11,14,17,20,23,26,29,32,35,38,41,44,47,50, 53,56,59,62,65,68,71,74,77,80,83,86,89,92,95,98);

    // $rDeleteKeyFront = "<td class='deleteTimesTd'><button type='submit' class='deleteTimesButton btn btn-default' formaction='p_room_delete.php';'><input type='hidden' name='rName";
    // $rDeleteKeyMiddle = "' value='";
    // $rDeleteKeyEnd = "'></td><i class='fa fa-times-circle'></i></button></td>";

    for ($i=0; $i < count($editRooms); $i++) {
      if(in_array($i, $startTrArray)){
        $table2 = $table2 ."<tr>
          <td style='padding-right:0px;'><input class='form-control text-center roomname' required='' type='text' name='rName".$i."' value='".$editRooms[$i]['rName']."'><input type='hidden' name='roomId' value='".$editRooms[$i]['id']."'><input type='hidden' name='ordered' value='".$editRooms[$i]['ordered']."'></td><td style='padding-left:0px;'>
          <button type='button' class='btn btn-default'
           style='padding-left: 0px;
           padding-top: 0px;
           border-top-width: 0px;
           border-left-width: 0px;' name='roomDelete';'>
          <i class='fa fa-times-circle' style='color:#FE9A2E;'></i></button>
          </td>";
      } else if(in_array($i, $closeTrArray)){
        $table2 = $table2 . "
        <td style='padding-right:0px;'><input class='form-control text-center roomname' required='' type='text' name='rName".$i."' value='". $editRooms[$i]['rName']."''><input type='hidden' name='roomId' value='".$editRooms[$i]['id']."'><input type='hidden' name='ordered' value='".$editRooms[$i]['ordered']."'></td><td style='padding-left:0px;'>
        <button type='button' class='btn btn-default'
         style='padding-left: 0px;
         padding-top: 0px;
         border-top-width: 0px;
         border-left-width: 0px;' name='roomDelete'>
        <i class='fa fa-times-circle' style='color:#FE9A2E;'></i></button>
        </td></tr>";
      } else {
        $table2 = $table2 . "
        <td style='padding-right:0px;'><input class='form-control text-center roomname' required='' type='text' name='rName".$i."' value='". $editRooms[$i]['rName']."''><input type='hidden' name='roomId' value='".$editRooms[$i]['id']."'><input type='hidden' name='ordered' value='".$editRooms[$i]['ordered']."'></td><td style='padding-left:0px;'>
        <button type='button' class='btn btn-default'
         style='padding-left: 0px;
         padding-top: 0px;
         border-top-width: 0px;
         border-left-width: 0px;' name='roomDelete'>
        <i class='fa fa-times-circle' style='color:#FE9A2E;'></i></button>
        </td>";
      }

    } //for end}

    $table2 = $table2."<td id='roomDiv'>
    <button type='button' class='btn btn-outline-warning btn-sm' data-toggle='modal' data-target='#roomAdd'>관리번호 추가</button><td></table>";

    $table2 = $table2."<div class='mt-7'><a class='btn btn-secondary' href='building.php' role='button'>이전화면으로</a><a class='btn btn-warning ml-1' role='button' name='btnGroupDelete'>그룹 삭제하기</a><button type='button' class='btn btn-primary ml-1' name='btnGroupEdit'>수정하기</button></div>";
    ?>
    <div>
      <?php echo $table2;?>
    </div>
  </form>
</section>

<?php include "b_group_room_edit_modal.php";?>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

<script>

var groupId = '<?=$filtered_id?>';
var groupName = "<?=$row['gName']?>";
var groupCount = "<?=$row['count']?>";
var rooms = [];

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// $('button[name=roomDelete]').on('click', function(){
//   var a = $(this);
// })

$('button[name=btnGroupEdit]').on('click', function(){
  var roomArray = [];
  var roomcount = $('.roomname').length;

  for (var i = 0; i < roomcount; i++) {
    var a = $('.roomname:eq('+i+')').val();
    roomArray.push(a);
  }

  for (var i = 0; i < roomArray.length; i++) {
    for (var j = i+1; j < roomArray.length; j++) {
      if(roomArray[i]===roomArray[j]){
        alert(roomArray[i]+' 가 중복되어 수정불가합니다. 다시 확인해주세요.');
        return false;
      }
    }
  }

  $('form').submit();

})

$('a[name=btnGroupDelete]').on('click', function(){
  if(confirm('정말 삭제하시겠습니까?')){

      goCategoryPage('groupDelete', 'p_group_delete.php', groupId);
      function goCategoryPage(a, b, c){
        var frm = formCreate(a, 'post', b,'');
        frm = formInput(frm, 'groupId', c);
        formSubmit(frm);
      }
  } else {
    return false;
  }
})

$('button[name=roomDelete]').on('click', function(){
  var a = $(this);
  console.log(a);

  var roomId = a.parent().prev().children('input[name=roomId]').val();
  var ordered = a.parent().prev().children('input[name=ordered]').val();

  console.log(roomId, ordered);

  if(ordered != groupCount){
    alert('제일 마지막 관리번호 지우는 것만 가능합니다.');
    return false;
  }

  goCategoryPage('roomDelete', 'p_room_delete.php', roomId, groupId);

  function goCategoryPage(a, b, c, d){
    var frm = formCreate(a, 'post', b,'');
    frm = formInput(frm, 'roomId', c);
    frm = formInput(frm, 'groupId', d);
    formSubmit(frm);
  }
})

$('input[name=mcount]').on('click', function(){
  $(this).select();
})

$('button[name=btnroomAdd]').on('click', function(){ //모달안의 생성버튼 누를 때

  var count = Number($('input[name=mcount]').val());
  var ahead = $('input[name=mahead]').val();
  var startNumber = Number($('input[name=msNumber]').val());
  var tail = $('input[name=mtail]').val();

  if((count === 0) || (count > 100)){
    alert('관리개수 항목에 1~100 사이 숫자를 입력해야 합니다!')
    return false;
  }
  if(!startNumber){
    for (var i=0; i < count; i++){
      var eachname = ahead + "" + tail;
      rooms.push(eachname);
    }
  } else {
    for(var i = startNumber; i < (startNumber+count); i++){
      var eachname = ahead + i + tail;
      rooms.push(eachname);
    }
  }

  alert(rooms);

  var $tweet = $('<div></div>');
  $tweet.append("<h5 class='text-center'>관리번호 목록</h5>");
  // $tweet.appendTo($('#table_rooms'));
  var table = "<table class='table table-bordered table-sm text-center'>";
  var trArray=[0,3,6,9,12,15,18,21,24,27,30,33,36,39,42,45,48, 51,54,57,60,63,66,69,72,75,78,81,84,87,90,93,96,99];
  var closeTrArray= [2,5,8,11,14,17,20,23,26,29,32,35,38,41,44,47,50, 53,56,59,62,65,68,71,74,77,80,83,86,89,92,95,98];
  for(var i=0; i<rooms.length; i++) {
   var stringI = i.toString();
   if(trArray.includes(i)){
     table = table + "<tr><td>"+ "<input type='text' name='rName" + i + "' class='form-control text-center' value ='"+ rooms[i] +"' required></td>";

   } else if (closeTrArray.includes(i)){
     table = table + "<td>"+ "<input type='text' name='rName" + i + "' class='form-control text-center' value ='" + rooms[i] + "' required></td></tr>";

   } else {
     table = table + "<td>"+ "<input type='text' name='rName" + i + "' class='form-control text-center' value ='" + rooms[i] + "' required></td>";
   }
  }
  table = table + "</table><div class='mt-7'><button type='button' class='btn btn-primary mr-1' id='mroomAdd'>추가</button><a class='btn btn-secondary' href='b_group_room_edit.php?id=<?=$filtered_id?>' role='button'>취소/돌아가기</a></div>";

  $tweet.append(table);

  $('#mbelow_rooms').html($tweet);

  $('button[id=mroomAdd]').on('click', function(){
    rooms = JSON.stringify(rooms);

    goCategoryPage(groupId, count, rooms, groupName)
    function goCategoryPage(a,b,c,d){
      var frm = formCreate('roomAdd', 'post', 'p_room_append.php','');
      frm = formInput(frm, 'groupId', a);
      frm = formInput(frm, 'groupName', d);
      frm = formInput(frm, 'count', b);
      frm = formInput(frm, 'roomArray', c);
      formSubmit(frm);
    }

  })//모달안에서 추가하기 버튼 누를때, 생성이랑 헷갈리지 말것

  $('button[name=mbtnCansel]').on('click', function(){
    rooms = [];
    $('#mbelow_rooms').empty();
  })

})//모달안의 생성버튼 누를 때}

</script>

</body>
</html>
