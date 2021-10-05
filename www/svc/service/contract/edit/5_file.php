<div class="p-3 mb-2 text-dark border border-info rounded">
  <form name="uploadForm">
    <label for="">첨부파일</label>
    <input type="file" name="upfile" id="upfile">
    <input type="button" name="uploadBtn" value="업로드" onclick="fnUpload()">
    <input type="hidden" name="contractId" value="<?=$filtered_id?>">
  </form>

  <div class="mt-3">
    <table class="table table-sm table-hover text-center">
      <thead>
        <tr class="table-secondary">
          <td class="">순번</td>
          <td class="">파일명</td>
          <td class="mobile">용량</td>
          <td class="mobile">등록일시</td>
          <td class="mobile">관리</td>
        </tr>
      </thead>
      <tbody id="file11">

      </tbody>
    </table>
    <small>(1)파일등록할수 있는 확장자는 'hwp', 'xls', 'xlsx', 'doc', 'docx', 'pdf', 'jpg', 'jpeg', 'gif', 'png', 'txt', 'ppt', 'pptx', 'tiff'입니다. <br>
      (2)파일은 5MB까지만 업로드 가능합니다.<br>
      <!-- (3)아이폰의 사진은 파일에서 jpg확장자로 변환후 등록하여주세요. -->
    </small>
  </div>
</div>
