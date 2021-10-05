<?php include "view/header.php";
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

?>

<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&family=Noto+Sans+KR:wght@100&display=swap');

        .contact {
            font-family: 'Nanum Myeongjo', serif;
            font-family: 'Noto Sans KR', sans-serif;
        }
    </style>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        리스맨은 '크롬브라우저'에서 작동합니다. 반드시 크롬브라우저에서 실행해주세요 ^__^ <a href="https://www.google.com/intl/ko/chrome/" class="alert-link" target="_blank">다운로드 바로가기</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="bg-dark text-center pt-3">
        <a href="https://www.leaseman.co.kr" target="_blank"><img class="mb-4" src="inc/img/leaseman-1.png" alt="" width="" height=""></a>
    </div>

    <div class="text-center container mt-5">

        <h1 class="h3 mb-3 font-weight-normal">임대관리프로그램 리스맨 접속을 환영합니다!</h1>
        <p class="">크롬브라우저에서 작동합니다. 반드시 크롬브라우저를 이용해주세요 ^__^</p>
        <!-- <p>회원가입후 30일 또는 20건 이하 계약은 쭉~~ 무료이용입니다. 부담없이 회원가입해주세요^__^ <a href="../use_guide/fare_guide.php"
                class='badge badge-danger'>요금안내 바로가기</a></p> -->
        <div class="text-center container mt-5" style="width:360px;">


            <form method="post" action="login_check.php" class="form-signin">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="이메일주소" required="" autofocus="">
                    <input type="password" name="password" class="form-control" placeholder="비밀번호" required="">
                </div>
                <div class="check-box mb-3">
                    <input type="checkbox" name="remember-email">&nbsp;이메일 기억하기
                </div>
                <div class="top_margin"></div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
            </form>

            <div class="form-row mt-2">
                <div class="form-group col-md-4">
                    <a class="btn btn-sm btn-outline-success btn-block" href="email_find.php" role="button">이메일찾기</a>
                </div>
                <div class="form-group col-md-4">
                    <a class="btn btn-sm btn-outline-success btn-block" href="password_find2.php" role="button">비밀번호찾기</a>
                </div>
                <div class="form-group col-md-4">
                    <a class="btn btn-sm btn-outline-success btn-block" href="https://forms.gle/D9kt2TEpdLnHaswJ9" role="button" target="_blank">문의하기</a>
                </div>
                <!-- <div class="form-group col-md-4">
                    <a class="btn btn-sm btn-outline-success btn-block" href="../membership/membership.php" role="button">회원가입하기</a>
                </div> -->
                <!-- <a href="https://open.kakao.com/o/sZsgqby" class="btn btn-sm btn-warning btn-block mb-4"
                    type="button">카카오톡 문의하기</a> -->
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <a class="btn btn-sm btn-outline-primary btn-block" href="https://drive.google.com/file/d/14kWOLZ8GSslaEzO44YIgtXr28QzvEAIj/view?usp=sharing" target="_blank" role="button">리스맨 화면소개 보기</a>
                </div>
            </div>
        </div>
        <hr>
        <p class="contact text-left">
            1. 하단 사업자번호로 사업자상태 확인하세요. <a href="https://teht.hometax.go.kr/websquare/websquare.html?w2xPath=/ui/ab/a/a/UTEABAAA13.xml" class="" target="_blank">(국세청사이트)</a><br>
            2. 통신판매업정보 확인하세요. <a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=7450601064" class="" target="_blank">(공정거래위원회사이트)</a><br>
            3. 리스맨 상표권 확인하세요.(출원번호 4020170015461(출원일 2017.02.07)) <a href="http://www.kipris.or.kr/khome/main.jsp" class="" target="_blank">(특허정보넷 키프리스)</a><br>
            4. 리스맨 기술특허 확인하세요 (임대사업자 관리 장치 및 그 방법(APPARATUS AND THE METHOD FOR MANAGING RENTAL OR LEASE), 특허등록번호 10-1878261-0000). <a href="http://www.kipris.or.kr/khome/main.jsp" class="" target="_blank">(특허정보넷 키프리스)</a>
        </p>
    </div>

    <?php
    include "view/footer.php";
    ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var c_email = getCookie("email");
            $('input[name=email]').val(c_email);

            if ($('input[name=email]').val() != '') {
                $('input[name=remember-email]').attr("checked", true);
            }

            $('input[name=remember-email]').change(function() {
                if ($(this).is(":checked")) {
                    console.log('checked');
                    setCookie("email", $('input[name=email]').val(), 60);
                } else {
                    deleteCookie("email");
                    console.log('unchecked')
                }
            })

            $('input[name=email]').on('keyup', function() {
                if ($('input[name=remember-email]').is(':checked')) {
                    setCookie("email", $('input[name=email]').val(), 60);
                }
            })

            function setCookie(cookieName, value, exdays) {
                var exdate = new Date();
                exdate.setDate(exdate.getDate() + exdays);
                var cookieValue = escape(value) + ((exdays === null) ? "" : "; expires=" + exdate.toGMTString());
                document.cookie = cookieName + "=" + cookieValue;
                console.log(document.cookie);
            }

            function deleteCookie(cookieName) {
                var expireDate = new Date();
                expireDate.setDate(expireDate.getDate() - 1);
                document.cookie = cookieName + '= ' + '; expires=' + expireDate.toGMTString();
            }

            function getCookie(cookieName) {
                cookieName = cookieName + '=';
                var cookieData = document.cookie;
                var start = cookieData.indexOf(cookieName);
                var cookieValue = '';

                if (start != -1) {
                    start += cookieName.length;
                    var end = cookieData.indexOf(';', start);
                    if (end == -1) end = cookieData.length;
                    cookieValue = cookieData.substring(start, end);
                }

                return unescape(cookieValue);
            }


        })
    </script>
</body>

</html>