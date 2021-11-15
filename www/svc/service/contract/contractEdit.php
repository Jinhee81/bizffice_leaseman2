<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
// 환불액 넣으려고 새로 만든 것
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title></title>
    <link rel="icon" type="image/x-icon" href="/svc/inc/img/icon/checkround.png">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no">

    <!-- 부트스트랩 css -->
    <link rel="stylesheet" href="/svc/inc/css/bootstrap.min.css">


    <!-- 달력 css -->
    <link rel="stylesheet" href="/svc/inc/css/jquery-ui.min.css">

    <!-- 세금계산서 css -->
    <link rel="stylesheet" href="/svc/inc/css/pops.css">

    <!-- 폰트어썸 css -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- 커스텀 css -->
    <link rel="stylesheet" href="/svc/inc/css/customizing.css?<?= date('YmdHis') ?>">

    <!-- fullCalendar css -->
    <link rel="stylesheet" href="/svc/inc/css/fullcalendar.css?<?= date('YmdHis') ?>">
    <link rel="stylesheet" href="/svc/inc/css/fullcalendar.min.css?<?= date('YmdHis') ?>">
</head>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
include "building.php";
include "./condi/sql_all2.php";
include "./condi/sql_deposit.php";
include "./condi/sql_file.php";
include "./condi/sql_memo.php";
?>
<style>
/* 세금계산서 iframe 크기 조절  */
.popup_iframe {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 9999;
    width: 100%;
    height: 100%;
    display: none;
}

#wrap {
    position: absolute;
    width: 100%;
    height: 100%;
}
</style>

<section class="container jumbotron pt-3 pb-3 mb-2">
    <label for="" style="font-size:32px;">임대계약상세(화면번호 202)</label>
    <label class="font-italic" style="font-size:20px;color:#2E9AFE;">계약번호 <?= $filtered_id ?></label>
</section>

<section>
    <div class="row justify-content-center">
        <div class="col-11">
            <?php include "./edit/1_button2.php"; ?>
            <?php include "./edit/2_ci.php"; ?>
        </div>
    </div>
</section>

<!-- 하단 탭 -->
<section class="container">
    <nav class="">
        <ul class="nav nav-tabs">
            <li class="nav-items">
                <a class="nav-link" href="contractEdit.php?id=<?= $filtered_id ?>">임대료목록(<?= $row['count2'] ?>개월)</a>
            </li>
        </ul>
    </nav>
    <div class="">
        <?php
        include "./edit/3_schedule2.php";
        include "../../modal/modal_nadd.php"; //n개월추가모달
        include "../../modal/modal_regist.php"; //청구설정모달
        ?>
    </div>

    <nav class="">
        <ul class="nav nav-tabs">
            <li class="nav-items">
                <a class="nav-link" href="contractEdit.php?id=<?= $filtered_id ?>">보증금 (<span
                        name="depositMoney"></span>원), 중간종료내역</a>
            </li>
        </ul>
    </nav>
    <div class="">
        <?php
        include "./edit/4_deposit3.php";
        ?>
    </div>

    <nav class="">
        <ul class="nav nav-tabs">
            <li class="nav-items">
                <a class="nav-link" href="contractEdit.php?id=<?= $filtered_id ?>">첨부파일(<?= count($fileRows) ?>건)</a>
            </li>
        </ul>
    </nav>
    <div class="">
        <?php
        include "./edit/5_file.php";
        ?>
    </div>
    <nav class="">
        <ul class="nav nav-tabs">
            <li class="nav-items">
                <a id="navMemo" class="nav-link"
                    href="contractEdit.php?id=<?= $filtered_id ?>">메모작성(<?= count($memoRows) ?>건)</a>
            </li>
        </ul>
    </nav>
    <div class="">
        <?php
        include "./edit/6_memo.php";
        ?>
    </div>
</section>


<!-- 최하단 계약정보작성자보여주기섹션 -->
<section class="d-flex justify-content-center">
    <small class="form-text text-muted text-center">계약번호[<?= $row[0] ?>] 등록일시[<?= $row['createTime'] ?>]
        수정일시[<?= $row['updateTime'] ?>] </small>
</section>

</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/customer/modal_customer.php";
include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/sms/modal_sms3.php";
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_footer.php"; ?>


<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/autosize.min.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/etc/form.js?<?= date('YmdHis') ?>"></script>
<script src="/svc/inc/js/etc/sms_noneparase4.js?<?= date('YmdHis') ?>"></script>
<script src="/svc/inc/js/etc/customer.js?<?= date('YmdHis') ?>"></script>
<script src="/svc/inc/js/etc/customer_edit.js?<?= date('YmdHis') ?>"></script>
<script src="/svc/inc/js/etc/ce_pl_f2.js?<?= date('YmdHis') ?>"></script>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="/svc/inc/js/daumAddressAPI3.js?<?= date('YmdHis') ?>"></script>


<script type="text/javascript">
var buildingArray = <?php echo json_encode($buildingArray); ?>;
var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
var roomArray = <?php echo json_encode($roomArray); ?>;
console.log(buildingArray);
console.log(groupBuildingArray);
console.log(roomArray);
</script>

<script>
let contractId = <?= $filtered_id ?>;
// let tbl = $("#checkboxTestTbl");
let customerId = $('input[name=customerId').val();
let buildingId = $('input[name=building').val();
let step = '<?= $step ?>';
let url = '../../ajax/ajax_amountlist.php';

$('input').attr('autocomplete', 'off');

// console.log(contractId, customerId, buildingId, step, url);

$(document).on('click', '.dateType', function() {
    $('.dateType').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
        closeText: '닫기' // 닫기 버튼 패널
    })

    // console.log('solmi');
})

$(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('input[name=expecteDay]').on('click', function() {
        $(this).select();
    })

    autosize($('textarea[name=memoContent]'));

    $('.dateType').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
        closeText: '닫기' // 닫기 버튼 패널
    })

    $(".amountNumber").click(function() {
        $(this).select();
    });

    $("input:text[numberOnly]").number(true);

    $(".numberComma").number(true);

    $('#groupExpecteDay').keydown(function(event) {
        var key = event.charCode || event.keyCode || 0;
        $text = $(this);
        if (key !== 8 && key !== 9) {
            if ($text.val().length === 4) {
                $text.val($text.val() + '-');
            }
            if ($text.val().length === 7) {
                $text.val($text.val() + '-');
            }
        }

        return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <=
            105));
        // Key 8번 백스페이스, Key 9번 탭, Key 46번 Delete 부터 0 ~ 9까지, Key 96 ~ 105까지 넘버패트
        // 한마디로 JQuery 0 ~~~ 9 숫자 백스페이스, 탭, Delete 키 넘버패드외에는 입력못함
    })


    $('#smsBtn').on('click', function() {
        // var buildingkey = $('input[name=building]').val();
        var buildingkey = '<?= $row['building_id'] ?>';
        console.log(buildingkey);
        var recievephonenumber = '<?= $cContact ?>';
        var cname = '<?= $row[2] ?>';

        //문자발송번호
        var sendphonenumber = buildingArray[buildingkey][3] + buildingArray[buildingkey][4] +
            buildingArray[buildingkey][5];
        $('input[name=sendphonenumber]').val(sendphonenumber);

        //문자수신번호
        $('#recievephonenumber').text(recievephonenumber);
        $('#mcid').val(customerId);
        $('#mcname').text(cname);

        sms_noneparase();
    })

    amountlist(contractId, url);
    depositlist(contractId);
    memolist(contractId);
    filelist(contractId);
    refundlist(contractId);

    //   $('title').text(<?= $row['rname'] ?>);
    $(document).attr('title', '<?= $row['rname'] ?> 임대계약상세');

}) //document.ready function closing}
//=====================================

var tbl = $("table[name=tableAmount]");
var expectedDayArray = [];
var AmountArray = [];
var AmountArrayEle = [];
var amountMoney = [0, 0, 0];

$('#allselect2').click(function() {

    var allCnt = $('.tbodycheckbox2').length;
    var table = tbl.find('tbody');
    expectedDayArray = [];
    amountMoney = [0, 0, 0];
    let amount, vamount, tamount;

    if ($(this).is(":checked")) {
        for (var i = 0; i < allCnt; i++) {
            var expectedDayEle = [];
            var rowid = i; //system order
            var colOrder = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=order]").children(
                'span[name=ordered]').text(); //order
            var colid = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=checkbox]").children(
                'input[name=csId]').val(); //csId
            var colexpectDate = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                'input[name=mExpectedDate]').val();

            expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
            expectedDayArray.push(expectedDayEle);

            var payId = table.find("tr[name=contractRow]:eq(" + i + ")").find("td:eq(0)").children(
                'input[name=payId]').val();

            console.log(payId, typeof(payId));

            if (payId === '0' || payId === 'null') { //청구번호가 없으면, 인풋박스안에 value
                amount = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                    'input[name=mAmount]').val();
                vamount = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                    'input[name=mvAmount]').val();
                tamount = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                    'input[name=mtAmount]').val();
                amount = Number(amount);
                vamount = Number(vamount);
                tamount = Number(tamount);

                // console.log(amount, vamount, tamount);
            } else {
                amount = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                    'span[name=mAmount]').text();
                vamount = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                    'span[name=mvAmount]').text();
                tamount = table.find("tr[name=contractRow]:eq(" + i + ")").find("td[name=detail]").find(
                    'span[name=mtAmount]').text();
                amount = Number(amount.replace(/,/gi, ''));
                vamount = Number(vamount.replace(/,/gi, ''));
                tamount = Number(tamount.replace(/,/gi, ''));

                // console.log(amount, vamount, tamount);
            }

            amountMoney[0] += amount;
            amountMoney[1] += vamount;
            amountMoney[2] += tamount;
        } //for}
        // console.log(expectedDayArray);

        $(".tbodycheckbox2").prop('checked', true);
        $(".tbodycheckbox2").parent().parent().addClass("selected");

        //==========================


        $('#selectcount').html(allCnt);
        $('#selectamount').html(amountMoney[0]);
        $('#selectamount').number(true);
        $('#selectvamount').html(amountMoney[1]);
        $('#selectvamount').number(true);
        $('#selecttamount').html(amountMoney[2]);
        $('#selecttamount').number(true);
        // console.log(amountMoney);

    } else {
        expectedDayArray = [];
        // console.log(expectedDayArray);
        $(".tbodycheckbox2").prop('checked', false);
        $(".tbodycheckbox2").parent().parent().removeClass("selected");

        amountMoney = [0, 0, 0];
        $('#selectcount').text(0);
        $('#selectamount').text(0);
        $('#selectvamount').text(0);
        $('#selecttamount').text(0);
    }
    // console.log(expectedDayArray);
})

// $('.table').on('click',$(':checkbox:not(:first).is(":checked")'),function()

$(document).on('change', '.tbodycheckbox2', function() {

    var expectedDayEle = [];
    var allCnt = $(".tbodycheckbox2").length;
    var checkedCnt = $(".tbodycheckbox2").filter(":checked").length;

    //   console.log(allCnt, checkedCnt);

    if ($(this).is(":checked")) {
        var currow = $(this).closest('tr');
        var rowid = currow.find('td[name=order]').children('input[name=rowid]').val();
        rowid = Number(rowid);
        var colOrder = currow.find('td[name=order]').children('span[name=ordered]').text();
        var colid = currow.find('td[name=checkbox]').children('input[name=csId]').val();
        var colexpectDate = currow.find('td[name=detail]').find('input[name=mExpectedDate]').val();
        expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
        expectedDayArray.push(expectedDayEle);
        // console.log(expectedDayArray);

        $(this).prop('checked', true);
        $(this).parent().parent().addClass("selected");

        checkedCnt = $(".tbodycheckbox2").filter(":checked").length;

        var payId = currow.find('td:eq(0)').children('input[name=payId]').val();
        // let amount, vamount, tamount;

        // console.log(payId);

        if (payId === '0' || payId === 'null') {
            amount = currow.find("td[name=detail]").find('input[name=mAmount]').val();
            vamount = currow.find("td[name=detail]").find('input[name=mvAmount]').val();
            tamount = currow.find("td[name=detail]").find('input[name=mtAmount]').val();
            amount = Number(amount);
            vamount = Number(vamount);
            tamount = Number(tamount);

            // console.log('input : ', amount, vamount, tamount);
        } else {
            amount = currow.find("td[name=detail]").find('span[name=mAmount]').text();
            vamount = currow.find("td[name=detail]").find('span[name=mvAmount]').text();
            tamount = currow.find("td[name=detail]").find('span[name=mtAmount]').text();
            amount = Number(amount.replace(/,/gi, ''));
            vamount = Number(vamount.replace(/,/gi, ''));
            tamount = Number(tamount.replace(/,/gi, ''));

            // console.log('span : ', amount, vamount, tamount);
        }

        // console.log(amountMoney[0]);
        // console.log(amount, vamount, tamount);
        AmountArrayEle.push(amount, vamount, tamount);
        AmountArray.push(AmountArrayEle);
        amountMoney[0] += amount;
        amountMoney[1] += vamount;
        amountMoney[2] += tamount;

        // console.log(amountMoney[0]);

        $('#selectcount').html(checkedCnt);
        $('#selectamount').html(amountMoney[0]);
        $('#selectamount').number(true);
        $('#selectvamount').html(amountMoney[1]);
        $('#selectvamount').number(true);
        $('#selecttamount').html(amountMoney[2]);
        $('#selecttamount').number(true);

    } else {
        var currow = $(this).closest('tr');
        var colOrder = currow.find('td[name=order]').children('span[name=ordered]').text();

        for (var i = 0; i < expectedDayArray.length; i++) {
            if (expectedDayArray[i][1] === colOrder) {
                var index = i;
                break;
            }
        }

        expectedDayArray.splice(index, 1);

        $(this).prop('checked', false);
        $(this).parent().parent().removeClass("selected");
        checkedCnt = $(".tbodycheckbox2").filter(":checked").length;

        var payId = currow.find('td:eq(0)').children('input[name=payId]').val();
        var amount, vamount, tamount;

        if (payId === '0' || payId === 'null') {
            amount = currow.find("td[name=detail]").find('input[name=mAmount]').val();
            vamount = currow.find("td[name=detail]").find('input[name=mvAmount]').val();
            tamount = currow.find("td[name=detail]").find('input[name=mtAmount]').val();
            amount = Number(amount);
            vamount = Number(vamount);
            tamount = Number(tamount);
        } else {
            amount = currow.find("td[name=detail]").find('span[name=mAmount]').text();
            vamount = currow.find("td[name=detail]").find('span[name=mvAmount]').text();
            tamount = currow.find("td[name=detail]").find('span[name=mtAmount]').text();
            amount = Number(amount.replace(/,/gi, ''));
            vamount = Number(vamount.replace(/,/gi, ''));
            tamount = Number(tamount.replace(/,/gi, ''));
        }

        var dropReady = AmountArrayEle.push(amount, vamount, tamount);
        var index = AmountArray.indexOf(dropReady);
        AmountArray.splice(index, 1);
        amountMoney[0] -= amount;
        amountMoney[1] -= vamount;
        amountMoney[2] -= tamount;

        // console.log(amountMoney);

        $('#selectcount').html(checkedCnt);
        $('#selectamount').html(amountMoney[0]);
        $('#selectamount').number(true);
        $('#selectvamount').html(amountMoney[1]);
        $('#selectvamount').number(true);
        $('#selecttamount').html(amountMoney[2]);
        $('#selecttamount').number(true);
    }

    if (allCnt == checkedCnt) {
        $("#allselect2").prop("checked", true);
    } else {
        $("#allselect2").prop("checked", false);
    }
    // console.log(expectedDayArray);
})
//=====================================


$('.eachpop').on('click', function() {
    m_customer(customerId);
})

//===================
$(document).on('click', '#button5', function() { //1개월추가 버튼클릭

    let allCnt = $(":checkbox:not(:first)", tbl).length;
    let url = '/svc/service/contract/process/pp_contractScheduleAppend.php';

    //   console.log(allCnt, contractId, url);

    if (allCnt === 72) {
        alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
        return false;
    }

    amountlist(contractId, url);

}); //1개월추가 버튼

$('#button7').click(function() { //삭제버튼 클릭시
    var contractScheduleArray = [];
    var allCnt = $(":checkbox:not(:first)", tbl).length;
    var table = tbl.find('tbody');
    // console.log(allCnt, expectedDayArray.length);
    // console.log(expectedDayArray);

    if (expectedDayArray.length === 0) {
        alert('한개 이상을 선택해야 삭제 가능합니다.');
        return false;
    }

    for (var i = 0; i < expectedDayArray.length; i++) {

        contractScheduleArray[i] = [];

        var csId = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=checkbox]').children('input[name=csId]').val();

        var csOrder = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=order]').children('span[name=ordered]').text();

        var psId = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=checkbox]').children('input[name=payId]').val();

        if (!(psId === 'null' || psId === '0')) {
            alert('청구번호는 ' + psId + ' 입니다. 청구번호가 존재하면 삭제할수 없습니다.');
            return false;
        }

        contractScheduleArray[i].push(csId, csOrder, psId);
    }
    // console.log(contractScheduleArray);

    var selectedOrderArray = [];
    for (var i = 0; i < expectedDayArray.length; i++) {
        selectedOrderArray.push(Number(expectedDayArray[i][1]));
    }
    selectedOrderArray.sort(function(a, b) {
        return a - b;
    }); //선택한순번들을 오름차순으로 정렬해주는것
    // console.log(selectedOrderArray);

    var regularOrderArray = [];
    for (var i = 0; i < contractScheduleArray.length; i++) {
        var ele = allCnt - i;
        regularOrderArray.push(ele);
    }
    regularOrderArray.sort(function(a, b) {
        return a - b;
    }); //정해진순번들을 오름차순으로 정렬해주는것
    // console.log(regularOrderArray);

    if (!selectedOrderArray.includes(allCnt)) {
        console.log(selectedOrderArray);
        console.log(allCnt);
        alert('스케줄 중간을 삭제할 수 없습니다.');
        return false;
    }

    if (selectedOrderArray.includes(1)) {
        alert('순번1은 삭제할 수 없습니다. 1개이상의 스케쥴은 존재해야 합니다.');
        return false;
    }

    for (var i = 0; i < regularOrderArray.length; i++) {
        if (!((regularOrderArray[i] - selectedOrderArray[i]) === 0)) {
            alert('스케줄은 순차적으로 삭제되어야 합니다.');
            return false;
        }
    }

    var contractScheduleIdArray = [];
    for (var i = 0; i < contractScheduleArray.length; i++) {
        contractScheduleIdArray.push(contractScheduleArray[i][0]);
    }

    contractScheduleIdArray = JSON.stringify(contractScheduleIdArray);

    // console.log(contractScheduleIdArray);

    let url = '/svc/service/contract/process/pp_contractScheduleDrop.php';

    amountlist2(contractId, contractScheduleIdArray, url);

}) //삭제버튼 클릭시


//===============
$('#button6').click(function() { //n개월추가 버튼, 모달클릭으로 바뀜

    let modal1 = new bootstrap.Modal(document.getElementById('nAddBtn'), {
        keyboard: false
    });
    modal1.show();

    let mAmount = '<?= $row['mAmount'] ?>';
    let mvAmount = '<?= $row['mvAmount'] ?>';
    let mtAmount = '<?= $row['mtAmount'] ?>';
    let lastDate = '<?= $row['endDate2'] ?>';
    let payOrder = '<?= $row['payOrder'] ?>';

    // console.log(mAmount, mvAmount, mtAmount, lastDate, payOrder);

    lastDate2 = new Date(lastDate);
    let nextDate = new Date(lastDate2.getFullYear(), lastDate2.getMonth(), lastDate2.getDate() + 1);
    let oneMonthLater = new Date(nextDate.getFullYear(), nextDate.getMonth() + 1, nextDate.getDate() - 1);
    let oneMonthLater1 = new Date(oneMonthLater.getFullYear(), oneMonthLater.getMonth(), oneMonthLater
        .getDate() + 1);

    nextDate = nextDate.getFullYear() + '-' + (nextDate.getMonth() + 1) + '-' + nextDate.getDate();

    oneMonthLater = oneMonthLater.getFullYear() + '-' + (oneMonthLater.getMonth() + 1) + '-' + oneMonthLater
        .getDate();

    oneMonthLater1 = oneMonthLater1.getFullYear() + '-' + (oneMonthLater1.getMonth() + 1) + '-' + oneMonthLater1
        .getDate();

    // console.log(nextDate, oneMonthLater, oneMonthLater1);


    $("input[name='modalAmount1']").val(mAmount);
    $("input[name='modalAmount2']").val(mvAmount);
    $("input[name='modalAmount3']").val(mtAmount);

    if (payOrder === '선납') {
        $("#mpExpectedDate2").val(lastDate);
        $("#mexecutiveDate2").val(lastDate);
    } else {
        $("#mpExpectedDate2").val(oneMonthLater1);
        $("#mexecutiveDate2").val(oneMonthLater1);
    }

    $('input[name=addMonth]').on('keyup', function() {
        var monthCount = Number($(this).val());
        var mtAmount = $("input[name='modalAmount3']").val();
        mtAmount = parseInt(mtAmount.replace(",", ""));
        var executiveAmount = monthCount * mtAmount;

        executiveAmount = executiveAmount.toLocaleString();

        // console.log(monthCount, executiveAmount);

        $('#mexecutiveAmount2').val(executiveAmount);
    })

    $("input[name='modalAmount1']").on('keyup', function() {
        var changeAmount1 = Number($(this).val());
        var changeAmount2 = Number($("input[name='modalAmount2']").val());
        var changeAmount3 = changeAmount1 + changeAmount2;
        var monthCount = Number($('input[name=addMonth]').val());
        var executiveAmount = monthCount * changeAmount3;

        $("input[name='modalAmount3']").val(changeAmount3);
        $('#mexecutiveAmount2').val(executiveAmount);
    });

    $("input[name='modalAmount2']").on('keyup', function() {
        var changeAmount2 = Number($(this).val());
        var changeAmount1 = Number($("input[name='modalAmount1']").val());
        var changeAmount3 = changeAmount1 + changeAmount2;
        var monthCount = Number($('input[name=addMonth]').val());
        var executiveAmount = monthCount * changeAmount3;
        $("input[name='modalAmount3']").val(changeAmount3);
        $('#mexecutiveAmount2').val(executiveAmount);
    });

    $('#buttonm3').on('click', function() { //추가하기 버튼
        let allCnt = $(":checkbox:not(:first)", tbl).length;
        let addMonth = Number($("input[name='addMonth']").val());
        let mAmount = $("input[name='modalAmount1']").val();
        let mvAmount = $("input[name='modalAmount2']").val();
        let mtAmount = $("input[name='modalAmount3']").val();

        // console.log(allCnt, addMonth, mAmount, mvAmount, mtAmount);

        if (!addMonth) {
            alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
            return false;
        }

        if (Number(addMonth) + allCnt > 72) {
            alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
            return false;
        }

        let url = '/svc/service/contract/process/pp_contractScheduleAppendM.php';

        amountlist3(contractId, url, addMonth, mAmount, mvAmount, mtAmount);

        // modal1.modal('dispose');

    }) //1.추가하기

    $('#buttonm2').on('click', function() { //청구설정 버튼
        let allCnt = $(":checkbox:not(:first)", tbl).length;
        let addMonth = Number($("input[name='addMonth']").val());
        let mAmount = $("input[name='modalAmount1']").val();
        let mvAmount = $("input[name='modalAmount2']").val();
        let mtAmount = $("input[name='modalAmount3']").val();
        var expectedDate = $('#mpExpectedDate2').val();
        var payKind = $('#executiveDiv2').val();


        if (!addMonth) {
            alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
            return false;
        }

        if (Number(addMonth) + allCnt > 72) {
            alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
            return false;
        }

        let url = '/svc/service/contract/process/pp_payScheduleAdd2.php';

        // console.log(contractId, url, addMonth, mAmount, mvAmount, mtAmount, expectedDate, payKind, buildingId);

        amountlist4(contractId, url, addMonth, mAmount, mvAmount, mtAmount, expectedDate, payKind,
            buildingId);

        // $('#nAddBtn').modal('hide');

    }) //2.청구설정

    $('#buttonm1').on('click', function() { //입금완료 버튼
        let allCnt = $(":checkbox:not(:first)", tbl).length;
        let addMonth = Number($("input[name='addMonth']").val());
        let mAmount = $("input[name='modalAmount1']").val();
        let mvAmount = $("input[name='modalAmount2']").val();
        let mtAmount = $("input[name='modalAmount3']").val();
        var expectedDate = $('#mpExpectedDate2').val();
        var payKind = $('#executiveDiv2').val();
        var executiveDate = $('#mexecutiveDate2').val();
        var executiveAmount = $('#mexecutiveAmount2').val();

        if (!addMonth) {
            alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
            return false;
        }

        if (Number(addMonth) + allCnt > 72) {
            alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
            return false;
        }

        if (!(expectedDate && executiveDate)) {
            alert('입금예정일 또는 입금완료일을 둘다 넣어주거나 아니면 둘다 넣지 않아야 합니다. 둘 중 한개만 넣으면 처리되지 않습니다.');
            return false;
        }

        let url = '/svc/service/contract/process/pp_payScheduleGetAmountInputFor2.php';

        // console.log(contractId, url, addMonth, mAmount, mvAmount, mtAmount, expectedDate, payKind, buildingId, executiveDate, executiveAmount);

        amountlist5(contractId, url, addMonth, mAmount, mvAmount, mtAmount, expectedDate, payKind,
            buildingId, executiveDate, executiveAmount);

        // $('#nAddBtn').modal('hide');

    }) //3.입금완료

}); //n개월추가버튼누를때

//=================
$(document).on('click', '.modalpay', function() { //청구번호클릭하는거(모달클릭)
    var currow2 = $(this).closest('tr');
    var payNumber = $(this).text();
    var expectedAmount = $(this).parent().siblings('input[name=ptAmount]').val();
    var expectedDate = $(this).parent().siblings('input[name=pExpectedDate]').val();
    var executiveDiv = $(this).parent().siblings('input[name=payKind]').val(); //입금구분
    var executiveDate = $(this).parent().siblings('input[name=executiveDate]').val();
    var executiveAmount = $(this).parent().siblings('input[name=getAmount]').val();
    var payDiv = $(this).parent().siblings('span[name=payDiv]').text();
    var taxMun = $(this).parent().siblings('input[name=taxMun]').val();
    // alert(taxMun);

    // console.log(filtered_id, payNumber, expectedAmount, expectedDate, executiveDiv, executiveDate, executiveAmount, payDiv, taxMun);

    var footer1 =
        "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mpayBack' class='btn btn-warning btn-sm mr-0'>청구취소</button><button type='button' id='mgetExecute' class='btn btn-primary btn-sm'>입금완료</button>"; //입금대기이고 증빙이 없을때
    var footer11 =
        "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mpayBack' class='btn btn-warning btn-sm mr-0' disabled>청구취소</button><button type='button' id='mgetExecute' class='btn btn-primary btn-sm'>입금완료</button>"; //입금대기이고 증빙있을때
    var footer2 =
        "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mModify' class='btn btn-warning btn-sm mr-0'>수정</button><button type='button' id='mExecuteBack' class='btn btn-warning btn-sm mr-0'>입금취소</button>"; //입금완료이고 증빙일자 없을때
    var footer22 =
        "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mExecuteBack' class='btn btn-warning btn-sm mr-0' disabled>입금취소</button>"; //입금완료이고 증빙일자 있을때

    // console.log(expectedAmount, expectedDate, executiveDiv, executiveDate, executiveAmount);

    $('#payId').text(payNumber);
    $('#expectedAmount').val(expectedAmount);
    $('#expectedDate').val(expectedDate);
    if (executiveDiv === '계좌') {
        $('#executiveDiv').val('계좌').prop('selected', true);
    } else if (executiveDiv === '현금') {
        $('#executiveDiv').val('현금').prop('selected', true);
    } else if (executiveDiv === '카드') {
        $('#executiveDiv').val('카드').prop('selected', true);
    }

    if (payDiv === '완납' || payDiv === '완납(연체)') {

        // $('#expectedDate').val(expectedDate).prop('disabled', true);
        $('#expectedDate').val(expectedDate); //입금예정일도 수정할수 있도록 변경시킴
        $('#expectedAmount').val(expectedAmount).prop('disabled', true);
        $('#executiveAmount').val(expectedAmount).prop('disabled', true); //하다보니 입금수단과 입금일은 좀 수정을 하고싶어짐
        $('#executiveDiv').val(executiveDiv);
        $('#executiveDate').val(executiveDate);
        if (taxMun === 'null') {
            $('#modalfooter11').html(footer2);
        } else {
            $('#modalfooter11').html(footer22);
        }
    } else if (payDiv === '입금대기' || payDiv === '미납') {
        $('#executiveDiv').prop('disabled', false);
        $('#executiveDate').val(expectedDate).prop('disabled', false);
        $('#executiveAmount').val(expectedAmount).prop('disabled', false);
        if (taxMun === 'null') {
            $('#modalfooter11').html(footer1);
        } else {
            $('#modalfooter11').html(footer11);
        }
    }

    $('#mModify').on('click', function() { //수정버튼(모달안버튼) 클릭

        var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)')
            .text(); //청구번호
        var payDiv2 = $('#executiveDiv').val(); //입금수단, 계좌/현금/카드
        var executiveDate2 = $('#executiveDate').val(); //입금금액
        var expectedDate2 = $('#expectedDate').val(); //입금예정일
        let url = '/svc/service/contract/process/pp_payScheduleGetAmountModify.php';

        if (executiveDiv === payDiv2 && executiveDate === executiveDate2 && expectedDate ===
            expectedDate2) {
            alert('수정내역이 없습니다.');
            // $('#pPay').modal('hide');
            return false;
        }

        amountlist22(pid, payDiv2, executiveDate2, contractId, url, expectedDate2);
        // alert('수정했습니다.');
        $('#pPay').modal('hide');
    })

    $('#mpayBack').on('click', function() { //청구취소버튼(모달안버튼) 클릭

        var payId = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)')
            .text(); //청구번호

        // console.log(pid, contractId);

        let url = '/svc/service/contract/process/pp_payScheduleDrop.php';

        amountlist20(contractId, payId, url);
        // $('#pPay').modal('dispose');
        $('#pPay').modal('hide');
    })

    $('#mgetExecute').on('click', function() { //입금완료버튼(모달안버튼) 클릭

        var pExpectedDate = $('#expectedDate').val(); //입금예정일

        var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)')
            .text(); //청구번호

        var ppayKind = $(this).parent().prev().children().children(':eq(2)').children(':eq(1)')
            .children().val(); //입금구분

        var pgetDate = $(this).parent().prev().children().children(':eq(3)').children(':eq(1)')
            .children().val(); //입금일

        var pgetAmount = $(this).parent().prev().children().children(':eq(4)').children(':eq(1)')
            .children().val(); //입금액

        var pExpectedAmount = $(this).parent().prev().children().children(':eq(0)').children(':eq(1)')
            .children().val(); //예정금액

        let url = '/svc/service/contract/process/pp_payScheduleGetAmountInput.php';

        console.log(contractId, pid, ppayKind, pgetDate, pgetAmount, pExpectedDate);

        if (pgetAmount != pExpectedAmount) {
            alert('입금액과 예정금액은 같아야 합니다.');
            return false;
        }

        amountlist31(contractId, pid, ppayKind, pgetDate, pgetAmount, pExpectedDate, url);

        $('#pPay').modal('hide');
    })

    $('#mExecuteBack').on('click', function() { //입금취소버튼(모달안버튼) 클릭

        var pid = $(this).parent().parent().children(':eq(0)').children(':eq(0)').children(':eq(0)')
            .text(); //청구번호
        let url = '/svc/service/contract/process/pp_payScheduleGetAmountCansel.php';

        // console.log(pid, contractId);

        amountlist20(contractId, pid, url);
        $('#pPay').modal('hide');
    })

}) //청구번호클릭하는거(모달클릭) closing}

function taxInfo2(bid, mun, ccid) {
    var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
    // $("body").append(tmps);
    $('body').prepend(tmps);
    //alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );

    $("#ifm_pops_21").attr("src", "/svc/service/get/tax_invoice.php?building_idx=" + bid + "&mun=" + mun + "&id=" +
        ccid + "&flag=expected");
    $('#ifm_pops_21').show();
    $('.pops_wrap, .pops_21').show();

}

$(document).on('click', 'u.taxDate', function() {
    var mun = $(this).parents().siblings('input[name=taxMun]').val();

    console.log(buildingId, mun, customerId);

    taxInfo2(buildingId, mun, customerId);
})

//===================


$(document).on('change', '#groupExpecteDay', function() { //입금예정일 변경버튼 이벤트
    var expectedDayGroup = $('#groupExpecteDay').val();
    var table = tbl.find('tbody');

    if (expectedDayArray.length >= 1) {
        for (var i in expectedDayArray) {
            table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find("td[name=detail]").find(
                'input[name=mExpectedDate]').val(expectedDayGroup);
            // console.log(expectedDayArray[i][0], a);
        }
    } else {
        alert('변경해야할 행이 없습니다.');
    }
})

$(document).on('change', '#paykind', function() { //입금수단 변경버튼 이벤트
    var a = $(this).val();
    var table = tbl.find('tbody');

    if (expectedDayArray.length >= 1) {
        for (var i in expectedDayArray) {
            table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find("td[name=detail]").find(
                'select[name=payKind]').val(a).prop('selected', true);
            // console.log(expectedDayArray[i][0], a);
        }
    }
})

//============================
$(document).on('click', '#button1', function() { //청구설정버튼 클릭시
    var paykind = $('#paykind option:selected').text();


    expectedDayArray = expectedDayArray.sort(function(a, b) {
        return a[0] - b[0];
    }) //순번대로 정렬함(오름차순), 이거 중요함, 그런데 이거하고나니 엄청 느려짐 ㅠㅠ

    var contractScheduleArray = [];

    for (var i = 0; i < expectedDayArray.length; i++) {
        var table = tbl.find('tbody');
        var payId = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=checkbox]').children('input[name=payId]').val(); //청구번호

        // console.log(payId);
        if (!(payId === '0')) {
            alert('청구번호가 이미 존재하여 청구설정 불가합니다. 다시 확인해주세요.');
            window.location.reload();
            return false;
        }

        // table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(7)").text(paykind);이게 왜있지? 20.11.12
        // console.log(expectedDayArray[i][0], a);
        // 입금구분을 변경시키는 것
        var contractScheduleEle = [];

        let cid = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=checkbox]').children('input[name=csId]').val(); //계약번호
        let order = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=order]').children('span[name=ordered]').text(); //순번
        let startDate = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=date]').find('span[name=mStartDate]').text(); //시작일
        let endDate = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=date]').find('span[name=mEndDate]').text(); //종료일
        let mAmount = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mAmount]').val(); //공급가액
        let mvAmount = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mvAmount]').val(); //세액
        let mtAmount = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mtAmount]').val(); //합계금액
        let expectedDate = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mExpectedDate]').val(); //예정일
        let payKind = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('select[name=payKind]').val(); //입금구분

        contractScheduleEle.push(cid, order, startDate, endDate, mAmount, mvAmount, mtAmount, expectedDate,
            payKind);

        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=checkbox]').children('input[name=csId]').val()); //계약번호
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=order]').children('span[name=ordered]').text()); //순번
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=date]').find('span[name=mStartDate]').text()); //시작일
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=date]').find('span[name=mEndDate]').text()); //종료일
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=detail]').find('input[name=mAmount]').val()); //공급가액
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=detail]').find('input[name=mvAmount]').val()); //세액
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=detail]').find('input[name=mtAmount]').val()); //합계금액
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=detail]').find('input[name=mExpectedDate]').val()); //예정일
        // contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
        //     'td[name=detail]').find('select[name=payKind]').val()); //입금구분

        contractScheduleArray.push(contractScheduleEle);
    }
    console.log(contractScheduleArray);

    contractScheduleArray = JSON.stringify(contractScheduleArray);

    // console.log(expectedDayArray);

    if (expectedDayArray.length === 0) {
        alert('한개 이상을 선택해야 청구가 됩니다.');
        return false;
    } else if (expectedDayArray.length <= 120) {

        let url = '/svc/service/contract/process/pp_payScheduleAdd.php';
        // console.log(contractId, buildingId,contractScheduleArray, url);
        amountlist21(contractId, buildingId, contractScheduleArray, url);

    } else {
        alert('계약기간은 120개월, 10년으로 제안됩니다. 그 이상인경우 새로운 계약을 생성해주세요.');
        return false;
    }

})

$(document).on('click', '#button2', function() { //청구취소버튼 클릭시

    if (expectedDayArray.length === 0) {
        alert('선택한 내역이 없습니다.');
        return false;
    }

    var payIdArray = [];
    var table = tbl.find('#schedule');

    console.log(expectedDayArray);

    for (var i = 0; i < expectedDayArray.length; i++) {

        var payIdArrayEle = [];
        var payId = table.find('tr[name=contractRow]:eq(' + expectedDayArray[i][0] + ')').find('td:eq(0)')
            .children('input[name=payId]').val(); //청구번호
        var csCheck = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail2]').children('span[name=payDiv]').text(); //수납구분
        // console.log(csCheck);
        var taxMun = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail2]').children('span[name=taxMun]').text();

        if (payId === '' || payId === null) {
            window.location.reload();
            alert('청구번호가 존재해야 청구취소 가능합니다.');
            return false;
        }

        if (csCheck == '완납' || csCheck == '완납(연체)') {
            alert('완납상태여서 청구취소 불가합니다. 입금취소부터 해주세요.');
            window.location.reload();
            return false;
        }

        if (taxMun) {
            alert('세금계산서가 발행된 상태이므로 청구취소 불가합니다. 내용을 다시 확인하거나 만일 반드시 청구취소해야 한다면, 데이터정정요청 버튼을 클릭하세요.');
            window.location.reload();
            return false;
        }

        payIdArrayEle.push(payId, csCheck);
        payIdArray.push(payIdArrayEle);
    }
    // console.log(payIdArray);

    var contractId = '<?= $filtered_id ?>';
    payIdArray = JSON.stringify(payIdArray);
    var url = '/svc/service/contract/process/pp_payScheduleDropFor.php';
    // goCategoryPage(payIdArray, contractId);

    // console.log(payIdArray, contractId);
    amountlist24(contractId, payIdArray, url);

})


$('#button3').click(function() { //일괄입금버튼 클릭시

    var payIdArray = [];
    var table = tbl.find('tbody');

    // console.log(expectedDayArray);

    if (expectedDayArray.length === 0) {
        alert('청구설정된것을 선택해야 일괄입금처리가 가능합니다.');
        return false;
    }

    for (var i = 0; i < expectedDayArray.length; i++) {
        var payIdArrayEle = [];

        var psId = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find('td:eq(0)')
            .children('input[name=payId]').val(); //청구번호
        console.log(psId); //제이쿼리로 트림을 하니 더 이상해져서 안하기로함
        if (psId.trim() === "") { //trim()이거를 안넣으니 빈문자열로 인식이 안되어서 이거넣음
            alert('청구번호가 존재해야 일괄입금처리가 가능합니다.');
            window.location.reload();
            return false;
        }

        var csCheck = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail2]').children('span[name=payDiv]').text(); //수납구분
        if (csCheck == '완납' || csCheck == '완납(연체)') {
            alert('이미 입금처리가 되어있습니다.');
            return false;
        }

        var payKind = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').children('span[name=payKind]').text(); //입금구분
        var executiveDate = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').children('span[name=pExpectedDate]').text();
        var executiveAmount = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail2]').children('input[name=ptAmount]').val();

        payIdArrayEle.push(psId, payKind, executiveDate, executiveAmount);
        payIdArray.push(payIdArrayEle);
    }
    console.log(payIdArray);

    // var contractId = '<?= $filtered_id ?>';
    var url = '/svc/service/contract/process/pp_payScheduleGetAmountInputFor.php';
    payIdArray = JSON.stringify(payIdArray);

    amountlist24(contractId, payIdArray, url);

})

$('#button4').click(function() { //일괄입금취소버튼 클릭시

    var payIdArray = [];
    var table = tbl.find('tbody');

    if (expectedDayArray.length === 0) {
        alert('선택된것이 없습니다. 먼저 체크박스로 데이터를 선택해주세요.');
        return false;
    }

    for (var i = 0; i < expectedDayArray.length; i++) {

        var psId = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find('td:eq(0)')
            .children('input[name=payId]').val(); //청구번호

        if (psId === '0') { //trim()이거를 안넣으니 빈문자열로 인식이 안되어서 이거넣음
            alert('청구번호가 존재해야 일괄입금취소 처리가 가능합니다.');
            window.location.reload();
            return false;
        }

        var csCheck = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail2]').children('span[name=payDiv]').text(); //수납구분
        if (csCheck == '입금대기' || csCheck == '미납') {
            alert('아직 입금처리가 되어있지 않으므로 입금취소 불가합니다.');
            location.reload();
            return false;
        }

        var taxMun = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail2]').children('span[name=taxMun]').text();

        if (taxMun.length > 0) {
            alert(
                '세금계산서가 발행된 상태이므로 입금취소 불가합니다. 내용을 다시 확인하거나 만일 반드시 입금취소해야 한다면, 하단 이메일(info@leaseman.co.kr)로 데이터정정을 요청해주세요.'
            );
            return false;
        }

        console.log(taxMun);

        payIdArray.push(psId);
    }
    // console.log(contractScheduleArray);

    payIdArray = JSON.stringify(payIdArray);

    // console.log(payIdArray);

    var url = '/svc/service/contract/process/pp_payScheduleGetAmountCanselFor.php';

    amountlist24(contractId, payIdArray, url);

})

//==============================



$(document).on('click', '#buttonDirect', function() {
    var paykind = $('#paykind option:selected').text();
    var table = tbl.find('tbody');

    if (expectedDayArray.length === 0) {
        alert('한개 이상을 선택해야 즉시입금 가능합니다.');
        return false;
    }

    expectedDayArray = expectedDayArray.sort(function(a, b) {
        return a[0] - b[0];
    }) //순번대로 정렬함(오름차순), 이거 중요함, 그런데 이거하고나니 엄청 느려짐 ㅠㅠ

    var contractSchedule = [];

    for (var i = 0; i < expectedDayArray.length; i++) {
        var psId = table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=checkbox]').children('input[name=payId]').val(); //청구번호
        if (psId != 0) {
            alert('청구번호가 있는경우 입금처리버튼으로 입금해주세요.');
            return false;
        }

        // table.find("tr:eq("+expectedDayArray[i][0]+")").find("td:eq(7)").text(paykind);이게왜있나??
        // console.log(expectedDayArray[i][0], a);
        // 입금구분을 변경시키는 것
        var contractScheduleEle = [];
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=checkbox]').children('input[name=csId]').val()); //계약번호
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=order]').children('span[name=ordered]').text()); //순번
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=date]').find('span[name=mStartDate]').text()); //시작일
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=date]').find('span[name=mEndDate]').text()); //종료일
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mAmount]').val()); //공급가액
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mvAmount]').val()); //세액
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mtAmount]').val()); //합계금액
        contractScheduleEle.push(table.find("tr[name=contractRow]:eq(" + expectedDayArray[i][0] + ")").find(
            'td[name=detail]').find('input[name=mExpectedDate]').val()); //예정일

        contractSchedule.push(contractScheduleEle);
    }

    // console.log(contractSchedule);

    var contractSchedule11 = JSON.stringify(contractSchedule);
    let url = '/svc/service/contract/process/pp_payScheduleGetAmountInputFor3.php';

    amountlist23(contractSchedule11, contractId, buildingId, paykind, url);

})

//========================

$(document).on('keyup', "input[name='depositInAmount']", function() {
    var depositInAmount = Number($(this).val());
    var depositOutAmount = Number($("input[name='depositOutAmount']").val());
    var depositMoney = depositInAmount - depositOutAmount;
    $("input[name='depositMoney']").val(depositMoney);
});

$(document).on('keyup', "input[name='depositOutAmount']", function() {
    var depositInAmount = Number($("input[name='depositInAmount']").val());
    var depositOutAmount = Number($(this).val());
    var depositMoney = depositInAmount - depositOutAmount;
    $("input[name='depositMoney']").val(depositMoney);
});

$("button[name='depositSaveBtn']").on('click', function() {
    var depositInDate = $("input[name='depositInDate']").val();
    var depositInAmount = Number($("input[name='depositInAmount']").val());
    var depositOutDate = $("input[name='depositOutDate']").val();
    var depositOutAmount = Number($("input[name='depositOutAmount']").val());
    var depositMoney = Number($("input[name='depositMoney']").val());

    let url = '/svc/service/contract/process/pp_depositSave.php';

    amountlist32(contractId, depositInDate, depositInAmount, depositOutDate, depositOutAmount, depositMoney,
        url);

    alert('저장했습니다.');

})

$(document).on('click', 'input[name=depositInAmount]', function() {
    $(this).select();
})

$(document).on('click', 'input[name=depositOutAmount]', function() {
    $(this).select();
})

//===================================
$(document).on('click', '#memoButton', function() {
    var memoInputer = $('#memoInputer').val();
    var memoContent = $('#memoContent').val();

    if (!memoContent) {
        alert('내용을 입력해야 합니다.');
        return false;
    }
    // console.log(memoInputer, memoContent);

    var url = '/svc/service/contract/process/pp_memoAppend.php';

    memoInput(contractId, memoInputer, memoContent, url);

});

$(document).on('click', 'label[name=memoEdit]', function() {
    var memoid = $(this).parent().parent().find('td:eq(0)').children('input[name=memoid]').val();
    var memoCreator = $(this).parent().parent().find('td:eq(1)').children('input').val();
    var memoContent = $(this).parent().parent().children().children('textarea').val();
    // console.log(memoid, memoCreator, memoContent);
    var url = '/svc/service/contract/process/pp_memoEdit.php';

    // console.log(contractId,memoid,memoCreator,memoContent,url);

    memoEdit(contractId, memoid, memoCreator, memoContent, url);
    alert('수정했습니다.');
});


$(document).on('click', 'label[name=memoDelete]', function() {

    var c = confirm('정말 삭제하시겠습니까?');

    if (c) {
        var memoid = $(this).parent().parent().children().children('input:eq(0)').val();
        var url = '/svc/service/contract/process/pp_memoDelete.php';

        memoDelete(contractId, memoid, url);
    }

});

function fnUpload() {
    var extArray = new Array('hwp', 'xls', 'xlsx', 'doc', 'docx', 'pdf', 'jpg', 'jpeg', 'gif', 'png', 'txt', 'ppt',
        'pptx', 'tiff', 'zip');
    var path = $('input[name=upfile]').val();
    // console.log(path);

    if (path === "") {
        alert('파일을 선택해주세요.');
        return false;
    }

    var pos = path.lastIndexOf(".");
    if (pos < 0) {
        alert('확장자가 없는 파일입니다.');
        return false;
    }

    var ext = path.slice(path.lastIndexOf(".") + 1).toLowerCase();
    var checkExt = false;
    for (var i = 0; i < extArray.length; i++) {
        if (ext === extArray[i]) {
            checkExt = true;
            break;
        }
    }
    // console.log(ext, checkExt);

    if (checkExt === false) {
        alert('업로드할수있는 확장자가 아닙니다.');
        return false;
    }

    var url = '/svc/service/contract/process/pp_file.php';

    var form = $('form[name=uploadForm]')[0];
    var formData = new FormData(form);

    upfile(url, formData);

} //uploadBtn function closing}

$(document).on('click', 'button[name=fileDelete]', function() {
    var fileid = $(this).parent().parent().children().children('input:eq(0)').val();

    let url = '/svc/service/contract/process/pp_fileDelete.php';

    console.log(url, contractId, fileid);
    deletefile(url, contractId, fileid);
})

$('.table').on('keyup', '.amountNumber:input[type="text"]', function() {
    var currow = $(this).closest('table').parent().closest('tr');

    // console.log(colOrder);

    var colmAmount = Number(currow.find('td[name=detail]').find('input[name=mAmount]').val());

    var colmvAmount = Number(currow.find('td[name=detail]').find('input[name=mvAmount]').val());

    var colmtAmount = colmAmount + colmvAmount;
    currow.find('td[name=detail]').find('input[name=mtAmount]').val(colmtAmount);

    // console.log(colmAmount, colmvAmount, colmtAmount)

})

//===========================================

$("input[name='rAmount']").on('keyup', function() {
    var refundAmount1 = Number($(this).val());
    var refundAmount2 = Number($("input[name='rvAmount']").val());
    var refundAmount3 = refundAmount1 + refundAmount2;

    $("input[name='rtAmount']").val(refundAmount3);
});

$("input[name='rvAmount']").on('keyup', function() {
    var refundAmount2 = Number($(this).val());
    var refundAmount1 = Number($("input[name='rAmount']").val());
    var refundAmount3 = refundAmount1 + refundAmount2;

    $("input[name='rtAmount']").val(refundAmount3);
});

$('#enddate33').on('change', function() {
    $('#enddate44').val($(this).val());
})

$(document).on('click', '#enddate3btn', function() {
    var original_enddate = '<?= $row['endDate2'] ?>';
    var startDate = '<?= $row['startDate'] ?>';
    var enddate3 = $('#enddate33').val(); //중간종료일
    var enddate4 = $('#enddate44').val(); //환불일자
    var rPayid = $('input[name=rPayid]').val();
    let executiveDiv3 = $('#executiveDiv3').val(); //환불수단, 계좌/현금/카드 등
    let labeltext = $('#enddate3btn').children().text();
    let urlaa;
    let successMent;

    let middleEndAmount = Number($('input[name=rAmount]').val());
    let middleEndAvmount = Number($('input[name=rvAmount]').val());
    let middleEndAtmount = Number($('input[name=rtAmount]').val());

    original_enddate = new Date(original_enddate);
    startDate = new Date(startDate);
    enddate3 = new Date(enddate3);

    // console.log(original_enddate, startDate, enddate3);

    Date.prototype.isValid = function() {
        return this.getTime() === this.getTime();
    };

    if (!(enddate3.isValid())) {
        alert('중간종료일에 입력값이 없습니다.');
        return false;
    }

    if (step != '입금') {
        alert('현재 단계가 ' + step + ' 상태여서 중간종료처리를 할 필요가 없어요. 계약기간 등을 수정하면 됩니다.');
        return false;
    }

    if (original_enddate === enddate3) {
        alert('종료일과 같으면 중간종료가 아닙니다. 중간종료일을 다시 확인하세요');
        return false;
    }

    if (enddate3 <= startDate) {
        alert('시작일보다 작거나 같으면 중간종료가 아닙니다. 날짜를 다시 확인해주세요.');
        return false;
    }

    if (enddate3 >= original_enddate) {
        alert('종료일보다 크거나 같으면 중간종료가 아닙니다. 날짜를 다시 확인해주세요.');
        return false;
    }

    enddate3 = $('#enddate33').val(); //중간종료일을 다시 형식에 맞추어서 만들어준다.

    // console.log(contractId, enddate3, enddate4, middleEndAmount, middleEndAvmount, middleEndAtmount,
    // buildingId);

    if (labeltext === '입력하기') {
        urlaa = 'p_realContract_middle_end000.php';
        successMent = '중간중료 입력했습니다.';
    } else {
        urlaa = 'p_realContract_middle_end_edit.php';
        successMent = '중간중료 수정했습니다.';
    }

    // console.log(urlaa, successMent);

    middleEndCreate(urlaa, contractId, enddate3, enddate4, middleEndAmount, middleEndAvmount, middleEndAtmount,
        executiveDiv3, buildingId, rPayid, successMent)

    // refundlist(contractId);
})



$(document).on('click', '#enddateCansel', function() { //철회버튼
    let contractId = '<?= $filtered_id ?>';
    let rPayid = $('input[name=rPayid]').val();

    middleEndCansel(contractId, rPayid);
})
</script>
</body>
</script>