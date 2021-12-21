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
  
      $.ajax({
        url : '/svc/pop/MessageExample/SendXMS_Multi_none.php',
        type : 'post',
        data : {'smsTime':smsTime,
                'smsTimeValue':smsTimeValue,
                'sendphonenumber':sendphonenumber,
                'textareaOnly':textareaOnly,
                'getByte':getByte,
                'smsDiv':smsDiv,
                'smstitle':'none',
                'sendedArray1':sendedArray1
                },
        success : function(data) {
            data = JSON.parse(data);
            console.log(data);

            if(data==='date_require'){
                alert('예약전송인 경우 날짜 시간을 지정해야 합니다.');
                return false;
            } else if (data==='error_occured2') {
              alert('mysql_error. 관리자에게 문의하세요');
              return false;
            } else if (data==='success') {
              alert('문자전송이 성공하였습니다.');
              return false;
            } else {
              alert(data + ' 에러발생했습니다. 관리자에게 문의하세요.');
              return false;
            }
        }

    })
  
    })
  }
  