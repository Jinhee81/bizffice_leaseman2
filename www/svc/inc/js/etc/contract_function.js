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


function maketable(x,y){
  var getCid;

  var a = getParameterByName('customerId');
  var b = getParameterByName('progress');
  var c = getParameterByName('dateDiv');

  if(a!=''){
    getCid = a;
  }
  if(b==='pAll'){
    $('select[name=progress]').val('pAll').prop('selected', true);
  }

  if(c==='endDate'){
    $('select[name=dateDiv]').val('endDate').prop('selected', true);
    $('select[name=dateDiv]').attr('readonly', true);
    $('select[name=periodDiv]').val('nownextMonth').prop('selected', true);
    $('select[name=periodDiv]').attr('readonly', true);
    $('select[name=progress]').val('pAll').prop('selected', true);
    $('select[name=progress]').attr('readonly', true);
    $('input[name="fromDate"]').val(todayMonthFirst);
    $('input[name="fromDate"]').attr('readonly', true);
    $('input[name="toDate"]').val(nextMonthLast);
    $('input[name="toDate"]').attr('readonly', true);
    $('select[name=building]').attr('readonly', true);
    $('select[name=group]').attr('readonly', true);
    $('select[name=etcCondi]').attr('readonly', true);
    $('input[name="cText"]').attr('readonly', true);
  }

  var form = $('form').serialize();
  // console.log(form);

  var mtable = $.ajax({
    url: 'ajax_realContractLoad.php',
    method: 'post',
    data: {'form' : form,
           'pagerow' : x,
           'getPage' : y,
           'customerId' : getCid
          },
    success: function(data){
      data = JSON.parse(data);
      datacount = data.length;
      // console.log(datacount);

      var returns = '';
      var countall;
      var monthlyAmount = 0;
      var depositAmount = 0;

      // console.log(typeof(x), x);
      // console.log(typeof(y), y);

      if(datacount===0){
        returns ="<tr><td colspan='14'>조회값이 없어요. 조회조건을 다시 확인하거나 서둘러 입력해주세요!</td></tr>";
        countall = 0;
      } else {
        $.each(data, function(key, value){
          countall = value.count;
          var ordered = Number(value.num) - ((y-1)*x);
          returns += '<tr>';
          returns += '<td class="" name=checkbox><input type="checkbox" name="rid" value="'+value.rid+'" class="tbodycheckbox"></td>';
          returns += '<td class="" data-toggle="tooltip" data-placement="top" title="'+value.rid+'" name=order>'+ordered+'</td>';

          if(value.status2==='present'){
            returns += '<td class="" name=status><div class="badge badge-info text-wrap" style="width: 3rem;">현재</div></td>';
          } if(value.status2==='waiting'){
            returns += '<td class="" name=status><div class="badge badge-warning text-wrap" style="width: 3rem;">대기</div></td>';
          } if(value.status2==='the_end'){
            returns += '<td class="" name=status><div class="badge badge-danger text-wrap" style="width: 3rem;">종료</div></td>';
          } if(value.status2==='middle_end'){
            returns += '<td class="" name=status><div class="badge badge-danger text-wrap" style="width: 3rem;">중간종료</div></td>';
          }

          // returns += '<td class=""><a href="/svc/service/customer/m_c_edit.php?id='+value.cid+'" data-toggle="tooltip" data-placement="top" title="'+value.ccnn+'" target="_blank">'+value.ccnnmb+'</a>';

          returns += '<td class="" name=customer><a href="/svc/service/customer/m_c_edit.php?id='+value.cid+'" data-toggle="modal" data-target="#eachpop" class="eachpop">'+value.ccnnmb+'</a>';
          returns += '<input type="hidden" name="customername" value="'+value.cname+'">';
          returns += '<input type="hidden" name="customercompanyname" value="'+value.ccomname2+'">';
          returns += '<input type="hidden" name="email" value="'+value.email+'">';
          returns += '<input type="hidden" name="etc" value="'+value.etc+'">';
          returns += '<input type="hidden" name="customerId" value="'+value.cid+'">';

          returns += '<input type="hidden" name="companyname" value="'+value.ccomname+'">';
          returns += '<input type="hidden" name="div2" value="'+value.div2+'">';
          returns += '<input type="hidden" name="ccnn2" value="'+value.ccnn2+'">';

          returns += '</td>';
          
          returns += '<td class="" name=contact><a href="tel:'+value.contact+'">'+value.contact+'</a>';

          returns += '</td>';
          returns += '<td class="mobile" name=building>'+value.bName+'<input type=hidden name=buildingId value='+value.building_id+'></td>';
          returns += '<td class="mobile" name=group>'+value.gName+'</td>';
          returns += '<td class="" name=room>'+value.rName+'</td>';
          returns += '<td class="mobile" name=startDate>'+value.startDate+'</td>';
          returns += '<td class="mobile" name=endDate>'+value.endDate2+'</td>';
          returns += '<td class="mobile" name=period><a href="contractEdit.php?&id='+value.rid+'" class="green" target=_blank><u>'+value.count2+'</u></a></td>';
          returns += '<td class="" name=amount><span class="green contractAmount" data-toggle="modal" data-target="#modal_amount">'+value.mtAmount+'</span>';

          returns += '<input type="hidden" name="contractId" value="'+value.rid+'">';
          returns += '<input type="hidden" name="mAmount" value="'+value.mAmount+'">';
          returns += '<input type="hidden" name="mvAmount" value="'+value.mvAmount+'">';
          returns += '<input type="hidden" name="payOrder" value="'+value.payOrder+'">';

          if(value.step==='clear'){
            returns += '<div class="badge badge-warning text-light" style="width: 1rem;">c</div></td>';
          } else {
            returns += '</td>';
          }

          returns += '<td class="mobile" name="deposit"><span class="green modaldeposit" data-toggle="modal" data-target="#modal_deposit">'+value.deposit+'</span></td>';

          returns += '<td class="mobile" name=filememo>';

          if(value.filecount > 0){
            returns += '<span class="badge badge-light modalfile" data-toggle="modal" data-target="#modal_file">'+value.filecount+'</span>';
          } else {
            returns += '<span class="badge badge-light modalfile" data-toggle="modal" data-target="#modal_file">.</span>';
          }

          if(value.memocount > 0){
            returns += '<span class="badge badge-dark modalmemo" data-toggle="modal" data-target="#modal_memo">'+value.memocount+'</span>';
          } else {
            returns += '<span class="badge badge-dark modalmemo" data-toggle="modal" data-target="#modal_memo">.</span>';
          }

          // returns += value.stepped + '</td>';
          returns += '</td>';
          returns += '</tr>';

          var pMonthlyAmount = value.mtAmount.replace(/,/gi,'');
          var pDepositAmount = value.deposit.replace(/,/gi,'');

          // monthlyAmount += Number(pMonthlyAmount);
          // depositAmount += Number(pDepositAmount);
          var monthlyAmount = value.amount1;
          var depositAmount = value.amount2;

        })
      }
      $('#allVals').html(returns);
      $('#countall').text(countall);
      $('#aa').text(monthlyAmount);
      $('#aa').number(true);
      $('#bb').text(depositAmount);
      $('#bb').number(true);

      var totalpage = Math.ceil(Number(countall)/Number(x));

      var totalpageArray = [];

      for (var i = 1; i <= totalpage; i++) {
        totalpageArray.push(i);
      }

      var paging = '<nav aria-label="..."><ul class="pagination pagination-sm justify-content-center">';

      for (var i = 1; i <= totalpageArray.length; i++) {
        paging += '<li class="page-item"><a class="page-link">'+i+'</a></li>';
      }

      paging += '</ul></nav>';

      $('#page').html(paging);

    //   let cnameTooltip = $('a.eachpop');
    //   let tooltip = new bootstrap.Tooltip(cnameTooltip, {
    //         placement : 'top',
    //         title :'solmi'
    //   }) 이건 잘 모르겠어서 주석처리하자 ㅠㅠ

    }//success}
  })//ajax }

  return mtable;
}//function }

function makesum(x,y){
  var getCid;

  var a = getParameterByName('customerId');
  var b = getParameterByName('progress');
  var c = getParameterByName('dateDiv');

  if(a!=''){
    getCid = a;
  }
  if(b==='pAll'){
    $('select[name=progress]').val('pAll').prop('selected', true);
  }

  if(c==='endDate'){
    $('select[name=dateDiv]').val('endDate').prop('selected', true);
    $('select[name=periodDiv]').val('nownextMonth').prop('selected', true);
    $('select[name=progress]').val('pAll').prop('selected', true);
    $('input[name="fromDate"]').val(todayMonthFirst);
    $('input[name="toDate"]').val(nextMonthLast);
  }

  var form = $('form').serialize();

  var sumvalue = $.ajax({
    url: 'ajax_realContractLoad_sum.php',
    method: 'post',
    data: {'form' : form,
           'pagerow' : x,
           'getPage' : y,
           'customerId' : getCid
          },
    success: function(data){
      $('#aa').html(data);
    }
  })

  return sumvalue;
}


  

