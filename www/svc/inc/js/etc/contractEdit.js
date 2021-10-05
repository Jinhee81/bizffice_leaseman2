// var step = '<?=$step?>';
// var customerId = <?=$row[1]?>;
var tbl = $("table[name=tableAmount]");


//
// $(document).ready(function(){
//
//   $(function () {
//       $('[data-toggle="tooltip"]').tooltip()
//   })
//
//   $('input[name=expecteDay]').on('click', function(){
//     $(this).select();
//   })
//
//   var allCnt = $(":checkbox:not(:first)", tbl).length;
//
//   $(".amountNumber").click(function(){
//     $(this).select();
//   });
//
//   $("input:text[numberOnly]").number(true);
//
//   $(".numberComma").number(true);
//
  
//
//
//   // 테이블 헤더에 있는 checkbox 클릭시
//   $(":checkbox:first", tbl).change(function(){
//     if($(":checkbox:first", tbl).is(":checked")){
//       $(":checkbox", tbl).prop('checked',true);
//       $(":checkbox").parent().parent().addClass("selected");
//     } else {
//       $(":checkbox", tbl).prop('checked',false);
//       $(":checkbox").parent().parent().removeClass("selected");
//     }
//   })
//   // 헤더에 있는 체크박스외 다른 체크박스 클릭시
//   $(":checkbox:not(:first)", tbl).change(function(){
//     var allCnt = $(":checkbox:not(:first)", tbl).length;
//     if($(this).prop("checked")==true){
//       $(this).parent().parent().addClass("selected");
//       var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
//       if(allCnt==checkedCnt ){
//         $("#allselect").prop("checked", true);
//       } else {
//         $("#allselect").prop("checked", false);
//       }
//     } else {
//       $(this).parent().parent().removeClass("selected");
//       var checkedCnt = $(".tbodycheckbox").filter(":checked").length;
//       if(allCnt==checkedCnt ){
//         $("#allselect").prop("checked", true);
//       } else {
//         $("#allselect").prop("checked", false);
//       }
//     }
//   })
//
//   $('.dateType').datepicker({
//     changeMonth: true,
//     changeYear: true,
//     showButtonPanel: true,
//     currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
//     closeText: '닫기'  // 닫기 버튼 패널
//   })
//
//   $('#smsBtn').on('click', function(){
//     // var buildingkey = $('input[name=building]').val();
//     // var buildingkey = '<?=$row['building_id']?>';
//     console.log(buildingkey);
//     var recievephonenumber = '<?=$cContact?>';
//     var cname = '<?=$row[2]?>';
//
//     //문자발송번호
//     var sendphonenumber = buildingArray[buildingkey][3] + buildingArray[buildingkey][4] + buildingArray[buildingkey][5];
//     $('input[name=sendphonenumber]').val(sendphonenumber);
//
//     //문자수신번호
//     $('#recievephonenumber').text(recievephonenumber);
//     $('#mcid').val(customerId);
//     $('#mcname').text(cname);
//
//     sms_noneparase();
//   })
//
// }) //document.ready function closing}
//
//
//
// var expectedDayArray = [];
//
// $(":checkbox:first", tbl).click(function(){
//
//     var allCnt = $(":checkbox:not(:first)", tbl).length;
//     var table = tbl.find('tbody');
//     expectedDayArray = [];
//
//
//     if($(":checkbox:first", tbl).is(":checked")){
//       for (var i = 0; i < allCnt; i++) {
//         var expectedDayEle = [];
//         var rowid = i;//system order
//         var colOrder = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=order]").children('span[name=ordered]').text();//order
//         var colid = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=checkbox]").children('input[name=csId]').val();//csId
//         var colexpectDate = table.find("tr[name=contractRow]:eq("+i+")").find("td[name=detail]").find('input[name=mExpectedDate]').val();
//
//         expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
//         expectedDayArray.push(expectedDayEle);
//       }
//       // console.log(expectedDayArray);
//     } else {
//       expectedDayArray = [];
//       // console.log(expectedDayArray);
//     }
//     console.log(expectedDayArray);
// })
//
// // $('.table').on('click',$(':checkbox:not(:first).is(":checked")'),function()
//
// $(":checkbox:not(:first)",tbl).click(function(){
//   var expectedDayEle = [];
//
//   if($(this).is(":checked")){
//     var currow = $(this).closest('tr');
//     var rowid = currow.find('td[name=order]').children('input[name=rowid]').val();
//     rowid = Number(rowid);
//     var colOrder = currow.find('td[name=order]').children('span[name=ordered]').text();
//     var colid = currow.find('td[name=checkbox]').children('input[name=csId]').val();
//     var colexpectDate = currow.find('td[name=detail]').find('input[name=mExpectedDate]').val();
//     expectedDayEle.push(rowid, colOrder, colid, colexpectDate);
//     expectedDayArray.push(expectedDayEle);
//     // console.log(expectedDayArray);
//     // console.log('체크됨');
//   } else {
//     var currow = $(this).closest('tr');
//     var colOrder = currow.find('td[name=order]').children('span[name=ordered]').text();
//
//     for (var i = 0; i < expectedDayArray.length; i++) {
//       if(expectedDayArray[i][1]===colOrder){
//         var index = i;
//         break;
//       }
//     }
//
//     expectedDayArray.splice(index, 1);
//   }
//   console.log(expectedDayArray);
// })
//
// $('.table').on('keyup', '.amountNumber:input[type="text"]', function(){
//   var currow = $(this).closest('table').parent().closest('tr');
//
//   // console.log(colOrder);
//
//   var colmAmount = Number(currow.find('td[name=detail]').find('input[name=mAmount]').val());
//
//   var colmvAmount = Number(currow.find('td[name=detail]').find('input[name=mvAmount]').val());
//
//   var colmtAmount = colmAmount + colmvAmount;
//   currow.find('td[name=detail]').find('input[name=mtAmount]').val(colmtAmount);
//
//   // console.log(colmAmount, colmvAmount, colmtAmount)
//
// })
//
/

//

//
//
// $('#button7').click(function(){ //삭제버튼 클릭시
//
//     var contractScheduleArray = [];
//     var allCnt = $(":checkbox:not(:first)", tbl).length;
//     var table = tbl.find('tbody');
//     // console.log(allCnt);
//
//     if(expectedDayArray.length===0){
//       alert('한개 이상을 선택해야 삭제 가능합니다.');
//       return false;
//     }
//
//     for (var i = 0; i < expectedDayArray.length; i++) {
//
//       contractScheduleArray[i] = [];
//
//       var csId = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=csId]').val();
//
//       var csOrder = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=order]').children('span[name=ordered]').text();
//
//       var psId = table.find("tr[name=contractRow]:eq("+expectedDayArray[i][0]+")").find('td[name=checkbox]').children('input[name=payId]').val();
//
//       if(psId != '0'){
//         alert('청구번호는 '+psId+' 입니다. 청구번호가 존재하면 삭제할수 없습니다.');
//         return false;
//       }
//
//       contractScheduleArray[i].push(csId, csOrder, psId);
//     }
//     // console.log(contractScheduleArray);
//
//     var selectedOrderArray = [];
//     for (var i = 0; i < expectedDayArray.length; i++) {
//       selectedOrderArray.push(Number(expectedDayArray[i][1]));
//     }
//     selectedOrderArray.sort(function(a,b) {
//       return a-b;
//     }); //선택한순번들을 오름차순으로 정렬해주는것
//     // console.log(selectedOrderArray);
//
//     var regularOrderArray=[];
//     for (var i = 0; i < contractScheduleArray.length; i++) {
//       var ele = allCnt - i;
//       regularOrderArray.push(ele);
//     }
//     regularOrderArray.sort(function(a,b) {
//       return a-b;
//     }); //정해진순번들을 오름차순으로 정렬해주는것
//     // console.log(regularOrderArray);
//
//     if(!selectedOrderArray.includes(allCnt)){
//       console.log(selectedOrderArray);
//       console.log(allCnt);
//       alert('스케줄 중간을 삭제할 수 없습니다.');
//       return false;
//     }
//
//     if(selectedOrderArray.includes(1)){
//       alert('순번1은 삭제할 수 없습니다. 1개이상의 스케쥴은 존재해야 합니다.');
//       return false;
//     }
//
//     for (var i = 0; i < regularOrderArray.length; i++) {
//       if(!((regularOrderArray[i]-selectedOrderArray[i])===0)){
//         alert('스케줄은 순차적으로 삭제되어야 합니다.');
//         return false;
//       }
//     }
//
//     var contractScheduleIdArray = [];
//     for (var i = 0; i < contractScheduleArray.length; i++) {
//       contractScheduleIdArray.push(contractScheduleArray[i][0]);
//     }
//
//     // console.log(contractScheduleIdArray);
//
//     var aa = 'contractScheduleDrop';
//     var bb = 'p_contractScheduleDrop.php';
//     var contractId = '<?=$filtered_id?>';
//
//     goCategoryPage(aa, bb, contractId, contractScheduleIdArray);
//
//     function goCategoryPage(a, b, c, d){
//       var frm = formCreate(a, 'post', b,'');
//       frm = formInput(frm, 'contractId', c);
//       frm = formInput(frm, 'contractScheduleIdArray', d);
//       formSubmit(frm);
//     }
//
//
// }) //삭제버튼 클릭시
//

//

//
// $("button[name='fileDelete']").click(function(){
//     var fileid = $(this).parent().parent().children().children('input:eq(0)').val();
//
//     // console.log('메모삭제', memoid);
//
//     var contractId = '<?=$filtered_id?>';
//     var aa = 'fileDelete';
//     var bb = 'p_fileDelete.php';
//     //
//     goCategoryPage(aa,bb,contractId,fileid);
//
//     function goCategoryPage(a,b,c,d){
//         var frm = formCreate(a, 'post', b,'');
//         frm = formInput(frm, 'contractId', c);
//         frm = formInput(frm, 'fileid', d);
//         formSubmit(frm);
//     }
// });
//
//
// $("button[name='contractDelete']").on('click', function(){
//   var contractId = '<?=$filtered_id?>';
//   var memocount = '<?=count($memoRows)?>';
//   var filecount = '<?=count($fileRows)?>';
//
//   if(step==='청구'){
//     alert('청구정보를 삭제해야 계약삭제 가능합니다.체크박스 선택 후 청구취소버튼을 누르세요.');
//     return false;
//   }
//
//   if(step==='입금'){
//     alert('입금정보를 삭제해야 계약삭제 가능합니다.체크박스 선택 후 입금취소버튼을 누르세요.');
//     return false;
//   }
//
//   if(Number(memocount)>0){
//     alert('메모를 삭제해야 계약삭제 가능합니다.');
//     return false;
//   }
//
//   if(Number(filecount)>0){
//     alert('파일을 삭제해야 계약삭제 가능합니다.');
//     return false;
//   }
//
//   var aa = 'contractDelete';
//   var bb = 'p_realContract_delete.php';
//
//   var deleteCheck = confirm('정말 삭제하겠습니까?');
//   if(deleteCheck){
//     goCategoryPage(aa,bb,contractId);
//
//     function goCategoryPage(a,b,c){
//       var frm = formCreate(a, 'post', b,'');
//       frm = formInput(frm, 'contractId', c);
//       formSubmit(frm);
//     }
//   }
// })//메모개수와 파일개수가 0이어야 삭제가 됨
//
// 
//

//
// 
//





//
// $(document).on('click', '#buttonm2', function(){//n개월 추가모달에서 청구설정하는거
//
//   var allCnt = $(":checkbox:not(:first)", tbl).length;
//   var addMonth = Number($("input[name='addMonth']").val());
//
//   if(!addMonth){
//     alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
//     return false;
//   }
//
//   if(Number(addMonth)+allCnt > 72){
//       alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
//       return false;
//   }
//
//   var contractId = '<?=$filtered_id?>';
//   var buildingId = $('input[name=building]').val();
//   var changeAmount1 = $("input[name='modalAmount1']").val()
//   var changeAmount2 = $("input[name='modalAmount2']").val()
//   var changeAmount3 = $("input[name='modalAmount3']").val()
//   var expectedDate = $('#mpExpectedDate2').val();
//   var payKind = $('#executiveDiv2').val();
//
//   goCategoryPage(contractId,addMonth,changeAmount1,changeAmount2,changeAmount3, expectedDate, payKind, buildingId);
//
//   function goCategoryPage(a,b,c,d,e,f,g,h){
//       var frm = formCreate('cspsAppendM', 'post', 'p_payScheduleAdd2.php','');
//       frm = formInput(frm, 'contractId', a);
//       frm = formInput(frm, 'addMonth', b);
//       frm = formInput(frm, 'changeAmount1', c);
//       frm = formInput(frm, 'changeAmount2', d);
//       frm = formInput(frm, 'changeAmount3', e);
//       frm = formInput(frm, 'expectedDate', f);
//       frm = formInput(frm, 'payKind', g);
//       frm = formInput(frm, 'buildingId', h);
//       formSubmit(frm);
//   }
//
// })
//
// $(document).on('click', '#buttonm1', function(){//n개월 추가모달에서 입금완료 하는거
//
//   var allCnt = $(":checkbox:not(:first)", tbl).length;
//   var addMonth = Number($("input[name='addMonth']").val());
//
//   if(!addMonth){
//     alert('추가개월수가 비어있습니다. 개월수를 입력해야 합니다.');
//     return false;
//   }
//
//   if(Number(addMonth)+allCnt > 72){
//       alert('최대계약기간은 72개월(6년)입니다. 더이상 기간연장은 불가합니다.');
//       return false;
//   }
//
//   var contractId = '<?=$filtered_id?>';
//   var buildingId = $('input[name=building]').val();
//   var changeAmount1 = $("input[name='modalAmount1']").val()
//   var changeAmount2 = $("input[name='modalAmount2']").val()
//   var changeAmount3 = $("input[name='modalAmount3']").val()
//   var expectedDate = $('#mpExpectedDate2').val();
//   var executiveDate = $('#mexecutiveDate2').val();
//   var executiveAmount = $('#mexecutiveAmount2').val();
//   var payKind = $('#executiveDiv2').val();
//
//   if(expectedDate){
//     if(!executiveDate){
//       alert('입금예정일 또는 입금완료일을 둘다 넣어주거나 아니면 둘다 넣지 않아야 합니다. 둘 중 한개만 넣으면 처리되지 않습니다.');
//       return false;
//     }
//   }
//
//   if(executiveDate){
//     if(!expectedDate){
//       alert('입금예정일 또는 입금완료일을 둘다 넣어주거나 아니면 둘다 넣지 않아야 합니다. 둘 중 한개만 넣으면 처리되지 않습니다.');
//       return false;
//     }
//   }
//
//   goCategoryPage(contractId,addMonth,changeAmount1,changeAmount2,changeAmount3, expectedDate, payKind, buildingId, executiveDate, executiveAmount);
//
//   function goCategoryPage(a,b,c,d,e,f,g,h,i,j){
//       var frm = formCreate('cspsAmountInputM', 'post', 'p_payScheduleGetAmountInputFor2.php','');
//       frm = formInput(frm, 'contractId', a);
//       frm = formInput(frm, 'addMonth', b);
//       frm = formInput(frm, 'changeAmount1', c);
//       frm = formInput(frm, 'changeAmount2', d);
//       frm = formInput(frm, 'changeAmount3', e);
//       frm = formInput(frm, 'expectedDate', f);
//       frm = formInput(frm, 'payKind', g);
//       frm = formInput(frm, 'buildingId', h);
//       frm = formInput(frm, 'executiveDate', i);
//       frm = formInput(frm, 'executiveAmount', j);
//       formSubmit(frm);
//   }
//
// })
//

//
// function taxInfo2(bid,mun,ccid) {
//   var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
//   $("body").append(tmps);
//   //alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );
//
//   $("#ifm_pops_21").attr("src","/svc/service/get/tax_invoice.php?building_idx="+bid+"&mun="+mun+"&id="+ccid+"&flag=expected");
//   $('#ifm_pops_21').show();
//   $('.pops_wrap, .pops_21').show();
//
// }
//
// $('.taxDate').on('click', function(){
//   var mun = $(this).siblings('input[name=taxMun]').val();
//   var bid = $(this).siblings('input[name=buildingId]').val();
//   var cid = $(this).siblings('input[name=customerId]').val();
//
//   // console.log(mun, bid, cid);
//
//   taxInfo2(bid, mun, cid);
// })
//
// $('#enddate3btn').on('click', function(){
//   var contractId = '<?=$filtered_id?>';
//   var original_enddate = '<?=$row['endDate2']?>';
//   var startDate = '<?=$row['startDate']?>';
//   var enddate3 = $('#enddate3').val();
//
//   original_enddate = new Date(original_enddate);
//   startDate = new Date(startDate);
//   enddate3 = new Date(enddate3);
//
//   // console.log(original_enddate, startDate, enddate3);
//
//   if(step != '입금'){
//     alert('현재 단계가 '+step+' 상태여서 중간종료처리를 할 필요가 없어요. 계약기간 등을 수정하면 됩니다.');
//     return false;
//   }
//
//   if(original_enddate === enddate3){
//     alert('종료일과 같으면 중간종료가 아닙니다. 중간종료일을 다시 확인하세요');
//     return false;
//   }
//
//   if(enddate3 <= startDate){
//     alert('시작일보다 작거나 같으면 중간종료가 아닙니다. 날짜를 다시 확인해주세요.');
//     return false;
//   }
//
//   if(enddate3 >= original_enddate){
//     alert('종료일보다 크거나 같으면 중간종료가 아닙니다. 날짜를 다시 확인해주세요.');
//     return false;
//   }
//
//   enddate3 = $('#enddate3').val();;
//
//   goCategoryPage(contractId, enddate3);
//
//   function goCategoryPage(a,b){
//     var frm = formCreate('contractMiddleEnd', 'post', 'p_realContract_middle_end.php', '');
//     frm = formInput(frm, 'contractId', a);
//     frm = formInput(frm, 'enddate3', b);
//     formSubmit(frm);
//   }
//
// })
//
// $('button[name=middleEndCansel]').on('click', function(){
//   var contractId = '<?=$filtered_id?>';
//
//   goCategoryPage(contractId);
//
//   function goCategoryPage(a){
//     var frm = formCreate('contractMiddleEndCansel', 'post', 'p_realContract_middle_end_cansel.php', '');
//     frm = formInput(frm, 'contractId', a);
//     formSubmit(frm);
//   }
// })
//
// autosize($('textarea[name=memoContent]'));
//

