<!-- Modal 고정비 넣기 -->
<div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">고정비 넣기 <span class="badge badge-danger" id="href_fixcost">new 생성하기</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="form-group row justify-content-md-center">
                <div class="form-group col-md-2 mb-2">
                    <p class="text-right">관리물건</p>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <select class="form-control form-control-sm selectCall" name="modalbuilding" disabled>
                    </select><!---->
                </div>
            </div>
            <div id="fixcostListModal">

            </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
        <button type="button" class="btn btn-primary" id="btn1">넣기</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal 고정비 넣기 End-->
