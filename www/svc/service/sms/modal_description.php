<!--청구모달시작-->
<div class="modal fade" id="smsDescription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">

    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="far fa-envelope"></i>문자보기</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container" style="">
          <!-- <div class='row mb-2'>
            <div class='row justify-content-md-center'>
              <div class="col">
                <textarea id='modaltextarea' class='form-control' style='background-color: #FAFAFA;width:160px;'>
                </textarea>
              </div>
            </div>
          </div> -->
          <div class='row mb-2'>
            <!-- <div class='col col-md-3'>내용</div> -->
            <div class='col'>
              <textarea id='modaltextarea' class='form-control' style='background-color: #FAFAFA;' rows="8">
              </textarea>
            </div>
          </div>
          <div class='row mb-2'>
            <div class='col col-md-4'>받는사람</div>
            <div class='col col-md-8'><input class='form-control form-control-sm' id='mcustomer' disabled></div>
          </div>
          <div class='row mb-2'>
            <div class='col col-md-4'>수신번호</div>
            <div class='col col-md-8'><input class='form-control form-control-sm' id='recievenumber' disabled></div>
          </div>
          <div class='row mb-2'>
            <div class='col col-md-4'>발신번호</div>
            <div class='col col-md-8'><input class='form-control form-control-sm' id='sentnumber' disabled></div>
          </div>
          <div class='row mb-2'>
            <div class='col col-md-4'>바이트</div>
            <div class='col col-md-8'><input class='form-control form-control-sm' id='mbyte' disabled></div>
          </div>
        </div>
      </div>


      <!-- <div class="modal-footer">
        <button type='button' class='btn btn-secondary btn-sm mr-0' data-dismiss='modal'>닫기</button>
      </div> -->
    </div>

  </div>
</div>
