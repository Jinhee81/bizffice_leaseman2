<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";

$sql = "select * from user_account where user_id={$_SESSION['id']}";
$result = mysqli_query($conn, $sql);

$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[] = $row;
}

print_r($allRows);
?>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4"> >> 부계정 목록 화면입니다!</h1>
    <p class="lead">직원이 있는경우 부계정을 등록하세요 </p>
    <hr class="my-4">
    <!-- <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
  </div>
</section>

<section class="container">
  <table class="table table-hover text-center mt-2">
    <tr class="table-primary">
      <td>순번</td>
      <td>아이디</td>
      <td>비밀번호</td>
      <td>이름</td>
      <td>특이사항</td>
      <td></td>
    </tr>
    <?php
      if(count($allRows)===0){
        echo "<tr><td colspan='6'>등록된 부계정이 없습니다.</td></tr>";
      } else {
        for($i=0; $i < count($allRows); $i++){?>
      <tr>
        <td>
          <?=$i+1?>
          <input type="hidden" name="id" value="<?=$allRows[$i]['id']?>">
        </td>
        <td><?=$allRows[$i]['nickid']?></td>
        <td><?=$allRows[$i]['password']?></td>
        <td><?=$allRows[$i]['name']?></td>
        <td><?=$allRows[$i]['etc']?></td>
        <td>
          <button type="submit" name="edit" class="btn btn-default grey">
            <i class='far fa-edit'></i>
          </button>
          <button type="submit" name="delete" class="btn btn-default grey">
            <i class='far fa-trash-alt'></i>
          </button>
        </td>
      </tr>
      <?php
        }
      }
     ?>
  </table>
  <div class="row justify-content-center">
    <a href="account_add.php"><button type="button" class="btn btn-primary" name="button">등록하기</button></a>
  </div>
</section>

<script type="text/javascript">
$('button[name="delete"]').on('click', function(){
  var id = $(this).parent().parent().children().children('input:eq(0)').val();

  console.log(id);

  // var aa = 'smsDelete';
  // var bb = 'p_smsDelete.php';
  //
  // var deleteCheck = confirm('정말 삭제하겠습니까?');
  // if(deleteCheck){
  //   goCategoryPage(aa,bb,smsid);
  // 
  //   function goCategoryPage(a,b,c){
  //     var frm = formCreate(a, 'post', b,'');
  //     frm = formInput(frm, 'smsid', c);
  //     formSubmit(frm);
  //   }
  // }
})//삭제하기버튼 클릭
</script>

<?php include $_SERVER['DOCUMENT_ROOT']."/view/service_footer.php";?>
