<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
// include "contractEdit_condi0.php";
 ?>
<!-- Modal -->
<div class="modal" tabindex="-1" id="modal_amount">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">임대료 내역 - 계약번호 <span id='contractNumber'></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        include "contractEdit_cs0.php";
         ?>
      </div>
    </div>
  </div>
</div>
