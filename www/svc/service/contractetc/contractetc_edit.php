<!-- 계약리스트화면에서 등록버튼누르면 나오는 거 -->
<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: /svc/login.php');
}
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
include "good.php";

$filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //기타계약번호

include "contractetc_edit_condi.php";
?>

<!-- 제목섹션 -->
<section class="container">
    <div class="jumbotron pt-3 pb-3">
        <h3 class="">기타계약 수정 화면입니다!</h3>
        <!-- <p class="lead">고객이란 입주한 세입자 및 문의하는 문의고객, 거래처 등을 포함합니다. 고객등록이 되어야 임대계약 등록이 가능합니다!</p> -->
        <!-- <small>(1)<span id='star' style='color:#F7BE81;'> * </span>표시는 필수 입력값입니다. (2)<b>[세입자정보]</b>에는 세입자만 등록 가능합니다. (거래처 및 문의고객은 검색결과가 없다고 표시되니 주의하세요!) <b>[세입자정보]</b>의 제일우측 숫자는 고객번호로써 시스템데이터임을 참고하여주세요. (3)<b>[기간정보]</b>의 기간(개월수)에는 최대 72개월(6년)까지 등록 가능합니다.</small> -->
        <hr class="my-4">
        <!-- <a class="btn btn-primary btn-sm" href="/service/customer/m_c_add.php" role="button">성명등록</a>
    <a class="btn btn-primary btn-sm" href="/service/setting/building.php" role="button">상품추가</a> -->
    </div>
</section>

<!-- 입력폼 -->
<section class="container" style="width:900px;">
    <form method="post" action="p_etcContract_edit.php">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label><b>[성명]</b></label>
            </div>
            <div class="form-group col-md-10 inputWithIcon">
                <a href="/svc/service/customer/m_c_edit.php?id=<?= $row['cid'] ?>">
                    <input type="text" class="form-control" name="" value="<?php if ($row['etc']) {
                                                                                echo $cName . ', ' . $cContact . ', (' . $row['etc'] . ')';
                                                                            } else {
                                                                                echo $cName . ', ' . $cContact;
                                                                            } ?>" disabled>
                </a>
                <input type="hidden" name="etcContract_id" value="<?= $filtered_id ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label><b>[물건,금액]</b></label>
            </div>
            <div class="form-group col-md-10" id="mulgunInfo">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <!--물건목록-->
                        <label>물건명</label>
                        <select name="building" class="form-control" disabled>
                            <option value="<?= $row['building_id'] ?>"><?= $row[11] ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <!--상품목록-->
                        <label>상품명</label>
                        <select name="good" class="form-control">
                            <?php
                            $sql_group = "select id, name from good_in_building where building_id={$row['building_id']}";
                            $result_group = mysqli_query($conn, $sql_group);
                            while ($row_group = mysqli_fetch_array($result_group)) { ?>
                                <option value="<?= $row_group['id'] ?>" <?php if ($row_group['id'] === $row['good_in_building_id']) {
                                                                            echo "selected";
                                                                        } ?>><?= $row_group['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2 mb-0">
                        <label><span id='star' style='color:#F7BE81;'>* </span>공급가액</label>
                        <input type="text" class="form-control text-right amountNumber" name="pAmount" value="<?= $row['pAmount'] ?>" numberOnly required>
                    </div>
                    <div class="form-group col-md-2 mb-0">
                        <label>세액</label>
                        <input type="text" class="form-control text-right amountNumber" name="pvAmount" value="<?= $row['pvAmount'] ?>" numberOnly required>
                    </div>
                    <div class="form-group col-md-2 mb-0">
                        <label>합계</label>
                        <input type="text" class="form-control text-right amountNumber" name="ptAmount" value="<?= $row['ptAmount'] ?>" numberOnly readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2 mb-0">
                <label><b>[날짜]</b></label>
            </div>
            <div class="form-group col-md-10 mb-0">
                <div class="form-row">
                    <div class="form-group col-md-2 mb-10">
                        <label><span id='star' style='color:#F7BE81;'>* </span>입금일자</label>
                        <input type="text" class="form-control dateType" name="executiveDate" value="<?= $row['executiveDate'] ?>" placeholder="" required>
                    </div>
                    <div class="form-group col-md-2 mb-10">
                        <label>입금구분</label>
                        <select class="form-control" name="payKind">
                            <option value="계좌" <?php if ($row['payKind'] === '계좌') {
                                                    echo 'selected';
                                                } ?>>계좌</option>
                            <option value="현금" <?php if ($row['payKind'] === '현금') {
                                                    echo 'selected';
                                                } ?>>현금</option>
                            <option value="카드" <?php if ($row['payKind'] === '카드') {
                                                    echo 'selected';
                                                } ?>>카드</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-0">
                        <label>시작일시</label>
                        <input type="text" class="form-control timeType" name="startTime" value="<?= $row['startTime'] ?>">
                    </div>
                    <div class="form-group col-md-4 mb-0">
                        <label>종료일시</label>
                        <input type="text" class="form-control timeType" name="endTime" value="<?= $row['endTime'] ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2 mb-0">
                <label><b>[특이사항]</b></label>
            </div>
            <div class="form-group col-md-10 mb-0">
                <input type="text" id="" class="form-control" name="etc" value="<?= $row['etc'] ?>">
            </div>
        </div>

        <!-- 기타계약정보 -->
        <div class="mb-3">
            <section class="d-flex justify-content-center">
                <small class="form-text text-muted text-center">기타계약번호[<?= $row['eid'] ?>] 등록일시[<?= $row['createTime'] ?>] 수정일시[<?= $row['updateTime'] ?>] </small>
            </section>
        </div>


        <div class="mt-3">
            <button type='submit' class='btn btn-primary' id='saveBtn'>수정</button>
            <button type='button' class='btn btn-danger' id='deleteBtn'>삭제</button>
            <a href='contractetc.php'><button type='button' class='btn btn-secondary'><i class="fas fa-angle-double-right"></i> 기타계약목록</button></a>
        </div>
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_footer.php"; ?>

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script src="/svc/inc/js/jquery-ui.min.js"></script>
<script src="/svc/inc/js/popper.min.js"></script>
<script src="/svc/inc/js/bootstrap.min.js"></script>
<script src="/svc/inc/js/datepicker-ko.js"></script>
<script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
<script src="/svc/inc/js/jquery.number.min.js"></script>
<script src="/svc/inc/js/etc/form.js"></script>

<script type="text/javascript">
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    var goodBuildingArray = <?php echo json_encode($goodBuildingArray); ?>;
    console.log(buildingArray);
    console.log(goodBuildingArray);
</script>


<script>
    let id = <?= $filtered_id ?>;
    $(document).ready(function() {

        $('.timeType').datetimepicker({
            dateFormat: 'yy-m-d',
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            changeMonth: true,
            changeYear: true,
            showMonthAfterYear: true,
            timeFormat: 'HH:mm:ss',
            controlType: 'select',
            oneLine: true
        })

        $('.dateType').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            currentText: '오늘',
            closeText: '닫기'
        })

        $(".amountNumber").click(function() {
            $(this).select();
        });

        $("input:text[numberOnly]").number(true);


    }) //document.ready closing}

    $("input[name='pAmount']").on('keyup', function() {
        var amount1 = Number($(this).val());
        var amount2 = Number($("input[name='pvAmount']").val());
        var amount12 = amount1 + amount2;
        $("input[name='ptAmount']").val(amount12);
    })

    $("input[name='pvAmount']").on('keyup', function() {
        var amount1 = Number($("input[name='pAmount']").val());
        var amount2 = Number($(this).val());
        var amount12 = amount1 + amount2;
        $("input[name='ptAmount']").val(amount12);
    })


    function goCategoryPage(a) {
        var frm = formCreate('delete', 'post', 'p_etcContract_delete.php', '');
        frm = formInput(frm, 'id', a);
        formSubmit(frm);
    }


    $('#deleteBtn').on('click', function() {

        let confirm = window.confirm('정말 삭제하시겠습니까?');

        if (confirm) {
            goCategoryPage(id);
        }
    })
</script>

</body>

</html>