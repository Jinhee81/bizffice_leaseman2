<!-- Modal 변동비 넣기 -->
<div class="modal fade bd-example-modal-sm" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">변동비 입력하기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="p_costlist_add_flex.php">
        <div class="modal-body">
          <div class="container">
              <div class="form-group row justify-content-md-center">
                  <div class="form-group col-md-3 mb-2 pr-1">
                    <select class="form-control form-control-sm" name="modalbuilding" readonly>
                    </select>
                  </div>
                  <div class="form-group col-md-3 mb-2 pl-0 pr-1">
                    <select class="form-control form-control-sm" name="modalyear" readonly>
                    </select>
                  </div>
                  <div class="form-group col-md-3 mb-2 pl-0">
                    <select class="form-control form-control-sm" name="modalmonth" readonly>
                    </select>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-3 mb-0">
                      <p class="text-center mb-1">내역</p>
                  </div>
                  <div class="form-group col-md-3 mb-0">
                      <p class="text-center mb-1">금액</p>
                  </div>
                  <div class="form-group col-md-3 mb-0">
                      <p class="text-center mb-1">지출일자</p>
                  </div>
                  <div class="form-group col-md-3 mb-0">
                      <p class="text-center mb-1">증빙일자</p>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-3 mb-0">
                      <input type="text" class="form-control form-control-sm text-center grey" name="title" value="" required>
                      <p class="text-right mb-0"><small>공급가액</small></p>
                      <p class="text-right"><small>세액</small></p>
                  </div>
                  <div class="form-group col-md-3 mb-0">
                      <input type="text" class="form-control form-control-sm text-center amountNumber grey numberComma" name="mamount1" value="0" numberOnly required>
                      <input type="text" class="form-control form-control-sm text-right amountNumber grey" name="mamount2" value="0" numberOnly required>
                      <input type="text" class="form-control form-control-sm text-right grey amountNumber" name="mamount3" value="0" numberOnly required>
                  </div>
                  <div class="form-group col-md-3 mb-0">
                    <input type="text" class="form-control form-control-sm text-center dateType" name="payDate" value="" required>
                  </div>
                  <div class="form-group col-md-3 mb-0">
                    <input type="text" class="form-control form-control-sm text-center dateType" name="taxDate" value="">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6 mb-0">
                    <div class="row justify-content-end mr-0">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="vatYes" checked>
                        <label class="form-check-label" for="inlineRadio1"><small>부가세 포함</small></label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="vatNo">
                        <label class="form-check-label" for="inlineRadio2"><small>부가세 별도</small></label>
                      </div>
                    </div>
                  </div>

              </div>
              <div class="form-row">
                  <p class="mb-1">특이사항</p>
                  <input type="text" class="form-control form-control-sm text-center" name="etc" value="">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
          <button type="submit" class="btn btn-primary">넣기</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal 변동비 넣기 End-->
