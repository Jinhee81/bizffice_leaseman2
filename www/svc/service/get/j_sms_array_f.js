var smsReadyArray = [];

$("#allselect").click(function(){

  var allCnt = $(".tbodycheckbox").length;
  smsReadyArray = [];

  if($("#allselect").is(":checked")){
    for (var i = 1; i <= allCnt; i++) {
      var smsReadyArrayEle = [];
      var colOrder = Number(table.find("tr:eq("+i+")").find("td:eq(1)").text());
      var colid = Number(table.find("tr:eq("+i+")").find("td:eq(0)").children('input').val());
      var colgroup = table.find("tr:eq("+i+")").find("td:eq(10)").children('input:eq(1)').val();
      var colroom = table.find("tr:eq("+i+")").find("td:eq(10)").children('input:eq(2)').val();
      var colcustomerName = table.find("tr:eq("+i+")").find("td:eq(7)").children('input[name=name]').val();
      var colcustomerCompany = table.find("tr:eq("+i+")").find("td:eq(7)").children('input[name=companyname]').val();
      var colcustomerContact = table.find("tr:eq("+i+")").find("td:eq(8)").text();
      var colcustomerEmail = table.find("tr:eq("+i+")").find("td:eq(7)").children('input[name=email]').val();
      var colcustomerId = table.find("tr:eq("+i+")").find("td:eq(7)").children('input[name=customer_id]').val();
      var colexecutiveDate = table.find("tr:eq("+i+")").find("td:eq(2)").children().text();
      var coltaxDate = table.find("tr:eq("+i+")").find("td:eq(11)").text();
      var colamount1 = table.find("tr:eq("+i+")").find("td:eq(3)").text();
      var colamount2 = table.find("tr:eq("+i+")").find("td:eq(4)").text();
      var colamount3 = table.find("tr:eq("+i+")").find("td:eq(5)").children().text();
      var colstartDate = table.find("tr:eq("+i+")").find("td:eq(2)").children('input[name=pStartDate]').val();
      var colendDate = table.find("tr:eq("+i+")").find("td:eq(2)").children('input[name=pEndDate]').val();
      var colmonthcount = table.find("tr:eq("+i+")").find("td:eq(2)").children('input[name=monthCount]').val();

      // console.log(colOrder, colid, colgroup, colroom, colcustomerName, colcustomerContact, colexectutiveDate, coltaxDate, colamount1, colamount2,colamount3);

      smsReadyArrayEle.push({'순번':colOrder}, {'청구번호':colid}, {'그룹':colgroup}, {'방번호':colroom}, {'받는사람':colcustomerName}, {'연락처':colcustomerContact}, {'이메일':colcustomerEmail}, {'납부일':colexecutiveDate}, {'증빙일':coltaxDate}, {'공급가액':colamount1}, {'세액':colamount2}, {'합계':colamount3}, {'받는사람id':colcustomerId}, {'예정일':''}, {'시작일':colstartDate}, {'종료일':colendDate}, {'개월수':colmonthcount}, {'연체일수':''}, {'연체이자':''}, {'사업자명':colcustomerCompany});
      smsReadyArray.push(smsReadyArrayEle);

      // console.log(colOrder, colid, colgroup, colroom, colcustomerName, colcustomerContact, colexectutiveDate, coltaxDate, colamount1, colamount2,colamount3);

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
      var colid = Number(currow.find("td:eq(0)").children('input[name=pid]').val());
      var colgroup = currow.find("td:eq(10)").children('input:eq(1)').val();
      var colroom = currow.find("td:eq(10)").children('input:eq(2)').val();
      var colcustomerName = currow.find("td:eq(7)").children('input[name=name]').val();
      var colcustomerCompany = currow.find("td:eq(7)").children('input[name=companyname]').val();
      var colcustomerContact = currow.find("td:eq(8)").text();
      var colcustomerEmail = currow.find("td:eq(7)").children('input[name=email]').val();
      var colcustomerId = currow.find("td:eq(7)").children('input[name=customer_id]').val();
      var colexecutiveDate = currow.find("td:eq(2)").children().text();
      var coltaxDate = currow.find("td:eq(11)").text();
      var colamount1 = currow.find("td:eq(3)").text();
      var colamount2 = currow.find("td:eq(4)").text();
      var colamount3 = currow.find("td:eq(5)").children().text();
      var colstartDate = currow.find("td:eq(2)").children('input[name=pStartDate]').val();
      var colendDate = currow.find("td:eq(2)").children('input[name=pEndDate]').val();
      var colmonthcount = currow.find("td:eq(2)").children('input[name=monthCount]').val();
      smsReadyArrayEle.push({'순번':colOrder}, {'청구번호':colid}, {'그룹':colgroup}, {'방번호':colroom}, {'받는사람':colcustomerName}, {'연락처':colcustomerContact}, {'이메일':colcustomerEmail}, {'납부일':colexecutiveDate}, {'증빙일':coltaxDate}, {'공급가액':colamount1}, {'세액':colamount2}, {'합계':colamount3}, {'받는사람id':colcustomerId},{'예정일':''}, {'시작일':colstartDate}, {'종료일':colendDate}, {'개월수':colmonthcount}, {'연체일수':''}, {'연체이자':''}, {'사업자명':colcustomerCompany});

      smsReadyArray.push(smsReadyArrayEle);
    } else {

      var currow = $(this).closest('tr');
      var colOrder = Number(currow.find('td:eq(1)').text());
      // Number(currow.find("td:eq(0)").children('input').val());
      // console.log(colOrder);


      for (var i = 0; i < smsReadyArray.length; i++) {
        if(smsReadyArray[i][0]['순번']===colOrder){
          // console.log(smsReadyArray[i][0]['순번'])
          var index = i;
          break;
        }
      }

      smsReadyArray.splice(index, 1);
      // console.log(index);
      // console.log(smsReadyArray);
    }

console.log(smsReadyArray);

})
