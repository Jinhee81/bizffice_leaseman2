<div class="p-3 mb-2 text-dark border border-info rounded">
    <!-- <div class="row justify-content-md-center">
          <div class="col col-sm-5">
            <form action="p_file_upload.php" method="post" enctype="multipart/form-data">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                    <label class="custom-file-label" for="inputGroupFile02">파일선택</label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon02">등록</button>
                  </div>
                </div>
            </form>
          </div>
      </div> -->
  <!-- <h5>첨부파일</h5> -->
  <form name="uploadForm" id="uploadForm" method="post" action="p_file_upload.php" enctype="multipart/form-data">
    <label for="">첨부파일</label>
    <input type="file" name="upfile" id="upfile">
    <input type="hidden" name="contract" value="<?=$filtered_id?>">
    <input type="button" name="uploadBtn" value="업로드" onclick="fnUpload()">
  </form>
  <div class="mt-3">
    <table class="table table-sm table-hover text-center">
      <tr class="table-secondary">
        <td class="">순번</td>
        <td class="">파일명</td>
        <td class="mobile">용량</td>
        <td class="mobile">등록일시</td>
        <td class="mobile">관리</td>
      </tr>
      <?php
      if(count($fileRows)===0){
        echo "<tr><td colspan='5'>등록된 파일이 없습니다.</td></tr>";
      } else {
        for ($i=0; $i < count($fileRows); $i++) { ?>
      <tr>
        <td class="">
          <?=$fileRows[$i]['num']?>
          <input type="hidden" name="fileid" value="<?=$fileRows[$i]['file_id']?>">
        </td>
        <td class="">
          <a href="download.php?file_id=<?=$fileRows[$i]['file_id']?>" target="_blank"><?=$fileRows[$i]['name_orig']?></a>
        </td>
        <td class="mobile">
          <?=$fileRows[$i]['bytes']?>
        </td>
        <td class="mobile"><?=$fileRows[$i]['reg_time']?></td>
        <td class="mobile">
          <button type="submit" name="fileDelete" class="btn btn-default grey">
            <i class='far fa-trash-alt'></i>
          </button>
        </td>
        </tr>
        <?php }
      } ?>
    </table>
    <small>(1)파일등록할수 있는 확장자는 'hwp', 'xls', 'xlsx', 'doc', 'docx', 'pdf', 'jpg', 'jpeg', 'gif', 'png', 'txt', 'ppt', 'pptx', 'tiff'입니다. <br>
      (2)파일은 5MB까지만 업로드 가능합니다.<br>
      <!-- (3)아이폰의 사진은 파일에서 jpg확장자로 변환후 등록하여주세요. -->
    </small>
  </div>
</div>
