<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>고정비</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";
?>

    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h2 class="">고정비를 관리하세요.</h2>
            <p class="lead">
                <!-- (1) 상태(진행 - 현재 계약 진행 중), (대기 - 곧 계약시작임), (종료 - 종료된 계약)로 구분합니다.<br>
      (2) 월이용료를 클릭하면 해당 계약의 상세페이지가 나옵니다.<br>
      (3) 단계는 (clear-계약을 입력하자마자), (청구- 언제돈입금예정인지 설정), 입금(이용료(임대료)가 입금되고있는 상태)로 구분됩니다. -->
            </p>
        </div>
    </section>

    <section class="container" style="max-width:1000px;">
        <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
            <form>
                <div class="form-group row justify-content-md-center">
                    <div class="col-sm-2 pl-0 pr-1">
                        <select class="form-control form-control-sm selectCall" name="building">
                        </select>
                        <!---->
                    </div>
                    <div class="col-sm-2 pl-0 pr-0">
                        <button type="button" class="btn btn-primary btn-sm" name="btnAdd" data-toggle="modal"
                            data-target="#exampleModal">고정비추가</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="">
            <table class="table table-hover text-center mt-2 table-sm" id="checkboxTestTbl">
                <thead>
                    <tr class="table-info">
                        <!-- <th scope="col"><input type="checkbox"></th> -->
                        <th scope="col">순번</th>
                        <th scope="col" class="mobile">관리물건</th>
                        <th scope="col">내역</th>
                        <th scope="col" class="mobile">금액</th>
                        <th scope="col" class="mobile">공급가액</th>
                        <th scope="col" class="">세액</th>
                        <th scope="col" class="">부가세</th>
                        <th scope="col" class="mobile"></th>
                    </tr>
                </thead>
                <tbody id="allVals">

                </tbody>
            </table>

        </div>
    </section>

    <!-- <section id="allVals2">

</section> -->

    <?php include "fixcost_add_modal.php"; ?>
    <?php include "fixcost_edit_modal.php"; ?>

    <!-- <script src="/js/etc/date.js"></script> -->

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery.number.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
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


    <script>
    function maketable() {
        var mtable = $.ajax({
            url: 'ajax_fixcost_value.php',
            method: 'post',
            data: $('form').serialize(),
            success: function(data) {
                data = JSON.parse(data);
                datacount = data.length;

                var returns = '';
                var totalamountArray = [0, 0, 0];

                //
                if (datacount === 0) {
                    returns = "<tr><td colspan='8'>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요!</td></tr>";
                } else {
                    $.each(data, function(key, value) {
                        returns += '<tr>';
                        returns += '<td>' + value.num + '<input type="hidden" name="id" value="' +
                            value.id + '"></td>';
                        returns += '<td>' + value.bName + '</td>';
                        returns += '<td>' + value.title + '</td>';
                        returns += '<td>' + value.amount1 + '</td>';
                        returns += '<td>' + value.amount2 + '</td>';
                        returns += '<td>' + value.amount3 + '</td>';

                        if (value.vat === 'vatYes') {
                            returns += '<td>유</td>';
                        } else {
                            returns += '<td>무</td>';
                        }

                        returns +=
                            '<td><button type="submit" name="edit" class="btn btn-default grey" data-toggle="modal" data-target="#editModal"><i class="far fa-edit"></i></button><button type="submit" name="delete" class="btn btn-default grey"><i class="far fa-trash-alt"></i></button></td>';

                        returns += '</tr>';

                        var amount1 = value.amount1.replace(/,/gi, '');
                        var amount2 = value.amount2.replace(/,/gi, '');
                        var amount3 = value.amount3.replace(/,/gi, '');

                        totalamountArray[0] += Number(amount1);
                        totalamountArray[1] += Number(amount2);
                        totalamountArray[2] += Number(amount3);

                    }) //each }

                    // totalamountArray[0] = totalamountArray[0].number(true);
                    // totalamountArray[1] = totalamountArray[1].number(true);
                    // totalamountArray[2] = totalamountArray[2].number(true);

                    returns += '<tr style="background-color:#D8D8D8;">';
                    returns += '<td colspan="3"><p class="font-italic mb-1">소계</p></td>';
                    returns += '<td><p class="font-italic mb-1">' + totalamountArray[0] + '</p></td>';
                    returns += '<td><p class="font-italic mb-1">' + totalamountArray[1] + '</p></td>';
                    returns += '<td><p class="font-italic mb-1">' + totalamountArray[2] + '</p></td>';
                    returns += '<td></td><td></td></tr>';
                } //else }

                $('#allVals').html(returns);
            } //success }
        }) //ajax }

        return mtable;
    } //function}

    function makesql() {
        var query = $.ajax({
            url: 'ajax_fixcost_sql2.php',
            method: 'post',
            data: $('form').serialize(),
            success: function(data) {
                $('#allVals2').html(data);
            }
        });
        return query;
    }

    $(document).ready(function() {
        $(".numberComma").number(true);

        maketable();
        makesql();

        $('select[name=building]').on('change', function() {
            maketable();
            makesql();
        })

        $('button[name="delete"]').on('click', function() {
            var id = $(this).parent().parent().children().children('input:eq(0)').val();

            console.log(id);

            var aa = 'fixcostDelete';
            var bb = 'p_fixcost_delete.php';

            var deleteCheck = confirm('정말 삭제하겠습니까?');
            if (deleteCheck) {
                goCategoryPage(aa, bb, id);

                function goCategoryPage(a, b, c) {
                    var frm = formCreate(a, 'post', b, '');
                    frm = formInput(frm, 'id', c);
                    formSubmit(frm);
                }
            }
        }) //삭제하기버튼 클릭=====



        $('button[name="edit"]').on('click', function() {

            var id = $(this).parent().parent().children().children('input:eq(0)').val();

            console.log(id);

            $.ajax({
                url: 'ajax_fixcostModalEdit.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(data) {
                    $('.modal-body').html(data);
                }
            })

            // $('#modalEditBtn').on('click', function(){
            //   var building =
            // })

        }) //edit icon click event=============
    }) //document.ready}




    $("input:text[numberOnly]").on('click', function() {
        $(this).select();
    })

    $('input[name=amount1]').on('keyup', function() {
        var amount1 = Number($(this).val());

        var vat = $(':input:radio[name=inlineRadioOptions]:checked').val();

        if (vat === 'vatYes') {
            var amount2 = amount1 / 1.1;
            var amount3 = amount1 - amount2;
        } else {
            var amount2 = amount1;
            var amount3 = amount1 - amount2;
        }

        $('input[name=amount2]').val(amount2);
        $('input[name=amount3]').val(amount3);
    }) //금액이 키업될 때


    $(':input:radio[id=inlineRadio1]').on('click', function() {
        var amount1 = Number($('input[name=amount1]').val());

        var amount2 = amount1 / 1.1;
        var amount3 = amount1 - amount2;

        $('input[name=amount2]').val(amount2);
        $('input[name=amount3]').val(amount3);
    }) //라디오버튼 부가세포함이 클릭될때

    $(':input:radio[id=inlineRadio2]').on('click', function() {
        var amount1 = Number($('input[name=amount1]').val());

        var amount2 = amount1;
        var amount3 = amount1 - amount2;

        $('input[name=amount2]').val(amount2);
        $('input[name=amount3]').val(amount3);
    }) //라디오버튼 부가세별도가 클릭될때
    </script>


    </body>

</html>