let contractArray = [];
// let table = $('#checkboxTestTbl');

$(document).on('change', '#allselect', function() {

    var allCnt = $(".tbodycheckbox", table).length;
    console.log(allCnt);
    contractArray = [];

    if ($("#allselect").is(":checked")) {
        for (var i = 1; i <= allCnt; i++) {
            var contractArrayEle = [];
            var colOrder = table.find("tr:eq(" + i + ")").find("td:eq(1)").text().trim();
            var colid = table.find("tr:eq(" + i + ")").find("td:eq(0)").children('input').val();
            var colStep = table.find("tr:eq(" + i + ")").find("td:eq(11)").children('div').text();
            var colFile = table.find("tr:eq(" + i + ")").find("td:eq(13)").children('a:eq(0)').text();
            var colMemo = table.find("tr:eq(" + i + ")").find("td:eq(13)").children('a:eq(1)').text();
            contractArrayEle.push(colOrder, colid, $.trim(colStep), colFile, colMemo);
            contractArray.push(contractArrayEle);
        }
        // console.log('checked');
    } else {
        contractArray = [];
        // console.log('unchecked');
    }
    console.log(contractArray);
})

$(document).on('change', '.tbodycheckbox', function() {
    var contractArrayEle = [];

    if ($(this).is(":checked")) {
        var currow = $(this).closest('tr');
        var colOrder = Number(currow.find('td:eq(1)').text());
        var colid = currow.find('td:eq(0)').children('input').val();
        var colStep = currow.find('td:eq(11)').children('div').text();
        var colFile = currow.find("td:eq(13)").children('a:eq(0)').text();
        var colMemo = currow.find("td:eq(13)").children('a:eq(1)').text();
        contractArrayEle.push(colOrder, colid, $.trim(colStep), colFile, colMemo);
        contractArray.push(contractArrayEle);
    } else {
        var currow = $(this).closest('tr');
        var colOrder = Number(currow.find('td:eq(1)').text());

        for (var i = 0; i < contractArray.length; i++) {
            if (contractArray[i][0] === colOrder) {
                var index = i;
                break;
            }
        }
        contractArray.splice(index, 1);
    }
    console.log(contractArray);
    // console.log(typeof(contractArray[3]));
})


