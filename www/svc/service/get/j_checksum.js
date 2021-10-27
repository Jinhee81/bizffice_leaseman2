var AmountArray = [];
var amountMoney = [0,0,0];
$("#allselect").click(function(){
  let table = $('table[name=outsideTable]');
  var allCnt = $(".tbodycheckbox").length;
  amountMoney = [0,0,0];
  // console.log(allCnt);

  if($("#allselect").is(":checked")){
    for (var i = 1; i <= allCnt; i++) {
      var colpAmount = table.find("tr:eq("+i+")").find("td:eq(9)").children('label:eq(0)').text();
      var colpvAmount = table.find("tr:eq("+i+")").find("td:eq(9)").children('label:eq(1)').text();
      var colptAmount = table.find("tr:eq("+i+")").find("td:eq(10)").children('.contractAmount').text();
      colpAmount = colpAmount.replace(/,/gi,'');
      colpvAmount = colpvAmount.replace(/,/gi,'');
      colptAmount = colptAmount.replace(/,/gi,'');
      colpAmount = Number(colpAmount);
      colpvAmount = Number(colpvAmount);
      colptAmount = Number(colptAmount);
      amountMoney[0] += colpAmount;
      amountMoney[1] += colpvAmount;
      amountMoney[2] += colptAmount;
    }
    $('#ptAmountSelectCount').html(allCnt);
    $('#pAmountSelectAmount').html(amountMoney[0]);
    $('#pAmountSelectAmount').number(true);
    $('#pvAmountSelectAmount').html(amountMoney[1]);
    $('#pvAmountSelectAmount').number(true);
    $('#ptAmountSelectAmount').html(amountMoney[2]);
    $('#ptAmountSelectAmount').number(true);
    // console.log('solmi');

  } else {
    AmountArray = [];
    amountMoney = [0,0,0];
    $('#ptAmountSelectCount').html(AmountArray.length);
    $('#pAmountSelectAmount').html(amountMoney[0]);
    $('#pvAmountSelectAmount').html(amountMoney[1]);
    $('#ptAmountSelectAmount').html(amountMoney[2]);
  }

  // console.log('solmi');
//   console.log(amountMoney);
})

$(document).on('click', '.tbodycheckbox', function(){

    var AmountArrayEle = [];

    if($(this).is(":checked")){
      var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
      var currow = $(this).closest('tr');
      var colid = currow.find('td:eq(0)').children('input').val();
      var colpAmount = currow.find("td:eq(9)").children('label:eq(0)').text();
      var colpvAmount = currow.find("td:eq(9)").children('label:eq(1)').text();
      var colptAmount = currow.find("td:eq(10)").children('.contractAmount').text();
      colpAmount = colpAmount.replace(/,/gi,'');
      colpAmount = Number(colpAmount);
      colpvAmount = colpvAmount.replace(/,/gi,'');
      colpvAmount = Number(colpvAmount);
      colptAmount = colptAmount.replace(/,/gi,'');
      colptAmount = Number(colptAmount);
      AmountArrayEle.push(colid, colpAmount, colpvAmount, colptAmount);
      AmountArray.push(AmountArrayEle);
      amountMoney[0] += colpAmount;
      amountMoney[1] += colpvAmount;
      amountMoney[2] += colptAmount;

      $('#ptAmountSelectCount').html(checkedCnt);
      $('#pAmountSelectAmount').html(amountMoney[0]);
      $('#pAmountSelectAmount').number(true);
      $('#pvAmountSelectAmount').html(amountMoney[1]);
      $('#pvAmountSelectAmount').number(true);
      $('#ptAmountSelectAmount').html(amountMoney[2]);
      $('#ptAmountSelectAmount').number(true);
      // console.log(ptAmountArray);
    } else {
      var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
      var currow = $(this).closest('tr');
      var colid = currow.find('td:eq(0)').children('input').val();
      var colpAmount = currow.find("td:eq(9)").children('label:eq(0)').text();
      var colpvAmount = currow.find("td:eq(9)").children('label:eq(1)').text();
      var colptAmount = currow.find("td:eq(10)").children('span').text();
      colpAmount = colpAmount.replace(/,/gi,'');
      colpAmount = Number(colpAmount);
      colpvAmount = colpvAmount.replace(/,/gi,'');
      colpvAmount = Number(colpvAmount);
      colptAmount = colptAmount.replace(/,/gi,'');
      colptAmount = Number(colptAmount);
      var dropReady = AmountArrayEle.push(colid, colpAmount, colpvAmount, colptAmount);
      var index = AmountArray.indexOf(dropReady);
      AmountArray.splice(index, 1);
      amountMoney[0] -= colpAmount;
      amountMoney[1] -= colpvAmount;
      amountMoney[2] -= colptAmount;

      $('#ptAmountSelectCount').html(checkedCnt);
      $('#pAmountSelectAmount').html(amountMoney[0]);
      $('#pAmountSelectAmount').number(true);
      $('#pvAmountSelectAmount').html(amountMoney[1]);
      $('#pvAmountSelectAmount').number(true);
      $('#ptAmountSelectAmount').html(amountMoney[2]);
      $('#ptAmountSelectAmount').number(true);
      // console.log(ptAmountArray);
    }
    // console.log(amountMoney);
})
