<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /user/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>코인구매</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";

// print_r($_SESSION);

$sql = "select count(*)
        from realcontract
        where user_id={$_SESSION['id']} and
              getstatus(startdate, enddate2) = 'present'
        ";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$pay1 = "
        <span class='badge badge-info'>카드결제</span>";
$pay2 = "
        <span class='badge badge-danger'>휴대폰결제</span>";

$payAmount = [
              [10000, 30000, 50000, 100000],
              [0,0.03, 0.05, 0.1]
             ];


//date_default_timezone_set('Asia/Seoul');
$currentDate = date('Y-m-d');

$currentDateDate = new DateTime($currentDate);
$startDateDate = new DateTime($_SESSION['created']);

$fordays = date_diff($currentDateDate, $startDateDate);

$fordays2 = $fordays->days;

$month1later = date('Y-m-d', strtotime($currentDate.'+1 month -1 days'));
$year1later = date('Y-m-d', strtotime($currentDate.'+1 year -1 days'));

// echo 666;
?>

<style media="screen">
  /* .fas {
    color:yellow;
  } */
</style>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4">코인구매입니다</h1>
    <p class="lead">
    코인을 충전하여 문자메시지를 발송하거나 리스맨에서 바로 전자세금계산서를 발행하세요 ^__^
    <hr class="my-4">
    <small>
      (1)문자메시지 (단문 30코인, 장문 90코인) 및 전자세금계산서 (120코인) 건당 차감됩니다.<br>
      (2)구매하신 코인은 구매일로부터 5년간 유효합니다.<br>
      (3)구매하신 코인은 구매와 동시에 선과금되며 사용된 코인은 환불 불가합니다.<br>
    </small>
  </div>
</section>

<section class="container">
  <table class="table table-bordered text-center">
    <tr>
      <th>충전금액</th>
      <th>보너스코인</th>
      <th>적립코인</th>
      <th>바로가기</th>
    </tr>
    <tr>
      <td><?=number_format($payAmount[0][0])?>원</td>
      <td><?=number_format($payAmount[0][0]*$payAmount[1][0])?>코인</td>
      <td><?=number_format($payAmount[0][0]+($payAmount[0][0]*$payAmount[1][0]))?>코인</td>
      <td><?=$pay1,$pay2?></td>
    </tr>
    <tr>
      <td><?=number_format($payAmount[0][1])?>원</td>
      <td><?=number_format($payAmount[0][1]*$payAmount[1][1])?>코인(3% <span class="badge badge-pill badge-warning">보너스</span>)</td>
      <td><?=number_format($payAmount[0][1]+($payAmount[0][1]*$payAmount[1][1]))?>코인</td>
      <td><?=$pay1,$pay2?></td>
    </tr>
    <tr>
      <td><?=number_format($payAmount[0][2])?>원</td>
      <td><?=number_format($payAmount[0][2]*$payAmount[1][2])?>코인(5% <span class="badge badge-pill badge-warning">보너스</span>)</td>
      <td><?=number_format($payAmount[0][2]+($payAmount[0][2]*$payAmount[1][2]))?>코인</td>
      <td><?=$pay1,$pay2?></td>
    </tr>
    <tr>
      <td><?=number_format($payAmount[0][3])?>원</td>
      <td><?=number_format($payAmount[0][3]*$payAmount[1][3])?>코인(10% <span class="badge badge-pill badge-warning">보너스</span>)</td>
      <td><?=number_format($payAmount[0][3]+($payAmount[0][3]*$payAmount[1][3]))?>코인</td>
      <td><?=$pay1,$pay2?></td>
    </tr>
  </table>
</section>

<script>

//숫자에 콤마 넣음
Number.prototype.format = function(){
    if(this==0) return 0;

    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');

    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

    return n;
};

//문자를 숫자형태로 바꿔서 콤마 넣음
String.prototype.format = function(){
    var num = parseFloat(this);
    if( isNaN(num) ) return "0";

    return num.format();
};

var today = <?=json_encode($currentDate)?>;
var month1later = <?=json_encode($month1later)?>;
var year1later = <?=json_encode($year1later)?>;

function goCategoryPage(a, b, c, d, e, f){
  var frm = formCreate('gradeAdd', 'post', 'p_gradeAdd.php','');
  frm = formInput(frm, 'paydiv', a);
  frm = formInput(frm, 'today', b);
  frm = formInput(frm, 'month1later', c);
  frm = formInput(frm, 'year1later', d);
  frm = formInput(frm, 'amount', e);
  frm = formInput(frm, 'gradename', f);
  formSubmit(frm);
}


$('.monthonly').on('click', function(){
  var curTr = $(this).closest('tr');
  var amount = curTr.children('td:eq(0)').children('input[name=1monthAmount]').val();
  var gradename = curTr.children('td:eq(0)').children('input[name=gradename]').val();
  var paydiv = 'monthonly';
  var pay = confirm(month1later + '까지 1개월 이용 가능합니다. 결제 진행하시겠습니까?');

  if(pay){
    goCategoryPage(paydiv, today, month1later, year1later, amount, gradename);
  }

})

$('.monthly').on('click', function(){
  var curTr = $(this).closest('tr');
  var amount = curTr.children('td:eq(0)').children('input[name=monthlyAmount]').val();
  var paydiv = 'monthly'
  // console.log(monthAmount);
  var gradename = curTr.children('td:eq(0)').children('input[name=gradename]').val();

  var pay = confirm('정기결제를 클릭하시면 30일 간격으로 '+ amount.format() +'원이 카드자동결제(구독)가 됩니다. 결제 진행하시겠습니까?');

  if(pay){
    goCategoryPage(paydiv, today, month1later, year1later, amount, gradename);
  }
})


$('.yearonly').on('click', function(){
  var curTr = $(this).closest('tr');
  var amount = curTr.children('td:eq(0)').children('input[name=1yearAmount]').val();
  var yearAmount2 = Number(amount)*12;
  var paydiv = 'yearonly';
  var gradename = curTr.children('td:eq(0)').children('input[name=gradename]').val();

  var pay = confirm(year1later + '까지 리스맨 이용 가능합니다. 결제 금액은 12개월치 '+yearAmount2.format()+'원입니다. 결제 진행하시겠습니까?');

  if(pay){
    goCategoryPage(paydiv, today, month1later, year1later, amount, gradename);
  }
})

</script>

<?php include $_SERVER['DOCUMENT_ROOT']."/view/service_footer.php";?>
