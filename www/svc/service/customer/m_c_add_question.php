<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>문의등록</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";

$currentDate = date('Y-m-d');
?>


    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">문의자 등록 화면입니다!</h3>
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
        <form method="post" action="p_m_c_add_question.php">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>물건</p>

                </div>
                <div class="form-group col-md-8">
                    <select name="building" class="form-control">
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <p class="mb-1"><span id='star' style='color:#F7BE81;'>* </span>연락처</p>
                        <div class='form-row'>
                            <div class='form group col-md-4'>
                                <input type='text' name='contact1' id='contact1' class='form-control' maxlength='3'
                                    value='010' required numberOnly>
                            </div>
                            <div class='form group col-md-4'>
                                <input type='text' name='contact2' id='contact2' class='form-control' maxlength='4'
                                    required oninput='maxlengthCheck(this);' numberOnly>
                            </div>
                            <div class='form group col-md-4'>
                                <input type='text' name='contact3' id='contact3' class='form-control' maxlength='4'
                                    required oninput='maxlengthCheck(this);' numberOnly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <p class="mb-1">문의일자</p>
                        <input type="text" name="qDate" value="<?=$currentDate?>" class="form-control dateType grey">
                    </div>
                </div>

                <div class='form-row pl-1 pr-1'>
                    <p class="mb-1">문의내용</p>
                    <input type='text' name='etc' class='form-control' maxlength='47'>
                </div>
            </div>


            <div class="row justify-content-md-center">
                <button type='submit' class='btn btn-primary mr-1'>저장</button>
                <a href='customer.php'><button type='button' class='btn btn-secondary'><i
                            class="fas fa-angle-double-right"></i> 입주자목록</button></a>
            </div>
        </form>
    </section>

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/popper.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script type="text/javascript">
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    // console.log(buildingArray);
    var groupoption;
    for (var key in buildingArray) { //건물목록출력(비즈피스장암,비즈피스구로)
        groupoption = "<option value='" + key + "'>" + buildingArray[key][0] + "</option>";
        $('select[name=building]').append(groupoption);
    }
    </script>

    <script type="text/javascript">
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
    })
    </script>
    </body>

</html>