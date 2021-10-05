<div class="p-3 mb-2 text-dark border border-info rounded">
  <!-- <h5>메모</h5> -->
  <div class="form-row">
    <div class="col col-sm-2">
      <input type="text" class="form-control form-control-sm text-center" id="memoInputer" value="<?=$_SESSION['manager_name']?>">
    </div>
    <div class="col col-sm-8">
      <input type="text" class="form-control form-control-sm text-center" id="memoContent" value="" placeholder="계약의 메모를 입력하세요.">
    </div>
    <div class="col col-sm-2">
      <button type="button" id="memoButton" class="btn btn-outline-secondary btn-sm btn-block">등록</button>
    </div>
  </div>
  <table class="table table-sm table-hover text-center mt-3">
    <tr class="table-secondary">
      <td style="width:5%" class="">순번</td>
      <td style="width:10%" class="">작성자</td>
      <td style="width:45%" class="">내용</td>
      <td style="width:30%" class="mobile">등록일시/수정일시</td>
      <!-- <td style="width:20%">수정일시</td> -->
      <td style="width:10%" class="mobile">관리</td>
    </tr>
    <?php
    if(count($memoRows)===0){
      echo "<tr><td colspan='6'>등록된 메모가 없습니다.</td></tr>";
    } else {
        for ($i=0; $i < count($memoRows); $i++) { ?>
    <tr>
        <td>
            <?=$memoRows[$i]['num']?>
            <input type="hidden" name="memoid" value="<?=$memoRows[$i]['idrealContract_memo']?>">
        </td>
        <td class="">
            <input class="form-control form-control-sm text-center grey" name="memoContent" value="<?=$memoRows[$i]['memoCreator']?>"></td>
        </td>
        <td class=""><textarea name="memoContent" class="form-control form-control-sm grey" rows="1" cols="80"><?=$memoRows[$i]['memoContent']?></textarea>
        <td class="mobile">
          <small class="grey"><?=$memoRows[$i]['created']?>/<?php if(!$memoRows[$i]['updated']){
            echo "-";
          } else {
            echo $memoRows[$i]['updated'];
          } ?></small>
        </td>
     <!-- <td><label class="grey"><//?=$memoRows[$i]['updated']?></label></td> -->
        <td id="append" class="mobile">

          <label class="small grey" name="memoEdit"><u>수정</u></label>&nbsp;
          <label class="small grey" name="memoDelete"><u>삭제</u></label>
        </td>
    </tr>
<?php }
} ?>
  </table>
</div>
