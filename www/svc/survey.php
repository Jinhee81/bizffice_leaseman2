<?php include "view/header.php";
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

?>

<body>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&family=Noto+Sans+KR:wght@100&display=swap');
    @import url("https://fonts.googleapis.com/css?family=Gothic+A1:700|Nanum+Gothic");
    @import url('https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Noto+Serif+KR:wght@500&display=swap');

    .contact {
        /* font-family: 'Nanum Myeongjo', serif; */
        font-family: 'Noto Sans KR', sans-serif;
    }

    body {
        height: 100%;
        display: flex;
        flex-flow: column;
    }

    .main {
        /* font-family: 'Nanum Gothic', sans-serif; */
        /* font-family: 'Noto Serif KR', serif; */
        /* font-family: 'Black Han Sans', sans-serif; */
        /* font-family: 'Noto Serif KR', serif; */
        background-color: #e0f7fa;
        padding-top: 100px;
        padding-bottom: 100px;
        height: 60%
    }

    footer {
        background-color: #aec4c7;
        color: #000a12;
        flex-grow: 1;
    }

    .title {
        height: 20%
    }
    </style>

    <div class="bg-dark text-center pt-3 title">
        <a href="https://www.leaseman.co.kr"><img class="mb-4" src="inc/img/leaseman-1.png" alt="" width=""
                height=""></a>
    </div>

    <div class="text-center main">
        <h1 class="h3 mb-4 font-weight-normal">
            아래 설문하기 버튼을 눌러 설문지를 작성해주세요.<br><br>
            전화 상담 후 회원가입 가능합니다.
        </h1>
        <a href="https://forms.gle/969d3VhZAuWdi5bZA" class="btn btn-primary" role="button">설문하기</a>
        <br>
        <hr>
        <p class="contact mt-5">1. 고객센터운영시간 : 평일 오전 10시~오후5시<br>
            <br>
            2. 카카오톡 문의 가능합니다. (친구찾기 : 리스맨 검색)<br> <br>
            3. 하단 고객센터 번호로 문자송신 가능합니다 (단문/장문 모두 가능). 문자메시지 또는 이메일을 보내주세요.
        </p>
    </div>
    <footer class="text-center pt-3">
        <div class="footer-above">
            <p class="mb-2" style="font-family: 'Nanum Gothic', sans-serif; font-size:13px;">
                상호: 리스맨소프트 &nbsp;|&nbsp; 주소: 경기도 의정부시 신흥로258번길 25, 8층 A22호(의정부동, 해태프라자) &nbsp;|&nbsp; 대표: 유진희
                &nbsp;|&nbsp;
                전화: 031-879-8003
                &nbsp;|&nbsp; 이메일: info@leaseman.co.kr
            </p>
            <p class="mb-2" style="font-family: 'Nanum Gothic', sans-serif; font-size:13px;">
                사업자등록번호: 745-06-01064 &nbsp;|&nbsp; 통신판매업신고번호: 제2020-의정부신곡-0073호
            </p>
            <p class="mb-0 pb-4" style="font-family: 'Nanum Gothic', sans-serif; font-size:13px;">
                COPYRIGHT &copy; 2018 LEASEMANSOFT Co. ALL RIGHT RESERVED.
            </p>
        </div>
    </footer>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>

</body>

</html>