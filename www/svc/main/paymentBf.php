<!-- 도로 정기결제 가져옴-->

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
// if(!isset($_SESSION['is_login'])){
//   header('Location: /svc/user/login.php');
// }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>리스맨결제하기</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_SESSION);
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/INIStdPayUtil.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/sha256.inc.php');
$SignatureUtil = new INIStdPayUtil();


 //############################################
 // 1.전문 필드 값 설정(***가맹점 개발수정***)
 //############################################
 // 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
 //$mid          = "INIpayTest";                          // 가맹점 ID(가맹점 수정후 고정)
$mid = array(
    'pay' => 'INIpayTest',
    'bill' => 'INIBillTst'
);
 // leasemanc1
 //인증
 //$signKey       = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS";          // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
        
// 정기구독 signkey            UjNLbnoyZEl2cVNNZDFMck4yMVNuZz09        
// djF5OHVoWjJVMWRoVWtNL3pGN0lDdz09

$signKey = array(
    'pay' =>  "SU5JTElURV9UUklQTEVERVNfS0VZU1RS",
    'bill' => "SU5JTElURV9UUklQTEVERVNfS0VZU1RS");

$timestamp       = $SignatureUtil->getTimestamp();            // util에 의해서 자동생성
$orderNumber    = "leaseman_" . $timestamp;                   // 가맹점 주문번호(가맹점에서 직접 설정)
// $price          = "1000";                                // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

 //값으로 변경 (SHA-256방식 사용)
 //###################################
$mKey = array( 
    'pay'  => hash("sha256", $signKey['pay']), 
    'bill' => hash("sha256", $signKey['bill'])
);



 /*
 //###################################
 // 2. 가맹점 확인을 위한 signKey를 해시
  **** 위변조 방지체크를 signature 생성 ***
  * oid, price, timestamp 3개의 키와 값을
  * key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값
  * ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004
  * key기준 알파벳 정렬
  * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그데로 사용하여야함
  */
//  $params = "oid=" . $orderNumber . "&price=" . $price . "&timestamp=" . $timestamp;
//  $sign = hash("sha256", $params);

 /* 기타 */
 $siteDomain = "http://".$_SERVER['HTTP_HOST']."/svc/main"; //가맹점 도메인 입력

 // 페이지 URL에서 고정된 부분을 적는다.
 // Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
 //                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.

 ?>

   <!-- 이니시스 표준결제 js -->
 <!--         <script language="javascript" type="text/javascript" src="HTTPS://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script> -->
                                                                        
 <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>


 <script type="text/javascript">
    function paybtn() {
       INIStdPay.pay('SendPayForm_id');
    }

    function cardShow(){
       // document.getElementById("acceptmethod").value = "BILLAUTH(card):FULLVERIFY";
    }

    function hppShow(){
       document.getElementById("acceptmethod").value = "BILLAUTH(HPP):HPP(1)";
    }
 </script>
 <link href="http://www.leaseman.co.kr/svc/main/preference.css" rel="stylesheet" type="text/css"/>

 <style>
     #inicisModalDiv {

opacity: 100;

}
 </style>
 <!-- <script src="/preference/preference.js"></script> 비어있는 php -->
 <form method="post" name="fm_pay" id="SendPayForm_id" class="" accept-charset="utf-8">

       <input type="hidden" name="goods_type" id="goods_type" value="" />
       <input type="hidden" name="goods_price" id="goods_price" value="" />
       <input type="hidden" name="goods_name" id="goods_name" value="" />
       <input type="hidden" name="goodsname" id="goodsname" value="" />
       <input type="hidden" name="goods_level" id="goods_level" value="" />
       <input type="hidden" name="version" value="1.0" >
       <input type="hidden" name="mid" id="mid" value="" >
       <input type="hidden" name="goodname" id="goodname" value="" >
       <input type="hidden" name="oid" id="oid" value="<?php echo $orderNumber ?>" >
       <input type="hidden" name="price" id="price" value="" >
       <input type="hidden" name="currency" value="WON" >
       <input type="hidden" name="buyername" value="<?=isset($_SESSION['customer']['name']) ? $_SESSION['customer']['name'] : '';?>" >
       <!-- <input type="hidden" name="buyertel" value="< ? =get_user_info('mobile')?>" > -->
       <input type="hidden" name="buyertel" value="01049442076" />     <!-- 결제요청 user 전화번호 -->
       <input type="hidden" name="buyeremail" value="<?=isset($_SESSION['customer']['email']) ? $_SESSION['customer']['email'] : '';?>" >
       <input type="hidden" name="timestamp" id="timestamp" value="<?php echo $timestamp ?>" >
       <input type="hidden" name="signature" id="signature" value="" > <!-- <?php echo $sign ?> -->
       <input type="hidden" name="returnUrl" value="<?php echo $siteDomain ?>/inistdpay_result.php" >
       <input type="hidden" name="mKey" id="mKey" value="" >
       <input type="hidden" name="gopaymethod" id="gopaymethod" value="Card" >
       <input type="hidden" name="offerPeriod" id="offerPeriod" value="" >
       <input type="hidden" id="acceptmethod" name="acceptmethod" value="" >
       <input type="hidden" id="billPrint_msg" name="billPrint_msg" value="해당 결제는 매달 자동 결제됩니다." >
       <input type="hidden" name="languageView" value="" >
       <input type="hidden" name="charset" value="" >
       <input type="hidden" name="payViewType" value="" >
       <input type="hidden" name="closeUrl" value="http://www.leaseman.co.kr/svc/main/stdpay3/INIStdPaySample/close.php">
       <input type="hidden" name="popupUrl" value="http://www.leaseman.co.kr/svc/main/stdpay3/INIStdPaySample/popup.php">
       <input type="hidden" name="merchantData" id="merchantData" value="" >            <!-- 인증 성공시 가맹점으로 리턴 (한글사용불가)  -->
       <input type="hidden" name="signKeyPay"  id="signKeyPay" value="<?php echo $signKey["pay"] ?> " >
       <input type="hidden" name="signKeyBill" id="signKeyBill" value="<?php echo $signKey["bill"] ?> " >

    </form>

<?php
$sql = "SELECT count(*)
        FROM realcontract
        WHERE user_id={$_SESSION['id']} and
              getstatus(startdate, enddate2) = 'present'
        ";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$pay1 = "
        &nbsp;<span class='badge badge-info monthonly'>바로가기</span>";
$pay2 = "
        &nbsp;<span class='badge badge-danger monthly'>바로가기</span>";


$payAmount = array(
         array(1,20,0,0),
         array(2, 40, 1000, 1000),
         array(3, 60, 24900, 17900),
         array(4, 80, 29900, 23900),
         array(5, 120, 44900, 35900),
         array(6, 200, 59900, 47900),
         array(7, 300, 74900, 59900)
        );


$currentDate = date('Y-m-d');

$currentDateDate = new DateTime($currentDate);
$startDateDate = new DateTime($_SESSION['created']);

// $fordays = date_diff($currentDateDate, $startDateDate);

// $fordays2 = $fordays->days;
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
    <h1 class="display-4">이용요금입니다</h1>
    <p class="lead">
    (1)계약건수에 따라 등급을 선택하세요 (계약건수는 통상적으로 방 개수를 말합니다.)<br>
    (2)<?=$_SESSION['email']?>님의 현재계약건수는 <?=$row[0]?>건 이며, 회원가입한지 <?=$fordays2?>일 되었습니다. (회원가입후 30일 및 계약건수 20건 이하까지 무료이용)
    <hr class="my-4">
  </div>
</section>

<section class="container text-center" style="max-width:1000px;">
  <table class="table table-bordered text-center">
    <tr>
      <th rowspan="2">등급</th>
      <th rowspan="2">건수</th>
      <th colspan="2">이용요금</th>
    </tr>
    <tr>
      <th>1개월 구매하기</th>
      <th>1개월 구독하기</th>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)1</td>
      <td><?=$payAmount[0][1]?>건</td>
      <td><?=$payAmount[0][2]?>원</td>
      <td><?=$payAmount[0][3]?>원</td>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)2
        <input type="hidden" name="gradename" value="star2">
        <input type="hidden" name="1monthAmount" value="<?=$payAmount[1][2]?>">
        <input type="hidden" name="monthlyAmount" value="<?=$payAmount[1][3]?>">
      </td>
      <td><?=$payAmount[1][1]?>건</td>
      <td><?=number_format($payAmount[1][2])?>원
        <?php
        if((int)$row[0]<=30){
          echo $pay1;
        }
         ?>
      </td>
      <td><?=number_format($payAmount[1][3])?>원
        <?php
        if((int)$row[0]<=30){
          echo $pay2;
        }
         ?>
      </td>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)3
        <input type="hidden" name="gradename" value="star3">
        <input type="hidden" name="1monthAmount" value="<?=$payAmount[2][2]?>">
        <input type="hidden" name="monthlyAmount" value="<?=$payAmount[2][3]?>">
      </td>
      <td><?=$payAmount[2][1]?>건</td>
      <td><?=number_format($payAmount[2][2])?>원
        <?php
        if((int)$row[0]<=50){
          echo $pay1;
        }
         ?>
      </td>
      <td><?=number_format($payAmount[2][3])?>원
        <?php
        if((int)$row[0]<=50){
          echo $pay2;
        }
         ?>
      </td>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)4
        <input type="hidden" name="gradename" value="star4">
        <input type="hidden" name="1monthAmount" value="<?=$payAmount[3][2]?>">
        <input type="hidden" name="monthlyAmount" value="<?=$payAmount[3][3]?>">
      </td>
      <td><?=$payAmount[3][1]?>건</td>
      <td><?=number_format($payAmount[3][2])?>원
        <?php
        if((int)$row[0]<=130){
          echo $pay1;
        }
         ?>
      </td>
      <td><?=number_format($payAmount[3][3])?>원
        <?php
        if((int)$row[0]<=130){
          echo $pay2;
        }
         ?>
      </td>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)5
        <input type="hidden" name="gradename" value="star5">
        <input type="hidden" name="1monthAmount" value="<?=$payAmount[4][2]?>">
        <input type="hidden" name="monthlyAmount" value="<?=$payAmount[4][3]?>">
      </td>
      <td><?=$payAmount[4][1]?>건</td>
      <td><?=number_format($payAmount[4][2])?>원
        <?php
        if((int)$row[0]<=200){
          echo $pay1;
        }
         ?>
      </td>
      <td><?=number_format($payAmount[4][3])?>원
        <?php
        if((int)$row[0]<=200){
          echo $pay2;
        }
         ?>
      </td>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)6
        <input type="hidden" name="gradename" value="star6">
        <input type="hidden" name="1monthAmount" value="<?=$payAmount[5][2]?>">
        <input type="hidden" name="monthlyAmount" value="<?=$payAmount[5][3]?>">
      </td>
      <td><?=$payAmount[5][1]?>건</td>
      <td><?=number_format($payAmount[5][2])?>원
        <?php
        if((int)$row[0]<=300){
          echo $pay1;
        }
         ?>
      </td>
      <td><?=number_format($payAmount[5][3])?>원
        <?php
        if((int)$row[0]<=300){
          echo $pay2;
        }
         ?>
      </td>
    </tr>
    <tr>
      <td><i class="fas fa-star"></i>(스타)7
        <input type="hidden" name="gradename" value="star7">
        <input type="hidden" name="1monthAmount" value="<?=$payAmount[6][2]?>">
        <input type="hidden" name="monthlyAmount" value="<?=$payAmount[6][3]?>">
      </td>
      <td><?=$payAmount[6][1]?>건</td>
      <td><?=number_format($payAmount[6][2])?>원
        <?php
        if((int)$row[0]<=400){
          echo $pay1;
        }
         ?>
      </td>
      <td><?=number_format($payAmount[6][3])?>원
        <?php
        if((int)$row[0]<=400){
          echo $pay2;
        }
         ?>
      </td>
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

var orderNumber = $("#oid").val();
var timestamp = $("#timestamp").val();
var g_price = $("#price").val();
var signKey = $("#signKey").val();
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
  var goodsName = `${gradename}_monthonly`;
  // var merchantData = 'paydiv=monthonly&signkey=' + $("#signKeyPay").val();
  var merchantData = '';
  console.log(merchantData);
 
  if(!pay) return;

    $.ajax({
        url     : "http://www.leaseman.co.kr/svc/main/stdpay3/INIStdPaySample/get_sign2.php",
        method  : "GET",
        data    : "orderNumber="+orderNumber+"&timestamp="+timestamp+"&price="+amount,
        success : function(data) {
            console.log(goodsName, data);
            merchantData += `paydiv=${paydiv}`;
            merchantData += `&today=${today}`; 
            merchantData += `&month1later=${month1later}`;
            merchantData += `&amount=${amount}`;
            merchantData += `&gradename=${gradename}`;

            $("#mid").val("<?=$mid['pay']?>");
            $("#mKey").val("<?=$mKey['pay']?>");
            $("#merchantData").val(merchantData);
            $("#signature").val(data);
            $("#price").val(amount);
            $("#goods_name").val(goodsName);
            $("#goodsname").val(goodsName);
            $("#gradename").val(gradename);
            $("#paydiv").val(paydiv);
            $("#month1later").val(month1later);
            $("#today").val(today);
            cardShow();
             paybtn();
        },

        error:function(request,status,error){
             alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
          }

        //  error   : function() {
        //  alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        // }
    });
 

  

  // if(pay){
  //   goCategoryPage(paydiv, today, month1later, year1later, amount, gradename);
  // }

})

$('.monthly').on('click', function(){
    var curTr = $(this).closest('tr');
    var amount = curTr.children('td:eq(0)').children('input[name=monthlyAmount]').val();
    var paydiv = 'monthly'
    // console.log(monthAmount);
    var gradename = curTr.children('td:eq(0)').children('input[name=gradename]').val();

    var pay = confirm('정기결제를 클릭하시면 30일 간격으로 '+ amount.format() +'원이 카드자동결제(구독)가 됩니다. 결제 진행하시겠습니까?');
    var goodsName = `${gradename}_monthly`;
    var merchantData = '';

    if(!pay) return;

  $.ajax({
        url     : "http://www.leaseman.co.kr/svc/main/stdpay3/INIStdPaySample/get_sign2.php",
        data    : "orderNumber="+orderNumber+ "&timestamp=" + timestamp + "&price="+ amount,

        success : function(data) {
            console.log(data);
            
            merchantData += `paydiv=${paydiv}`;
            merchantData += `&today=${today}`; 
            merchantData += `&month1later=${month1later}`;
            merchantData += `&amount=${amount}`;
            merchantData += `&gradename=${gradename}`;

            $("#mid").val("<?=$mid['bill']?>");
            $("#mKey").val("<?=$mKey['bill']?>");
            $("#merchantData").val(merchantData);
            $("#signature").val(data);
            $("#price").val(amount);
            $("#goods_name").val(goodsName);
            $("#goodsname").val(goodsName);
            document.getElementById("acceptmethod").value = "BILLAUTH(card):FULLVERIFY"

          // cardShow();
            paybtn();
        },

        error:function(request,status,error){
             alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
          }

        //  error   : function() {
        //  alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        // }
    });

  // if(pay){
  //   goCategoryPage(paydiv, today, month1later, year1later, amount, gradename);
  // }
})
      //alert("goods_type="+g_type+"&goods_price="+g_price+"&goods_name="+g_name+"&goods_level="+g_level+"&oid="+orderNumber);


</script>

<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
