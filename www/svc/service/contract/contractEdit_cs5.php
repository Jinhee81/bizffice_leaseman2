<!-- cs는 charge Schedule (청구스케줄)의 약자 파일 -->
<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
 ?>
<div class="p-3 mb-2 text-dark border border-info rounded">

    <div class="row">
      <div class="col">
        <button type="button" id="button5" class="btn btn-outline-info btn-sm">1개월 추가</button>
        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#nAddBtn">n개월 추가</button>
        <button type="button" id="button7" class="btn btn-outline-info btn-sm">삭제</button>
      </div>
      <div class="col-md-5 row justify-content-end">
        <input type="text" class="form-control form-control-sm dateType text-center mr-1" style="width:120px" value="" placeholder="입금예정일변경" id="groupExpecteDay" data-toggle="tooltip" data-placement="left" title="체크된것의 입금예정일을 변경합니다">
        <select class="form-control form-control-sm mr-1" id="paykind" data-toggle="tooltip" data-placement="top" title="체크된것의 입금수단을 변경합니다" style="width:100px" >
          <option value="계좌">계좌</option>
          <option value="현금">현금</option>
          <option value="카드">카드</option>
        </select>
        <button type="button" id="button1" class="btn btn-outline-info btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="체크된것을 청구설정합니다">청구설정</button>
        <button type="button" id="buttonDirect" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="top" title="체크된것을 입금예정일 날짜로 입금처리합니다(청구설정+입금처리)">즉시입금</button>
      </div>
      <div class="col">

      </div>
    </div>

  <div class="row mt-2">
    <div class="col col-md-8 text-left">
      선택 <span id=selectcount>0</span>건, 공급가액 <span id=selectamount>0</span>원, 세액 <span id=selectvamount>0</span>원, 합계 <span id=selecttamount>0</span>원
    </div>
    <div class="col col-md-4 justify-content-end text-right">
      미납액 : <?=$sum?>원
    </div>
  </div>

  <div class="table-responsive mainTable">
    <table class="table table-sm table-hover text-center table-borderless" style="width:100%" cellspacing="0" id="checkboxTestTbl" name="tableAmount">
      <thead>
        <tr class="table-info">
          <td width="3%" class="fixedHeader"><input type="checkbox" id="allselect"></td>
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
