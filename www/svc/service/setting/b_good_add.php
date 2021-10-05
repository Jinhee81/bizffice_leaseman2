<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_GET);
$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
settype($filtered_id, 'integer');
$sql = "select * from building where id={$filtered_id}";
// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
// print_r($row);
?>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4"> >> 기타상품 생성 화면입니다!</h1>
    <hr class="my-4">
    <p class="lead">임대계약 외에 일회성으로 발생하는 기타매출 상품명을 적으세요. 예)회의실,노트북 등</p>
    <!-- <hr class="my-4">
    <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
  </div>
</section>

<section class="container" style="max-width:600px;">
  <form class="container" action="p_good_add.php" method="post">
    <input type="hidden" name="id" value="<?=$filtered_id?>">
    <table class="table table-bordered text-center">
      <tr>
        <td scope="col col-md-4">물건명</td>
        <td scope="col col-md-8"><input class="form-control text-center" type="text" name="building_name" value="<?=$row['bName']?>" disabled></td>
      </tr>
      <tr>
        <td scope="col col-md-4">기타상품</td>
        <td scope="col col-md-8"><input class="form-control text-center" type="text" name="good" required="" placeholder="예)회의실, 노트북 등" ></td>
      </tr>
    </table>
    <div class='mt-7'>
      <button type='submit' class='btn btn-primary ml-1'>추가</button>
      <a class='btn btn-secondary' href='building.php' role='button'>취소/돌아가기</a>
    </div>
  </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

</body>
</html>
