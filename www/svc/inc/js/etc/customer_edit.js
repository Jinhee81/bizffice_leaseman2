$('button[name=editCustomer]').on('click', function(){
    let cid = $('span[name=id_m]').text();

    let div2 = $('select[name=div2_m]').val();
    let name = $('input[name=name_m]').val();
    let contact1 = $('input[name=contact1_m]').val();
    let contact2 = $('input[name=contact2_m]').val();
    let contact3 = $('input[name=contact3_m]').val();

    let companyname = $('input[name=companyname_m]').val();
    let cNumber1 = $('input[name=cNumber1_m]').val();
    let cNumber2 = $('input[name=cNumber2_m]').val();
    let cNumber3 = $('input[name=cNumber3_m]').val();
    let email = $('input[name=email_m]').val();

    let div3 = $('select[name=div3_m]').val();
    let div4 = $('input[name=div4_m]').val();
    let div5 = $('input[name=div5_m]').val();

    let zipcode = $('input[name=zipcode]').val();
    let add1 = $('input[name=add1]').val();
    let add2 = $('input[name=add2]').val();
    let add3 = $('input[name=add3]').val();

    let etc = $('textarea[name=etc_m]').val();

    // console.log(cid, div2, name, contact1, contact2, contact3, companyname, cNumber1, cNumber2, cNumber3, email, div3, div4, div5, zipcode, add1, add2, add3, etc);

    let customer_attr = {
        'cid' : cid,
        'div2' : div2,
        'name' : name,
        'contact1' : contact1,
        'contact2' : contact2,
        'contact3' : contact3,
        'companyname' : companyname,
        'cNumber1' : cNumber1,
        'cNumber2' : cNumber2,
        'cNumber3' : cNumber3,
        'email' : email,
        'div3' : div3,
        'div4' : div4,
        'div5' : div5,
        'zipcode' : zipcode,
        'add1' : add1,
        'add2' : add2,
        'add3' : add3,
        'etc' : etc
    };

    editCustomer(customer_attr, cid);
})

function editCustomer(a, b){
    $.ajax({
        url:'/svc/ajax/customer/edit.php',
        method:'post',
        data: {
            "customer":a
        },
        success:function(data){
            data = JSON.parse(data);
            // console.log(data);

            if (data === 'success') {
                alert('수정했습니다^^');
            } else if(data === 'none_changes'){
                alert('변경내용이 없네요. 다시 확인해보세요^^')
            } else {
                alert('앗, 에러가 발생했군요. 관리자에게 문의하세요 ^^;')
            }

            m_customer(b);
        }
    })
}