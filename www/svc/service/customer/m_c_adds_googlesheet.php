<!-- 처음에 만들때는 구분2가 있었는데 그거 자체를 삭제하고 다시 만듬 -->
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>세입자일괄등록</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
?>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4">일괄등록 화면입니다!</h1>
    <p class="lead">이 화면에서는 한꺼번에 많은 세입자를 등록합니다.</p>
    <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다. (2)연락처는 010으로 시작하는 핸드폰번호 기준입니다.(지역번호 02로 시작하는 번호 또는 031로 시작하는 번호는 고객상세화면에서 수정하세요)</small>
    <!-- <hr class="my-4">
    <a class="btn btn-primary btn-sm mobile" href="m_c_add_csv1.php" role="button">csv등록</a> -->
  </div>
</section>
<section class="container" style="max-width:1200px;">
<iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSg7p0SfcPTDCZQ1T9vpI5MNeCv4-OOEO1PIUdRmx-HvPKY5yC7X6e0NJ5T6ab_MPbv5U4yjjvgE9rA/pubhtml?widget=true&amp;gid=1JObUboYx93w6bx0wCky1st8uK15ZIQRO9tn3fB1sriY;headers=true;chrome=true;range=a1:j30" width="100%"></iframe>
</section>


<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
