<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>문의수정</title>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header1_meta.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_header2.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/contract/building.php";

    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //고객아이디
    settype($filtered_id, 'integer');

    $sql = "select
          qDate, name, contact1, contact2, contact3,
          etc, created, updated, building_id
      from customer
      where id = {$filtered_id}";

    // echo $sql;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>


    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">문의자 수정 화면입니다!</h3>
            <p class="lead">
                <!-- (1)입주한 사람(또는 법인) 뿐만아니라 거래처 또는 기타분류를 등록할 수 있습니다.<br>
      (2)'구분1'이 '입주자'이면 임대계약이 가능하며, '기타'이면 기타계약이 가능합니다.<br>
      (3)<a href="m_c_adds.php" target="_blank">'일괄등록'</a>화면에서 여러명의 관계자를 등록하세요. -->
            </p>
            <!-- <small>(1)<span id='star' style='color:#F7BE81;'>* </span>표시는 반드시 입력해야 합니다.(2)'일괄등록','csv등록'은 데스크탑 디스플레이에서 사용가능합니다. </small> -->
            <hr class="my-4">
        </div>
    </section>

    <section class="container" style="max-width:600px;">
        <form class="" action="p_m_c_edit_question.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>물건</p>
                </div>
                <div class="form-group col-md-8">
                    <select name="building" class="form-control">
                        <?php
                        foreach ($buildingArray as $key => $value) {
                            if ($row['building_id'] == $key) {
                                echo "<option value='$key' selected>" . $buildingArray[$key][0] . "</option>";
                            } else {
                                echo "<option value='$key'>" . $buildingArray[$key][0] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="hidden" name="cid" value="<?= $filtered_id ?>">
                    <input type="hidden" name="name" value="<?= $row['name'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-7">
                    <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>연락처</p>
                    <div class='form-row'>
                        <div class='form group col-md-4'>
                            <input type='text' name='contact1' class='form-control' maxlength='3' value='<?= $row['contact1'] ?>' required numberOnly>
                        </div>
                        <div class='form group col-md-4'>
                            <input type='text' name='contact2' class='form-control' maxlength='4' value='<?= $row['contact2'] ?>' required oninput='maxlengthCheck(this);' numberOnly>
                        </div>
                        <div class='form group col-md-4'>
                            <input type='text' name='contact3' class='form-control' maxlength='4' value='<?= $row['contact3'] ?>' required oninput='maxlengthCheck(this);' numberOnly>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <p class="mb-1">문의일자</p>
                    <input type="text" name="qDate" value="<?= date('Y-n-j', strtotime($row['qDate'])) ?>" class="form-control dateType">
                </div>
            </div>
            <div class='form-row pl-1 pr-1 mb-2'>
                <p class="mb-1">문의내용</p>
                <input type='text' name='etc' class='form-control' maxlength='47' value="<?= $row['etc'] ?>">
            </div>
            <div class="row">
                <div class="col col-md-3">
                    <button type='button' class='btn btn-sm btn-outline-primary' data-toggle="modal" data-target="#smsModal1" id="smsBtn"><i class="far fa-envelope"></i> 보내기</button>
                </div>
                <div class="col col-md-9">
                    <div class="row justify-content-end mr-0">
                        <a href='m_c_edit.php?id=<?= $filtered_id ?>'><button type='button' class='btn btn-warning mr-1'><i class="fas fa-angle-double-right"></i> 전환</button></a>
                        <button type='button' class='btn btn-primary mr-1' name="editBtn">수정</button>
                        <button type='button' class='btn btn-danger mr-1' name="deleteBtn">삭제</button>
                        <a href='customer.php'><button type='button' class='btn btn-secondary'><i class="fas fa-angle-double-right"></i> 입주자목록</button></a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/service/sms/modal_sms3.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/service_footer.php"; ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/popper.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script src="/svc/inc/js/jquery-ui-timepicker-addon.js"></script>
    <script src="/svc/inc/js/etc/newdate8.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/form.js?<?= date('YmdHis') ?>"></script>
    <script src="/svc/inc/js/etc/sms_noneparase4.js?<?= date('YmdHis') ?>"></script>

    <script type="text/javascript">
        var buildingArray = <?php echo json_encode($buildingArray); ?>;
        var customerId = <?= $filtered_id ?>;

        function maxlengthCheck(object) {
            if (object.value.length > object.maxLength) {
                object.value = object.value.slice(0, object.maxLength);
            }
        } //숫자 입력개수 제한하는 함수, 연락처1,2,3/사업자번호에 사용됨

        $("input:text[numberOnly]").on("keyup", function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });

        $(document).ready(function() {
            $('.dateType').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                currentText: '오늘',
                closeText: '닫기'
            })

            $('button[name=editBtn]').on('click', function() {
                $('form').submit();
            })

            $('button[name=deleteBtn]').on('click', function() {
                var c = confirm('정말 삭제하시겠습니까?');

                if (c) {
                    goCategoryPage(customerId);

                    function goCategoryPage(a) {
                        var frm = formCreate('querydelete', 'post', 'p_m_c_delete.php', '');
                        frm = formInput(frm, 'cid', a);
                        formSubmit(frm);
                    }
                }
            })

            var recievephonenumber = $('input[name=contact1]').val() + '-' + $('input[name=contact2]').val() + '-' + $('input[name=contact3]').val();
            var cname = $('input[name=name]').val();

            $('#smsBtn').on('click', function() {
                var buildingkey = $('select[name=building]').val();
                // console.log(buildingkey);

                //문자발송번호
                var sendphonenumber = buildingArray[buildingkey][3] + buildingArray[buildingkey][4] + buildingArray[buildingkey][5];
                $('input[name=sendphonenumber]').val(sendphonenumber);

                //문자수신번호
                $('#recievephonenumber').text(recievephonenumber);
                $('#mcid').val(customerId);
                $('#mcname').text(cname);


                sms_noneparase();
            })


        })
    </script>
    </body>

</html>