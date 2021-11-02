<!--청구모달시작-->
<div class="modal fade" id="pPay2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">납부처리 - 청구번호 <span class='payid'></span></h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-0">
                            <p class="text-left">예정금액</p>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <input type="text" name="modalpayamount" class="form-control form-control-sm" value=""
                                numberOnly disabled>
                        </div>
                        <div class="form-group col-md-2 mb-0">
                            <p class="text-left">원</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-0">
                            <p class="text-left">예정일</p>
                        </div>
                        <div class="form-group col-md-8 mb-0">
                            <input type="text" name="modalpaydate" class="form-control form-control-sm" value=""
                                disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-0">
                            <p class="text-left">구분</p>
                        </div>
                        <div class="form-group col-md-8 mb-0">
                            <select class="form-control form-control-sm" id="payKind">
                                <option value="계좌" name="kind1">계좌</option>
                                <option value="현금" name="kind2">현금</option>
                                <option value="카드" name="kind3">카드</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-0">
                            <p class="text-left">납부일</p>
                        </div>
                        <div class="form-group col-md-8 mb-0">
                            <input type="text" class="form-control form-control-sm dateType" style="color:#F7819F;"
                                name="modalexecutivedate" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-0">
                            <p class="text-left">납부액</p>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <input type="text" class="form-control form-control-sm amountNumber" style="color:#F7819F;"
                                name="modalexecutiveamount" numberOnly required>
                        </div>
                        <div class="form-group col-md-2 mb-0">
                            <p class="text-left">원</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button>
                <!-- <button type='button' class='btn btn-warning btn-sm mr-0 getExecuteBack'>청구취소</button> -->
                <button type='button' class='btn btn-primary btn-sm getExecute'>납부완료</button>
            </div>
        </div>

    </div>
</div>