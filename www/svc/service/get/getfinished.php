<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>납부완료목록</title>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header1_meta.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/main/condition.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/contract/building.php"; //이거빼면큰일남, 조회안됨
    // print_r($_SESSION);

    $sql_sms = "select
          screen, title, description
        from sms
        where
          user_id={$_SESSION['id']} and
          screen='납부완료화면'";
    // echo $sql_sms;

    $result_sms = mysqli_query($conn, $sql_sms);
    $rowsms = array();
    while ($row_sms = mysqli_fetch_array($result_sms)) {
        $rowsms[] = $row_sms;
    }

    // print_r($rowsms);
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

    <!-- 제목섹션 -->
    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h2 class=""><span id="screenName">납부완료 목록이에요.(#501)</h2>
            <p class="lead">
                (1) 세금계산서 발행은 오늘 날짜 발행만 가능해요.<a href="https://blog.naver.com/leaseman_ad/221970487609"
                    target="_blank">발행방법 바로가기</a><br>
                (2) 만일 홈택스에서 세금계산서 또는 현금영수증을 발행한 것을 입력하고 싶을때, 입력버튼을 클릭하세요.<br>
                (3) 만일 세금계산서 취소를 원하면 <a href="https://www.popbill.com" target="_blank">팝빌사이트</a>에 로그인하여 발행취소처리해주세요 (단,
                데이터 정정은 리스맨고객센터(이메일 info@leaseman.co.kr)로 연락주세요.)
            </p>
        </div>
    </section>

    <!-- 조회조건 섹션 -->
    <section class="container">
        <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
            <div class="row justify-content-md-center">
                <form>
                    <table>
                        <tr>
                            <td width="6%" class="">
                                <select class="form-control form-control-sm selectCall" name="dateDiv">
                                    <option value="executiveDate">입금일자</option>
                                    <option value="taxDate">증빙일자</option>
                                </select>
                            </td>
                            <!--입금,증빙일자-->
                            <td width="5%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="periodDiv">
                                    <option value="allDate">--</option>
                                    <option value="nowMonth" selected>당월</option>
                                    <option value="pastMonth">전월</option>
                                    <option value="1pastMonth">1개월전</option>
                                    <!-- <option value="3pastMonth">3개월전</option> -->
                                    <option value="nowYear">당년</option>
                                    <option value="today">오늘</option>
                                    <option value="janu">1월</option>
                                    <option value="feb">2월</option>
                                    <option value="march">3월</option>
                                    <option value="april">4월</option>
                                    <option value="may">5월</option>
                                    <option value="june">6월</option>
                                    <option value="july">7월</option>
                                    <option value="august">8월</option>
                                    <option value="september">9월</option>
                                    <option value="october">10월</option>
                                    <option value="november">11월</option>
                                    <option value="december">12월</option>
                                    <option value="1quater">1분기</option>
                                    <option value="2quater">2분기</option>
                                    <option value="3quater">3분기</option>
                                    <option value="4quater">4분기</option>
                                    <option value="sangbangi">상반기</option>
                                    <option value="habangi">하반기</option>
                                </select>
                            </td>
                            <!--당월,전월 등-->
                            <td width="6%" class="">
                                <input type="text" name="fromDate" value=""
                                    class="form-control form-control-sm text-center dateType yyyymmdd">
                            </td>
                            <!--fromdate-->
                            <td width="1%" class="">~</td><!-- ~ -->
                            <td width="6%" class="">
                                <input type="text" name="toDate" value=""
                                    class="form-control form-control-sm text-center dateType yyyymmdd">
                            </td>
                            <!--todate-->
                            <td width="6%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="building">
                                </select>
                            </td>
                            <!--building-->
                            <td width="6%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="taxDiv">
                                    <option value="alltax">세액전체</option>
                                    <option value="taxYes">0원초과</option>
                                    <option value="taxNone">0원</option>
                                </select>
                            </td>
                            <!--부가세유무-->
                            <td width="6%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="payKind">
                                    <option value="payall">입금구분전체</option>
                                    <option value="계좌">계좌</option>
                                    <option value="현금">현금</option>
                                    <option value="카드">카드</option>
                                </select>
                            </td>
                            <!--계좌,현금,카드-->
                            <!-- <td width="6%" class="mobile">
              <select class="form-control form-control-sm selectCall" name="evidenceKind">
                <option value="evidenceAll">증빙전체</option>
                <option value="evidenceExist">있음</option>
                <option value="evidenceNone">없음</option>
              </select>
            </td>증빙유무 이거 왜 넣었니? ㅠㅠ 빼자-->
                            <td width="6%" class="">
                                <select class="form-control form-control-sm selectCall" name="etcCondi">
                                    <option value="customer">납부자명</option>
                                    <option value="contact">연락처</option>
                                    <!-- <option value="contractId">계약번호</option> -->
                                    <option value="gName">그룹명</option>
                                    <option value="rName">방번호</option>
                                    <option value="goodName">상품</option>
                                </select>
                            </td>
                            <!--기타조건-->
                            <td width="10%" class="">
                                <input type="text" name="cText" class="form-control form-control-sm text-center">
                            </td>
                            <!--text input-->
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section>

    <!-- 문자 및 세금계산서발행 섹션 -->
    <section class="container">
        <div class="row">
            <div class="col col-md-7">
                <div class="row ml-0">
                    <table>
                        <tr>
                            <td>
                                <select class="form-control form-control-sm" id="smsTitle" name="">
                                    <option value="상용구없음">상용구없음</option>
                                    <?php for ($i = 0; $i < count($rowsms); $i++) {
                                        echo "<option value='" . $rowsms[$i]['title'] . "'>" . $rowsms[$i]['title'] . "</option>";
                                    } ?>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-block btn-outline-primary" id="smsBtn" data-toggle="modal"
                                    data-target="#smsModal1"><i class="far fa-envelope"></i> 보내기</button>
                            </td>
                            <td class="mobile">
                                <a href="/svc/service/sms/smsSetting.php">
                                    <button class="btn btn-sm btn-block btn-dark" id="smsSettingBtn"><i
                                            class="fas fa-angle-double-right"></i> 상용구설정</button></a>
                            </td>
                            <td>
                                <a href="/svc/service/sms/sent.php">
                                    <button class="btn btn-sm btn-block btn-dark" id="smsSettingBtn"><i
                                            class="fas fa-angle-double-right"></i> 보낸문자목록</button></a>
                            </td>
                            <!-- <td><button class="btn btn-sm btn-block btn-danger" name="button1" data-toggle="tooltip" data-placement="top" title="작업중입니다^^;">납부취소</button></td> 이거 하려다가 안했음, 이유는 기타계약이 있어서 납부취소를 하면 안됌-->
                            <td class="mobile"><button type="button" class="btn btn-info btn-sm" id="excelbtn"><i
                                        class="far fa-file-excel"></i>엑셀양식</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col col-md-5 mobile">
                <div class="row justify-content-end">
                    <div class="col col-md-3 pl-0 pr-1">
                        <input type="text" name="taxDate" placeholder="날짜선택"
                            class="form-control form-control-sm dateType text-center">
                    </div>
                    <div class="col col-md-3 pl-0 pr-1">
                        <select class="form-control form-control-sm" name="taxSelect">
                            <option value="세금계산서">세금계산서</option>
                            <option value="현금영수증">현금영수증</option>
                        </select>
                    </div>
                    <div class="col col-md-2 pl-0 pr-1">
                        <button type="button" class="btn btn-warning btn-sm btn-block" id="btnTaxDateInput2">입력</button>
                    </div>
                    <div class="col col-md-4 pl-0">
                        <button type="button" class="btn btn-primary btn-sm btn-block"
                            id="btnTaxDateInput">영수세금계산서발행</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end mr-0 mobile">
            <label class="mb-0" style=""> 전체 : <span id="ptAmountTotalCount">0</span>건, 공 <span
                    id="pAmountTotalAmount">0</span>원, 세 <span id="pvAmountTotalAmount">0</span>원, 합 <span
                    id="ptAmountTotalAmount">0</span>원</label>
            <!--글자 기본&-->
        </div>
        <div class="row justify-content-end mr-0 mobile">
            <label class="mb-0" style="color:#007bff;"> 체크 : <span id="ptAmountSelectCount">0</span>건, 공 <span
                    id="pAmountSelectAmount">0</span>원, 세 <span id="pvAmountSelectAmount">0</span>원, 합 <span
                    id="ptAmountSelectAmount">0</span>원</label>
            <!--글자 파란색-->
        </div>
    </section>

    <!-- 표 섹션 -->
    <section class="container">
        <table class="table table-sm table-bordered table-hover text-center mt-2 table-sm" id="checkboxTestTbl"
            name="outsideTable">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class=""><input type="checkbox" id="allselect"></th>
                    <th scope="col" class="">순번</th>
                    <th scope="col" class="">납부일</th>
                    <th scope="col" class="mobile">공급가액</th>
                    <th scope="col" class="mobile">세액</th>
                    <th scope="col" class="">합계</th>
                    <th scope="col" class="mobile">구분</th>
                    <th scope="col" class="">납부자명</th>
                    <th scope="col" class="">연락처</th>
                    <th scope="col" class="">물건명</th>
                    <th scope="col" class="">계약(상품)</th>
                    <th scope="col" class="mobile">증빙</th>
                    <th scope="col" class=""><span class="badge badge-light">파일</span>
                        <span class="badge badge-dark">메모</span>
                    </th>
                </tr>
            </thead>
            <tbody id="allVals">

            </tbody>
        </table>
    </section>

    <!-- sql 섹션 -->
    <section id="allVals2" class="container">
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/customer/modal_customer.php";
    include "modal_pay2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/sms/modal_sms1.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/sms/modal_sms2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_amount2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_file.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_memo.php";
    ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_footer.php"; ?>


    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/popper.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/jquery.number.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
    <script src="/svc/inc/js/etc/newdate8.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/sms_noneparase3.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/sms_existparase10.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/checkboxtable.js?<?= date('YmdHis') ?>">
    </script>
    <script src="/svc/inc/js/etc/form.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/ce_pl_f2.js?<?= date('YmdHis') ?>"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/svc/inc/js/daumAddressAPI3.js?<?= date('YmdHis') ?>"></script>

    <script type="text/javascript">
    function taxInfo(bid, mun, ccid) {
        console.log('solmi');
        var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
        $("body").append(tmps);
        //alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );

        $("#ifm_pops_21").attr("src", "/svc/service/get/tax_invoice3.php?building_idx=" + bid + "&mun=" + mun + "&id=" +
            ccid + "&flag=finished");
        $('#ifm_pops_21').show();
        // $('.pops_wrap, .pops_21').show();

    }

    var lease_type = <?php echo json_encode($_SESSION['lease_type']); ?>;
    var cellphone = <?php echo json_encode($_SESSION['cellphone']); ?>;
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
    var roomArray = <?php echo json_encode($roomArray); ?>;
    var smsSettingArray = <?php echo json_encode($rowsms); ?>;
    var buildingText = <?php echo json_encode($_SESSION['user_name']); ?>;
    var popbillid = <?php echo json_encode($_SESSION['popbillid']); ?>;
    var companynumber =
        <?= json_encode($_SESSION['companynumber']) ?>;
    // console.log(buildingArray);
    // console.log(groupBuildingArray);
    // console.log(roomArray);
    // console.log(buildingText); //user_name, 회원명을 상호명으로 함.
    // console.log(popbillid);
    // console.log(companynumber);
    // console.log(companynumber.length);
    </script>


    <script src="/svc/inc/js/etc/building.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/customer.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/customer_edit.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_checksum_f.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_sms_array_f.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_taxarray_f.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/service/contract/j_contract_insidebuttons.js?<?= date('YmdHis') ?>">
    </script>
    <script src="/svc/inc/js/autosize.min.js"></script>


    <script type="text/javascript">
    var taxDiv = 'accept'; //입금예정리스트여서 청구라는 뜻의 charge 사용, 입금완료리스트에서는 영수라는 뜻의 accept 사용 예정

    function maketable() {
        var mtable = $.ajax({
            url: 'ajax_getFinishedCondi_value.php',
            method: 'post',
            data: $('form').serialize(),
            success: function(data) {
                data = JSON.parse(data);
                console.log(data);
                datacount = data.length;

                var returns = '';
                var totalpAmount = 0;
                var totalpvAmount = 0;
                var totalptAmount = 0;

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                if (datacount === 0) {
                    returns = "<tr><td colspan='11'>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요!</td></tr>";
                } else {
                    $.each(data, function(key, value) {
                        let filecount, memocount;
                        if (value.filecount === 0) {
                            filecount = '.';
                        } else {
                            filecount = value.filecount;
                        }

                        if (value.memocount === 0) {
                            memocount = '.';
                        } else {
                            memocount = value.memocount;
                        }

                        returns += '<tr>';
                        returns += '<td class=""><input type="checkbox" name="pid" value="' + value
                            .idpaySchedule2 +
                            '" class="tbodycheckbox"><input type="hidden" name="rid" value="' +
                            value.rid + '"></td>';
                        returns += '<td>' + datacount + '</td>';

                        returns += '<td class="">';

                        if (value.roomdiv === 'room') {
                            returns +=
                                '<p class="mb-0 modalAsk" data-toggle="modal" data-target="#pPay2">' +
                                value.executiveDate + '</p>';
                        } else {
                            returns += '<p class="mb-0">' + value.executiveDate + '</p>';
                        }

                        returns += '<input type="hidden" name="pStartDate" value="' + value
                            .pStartDate + '">';
                        returns += '<input type="hidden" name="pEndDate" value="' + value.pEndDate +
                            '">';
                        returns += '<input type="hidden" name="pMonthCount" value="' + value
                            .monthCount + '">';

                        if (value.roomdiv === 'room') {
                            returns += '<input type="hidden" name="startDate" value="' + value
                                .startDate + '">';
                            returns += '<input type="hidden" name="endDate" value="' + value
                                .endDate2 + '">';
                            returns += '<input type="hidden" name="monthCount" value="' + value
                                .count2 + '">';
                        } else {
                            returns += '<input type="hidden" name="startTime" value="' + value
                                .startDate + '">';
                            returns += '<input type="hidden" name="endTime" value="' + value
                                .endDate2 + '">';
                        }

                        returns += '</td>';

                        returns += '<td class="text-right pr-3 mobile">' + numberWithCommas(value
                            .pAmount) + '</td>';
                        returns += '<td class="text-right pr-3 mobile">' + numberWithCommas(value
                            .pvAmount) + '</td>';

                        if (value.roomdiv === 'room') {
                            returns += `<td class='text-right pr-3 green'>
                            <a class="contractAmount" data-toggle='modal' data-target=#modal_amount>${numberWithCommas(value.ptAmount)}</a>
                            </td>`;
                        } else if (value.roomdiv === 'good') {
                            returns +=
                                `<td class="text-right pr-3"><a class="green" href=/svc/service/contractetc/contractetc_edit.php?id=${value.rid} target=_blank>${numberWithCommas(value.ptAmount)}</a></td>`;
                        }

                        returns += '<td class="mobile">' + value.payKind + '</td>';

                        returns += '<td class=""><a href="/svc/service/customer/m_c_edit.php?id=' +
                            value.customer_id +
                            '" data-toggle="modal" data-target="#eachpop" class="cnameclass eachpop">' +
                            value.cnamemb + '</a>';

                        returns += '<input type="hidden" name="email" value="' + value.email + '">';
                        returns += '<input type="hidden" name="customer_id" value="' + value
                            .customer_id + '">';
                        returns += '<input type="hidden" name="cname" value="' + value.cname + '">';
                        returns += '<input type="hidden" name="name" value="' + value.name + '">';
                        returns += '<input type="hidden" name="bid" id="bid" value="' + value.bid +
                            '">';
                        returns += '<input type="hidden" name="mun" id="mun" value="' + value.mun +
                            '">';
                        returns += '<input type="hidden" name="ccid" id="ccid" value="' + value
                            .ccid + '">';
                        returns += '<input type="hidden" name="companynumber" value="' + value
                            .companynumber + '">';
                        returns += '<input type="hidden" name="companyname" value="' + value
                            .companyname2 + '">';
                        returns += '<input type="hidden" name="address" value="' + value.address +
                            '">';
                        returns += '<input type="hidden" name="div4" value="' + value.div4 + '">';
                        returns += '<input type="hidden" name="div5" value="' + value.div5 + '">';
                        returns += '</td>';

                        returns += '<td class=""><a href="tel:' + value.contact + '">' + value
                            .contact + '</td>';
                        returns += `<td class="">${value.buildingname}</td>`;

                        if (value.roomdiv === 'room') {
                            returns += '<td class="">' + '임대' + '(' + value.groupname + ',' +
                                value.roomname + ')' +
                                '<input type="hidden" name="roomdiv" value="' + value.roomdiv +
                                '"><input type="hidden" name="groupname" value="' + value
                                .groupname + '"><input type="hidden" name="roomname" value="' +
                                value.roomname + '"></td>';
                        } else if (value.roomdiv === 'good') {
                            returns += '<td class="">' + '기타' + '(' + value.groupname + ')' +
                                '<input type="hidden" name="roomdiv" value="' + value.roomdiv +
                                '"><input type="hidden" name="groupname" value="' + value
                                .groupname +
                                '"><input type="hidden" name="roomname" value=""></td>';
                        }
                        var mun = value.mun;
                        var bid = value.bid;
                        var ccid = value.ccid;
                        //
                        // console.log(typeof(mun));
                        // console.log(mun);

                        if (mun) {
                            if (value.taxSelect === '세금계산서') {
                                returns += '<td class="mobile"><a onclick="taxInfo(' + bid +
                                    ',\'' + mun + '\',\'' + ccid +
                                    '\');"><span class="badge badge-warning text-light" style="width: 1.5rem;">세</span><label class="green mb-0"><u>' +
                                    value.taxDate + '</u></label></a></td>';
                            } else if (value.taxSelect === '현금영수증') {
                                returns +=
                                    '<td class="mobile"><span class="badge badge-info text-light" style="width: 1.5rem;">현</span>' +
                                    value.taxDate + '</td>';
                            } else {
                                returns += '<td class="mobile"></td>';
                            }
                        } else {
                            if (value.taxSelect === '세금계산서') {
                                returns +=
                                    '<td class="mobile"><span class="badge badge-warning text-light" style="width: 1.5rem;">세</span>' +
                                    value.taxDate + '</td>';
                            } else if (value.taxSelect === '현금영수증') {
                                returns +=
                                    '<td class="mobile"><span class="badge badge-info text-light" style="width: 1.5rem;">현</span>' +
                                    value.taxDate + '</td>';
                            } else {
                                returns += '<td class="mobile"></td>';
                            }
                        }

                        returns += `<td class="mobile" name=filememo>
                        <span class="badge badge-light modalfile" data-toggle="modal" data-target="#modal_file">${filecount}</span>
                        <span class="badge badge-dark modalmemo" data-toggle="modal" data-target="#modal_memo">${memocount}</span>
                    </td>`;



                        returns += '</tr>';

                        datacount -= 1;
                        var pamount = value.pAmount.replace(/,/gi, '');
                        var pvamount = value.pvAmount.replace(/,/gi, '');
                        var ptamount = value.ptAmount.replace(/,/gi, '');
                        totalpAmount += Number(pamount);
                        totalpvAmount += Number(pvamount);
                        totalptAmount += Number(ptamount);

                    }) //$.each closing}
                } //if else closing}
                $('#allVals').html(returns);
                $('#ptAmountTotalCount').text(data.length);
                $('#pAmountTotalAmount').text(totalpAmount);
                $('#pAmountTotalAmount').number(true);
                $('#pvAmountTotalAmount').text(totalpvAmount);
                $('#pvAmountTotalAmount').number(true);
                $('#ptAmountTotalAmount').text(totalptAmount);
                $('#ptAmountTotalAmount').number(true);
            } //ajax success closing}

        }) //ajax closing }

        return mtable;

    } //function maketable closing}


    $(document).ready(function() {
        var periodDiv = $('select[name=periodDiv]').val();
        dateinput2(periodDiv);

        maketable();

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('.dateType').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            currentText: '오늘',
            closeText: '닫기'
        })

        $('.yyyymmdd').keydown(function(event) {
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

            return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 &&
                key <= 105));
            // Key 8번 백스페이스, Key 9번 탭, Key 46번 Delete 부터 0 ~ 9까지, Key 96 ~ 105까지 넘버패트
            // 한마디로 JQuery 0 ~~~ 9 숫자 백스페이스, 탭, Delete 키 넘버패드외에는 입력못함
        })

        $(document).on('click', '.modalAsk', function() { //입금일 클릭하는거(모달클릭)

            var currow2 = $(this).closest('tr');
            var payid = currow2.find('td:eq(0)').children('input[name=pid]').val();
            // console.log(payNumber);
            var rid = currow2.find('td:eq(0)').children('input[name=rid]').val();

            var startDate = $(this).siblings('input[name=startDate]').val();
            var endDate = $(this).siblings('input[name=endDate]').val();
            var monthCount = $(this).siblings('input[name=monthCount]').val();
            var pStartDate = $(this).siblings('input[name=pStartDate]').val();
            var pEndDate = $(this).siblings('input[name=pEndDate]').val();
            var pMonthCount = $(this).siblings('input[name=pMonthCount]').val();

            // console.log(payid, rid, startDate);

            $('#modalrid').val(rid);
            $('#modalpid').val(payid);
            $('input[name=m2startDate]').val(startDate);
            $('input[name=m2endDate]').val(endDate);
            $('input[name=m2duration]').val(monthCount);
            $('input[name=m2pStartDate]').val(pStartDate);
            $('input[name=m2pEndDate]').val(pEndDate);
            $('input[name=m2pDuration]').val(pMonthCount);

        })


    }) //---------document.ready function end & 각종 조회 펑션 시작--------------//

    $('select[name=dateDiv]').on('change', function() {
        maketable();
    })

    $('select[name=periodDiv]').on('change', function() {
        var periodDiv = $('select[name=periodDiv]').val();
        // console.log(periodDiv);
        dateinput2(periodDiv);
        maketable();
    })

    $('input[name=fromDate]').on('change', function() {
        maketable();
    })

    $('input[name=toDate]').on('change', function() {
        maketable();
    })

    $('select[name=building]').on('change', function() {
        maketable();
    })

    $('select[name=taxDiv]').on('change', function() {
        maketable();
    })

    $('select[name=payKind]').on('change', function() {
        maketable();
    })

    $('select[name=etcCondi]').on('change', function() {
        maketable();
    })

    $('input[name=cText]').on('keyup', function() {
        maketable();
    })

    $('#excelbtn').on('click', function() {
        var a = $('form').serialize();

        goCategoryPage(a);

        function goCategoryPage(a) {
            var frm = formCreate('exceldown', 'post', 'p_exceldown.php', '');
            frm = formInput(frm, 'formArray', a);
            formSubmit(frm);
        }
    })

    $(document).on('click', '.eachpop', function() {
        var cid = $(this).siblings('input[name=customer_id]').val();
        // console.log(cid);
        m_customer(cid);
    })

    $(document).on('click', '.contractAmount', function() {

        var ccid = $(this).parent().siblings('td:eq(0)').find('input[name=rid]').val();
        var cccustomer = $(this).parent().parent().find('td:eq(7)').find('input[name=name]').val();
        var ccroom = $(this).parent().parent().find('td:eq(9)').find('input[name=roomname]').val();
        let url = '../../ajax/ajax_amountlist.php';

        console.log(cccustomer, ccroom);

        $('span.mtitle').text('임대료 내역');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        amountlist(ccid, url);

        $('.contractEditAll').on('click', function() {
            var cid = $(this).siblings('.contractNumber').text();
            //   console.log(cid);
            window.open('about:blank').location.href = '/svc/service/contract/contractEdit.php?id=' +
                cid;
        })
    })

    $(document).on('click', '.modalfile', function() {
        var ccid = $(this).parent().siblings('td:eq(0)').find('input[name=rid]').val();
        var cccustomer = $(this).parent().parent().find('td:eq(7)').find('input[name=name]').val();
        var ccroom = $(this).parent().parent().find('td:eq(9)').find('input[name=roomname]').val();
        ccid = Number(ccid);

        $('span.mtitle').text('첨부파일');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        filelist(ccid);
        //   console.log('file load');
    })

    $(document).on('click', '.modalmemo', function() {
        var ccid = $(this).parent().siblings('td:eq(0)').find('input[name=rid]').val();
        var cccustomer = $(this).parent().parent().find('td:eq(7)').find('input[name=name]').val();
        var ccroom = $(this).parent().parent().find('td:eq(9)').find('input[name=roomname]').val();
        ccid = Number(ccid);

        // console.log('memo load');

        $('span.mtitle').text('메모');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        memolist(ccid);
    })

    $('#eachpop').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })

    $('#modal_file').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })

    $('#modal_memo').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })
    </script>

    <script type="text/javascript" src="js_sms_tax.js?<?= date('YmdHis') ?>">
    </script>

    </body>

</html>