<div class="p-3 mb-2 text-dark border border-info rounded">
    <!-- <h5>보증금 현황<span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info btn-sm" name="depositSaveBtn">저장</button></span></h5> -->

    <table class="table table-sm table-hover text-center mt-3">
        <tr class="table-secondary">
            <td width="" class="mobile">입금일</td>
            <td width="" class="">입금액</td>
            <td width="" class="mobile">출금일</td>
            <td width="" class="">출금액</td>
            <td width="" class="">잔액</td>
            <td width="" class="mobile">저장일시</td>
            <td width="" class="mobile"></td>
        </tr>
        <tr>
            <td class="mobile">
                <input type="text" name="depositInDate" class="form-control form-control-sm dateType text-center">
            </td>
            <td class="">
                <input type="text" name="depositInAmount" class="form-control form-control-sm amountNumber text-center"
                    numberOnly>
            </td>
            <td class="mobile">
                <input type="text" name="depositOutDate" class="form-control form-control-sm dateType text-center">
            </td>
            <td class="">
                <input type="text" name="depositOutAmount" class="form-control form-control-sm amountNumber text-center"
                    numberOnly>
            </td>
            <td class="">
                <input type="text" name="depositMoney" class="form-control form-control-sm amountNumber text-center"
                    readonly numberOnly>
            </td>
            <td class="mobile" name="saved"></td>
            <td class="mobile"><button type="button" class="btn btn-info btn-sm" name="depositSaveBtn">저장</button></td>
        </tr>
    </table>
</div>