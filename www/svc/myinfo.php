<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>나의정보</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$sql = "select
          email, user_div, user_name, manager_name,
          cellphone, lease_type, created, updated, gradename, coin, popbillid, companynumber
        from user
        where id={$_SESSION['id']}";
// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

 ?>
    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">내 정보를 확인 또는 수정합니다.</h3>
            <hr class="my-4">
            <p class="lead"><?=$_SESSION['email']?>님은 현재 <?=$row['gradename']?>등급이며 <?=number_format($row['coin'])?>코인
                보유중입니다.</p>
            <a class="btn btn-primary btn-sm" href="usecount.php" role="button">사용량/결제정보조회</a>
            <a class="btn btn-primary btn-sm" href="password_change.php" role="button">비밀번호변경</a>
            <!-- <a class="btn btn-outline-primary btn-sm" href="./question/questionlist.php" role="button">문의내역조회</a> -->
            <!-- <a class="btn btn-warning btn-sm" href="/svc/main/coinpay.php" role="button">코인구매</a> -->
        </div>
    </section>

    <div class="container" style="max-width:600px;">
        <form class="" action="myinfo_edit_proccess.php" method="post">
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>회원번호</b></label>
                <label for="" class="col-sm-9 col-form-label"><?=$_SESSION['id']?></label>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>이메일</b></label>
                <label for="" class="col-sm-9 col-form-label"><?=$row['email']?></label>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>회원구분</b></label>
                <div class="col-sm-9">
                    <select name="user_div" class="form-control">
                        <option value='개인' <?php if($row['user_div']==="개인"){echo "selected";}?>>개인</option>
                        <option value='사업자' <?php if($row['user_div']==="사업자"){echo "selected";}?>>사업자</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>회원명(상호명)</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="user_name" value="<?=$row['user_name']?>">
                    <small class="green">세금계산서 발행시 상호명으로 기재됩니다.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>담당자/대표자명</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="manager_name" value="<?=$row['manager_name']?>">
                    <small class="green">세금계산서 발행시 작성자로 기재됩니다.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>연락처</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="cellphone" value="<?=$row['cellphone']?>">
                    <small class="green">문자메시지 발송에 사용되는 전화번호입니다.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>팝빌아이디</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="popbillid" value="<?=$row['popbillid']?>">
                    <small class="green">전자세금계산서 발행을 원하면 <a href="https://www.popbill.com/Member/Form/Link"
                            target="_blank">팝빌사이트</a>에 회원가입하고 아이디를 적어주세용.</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label"><b>사업자번호</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="companynumber" value="<?=$row['companynumber']?>">
                    <small class=green>매출 전자세금계산서 발행에 필요한 사업자번호에요.(숫자10자리입니다.)</small>
                </div>
            </div>
            <!-- <div class="form-group row">
      <label for="" class="col-sm-3 col-form-label"><b>문자발송번호</b></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="smsnumber" value="<?=$row['smsnumber']?>">
      </div>
    </div> -->
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label"><b>임대유형</b></label>
                <div class="col-sm-9">
                    <select name="lease_type" class="form-control">
                        <option value="공유오피스" <?php if($row['lease_type']=="공유오피스"){echo "selected";}?>>공유오피스</option>
                        <option value="원룸" <?php if($row['lease_type']=="원룸"){echo "selected";}?>>원룸</option>
                        <option value="빌딩" <?php if($row['lease_type']=="빌딩"){echo "selected";}?>>빌딩</option>
                        <option value="고시원" <?php if($row['lease_type']=="고시원"){echo "selected";}?>>고시원</option>
                        <option value="창고" <?php if($row['lease_type']=="창고"){echo "selected";}?>>창고</option>
                        <option value="임대관리회사" <?php if($row['lease_type']=="임대관리회사"){echo "selected";}?>>임대관리회사
                        </option>
                        <option value="기타" <?php if($row['lease_type']=="기타"){echo "selected";}?>>기타</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label><b>가입일시</b></label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?=$row['created']?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label><b>수정일시</b></label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?=$row['updated']?>" disabled>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-outline-info btn-block">수정하기</button>
        </form>
    </div>


    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <!--툴팁함수호출하면 예쁘게부트스트랩표시가 됨-->

    </body>

</html>