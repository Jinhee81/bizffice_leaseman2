// 계약리스트파일에서 체크썸 파일


var AmountArray = [];
var amountMoney = [0,0];
var table = $('#checkboxTestTbl');

$("#allselect").click(function(){

  var allCnt = $(".tbodycheckbox").length;
  amountMoney = [0,0];
  console.log(allCnt);

  if($("#allselect").is(":checked")){
    for (var i = 1; i <= allCnt; i++) {
      var colmonth = table.find("tr:eq("+i+")").find("td:eq(11)").children('a').text();
      var coldeposit = table.find("tr:eq("+i+")").find("td:eq(12)").children().text();
      colmonth = colmonth.replace(/,/gi,'');
      coldeposit = coldeposit.replace(/,/gi,'');
      console.log(colmonth, coldeposit);
      colmonth = Number(colmonth);
      coldeposit = Number(coldeposit);
      amountMoney[0] += colmonth;
      amountMoney[1] += coldeposit;
    }
    $('#countchecked').html(allCnt);
    $('#aa1').html(amountMoney[0]);
    $('#aa1').number(true);
    $('#bb1').html(amountMoney[1]);
    $('#bb1').number(true);
    console.log('solmi');

  } else {
    AmountArray = [];
    amountMoney = [0,0];
    $('#countchecked').html(AmountArray.length);
    $('#aa1').html(amountMoney[0]);
    $('#bb1').html(amountMoney[1]);

    console.log('minsun');
  }

  // console.log('solmi');
  // console.log(ptAmountArray);
})

$(document).on('click', '.tbodycheckbox', function(){
    var AmountArrayEle = [];

    if($(this).is(":checked")){
      var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
      var currow = $(this).closest('tr');
      var colid = currow.find('td:eq(0)').children('input').val();
      var colmonth = currow.find("td:eq(11)").children('a').text();
      var coldeposit = currow.find("td:eq(12)").children().text();
      colmonth = colmonth.replace(/,/gi,'');
      colmonth = Number(colmonth);
      coldeposit = coldeposit.replace(/,/gi,'');
      coldeposit = Number(coldeposit);
      AmountArrayEle.push(colid, colmonth, coldeposit);
      AmountArray.push(AmountArrayEle);
      amountMoney[0] += colmonth;
      amountMoney[1] += coldeposit;

      $('#countchecked').html(checkedCnt);
      $('#aa1').html(amountMoney[0]);
      $('#aa1').number(true);
      $('#bb1').html(amountMoney[1]);
      $('#bb1').number(true);
      // console.log(ptAmountArray);
    } else {
      var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
      var currow = $(this).closest('tr');
      var colid = currow.find('td:eq(0)').children('input').val();
      var colmonth = currow.find("td:eq(11)").children('a').text();
      var coldeposit = currow.find("td:eq(12)").children().text();
      colmonth = colmonth.replace(/,/gi,'');
      colmonth = Number(colmonth);
      coldeposit = coldeposit.replace(/,/gi,'');
      coldeposit = Number(coldeposit);
      var dropReady = AmountArrayEle.push(colid, colmonth, coldeposit);
      var index = AmountArray.indexOf(dropReady);
      AmountArray.splice(index, 1);
      amountMoney[0] -= colmonth;
      amountMoney[1] -= coldeposit;

      $('#countchecked').html(checkedCnt);
      $('#aa1').html(amountMoney[0]);
      $('#aa1').number(true);
      $('#bb1').html(amountMoney[1]);
      $('#bb1').number(true);
      // console.log(ptAmountArray);
    }
})
