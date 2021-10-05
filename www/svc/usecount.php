<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>사용량조회</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered_id = mysqli_real_escape_string($conn, $_SESSION['id']);//사용자번호
settype($filtered_id, 'integer');

$sql_all = "
        select count(*)
        from realContract
        where user_id={$filtered_id}
        ";
$result_all = mysqli_query($conn, $sql_all);
$row_all = mysqli_fetch_array($result_all);

$sql_present = "
        select count(*)
        from realContract
        where
            user_id={$filtered_id} and
            getstatus(startdate, enddate2) = 'present'
         ";
$result_present = mysqli_query($conn, $sql_present);
$row_present = mysqli_fetch_array($result_present);

$sql_end = "
       select count(*)
       from realContract
       where
           user_id={$filtered_id} and
           getstatus(startdate, enddate2) = 'the_end'
        ";
$result_end = mysqli_query($conn, $sql_end);
$row_end = mysqli_fetch_array($result_end);

$sql_waiting = "
        select count(*)
        from realContract
        where
            user_id={$filtered_id} and
            getstatus(startdate, enddate2) = 'waiting'
         ";
$result_waiting = mysqli_query($conn, $sql_waiting);
$row_waiting = mysqli_fetch_array($result_waiting);

$sql_sms_all = "select count(*)
                from sentsms
                where
                    user_id={$filtered_id}";
$result_sms_all = mysqli_query($conn, $sql_sms_all);
$row_sms_all = mysqli_fetch_array($result_sms_all);

$sql_sms_short = "select count(*)
                from sentsms
                where
                    user_id={$filtered_id} and
                    type='sms'";
$result_sms_short = mysqli_query($conn, $sql_sms_short);
$row_sms_short = mysqli_fetch_array($result_sms_short);

$sql_sms_long = "select count(*)
                from sentsms
                where
                    user_id={$filtered_id} and
                    type='mms'";
$result_sms_long = mysqli_query($conn, $sql_sms_long);
$row_sms_long = mysqli_fetch_array($result_sms_long);

$sql_tax = "select count(*)
            from payschedule2
            where
                user_id={$filtered_id} and
                taxDate IS NOT NULL";
$result_tax = mysqli_query($conn, $sql_tax);
$row_tax = mysqli_fetch_array($result_tax);

$sql_grade = "select
                gradename, executivedate, startdate, enddate, formonth, payamount,
                ordered,
                paydiv, payhow
              from grade
              where user_id={$filtered_id}
              order by ordered desc
              ";
// echo $sql_grade;

$result_grage = mysqli_query($conn, $sql_grade);

$gradeArray = array();

while($row_grade = mysqli_fetch_array($result_grage)){
  $gradeArray[] = $row_grade;
}

for ($i=0; $i < count($gradeArray); $i++) {
  $replaceStar = '<i class="fas fa-star"></i>(스타)';
  $replaceSubscription = '&nbsp;<span class="badge badge-danger">구독</span>';

  if($gradeArray[$i]['gradename']==='feefree'){
    $gradeArray[$i]['gradename'] = '무료';
  } else {
    $gradeArray[$i]['gradename'] = str_replace("star", $replaceStar, $gradeArray[$i]['gradename']);
    $gradeArray[$i]['gradename'] = str_replace("(s)", $replaceSubscription, $gradeArray[$i]['gradename']);
  }

  if($gradeArray[$i]['payhow']==='Card'){
    $gradeArray[$i]['payhow'] = '신용카드';
  } else if($gradeArray[$i]['payhow']==='VBank'){
    $gradeArray[$i]['payhow'] = '가상계좌';
  } else if($gradeArray[$i]['payhow']==='DirectBank'){
    $gradeArray[$i]['payhow'] = '계좌이체';
  } else if($gradeArray[$i]['payhow']==='Auth'){
    $gradeArray[$i]['payhow'] = '신용카드';
  } else {
    $gradeArray[$i]['payhow'];
  }
}

 ?>
<section class="container">
  <div class="jumbotron">
    <h3 class="display-4">사용량 조회입니다.</h3>
    <hr class="my-4">
    <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
 </div>
</section>

<section class="container">
  <table class="table mt-5 table-bordered text-center">
      <tr class="table-success">
        <th colspan="4">계약</th>
        <th colspan="3">문자</th>
        <th rowspan="2">세금계산서</th>
      </tr>
      <tr class="table-success">
        <td>전체</td>
        <td><b>현재</b></td>
        <td>대기</td>
        <td>종료</td>
        <td><b>전체</b></td>
        <td>단문</td>
        <td>장문</td>
      </tr>
      <tr>
        <td><?=$row_all[0]?></td>
        <td><b><?=$row_present[0]?></b></td>
        <td><?=$row_waiting[0]?></td>
        <td><?=$row_end[0]?></td>
        <td><?=$row_sms_all[0]?></td>
        <td><?=$row_sms_short[0]?></td>
        <td><?=$row_sms_long[0]?></td>
        <td><?=$row_tax[0]?></td>
      </tr>
  </table>

  <table class="table mt-5 table-bordered text-center table-sm">
      <tr class="table-danger">
        <td>등급명</td>
        <td>결제일</td>
        <td>시작일</td>
        <td>종료일</td>
        <td>개월수</td>
        <td>결제금액</td>
        <td>결제방법</td>
        <td>회차</td>
      </tr>
      <?php
      for ($i=0; $i < count($gradeArray); $i++) {?>
        <tr>
          <td>
            <?=$gradeArray[$i]['gradename']?>
          </td>
          <td><?=$gradeArray[$i]['executivedate']?></td>
          <td><?=$gradeArray[$i]['startdate']?></td>
          <td><?=$gradeArray[$i]['enddate']?></td>
          <td><?=$gradeArray[$i]['formonth'].'개월'?></td>
          <td><?=number_format($gradeArray[$i]['payamount']).'원'?></td>
          <td><?=$gradeArray[$i]['payhow']?></td>
          <td><?=$gradeArray[$i]['ordered'].'회차'?></td>
        </tr>
      <?php
      }
       ?>
  </table>

  <!-- <?php echo 111;?> -->
</section>

<script>
var pscheckval = false;

$('input[name=password2]').on('blur', function(){
  var ps1 = $('input[name=password1]').val();
  var ps2 = $(this).val();

  if(ps1 === ps2){
    $('div[name=pscheck]').text('비밀번호가 일치합니다.');
    pscheckval = true;
  } else {
    $('div[name=pscheck]').text('비밀번호가 일치하지 않습니다. 다시 확인해주세요.');
    pscheckval = false;
  }
})

$('button[type=submit]').on('click', function(){
  var f = $('form');

  if(pscheckval===true){
    f.submit();
  } else {
    alert('비밀번호가 일치하지 않습니다. 다시 확인하세요');
    return false;
  }
})


</script>


<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";
?>
