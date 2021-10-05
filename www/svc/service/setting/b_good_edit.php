<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//상품아이디
settype($filtered_id, 'integer');
$sql = "SELECT good_in_building.id, good_in_building.name as gName, building.bName as bName, building.id as bId
  FROM good_in_building LEFT JOIN building
  ON good_in_building.building_id = building.id
  WHERE good_in_building.id={$filtered_id}";
// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$escaped_bName = htmlspecialchars($row['bName']);
$escaped_gName = htmlspecialchars($row['gName']);
?>

<section class="container">
    <div class="jumbotron">
        <h1 class="display-4"> >> 기타상품 수정 화면입니다!</h1>
        <hr class="my-4">
        <p class="lead">임대계약 외에 일회성으로 발생하는 기타매출 상품명을 적으세요. 예)회의실,노트북 등</p>
        <!-- <hr class="my-4">
    <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
    </div>
</section>

<section class="container" style="max-width:600px;">
    <form class="container" action="p_good_edit.php" method="post">
        <input type="hidden" name="gId" value="<?=$filtered_id?>">
        <input type="hidden" name="bId" value="<?=$row['bId']?>">
        <table class="table table-bordered text-center">
            <tr>
                <td scope="col col-md-4">물건명</td>
                <td scope="col col-md-8"><input class="form-control text-center" type="text" name="building_name"
                        value="<?=$escaped_bName?>" disabled></td>
            </tr>
            <tr>
                <td scope="col col-md-4">기타상품</td>
                <td scope="col col-md-8"><input class="form-control text-center" type="text" name="good" required=""
                        value="<?=$escaped_gName?>"></td>
            </tr>
        </table>
        <div class='mt-7'>
            <a class='btn btn-secondary' href='building.php' role='button'>취소/돌아가기</a>
            <a class='btn btn-warning' role='button' onclick='goCategoryPage(aa1,bb1,cc1,dd1);'>삭제</a>
            <button type='submit' class='btn btn-primary'>수정</button>
        </div>
    </form>
</section>

<script>
var aa1 = 'goodDelete';
var bb1 = 'p_good_delete.php';
var cc1 = 'id';
var dd1 = '<?=$filtered_id?>';

function goCategoryPage(a, b, c, d) {
    if (confirm('정말 삭제하시겠습니까?')) {
        var frm = formCreate(a, 'post', b, '')
        frm = formInput(frm, c, d);
        formSubmit(frm);
        // console.log(b);
    } else {
        return false;
    }
}
</script>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>