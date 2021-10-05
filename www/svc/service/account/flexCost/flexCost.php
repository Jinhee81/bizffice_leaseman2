<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>지출입력</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";
include "yearMonth.php";
?>


    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">지출을 입력하세요.</h3>
            <p class="lead">
                <!-- (1) 상태(진행 - 현재 계약 진행 중), (대기 - 곧 계약시작임), (종료 - 종료된 계약)로 구분합니다.<br>
      (2) 월이용료를 클릭하면 해당 계약의 상세페이지가 나옵니다.<br>
      (3) 단계는 (clear-계약을 입력하자마자), (청구- 언제돈입금예정인지 설정), 입금(이용료(임대료)가 입금되고있는 상태)로 구분됩니다. -->
            </p>
        </div>
    </section>


    <section class="container">
        <!--style="max-width:1000px;"-->
        <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
            <form name="building">
                <div class="form-group row justify-content-md-center">
                    <div class="col-sm-2 pl-0 pr-1">
                        <select class="form-control form-control-sm selectCall" name="building">
                        </select>
                        <!---->
                    </div>
                    <div class="col-sm-2 pl-0 pr-1">
                        <select class="form-control form-control-sm selectCall" name="year">
                            <option value="<?=$yearArray[0]?>">
                                <?=$yearArray[0].'년'?>
                            </option>
                            <option value="<?=$yearArray[1]?>">
                                <?=$yearArray[1].'년'?>
                            </option>
                            <option value="<?=$yearArray[2]?>" selected>
                                <?=$yearArray[2].'년'?>
                            </option>
                            <option value="<?=$yearArray[3]?>">
                                <?=$yearArray[3].'년'?>
                            </option>
                        </select>
                        <!---->
                    </div>
                    <div class="col-sm-2 pl-0 pr-1">
                        <select class="form-control form-control-sm selectCall" name="month">
                            <option value="1" <?php if($currentMonth=="1"){echo "selected";}?>>1월</option>
                            <option value="2" <?php if($currentMonth=="2"){echo "selected";}?>>2월</option>
                            <option value="3" <?php if($currentMonth=="3"){echo "selected";}?>>3월</option>
                            <option value="4" <?php if($currentMonth=="4"){echo "selected";}?>>4월</option>
                            <option value="5" <?php if($currentMonth=="5"){echo "selected";}?>>5월</option>
                            <option value="6" <?php if($currentMonth=="6"){echo "selected";}?>>6월</option>
                            <option value="7" <?php if($currentMonth=="7"){echo "selected";}?>>7월</option>
                            <option value="8" <?php if($currentMonth=="8"){echo "selected";}?>>8월</option>
                            <option value="9" <?php if($currentMonth=="9"){echo "selected";}?>>9월</option>
                            <option value="10" <?php if($currentMonth=="10"){echo "selected";}?>>10월</option>
                            <option value="11" <?php if($currentMonth=="11"){echo "selected";}?>>11월</option>
                            <option value="12" <?php if($currentMonth=="12"){echo "selected";}?>>12월</option>
                        </select>
                        <!---->
                    </div>
                    <div class="col-sm-1 pl-0 pr-0 mr-1">
                        <button type="button" name="button" class="btn btn-sm btn-primary btn-block"
                            id="btnSave">저장</button>


                    </div>
                    <!-- <div class="col-sm-1 pl-0 pr-0 mr-1">
              <button type="button" name="button" class="btn btn-sm btn-outline-primary btn-block" id="btnEdit">편집</button>
            </div> -->
                    <div class="col-sm-1 pl-0 pr-0">
                        <button type="button" name="button" class="btn btn-sm btn-danger btn-block"
                            id="btnDeleteAll">전체삭제</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container" id="allVals" style="">
            <!-- style="max-width:800px;" 이거를 햇다가 input type=form-control이 나오니깐 넘 좁아져서 없앴음-->
            <div class="">
                <div class="row">
                    <div class="col">
                        <h5 class="display-5"># 고정비 <span class="badge badge-success" id="badge1" data-toggle="modal"
                                data-target="#exampleModal">고정비입력</span></h5>
                    </div>

                </div>

                <div class="" id="fixcostList">

                </div>
            </div>
            <hr>
            <div class="">
                <h5 class="display-5"># 변동비 <span class="badge badge-success" id="badge2" data-toggle="modal"
                        data-target="#modal2">변동비입력</span></h5>
                <div id="flexcostList">

                </div>
            </div>
            <hr>
        </div>
    </section>


    <?php include "modal_fixcost.php"; ?>
    <?php include "modal_flexcost.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>


    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/jquery.number.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script type="text/javascript">
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
    var roomArray = <?php echo json_encode($roomArray); ?>;
    console.log(buildingArray);
    console.log(groupBuildingArray);
    console.log(roomArray);
    </script>
    <script src="/svc/inc/js/etc/building2.js?<?=date('YmdHis')?>"></script>

    <script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>


    <script>
    var buildingIdx = $('select[name=building]').val();
    var year = $('select[name=year]').val();
    var month = $('select[name=month]').val();
    var yearText = $('select[name=year] option:selected').text();
    var monthText = $('select[name=month] option:selected').text();
    var building = $('select[name=building] option:selected').text();
    var modalbuildingOption = "<option value='" + buildingIdx + "'>" + building + "</option>";
    var modalyearOption = "<option value='" + year + "'>" + yearText + "</option>";
    var modalmonthOption = "<option value='" + month + "'>" + monthText + "</option>";
    var modalDate = year + '-' + month + '-1';
    $('select[name=modalbuilding]').html(modalbuildingOption);
    $('select[name=modalyear]').html(modalyearOption);
    $('select[name=modalmonth]').html(modalmonthOption);
    $('input[name=payDate]').val(modalDate);

    //---- ^ buildingIdx 전역변수 선언 ^------//

    function fntblfix() {
        buildingIdx = $('select[name=building]').val();
        year = $('select[name=year]').val();
        month = $('select[name=month]').val();

        var fixtable = $.ajax({
            url: 'ajax_fixcostLoad.php',
            method: 'post',
            data: {
                buildingIdx: buildingIdx,
                year: year,
                month: month
            },
            success: function(data) {
                $('#fixcostList').html(data);
            } //success}
        }) //ajax}
        return fixtable;
    } //function}

    function fntblflex() {
        buildingIdx = $('select[name=building]').val();
        year = $('select[name=year]').val();
        month = $('select[name=month]').val();

        var flextable = $.ajax({
            url: 'ajax_flexcostLoad.php',
            method: 'post',
            data: {
                buildingIdx: buildingIdx,
                year: year,
                month: month
            },
            success: function(data) {
                $('#flexcostList').html(data);
            } //success}
        }) //ajax}
        return flextable;
    } //function}

    function fntblmodalfix() {
        var buildingIdx = $('select[name=building]').val();
        var building = $('select[name=building] option:selected').text();
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        var modalbuildingOption = "<option value='" + buildingIdx + "'>" + building + "</option>";

        $('select[name=modalbuilding]').html(modalbuildingOption);

        var modalfixtable = $.ajax({
            url: 'ajax_modalfixcostLoad.php',
            method: 'post',
            data: {
                buildingIdx: buildingIdx,
                year: year,
                month: month
            },
            success: function(data) {
                $('#fixcostListModal').html(data);
            } //success}
        }) //ajax}
        return modalfixtable;
    } //function}

    $(document).ready(function() {
        fntblfix();
        fntblflex();
        fntblmodalfix();
    }) //------------ ^ document.ready ^------//


    $('select[name=building]').on('change', function() {
        fntblfix();
        fntblflex();
        fntblmodalfix();
    })

    $('select[name=year]').on('change', function() {
        fntblfix();
        fntblflex();
    })

    $('select[name=month]').on('change', function() {
        fntblfix();
        fntblflex();
    })

    $('#href_fixcost').on('click', function() {
        var moveCheck = confirm('고정비관리 화면으로 이동합니다. 이동하시겠습니까?');
        if (moveCheck) {
            location.href = '/svc/service/account/fixcost/fixcost.php';
        }
    }) //------- ^ 모달안 고정비출력 ^------//

    $('#btn1').on('click', function() {
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        var payDate = year + '-' + month + '-1';
        var allCnt = $("#modalTable tbody :checkbox").length;
        var fixcostArray = [];
        console.log(allCnt);

        if ($("#modalTable thead :checkbox").is(':checked')) {
            for (var i = 0; i < allCnt; i++) {
                var fixcostArrayEle = [];
                var colfixcostId = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(0)").children(
                    'input').val(); //고정비아이디
                var colfixcostTitle = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(3)")
                    .text(); //타이틀
                var colfixcostAmount1 = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(4)")
                    .text(); //금액
                var colfixcostAmount2 = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(5)")
                    .text(); //공급가액
                var colfixcostAmount3 = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(6)")
                    .text(); //세액
                fixcostArrayEle.push(colfixcostId, colfixcostTitle, colfixcostAmount1, colfixcostAmount2,
                    colfixcostAmount3);
                fixcostArray.push(fixcostArrayEle);
            }
        } else {
            for (var i = 0; i <= allCnt; i++) {
                var checkboxCheck = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(0)").children(
                    'input').is(':checked'); //체크인지 아닌지 확인
                console.log(checkboxCheck);

                if (checkboxCheck === true) {
                    var fixcostArrayEle = [];
                    var colfixcostId = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(0)")
                        .children('input').val(); //고정비아이디
                    var colfixcostTitle = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(3)")
                        .text(); //타이틀
                    var colfixcostAmount1 = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(4)")
                        .text(); //금액
                    var colfixcostAmount2 = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(5)")
                        .text(); //공급가액
                    var colfixcostAmount3 = $("#modalTable tbody").find("tr:eq(" + i + ")").find("td:eq(6)")
                        .text(); //세액
                    fixcostArrayEle.push(colfixcostId, colfixcostTitle, colfixcostAmount1, colfixcostAmount2,
                        colfixcostAmount3);
                    fixcostArray.push(fixcostArrayEle);
                }
            }
        }
        //
        console.log(fixcostArray);

        if (fixcostArray.length === 0) {
            alert('1개이상을 선택해야합니다.');
            return false;
        }

        function goCategoryPage(a, b, c, d, e, f, g) {
            var frm = formCreate(a, 'post', b, '');
            frm = formInput(frm, 'fixcostArray', c);
            frm = formInput(frm, 'buildingIdx', d);
            frm = formInput(frm, 'year', e);
            frm = formInput(frm, 'month', f);
            frm = formInput(frm, 'payDate', g);
            formSubmit(frm);
        }

        var fixcostArrayjson = JSON.stringify(fixcostArray);
        var aa = 'fixcostArray';
        var bb = 'p_costlist_add_fix.php';

        goCategoryPage(aa, bb, fixcostArrayjson, buildingIdx, year, month, payDate);

    })
    //------- ^ 모달안 넣기버튼 클릭 ^------//


    $('#btnSave').on('click', function() { //------ ^전체 저장버튼 클릭 ^------//
        var buildingIdx = $('select[name=building]').val();
        var building = $('select[name=building] :selected').text();
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        var fixrow = $('#fixcostTable tbody tr').length - 1;
        var flexrow = $('#flexcostTable tbody tr').length - 1;

        // var editableArray = [];
        var costlistArray1 = [];
        for (var i = 0; i < fixrow; i++) {
            var costlistArray1ele = [];

            var costlistid = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(0)").children(
                'input').val(); //아이디
            var costlistTitle = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(1)").text(); //내역
            var costlistAmount1 = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(2)").children(
                'input').val().replace(/,/g, ''); //금액
            var costlistAmount2 = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(3)").children(
                'input').val().replace(/,/g, ''); //공급가액
            var costlistAmount3 = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(4)").children(
                'input').val().replace(/,/g, ''); //세액
            var costlistPaydate = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(5)").children(
                'input').val(); //지출일자
            var costlistTaxdate = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(6)").children(
                'input').val(); //증빙일자
            var costlistEtc = $('#fixcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(7)").children(
                'input').val(); //특이사항

            costlistAmount1 = Number(costlistAmount1);
            costlistAmount2 = Number(costlistAmount2);
            costlistAmount3 = Number(costlistAmount3);

            // console.log(costlistid, costlistTitle, costlistAmount1, costlistAmount2, costlistAmount3, costlistPaydate, costlistTaxdate, costlistEtc);


            if (costlistAmount1 != (costlistAmount2 + costlistAmount3)) {
                // console.log(costlistAmount1);
                // console.log(costlistAmount2+costlistAmount3);
                alert(costlistTitle + '의 공급가액,세액의 합계가 금액과 맞지 않습니다.');
                return false;

            }

            costlistArray1ele.push(costlistid, costlistTitle, costlistAmount1, costlistAmount2, costlistAmount3,
                costlistPaydate, costlistTaxdate, costlistEtc);

            costlistArray1.push(costlistArray1ele);
        } //costlistArray1 making for end



        var costlistArray2 = [];
        for (var i = 0; i < flexrow; i++) {
            var costlistArray2ele = [];

            var costlist2id = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(0)").children(
                'input').val(); //아이디
            var costlist2Title = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(1)").children()
                .val().trim(); //내역
            var costlist2Amount1 = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(2)").children(
                'input').val().replace(/,/g, ''); //금액
            var costlist2Amount2 = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(3)").children(
                'input').val().replace(/,/g, ''); //공급가액
            var costlist2Amount3 = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(4)").children(
                'input').val().replace(/,/g, ''); //세액
            var costlist2Paydate = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(5)").children(
                'input').val(); //지출일자
            var costlist2Taxdate = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(6)").children(
                'input').val(); //증빙일자
            var costlist2Etc = $('#flexcostTable tbody').find("tr:eq(" + i + ")").find("td:eq(7)").children(
                'input').val(); //특이사항

            costlist2Amount1 = Number(costlist2Amount1);
            costlist2Amount2 = Number(costlist2Amount2);
            costlist2Amount3 = Number(costlist2Amount3);


            if (costlist2Amount1 != (costlist2Amount2 + costlist2Amount3)) {
                alert(costlist2Title + '의 공급가액,세액의 합계가 금액과 맞지 않습니다.');
                return false;

            }

            costlistArray2ele.push(costlist2id, costlist2Title, costlist2Amount1, costlist2Amount2,
                costlist2Amount3, costlist2Paydate, costlist2Taxdate, costlist2Etc);

            costlistArray2.push(costlistArray2ele);

        } //costlistArray2 making for end

        console.log(costlistArray1, costlistArray2);

        if (costlistArray1.length > 0 || costlistArray2.length > 0) {
            function goCategoryPage(a, b, c, d, e, f, g, h) {
                var frm = formCreate(a, 'post', b, '');
                frm = formInput(frm, 'costlistArray1', c);
                frm = formInput(frm, 'costlistArray2', d);
                frm = formInput(frm, 'buildingIdx', e);
                frm = formInput(frm, 'building', f);
                frm = formInput(frm, 'year', g);
                frm = formInput(frm, 'month', h);
                formSubmit(frm);
            }

            var costlistArray1json = JSON.stringify(costlistArray1);
            var costlistArray2json = JSON.stringify(costlistArray2);
            var aa = 'costlist';
            var bb = 'p_costlist_update.php'; //저장버튼이지만 실제행위는 업데이트이므로 업데이트파일이 맞다.

            goCategoryPage(aa, bb, costlistArray1json, costlistArray2json, buildingIdx, building, year, month);

        } else {
            alert('저장할 대상이 존재하지 않습니다.');
            return false;
        }
    }) //------ ^전체 저장버튼 클릭 ^------//

    $('input[name=mamount1]').on('keyup', function() {
        var amount1 = Number($(this).val());

        var vat = $(':input:radio[name=inlineRadioOptions]:checked').val();

        if (vat === 'vatYes') {
            var amount2 = amount1 / 1.1;
            var amount3 = amount1 - amount2;
        } else {
            var amount2 = amount1;
            var amount3 = amount1 - amount2;
        }

        $('input[name=mamount2]').val(amount2);
        $('input[name=mamount3]').val(amount3);
    }) //금액이 키업될 때


    $(':input:radio[id=inlineRadio1]').on('click', function() {
        var amount1 = Number($('input[name=mamount1]').val());

        var amount2 = amount1 / 1.1;
        var amount3 = amount1 - amount2;

        $('input[name=mamount2]').val(amount2);
        $('input[name=mamount3]').val(amount3);
    }) //라디오버튼 부가세포함이 클릭될때

    $(':input:radio[id=inlineRadio2]').on('click', function() {
        var amount1 = Number($('input[name=mamount1]').val());

        var amount2 = amount1;
        var amount3 = amount1 - amount2;

        $('input[name=mamount2]').val(amount2);
        $('input[name=mamount3]').val(amount3);
    }) //라디오버튼 부가세별도가 클릭될때

    $('#btnDeleteAll').on('click', function() {
        var buildingIdx = $('select[name=building]').val();
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();

        var deleteCheck = confirm('정말 전체 삭제하시겠습니까?');
        if (deleteCheck) {
            function goCategoryPage(a, b, c, d, e) {
                var frm = formCreate(a, 'post', b, '');
                frm = formInput(frm, 'buildingIdx', c);
                frm = formInput(frm, 'year', d);
                frm = formInput(frm, 'month', e);
                formSubmit(frm);
            }

            var aa = 'costlist_delete_all';
            var bb = 'p_costlist_delete_all.php';

            goCategoryPage(aa, bb, buildingIdx, year, month);
        }

    }) //상단 전체삭제버튼 클릭시
    </script>

    </body>

</html>