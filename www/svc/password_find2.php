<?php include "view/header.php";
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>비밀번호를 찾습니다.</title>
    <style>
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
            <h3 class="">비밀번호를 찾습니다(임시비밀번호를 발급합니다).</h3>
            <hr class="my-4">
            <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
        </div>
    </section>

    <div class="container" style="max-width:500px;">
        <div class="form-group row">
            <label for="" class="col-sm-4 col-form-label"><b>이메일</b></label>
            <div class="col-sm-8">
                <input type="email" class="form-control" name="email1" id=email1 required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-4 col-form-label"><b>연락처</b></label>
            <div class="col-sm-8">
                <input type="number" class="form-control" name="cellphone1" id=cellphone1 required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-sm btn-outline-info" id='btnSubmit'>임시비밀번호 생성하기</button>
        </div>
        <div class="mt-2 mb-4" id="result"></div>
    </div>

    <?php
    include "view/footer.php";
    ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script>
    function generatePassword() {
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        console.log(retVal);
        return retVal;
    }

    $('#btnSubmit').on('click', function() {
        let tempPass = generatePassword();
        console.log(tempPass);


        tempPass = JSON.stringify(tempPass);
        let email1 = JSON.stringify($('#email1').val());
        let cellphone1 = JSON.stringify($('#cellphone1').val());

        $.ajax({
            url: 'ajax_pass_gene.php',
            data: {
                'temp': tempPass,
                'email1': email1,
                'cellphone1': cellphone1
            },
            type: 'post',
            success: function(data) {
                data = JSON.parse(data);
                console.log(data);

                $('#result').html(data);
            }
        })
    })
    </script>
    </body>

</html>