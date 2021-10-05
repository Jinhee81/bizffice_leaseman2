<!-- n개월추가 모달 시작  -->
<div class="modal fade bd-example-modal-sm" id="nAddBtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="">n개월 추가/청구설정/입금완료</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label>추가개월수</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-right" name="addMonth" value="" numberOnly required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label>공급가액</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-right amountNumber grey" name="modalAmount1" numberOnly required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label>세액</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-right amountNumber grey" name="modalAmount2" numberOnly required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label>합계</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-right amountNumber grey" name="modalAmount3" numberOnly required disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label class="pink">입금예정일</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-center grey" id="mpExpectedDate2">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label class="pink">입금완료일</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-center grey" id="mexecutiveDate2">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label>입금액</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <input type="text" class="form-control form-control-sm text-center grey amountNumber" id="mexecutiveAmount2" value="" disabled numberOnly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5 mb-1">
                    <label>입금구분</label>
                </div>
                <div class="form-group col-md-7 mb-1">
                    <select class="form-control form-control-sm" id="executiveDiv2">
                      <option value="계좌">계좌</option>
                      <option value="현금">현금</option>
                      <option value="카드">카드</option>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="container">
        <div class="modal-footer-n">
          <button type="button" class="btn btn-sm btn-secondary mr-0" data-dismiss="modal">닫기</button>
          <button type="button" class="btn btn-sm btn-primary mr-0" id="buttonm3">추가하기</button>
          <button type="button" class="btn btn-sm btn-warning mr-0" id="buttonm2">청구설정</button>
          <button type="button" class="btn btn-sm btn-warning mr-0" id="buttonm1">입금완료</button>
        </div>
        <div class="container pl-3 pr-3">
          <p class="pink" style="line-height:15px;font-size:small;">* 입금예정일 또는 입금완료일을 넣으면 해당날짜로 일괄 청구/입금처리 됩니다. 넣지 않으면 월단위로 청구/입금처리 됩니다. ^_^</p>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div> -->
    </div>
  </div>
</div>
<!-- n개월추가 모달 끝  -->
