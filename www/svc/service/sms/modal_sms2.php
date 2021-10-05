<!-- Modal2, 상용구있음 -->
<div class="modal fade" id="smsModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">문자보내기(<span id="modalsmstitle"></span>)<span class="badge badge-info" id="href_smsSetting">상용구설정바로가기</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- <div class="d-flex justify-content-center">
          <a href="/service/sms/smsSetting.php"><button class="btn btn-sm btn-block btn-dark" id="smsSettingBtn">상용구설정 바로가기</button></a>
        </div> 이건 막상 넣으니 이상해서 빼기로 함-->

        <table class="table table-borderless" id="checkboxTestTbl2">
          <thead id="thead2">
            <tr>
              <td><input type="checkbox" checked></td>
              <td colspan="3">
                <div class="row" style="padding-left:12px;">
                  <select class="form-control form-control-sm mr-1" style="width: 10rem;" id="smsTime2">
                    <option value="immediately">즉시전송</option>
                    <option value="reservation">예약전송</option>
                  </select>
                  <input type="text" class="form-control form-control-sm mr-1" name="sendphonenumber" readonly style="width: 11rem;">
                  <button type="button" name="button" class="btn btn-sm btn-primary" style="width: 3rem;" id="smsSendBtn2">전송</button>
                </div>
                <div class="row mt-1" style="padding-left:12px;" id="timeSet2">
                </div>

              </td>

            </tr>
          </thead>
          <tbody id="tbody2">

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
