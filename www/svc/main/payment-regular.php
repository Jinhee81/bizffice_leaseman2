<section class="container">
    <div class="jumbotron">
        <h1 class="display-4">이용요금입니다</h1>
        <p class="lead">
            (1)계약건수에 따라 등급을 선택하세요 (계약건수는 통상적으로 방 개수를 말합니다.)<br>
            (2)<?=$_SESSION['email']?>님의 현재계약건수는 <?=$row[0]?>건 이며, 회원가입한지 <?=$fordays2?>일 되었습니다. (회원가입후 30일 및 계약건수 20건
            이하까지 무료이용)<br>
            (3)문자메시지 발송 및 전자세금계산서 발행을 원하면 코인을 구매해야 합니다.<a href="payment.php?page=coin" class='badge badge-danger'>코인구매
                바로가기</a><br>
            <hr class="my-4">
    </div>
</section>

<section class="container text-center" style="max-width:1000px;">
    <table class="table table-bordered text-center">
        <tr>
            <th rowspan="2">등급</th>
            <th rowspan="2">건수</th>
            <th colspan="3">이용요금</th>
        </tr>
        <tr>
            <th>1개월 구매하기</th>
            <!-- <th>1개월 구독하기</th> -->
            <th>3개월 구매하기(월요금)</th>
            <th>12개월 구매하기(월요금)</th>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)1</td>
            <td>~<?=$payAmount[0][1]?>건</td>
            <td><?=$payAmount[0][2]?>원</td>
            <!-- <td><?=$payAmount[0][3]?>원</td> -->
            <td><?=$payAmount[0][4]?>원</td>
            <td><?=$payAmount[0][5]?>원</td>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)2
                <input type="hidden" name="grade_star" value="스타2">
                <input type="hidden" name="gradename" value="star2">
            </td>
            <td>~<?=$payAmount[1][1]?>건</td>
            <td><?=number_format($payAmount[1][2])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[1][2]?>">
                <input type="hidden" name="month" value="<?=1?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[1][1]){
         echo $pay1;
       }
        ?>
            </td>
            <!-- <td><?=number_format($payAmount[1][3])?>원
       <input type="hidden" name="amount" value="<?=$payAmount[1][3]?>">
       <input type="hidden" name="month" value="<?=1?>">
       <?php
       if((int)$row[0]<=(int)$payAmount[1][1]){
         echo $pay2;
       }
        ?>
     </td> -->
            <td><?=number_format($payAmount[1][4])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[1][4]?>">
                <input type="hidden" name="month" value="<?=3?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[1][1]){
         echo $pay1;
       }
        ?>
            </td>
            <td><?=number_format($payAmount[1][5])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[1][5]?>">
                <input type="hidden" name="month" value="<?=12?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[1][1]){
         echo $pay1;
       }
        ?>
            </td>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)3
                <input type="hidden" name="grade_star" value="스타3">
                <input type="hidden" name="gradename" value="star3">
            </td>
            <td>~<?=$payAmount[2][1]?>건</td>
            <td><?=number_format($payAmount[2][2])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[2][2]?>">
                <input type="hidden" name="month" value="<?=1?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[2][1]){
         echo $pay1;
       }
        ?>
            </td>
            <!-- <td><?=number_format($payAmount[2][3])?>원
       <input type="hidden" name="amount" value="<?=$payAmount[2][3]?>">
       <input type="hidden" name="month" value="<?=1?>">
       <?php
       if((int)$row[0]<=(int)$payAmount[2][1]){
         echo $pay2;
       }
        ?>
     </td> -->
            <td><?=number_format($payAmount[2][4])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[2][4]?>">
                <input type="hidden" name="month" value="<?=3?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[2][1]){
         echo $pay1;
       }
        ?>
            </td>
            <td><?=number_format($payAmount[2][5])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[2][5]?>">
                <input type="hidden" name="month" value="<?=12?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[2][1]){
         echo $pay1;
       }
        ?>
            </td>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)4
                <input type="hidden" name="grade_star" value="스타4">
                <input type="hidden" name="gradename" value="star4">
            </td>
            <td>~<?=$payAmount[3][1]?>건</td>
            <td><?=number_format($payAmount[3][2])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[3][2]?>">
                <input type="hidden" name="month" value="<?=1?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[3][1]){
         echo $pay1;
       }
        ?>
            </td>
            <!-- <td><?=number_format($payAmount[3][3])?>원
       <input type="hidden" name="amount" value="<?=$payAmount[3][3]?>">
       <input type="hidden" name="month" value="<?=1?>">
       <?php
       if((int)$row[0]<=(int)$payAmount[3][1]){
         echo $pay2;
       }
        ?>
     </td> -->
            <td><?=number_format($payAmount[3][4])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[3][4]?>">
                <input type="hidden" name="month" value="<?=3?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[3][1]){
         echo $pay1;
       }
        ?>
            </td>
            <td><?=number_format($payAmount[3][5])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[3][5]?>">
                <input type="hidden" name="month" value="<?=12?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[3][1]){
         echo $pay1;
       }
        ?>
            </td>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)5
                <input type="hidden" name="grade_star" value="스타5">
                <input type="hidden" name="gradename" value="star5">
            </td>
            <td>~<?=$payAmount[4][1]?>건</td>
            <td><?=number_format($payAmount[4][2])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[4][2]?>">
                <input type="hidden" name="month" value="<?=1?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[4][1]){
         echo $pay1;
       }
        ?>
            </td>
            <!-- <td><?=number_format($payAmount[4][3])?>원
       <input type="hidden" name="amount" value="<?=$payAmount[4][3]?>">
       <input type="hidden" name="month" value="<?=1?>">
       <?php
       if((int)$row[0]<=(int)$payAmount[4][1]){
         echo $pay2;
       }
        ?>
     </td> -->
            <td><?=number_format($payAmount[4][4])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[4][4]?>">
                <input type="hidden" name="month" value="<?=3?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[4][1]){
         echo $pay1;
       }
        ?>
            </td>
            <td><?=number_format($payAmount[4][5])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[4][5]?>">
                <input type="hidden" name="month" value="<?=12?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[4][1]){
         echo $pay1;
       }
        ?>
            </td>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)6
                <input type="hidden" name="grade_star" value="스타6">
                <input type="hidden" name="gradename" value="star6">
            </td>
            <td>~<?=$payAmount[5][1]?>건</td>
            <td><?=number_format($payAmount[5][2])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[5][2]?>">
                <input type="hidden" name="month" value="<?=1?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[5][1]){
         echo $pay1;
       }
        ?>
            </td>
            <!-- <td><?=number_format($payAmount[5][3])?>원
       <input type="hidden" name="amount" value="<?=$payAmount[5][3]?>">
       <input type="hidden" name="month" value="<?=1?>">
       <?php
       if((int)$row[0]<=(int)$payAmount[5][1]){
         echo $pay2;
       }
        ?>
     </td> -->
            <td><?=number_format($payAmount[5][4])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[5][4]?>">
                <input type="hidden" name="month" value="<?=3?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[5][1]){
         echo $pay1;
       }
        ?>
            </td>
            <td><?=number_format($payAmount[5][5])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[5][5]?>">
                <input type="hidden" name="month" value="<?=12?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[5][1]){
         echo $pay1;
       }
        ?>
            </td>
        </tr>
        <tr>
            <td><i class="fas fa-star"></i>(스타)7
                <input type="hidden" name="grade_star" value="스타6">
                <input type="hidden" name="gradename" value="star6">
            </td>
            <td>~<?=$payAmount[6][1]?>건</td>
            <td><?=number_format($payAmount[6][2])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[6][2]?>">
                <input type="hidden" name="month" value="<?=1?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[6][1]){
         echo $pay1;
       }
        ?>
            </td>
            <!-- <td><?=number_format($payAmount[6][3])?>원
       <input type="hidden" name="amount" value="<?=$payAmount[6][3]?>">
       <input type="hidden" name="month" value="<?=1?>">
       <?php
       if((int)$row[0]<=(int)$payAmount[6][1]){
         echo $pay2;
       }
        ?>
     </td> -->
            <td><?=number_format($payAmount[6][4])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[6][4]?>">
                <input type="hidden" name="month" value="<?=3?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[6][1]){
         echo $pay1;
       }
        ?>
            </td>
            <td><?=number_format($payAmount[6][5])?>원
                <input type="hidden" name="amount" value="<?=$payAmount[6][5]?>">
                <input type="hidden" name="month" value="<?=12?>">
                <?php
       if((int)$row[0]<=(int)$payAmount[6][1]){
         echo $pay1;
       }
        ?>
            </td>
        </tr>
    </table>
    <p>
        · 구매하신 상품은 구매와 동시에 선과금되며 사용 이력이 있는 경우 환불 불가합니다.<br>
        · 구매하신 상품은 하단 문의하기 게시판에 상세내용 및 결제방법, 상품해지를 신청할 수 있습니다.<br>
        · 자동결제 상품을 해지한 경우 해당 서비스 만료일까지 사용할 수 있습니다. <br>
        · 위 계약건수 초과 사용을 원할경우 하단 이메일로 연락 바랍니다. <br>
        . 계좌번호는 <b>국민 272701-04-336217 유진희(리스맨소프트)</b> 입니다. <br>
        <!-- · 결제 관련 문의는 하단 <span class='badge badge-warning'>결제문의</span> 또는 전화(031-879-8003)로 문의하시기 바랍니다.<br> -->
    </p>
</section>