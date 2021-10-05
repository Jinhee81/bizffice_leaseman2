//contractEdit.php file, page load function acronym

function depositlist(a){
  let amountlist = $.ajax({
    url:'../../ajax/ajax_depositlist.php',
    method: 'post',
    data:{'id':a},
    success:function(data){
      data = JSON.parse(data);
      // console.log(data);
      $('input[name=depositInDate]').val(data.inDate);
      $('input[name=depositInAmount]').val(data.inMoney);
      $('input[name=depositOutDate]').val(data.outDate);
      $('input[name=depositOutAmount]').val(data.outMoney);
      $('input[name=depositMoney]').val(data.remainMoney);
      $('span[name=depositMoney]').text(data.remainMoney);
      $('td[name=saved]').text(data.saved);
    }
  })

  return amountlist;
}

function memolist(a){
  let memolist = $.ajax({
    url:'../../ajax/ajax_memolist.php',
    method: 'post',
    data:{'id':a},
    success:function(data){
      data = JSON.parse(data);
      // console.log(data);
      let returns = '';
      const datacount = data.length;

      if(datacount===0){
        returns ="<tr><td colspan='6'>등록된 메모가 없습니다.</td></tr>";
        countall = 0;
      } else {
        $.each(data, function(key, value){
          returns += "<tr>";
          returns += "<td>"+value.num;
          returns += "<input type='hidden' name='memoid' value='"+value.idrealContract_memo+"'></td>";
          returns += "<td><input class='form-control form-control-sm text-center' name='memoCreator' value='"+value.memoCreator+"'></td>";
          returns += "<td><textarea class='form-control form-control-sm' name='memoContent' rows='1'>"+value.memoContent+"</textarea></td>";
          returns += "<td><small>"+value.created+"</small></td>";

          if(value.updated===null){
            returns += "<td><small>-</small></td>";
          } else {
            returns += "<td><small>"+value.updated+"</small></td>";
          }
          returns += "<td><label class='small' name='memoEdit'><u>수정</u></label>&nbsp;<label class='small' name='memoDelete'><u>삭제</u></label></td>";
          returns += "</tr>";
        })
      }
      $('#memo11').html(returns);
      autosize($('textarea[name=memoContent]'));
    }//success}
  })

  return memolist;
}

function filelist(a){
  let filelist = $.ajax({
    url:'../../ajax/ajax_filelist.php',
    method: 'post',
    data:{'id':a},
    success:function(data){
      data = JSON.parse(data);
      // console.log(data);
      let returns = '';
      const datacount = data.length;

      if(datacount===0){
        returns ="<tr><td colspan='5'>등록된 파일이 없습니다.</td></tr>";
        countall = 0;
      } else {
        $.each(data, function(key, value){
          returns += "<tr>";
          returns += "<td>"+value.num;
          returns += "<input type='hidden' name='fileid' value='"+value.file_id+"'></td>";
          returns += "<td><a href='download.php?file_id="+value.file_id+"' target=_blank>"+value.name_orig+"</a></td>";
          returns += "<td>"+value.bytes+"</td>";
          returns += "<td>"+value.reg_time+"</td>";
          returns += "<td><button type='submit' name='fileDelete' class='btn btn-default grey'><i class='far fa-trash-alt'></i></button></td>";
          returns += "</tr>";
        })
      }
      $('#file11').html(returns);
    }
  })

  return filelist;
}

function amountlist(a){
  let amountlist = $.ajax({
    url:'../../ajax/ajax_amountlist.php',
    method: 'post',
    data:{'id':a},
    success:function(data){
      data = JSON.parse(data);
    //   console.log(data);
      let returns = '';
      const datacount = data.length;
      const delayAmount = data[0]['sum'];

      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      $.each(data, function(key, value){
        let rowIndex = datacount - Number(value.ordered);

        if(!value.payId){
          returns += "<tr name=contractRow style='border-bottom:solid 1px grey;'>";
        } else {
          returns += "<tr name=contractRow style=''>";
        }

        returns += "<td name=checkbox>";
        returns += "<input type=checkbox name=csId class=tbodycheckbox2 value="+value.idcontractSchedule+">";
        returns += "<input type=hidden name=payId value="+value.payId+">";
        returns += "</td>";
        returns += "<td name=order>";
        returns += "<span name=ordered>"+value.ordered+"</span>";
        returns += "<input type=hidden name=rowid value="+rowIndex+">";
        returns += "</td>";
        returns += "<td name=date class=text-left>";
        returns += "<span name=mStartDate>"+value.mStartDate+"</span>~";
        returns += "<span name=mEndDate>"+value.mEndDate+"</span>";
        returns += "</td>";
        returns += "<td name=detail class=text-left>";

        if(value.payId === null){
          returns += "<table name=detail><tr>";
          returns += "<td name=mAmount><input type=text name=mAmount class='form-control form-control-sm amountNumber numberComma' value="+value.mMamount+" style=width:100px></td>";
          returns += "<td name=mvAmount><input type=text name=mvAmount class='form-control form-control-sm amountNumber numberComma' value="+value.mVmAmount+" style=width:100px></td>";
          returns += "<td name=mtAmount><input type=text name=mtAmount class='form-control form-control-sm amountNumber numberComma' value="+value.mTmAmount+" style=width:100px></td>";
          returns += "<td name=mExpectedDate><input type=text name=mExpectedDate class='form-control form-control-sm dateType' value="+value.mExpectedDate+" style=width:100px></td>";
          returns += "<td name=payKind><select name=payKind class='form-control form-control-sm' style=width:100px><option value=계좌>계좌</option><option value=현금>현금</option><option value=카드>카드</option></select></td>";
          returns += "</tr></table>";
        } else {
          returns += "<span name=mAmount class=numberComma>"+value.mMamount+"</span>원, ";
          returns += "<span name=mvAmount class=numberComma>"+value.mVmAmount+"</span>원, ";
          returns += "<span name=mtAmount class=numberComma>"+value.mTmAmount+"</span>원";
        }

        returns += "</td></tr>";

        if(value.payId && value.payIdOrder==="0"){
          // console.log('solmi');
          let getdiv = '';
          let taxString = '';
          let dcount1 = Number(value.paySchedule2.delaycount1);//executiveDate null
          let dcount2 = Number(value.paySchedule2.delaycount2);//executiveDate exist
          let interest1 = parseInt(value.paySchedule2.ptAmount.replace(/,/g,"")) * (dcount1/365) * 0.27;
          let interest2 = parseInt(value.paySchedule2.ptAmount.replace(/,/g,"")) * (dcount2/365) * 0.27;

          let payId = Number(value.payId);
          let payIdString = ', <span>#<u class=modalpay data-toggle=modal data-target=#nPay>'+payId+'</u></span>';

          let hidden = '<input type=hidden name=ptAmount value='+value.paySchedule2.ptAmount+'><input type=hidden name=pExpectedDate value='+value.paySchedule2.pExpectedDate+'><input type=hidden name=payKind value='+value.paySchedule2.payKind+'><input type=hidden name=executiveDate value='+value.paySchedule2.executiveDate+'><input type=hidden name=getAmount value='+value.paySchedule2.getAmount+'>';

          if(value.paySchedule2.mun){
            taxString = `, 세금계산서 <span name='taxDate' class=taxDate><u>${value.paySchedule2.taxDate}</u></span><input type=hidden name=taxMun value=${value.paySchedule2.mun}><input type=hidden name='buildingId' value=${value.paySchedule2.bid}>`;
          } else {
              if(value.paySchedule2.taxDate){
                taxString = `, 세금계산서 <span name='taxDate' class=taxDate>${value.paySchedule2.taxDate}</span>`;
              } else {
                taxString = '';
              }
          }

          // console.log(value.paySchedule2.getdiv2);

          if(value.paySchedule2.monthCount==="1"){
            switch (value.paySchedule2.getdiv2) {
              case 'geted':getdiv += '입금예정일 <span>'+value.paySchedule2.pExpectedDate+'</span>, 입금일 <span>'+value.paySchedule2.executiveDate+'</span>, <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원('+value.paySchedule2.payKind+'), 연체0일/이자0원, <span name=payDiv>완납</span>' + taxString + payIdString+hidden;
              break;
              case 'get_delay':getdiv += '입금예정일 <span>'+value.paySchedule2.pExpectedDate+', 입금일 <span>'+value.paySchedule2.executiveDate+'</span>, <span  class=numberComma>'+value.paySchedule2.ptAmount+'</span>원(<span>'+value.paySchedule2.payKind+'</span>), 연체'+dcount2+'일/이자<span name=interest>'+interest2+'</span>원<span name=payDiv>완납(연체)</span>' + taxString + payIdString+hidden;
              break;
              case 'not_get_delay':getdiv += '입금예정일 <span>'+value.paySchedule2.pExpectedDate+'</span> <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원('+value.paySchedule2.payKind+'), 연체'+dcount1+'일/이자<span name=interest>'+interest1+'</span>원, <span name=payDiv>미납</span>' + taxString + payIdString+hidden;
              break;
              case 'not_get':getdiv += '입금예정일 <span>'+value.paySchedule2.pExpectedDate+'</span>, <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원('+value.paySchedule2.payKind+'), <span name=payDiv>입금대기</span>' + taxString + payIdString+hidden;
              break;
            }
          } else {
            switch (value.paySchedule2.getdiv2) {
              case 'geted':getdiv += '<span>'+value.paySchedule2.monthCount+'</span>개월치, 입금예정일 <span>'+value.paySchedule2.pExpectedDate+'</span>, 입금일 <span>'+value.paySchedule2.executiveDate+'</span>'+'(<span>'+value.paySchedule2.payKind+'</span>) <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원 입금, 연체0일/이자0원, <span name=payDiv>완납</span>' + taxString + payIdString+hidden;
              break;
              case 'get_delay':getdiv += '<span>'+value.paySchedule2.monthCount+'</span>개월치, 입금예정일 <span>'+value.paySchedule2.pExpectedDate+', <span>'+value.paySchedule2.executiveDate+'</span>(<span>'+value.paySchedule2.payKind+'</span>) <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원 입금, 연체'+dcount2+'일/이자<span name=interest>'+interest2+'</span>원, <span name=payDiv>완납(연체)</span>' + taxString + payIdString+hidden;
              break;
              case 'not_get_delay':getdiv += '<span>'+value.paySchedule2.monthCount+'</span>개월치, 입금예정일 <span>'+value.paySchedule2.pExpectedDate+'</span>(<span>'+value.paySchedule2.payKind+'</span>) <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원, 연체'+dcount1+'일/이자<span name=interest>'+interest1+'</span>원, <span name=payDiv>미납</span>' + taxString + payIdString+hidden;
              break;
              case 'not_get':getdiv += '<span>'+value.paySchedule2.monthCount+'</span>개월치, 입금예정일 <span>'+value.paySchedule2.pExpectedDate+'</span>(<span>'+value.paySchedule2.payKind+'</span>) <span class=numberComma>'+value.paySchedule2.ptAmount+'</span>원, <span name=payDiv>입금대기</span>' + taxString + payIdString+hidden;
              break;
          }
        }

        switch (value.paySchedule2.getdiv2) {
          case 'geted': returns += "<tr class=paySchedule style='border-bottom:solid 1px grey;'><td colspan=5 class='text-right green'>"+getdiv+"</td></tr>";
          break;
          case 'get_delay': returns += "<tr class=paySchedule style='border-bottom:solid 1px grey;'><td colspan=5 class='text-right green'>"+getdiv+"</td></tr>";
          break;
          case 'not_get_delay': returns += "<tr class=paySchedule style='border-bottom:solid 1px grey;'><td colspan=5 class='text-right pink'>"+getdiv+"</td></tr>";
          break;
          case 'not_get': returns += "<tr class=paySchedule style='border-bottom:solid 1px grey;'><td colspan=5 class='text-right sky'>"+getdiv+"</td></tr>";
          break;
        }
      }

      })//each}

      $('#schedule').html(returns);

      $('#delayAmount').text(delayAmount);

      $('.dateType').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        currentText: '오늘', // 오늘 날짜로 이동하는 버튼 패널
        closeText: '닫기'  // 닫기 버튼 패널
      })

      $(".amountNumber").click(function(){
        $(this).select();
      });
      // $("input:text[numberOnly]").number(true);

      $("span[class=numberComma]").number(true);
      $("input[name=mAmount]").number(true);
      $("input[name=mvAmount]").number(true);
      $("input[name=mtAmount]").number(true);
      $("span[name=interest]").number(true);
    }//success }

  })
  return amountlist;
}
