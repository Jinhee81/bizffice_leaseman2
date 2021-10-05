function sms_noneparase(){

  function byteLength(a){
    var l = 0;

    for (var idx=0; idx<a.length; idx++){
      var c = escape(a.charAt(idx));
      if(c.length==1) l++;
      else if(c.indexOf("%u")!==-1) l += 2;
      else if(c.indexOf("%")!==-1) l += c.length/3;
    }
    return l;
  }

  $('#textareaOnly').on('keyup', function(){

    var textContent = $('#textareaOnly').val();
    var getByte = byteLength(textContent);
    // console.log(getByte);
    $("#getByteOnly").html(getByte);

    if(getByte > 80){
      $('#smsDivOnly').html('<span class="badge badge-danger">mms</span>');
    } else {
      $('#smsDivOnly').html('<span class="badge badge-primary">sms</span>');
    }

    // console.log('solmi');

  })

  $('#textareaOnly').on('change', function(){
    var textContent = $('#textareaOnly').val();
    var getByte = byteLength(textContent);
    // console.log(getByte);
    $("#getByteOnly").html(getByte);

    if(getByte > 80){
      $('#smsDivOnly').attr('class','badge badge-primary');
    } else {
      $('#smsDivOnly').attr('class','badge badge-primary');
    }
  })

  $('#smsTime').on('change', function(){


    if($('#smsTime').val()==='reservation'){


      $('#timeSet').html('<input type="text" class="form-control form-control-sm timeType mb-2" id="timeSetVal" value="" placeholder="">');
    } else {
      $('#timeSet').empty();
    }

    $('.timeType').datetimepicker({
      dateFormat:'yy-mm-dd',
      monthNamesShort:[ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
      dayNamesMin:[ '일', '월', '화', '수', '목', '금', '토' ],
      changeMonth:true,
      changeYear:true,
      showMonthAfterYear:true,

      timeFormat: 'HH:mm:ss',
      controlType: 'select',
      oneLine: true,
      minDate: today
      // hourMin: today.getHours(), 시간,분,초 구하는게 잘 안되서 일단 안하기로함.
      // minuteMin: today.getMinutes(),
      // hourMin: today.getSeconds()
    })

    // console.log('solmi');

  })


  $('#smsSendBtn1').on('click', function(){
    var smsReadyArray = [];
    var smsReadyArrayEle = [];
    var recievephonenumber2 = $('#recievephonenumber').text();
    var cname = $('#mcname').text();
    console.log(recievephonenumber2);
    smsReadyArrayEle.push({'순번':1}, {'청구번호':''}, {'그룹':''}, {'방번호':''}, {'받는사람':cname}, {'연락처':recievephonenumber2}, {'이메일':''}, {'납부일':''}, {'증빙일':''}, {'공급가액':''}, {'세액':''}, {'합계':''}, {'받는사람id':customerId}, {'예정일':''}, {'시작일':''}, {'종료일':''}, {'개월수':''}, {'연체일수':''}, {'연체이자':''}, {'사업자명':''});
    smsReadyArray.push(smsReadyArrayEle);


    var sendedArray1 = JSON.stringify(smsReadyArray);
    var aa = 'sendedArray1';
    var bb = '/svc/service/sms/p_sendedsms1.php';

    function goCategoryPage(a,b,c,d,e,f,g,h,i){
        var frm = formCreate(a, 'post', b,'');
        frm = formInput(frm, 'sendedArray1', c);
        frm = formInput(frm, 'textareaOnly', d);
        frm = formInput(frm, 'timeDiv', e);
        frm = formInput(frm, 'smsTime', f);
        frm = formInput(frm, 'getByte', g);
        frm = formInput(frm, 'smsDiv', h);
        frm = formInput(frm, 'sendphonenumber', i);
        formSubmit(frm);
    }

    var textareaOnly = $('#textareaOnly').val();
    var smsTime = $('#smsTime').val();
    var smsTimeValue = $('#timeSetVal').val();
    var getByte = byteLength(textareaOnly);
    if(getByte>80){
      var smsDiv = 'mms';
    } else {
      var smsDiv = 'sms';
    }
    var sendphonenumber = $('input[name=sendphonenumber]').val();
    if(textareaOnly.length===0){
      alert('문자내용이 없는 경우 문자전송할수 없습니다.');
      return false;
    }

    console.log(smsReadyArray);
    // console.log(getByte);

    goCategoryPage(aa, bb, sendedArray1, textareaOnly, smsTime, smsTimeValue, getByte, smsDiv, sendphonenumber);

  })
}
