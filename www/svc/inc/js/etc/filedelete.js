$(document).on('click', 'button[name=fileDelete]', function() {
    var fileid = $(this).parent().parent().children().children('input:eq(0)').val();

    let contractId = $('.contractNumber:eq(0)').text();
    let url = '/svc/service/contract/process/pp_fileDelete.php';

    console.log(url, contractId, fileid);
    deletefile(url, contractId, fileid);
})