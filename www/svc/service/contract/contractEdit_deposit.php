<div class="p-3 mb-2 text-dark border border-info rounded">
  <!-- <h5>보증금 현황<span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info btn-sm" name="depositSaveBtn">저장</button></span></h5> -->

  <table class="table table-sm table-hover text-center mt-3">
    <tr class="table-secondary">
      <td width="" class="mobile">입금일</td>
      <td width="" class="mobile">입금액</td>
      <td width="" class="mobile">출금일</td>
      <td width="" class="mobile">출금액</td>
      <td width="" class="">잔액</td>
      <td width="" class="mobile">저장일시</td>
      <td width="" class="mobile"></td>
    </tr>
    <tr>
      <td class="mobile">
        <input type="text" name="depositInDate" class="form-control form-control-sm dateType text-center" value="<?=$row_deposit['inDate']?>">
      </td>
      <td class="mobile">
        <input type="text" name="depositInAmount" class="form-control form-control-sm amountNumber text-center" value="<?=$row_deposit['inMoney']?>" numberOnly>
      </td>
      <td class="mobile">
        <input type="text" name="depositOutDate" class="form-control form-control-sm dateType text-center" value="<?=$row_deposit['outDate']?>">
      </td>
      <td class="mobile">
        <input type="text" name="depositOutAmount" class="form-control form-control-sm amountNumber text-center" value="<?=$row_deposit['outMoney']?>" numberOnly>
      </td>
      <td class="">
        <input type="text" name="depositMoney" class="form-control form-control-sm amountNumber text-center" value="<?=$row_deposit['remainMoney']?>" readonly numberOnly>
      </td>
      <td class="mobile"><?=$row_deposit['saved']?></td>
      <td><button type="button" class="btn btn-info btn-sm" name="depositSaveBtn">저장</button></td>
    </tr>
  </table>
</div>
