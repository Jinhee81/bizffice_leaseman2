var d = new Date();
var today = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate();

var todayMonthFirst = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + '1';
var todayMonthLastDate = new Date(d.getFullYear(), (d.getMonth()+1), 0);
var todayMonthLastDate1 = todayMonthLastDate.getDate();
var todayMonthLast = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + todayMonthLastDate1;

// if(d.getMonth()===0){
//   var lastMonthFirst = d.getFullYear()-1 + '-' + '12' + '-' + '01';
//   var lastMonthLast = d.getFullYear()-1 + '-' + '12' + '-' + '31';
//   var last1monthdate = d.getFullYear()-1 + '-' + '12' + '-' + d.getDate();
// } else {
//   var lastMonthFirst = d.getFullYear() + '-' + d.getMonth() + '-' + '01';
//   var lastMonthLastDate = new Date(d.getFullYear(), d.getMonth(), 0);
//   var lastMonthLastDate1 = lastMonthLastDate.getDate();
//   var lastMonthLast = new Date(d.getFullYear() + '-' + d.getMonth() + '-' + lastMonthLastDate1);
//   lastMonthLast = lastMonthLast.getFullYear() + '-' + (lastMonthLast.getMonth()+1) + '-' + lastMonthLast.getDate();
//   var last1monthdate = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate();
// }
//
// if(d.getMonth()===11){
//   var nextMonthFirst = d.getFullYear()+1 + '-' + '1' + '-' + '1';
//   var nextMonthLast = d.getFullYear()+1 + '-' + '1' + '-' + '31';
// } else {
//   var nextMonthFirst = d.getFullYear() + '-' + (d.getMonth()+2) + '-' + '1';
//   var nextMonthLastDate = new Date(d.getFullYear(), (d.getMonth()+2), 0);
//   var nextMonthLastDate1 = lastMonthLastDate.getDate();
//   var nextMonthLast = new Date(d.getFullYear() + '-' + (d.getMonth()+2) + '-' + nextMonthLastDate1);
//   nextMonthLast = nextMonthLast.getFullYear() + '-' + (nextMonthLast.getMonth()+1) + '-' + nextMonthLast.getDate();
// }
// console.log(d.getMonth());

if(d.getMonth()===0){//1월일때
  var lastMonthFirst = d.getFullYear()-1 + '-' + '12' + '-' + '01';
  var lastMonthLast = d.getFullYear()-1 + '-' + '12' + '-' + '31';
  var last1monthdate = d.getFullYear()-1 + '-' + '12' + '-' + d.getDate();
  var nextMonthFirst = d.getFullYear() + '-' + '2' + '-' + '1';
  var nextMonthLast = d.getFullYear() + '-' + '2' + '-' + '28';
} else if(d.getMonth()===11) {//12월일때
  var nextMonthFirst = d.getFullYear()+1 + '-' + '1' + '-' + '1';
  var nextMonthLast = d.getFullYear()+1 + '-' + '1' + '-' + '31';
  var lastMonthFirst = d.getFullYear() + '-' + d.getMonth() + '-' + '1';
  var lastMonthLast = d.getFullYear() + '-' + d.getMonth() + '-' + '30';
} else {//2~11월일때
  var lastMonthFirst = d.getFullYear() + '-' + d.getMonth() + '-' + '1';
  var lastMonthLastDate = new Date(d.getFullYear(), d.getMonth(), 0);
  var lastMonthLastDate1 = lastMonthLastDate.getDate();
  var lastMonthLast = new Date(d.getFullYear() + '-' + d.getMonth() + '-' + lastMonthLastDate1);
  lastMonthLast = lastMonthLast.getFullYear() + '-' + (lastMonthLast.getMonth()+1) + '-' + lastMonthLast.getDate();
  var last1monthdate = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate();

  var nextMonthFirst = d.getFullYear() + '-' + (d.getMonth()+2) + '-' + '1';
  var nextMonthLastDate = new Date(d.getFullYear(), (d.getMonth()+2), 0);
  var nextMonthLastDate1 = nextMonthLastDate.getDate();
  // console.log(nextMonthLastDate, nextMonthLastDate1);
  var nextMonthLast = new Date(d.getFullYear() + '-' + (d.getMonth()+2) + '-' + nextMonthLastDate1);
  nextMonthLast = nextMonthLast.getFullYear() + '-' + (nextMonthLast.getMonth()+1) + '-' + nextMonthLast.getDate();
}

// console.log(lastMonthFirst, lastMonthLast);


var todayYearFirst = d.getFullYear() + '-1-1';
var todayYearLast = d.getFullYear() + '-12-31';

var janulast = d.getFullYear() + '-1-31';
var febfirst = d.getFullYear() + '-2-1';
var feblast = d.getFullYear() + '-2-28'; //2020년은 윤달이어서 29일로했고 내년에는 28로 변경할 예정
var marchfirst = d.getFullYear() + '-3-1';
var marchlast = d.getFullYear() + '-3-31';
var aprilfirst = d.getFullYear() + '-4-1';
var aprillast = d.getFullYear() + '-4-30';
var mayfirst = d.getFullYear() + '-5-1';
var maylast = d.getFullYear() + '-5-31';
var junefirst = d.getFullYear() + '-6-1';
var junelast = d.getFullYear() + '-6-30';
var julyfirst = d.getFullYear() + '-7-1';
var julylast = d.getFullYear() + '-7-31';
var augustfirst = d.getFullYear() + '-8-1';
var augustlast = d.getFullYear() + '-8-31';
var septemberfirst = d.getFullYear() + '-9-1';
var septemberlast = d.getFullYear() + '-9-30';
var octoberfirst = d.getFullYear() + '-10-1';
var octoberlast = d.getFullYear() + '-10-31';
var novemberfirst = d.getFullYear() + '-11-1';
var novemberlast = d.getFullYear() + '-11-30';
var decemberfirst = d.getFullYear() + '-12-1';


function dateinput2(x){ //from, to date 입력()
  if(x === 'allDate'){
    var fromdate = $('input[name="fromDate"]').val("");
    var todate = $('input[name="toDate"]').val("");
  }

  if(x === 'nowMonth'){
    var fromdate = $('input[name="fromDate"]').val(todayMonthFirst);
    var todate = $('input[name="toDate"]').val(todayMonthLast);
  }

  if(x === 'pastMonth'){ //기간이 전월일 때
    var fromdate = $('input[name="fromDate"]').val(lastMonthFirst);
    var todate = $('input[name="toDate"]').val(lastMonthLast);
  }

  if(x === '1pastMonth'){ //기간이 1개월전일때
    var fromdate = $('input[name="fromDate"]').val(last1monthdate);
    var todate = $('input[name="toDate"]').val(today);
  }

  if(x === 'nownextMonth'){ //기간이 당월익월일때
    var fromdate = $('input[name="fromDate"]').val(todayMonthFirst);
    var todate = $('input[name="toDate"]').val(nextMonthLast);
  }

  if(x === 'nextMonth'){ //기간이 익월일 때
    var fromdate = $('input[name="fromDate"]').val(nextMonthFirst);
    var todate = $('input[name="toDate"]').val(nextMonthLast);

    // console.log(nextMonthFirst, nextMonthLast);
  }

  if(x === 'nowYear'){
    var fromdate = $('input[name="fromDate"]').val(todayYearFirst);
    var todate = $('input[name="toDate"]').val(todayYearLast);
  }

  if(x === 'today'){
    $('input[name="fromDate"]').val(today);
    $('input[name="toDate"]').val(today);
  }

  if(x === 'untilNowMonth'){
    var fromdate = $('input[name="fromDate"]').val('');
    var todate = $('input[name="toDate"]').val(todayMonthLast);
  }

  if(x === 'janu'){
    var fromdate = $('input[name="fromDate"]').val(todayYearFirst);
    var todate = $('input[name="toDate"]').val(janulast);
  }
  if(x === 'feb'){
    var fromdate = $('input[name="fromDate"]').val(febfirst);
    var todate = $('input[name="toDate"]').val(feblast);
  }
  if(x === 'march'){
    var fromdate = $('input[name="fromDate"]').val(marchfirst);
    var todate = $('input[name="toDate"]').val(marchlast);
  }
  if(x === 'april'){
    var fromdate = $('input[name="fromDate"]').val(aprilfirst);
    var todate = $('input[name="toDate"]').val(aprillast);
  }
  if(x === 'may'){
    var fromdate = $('input[name="fromDate"]').val(mayfirst);
    var todate = $('input[name="toDate"]').val(maylast);
  }
  if(x === 'june'){
    var fromdate = $('input[name="fromDate"]').val(junefirst);
    var todate = $('input[name="toDate"]').val(junelast);
  }
  if(x === 'july'){
    var fromdate = $('input[name="fromDate"]').val(julyfirst);
    var todate = $('input[name="toDate"]').val(julylast);
  }
  if(x === 'august'){
    var fromdate = $('input[name="fromDate"]').val(augustfirst);
    var todate = $('input[name="toDate"]').val(augustlast);
  }
  if(x === 'september'){
    var fromdate = $('input[name="fromDate"]').val(septemberfirst);
    var todate = $('input[name="toDate"]').val(septemberlast);
  }
  if(x === 'october'){
    var fromdate = $('input[name="fromDate"]').val(octoberfirst);
    var todate = $('input[name="toDate"]').val(octoberlast);
  }
  if(x === 'november'){
    var fromdate = $('input[name="fromDate"]').val(novemberfirst);
    var todate = $('input[name="toDate"]').val(novemberlast);
  }
  if(x === 'december'){
    var fromdate = $('input[name="fromDate"]').val(decemberfirst);
    var todate = $('input[name="toDate"]').val(decemberlast);
  }

  if(x === '1quater'){
    var fromdate = $('input[name="fromDate"]').val(todayYearFirst);
    var todate = $('input[name="toDate"]').val(marchlast);
  }
  if(x === '2quater'){
    var fromdate = $('input[name="fromDate"]').val(aprilfirst);
    var todate = $('input[name="toDate"]').val(junelast);
  }
  if(x === '3quater'){
    var fromdate = $('input[name="fromDate"]').val(julyfirst);
    var todate = $('input[name="toDate"]').val(septemberlast);
  }
  if(x === '4quater'){
    var fromdate = $('input[name="fromDate"]').val(octoberfirst);
    var todate = $('input[name="toDate"]').val(todayYearLast);
  }
  if(x === 'sangbangi'){
    var fromdate = $('input[name="fromDate"]').val(todayYearFirst);
    var todate = $('input[name="toDate"]').val(junelast);
  }
  if(x === 'habangi'){
    var fromdate = $('input[name="fromDate"]').val(julyfirst);
    var todate = $('input[name="toDate"]').val(todayYearLast);
  }

  return fromdate, todate;
}
