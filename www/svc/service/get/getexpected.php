<?php
//이거가 서버에 있는 파일. 관리 매우 중요함...
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>납부예정</title>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header1_meta.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/main/condition.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/contract/building.php";
    // header("Content-Type: text/html; charset=UTF-8");
    $sql_sms = "select
          screen, title, description
        from sms
        where
          user_id={$_SESSION['id']} and
          screen='납부예정화면'";
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
            <h2 class="">납부예정 목록이에요.(#401)</h2>
            <p class="warningg">
                <i class="fas fa-exclamation-circle"></i> 문자메시지 발송후 반드시 보낸문자목록에서 확인하세요. 가끔 발송이 안되는 경우가 있어요(상대방 전화해지, 또는
                해외 출국 등 사유)<br>
                <i class="fas fa-exclamation-circle"></i> 전자세금계산서를 발행할 수 있습니다. <a
                    href="https://blog.naver.com/leaseman_ad/221970487609" target="_blank">발행방법 바로가기</a>
            </p>
        </div>
    </section>

    <!-- 조회조건 섹션 -->
    <section class="container">
        <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
            <form>
                <div class="row justify-content-md-center">
                    <table>
                        <tr>
                            <td width="6%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="dateDiv">
                                    <option value="pExpectedDate">예정일자</option>
                                </select>
                                <!--codi1-->
                            </td>
                            <td width="6%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="periodDiv">
                                    <option value="allDate">--</option>
                                    <option value="untilNowMonth" selected>당월까지</option>
                                    <option value="nowMonth">당월</option>
                                    <option value="pastMonth">전월</option>
                                    <option value="1pastMonth">1개월전</option>
                                    <option value="nextMonth">익월</option>
                                    <option value="nowYear">당년</option>
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
                                <!--시간구분-->
                            </td>
                            <td width="8%" class="mobile">
                                <input type="text" name="fromDate" value=""
                                    class="form-control form-control-sm text-center dateType yyyymmdd">
                                <!--codi3-->
                            </td>
                            <td width="1%" class="mobile">~</td>
                            <td width="8%" class="mobile">
                                <input type="text" name="toDate" value=""
                                    class="form-control form-control-sm text-center dateType yyyymmdd">
                                <!--codi4-->
                            </td>
                            <td width="7%" class="">
                                <select class="form-control form-control-sm selectCall" name="building">
                                </select>
                                <!--건물-->
                            </td>
                            <td width="7%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="group">
                                    <option value="groupAll">그룹전체</option>
                                </select>
                                <!--그룹-->
                            </td>
                            <td width="7%" class="">
                                <select class="form-control form-control-sm selectCall" name="etcCondi">
                                    <option value="customer">성명/사업자명</option>
                                    <option value="contact">연락처</option>
                                    <option value="contractId">계약번호</option>
                                    <option value="roomId">관리호수</option>
                                </select>
                                <!--codi8-->
                            </td>
                            <td width="12%" class="">
                                <input type="text" name="cText" value=""
                                    class="form-control form-control-sm text-center">
                                <!--codi9-->
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
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
                            <td>
                                <a href="/svc/service/sms/smsSetting.php">
                                    <button class="btn btn-sm btn-block btn-dark mobile" id="smsSettingBtn"><i
                                            class="fas fa-angle-double-right"></i> 상용구설정</button></a>
                            </td>
                            <td>
                                <a href="/svc/service/sms/sent.php">
                                    <button class="btn btn-sm btn-block btn-dark" id="smsSettingBtn"><i
                                            class="fas fa-angle-double-right"></i> 보낸문자목록</button></a>
                            </td>
                            <td><button class="btn btn-sm btn-block btn-danger mobile" id="button1">입금처리</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col col-md-5 mobile">
                <div class="row justify-content-end">
                    <div class="col col-md-4 pl-0">
                        <button type="button" class="btn btn-primary btn-sm btn-block" id="btnTaxDateInput">청구세금계산서
                            발행</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end mr-0 mobile">
            <label class="mb-0" style="" id="aa"></label>
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
    <section class="row justify-content-center">
        <div class="col-11">
            <div class="mainTable">
                <table class="table table-sm table-bordered table-hover text-center mt-2 table-sm" id="checkboxTestTbl"
                    name="outsideTable">
                    <thead>
                        <tr class="table-secondary">
                            <th width="2%" class="fixedHeader"><input type="checkbox" id="allselect"></th>
                            <th width="4%" class="fixedHeader">순번</th>
                            <th width="5%" class="mobile fixedHeader">물건명<br>그룹명</th>
                            <th width="5%" class="fixedHeader">관리호수</th>
                            <th width="10%" class="fixedHeader">입주자</th>
                            <th width="10%" class="fixedHeader">연락처</th>
                            <th width="4%" class="mobile fixedHeader">개월</th>
                            <th width="10%" class="mobile fixedHeader">시작일<br>종료일</th>
                            <th width="10%" class="fixedHeader">예정일<br>입금일</th>
                            <th width="10%" class="mobile fixedHeader">공급가액<br>세액</th>
                            <th width="8%" class="fixedHeader">
                                합계<br>
                                <span class="badge badge-light">파일</span>
                                <span class="badge badge-dark">메모</span>
                            </th>
                            <th width="5%" class="mobile fixedHeader">구분</th>
                            <th width="6%" class="mobile fixedHeader">연체일수<br>이자</th>
                            <th width="8%" class="mobile fixedHeader">증빙</th>
                        </tr>
                    </thead>
                    <tbody id="allVals">

                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 페이지 -->
    <section class="container mt-2" id="page">
    </section>

    <!-- sql 섹션 -->
    <!-- <section class="container mt-2" id="sql"> -->
    <!-- </section> -->


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/customer/modal_customer.php";
    include "modal_pay.php";
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
    <script src="/svc/inc/js/etc/checkboxtable.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/modal_table.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/form.js?<?= date('YmdHis') ?>"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/svc/inc/js/daumAddressAPI3.js?<?= date('YmdHis') ?>"></script>

    <script type="text/javascript">
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
    console.log(buildingArray);
    console.log(groupBuildingArray);
    console.log(roomArray);
    </script>

    <script src="/svc/inc/js/etc/building.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_checksum.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_sms_array.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_taxarray.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/ce_pl_f2.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/customer.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/customer_edit.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/memo.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/filedelete.js?<?= date('YmdHis') ?>"></script>

    <script src="/svc/inc/js/autosize.min.js"></script>

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    var taxDiv = 'charge'; //입금예정리스트여서 청구라는 뜻의 charge 사용, 입금완료리스트에서는 영수라는 뜻의 accept 사용 예정


    function taxInfo2(bid, mun, ccid) {
        var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
        $("body").append(tmps);
        //alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );

        $("#ifm_pops_21").attr("src", "/svc/service/get/tax_invoice2.php?building_idx=" + bid + "&mun=" + mun + "&id=" +
            ccid + "&flag=expected");
        $('#ifm_pops_21').show();
        $('.pops_wrap, .pops_21').show();

    }

    function sql(x, y) {
        var form = $('form').serialize();
        var sql = $.ajax({
            url: 'ajax_getexpectedCondi_sql2.php',
            method: 'post',
            data: {
                'form': form,
                'pagerow': x,
                'getPage': y
            },
            success: function(data) {
                $('#sql').html(data);
            }
        })
        return sql;
    }

    function maketable(x, y) {
        var form = $('form').serialize();
        var mtable = $.ajax({
            url: 'ajax_getexpectedCondi_value.php',
            method: 'post',
            data: {
                'form': form,
                'pagerow': x,
                'getPage': y
            },
            success: function(data) {
                data = JSON.parse(data);
                console.log(data);
                datacount = data.length;

                var returns = '';
                var totalpAmount = 0;
                var totalpvAmount = 0;
                var totalptAmount = 0;

                if (datacount === 0) {
                    returns = "<tr><td colspan='14'>아직 임대료를 청구한 데이터가 없네요. 임대계약에서 청구하기를 실행하세요!</td></tr>";
                } else {
                    $.each(data, function(key, value) {
                        countall = value.count;
                        var ordered = Number(value.num) - ((y - 1) * x);
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
                        returns += '<td><input type="checkbox" name="psid" value="' + value
                            .idpaySchedule2 + '" class="tbodycheckbox">';
                        returns += '<input type="hidden" name="rid" value="' + value.rid +
                            '"></td>';
                        returns += '<td>' + ordered + '</td>';
                        returns +=
                            `<td class="mobile"><span name=bname>${(value.bname).substring(0,3)}</span><br><span name=gname>${value.gname}</span></td>`;
                        returns += '<td>' + value.roomname + '</td>';
                        returns += '<td><a href="/svc/service/customer/m_c_edit.php?id=' + value
                            .cid +
                            '" data-toggle="modal" data-target="#eachpop" class="eachpop cnameclass">' +
                            value.cnamemb + '</a>';
                        returns += '<input type="hidden" name="cname" value="' + value.cname + '">';
                        returns += '<input type="hidden" name="contact" value="' + value.contact +
                            '">';
                        returns += '<input type="hidden" name="email" value="' + value.email + '">';
                        returns += '<input type="hidden" name="customer_id" value="' + value.cid +
                            '">';
                        returns += '<input type="hidden" name="name" value="' + value.ccname + '">';
                        returns += '<input type="hidden" name="companynumber" value="' + value
                            .companynumber + '">';
                        returns += '<input type="hidden" name="companyname" value="' + value
                            .ccompanyname + '">';
                        returns += '<input type="hidden" name="address" value="' + value.address +
                            '">';
                        returns += '<input type="hidden" name="div4" value="' + value.div4 + '">';
                        returns += '<input type="hidden" name="div5" value="' + value.div5 + '">';
                        returns += '<input type="hidden" name="bid" id="bid" value="' + value.bid +
                            '">';
                        returns += '<input type="hidden" name="mun" id="mun" value="' + value.mun +
                            '">';
                        returns += '<input type="hidden" name="ccid" id="ccid" value="' + value
                            .ccid + '">';
                        returns += '</td>';
                        returns += '<td><a href="tel:' + value.contact + '">' + value.contact +
                            '</a></td>';
                        returns += '<td class="mobile">' + value.monthCount + '</td>';
                        returns += '<td class="mobile"><label class="mb-0">' + value.pStartDate +
                            '</label><br>';
                        returns += '<label class="mb-0">' + value.pEndDate + '</label></td>';
                        returns +=
                            '<td><p class="modalAsk mb-0" data-toggle="modal" data-target="#pPay2">' +
                            value.pExpectedDate + '</p>';
                        returns +=
                            '<input type="text" name="executiveDate" class="form-control form-control-sm grey text-center" value="' +
                            value.pExpectedDate + '">';
                        returns += '<td class="text-right pr-3 mobile"><label class="mb-0">' +
                            numberWithCommas(value.pAmount) + '</label><br>';
                        returns += '<label class="mb-0">' + numberWithCommas(value.pvAmount) +
                            '</label></td>';
                        // returns +=
                        //     '<td><a href="/svc/service/contract/contractEdit.php?page=schedule&id=' +
                        //     value.rid +
                        //     '" name="ptamount" data-toggle="tooltip" data-placement="top" title="계약상세보기" class="green amountNumber">' +
                        //     numberWithCommas(value.ptAmount) + '</a></td>';
                        returns +=
                            `<td>
                            <span class="green contractAmount" data-toggle='modal' data-target=#modal_amount>${numberWithCommas(value.ptAmount)}</span>
                            <br>
                            <span class="badge badge-light modalfile" data-toggle="modal" data-target="#modal_file">${filecount}</span>
                        <span class="badge badge-dark modalmemo" data-toggle="modal" data-target="#modal_memo">${memocount}</span>
                            <input type=hidden name=contractId value=${value.rid}><input type=hidden name=mAmount value=${value.mAmount}><input type=hidden name=mvAmount value=${value.mvAmount}><input type=hidden name=payOrder value=${value.payOrder}>
                            </td>`;
                        returns += '<td class="mobile">';
                        if (value.payKind === '계좌') {
                            returns +=
                                '<select class="form-control form-control-sm" name="payKind"><option value="계좌" selected>계좌</option><option value="현금">현금</option><option value="카드">카드</option></select>';
                        } else if (value.payKind === '현금') {
                            returns +=
                                '<select class="form-control form-control-sm" name="payKind"><option value="계좌">계좌</option><option value="현금" selected>현금</option><option value="카드">카드</option></select>';
                        } else if (value.payKind === '카드') {
                            returns +=
                                '<select class="form-control form-control-sm" name="payKind"><option value="계좌">계좌</option><option value="현금">현금</option><option value="카드" selected>카드</option></select>';
                        }
                        returns += '</td>'; //입금구분
                        returns += '<td class="mobile"><label class="mb-0">' + value.delaycount +
                            '</label><br>';
                        returns += '<label class="mb-0">' + value.delayinterest +
                            '</label></td>'; //연체일수,연체이자
                        var mun = value.mun;
                        var bid = value.bid;
                        var ccid = value.ccid;

                        if (mun) {
                            if (value.taxSelect === '세금계산서') {
                                returns += '<td class="mobile"><a onclick="taxInfo2(' + bid +
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
                        // if(value.taxSelect==='세금계산서'){
                        //   returns += '<td class="mobile"><a onclick="taxInfo2('+bid+',\''+mun+'\',\''+ccid+'\');"><span class="badge badge-warning text-light" style="width: 1.5rem;">세</span>'+value.taxDate+'</a></td>';
                        // } else if(value.taxSelect==='현금영수증'){
                        //   returns += '<td class="mobile"><span class="badge badge-info text-light" style="width: 1.5rem;">현</span>'+value.taxDate+'</td>';
                        // } else {
                        //   returns += '<td class="mobile"></td>';
                        // }

                        returns += '</tr>';

                        function numberWithCommas(x) {
                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

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

                var totalpage = Math.ceil(Number(countall) / Number(x));

                var totalpageArray = [];

                for (var i = 1; i <= totalpage; i++) {
                    totalpageArray.push(i);
                }

                var paging =
                    '<nav aria-label="..."><ul class="pagination pagination-sm justify-content-center">';

                for (var i = 1; i <= totalpageArray.length; i++) {
                    paging += '<li class="page-item"><a class="page-link">' + i + '</a></li>';
                }

                paging += '</ul></nav>';

                $('#page').html(paging);
            } //ajax success closing}

        }) //ajax closing }

        return mtable;

    } //function maketable closing}

    function makesum(x, y) {

        var form = $('form').serialize();

        var sumvalue = $.ajax({
            url: 'ajax_getexpected_sum.php',
            method: 'post',
            data: {
                'form': form,
                'pagerow': x,
                'getPage': y
            },
            success: function(data) {
                $('#aa').html(data);
            }
        })

        return sumvalue;
    }


    $(document).ready(function() {

        // $(document).on('blur', '.cnameclass', function(){
        //   $(this).tooltip({
        //     sanitizeFn: function (content) {
        //     return DOMPurify.sanitize(content)
        //     }
        //   });
        // })
        //
        // $(document).on('blur', 'a[name=ptamount]', function(){
        //   $(this).tooltip('show');
        // })

        // $('#button1').tooltip('show');
        // $('#button2').tooltip('show');

        // $('a[name=cname]').tooltip('show');
        // $('a[name=ptamount]').tooltip('show');

        var periodDiv = $('select[name=periodDiv]').val();
        dateinput2(periodDiv);

        var pagerow = 50;
        var getPage = 1;

        maketable(pagerow, getPage);
        sql(pagerow, getPage);
        makesum(pagerow, getPage);

        $('.dateType').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            currentText: '오늘',
            closeText: '닫기'
        })

        $(".numberComma").number(true);

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

        $('#href_smsSetting').on('click', function() {
            var moveCheck = confirm('문자상용구설정 화면으로 이동합니다. 이동하시겠습니까?');
            if (moveCheck) {
                location.href = '/svc/service/sms/smsSetting.php';
            }
        })

        $(document).on('click', '.modalAsk', function() { //청구번호클릭하는거(모달클릭)

            var currow2 = $(this).closest('tr');
            var payid = currow2.find('td:eq(0)').children('input[name=psid]').val();
            // console.log(payNumber);
            var rid = currow2.find('td:eq(0)').children('input[name=rid]').val();

            var payamount = currow2.find('td:eq(10)').children('.contractAmount').text();
            var paykind = currow2.find('td:eq(11)').children().val();
            var pExpectedDate = $(this).text();

            // console.log(payid, payamount, paykind, pExpectedDate);

            $('.payid').html(payid);
            $('input[name=modalpaydate]').val(pExpectedDate);
            $('input[name=modalexecutivedate]').val(pExpectedDate);
            $('input[name=modalpayamount]').val(payamount);
            $('input[name=modalexecutiveamount]').val(payamount);

            if (paykind === '계좌') {
                $('option[name=kind1]').attr('selected', true);
            } else if (paykind === '현금') {
                $('option[name=kind2]').attr('selected', true);
            } else if (paykind === '카드') {
                $('option[name=kind3]').attr('selected', true);
            }


            $('.getExecute').on('click', function() { //납부완료버튼(모달안버튼) 클릭

                var aa1 = 'payScheduleInput';
                var bb1 = 'p_getPayScheduleGetAmountInput.php';


                var ppayKind = $('#payKind').val(); //납부구분

                var pgetDate = $('input[name=modalexecutivedate]').val(); //납부일

                var pgetAmount = $('input[name=modalexecutiveamount]').val(); //납부액

                var pExpectedAmount = $('input[name=modalpayamount]').val(); //예정금액

                // console.log(pExpectedAmount);

                if (pgetAmount != pExpectedAmount) {
                    alert('납부액과 예정금액은 같아야 합니다.');
                    return false;
                }

                goCategoryPage(aa1, bb1, payid, ppayKind, pgetDate, pgetAmount, rid);

                function goCategoryPage(a, b, c, d, e, f, g) {
                    var frm = formCreate(a, 'post', b, '');
                    frm = formInput(frm, 'realContract_id', g);
                    frm = formInput(frm, 'payid', c);
                    frm = formInput(frm, 'paykind', d);
                    frm = formInput(frm, 'pgetdate', e);
                    frm = formInput(frm, 'pgetAmount', f);
                    formSubmit(frm);
                }
            })


            // $('.getExecuteBack').on('click', function(){ //청구취소(삭제)버튼(모달안버튼) 클릭
            //   var aa1 = 'payScheduleDrop';
            //   var bb1 = '/svc/service/contract/p_payScheduleDrop.php';
            //
            //   // console.log(pid, contractId);
            //
            //   goCategoryPage(aa1, bb1, rid, payid);
            //
            //   function goCategoryPage(a, b, c, d){
            //     var frm = formCreate(a, 'post', b,'');
            //     frm = formInput(frm, 'realContract_id', c);
            //     frm = formInput(frm, 'payid', d);
            //     formSubmit(frm);
            //   }
            //
            // })//납부예정화면에서는 청구취소는 일단 없애자, 햇깔리니깐

        })

        $(document).on('click', '.page-link', function() {
            // $(this).parent('li').attr('class','active');
            var pagerow = 50;
            var getPage = $(this).text();
            // console.log(getPage);
            maketable(pagerow, getPage);
            makesum(pagerow, getPage);
            sql(pagerow, getPage);
        })

    }) //---------document.ready function end & 각종 조회 펑션 시작--------------//
    $('select[name=dateDiv]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=periodDiv]').on('change', function() {
        var periodDiv = $('select[name=periodDiv]').val();
        // console.log(periodDiv);
        dateinput2(periodDiv);
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('input[name=fromDate]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('input[name=toDate]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=building]').on('change', function() {
        var buildingkey = $('select[name=building]').val();
        // console.log(buildingkey);

        //문자발송에 필요한 번호
        var sendphonenumber = buildingArray[buildingkey][3] + buildingArray[buildingkey][4] + buildingArray[
            buildingkey][5];


        $('input[name=sendphonenumber]').val(sendphonenumber);

        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=group]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=etcCondi]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);

        // $.ajax({
        //     url: 'ajax_getexpectedCondi_sql2.php',
        //     method: 'post',
        //     data: $('form').serialize(),
        //     success: function(data){
        //       $('#allVals2').html(data);
        //     }
        // })
    })

    $('input[name=cText]').on('keyup', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        makesum(pagerow, getPage);
        sql(pagerow, getPage);

        // $.ajax({
        //     url: 'ajax_getexpectedCondi_sql2.php',
        //     method: 'post',
        //     data: $('form').serialize(),
        //     success: function(data){
        //       $('#allVals2').html(data);
        //     }
        // })
    })

    //==================입금처리 시$작

    var psArray = [];

    $('#allselect').click(function() {

        let table = $('#checkboxTestTbl');

        var allCnt = $(".tbodycheckbox").length;
        if ($("#allselect").is(":checked")) {
            for (var i = 1; i <= allCnt; i++) {
                var psArrayEle = [];
                var colOrder = Number(table.find("tr:eq(" + i + ")").find("td:eq(1)").text());;
                var psId = Number(table.find("tr:eq(" + i + ")").find("td:eq(0)").children('input[name=psid]')
                    .val());
                var executiveDate = table.find("tr:eq(" + i + ")").find("td:eq(8)").children(
                    'input[name=executiveDate]').val();
                var executiveAmount = table.find("tr:eq(" + i + ")").find("td:eq(10)").children(
                    '.contractAmount').text();
                var payKind = table.find("tr:eq(" + i + ")").find("td:eq(11)").children('select').val();
                var rid = table.find("tr:eq(" + i + ")").find("td:eq(0)").children('input[name=rid]').val();

                psArrayEle.push(colOrder, psId, executiveDate, executiveAmount, payKind, rid);
                psArray.push(psArrayEle);
            }
        } else {
            psArray = [];
        }
        console.log(psArray);
    })

    $(document).on('click', '.tbodycheckbox', function() {
        var psArrayEle = [];

        if ($(this).is(':checked')) {
            var currow = $(this).closest('tr');
            var colOrder = Number(currow.find('td:eq(1)').text());
            var psId = Number(currow.find("td:eq(0)").children('input[name=psid]').val());
            var executiveDate = currow.find("td:eq(8)").children('input[name=executiveDate]').val();
            var executiveAmount = currow.find("td:eq(10)").children('a').text();
            var payKind = currow.find("td:eq(11)").children('select').val();
            var rid = currow.find("td:eq(0)").children('input[name=rid]').val();

            psArrayEle.push(colOrder, psId, executiveDate, executiveAmount, payKind, rid);
            psArray.push(psArrayEle);
        } else {
            var currow = $(this).closest('tr');
            var colOrder = Number(currow.find('td:eq(1)').text());

            for (var i = 0; i < psArray.length; i++) {
                if (psArray[i][0] === colOrder) {
                    // console.log(smsReadyArray[i][0]['순번'])
                    var index = i;
                    break;
                }
            }
            // console.log(index);
            psArray.splice(index, 1);
        }
        // console.log(psArray);
    })

    $('#button1').on('click', function() {
        console.log(psArray);
        if (psArray.length === 0) {
            alert('입금처리 할 것을 선택해야 합니다.');
            return false;
        }

        for (var i = 0; i < psArray.length; i++) {
            if (!psArray[i][2]) {
                alert('입금일 날짜가 입력되어야 합니다.');
                return false;
            }
        }

        psArray = JSON.stringify(psArray);
        goCategoryPage(psArray);

        function goCategoryPage(a) {
            var frm = formCreate('p_payScheduleGetAmountInputFor', 'post',
                '../contract/p_payScheduleGetAmountInputFor4.php', '');
            frm = formInput(frm, 'psArray', a);
            formSubmit(frm);
        }
    })

    $(document).on('click', '.eachpop', function() {
        var cid = $(this).siblings('input[name=customer_id]').val();
        // console.log(cid);
        m_customer(cid);
    })

    $(document).on('click', '.contractAmount', function() {

        var ccid = $(this).siblings('input[name=contractId]').val();
        var cccustomer = $(this).parent().siblings('td:eq(4)').find('input[name=cname]').val();
        var ccroom = $(this).parent().siblings('td:eq(3)').text();
        let url = '../../ajax/ajax_amountlist.php';

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
        var ccid = $(this).siblings('input[name=contractId]').val();
        var cccustomer = $(this).parent().siblings('td:eq(4)').find('input[name=cname]').val();
        var ccroom = $(this).parent().siblings('td:eq(3)').text();
        ccid = Number(ccid);

        $('span.mtitle').text('첨부파일');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        filelist(ccid);
        //   console.log('file load');
    })

    $(document).on('click', '.modalmemo', function() {
        var ccid = $(this).siblings('input[name=contractId]').val();
        var cccustomer = $(this).parent().siblings('td:eq(4)').find('input[name=cname]').val();
        var ccroom = $(this).parent().siblings('td:eq(3)').text();
        ccid = Number(ccid);

        // console.log('memo load');

        $('span.mtitle').text('메모');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        memolist(ccid);
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

    $('#eachpop').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })
    </script>

    <script type="text/javascript" src="js_sms_tax.js?<?= date('YmdHis') ?>"></script>

    </body>

</html>