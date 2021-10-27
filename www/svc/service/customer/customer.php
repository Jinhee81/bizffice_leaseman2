<!-- pagenation 작업 시작 -->
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>입주자</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";

$sql_sms = "select
          screen, title, description
        from sms
        where
          user_id={$_SESSION['id']} and
          screen='관계자화면'";
// echo $sql_sms;

$result_sms = mysqli_query($conn, $sql_sms);
$rowsms = array();
while($row_sms = mysqli_fetch_array($result_sms)){
  $rowsms[] = $row_sms;
}
?>

    <section class="container">
        <div class="jumbotron pt-3 pb-3 mb-2">
            <div class="row">
                <h3 class="">입주자 목록이에요.(#101)</h3>
            </div>
            <p class="lead">
                <!-- (1) 정확한 표현은 이해관계자리스트라고 보아도 무방합니다. 세입자(고객) 뿐만 아니라, 문의하는 사람 및 자주 거래하는 거래처도 저장할 수 있어요.<br> -->
                (1) 임대계약이 발생하면 숫자가 표시됩니다. (2)'기타' 분류는 임대계약 외의 일회성매출에 대한 고객을 분류할 수 있습니다.<br>
                (3) 등록해야할 입주자(세입자/임차인)가 많으면 고객센터로 연락주세요. 대신 등록작업 해드립니다. (1년계약시 유효 ^_^)
            </p>

            <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
                <form>
                    <div class="row justify-content-md-center">
                        <table>
                            <tr>
                                <td width="8%" class="mobile">
                                    <select class="form-control form-control-sm selectCall" name="dateDiv">
                                        <option value="registerDate">등록일자</option>
                                        <option value="updateDate">수정일자</option>
                                    </select>
                                </td>
                                <td width="8%" class="mobile">
                                    <select class="form-control form-control-sm selectCall" name="periodDiv">
                                        <option value="allDate">--</option>
                                        <option value="nowMonth">당월</option>
                                        <option value="pastMonth">전월</option>
                                        <option value="1pastMonth">1개월전</option>
                                        <option value="nowYear" selected>당년</option>
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
                                <td width="10%" class="mobile">
                                    <input type="text" name="fromDate" value=""
                                        class="form-control form-control-sm text-center dateType yyyymmdd">
                                </td>
                                <td width="1%" class="mobile">~</td>
                                <td width="10%" class="mobile">
                                    <input type="text" name="toDate" value=""
                                        class="form-control form-control-sm text-center dateType yyyymmdd">
                                </td>
                                <td width="8%" class="mobile">
                                    <select name="building" class="form-control form-control-sm selectCall">
                                    </select>
                                </td>
                                <td width="8%" class="mobile">
                                    <select name="customerDiv" class="form-control form-control-sm selectCall">
                                        <option value="customerAll">구분전체</option>
                                        <option value="입주자">입주자</option>
                                        <option value="문의">문의</option>
                                        <option value="거래처">거래처</option>
                                        <option value="기타">기타</option>
                                    </select>
                                </td>
                                <td width="8%" class="">
                                    <select class="form-control form-control-sm selectCall" name="etcCondi">
                                        <option value="customer">성명/사업자명</option>
                                        <option value="contact">연락처</option>
                                        <option value="email">이메일</option>
                                        <option value="etc">특이사항</option>
                                    </select>
                                </td>
                                <td width="15%" class="">
                                    <input type="text" name="cText" value=""
                                        class="form-control form-control-sm text-center">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>

    </section>

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
                                    <?php for ($i=0; $i < count($rowsms); $i++) {
                  echo "<option value='".$rowsms[$i]['title']."'>".$rowsms[$i]['title']."</option>";
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
                            <td>
                                <button type="button" class="btn btn-info btn-sm mobile" name="button" id="excelbtn"><i
                                        class="far fa-file-excel"></i>엑셀양식</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col col-md-5">
                <div class="row justify-content-end mr-0">
                    <a href="m_c_add_question.php" role="button" class="btn btn-outline-primary btn-sm mr-1"
                        name="button">문의등록</a>
                    <a href="m_c_add.php" role="button" class="btn btn-primary btn-sm mr-1" name="button">신규등록</a>
                    <button type="button" class="btn btn-danger btn-sm mobile" name="rowDeleteBtn">선택삭제</button>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row ml-0">
            <label for=""> 총 <span id="countall"></span>건</label>
        </div>
    </section>

    <!-- 표내용 -->
    <section class="row justify-content-center">
        <div class="container">
            <div class="mainTable">
                <table class="table table-hover table-bordered table-sm text-center" id="checkboxTestTbl">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col" class="fixedHeader"><input type="checkbox" id="allselect"></th>
                            <th scope="col" class="fixedHeader">순번</th>
                            <th scope="col" class="fixedHeader">소속물건</th>
                            <th scope="col" class="fixedHeader">구분</th>
                            <th scope="col" class="fixedHeader">성명/사업자명</th>
                            <th scope="col" class="fixedHeader">연락처</th>
                            <th scope="col" class="fixedHeader mobile">이메일</th>
                            <th scope="col" class="fixedHeader mobile">특이사항</th>
                            <th scope="col" class="fixedHeader mobile">등록일</th>
                            <th scope="col" class="fixedHeader mobile">수정일</th>
                            <th scope="col" class="fixedHeader mobile">바로가기</th>
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


    <!-- <section id="query" class="container">

</section> -->

    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/service/sms/modal_sms1.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/sms/modal_sms2.php";
 ?>

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/popper.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
    <script src="/svc/inc/js/etc/newdate8.js?<?=date('YmdHis')?>"></script>
    <script src="/svc/inc/js/etc/checkboxtable.js?<?=date('YmdHis')?>"></script>
    <script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

    <script src="/svc/inc/js/etc/sms_noneparase3.js?<?=date('YmdHis')?>"></script>
    <script src="/svc/inc/js/etc/sms_existparase10.js?<?=date('YmdHis')?>"></script>

    <script type="text/javascript">
    var lease_type = <?php echo json_encode($_SESSION['lease_type']); ?>;
    var cellphone = <?php echo json_encode($_SESSION['cellphone']); ?>;
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    console.log(buildingArray);
    var smsSettingArray = <?php echo json_encode($rowsms); ?>;

    var buildingoption = buildingoption = `<option value=bAll>물건전체</option>`;
    $('select[name=building]').append(buildingoption);

    for (var key in buildingArray) { //건물목록출력(비즈피스장암,비즈피스구로)
        buildingoption = "<option value='" + key + "'>" + buildingArray[key][0] + "</option>";
        $('select[name=building]').append(buildingoption);
    }
    </script>

    <script type="text/javascript" src="js_sms_array_customer.js?<?=date('YmdHis')?>"></script>

    <script>
    function maketable(x, y) {

        var form = $('form').serialize();
        var mtable = $.ajax({
            url: 'ajax_customerLoad.php',
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
                    returns = "<tr><td colspan='11'>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요!</td></tr>";
                } else {
                    $.each(data, function(key, value) {
                        countall = value.count; //원래의 전체길이를 구하는  (pagenation하기 위한 전체길이)
                        returns += '<tr>';
                        returns += '<td class=""><input type="checkbox" value="' + value.id +
                            '" class="tbodycheckbox"></td>';
                        returns += '<td class="">' + value.num + '</td>';
                        returns += '<td class="">' + value.bName + '</td>';
                        returns += '<td class="">' + value.div1 + '</td>';
                        if (value.div1 === '문의') {
                            returns += '<td class=""><a href="m_c_edit_question.php?id=' + value
                                .id + '" data-toggle="tooltip" data-placement="top" title="' + value
                                .cName + '" class="green">' + value.cNamemb + '</a>';
                        } else {
                            returns += '<td class=""><a href="m_c_edit.php?id=' + value.id +
                                '" data-toggle="tooltip" data-placement="top" title="' + value
                                .cName + '" class="green">' + value.cNamemb + '</a>';
                        }

                        returns += '<input type="hidden" name="name" value="' + value.name + '">';
                        returns += '<input type="hidden" name="companyname" value="' + value
                            .companyname + '">';

                        if (value.contractCount >= 1) {
                            returns += '<a href="/svc/service/contract/contract.php?customerId=' +
                                value.id +
                                '&progress=pAll" class="badge badge-pill badge-warning">' + value
                                .contractCount + '</a></td>';
                        } else {
                            returns += '</td>';
                        }

                        returns += '<td class=""><a href="tel:' + value.cContact + '">' + value
                            .cContact + '</a></td>';
                        returns += '<td class="mobile">' + value.emailmb +
                            '<input type="hidden" value="' + value.email + '"></td>';
                        returns += '<td class="mobile">' + value.etc + '</td>';
                        returns += '<td class="mobile">' + value.created + '</td>';
                        returns += '<td class="mobile">' + value.updated + '</td>';
                        if (value.gothere === '임대계약') {
                            returns +=
                                '<td class="mobile"><a href="/svc/service/contract/contract_add1.php?id=' +
                                value.id + '" class="badge badge-secondary">계약</a></td>';
                        } else if (value.gothere === '기타계약') {
                            returns +=
                                '<td class="mobile"><a href="/svc/service/contractetc/contractetc_add1.php?id=' +
                                value.id + '" class="badge badge-secondary">계약</a></td>';
                        } else {
                            returns += '<td class="mobile"></td>';
                        }

                        returns += '</tr>';

                        datacount -= 1;

                    }) //each end}
                } //else end}

                $('#allVals').html(returns);
                $('#countall').text(countall);
                var totalpage = Math.ceil(Number(countall) / Number(x));

                var totalpageArray = [];

                for (var i = 1; i <= totalpage; i++) {
                    totalpageArray.push(i);
                }

                var paging =
                    '<nav aria-label="..."><ul class="pagination pagination-sm justify-content-center">';

                for (var i = 1; i <= totalpageArray.length; i++) {
                    // paging += '<li class="page-item"><a class="page-link" href="customer0.php?page='+i+'">'+i+'</a></li>';
                    paging += '<li class="page-item"><a class="page-link">' + i + '</a></li>';
                }

                paging += '</ul></nav>';

                // console.log(totalpageArray);
                $('#page').html(paging);


            } //success end}
        })

        return mtable;
    }

    function makesql(x, y) {

        var form = $('form').serialize();
        var query = $.ajax({
            url: 'ajax_customerLoad_sql2.php',
            method: 'post',
            data: {
                'form': form,
                'pagerow': x,
                'getPage': y
            },
            success: function(data) {
                $('#query').html(data);
            } //success end}
        })
        return query;
    }

    $(document).ready(function() {

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })

        var periodDiv = $('select[name=periodDiv]').val();
        dateinput2(periodDiv);

        // var pagerow = $('select[name=pagerow]').val();처음에 이걸했다가 그냥 50줄씩으로 고정하기로 함
        var pagerow = 50;
        var getPage = 1;

        maketable(pagerow, getPage);
        makesql(pagerow, getPage);

        $(document).on('click', '.page-link', function() {
            // console.log('minsun222');
            // console.log($(this).text());
            // console.log($(this).parent());
            $(this).parent('li').attr('class', 'active');
            // $(this).parent().css('color','#ffffff').css('background-color','#007bff'); 일단 이거는 다음에 하자 너무 잘 안됨. bind를 알아야하나? ㅠㅠ
            // $(this).parent().addClass('active').siblings().removeClass('active');

            // function fnpage(a){
            //   var pagenumber = a.text();
            //   return pagenumber;
            // }
            //
            // var b = fnpage.bind($(this));
            // console.log(b);
            //
            // b.parent().addClass('active');

            var pagerow = 50;
            var getPage = $(this).text();
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

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
            currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
            closeText: '닫기' // 닫기 버튼 패널
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

        $('select[name=dateDiv]').on('change', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            // makesql(pagerow,getPage);
        })

        $('select[name=periodDiv]').on('change', function() {
            var periodDiv = $('select[name=periodDiv]').val();
            // console.log(periodDiv);
            dateinput2(periodDiv);
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        $('input[name=fromDate]').on('change', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        $('input[name=toDate]').on('change', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        $('select[name=building]').on('change', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        $('select[name=customerDiv]').on('change', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        $('select[name=etcCondi]').on('change', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        $('input[name=cText]').on('keyup', function() {
            var pagerow = 50;
            var getPage = 1;
            maketable(pagerow, getPage);
            makesql(pagerow, getPage);
        })

        //=================== customerArray start ==============//
        var customerArray = [];

        $(document).on('change', '#allselect', function() {
            // var table = $('#mydatatable');
            var allCnt = $(".tbodycheckbox").length;
            customerArray = [];

            if ($(this).is(":checked")) {
                for (var i = 1; i <= allCnt; i++) {
                    var customerArrayEle = [];
                    var colOrder = table.find("tr:eq(" + i + ")").find("td:eq(1)").text();
                    var colid = table.find("tr:eq(" + i + ")").find("td:eq(0)").children('input').val();
                    var colStep = table.find("tr:eq(" + i + ")").find("td:eq(3)").children('span')
                        .text();
                    customerArrayEle.push(colOrder, colid, colStep);
                    customerArray.push(customerArrayEle);
                }
            } else {
                customerArray = [];
            }
            console.log(customerArray);
        })

        $(document).on('change', '.tbodycheckbox', function() {
            // var table = $('#mydatatable');
            var customerArrayEle = [];

            if ($(this).is(":checked")) {
                var currow = $(this).closest('tr');
                var colOrder = Number(currow.find('td:eq(1)').text());
                var colid = currow.find('td:eq(0)').children('input').val();
                var colStep = currow.find('td:eq(3)').children('span').text();
                customerArrayEle.push(colOrder, colid, colStep);
                customerArray.push(customerArrayEle);
            } else {
                var currow = $(this).closest('tr');
                var colid = currow.find('td:eq(0)').children('input').val();

                for (var i = 0; i < customerArray.length; i++) {
                    if (customerArray[i][1] == colid) {
                        var index = i;
                        break;
                    }
                }
                customerArray.splice(index, 1);
            }
            console.log(customerArray);
        })
        //=================== customerArray end ==============//



        $('button[name="rowDeleteBtn"]').on('click', function() {
            console.log(customerArray);
            for (var i = 0; i < customerArray.length; i++) {
                if (Number(customerArray[i][2]) > 0) {
                    alert('계약등록된 고객이 포함될 경우 삭제 불가능합니다.');
                    return false;
                }
            }

            var aa = 'customerDelete';
            var bb = 'p_m_c_delete_for.php';

            goCategoryPage(aa, bb, customerArray);

            function goCategoryPage(a, b, c) {
                var frm = formCreate(a, 'post', b, '');
                frm = formInput(frm, 'customerArray', c);
                formSubmit(frm);
            }

        })



    }) //document.ready end

    $('#excelbtn').on('click', function() {
        var a = $('form').serialize();

        goCategoryPage(a);

        function goCategoryPage(a) {
            var frm = formCreate('exceldown', 'post', 'p_exceldown_customer.php', '_blank');
            frm = formInput(frm, 'form', a);
            formSubmit(frm);
        }
    })
    </script>

    <script type="text/javascript" src="/svc/service/get/js_sms_tax.js?<?=date('YmdHis')?>">
    </script>

    </body>

</html>