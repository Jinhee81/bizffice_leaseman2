<div class="modal" tabindex="-1" id="modal_amount">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="mtitle"></span> - <label class="font-italic mb-0">계약번호 <span
                            class='contractNumber'></span>, <span class=customer11></span>, <span class=room11></span>
                        <span class="badge badge-info contractEditAll">전체화면열기</span></label>
                    <input type="hidden" id="mAmount_m">
                    <input type="hidden" id="mvAmount_m">
                    <input type="hidden" id="mtAmount_m">
                    <input type="hidden" id="payOrder_m">
                    <input type="hidden" id="customerId_m">
                    <input type="hidden" id="buildingId_m">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="" id="amountlist">
                    <?php
            include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/edit/3_schedule2.php";
         ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>