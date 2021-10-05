<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);

$sql = "select
            building_id, bName,
            title,
            amount1,
            amount2,
            amount3,
            vat
        from fixcost
        join building
              on fixcost.building_id = building.id
        where fixcost.id = {$_POST['id']}";

// echo $sql;

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

// print_r($row);

$output = '<div class="container">';

$output .= '
<div class="form-row">
  <div class="form-group col-md-4 mb-2">
    <label>관리물건</label>
  </div>
  <div class="form-group col-md-8 mb-2">
    <select class="form-control form-control-sm" id="select2" name="buildingE" readonly>
      <option value="'.$row['building_id'].'">'.$row['bName'].'</option>
    </select>
  </div>
</div>';//관리물건부문


$output .='
<div class="form-row">
  <div class="form-group col-md-4 mb-2">
    <label>내역</label>
  </div>
  <div class="form-group col-md-8 mb-2">
    <input type="text" class="form-control form-control-sm text-left" name="titleE" value="'.$row['title'].'" required readonly>
    <input type="hidden" value="'.$_POST['id'].'" name="fixcostid">
  </div>
</div>';



if($row['vat']==='vatYes'){
  $output .='
  <div class="form-row">
    <div class="form-group col-md-4 mb-2">
      <label>금액</label>
    </div>
    <div class="form-group col-md-8 mb-2">
      <input type="text" class="form-control form-control-sm text-left amountNumber numberComma" name="amount1E" value="'.$row['amount1'].'" numberOnly required>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptionsE" id="inlineRadio1E" value="vatYes" checked>
        <label class="form-check-label" for="inlineRadio1">
          <small>부가세 포함</small>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptionsE" id="inlineRadio2E" value="vatNo">
        <label class="form-check-label" for="inlineRadio2">
          <small>부가세 별도</small>
        </label>
      </div>
    </div>
  </div>';
} else {
  $output .='
  <div class="form-row">
    <div class="form-group col-md-4 mb-2">
      <label>금액</label>
    </div>
    <div class="form-group col-md-8 mb-2">
      <input type="text" class="form-control form-control-sm text-left amountNumber grey numberComma" name="amount1E" value="'.$row['amount1'].'" numberOnly required>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptionsE" id="inlineRadio1E" value="vatYes">
        <label class="form-check-label" for="inlineRadio1">
          <small>부가세 포함</small>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptionsE" id="inlineRadio2E" value="vatNo" checked>
        <label class="form-check-label" for="inlineRadio2">
          <small>부가세 별도</small>
        </label>
      </div>
    </div>
  </div>';
}

$output .= '
<div class="form-row">
  <div class="form-group col-md-4 mb-0">
    <p class="text-right">
      <small>공급가액</small>
    </p>
  </div>
  <div class="form-group col-md-8 mb-0">
    <input type="text" class="form-control form-control-sm text-right grey numberComma" name="amount2E" value="'.$row['amount2'].'" numberOnly required>
  </div>
</div>';

$output .= '
<div class="form-row">
  <div class="form-group col-md-4 mb-0">
    <p class="text-right">
      <small>세액</small>
    </p>
  </div>
  <div class="form-group col-md-8 mb-0">
    <input type="text" class="form-control form-control-sm text-right grey numberComma" name="amount3E" value="'.$row['amount3'].'" numberOnly required>
  </div>
</div>
</div>';

echo $output;

?>
<script>
$(".numberComma").number(true);

$("input:text[numberOnly]").on('click', function(){
  $(this).select();
})

$('input[name=amount1E]').on('keyup', function(){
  var amount1 = Number($(this).val());

  var vat = $(':input:radio[name=inlineRadioOptionsE]:checked').val();

  if(vat === 'vatYes'){
    var amount2 = amount1 / 1.1;
    var amount3 = amount1 - amount2;
  } else {
    var amount2 = amount1;
    var amount3 = amount1 - amount2;
  }

  $('input[name=amount2E]').val(amount2);
  $('input[name=amount3E]').val(amount3);
})


$(':input:radio[id=inlineRadio1E]').on('click', function(){
  var amount1 = Number($('input[name=amount1E]').val());

  var amount2 = amount1 / 1.1;
  var amount3 = amount1 - amount2;

  $('input[name=amount2E]').val(amount2);
  $('input[name=amount3E]').val(amount3);
})

$(':input:radio[id=inlineRadio2E]').on('click', function(){
  var amount1 = Number($('input[name=amount1E]').val());

  var amount2 = amount1;
  var amount3 = amount1 - amount2;

  $('input[name=amount2E]').val(amount2);
  $('input[name=amount3E]').val(amount3);
})


console.log('minsun');
</script>
