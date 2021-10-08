// string tamplate 사용으로 변경한거
function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
      results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function sql(x,y){
  var getCid = getParameterByName('customerId');
  var getProgress = getParameterByName('progress');
  var getDateDiv = getParameterByName('dateDiv');

  if(getProgress==='pAll'){
    $('select[name=progress]').val('pAll').prop('selected', true);
  }

  if(getDateDiv==='endDate'){
    $('select[name=dateDiv]').val('endDate').prop('selected', true);
    $('select[name=periodDiv]').val('nownextMonth').prop('selected', true);
    $('select[name=progress]').val('pAll').prop('selected', true);
    $('input[name="fromDate"]').val(todayMonthFirst);
    $('input[name="toDate"]').val(nextMonthLast);
  }

  var form = $('form').serialize();

  var sql = $.ajax({
    url: 'ajax_realContractSql2.php',
    method: 'post',
    data: {'form' : form,
           'pagerow' : x,
           'getPage' : y,
           'customerId' : getCid
          },
    success: function(data){
      $('#sql').html(data);
    }
  })
  return sql;
}

function outsideTable(x, y) {
  var getCid;

  var a = getParameterByName('customerId');
  var b = getParameterByName('progress');

  if (a != '') {
    getCid = a;
  }
  if(b==='pAll'){
    $('select[name=progress]').val('pAll').prop('selected', true);
  }

  var form = $('form').serialize();
//   console.log(form);

  var outsideTable = $.ajax({
    url: 'ajax_realContractLoad.php',
    method: 'post',
    data: {
      'form': form,
      'pagerow': x,
      'getPage': y,
      'customerId': getCid
    },
    success: function (data) {
      data = JSON.parse(data);
      datacount = data.length;
      // console.log(datacount);

      var returns = '';
      var countall;
      var monthlyAmount = 0;
      var depositAmount = 0;

      // console.log(typeof(x), x);
      // console.log(typeof(y), y);

      if (datacount === 0) {
        returns =
            "<tr><td colspan='14'>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요!</td></tr>";
        countall = 0;
      } else {
        $.each(data, function (key, value) {
          countall = value.count;
          var ordered = Number(value.num) - ((y - 1) * x);
          let statusValue, step, filecount, memocount;
          let end__date; //중간종료때문에 새로 만든거

          if (value.status2 === 'present') {
            statusValue = '현재';
            statusColor = 'info';
            end__date = value.endDate2;
          }
          if (value.status2 === 'waiting') {
            statusValue = '대기';
            statusColor = 'warning';
            end__date = value.endDate2;
          }
          if (value.status2 === 'the_end') {
            statusValue = '종료';
            statusColor = 'danger';
            end__date = value.endDate2;
          }
          if (value.status2 === 'middle_end') {
            statusValue = '중간종료';
            statusColor = 'danger'
            end__date = value.endDate3;
          }

          if(value.step === 'clear') {
            step = '<div class="badge badge-warning text-light" style="width: 1rem;">c</div>';
          } else {
            step = '';
          }

          if(value.filecount===0){
            filecount = '.';
          } else {
            filecount = value.filecount;
          }

          if(value.memocount===0){
            memocount = '.';
          } else {
            memocount = value.memocount;
          }

          returns += `<tr>
                        <td class="" name=checkbox>
                            <input type="checkbox" name="rid" value=${value.rid} class="tbodycheckbox">
                        </td>
                        <td class="" data-toggle="tooltip" data-placement="top" title=${value.rid} name=order>${ordered}</td>
                        <td class="" name=status><div class="badge badge-${statusColor} text-wrap" style="width: 3rem;">${statusValue}</div></td>
                        <td class="" name=customer>
                            <span data-toggle="modal" data-target="#eachpop" class="eachpop sky">${value.ccnnmb}</span>
                            <input type="hidden" name="customername" value='${value.cname}'>
                            <input type="hidden" name="customercompanyname" value='${value.ccomname2}'>
                            <input type="hidden" name="email" value='${value.email}'>
                            <input type="hidden" name="customerId" value='${value.cid}'>
                            <input type="hidden" name="companyname" value='${value.ccomname}'>
                            <input type="hidden" name="div2" value='${value.div2}'>
                            <input type="hidden" name="ccnn2" value='${value.ccnn2}'>
                        </td>
                        <td class="" name=contact>
                            <a href="tel:${value.contact}">${value.contact}</a>
                        </td>
                        <td class="mobile" name=building>${value.bName}
                            <input type=hidden name=buildingId value=${value.building_id}>
                        </td>
                        <td class="mobile" name=group>${value.gName}</td>
                        <td class="" name=room>${value.rName}</td>
                        <td class="mobile" name=startDate>${value.startDate}</td>
                        <td class="mobile" name=endDate>${end__date}</td>
                        <td class="mobile" name=period>
                            <a href="contractEdit.php?&id=${value.rid} class="green" target=_blank><u>${value
              .count2}</u></a>
                        </td>
                        <td class="" name=amount>
                            <span class="green contractAmount" data-toggle="modal" data-target="#modal_amount">${value.mtAmount}</span>
                            <input type="hidden" name="contractId" value=${value.rid}>
                            <input type="hidden" name="mAmount" value=${value.mAmount}>
                            <input type="hidden" name="mvAmount" value=${value.mvAmount}>
                            <input type="hidden" name="payOrder" value=${value.payOrder}>
                            ${step}
                        </td>
                        <td class="mobile" name="deposit"><span class="green modaldeposit" data-toggle="modal" data-target="#modal_deposit">${value.deposit}</span>
                        </td>
                        <td class="mobile" name=filememo>
                        <span class="badge badge-light modalfile" data-toggle="modal" data-target="#modal_file">${filecount}</span>
                        <span class="badge badge-dark modalmemo" data-toggle="modal" data-target="#modal_memo">${memocount}</span>
                    </td>
                    </tr>`;

          var pMonthlyAmount = value.mtAmount.replace(/,/gi, '');
          var pDepositAmount = value.deposit.replace(/,/gi, '');

          monthlyAmount += Number(pMonthlyAmount);
          depositAmount += Number(pDepositAmount);
          // var monthlyAmount = value.amount1;
          // var depositAmount = value.amount2;

        })
      }
      $('#allVals').html(returns);
      $('#countall').text(countall);
      $('#aa').text(monthlyAmount);
      $('#aa').number(true);
      $('#bb').text(depositAmount);
      $('#bb').number(true);

      var totalpage = Math.ceil(Number(countall) / Number(x));

      var totalpageArray = [];

      for (var i = 1; i <= totalpage; i++) {
        totalpageArray.push(i);
      }

      var paging =
          '<nav aria-label="..."><ul class="pagination pagination-sm justify-content-center">';

      for (var i = 1; i <= totalpageArray.length; i++) {
        paging += '<li class="page-item"><a class="page-link">' + i + '</a></li>';
      }

      paging += '</ul></nav>';

      $('#page').html(paging);

    } //success}
  }) //ajax }

  return outsideTable;
} //function }

//contractEdit.php file, page load function acronym
const errorArray = ['input1', 'input2', 'input3', 'input4', 'update1', 'update2', 'update3', 'update4','delete1', 'delete2', 'delete3', 'delete4','datetype1', 'datetype2', 'datetype3', 'datetype4', 'select1', 'select2', 'select3', 'select4'];

function depositlist(a){
    let depositlist = $.ajax({
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
  
    return depositlist;
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
    let memolist = $.ajax({
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
    let memolist = $.ajax({
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
    let memolist = $.ajax({
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



