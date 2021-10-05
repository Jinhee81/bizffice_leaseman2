<!--납부완료화면에서 입금일 누르면 나오는 팝업-->
<div class="modal fade" id="pPay2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">

    <div class="modal-content">

      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">계약정보</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container">
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">계약번호</p>
            </div>
            <div class="form-group col-md-7 mb-0">
              <input type="text" id="modalrid" class="form-control form-control-sm" disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">청구번호</p>
            </div>
            <div class="form-group col-md-7 mb-0">
              <input type="text" id="modalpid" class="form-control form-control-sm" disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">계약시작일</p>
            </div>
            <div class="form-group col-md-7 mb-0">
              <input type="text" name="m2startDate" class="form-control form-control-sm" value="" numberOnly disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">계약종료일</p>
            </div>
            <div class="form-group col-md-7 mb-0">
              <input type="text" name="m2endDate" class="form-control form-control-sm" value="" numberOnly disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">계약기간</p>
            </div>
            <div class="form-group col-md-4 mb-0">
              <input type="text" class="form-control form-control-sm amountNumber" name="m2duration" numberOnly required disabled>
            </div>
            <div class="form-group col-md-3 mb-0">
              <p class="text-left">개월</p>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">청구시작일</p>
            </div>
            <div class="form-group col-md-7 mb-0">
              <input type="text" name="m2pStartDate" class="form-control form-control-sm pink" value="" numberOnly disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">청구종료일</p>
            </div>
            <div class="form-group col-md-7 mb-0">
              <input type="text" name="m2pEndDate" class="form-control form-control-sm pink" value=""  disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5 mb-0">
              <p class="text-left">청구기간</p>
            </div>
            <div class="form-group col-md-4 mb-0">
              <input type="text" class="form-control form-control-sm amountNumber pink" name="m2pDuration" numberOnly required disabled>
            </div>
            <div class="form-group col-md-3 mb-0">
              <p class="text-left">개월</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button>
        <!-- <button type='button' class='btn btn-warning btn-sm mr-0 getExecuteBack'>청구취소</button> -->
        <!-- <button type='button' class='btn btn-primary btn-sm getExecute'>수정</button> -->
      </div>
    </div>

  </div>
</div>
