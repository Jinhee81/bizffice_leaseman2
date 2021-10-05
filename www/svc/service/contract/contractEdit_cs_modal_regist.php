<!-- 청구번호 모달  -->
<div class="modal fade" id="pPay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">

    <div class="modal-content">
      <!-- <input type="hidden" name="payid" value=""> -->

      <div class="modal-header">
        <h6 class="modal-title">입금처리 - 청구번호 <span id='payId'></span></h6>

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
                <input type="text" class="form-control form-control-sm" id="expectedAmount" numberOnly disabled>
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
                <input type="text" class="form-control form-control-sm" id="expectedDate">
              </div>
          </div>
          <div class="form-row">
               <div class="form-group col-md-4 mb-0">
                 <p class="text-left">입금구분</p>
               </div>
               <div class="form-group col-md-8 mb-0">
                 <select class="form-control form-control-sm" id="executiveDiv">
                   <option value="계좌">계좌</option>
                   <option value="현금">현금</option>
                   <option value="카드">카드</option>
                 </select>
               </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4 mb-0">
                <p class="text-left">입금일</p>
              </div>
              <div class="form-group col-md-8 mb-0">
                <input type="text" id="executiveDate" class="form-control form-control-sm dateType" style="color:#F7819F;" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4 mb-0">
                <p class="text-left">입금액</p>
              </div>
              <div class="form-group col-md-6 mb-0">
                <input type="text" id="executiveAmount" class="form-control form-control-sm amountNumber" style="color:#F7819F;" numberOnly required>
              </div>
              <div class="form-group col-md-2 mb-0">
                <p class="text-left">원</p>
              </div>
          </div>
        </div>
      </div><!-- modal body end -->

      <div class="modal-footer">

      </div>
    </div><!-- modal content end -->

  </div><!-- modal dialog end -->
</div><!-- modal fade end -->

<script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

</script>
