var checkbox = "<input type='checkbox' name='chk[]' value='<?=$row[0]?>'>";
var sunbun;
var startDateInline = "<?=$row['startDate']?>";
var endDateInline;
var mAmount = "<input type='text' size='10' class='form-control form-control-sm text-right amountNumber' name='mAmount' value='<?=$row['mAmount']?>'>";
var mvAmount ="<input type='text' size='10' class='form-control form-control-sm text-right amountNumber' name='mvAmount' value='<?=$row['mvAmount']?>'>";
var mtAmount = "<input type='text' size='10' class='form-control form-control-sm text-right amountNumber' name='mtAmount' value='<?=$row['mtAmount']?>'>";
var expecteDay = "<input type='text' size='10' class='form-control form-control-sm text-center dateType' name='' value='2029-01-01'>";

var tableRow = "<td>"+checkbox+"</td>" + "<td>"+sunbun+"</td>" + "<td>"+startDateInline+"</td>" + "<td>"+endDateInline+"</td>" + "<td>"+mAmount+mvAmount"</td>" + "<td>"+mtAmount+"</td>";
