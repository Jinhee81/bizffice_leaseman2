var smsReadyArray = [];

$("#allselect").click(function(){

  var allCnt = $(".tbodycheckbox").length;
  let table = $('#outsideTable');
  smsReadyArray = [];

  if($(this).is(":checked")){
    for (var i = 1; i <= allCnt; i++) {
      var smsReadyArrayEle = [];
      var colOrder = Number(table.find("tr:eq("+i+")").find("td:eq(1)").text());
      var colid = Number(table.find("tr:eq("+i+")").find("td:eq(0)").children('input').val());//계약번호
      var colgroup = table.find("tr:eq("+i+")").find("td:eq(6)").text();
      var colroom = table.find("tr:eq("+i+")").find("td:eq(7)").text();
      var colcustomerName = table.find("tr:eq("+i+")").find("td:eq(3)").children('input[name=customername]').val();//성명
      var colcustomerCompany = table.find("tr:eq("+i+")").find("td:eq(3)").children('input[name=customercompanyname]').val();//사업자명
      var colcustomerContact = table.find("tr:eq("+i+")").find("td:eq(4)").children('a').text();
      var colcustomerEmail = table.find("tr:eq("+i+")").find("td:eq(3)").children('input[name=email]').val();
      var colcustomerId = table.find("tr:eq("+i+")").find("td:eq(3)").children('input[name=customerId]').val();
      var colexecutiveDate = "";
      var coltaxDate = "";
      var colamount1 = table.find("tr:eq("+i+")").find("td:eq(11)").children('input[name=mAmount]').val();
      var colamount2 = table.find("tr:eq("+i+")").find("td:eq(11)").children('input[name=mvAmount]').val();
      var colamount3 = table.find("tr:eq("+i+")").find("td:eq(11)").children('a').text();
      var colexpectedDate = "";
      var colstartDate = table.find("tr:eq("+i+")").find("td:eq(8)").text();
      var colendDate = table.find("tr:eq("+i+")").find("td:eq(9)").text();
      var colmonthcount = table.find("td[name=period]").find('u').text();
      var coldelaydays = "";
      var coldelayinterest = "";

      // console.log(colOrder, colid, colgroup, colroom, colcustomerName, colcustomerContact, colexectutiveDate, coltaxDate, colamount1, colamount2,colamount3);

      smsReadyArrayEle.push({'순번':colOrder}, {'청구번호':''}, {'그룹':colgroup}, {'방번호':colroom}, {'받는사람':colcustomerName}, {'연락처':colcustomerContact}, {'이메일':colcustomerEmail}, {'납부일':''}, {'증빙일':''}, {'공급가액':colamount1}, {'세액':colamount2}, {'합계':colamount3}, {'받는사람id':colcustomerId}, {'예정일':''}, {'시작일':colstartDate}, {'종료일':colendDate}, {'개월수':colmonthcount}, {'연체일수':''}, {'연체이자':''}, {'사업자명':colcustomerCompany}, {'계약번호':colid});
      smsReadyArray.push(smsReadyArrayEle);
    }
  } else {
    smsReadyArray = [];
  }
  console.log(smsReadyArray);
})

$(document).on('click', '.tbodycheckbox', function(){
var smsReadyArrayEle = [];

    if($(this).is(":checked")){
      var currow = $(this).closest('tr');
      var colOrder = Number(currow.find('td:eq(1)').text());
      var colid = Number(currow.find("td:eq(0)").children('input').val());
      var colgroup = currow.find("td:eq(6)").text();
      var colroom = currow.find("td:eq(7)").text();
      var colcustomerName = currow.find("td:eq(3)").children('input[name=customername]').val();//성명
      var colcustomerCompany = currow.find("td:eq(3)").children('input[name=customercompanyname]').val();//사업자명
      var colcustomerContact = currow.find("td:eq(4)").children('a').text();
      var colcustomerEmail = currow.find("td:eq(3)").children('input[name=email]').val();
      var colcustomerId = currow.find("td:eq(3)").children('input[name=customerId]').val();
      var colexecutiveDate = "";
      var coltaxDate = "";
      var colamount1 = currow.find("td:eq(11)").children('input[name=mAmount]').val();
      var colamount2 = currow.find("td:eq(11)").children('input[name=mvAmount]').val();
      var colamount3 = currow.find("td:eq(11)").children('a').text();
      var colexpectedDate = "";
      var colstartDate = currow.find("td:eq(8)").text();
      var colendDate = currow.find("td:eq(9)").text();
      var colmonthcount = currow.find("td[name=period]").find('u').text();
      var coldelaydays = "";
      var coldelayinterest = "";
      smsReadyArrayEle.push({'순번':colOrder}, {'청구번호':''}, {'그룹':colgroup}, {'방번호':colroom}, {'받는사람':colcustomerName}, {'연락처':colcustomerContact}, {'이메일':colcustomerEmail}, {'납부일':colexecutiveDate}, {'증빙일':coltaxDate}, {'공급가액':colamount1}, {'세액':colamount2}, {'합계':colamount3}, {'받는사람id':colcustomerId}, {'예정일':colexpectedDate}, {'시작일':colstartDate}, {'종료일':colendDate}, {'개월수':colmonthcount}, {'연체일수':coldelaydays}, {'연체이자':coldelayinterest}, {'사업자명':colcustomerCompany}, {'계약번호':colid});
      smsReadyArray.push(smsReadyArrayEle);
      // console.log('smsReadyArray :',smsReadyArray);
    } else {
      var currow = $(this).closest('tr');
      var colOrder = Number(currow.find('td:eq(1)').text());
      // Number(currow.find("td:eq(0)").children('input').val());
      // console.log(colOrder);


      for (var i = 0; i < smsReadyArray.length; i++) {
        if(smsReadyArray[i][0]['순번']===colOrder){
          var index = i;
          break;
        }
      }
      // console.log(index);
      smsReadyArray.splice(index, 1);
    }
console.log(smsReadyArray);
})
