<?php
//21.8.24 - 도움말아이콘 넣고 조회버튼 추가했음
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>임대계약목록</title>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header1_meta.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/main/condition.php";
    include "building.php";

    $sql_sms = "select
          screen, title, description
        from sms
        where
          user_id={$_SESSION['id']} and
          screen='임대계약화면'";
    // echo $sql_sms;

    $result_sms = mysqli_query($conn, $sql_sms);
    $rowsms = array();
    while ($row_sms = mysqli_fetch_array($result_sms)) {
        $rowsms[] = $row_sms;
    }

    // print_r($_SESSION);
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

    .container .condition {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }

    .itemdate {
        flex-basis: 10%;
    }
    </style>

    <!-- 제목 -->
    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">계약목록이에요.(#201)<img src="/svc/inc/img/icon/question.png" data-toggle="modal"
                    data-target="#modal_quest"></h3>
        </div>
    </section>

    <!-- 조회조건 -->
    <form action="" class="">
        <section class="container">
            <div class="container p-3 mb-2 bg-light text-dark border border-info rounded condition">
                <div class="item item1">
                    <select class="form-control form-control-sm selectCall" name="dateDiv">
                        <option value="startDate">시작일자</option>
                        <option value="endDate">종료일자</option>
                        <option value="contractDate">계약일자</option>
                        <option value="registerDate">등록일자</option>
                    </select>
                </div>
                <div class="item item2">
                    <select class="form-control form-control-sm selectCall" name="periodDiv">
                        <option value="allDate">--</option>
                        <option value="nowMonth">당월</option>
                        <option value="pastMonth">전월</option>
                        <option value="nextMonth">익월</option>
                        <option value="1pastMonth">1개월전</option>
                        <option value="nownextMonth">당월익월</option>
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
                </div>
                <div class="item itemdate">
                    <input type="text" name="fromDate" value=""
                        class="form-control form-control-sm text-center dateType yyyymmdd">
                </div>
                <div class="item item4">
                    ~
                </div>
                <div class="item itemdate">
                    <input type="text" name="toDate" value=""
                        class="form-control form-control-sm text-center dateType yyyymmdd">
                </div>
                <div class="item item6">
                    <select class="form-control form-control-sm selectCall" name="progress">
                        <option value="pAll">전체</option>
                        <option value="pIng" selected>현재</option>
                        <option value="pEnd">종료</option>
                        <option value="pWaiting">대기</option>
                        <option value="middleEnd">중간종료</option>
                        <option value="clear">clear</option>
                    </select>
                </div>
                <div class="item item7">
                    <select class="form-control form-control-sm selectCall" name="building">
                    </select>
                </div>
                <div class="item item8">
                    <select class="form-control form-control-sm selectCall" name="group">
                        <option value="groupAll">그룹전체</option>
                    </select>
                </div>
                <div class="item item9">
                    <select class="form-control form-control-sm selectCall" name="etcCondi">
                        <option value="customer">성명/사업자명</option>
                        <option value="contact">연락처</option>
                        <option value="contractId">계약번호</option>
                        <option value="roomId">관리호수</option>
                    </select>
                </div>
                <div class="item item10">
                    <input type="text" name="cText" value="" class="form-control form-control-sm text-center">
                </div>
                <div class="item item11">
                    <a role="button" class="btn btn-warning btn-sm" id="loading" name="loading">조회
                    </a>
                </div>
            </div>
        </section>
    </form>


    <!-- 문자 및 세금계산서발행 섹션 -->
    <section class="container mb-2">
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
                                    data-target="#smsModal1"><i class="far fa-envelope"></i> 보내기
                                </button>
                            </td>
                            <td>
                                <a href="/svc/service/sms/smsSetting.php">
                                    <button class="btn btn-sm btn-block btn-dark mobile" id="smsSettingBtn"><i
                                            class="fas fa-angle-double-right"></i> 상용구설정
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="/svc/service/sms/sent.php">
                                    <button class="btn btn-sm btn-block btn-dark" id="smsSettingBtn"><i
                                            class="fas fa-angle-double-right"></i> 보낸문자목록
                                    </button>
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" id="excelbtn"><i
                                        class="far fa-file-excel"></i>엑셀양식
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col col-md-5 mobile">
                <div class="row justify-content-end mr-0">
                    <a href="contract_add2.php" role="button" class="btn btn-sm btn-primary mr-1">신규등록</a>
                    <button type="button" class="btn btn-sm btn-danger mr-1" name="rowDeleteBtn" data-toggle="tooltip"
                        data-placement="top" title="임대료 숫자 뒤 'c'표시된것만 삭제 가능합니다">선택삭제
                    </button>
                </div>
            </div>
        </div>
        <div class="row justify-content-end mr-0 mobile">
            <label class="mb-0"> 전체 : <span id="countall">0</span>건, 임대료 <span id="aa">0</span>원, 보증금 <span
                    id="bb">0</span>원</label>
            <!--글자 기본&-->
        </div>
        <div class="row justify-content-end mr-0 mobile">
            <label class="mb-0" style="color:#007bff;"> 체크 : <span id="countchecked">0</span>건, 임대료 <span
                    id="aa1">0</span>원, 보증금 <span id="bb1">0</span>원</label>
            <!--글자 파란색-->
        </div>
    </section>


    <!-- 표내용 -->
    <section class="row justify-content-center">
        <div class="container">
            <div class="mainTable">
                <table class="table table-hover table-bordered table-sm text-center" name=outsideTable id=outsideTable>
                    <thead>
                        <tr class="table-secondary">
                            <th class="fixedHeader">
                                <input type="checkbox" id="allselect">
                            </th>
                            <th class="fixedHeader">순번</th>
                            <th class="fixedHeader">상태</th>
                            <th class="fixedHeader">입주자</th>
                            <th class="fixedHeader">연락처</th>
                            <th class="mobile fixedHeader">물건명</th>
                            <th class="mobile fixedHeader">그룹명</th>
                            <th class="fixedHeader">관리호수</th>
                            <th class="mobile fixedHeader">시작일</th>
                            <th class="mobile fixedHeader">종료일</th>
                            <th class="mobile fixedHeader">기간</th>
                            <th class="fixedHeader">임대료</th>
                            <th class="mobile fixedHeader">보증금</th>
                            <th class="mobile fixedHeader">
                                <span class="badge badge-light">파일</span>
                                <span class="badge badge-dark">메모</span>
                            </th>
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

    <section class="sql" id="sql">
    </section>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/customer/modal_customer.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/sms/modal_sms1.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/sms/modal_sms2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/m_q_contract.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_amount.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_deposit.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_file.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_memo.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_nadd.php";//n개월추가 모달
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/modal/modal_regist.php";//청구번호모달
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_footer.php";
    ?>


    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/popper.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/jquery.number.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
    <script src="/svc/inc/js/autosize.min.js"></script>
    <script src="/svc/inc/js/etc/newdate8.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/checkboxtable.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/modal_table.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/form.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/sms_noneparase3.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/sms_existparase10.js?<?= date('YmdHis') ?>"></script>
    <!-- <script src="/svc/inc/js/etc/uploadfile.js?<?= date('YmdHis') ?>"></script> -->
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/svc/inc/js/daumAddressAPI3.js?<?=date('YmdHis')?>"></script>

    <script type="text/javascript">
    var lease_type = <?php echo json_encode($_SESSION['lease_type']); ?>;
    var cellphone = <?php echo json_encode($_SESSION['cellphone']); ?>;
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
    var roomArray = <?php echo json_encode($roomArray); ?>;
    var smsSettingArray = <?php echo json_encode($rowsms); ?>;
    // console.log(buildingArray);
    // console.log(groupBuildingArray);
    // console.log(roomArray);
    </script>

    <script src="/svc/inc/js/etc/building.js?<?= date('YmdHis') ?>"></script>

    <script type="text/javascript" src="js_sms_array_rcontract.js?<?= date('YmdHis') ?>"></script>
    <!-- 계약리스트 표에서 체크썸파일 -->
    <script type="text/javascript" src="j_checksum_c0.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="/svc/inc/js/etc/customer.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_contract_outside.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_contract_inside.js?<?= date('YmdHis') ?>"></script>
    <script type="text/javascript" src="j_contract_array.js?<?= date('YmdHis') ?>"></script>


    <script>
    $('[data-toggle="tooltip"]').tooltip();

    $(document).ready(function() {

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        var periodDiv = $('select[name=periodDiv]').val();
        dateinput2(periodDiv);

        var pagerow = 50;
        var getPage = 1;

        outsideTable(pagerow, getPage);


        // sql(pagerow, getPage);


        $('#href_smsSetting').on('click', function() {
            var moveCheck = confirm('문자상용구설정 화면으로 이동합니다. 이동하시겠습니까?');
            if (moveCheck) {
                location.href = '/svc/service/sms/smsSetting.php';
            }
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

        $(document).on('click', '.page-link', function() {
            // $(this).parent('li').attr('class','active');
            var pagerow = 50;
            var getPage = $(this).text();
            // console.log(getPage);
            outsideTable(pagerow, getPage);
            // sql(pagerow, getPage);
        })

        $('input.amountNumber').number(true);
    })
    $(document).on('click', '.eachpop', function() {
        var cid = $(this).siblings('input[name=customerId]').val();
        m_customer(cid);
    })

    autosize($('textarea[name=etc_m]'));

    //===========document.ready function end and the other load start!

    $('select[name=dateDiv]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        // history.replaceState({}, null, location.pahtname);
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('select[name=periodDiv]').on('change', function() {
        // history.replaceState({}, null, location.pahtname);
        var pagerow = 50;
        var getPage = 1;
        var periodDiv = $('select[name=periodDiv]').val();
        // console.log(periodDiv);
        dateinput2(periodDiv);
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('input[name=fromDate]').on('change', function() {
        // history.replaceState({}, null, location.pahtname);이게 안되네 ㅠㅠ
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('input[name=toDate]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('select[name=progress]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('select[name=building]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('select[name=group]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('select[name=etcCondi]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })


    $('input[name=cText]').on('keyup', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })

    $('#loading').on('click', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // sql(pagerow, getPage);
    })
    //---------조회버튼클릭평션 end --------------//


    //---------삭제버튼 시작--------------//
    $('button[name="rowDeleteBtn"]').on('click', function() {
        // console.log(contractArray);

        if (contractArray.length === 0) {
            alert('1개 이상을 선택하여 주세요.');
            return false;
        }

        for (var i = 0; i < contractArray.length; i++) {
            if (!(contractArray[i][2] === 'c')) {
                alert("'c'표시된것만 삭제 가능합니다." + contractArray[i][0] + "행 확인하세요");
                return false;
            }
            if (!(contractArray[i][3] === "")) {
                alert('메모 또는 파일이 존재하면 삭제 불가합니다.');
                return false;
            }
            if (!(contractArray[i][4] === "")) {
                alert('메모 또는 파일이 존재하면 삭제 불가합니다.');
                return false;
            }
        }

        var aa = 'realContractDelete';
        var bb = 'p_realContract_delete_for.php';
        var cc = JSON.stringify(contractArray);

        goCategoryPage(aa, bb, cc);

        function goCategoryPage(a, b, c) {
            var frm = formCreate(a, 'post', b, '');
            frm = formInput(frm, 'contractArray', c);
            formSubmit(frm);
        }

    }) //rowDeleteBtn function closing

    $('#excelbtn').on('click', function() {
        var a = $('form').serialize();
        console.log(a);

        goCategoryPage(a);

        function goCategoryPage(a) {
            var frm = formCreate('exceldown', 'post', 'p_exceldown_contract.php', '_blank');
            frm = formInput(frm, 'form', a);
            formSubmit(frm);
        }
    })

    $(document).on('click', '.contractAmount', function() {

        var ccid = $(this).siblings('input[name=contractId]').val();
        let customerId = $(this).parent('td[name=amount]').siblings('td[name=customer]').children(
            'input[name=customerId]').val();
        var cccustomer = $(this).parent().siblings('td[name=customer]').find('input[name=ccnn2]')
            .val();
        var ccroom = $(this).parent().siblings('td[name=room]').text();
        let buildingId = $(this).parent().siblings('td[name=building]').children(
                'input[name=buildingId]')
            .val();
        ccid = Number(ccid);
        buildingId = Number(buildingId);
        let mtAmount = $(this).text();
        let mAmount = $(this).siblings('input[name=mAmount]').val();
        let mvAmount = $(this).siblings('input[name=mvAmount]').val();
        let payOrder = $(this).siblings('input[name=payOrder]').val();
        let url = '../../ajax/ajax_amountlist.php';

        $('span.mtitle').text('임대료 내역');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);
        $('#mAmount_m').val(mAmount);
        $('#mvAmount_m').val(mvAmount);
        $('#mtAmount_m').val(mtAmount);
        $('#payOrder_m').val(payOrder);
        $('#customerId_m').val(customerId);
        $('#buildingId_m').val(buildingId);

        // console.log(ccid, url);

        insideTable(ccid, url);
    })

    $(document).on('click', '.modaldeposit', function() {

        var ccid = $(this).parent().siblings('td[name=checkbox]').find('input[name=rid]').val();
        var cccustomer = $(this).parent().siblings('td[name=customer]').find('input[name=ccnn2]')
            .val();
        var ccroom = $(this).parent().siblings('td[name=room]').text();
        ccid = Number(ccid);

        $('span.mtitle').text('보증금');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        depositlist(ccid);
    })

    $(document).on('click', '.modalfile', function() {
        var ccid = $(this).parent().siblings('td[name=checkbox]').find('input[name=rid]').val();
        var cccustomer = $(this).parent().siblings('td[name=customer]').find('input[name=ccnn2]')
            .val();
        var ccroom = $(this).parent().siblings('td[name=room]').text();
        ccid = Number(ccid);

        $('span.mtitle').text('첨부파일');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        filelist(ccid);
        //   console.log('file load');
    })

    $(document).on('click', '.modalmemo', function() {
        var ccid = $(this).parent().siblings('td[name=checkbox]').find('input[name=rid]').val();
        var cccustomer = $(this).parent().siblings('td[name=customer]').find('input[name=ccnn2]')
            .val();
        var ccroom = $(this).parent().siblings('td[name=room]').text();
        ccid = Number(ccid);

        // console.log('memo load');

        $('span.mtitle').text('메모');
        $('span.contractNumber').text(ccid);
        $('span.customer11').text(cccustomer);
        $('span.room11').text(ccroom);

        memolist(ccid);
    })

    $('#modal_amount').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })

    $('#modal_deposit').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })

    $('#modal_file').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })

    $('#modal_memo').on('hidden.bs.modal', function() {
        var pagerow = 50;
        var getPage = 1;
        outsideTable(pagerow, getPage);
        // makesum(pagerow, getPage);
    })
    </script>

    <script type="text/javascript" src="/svc/service/get/js_sms_tax.js?<?=date('YmdHis')?>"></script>
    <script type="text/javascript" src="j_contract_insidebuttons.js?<?=date('YmdHis')?>"></script>
    <script type="text/javascript" src="j_checksum_cd.js?<?=date('YmdHis')?>"></script>

    </body>

</html>