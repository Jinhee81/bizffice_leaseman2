<!-- cs는 charge Schedule (청구스케줄)의 약자 파일 -->
<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
 ?>
<div class="p-3 mb-2 text-dark border border-info rounded">

  <div class="row mt-2">
    <div class="col col-md-8 text-left">
      선택 <span id=selectcount>0</span>건, 공급가액 <span id=selectamount>0</span>원, 세액 <span id=selectvamount>0</span>원, 합계 <span id=selecttamount>0</span>원
    </div>
    <div class="col col-md-4 justify-content-end text-right">
      미납액 : <span id=delayAmount></span>원
    </div>
  </div>

  <div class="table-responsive mainTable">
    <table class="table table-sm table-hover text-center table-borderless" style="width:100%" cellspacing="0" id="checkboxTestTbl" name="tableAmount">
      <thead>
        <tr class="table-info">
          <td width="3%" class="fixedHeader"><input type="checkbox" id="allselect2"></td>
          <td width="5%" colspan="" class="fixedHeader text-left">
            <span class="">순번</span>
          </td>
          <td width="20%" colspan="" class="fixedHeader text-left">
            <span class="">시작일~</span>
            <span class="">종료일</span>
          </td>
          <td width="" colspan="" class="fixedHeader text-left">
            <span class="">공급가액,</span>
            <span class="">세액,</span>
            <span class="">합계,</span>
            <span class="">입금예정일,</span>
            <span class="">입금구분</span>
          </td>
          <!-- <td width="" colspan="" class="fixedHeader text-left">
             <span class="ml-5 pl-5">예정일</span>
            <span class="">입급구분</span>
            <span class="">청구번호</span>
          </td> -->
        </tr>
      </thead>
      <tbody id="schedule">
      </tbody>
    </table>
  </div>
</div>
