<section class="container">
  <div class="jumbotron row mb-2 pt-3 pb-3 border border-dark rounded">
    <div class="col col-md-3">
      <button type='button' class='btn btn-sm btn-outline-primary' data-toggle="modal" data-target="#smsModal1" id="smsBtn"><i class="far fa-envelope"></i> 보내기</button>
      <a href="/svc/service/sms/sent.php">
      <button class="btn btn-sm btn-dark" id="smsSettingBtn"><i class="fas fa-angle-double-right"></i> 보낸문자목록</button></a>
    </div>
    <div class="col col-md-9">
      <div class="row justify-content-end mr-0">
        <a href="contract_edit.php?id=<?=$filtered_id?>">
          <button name="contractEdit" class="btn btn-dark btn-sm mr-1">계약수정</button>
        </a>
        <button type="button" name="contractDelete" class="btn btn-dark btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="청구정보가 없어야 삭제가능합니다">삭제하기</button>
        <?php
        if($status==='중간종료'){
          echo '<button type="button" name="middleEndCansel" class="btn btn-outline-danger btn-sm">중간종료해지</button>';
        } else {
          echo '<button type="button" name="middleEnd" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalEnd">중간종료</button>';
        }
         ?>
      </div>
    </div>
  </div>
</section>
