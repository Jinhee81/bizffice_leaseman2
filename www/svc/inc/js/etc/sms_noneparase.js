//동기방식에서 비동기방식으로 (ajax)로 변경하려고 파일 새로 만든것. 21.7.10

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

  let aa;

  for(let i = 0; i<smsReadyArray.length; i++) {
      aa += `<tr><td>${i+1}</td><td>${smsReadyArray[i][5]['연락처']}</td></tr>`;
  }

  $('#tbody').html(aa);


  $('#smsSendBtn1').on('click', function(){

    var sendedArray1 = JSON.stringify(smsReadyArray);
    var aa = 'sendedArray1';
    var bb = '/svc/service/sms/p_sendedsms1.php';

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

    $.ajax({
        url : '/svc/service/sms/p_sendedsms11.php',
        type : 'post',
        data : {
            'sendedArray1':sendedArray1,
            'textareaOnly':textareaOnly,
            'smsTime':smsTime,
            'smsTimeValue':smsTimeValue,
            'getByte':getByte,
            'smsDiv':smsDiv,
            'sendphonenumber':sendphonenumber
        },
        success:function(data){
            data = JSON.parse(data);
            console.log(data);

            if(data==='success'){
                alert('전송하였습니다.');
            } else {
                alert('문자메시지 전송하지 못했습니다. 관리자에게 문의하세요.');
                return false;
            }
        }
    })

  })
}
