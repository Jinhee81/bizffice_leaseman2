<!-- 이건 납부예정, 납부완료에서 보는 버튼없는 스케줄파일 -->
<?php
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
 ?>
<div class="p-3 mb-2 text-dark border border-info rounded">

    <div class="table-responsive mainTable">
        <table class="table table-sm table-hover text-center table-borderless" style="width:100%" cellspacing="0"
            name="tableAmount" id="modalTable">
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
                    <td width="35%" colspan="" class="fixedHeader text-left">
                        <span class="">공급가액,</span>
                        <span class="">세액,</span>
                        <span class="">합계,</span>
                        <span class="">입금예정일,</span>
                        <span class="">입금구분</span>
                    </td>
                    <td width="37%" colspan="" class="fixedHeader text-left">
                        <span class="">수납구분,</span>
                        <span class="">청구번호,</span>
                        <span class="">(개월수),</span>
                        <span class="">입금액,</span>
                        <span class="">입금일,</span>
                        <span class="">증빙일</span>
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