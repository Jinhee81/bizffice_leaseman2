//contractEdit.php file, page load function acronym
const errorArray = ['input1', 'input2', 'input3', 'input4', 'update1', 'update2', 'update3', 'update4','delete1', 'delete2', 'delete3', 'delete4','datetype1', 'datetype2', 'datetype3', 'datetype4', 'select1', 'select2', 'select3', 'select4'];

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

  //=======================

  function successMemo(data){
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
        returns += "<td class=mobile><small>"+value.created+"</small></td>";

        if(value.updated===null){
          returns += "<td class=mobile><small>-</small></td>";
        } else {
          returns += "<td class=mobile><small>"+value.updated+"</small></td>";
        }
        returns += "<td class=mobile><label class='small' name='memoEdit'><u>수정</u></label>&nbsp;<label class='small' name='memoDelete'><u>삭제</u></label></td>";
        returns += "</tr>";
      })
    }
    $('#memo11').html(returns);
    autosize($('textarea[name=memoContent]'));
  }
  
  function memolist(a){
    let memolist = $.ajax({
      url:'../../ajax/ajax_memolist.php',
      method: 'post',
      data:{'id':a},
      success:function(data){
        successMemo(data);
      }//success}
    })
    return memolist;
  }

  function memoInput(a,b,c,d){
    let amountlist = $.ajax({
      url:d,
      method: 'post',
      data:{'contractId':a,
            'memoInputer':b,
            'memoContent':c},
      success:function(data){
        successMemo(data);
      }
    })
    return memolist;
  }
  
  function memoEdit(a,b,c,d,e){
    let amountlist = $.ajax({
      url:e,
      method: 'post',
      data:{'contractId':a,
            'memoId':b,
            'memoCreator':c,
            'memoContent':d
           },
      success:function(data){
        successMemo(data);
      }
    })
    return memolist;
  }
  
  function memoDelete(a,b,c){
    let amountlist = $.ajax({
      url:c,
      method: 'post',
      data:{'contractId':a,
            'memoId':b
           },
      success:function(data){
        successMemo(data);
      }
    })
    return memolist;
  }

  //========================================

function successfile(data){
  data = JSON.parse(data);
  // console.log(data);
  let returns = '';
  const datacount = data.length;

  if(datacount===0){
    returns ="<tr><td colspan='5'>등록된 파일이 없습니다.</td></tr>";
    countall = 0;
  } else {
    $.each(data, function(key, value){
      // returns += "<tr>";
      // returns += "<td>"+value.num;
      // returns += "<input type='hidden' name='fileid' value='"+value.file_id+"'></td>";
      // returns += "<td><a href='/svc/service/contract/download.php?file_id="+value.file_id+"' target=_blank>"+value.name_orig+"</a></td>";
      // returns += "<td>"+value.bytes+"</td>";
      // returns += "<td>"+value.reg_time+"</td>";
      // returns += "<td><button type='submit' name='fileDelete' class='btn btn-default grey'><i class='far fa-trash-alt'></i></button></td>";
      // returns += "</tr>";

      returns += `<tr>
                  <td>${value.num}<input type='hidden' name='fileid' value=${value.file_id}></td>
                  <td><a href='/svc/service/contract/download.php?file_id=${value.file_id}' target=_blank>${value.name_orig}</a></td>
                  <td class=mobile>${value.bytes}</td>
                  <td class=mobile>${value.reg_time}</td>
                  <td class=mobile><button type='submit' name='fileDelete' class='btn btn-default grey'><i class='far fa-trash-alt'></i></button></td>
                </tr>`;
    })
  }
  $('#file11').html(returns);
}
  
function filelist(a){
  let filelist = $.ajax({
    url:'../../ajax/ajax_filelist.php',
    method: 'post',
    data:{'contractId':a},
    success:function(data){
      successfile(data);
    }
  })

  return filelist;
}

function upfile(a,b){
  let filelist = $.ajax({
    url: a,
    method: 'post',
    entype: 'multipart/form-data',
    data: b,
    processData: false,
    contentType: false,
    success:function(data){
      successfile(data);
    }
  })
  return filelist;
}

function deletefile(a,b,c){
  let filelist = $.ajax({
    url: a,
    method: 'post',
    data: {'contractId':b, 'fileid':c},
    success:function(data){
      successfile(data);
    }
  })
  return filelist;
}

//=========================
function success(data){
  data = JSON.parse(data);
  console.log(data);
  if(errorArray.includes(data)){
    alert('데이터처리과정에 문제가 생겼습니다. 오류번호는 '+data+' 입니다.');
    return false;
  } else if(data==='logical') {
    alert('0원은 청구할 수 없습니다. 다시 확인하세요.');
    return false;
  } else {
    let returns = '';
    const datacount = data.length;
    const delayAmount = data[0]['sum'];
  
    $.each(data, function(key, value){
        let rowIndex = datacount - Number(value.ordered);
  
        if(!value.payId){
          returns += "<tr name=contractRow style='border-bottom:solid 1px grey;'>";
        } else if(value.payId && value.payIdOrder==="0"){
          returns += "<tr name=contractRow style='border-bottom:solid 1px grey;'>";
        } else {
          returns += "<tr name=contractRow style=''>";
        }
  
        returns += "<td name=checkbox width=>";
        returns += "<input type=checkbox name=csId class=tbodycheckbox2 value="+value.idcontractSchedule+">";
        returns += "<input type=hidden name=payId value="+Number(value.payId)+">";
        returns += "</td>";
        returns += "<td name=order class=text-left>";
        returns += "<span name=ordered>"+value.ordered+"</span>";
        returns += "<input type=hidden name=rowid value="+rowIndex+">";
        returns += "</td>";
        returns += "<td name=date class=text-left width=>";
        returns += "<span name=mStartDate>"+value.mStartDate+"</span>~";
        returns += "<span name=mEndDate>"+value.mEndDate+"</span>";
        returns += "</td>";
  
        if(value.payId === null){
          returns += "<td name=detail class=text-left colspan=2>";
          returns += "<table name=detail><tr>";
          returns += "<td name=mAmount class=pl-0><input type=text name=mAmount class='form-control form-control-sm amountNumber' value="+value.mMamount+" style=width:100px></td>";
          returns += "<td name=mvAmount><input type=text name=mvAmount class='form-control form-control-sm amountNumber' value="+value.mVmAmount+" style=width:100px></td>";
          returns += "<td name=mtAmount><input type=text name=mtAmount class='form-control form-control-sm amountNumber' value="+value.mTmAmount+" style=width:100px></td>";
          returns += "<td name=mExpectedDate><input type=text name=mExpectedDate class='form-control form-control-sm dateType' value="+value.mExpectedDate+" style=width:100px></td>";
          returns += "<td name=payKind><select name=payKind class='form-control form-control-sm' style=width:100px><option value=계좌>계좌</option><option value=현금>현금</option><option value=카드>카드</option></select></td>";
          returns += "</tr></table>";
        } else {
          returns += "<td name=detail class=text-left>";
          returns += "<span name=mAmount class=numberComma>"+value.mMamount+"</span>원, ";
          returns += "<span name=mvAmount class=numberComma>"+value.mVmAmount+"</span>원, ";
          returns += "<span name=mtAmount class=numberComma>"+value.mTmAmount+"</span>원, ";
          returns += "<span name=pExpectedDate class=>"+value.paySchedule2.pExpectedDate+"</span>, ";
          returns += "<span name=payKind class=>"+value.paySchedule2.payKind+"</span>";
        }
  
        returns += "</td>";
  
        if(value.payId && value.payIdOrder==="0"){
          // console.log('solmi');
          let getdiv = '';
          let taxString = '';
          let dcount1 = Number(value.paySchedule2.delaycount1);//executiveDate null
          let dcount2 = Number(value.paySchedule2.delaycount2);//executiveDate exist
          let interest1 = parseInt(value.paySchedule2.ptAmount.replace(/,/g,"")) * (dcount1/365) * 0.27;
          let interest2 = parseInt(value.paySchedule2.ptAmount.replace(/,/g,"")) * (dcount2/365) * 0.27;
          // const interest1 = 0; const interest2 = 0;
  
          let payId = Number(value.payId);
          let payIdString = ', <span>#<u class=modalpay data-toggle=modal data-target=#pPay>'+payId+'</u></span>, ';
  
          let pAmount = '<span name=ptAmount class=numberComma>'+value.paySchedule2.ptAmount+'</span>원 입금예정';
          let eDate = '<span name=executiveDate>'+value.paySchedule2.executiveDate+'</span> 입금';
          let eAmount = '<span name=getAmount class=numberComma>'+value.paySchedule2.getAmount+'</span>원, ';
          let eCount = '(<span name=monthCount>'+value.paySchedule2.monthCount+'</span>)';
          let eCount2 = '(<span name=monthCount>'+value.paySchedule2.monthCount+'</span>), '; //comma exist
          let eCount3 = '(<span name=monthCount>'+value.paySchedule2.monthCount+'</span>)개월, '; //comma, 개월 exist
  
          let delayString = ', 연체<span name=dcount1>'+dcount1+'</span>일/이자<span name=interest>'+interest1+'</span>원';//미납일때는 보이게 함
  
          let hidden = `<input type=hidden name=ptAmount value=${value.paySchedule2.ptAmount}><input type=hidden name=pExpectedDate value=${value.paySchedule2.pExpectedDate}><input type=hidden name=payKind value=${value.paySchedule2.payKind}><input type=hidden name=executiveDate value=${value.paySchedule2.executiveDate}><input type=hidden name=getAmount value=${value.paySchedule2.getAmount}><input type=hidden name=taxMun value=${value.paySchedule2.mun}><input type=hidden name=taxDate value=${value.paySchedule2.taxDate}>`;
  
          if(value.paySchedule2.mun){
            taxString = `, 세금계산서 <span><u class=taxDate>${value.paySchedule2.taxDate}</u></span><input type=hidden name=taxMun value=${value.paySchedule2.mun}>`;
          } else {
              if(value.paySchedule2.taxDate){
                taxString = `, 세금계산서 <span name='taxDate' class=taxDate>${value.paySchedule2.taxDate}</span>`;
              } else {
                taxString = '';
              }
          }
  
          let pdiv='';
  
          // console.log(value.paySchedule2.getdiv2);
  
          if(value.paySchedule2.monthCount==="1"){
            switch (value.paySchedule2.getdiv2) {
              case 'geted':
                pdiv = '<span name=payDiv>완납</span>';
                getdiv += pdiv + payIdString + eCount2 + eAmount + eDate + taxString + hidden;
              break;
              case 'get_delay':
                pdiv = '<span name=payDiv>완납(연체)</span>';
                getdiv += pdiv + payIdString + eCount2 + eAmount + eDate + taxString + hidden;
              break;
              case 'not_get_delay':
                pdiv = '<span name=payDiv>미납</span>';
                getdiv += pdiv + payIdString + eCount + taxString + delayString + hidden;
              break;
              case 'not_get':
                pdiv = '<span name=payDiv>입금대기</span>';
                getdiv += pdiv + payIdString + eCount3 + pAmount + taxString + hidden;
              break;
            }
          } else {
            switch (value.paySchedule2.getdiv2) {
              case 'geted':
                pdiv = '<span name=payDiv>완납</span>';
                getdiv += pdiv + payIdString + eCount3 + eAmount + eDate + taxString + hidden;
              break;
              case 'get_delay':
                pdiv = '<span name=payDiv>완납(연체)</span>';
                getdiv += pdiv + payIdString + eCount3 + eAmount + eDate + taxString + hidden;
              break;
              case 'not_get_delay':
                pdiv = '<span name=payDiv>미납</span>';
                getdiv += pdiv + payIdString + eCount3 + pAmount +taxString + delayString + hidden;
              break;
              case 'not_get':
                pdiv = '<span name=payDiv>입금대기</span>';
                getdiv += pdiv + payIdString + eCount3 + pAmount + taxString + hidden;
              break;
          }
        }
  
        switch (value.paySchedule2.getdiv2) {
          case 'geted': returns += "<td name=detail2 class='text-left green font-italic'>"+getdiv+"</td>";//완납
          break;
          case 'get_delay': returns += "<td name=detail2 class='text-left green font-italic'>"+getdiv+"</td>";//완납(연체)
          break;
          case 'not_get_delay': returns += "<td name=detail2 class='text-left pink font-italic'>"+getdiv+"</td>";//미납
          break;
          case 'not_get': returns += "<td name=detail2 class='text-left sky font-italic'>"+getdiv+"</td>";//입금대기
          break;
        }
    }
  
    returns += "</tr>";
  
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
  }
}//success }

function amountlist(a,b){
  let amountlist = $.ajax({
    url:b,
    method: 'post',
    data:{'contractId':a},
    success:function(data){
      success(data);
    }
    // ,
    // error:function(request,status,error){
    //   alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
    // }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist2(a,b,c){
  let amountlist = $.ajax({
    url:c,
    method: 'post',
    data:{'contractId':a,
          'contractScheduleIdArray':b},
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist20(a,b,c){
  let amountlist = $.ajax({
    url:c,
    method: 'post',
    data:{'contractId':a,
          'payId':b},
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist24(a,b,c){
  let amountlist = $.ajax({
    url:c,
    method: 'post',
    data:{'contractId':a,
          'payIdArray':b},
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist21(a,b,c,d){
  let amountlist = $.ajax({
    url:d,
    method: 'post',
    data:{'contractId':a,
          'buildingId':b,
          'contractScheduleArray':c},
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist22(a,b,c,d,e,f){
  let amountlist = $.ajax({
    url:e,
    method: 'post',
    data:{'payid':a,
          'payKind':b,
          'executiveDate':c,
          'contractId':d,
          'pExpectedDate':f
         },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist23(a,b,c,d,e){
  let amountlist = $.ajax({
    url:e,
    method: 'post',
    data:{'scheduleArray':a,
          'contractId':b,
          'buildingId':c,
          'paykind':d
          },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist3(a,b,c,d,e,f){
    let amountlist = $.ajax({
      url:b,
      method: 'post',
      data:{'contractId':a,
            'addMonth':c,
            'changeAmount1':d,
            'changeAmount2':e,
            'changeAmount3':f
            },
      success:function(data){
        success(data);
      }
    })
    expectedDayArray = [];
    return amountlist;
}

function amountlist31(a,b,c,d,e,f,g){
  let amountlist = $.ajax({
    url:g,
    method: 'post',
    data:{'realContract_id':a,
          'payid':b,
          'paykind':c,
          'pgetdate':d,
          'pgetAmount':e,
          'pExpectedDate':f
          },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist32(a,b,c,d,e,f,g){
  let amountlist = $.ajax({
    url:g,
    method: 'post',
    data:{'contractId':a,
          'depositInDate':b,
          'depositInAmount':c,
          'depositOutDate':d,
          'depositOutAmount':e,
          'depositMoney':f
          },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist33(a,b,c,d,e,f){
  let amountlist = $.ajax({
    url:f,
    method: 'post',
    data:{'payid':a,
          'payKind':b,
          'executiveDate':c,
          'contractId':d,
          'pExpectedDate':e
         },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist4(a,b,c,d,e,f,g,h,i){
  let amountlist = $.ajax({
    url:b,
    method: 'post',
    data:{'contractId':a,
          'addMonth':c,
          'changeAmount1':d,
          'changeAmount2':e,
          'changeAmount3':f,
          'expectedDate':g,
          'payKind':h,
          'buildingId':i
          },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function amountlist5(a,b,c,d,e,f,g,h,i,j,k){
  let amountlist = $.ajax({
    url:b,
    method: 'post',
    data:{'contractId':a,
          'addMonth':c,
          'changeAmount1':d,
          'changeAmount2':e,
          'changeAmount3':f,
          'expectedDate':g,
          'payKind':h,
          'buildingId':i,
          'executiveDate':j,
          'executiveAmount':k
          },
    success:function(data){
      success(data);
    }
  })
  expectedDayArray = [];
  return amountlist;
}

function successRefund(data){
  data = JSON.parse(data);
  // console.log(data);

  let endDate3 = data.endDate3;
  let rAmount = data.rAmount;
  let rvAmount = data.rvAmount;
  let rtAmount = data.rtAmount;
  let rKind = data.rKind;
  let rDate = data.rDate;
  let rPayid = data.rPayid;
  let labeltext;

  // console.log(endDate3, rAmount, rvAmount, rtAmount, rKind, rDate, rPayid, labeltext);

  if(endDate3 == null || endDate3 == undefined){
    endDate3 = '--';
    labeltext = '<label class=small id=enddate3btn><u>입력하기</u></label>';
  } else {
    endDate3 = endDate3;
    labeltext = '<label class=small id=enddate3btn><u>수정</u></label>&nbsp;<label class=small id=enddateCansel><u>철회</u></label>';
  }
  if(rDate == null || rDate == undefined){
    rDate = '--';
  }
  if(rAmount == null || rAmount == undefined){
    rAmount='0';
  }
  if(rvAmount == null || rvAmount == undefined){
    rvAmount='0';
  }
  if(rtAmount == null || rtAmount == undefined){
    rtAmount='0';
  }
  if(rPayid == null || rPayid == undefined){
    rPayid='0';
  }
  if(rKind == null || rKind == undefined){
    rKind = '계좌';
  }

  $('#enddate33').val(endDate3);
  $('input[name=rAmount]').val(rAmount);
  $('input[name=rvAmount]').val(rvAmount);
  $('input[name=rtAmount]').val(rtAmount);
  $('#executiveDiv3').val(rKind).attr("selected", "selected");
  $('#enddate44').val(rDate);
  $('td[name=textlabel]').html(labeltext);
  $('input[name=rPayid]').val(rPayid);
}

function refundlist(a){
  let amountlist = $.ajax({
    url:'../../ajax/ajax_refundlist.php',
    method: 'post',
    data:{'id':a},
    success:function(data){
      successRefund(data);
    }
  })

  return amountlist;
}