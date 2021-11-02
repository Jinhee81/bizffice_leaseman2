//memo input, edit, delete

$(document).on('click', '#memoButton', function() {
    var memoInputer = $('#memoInputer').val();
    var memoContent = $('#memoContent').val();

    if (!memoContent) {
        alert('내용을 입력해야 합니다.');
        return false;
    }
    // console.log(memoInputer, memoContent);

    var url = '/svc/service/contract/process/pp_memoAppend.php';
    let contractId = $('.contractNumber:eq(0)').text();

    memoInput(contractId, memoInputer, memoContent, url);

});

$(document).on('click', 'label[name=memoEdit]', function() {
    let contractId = $('.contractNumber:eq(0)').text();
    var memoid = $(this).parent().parent().find('td:eq(0)').children('input[name=memoid]').val();
    var memoCreator = $(this).parent().parent().find('td:eq(1)').children('input').val();
    var memoContent = $(this).parent().parent().children().children('textarea').val();
    // console.log(memoid, memoCreator, memoContent);
    var url = '/svc/service/contract/process/pp_memoEdit.php';

    // console.log(contractId,memoid,memoCreator,memoContent,url);

    memoEdit(contractId, memoid, memoCreator, memoContent, url);
    alert('수정했습니다.');
});


$(document).on('click', 'label[name=memoDelete]', function() {

    var c = confirm('정말 삭제하시겠습니까?');

    if (c) {
        var memoid = $(this).parent().parent().children().children('input:eq(0)').val();
        let contractId = $('.contractNumber:eq(0)').text();
        var url = '/svc/service/contract/process/pp_memoDelete.php';

        memoDelete(contractId, memoid, url);
    }

});
//=============================

