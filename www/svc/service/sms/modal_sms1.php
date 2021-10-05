<!-- Modal1, 상용구없음-->
<div class="modal fade" id="smsModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">문자보내기</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-md-6">
                        <textarea rows="8" cols="80" class="form-control" style="background-color: #FAFAFA;"
                            id="textareaOnly"></textarea>
                        <div class="">
                            <p class="text-right mb-0">
                                <span id="getByteOnly"></span>
                                / 80 bytes
                            </p>
                            <p class="text-right" id="smsDivOnly"></p>
                            <!-- <p>전송일시</p> -->
                            <select class="form-conrol col" style="color:#848484;" id="smsTime">
                                <option value="immediately">즉시전송</option>
                                <option value="reservation">예약전송</option>
                            </select>
                            <div id="timeSet" class="mb-2">
                            </div>
                            <div class="row mb-2">
                                <div class="col col-sm-4 pl-0 pr-0">
                                    <label class="col pr-0">발송번호</label>
                                </div>
                                <div class="col col-sm-8">
                                    <input type="text" class="form-control form-control-sm col" name="sendphonenumber"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mb-2 pl-2 pr-2">
                                <small>발송번호는 상단 <i class="fas fa-user"></i>나의정보에서 설정합니다.</small>
                            </div>

                        </div>

                    </div>
                    <div class="col col-md-6">
                        <table class="table table-sm text-center" style="color:#848484;">
                            <thead>
                                <tr class="table-dark">
                                    <td>순번</td>
                                    <td>수신번호</td>
                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="">
                    <button type="button" name="button" class="btn btn-primary btn-block" id="smsSendBtn1">전송하기</button>
                </div>
            </div>
        </div>
    </div>
</div>