<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>보낸문자목록</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php"; //이거빼면큰일남, 조회안됨
 ?>

    <!-- 제목섹션 -->
    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h2 class="">보낸문자 목록이에요.(#602)</h2>
            <p class="lead">

            </p>
        </div>
    </section>

    <!-- 조회조건섹션 -->
    <section class="container">
        <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
            <div class="row justify-content-md-center">
                <form>
                    <table>
                        <tr class="text-center">
                            <td width="6%" class="">
                                <select class="form-control form-control-sm selectCall" name="dateDiv">
                                    <option value="sendtime">전송일자</option>
                                </select>
                            </td>
                            <td width="4%" class="">
                                <select class="form-control form-control-sm selectCall" name="periodDiv">
                                    <option value="allDate">--</option>
                                    <option value="today" selected>오늘</option>
                                    <option value="nowMonth">당월</option>
                                    <option value="pastMonth">전월</option>
                                    <option value="1pastMonth">1개월</option>
                                    <option value="3pastMonth">3개월</option>
                                    <option value="nowYear">당년</option>
                                </select>
                            </td>
                            <td width="6%" class="mobile">
                                <input type="text" name="fromDate" value=""
                                    class="form-control form-control-sm text-center dateType">
                            </td>
                            <td width="1%" class="mobile">~</td>
                            <td width="6%" class="mobile">
                                <input type="text" name="toDate" value=""
                                    class="form-control form-control-sm text-center dateType">
                            </td>
                            <td width="4%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="type">
                                    <option value="typeAll">유형</option>
                                    <option value="sms">단문</option>
                                    <option value="mms">장문</option>
                                </select>
                                <!--유형-->
                            </td>
                            <td width="4%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="div1">
                                    <option value="div1all">구분</option>
                                    <option value="immediately">즉시</option>
                                    <option value="reservationed">예약</option>
                                </select>
                                <!--유형-->
                            </td>
                            <td width="4%" class="mobile">
                                <select class="form-control form-control-sm selectCall" name="result">
                                    <option value="resultall">결과</option>
                                    <option value="success">전송성공</option>
                                    <option value="fail">전송실패</option>
                                </select>
                            </td>
                            <td width="6%" class="">
                                <select class="form-control form-control-sm selectCall" name="etcCondi">
                                    <option value="customer">수신자</option>
                                    <option value="contact">수신번호</option>
                                </select>
                            </td>
                            <td width="8%" class="">
                                <input type="text" name="cText" class="form-control form-control-sm text-center">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row ml-0">
            <label for=""> 총 <span id="countall"></span>건</label>
        </div>
    </section>

    <!-- 표 섹션 -->
    <section class="container">
        <div class="row">
            <div class="col col-md-4">
                <div class="mainTable">
                    <table class="table table-hover table-bordered table-sm text-center" id="checkboxTestTbl">
                        <thead>
                            <tr class="table-secondary">
                                <th class="fixedHeader">순번</th>
                                <th class="fixedHeader mobile">실행일시</th>
                                <th class="fixedHeader mobile">제목</th>
                                <th class="fixedHeader">발송번호</th>
                            </tr>
                        </thead>
                        <tbody id="allVals">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col col-md-8" id=rightArea>
            </div>
        </div>

    </section>

    <!-- 페이지 -->
    <section class="container mt-2" id="page">

    </section>

    <section id="allVals2" class="container">

    </section>

    <?php include "modal_description.php"; ?>

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script src="/svc/inc/js/etc/newdate8.js?<?=date('YmdHis')?>"></script>

    <script>
    function maketable(x, y) {
        var form = $('form').serialize();
        var mtable = $.ajax({
            url: 'popbill/xms_load.php',
            method: 'post',
            data: {
                'form': form,
                'pagerow': x,
                'getPage': y
            },
            success: function(data) {
                data = JSON.parse(data);
                datacount = data.length;

                var returns = '';
                var countall;

                if (datacount === 0) {
                    returns = "<tr><td colspan='10'>조회값이 없어요.</td></tr>";
                } else {
                    $.each(data, function(key, value) {
                        countall = value.count;
                        var ordered = Number(value.num) - ((y - 1) * x);

                        returns += '<tr>';

                        returns += `<td>${value.num}</td>`;
                        returns += `<td><a href='#' id=${value.popbill_receiptNum} class=pbnum>${value.action_date}</a>
                        </td>`;
                        returns += `<td>${value.title}</td>`;
                        returns += `<td>${value.sent_number}</td>`;

                        returns += '</tr>';

                        datacount -= 1;
                    })
                }
                $('#allVals').html(returns);
                $('#countall').text(datacount);
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
            }
        })

        return mtable;
    }

    function sql(x, y) {
        var form = $('form').serialize();
        var msqlajax = $.ajax({
            url: 'ajax_sentsms_sql2.php',
            method: 'post',
            data: {
                'form': form,
                'pagerow': x,
                'getPage': y
            },
            success: function(data) {
                // $('#allVals2').html(data);
            }
        });
        return msqlajax;
    }


    $(document).ready(function() {

        var periodDiv = $('select[name=periodDiv]').val();
        dateinput2(periodDiv);

        var pagerow = 50;
        var getPage = 1;

        maketable(pagerow, getPage);
        sql(pagerow, getPage);


        $('.dateType').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            currentText: '오늘',
            closeText: '닫기'
        })

        $(document).on('click', '.page-link', function() {
            // $(this).parent('li').attr('class','active');
            var pagerow = 50;
            var getPage = $(this).text();
            console.log(getPage);
            maketable(pagerow, getPage);
            sql(pagerow, getPage);
        })


        $(document).on('click', '.modalDescription', function() {
            // console.log($(this).text());

            var currow2 = $(this).closest('tr');

            var description = currow2.find('td:eq(7)').children('input[name=description]').val();

            var customer = currow2.find('td:eq(4)').children('label').text();
            var recievenumber = currow2.find('td:eq(5)').text();
            var sentnumber = currow2.find('td:eq(6)').text();
            var byte = currow2.find('td:eq(3)').children('input[name=byte]').val();

            console.log(description, customer, recievenumber, sentnumber);

            $('#modaltextarea').text(description);
            $('#mcustomer').val(customer);
            $('#recievenumber').val(recievenumber);
            $('#sentnumber').val(sentnumber);
            $('#mbyte').val(byte);

        })


    }) //---------document.ready end and 조회버튼클릭 펑션 시작--------------//

    $('select[name=dateDiv]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=periodDiv]').on('change', function() {
        var periodDiv = $('select[name=periodDiv]').val();
        // console.log(periodDiv);
        dateinput2(periodDiv);
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('input[name=fromDate]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('input[name=toDate]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=div1]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=type]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=result]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('select[name=etcCondi]').on('change', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })

    $('input[name=cText]').on('keyup', function() {
        var pagerow = 50;
        var getPage = 1;
        maketable(pagerow, getPage);
        sql(pagerow, getPage);
    })
    //---------조회버튼클릭평션 end and contractArray 펑션 시작--------------//

    $(document).on('click', '.pbnum', function() {
        let pbnum = $(this).attr('id');
        $('#rightArea').text(pbnum);

        $.ajax({
            url: 'popbill/detail.php',
            method: 'post',
            data: {
                'pbnum': pbnum,
            },
            success: function(data) {
                $('#rightArea').html(data);
            }
        });
    })
    </script>

    </body>

</html>