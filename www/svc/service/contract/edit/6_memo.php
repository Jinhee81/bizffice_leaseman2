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
  <table class="table table-sm table-bordered table-hover text-center mt-3">
    <thead>
      <tr class="table-secondary">
        <td style="width:5%" class="">순번</td>
        <td style="width:10%" class="">작성자</td>
        <td style="width:40%" class="">내용</td>
        <td style="width:15%" class="mobile">등록일시</td>
        <td style="width:15%" class="mobile">수정일시</td>
        <td style="width:9%" class="mobile">관리</td>
      </tr>
    </thead>
    <tbody id="memo11">
      
    </tbody>
  </table>
</div>
