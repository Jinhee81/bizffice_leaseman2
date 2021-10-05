<?php

$coinAmount = array(
                array(10000, 30000, 50000, 100000),
                array(0,0.03, 0.05, 0.1)
              );


//date_default_timezone_set('Asia/Seoul');
$currentDate = date('Y-m-d');

?>

<style media="screen">
  /* .fas {
    color:yellow;
  } */
</style>

<section class="container">
  <div class="jumbotron">
    <h1 class="display-4">코인구매입니다</h1>
    <p class="lead">
    코인을 충전하여 문자메시지를 발송하거나 리스맨에서 바로 전자세금계산서를 발행하세요 ^__^
    <hr class="my-4">
    <small>
      (1)문자메시지 (단문 30코인, 장문 90코인) 및 전자세금계산서 (120코인) 건당 차감됩니다.<br>
      (2)구매하신 코인은 구매일로부터 5년간 유효합니다.<br>
      (3)구매하신 코인은 구매와 동시에 선과금되며 사용된 코인은 환불 불가합니다.<br>
    </small>
  </div>
</section>

<section class="container" style="max-width:1000px;">
  <table class="table table-bordered text-center">
    <tr>
      <th>충전금액</th>
      <th>보너스코인</th>
      <th>적립코인</th>
      <th>구매하기</th>
    </tr>
    <tr>
      <td><?=number_format($coinAmount[0][0])?>원
        <input type="hidden" name="coinamount" value="<?=$coinAmount[0][0]?>">
      </td>
      <td><?=number_format($coinAmount[0][0]*$coinAmount[1][0])?>코인</td>
      <td><?=number_format($coinAmount[0][0]+($coinAmount[0][0]*$coinAmount[1][0]))?>코인</td>
      <td><?=$pay3?></td>
    </tr>
    <tr>
      <td><?=number_format($coinAmount[0][1])?>원
        <input type="hidden" name="coinamount" value="<?=$coinAmount[0][1]?>">
      </td>
      <td><?=number_format($coinAmount[0][1]*$coinAmount[1][1])?>코인(3% <span class="badge badge-pill badge-warning">보너스</span>)</td>
      <td><?=number_format($coinAmount[0][1]+($coinAmount[0][1]*$coinAmount[1][1]))?>코인</td>
      <td><?=$pay3?></td>
    </tr>
    <tr>
      <td><?=number_format($coinAmount[0][2])?>원
        <input type="hidden" name="coinamount" value="<?=$coinAmount[0][2]?>">
      </td>
      <td><?=number_format($coinAmount[0][2]*$coinAmount[1][2])?>코인(5% <span class="badge badge-pill badge-warning">보너스</span>)</td>
      <td><?=number_format($coinAmount[0][2]+($coinAmount[0][2]*$coinAmount[1][2]))?>코인</td>
      <td><?=$pay3?></td>
    </tr>
    <tr>
      <td><?=number_format($coinAmount[0][3])?>원
        <input type="hidden" name="coinamount" value="<?=$coinAmount[0][3]?>">
      </td>
      <td><?=number_format($coinAmount[0][3]*$coinAmount[1][3])?>코인(10% <span class="badge badge-pill badge-warning">보너스</span>)</td>
      <td><?=number_format($coinAmount[0][3]+($coinAmount[0][3]*$coinAmount[1][3]))?>코인</td>
      <td><?=$pay3?></td>
    </tr>
  </table>
</section>

<script>

//숫자에 콤마 넣음
Number.prototype.format = function(){
    if(this==0) return 0;

    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');

    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

    return n;
};

//문자를 숫자형태로 바꿔서 콤마 넣음
String.prototype.format = function(){
    var num = parseFloat(this);
    if( isNaN(num) ) return "0";

    return num.format();
};

function goCategoryPage(a, b, c, d, e, f){
  var frm = formCreate('gradeAdd', 'post', 'p_gradeAdd.php','');
  frm = formInput(frm, 'paydiv', a);
  frm = formInput(frm, 'today', b);
  frm = formInput(frm, 'month1later', c);
  frm = formInput(frm, 'year1later', d);
  frm = formInput(frm, 'amount', e);
  frm = formInput(frm, 'gradename', f);
  formSubmit(frm);
}

</script>
