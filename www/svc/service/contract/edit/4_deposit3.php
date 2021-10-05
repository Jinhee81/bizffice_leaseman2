<div class="p-3 mb-2 text-dark border border-info rounded">
    <!-- 환불금액이 추가된 것 -->

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
        <tr class="table-secondary">
            <td class="">중간종료일</td>
            <td class="">환불공급가액</td>
            <td class="">환불세액</td>
            <td class="">환불금액</td>
            <td class="">환불구분</td>
            <td class="">환불일자</td>
            <td style="width:10%"></td>
        </tr>
        <tr>
            <td class="" name=endDate3>
                <input type="text" class="form-control form-control-sm dateType text-center" name="enddate33"
                    id="enddate33">
                <input type="hidden" name="rPayid">
            </td>
            <td class="">
                <input type="text" class="form-control form-control-sm amountNumber pink text-right" name="rAmount"
                    numberOnly>
            </td>
            <td class="">
                <input type="text" class="form-control form-control-sm amountNumber pink text-right" name="rvAmount"
                    numberOnly>
            </td>
            <td class="">
                <input type="text" class="form-control form-control-sm amountNumber pink text-right" name="rtAmount"
                    numberOnly>
            </td>
            <td class="" name=rKind>
                <select class="form-control form-control-sm center" id="executiveDiv3">
                    <option value="계좌">계좌</option>
                    <option value="현금">현금</option>
                    <option value="카드">카드</option>
                </select>
            </td>
            <td class="" name=rDate>
                <input type="text" class="form-control form-control-sm dateType text-center" name="enddate44"
                    id="enddate44">
            </td>
            <td class="" name=textlabel>
            </td>
        </tr>
    </table>
</div>