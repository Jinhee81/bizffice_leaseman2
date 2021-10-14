function m_customer(a){
  var m_customer = $.ajax({
    url: '/svc/service/customer/ajax_customer.php',
    method: 'post',
    data: {'cid' : a},
    success: function(data){
      data = JSON.parse(data);
      // console.log(data);
      $('input[name=id_m]').val(a);

      $('input[name=bName]').val(data.bName);
      $('input[name=name_m]').val(data.name);
      $('input[name=contact1_m]').val(data.contact1);
      $('input[name=contact2_m]').val(data.contact2);
      $('input[name=contact3_m]').val(data.contact3);
      $('input[name=companyname_m]').val(data.companyname);
      $('input[name=cNumber1_m]').val(data.cNumber1);
      $('input[name=cNumber2_m]').val(data.cNumber2);
      $('input[name=cNumber3_m]').val(data.cNumber3);
      $('input[name=email_m]').val(data.email);
      $('input[name=div4_m]').val(data.div4);
      $('input[name=div5_m]').val(data.div5);

      $('#sample2_postcode').val(data.zipcode);
      $('#sample2_address').val(data.add1);
      $('#sample2_detailAddress').val(data.add2);
      $('#sample2_extraAddress').val(data.add3);
      $('textarea[name=etc_m]').val(data.etc);

      $('span[name=id_m]').text(Number(a));
      $('span[name=created_m]').text(data.created);
      $('span[name=updated_m]').text(data.updated);

      if(data.div2==='개인'){
        $('option[name=kind1]').attr('selected',true);
      } else if(data.div2==='개인사업자'){
        $('option[name=kind2]').attr('selected',true);
      } else if(data.div2==='법인사업자'){
        $('option[name=kind3]').attr('selected',true);
      }

      if(data.div3==='주식회사'){
        $('option[name=a2]').attr('selected',true);
      } else if(data.div3==='유한회사'){
        $('option[name=a3]').attr('selected',true);
      } else if(data.div3==='합자회사'){
        $('option[name=a4]').attr('selected',true);
      } else if(data.div3==='기타'){
        $('option[name=a5]').attr('selected',true);
      } else {
        $('option[name=a1]').attr('selected',true);
      }
    }
  });//ajax}

  return m_customer;
}
