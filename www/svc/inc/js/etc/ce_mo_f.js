//contractEdit.php file, modal load function acronym

$(document).on('click', '.modalpay', function(){ //청구번호클릭하는거(모달클릭)
  $('#pPay').modal('show');
  // console.log('minsun');
  
  var payNumber = $(this).text();
  var expectedAmount = $(this).parent().siblings('input[name=ptAmount]:hidden').val();
  var expectedDate = $(this).parent().siblings('input[name=pExpectedDate]:hidden').val();
  var executiveDiv = $(this).parent().siblings('input[name=payKind]:hidden').val();//입금구분 계좌,현금,카드
  var executiveDate = $(this).parent().siblings('input[name=executiveDate]:hidden').val();//입금일
  var executiveAmount = $(this).parent().siblings('input[name=getAmount]:hidden').val();//입금액
  var payDiv = $(this).parent().siblings('span[name=payDiv]').text();//완납, 완납연체, 미납, 입금대기, 엄청중요한 변수
  var taxMun = $(this).parent().siblings('input[name=taxMun]').val();
  // alert(taxMun);

  console.log(payNumber, expectedAmount, expectedDate, executiveAmount, payDiv, taxMun);

  var footer1 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mpayBack' class='btn btn-warning btn-sm mr-0'>청구취소</button><button type='button' id='mgetExecute' class='btn btn-primary btn-sm'>입금완료</button>";//입금대기이고 증빙이 없을때
  var footer11 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mpayBack' class='btn btn-warning btn-sm mr-0' disabled>청구취소</button><button type='button' id='mgetExecute' class='btn btn-primary btn-sm'>입금완료</button>";//입금대기이고 증빙있을때
  var footer2 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mModify' class='btn btn-warning btn-sm mr-0'>수정</button><button type='button' id='mExecuteBack' class='btn btn-warning btn-sm mr-0'>입금취소</button>";//입금완료이고 증빙일자 없을때
  var footer22 = "<button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button><button type='button' id='mExecuteBack' class='btn btn-warning btn-sm mr-0' disabled>입금취소</button>";//입금완료이고 증빙일자 있을때

  // console.log(expectedAmount, expectedDate, executiveDiv, executiveDate, executiveAmount);

  $('#payId').text(payNumber);
  $('#expectedAmount').val(expectedAmount);
  $('#expectedDate').val(expectedDate);
  if(executiveDiv==='계좌'){
    $('#executiveDiv').val('계좌').prop('selected', true);
  } else if(executiveDiv==='현금'){
    $('#executiveDiv').val('현금').prop('selected', true);
  } else if(executiveDiv==='카드'){
    $('#executiveDiv').val('카드').prop('selected', true);
  }

  if(payDiv==='완납' || payDiv==='완납(연체)'){

    $('#expectedDate').val(expectedDate).prop('disabled', true);
    $('#expectedAmount').val(expectedAmount).prop('disabled', true);
    // $('#executiveDiv').val(executiveDiv).prop('disabled', true);
    // $('#executiveDate').val(executiveDate).prop('disabled', true);
    $('#executiveAmount').val(expectedAmount).prop('disabled', true);//하다보니 입금수단과 입금일은 좀 수정을 하고싶어짐
    $('#executiveDiv').val(executiveDiv);
    $('#executiveDate').val(executiveDate);
    if(taxMun){
      $('.modal-footer').html(footer22);
    } else {
      $('.modal-footer').html(footer2);
    }
  } else if(payDiv==='입금대기' || payDiv==='미납'){
    $('#executiveDiv').prop('disabled', false);
    $('#executiveDate').val(expectedDate).prop('disabled', false);
    $('#executiveAmount').val(expectedAmount).prop('disabled', false);
    if(taxMun){
      $('.modal-footer').html(footer11);
    } else {
      $('.modal-footer').html(footer1);
    }
  }

}) //청구번호클릭하는거(모달클릭) closing}


