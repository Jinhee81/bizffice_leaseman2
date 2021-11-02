$('#smsBtn').on('click', function(){

    var buildingkey = $('select[name=building]').val();
    // console.log(buildingkey);
    var sendphonenumber = cellphone;


    $('input[name=sendphonenumber]').val(sendphonenumber);

    if(smsReadyArray.length===0){
      alert('1개 이상을 선택해야 문자메시지 보내기가 가능합니다.');
      return false;
    }

    var smsTitle = $('#smsTitle :selected').val();
    if(smsTitle==='상용구없음'){
      $(this).attr('data-target','#smsModal1');
    } else {
      $(this).attr('data-target','#smsModal2');
    }

    // console.log(smsReadyArray);

    if(smsTitle==='상용구없음'){
      sms_noneparase();
    } else { //if(smsTitle==='상용구없음') end, else start
      sms_existparase();
    } //if(smsTitle==='상용구없음') else end}

}) //smsBtn function closing

// function taxInfo(idx,mun) {

//     var tmps = "<iframe name='ifm_pops_21' id='ifm_pops_21' class='popup_iframe'   scrolling='no' src=''></iframe>";
// 	$("body").append(tmps);
// 	//alert( "/inc/tax_invoice2.php?chkId="+chkId+"&callnum="+subIdx );

// 	$("#ifm_pops_21").attr("src","/svc/service/get/tax_invoice.php?building_idx="+$('#building').val()+"&mun="+mun+"&id="+idx);
// 	$('#ifm_pops_21').show();
// 	$('.pops_wrap, .pops_21').show();

// }



$('#btnTaxDateInput').on('click', function(){

  var taxSelect = '세금계산서';
  var buildingkey = $('select[name=building]').val();
  // console.log(buildingkey);

  //세금계산서발송에 필요한 팝빌아이디, 사업자번호

  // alert(companynumber);


  if(taxArray.length===0){
    alert('세금계산서 발행할 것들을 먼저 체크박스로 선택해주세요.');
    return false;
  }


  if(popbillid.length === 0 || popbillid==='null'){
    alert('나의정보에서 팝빌아이디를 적어주세요.');
    return false;
  }

  if(companynumber.length === 0){
    alert('나의정보에서 사업자번호를 적어주세요.');
    return false;
  }

  if(companynumber.length != 10){
    alert('나의정보에서 사업자번호 형식을 확인해주세요. 숫자10자리여야 해요.');
    console.log(companynumber);
    return false;
  }

  // if(taxSelect==='현금영수증'){
  //   alert('현금영수증발행은 불가합니다.대신 현금영수증 발행하는것을 입력하는것은 가능합니다.');
  //   return false;
  // }
  //이건 나중에 현금영수증 api도 구현할때 사용할거임


  if(taxArray.length >= 1) {
    for (var i in taxArray) {
      if(taxArray[i][14]['입금구분']==='카드'){
        alert("입금구분이 '카드'이면 세금계산서 발행이 불가합니다.");
        return false;
      }

      if(taxArray[i][11]['세액']==='0'){
            alert("세액이 '0'원이면 세금계산서 발행이 불가합니다.");
            return false;
      }

      if(taxArray[i][15]['증빙일자']){
            alert("이미 증빙일자가 존재하므로 세금계산서 발행이 불가합니다.");
            return false;
      }

      if(taxArray[i][2]['사업자번호'].length != 12){
            alert(taxArray[i][4]['성명']+"의 사업자번호가 비어있어 세금계산서 발행이 불가합니다.");
            return false;
      }

      if(!taxArray[i][3]['사업자명']){
            alert(taxArray[i][4]['성명']+"의 사업자명이 비어있어 세금계산서 발행이 불가합니다.");
            return false;
      }
    }
  }

  var taxArrayTo = JSON.stringify(taxArray);

  goCategoryPage(buildingkey, buildingText, popbillid, companynumber, taxArrayTo, taxSelect, taxDiv);

  function goCategoryPage(a,b,c,d,e,f,g,h,i,j){
      var frm = formCreate('taxSave', 'post', 'p_payScheduleTaxInput4.php','');
      frm = formInput(frm, 'buildingId', a);
      frm = formInput(frm, 'buildingText', b);
      frm = formInput(frm, 'buildingPopbill', c);
      frm = formInput(frm, 'companynumber', d);
      frm = formInput(frm, 'taxArray', e);
      frm = formInput(frm, 'taxSelect', f);
      frm = formInput(frm, 'taxDiv', g);
      formSubmit(frm);
  }


})

$('#btnTaxDateInput2').on('click', function(){//이건입력버튼
  var taxDate = $('input[name="taxDate"]').val();
  var taxSelect = $('select[name="taxSelect"]').val(); //세금계산서인지 현금영수증인지 구분

  if(taxArray.length===0){
    alert('세금계산서 발행할 것들을 먼저 체크박스로 선택해주세요.');
    return false;
  }

  if(taxDate.length===0){
    alert('날짜가 입력되어야합니다.');
    return false;
  }

  if(taxArray.length >= 1) {
    for (var i in taxArray) {
      if(taxArray[i][14]['입금구분']==='카드'){
        alert("입금구분이 '카드'이면 증빙 발행이 불가합니다.");
        return false;
      }

      if(taxArray[i][11]['세액']==='0'){
            alert("세액이 '0'원이면 증빙 발행이 불가합니다.");
            return false;
      }

      if(taxArray[i][15]['증빙일자']){
            alert("이미 증빙일자가 존재하므로 증빙 입력이 불가합니다.");
            return false;
      }
    }
  }

  var taxArrayTo = JSON.stringify(taxArray);

//   goCategoryPage(taxArrayTo, taxSelect, taxDate);

//   function goCategoryPage(a,b,c){
//       var frm = formCreate('taxSave2', 'post', 'p_payScheduleTaxInput2.php','');
//       frm = formInput(frm, 'taxArray', a);
//       frm = formInput(frm, 'taxSelect', b);
//       frm = formInput(frm, 'taxDate', c);
//       formSubmit(frm);
//   }

  $.ajax({
      url : '/svc/ajax/get/payScheduleTaxInput2.php',
      method:'post',
      data : {
          'taxArray' : taxArrayTo,
          'taxSelect' : taxSelect,
          'taxDate' : taxDate
      },
      success : function(data){
        data = JSON.parse(data);
        console.log(data);

        if (data === 'success') {
            alert('입력했습니다^^');
        } else if(data === 'none_changes'){
            alert('변경내용이 없네요. 다시 확인해보세요^^')
        } else {
            alert('앗, 에러가 발생했군요. 관리자에게 문의하세요 ^^;')
        }

        maketable();
      }
  })


})
