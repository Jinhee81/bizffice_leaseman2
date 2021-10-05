<?php include "view/header.php";
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

?>

<body>

    <div class="bg-dark text-center pt-3">
        <img class="mb-4" src="inc/img/leaseman-1.png" alt="" width="" height="">
    </div>

    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">새로운 비밀번호를 생성합니다.</h3>
            <hr class="my-4">
            <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
        </div>
    </section>

    <div class="container" style="max-width:500px;">
        <form class="" action="p_password_send.php" method="post">

            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label"><b>이메일</b></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="email">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label"><b>연락처</b></label>
                <div class="col-sm-8">
                    <!-- <input type="text" class="form-control" name="cellphone"> -->
                    <input type="number" class="form-control" name="cellphone" id="phone" required
                        placeholder="'-' 제외, 숫자만 입력합니다" value="">
                    <input type="hidden" name="phoneAuth" value="no">
                    <button type="button" onclick="phone_check();" id="phoneBtn"
                        class="btn btn-sm btn-outline-danger">인증하기</button>
                    <h8 id="check"></h8>
                    <div id="ViewTimer"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label"><b>변경할 비밀번호</b></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="newpassword">
                    <button type="submit" class="btn btn-sm btn-outline-info mt-3" id="submitbtn">비밀번호 생성하기</button>
                </div>
            </div>

            <div class="text-center">
            </div>
        </form>
    </div>

    <?php
    include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";
    ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script>
    var SetTime = 999999999999; // 최초 설정 시간(기본 : 초)

    function msg_time() { // 1초씩 카운트

        m = Math.floor(SetTime / 60) + "분 " + (SetTime % 60) + "초"; // 남은 시간 계산

        var msg = "현재 남은 시간은 <font color='red'>" + m + "</font> 입니다.";

        document.all.ViewTimer.innerHTML = msg; // div 영역에 보여줌

        SetTime--; // 1초씩 감소

        if (SetTime < 0) { // 시간이 종료 되었으면..

            alert("인증시간이 만료되었습니다.");
            $('#sms').hide();
            $('#smsBtn').hide();
            $('#ViewTimer').hide();
            SetTime = 999999999999;
        }

    }

    window.onload = function TimerStart() {
        tid = setInterval('msg_time()', 1000)
    };

    $(function() {
        $('#ViewTimer').hide();
    })

    function phone_check() {
        if ($('#phone').val().length < 1) {
            alert('휴대폰번호를 다시 확인해주세요');
            return false;
        } else {
            var rand = generateRandom(100000, 999999);
            var phone = $('#phone').val();
            $('#ViewTimer').show();
            alert($('#phone').val() + '번호로 인증번호를 발송했습니다.');
            phone = phone.replace(/-/gi, '');
            SetTime = 180;
            $('#check').html(
                '<input type="text" name="sms" id="sms" placeholder="인증번호" required>' +
                '<button type="button" onclick="sms_check(' + rand +
                ');" name="sms_auth" id="smsBtn"">번호확인</button>'
            );
            $.ajax({
                url: 'smscheck.php',
                method: 'post',
                data: {
                    phone: phone,
                    rand: rand
                },
                success: function(data) {

                }
            })
        }
    }
    var generateRandom = function(min, max) {
        var ranNum = Math.floor(Math.random() * (max - min + 1)) + min;
        return ranNum;
    }

    function sms_check(rand) {
        if ($('#sms').val() == rand) {
            $('input[name=phoneAuth]').val('yes');
            alert('인증완료 되었습니다.');
            $('#phone').prop('readonly', 'true');
            $('#phoneBtn').hide();
            $('#sms').prop('disabled', 'true');
            $('#smsBtn').hide();
            $('#ViewTimer').hide();
            clearInterval(tid);
        } else {
            alert('인증번호를 다시 확인해 주세요.');
        }
    }

    $(function() {
        $("#submitbtn").click(function(e) {

            var checkphone = $('input[name=phoneAuth]').val();

            if (checkphone === 'no') {
                alert('연락처 인증하기를 진행해야 새로운 비밀번호 생성이 가능합니다.');
                return false;
            }
            e.preventDefault();
            var link = $(this).attr("href");

            $("#frm_from").attr("action", link);
            $("#frm_from").submit();

        });
    });
    </script>
</body>

</html>