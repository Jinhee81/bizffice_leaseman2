// contract detail js

var table = $('#schedule');
var AmountArray = [];
var AmountArrayEle = [];
var amountMoney = [0,0,0];

$("#allselect2").click(function(){

  var allCnt = $(".tbodycheckbox2").length;
  amountMoney = [0,0,0];
  // console.log(allCnt);

  if($(this).is(":checked")){
    for (var i = 0; i < allCnt; i++) {

      var payId = table.find("tr[name=contractRow]:eq("+i+")").find("td:eq(0)").children('input[name=payId]').val();

      if(payId==='0'||payId==='null'){//청구번호가 없으면, 인풋박스안에 value
        var amount = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('input[name=mAmount]').val();
        var vamount = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('input[name=mvAmount]').val();
        var tamount = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('input[name=mtAmount]').val();
      } else {
        var amount = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('span[name=mAmount]').text();
        var vamount = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('span[name=mvAmount]').text();
        var tamount = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('span[name=mtAmount]').text();
      }

      amount = amount.replace(/,/gi,'');
      vamount = vamount.replace(/,/gi,'');
      tamount = tamount.replace(/,/gi,'');
      amount = Number(amount);
      vamount = Number(vamount);
      tamount = Number(tamount);
      amountMoney[0] += amount;
      amountMoney[1] += vamount;
      amountMoney[2] += tamount;
    }
    $('#selectcount').html(allCnt);
    $('#selectamount').html(amountMoney[0]);
    $('#selectamount').number(true);
    $('#selectvamount').html(amountMoney[1]);
    $('#selectvamount').number(true);
    $('#selecttamount').html(amountMoney[2]);
    $('#selecttamount').number(true);
    // console.log('solmi');

  } else {
    amountMoney = [0,0,0];
    $('#selectcount').text(0);
    $('#selectamount').text(0);
    $('#selectvamount').text(0);
    $('#selecttamount').text(0);
  }

  // console.log('solmi');
  // console.log(ptAmountArray);
})

$(document).on('click', '.tbodycheckbox2', function(){

    if($(this).is(":checked")){
      var checkedCnt = $(".tbodycheckbox2").filter(":checked").length;
      var currow = $(this).closest('tr[name=contractRow]');
      var payId = currow.find('td:eq(0)').children('input[name=payId]').val();

      var amount, vamount, tamount;

      if(payId==='0' || payId==='null'){ //includes를 쓰면 이상해서 or 조건으로 변경했음
        amount = currow.find("td[name=detail]").find('input[name=mAmount]').val();
        vamount = currow.find("td[name=detail]").find('input[name=mvAmount]').val();
        tamount = currow.find("td[name=detail]").find('input[name=mtAmount]').val();
        // console.log(amount, vamount, tamount, 0, null)
      } else {
        amount = currow.find("td[name=detail]").find('span[name=mAmount]').text();
        vamount = currow.find("td[name=detail]").find('span[name=mvAmount]').text();
        tamount = currow.find("td[name=detail]").find('span[name=mtAmount]').text();
        // console.log(amount, vamount, tamount, 'payidexist')
      }

      amount = amount.replace(/,/gi,'');
      amount = Number(amount);
      vamount = vamount.replace(/,/gi,'');
      vamount = Number(vamount);
      tamount = tamount.replace(/,/gi,'');
      tamount = Number(tamount);
      AmountArrayEle.push(amount, vamount, tamount);
      AmountArray.push(AmountArrayEle);
      amountMoney[0] += amount;
      amountMoney[1] += vamount;
      amountMoney[2] += tamount;

      $('#selectcount').html(checkedCnt);
      $('#selectamount').html(amountMoney[0]);
      $('#selectamount').number(true);
      $('#selectvamount').html(amountMoney[1]);
      $('#selectvamount').number(true);
      $('#selecttamount').html(amountMoney[1]);
      $('#selecttamount').number(true);
      // console.log(ptAmountArray);
    } else {
      var checkedCnt = $(".tbodycheckbox2").filter(":checked").length;
      var currow = $(this).closest('tr');
      var payId = currow.find('td:eq(0)').children('input[name=payId]').val();
      var amount, vamount, tamount;

      if(payId==='0'){
        amount = currow.find("td[name=detail]").find('input[name=mAmount]').val();
        vamount = currow.find("td[name=detail]").find('input[name=mvAmount]').val();
        tamount = currow.find("td[name=detail]").find('input[name=mtAmount]').val();
      } else {
        amount = currow.find("td[name=detail]").find('span[name=mAmount]').text();
        vamount = currow.find("td[name=detail]").find('span[name=mvAmount]').text();
        tamount = currow.find("td[name=detail]").find('span[name=mtAmount]').text();
      }

      amount = amount.replace(/,/gi,'');
      amount = Number(amount);
      vamount = vamount.replace(/,/gi,'');
      vamount = Number(vamount);
      tamount = tamount.replace(/,/gi,'');
      tamount = Number(tamount);

      var dropReady = AmountArrayEle.push(amount, vamount, tamount);
      var index = AmountArray.indexOf(dropReady);
      AmountArray.splice(index, 1);
      amountMoney[0] -= amount;
      amountMoney[1] -= vamount;
      amountMoney[2] -= tamount;

      $('#selectcount').html(checkedCnt);
      $('#selectamount').html(amountMoney[0]);
      $('#selectamount').number(true);
      $('#selectvamount').html(amountMoney[1]);
      $('#selectvamount').number(true);
      $('#selecttamount').html(amountMoney[2]);
      $('#selecttamount').number(true);
      // console.log(ptAmountArray);
    }
})
