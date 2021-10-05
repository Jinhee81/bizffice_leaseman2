<!-- 도로 정기결제 가져옴, 이 파일이 엄청 중요함, 이걸로 작업 예정, 절대 지우면 안됌 ㅠ-->

<?php

session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>리스맨결제하기</title>
<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";


require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/INIStdPayUtil.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/sha256.inc.php');
$SignatureUtil = new INIStdPayUtil();


 //############################################
 // 1.전문 필드 값 설정(***가맹점 개발수정***)
 //############################################
 // 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
 //$mid          = "INIpayTest";                          // 가맹점 ID(가맹점 수정후 고정)
$mid = array(
    'pay' => 'leasemanc1',
    'bill' => 'leasemanc2'
);

// 일반결제 테스트 mid = INIpayTest
// 정기결제 테스트 mid = INIBillTst

// 테스트 signKey(일반 , 정기 같음)      = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS";

// signkey
// 일반결제     djF5OHVoWjJVMWRoVWtNL3pGN0lDdz09
// 정기결제     UjNLbnoyZEl2cVNNZDFMck4yMVNuZz09

$signKey = array(
    'pay' =>  "djF5OHVoWjJVMWRoVWtNL3pGN0lDdz09",
    'bill' => "UjNLbnoyZEl2cVNNZDFMck4yMVNuZz09");

$timestamp       = $SignatureUtil->getTimestamp();            // util에 의해서 자동생성
$orderNumber    = "leaseman_" . $timestamp;                   // 가맹점 주문번호(가맹점에서 직접 설정)
// $price          = "1000";                                  // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

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
$siteDomain = "https://".$_SERVER['HTTP_HOST']."/svc/main"; //가맹점 도메인 입력

// 현재 host
$http_host = "https://" . $_SERVER['HTTP_HOST'];
 // 페이지 URL에서 고정된 부분을 적는다.
 // Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
 //                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.

 ?>

   <!-- 이니시스 표준결제 js -->
<script language="javascript" type="text/javascript" src="HTTPS://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
        <!-- 이니시스 테스트결제 -->
<!-- <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script> -->


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
 <link href="https://www.leaseman.co.kr/svc/main/preference.css" rel="stylesheet" type="text/css"/>

 <style>
    #inicisModalDiv {

        opacity: 100;

    }
 </style>

 <!-- <script src="/preference/preference.js"></script> 비어있는 php -->
 <form method="post" name="fm_pay" id="SendPayForm_id" class="" accept-charset="UTF-8">

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
       <input type="hidden" name="buyername" id="buyername" value="<?=isset($_SESSION['customer']['name']) ? $_SESSION['customer']['name'] : '';?>" >

       <!-- <input type="hidden" name="buyertel" value="< ? =get_user_info('mobile')?>" > -->

       <input type="hidden" name="buyertel" value="<?=$_SESSION['cellphone']?>" />     <!-- 결제요청 user 전화번호 -->
       <input type="hidden" name="buyeremail" value="<?=isset($_SESSION['customer']['email']) ? $_SESSION['customer']['email'] : '';?>" >
       <input type="hidden" name="timestamp" id="timestamp" value="<?php echo $timestamp ?>" >
       <input type="hidden" name="signature" id="signature" value="" > <!-- <?php echo $sign ?> -->
       <input type="hidden" name="returnUrl" value="<?php echo $siteDomain ?>/inistdpay_result.php" >
       <input type="hidden" name="mKey" id="mKey" value="" >
       <input type="hidden" name="gopaymethod" id="gopaymethod" value="">
       <input type="hidden" name="offerPeriod" id="offerPeriod" value="" >
       <input type="hidden" id="acceptmethod" name="acceptmethod" value="" >
       <input type="hidden" id="billPrint_msg" name="billPrint_msg" value="해당 결제는 매달 자동 결제됩니다." >
       <input type="hidden" name="languageView" value="" >
       <input type="hidden" name="charset" value="UTF-8" >
       <input type="hidden" name="payViewType" value="" >
       <input type="hidden" name="closeUrl" value="<?php echo $http_host ?>/svc/main/stdpay3/INIStdPaySample/close.php">
       <input type="hidden" name="popupUrl" value="<?php echo $http_host ?>/svc/main/stdpay3/INIStdPaySample/popup.php">
       <input type="hidden" name="merchantData" id="merchantData" value="user_id=<?=$_SESSION["id"]?>" >            <!-- 인증 성공시 가맹점으로 리턴 (한글사용불가)  -->
       <input type="hidden" name="signKeyPay"  id="signKeyPay" value="<?php echo $signKey["pay"] ?> " >
       <input type="hidden" name="signKeyBill" id="signKeyBill" value="<?php echo $signKey["bill"] ?> " >

    </form>

<?php
$sql = "SELECT count(*)
        FROM realContract
        WHERE user_id={$_SESSION['id']} and
              getstatus(startdate, enddate2) = 'present'
        ";
// echo $sql;
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$pay1 = "
        &nbsp;<span class='badge badge-info monthonly'>바로가기</span>";
$pay2 = "
        &nbsp;<span class='badge badge-danger monthly'>바로가기</span>";
$pay3 = "
        &nbsp;<span class='badge badge-info coin'>바로가기</span>";
$payAmount = array(
                array(1, 20, 0, 0, 0, 0),
                array(2, 40, 14900, 12900, 11900, 9900),
                array(3, 60, 24900, 19900, 17900, 14900),
                array(4, 80, 29900, 25900, 23900, 19900),
                array(5, 120, 44900, 38900, 35900, 29900),
                array(6, 200, 59900, 51900, 47900, 39900),
                array(7, 300, 74900, 61900, 59900, 49900)
            );

$currentDate = date('Y-m-d');
$weekDate = date("Ymd", strtotime("+1 week")); // 일주일 후
// echo ($currentDate);
// exit;
$currentDateDate = strtotime($currentDate);
$startDateDate = strtotime($_SESSION['created']);

$fordays = $currentDateDate - $startDateDate;

$fordays2 = round($fordays / (60*60*24));

$month1later = date('Y-m-d', strtotime($currentDate.'+1 month -1 days'));
$month3later = date('Y-m-d', strtotime($currentDate.'+3 month -1 days'));
$year1later = date('Y-m-d', strtotime($currentDate.'+1 year -1 days'));

// echo 666;
?>

<style media="screen">
  /* .fas {
    color:yellow;
  } */
</style>


<div class="">
  <?php if($_GET['page']==='regular'){
    include "payment-regular.php";
  } else if($_GET['page']==='coin'){
    include "payment-coin.php";
  } else {
    include "payment-regular.php";
  }
  ?>
</div>



<?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>

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
var month3later = <?=json_encode($month3later)?>;
var year1later = <?=json_encode($year1later)?>;
var weekDate = <?=json_encode($weekDate)?>;
// 현재 host
var http_host = document.location.hostname;
// console.log(http_host);


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

// 모바일인지 아닌지 확인
function isMobile() {
    var filter = "win16|win32|win64|mac";
    if(navigator.platform){
        if(0 > filter.indexOf(navigator.platform.toLowerCase())){
            return "mobile";
        }else{
            return "pc";
        }
    }
}


$('.monthonly').on('click', function(){

    var curTr = $(this).closest('tr');
    var amount = $(this).parent().children('input[name=amount]').val();
    var month = $(this).parent().children('input[name=month]').val();
    var gradename = curTr.children('td:eq(0)').children('input[name=gradename]').val();
    var grade_star   = curTr.children('td:eq(0)').children('input[name=grade_star]').val();

    var pay, laterdate;

    if(month==='1'){
      laterdate = month1later;
      pay = confirm(laterdate + '까지 1개월 이용 가능합니다. 결제 진행하시겠습니까?');
    } else if(month==='3'){
      amount = Number(amount)*3;
      laterdate = month3later;
      pay = confirm(laterdate + '까지 이용 가능합니다. 결제 금액은 3개월치 '+amount.format()+'원입니다. 결제 진행하시겠습니까?');
    } else if(month==='12'){
      amount = Number(amount)*12;
      laterdate = year1later;
      pay = confirm(laterdate + '까지 이용 가능합니다. 결제 금액은 12개월치 '+amount.format()+'원입니다. 결제 진행하시겠습니까?');
    }
    var paydiv = 'monthonly';
    var goodsName = grade_star;
    var merchantData = $('#merchantData').val();
    var gopaymethod = $('#gopaymethod').val();

   // alert(http_host);

    if(!pay) return;

    $.ajax({
        url     : "https://" + http_host + "/svc/main/stdpay3/INIStdPaySample/get_sign2.php",
        data    : "orderNumber="+orderNumber+"&timestamp="+timestamp+"&price="+amount,
        success : function(data) {
            console.log(gopaymethod);
            merchantData += '&paydiv=' + paydiv + '&today='+today + '&laterdate='+laterdate +'&amount='+amount + '&gradename='+gradename + '&month='+month;

            // merchantData = '&today='+today;
            // merchantData = '&month1later='+month1later;
            // merchantData = '&amount='+amount;
            // merchantData = '&gradename='+gradename;

            //alert(merchantData);

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
            $("#buyername").val("<?=$_SESSION['user_name']?>");

            $("#acceptmethod").val("hpp(1):vbank(" + weekDate + ")");   // 결제수단 추가

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
    var amount = $(this).parent().children('input[name=amount]').val();
    var paydiv = 'monthly'
    // console.log(monthAmount);

    var gradename = curTr.children('td:eq(0)').children('input[name=gradename]').val();
    var grade_star   = curTr.children('td:eq(0)').children('input[name=grade_star]').val();
    var pay = confirm('정기결제를 클릭하시면 30일 간격으로 '+ amount.format() +'원이 카드자동결제(구독)가 됩니다. 결제 진행하시겠습니까?');

    var goodsName = grade_star;
    // var buyername = "노양후";
    var merchantData = $('#merchantData').val();
    var laterdate = month1later;
    var month = 1;

    if(!pay) return;

  $.ajax({
        url     : "https://" + http_host + "/svc/main/stdpay3/INIStdPaySample/get_sign2.php",
        data    : "orderNumber="+orderNumber+ "&timestamp=" + timestamp + "&price="+ amount,

        success : function(data) {
            console.log(data);
            // merchantData += '&paydiv=' + paydiv + '&today='+today + '&month1later='+month1later +'&amount='+amount + '&gradename='+gradename + '&buyername='+buyername;
            merchantData += '&paydiv=' + paydiv + '&today='+today + '&laterdate='+laterdate +'&amount='+amount + '&gradename='+gradename + '&month='+month;

            // merchantData += '&paydiv'=paydiv;
            // merchantData += '&today'=today;
            // merchantData += '&month1later'=month1later;
            // merchantData += '&amount'=amount;
            // merchantData += '&gradename'=gradename;

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
            console.log(merchantData);
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


$('.coin').on('click', function(){

    var curTr = $(this).closest('tr');
    var amount = curTr.children('td:eq(0)').children('input[name=coinamount]').val();
    var gradename = 'coin';
    var grade_star = 'coin';
    var paydiv = 'coin';
    var goodsName = coin;
    var merchantData = $('#merchantData').val();
    var gopaymethod = $('#gopaymethod').val();

   // alert(http_host);


    $.ajax({
        url     : "https://" + http_host + "/svc/main/stdpay3/INIStdPaySample/get_sign2.php",
        data    : "orderNumber="+orderNumber+"&timestamp="+timestamp+"&price="+amount,
        success : function(data) {
            console.log(gopaymethod);
            merchantData += '&paydiv=' + paydiv + '&today='+today + '&month1later='+month1later +'&amount='+amount + '&gradename='+gradename;

            // merchantData = '&today='+today;
            // merchantData = '&month1later='+month1later;
            // merchantData = '&amount='+amount;
            // merchantData = '&gradename='+gradename;

            //alert(merchantData);

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
            $("#buyername").val("<?=$_SESSION['user_name']?>");

            $("#acceptmethod").val("hpp(1):vbank(" + weekDate + ")");   // 결제수단 추가

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

</script>
</body>
<html>
