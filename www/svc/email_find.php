<?php include "view/header.php";
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>이메일 찾기</title>
    <style class="">
    .blue {
        color: #0080FF;
    }
    </style>
    <div class="bg-dark text-center pt-3">
        <a href="https://www.leaseman.co.kr"><img class="mb-4" src="inc/img/leaseman-1.png" alt="" width=""
                height=""></a>
    </div>
    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">가입한 이메일을 찾습니다.</h3>
            <hr class="my-4">
            <p>가입할때 기재한 연락처를 적어주세요.</p>
        </div>
    </section>

    <div class="container" style="max-width:500px;">
        <!-- <form class="" action="p_email_find.php" method="post"> -->

        <div class="form-group row">
            <label for="" class="col-sm-4 col-form-label"><b>연락처</b></label>
            <div class="col-sm-8">
                <input type="number" class="form-control" name="cellphone" placeholder="'-' 제외, 숫자만 입력합니다">
                <button type="submit" class="btn btn-sm btn-outline-info mt-3" id="btnSubmit">이메일 찾기</button>
            </div>
        </div>
        <div class="" id="result"></div>

        <!-- </form> -->
    </div>

    <?php
    include "view/footer.php";
    ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script>
    $('#btnSubmit').on('click', function() {
        let cellphone = $('input[name=cellphone]').val();

        cellphone = JSON.stringify(cellphone);
        $.ajax({
            url: 'ajax_email_find.php',
            method: 'post',
            data: {
                'cellphone': cellphone
            },
            success: function(data) {
                data = JSON.parse(data);
                // console.log(data);

                $('#result').html(
                    `<p class=font-italic>가입한 이메일은 <span class=blue>${data}</span>입니다. ^^</p><button class='btn btn-primary btn-sm' id='loginbtn'>로그인</button>`
                );
            }
        })
    })
    </script>

    <script>
    $(document).on('click', '#loginbtn', function() {
        location.href = 'login.php';
    })
    </script>
    </body>

</html>