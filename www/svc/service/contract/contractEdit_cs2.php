<!-- cs는 charge Schedule (청구스케줄)의 약자 파일 -->
<div class="p-3 mb-2 text-dark border border-info rounded">

  <div class="form-row">
    <div class="form-group col-md-6 mb-1">
      <table>
        <tr>
          <td width="8%"><button type="button" id="button5" class="btn btn-outline-info btn-sm mobile btn-block">1개월 추가</button></td>
          <td width="8%"><button type="button" class="btn btn-outline-info btn-sm mobile btn-block" data-toggle="modal" data-target="#nAddBtn">n개월 추가</button></td>
          <td width="6%"><button type="button" id="button7" class="btn btn-outline-info btn-sm mobile btn-block">삭제</button></td>
          <td width="6%"></td>
          <td width="10%"><input type="text" class="form-control form-control-sm dateType text-center" name="" value="" placeholder="입금예정일변경" id="groupExpecteDay" data-toggle="tooltip" data-placement="left" title="체크된것의 입금예정일을 변경합니다"></td>
          <td width="6%"><select class="form-control form-control-sm" id="paykind" data-toggle="tooltip" data-placement="top" title="체크된것의 입금수단을 변경합니다">
            <option value="계좌">계좌</option>
            <option value="현금">현금</option>
            <option value="카드">카드</option>
          </select></td>
        </tr>
      </table>
    </div>

    <div class="form-group col-md-6 mb-1">
      <div class="row justify-content-end mr-0">
        <button type="button" id="buttonDirect" class="btn btn-outline-danger btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="체크된것을 입금예정일 날짜로 입금처리합니다(청구설정+입금처리)">즉시입금</button>
        <button type="button" id="button1" class="btn btn-outline-info btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="체크된것을 청구설정합니다">청구설정</button>
        <button type="button" id="button2" class="btn btn-outline-info btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="체크된것의 청구정보를 취소합니다">청구취소</button>
        <button type="button" id="button3" class="btn btn-outline-info btn-sm mobile mr-1" data-toggle="tooltip" data-placement="top" title="체크된것들을 입금처리합니다(청구번호가있어야 입금처리 가능해요.)">일괄입금처리</button>
        <button type="button" id="button4" class="btn btn-outline-info btn-sm mobile mr-1" data-toggle="tooltip" data-placement="top" title="체크된것의 입금내역을 취소합니다">일괄입금취소</button>
      </div>
    </div>
  </div>

  <div class="row justify-content-end mr-0 mobile">
    미납액 : <?=$sum?>원
  </div>

  <div class="table-responsive mainTable">
    <table class="table table-sm table-hover text-center" style="width:100%" cellspacing="0" id="checkboxTestTbl">
      <thead>
        <tr class="table-info">
          <td width="3%" class="fixedHeader"><input type="checkbox" id="allselect"></td>
          <td width="3%" class="fixedHeader">순번</td>
          <td width="10%" class="fixedHeader">시작일</td>
          <td width="10%" class="fixedHeader">종료일</td>
          <!-- <td scope="col">종료일</td> -->
          <td width="8%" class="fixedHeader">공급가액/<br>세액</td>
          <!-- <td scope="col" class="mobile">세액</td> -->
          <td width="10%" class="fixedHeader">합계</td>
          <td width="10%" class="fixedHeader mobile">입금예정일</td>
          <td width="6%" class="fixedHeader mobile">입금구분</td>
          <td width="8%" class="fixedHeader mobile">청구번호/<br>(개월수)</td>
          <td width="8%" class="fixedHeader mobile">수납구분</td>
          <td width="10%" class="fixedHeader mobile">입금일/<br>입금(미납)액</td>
          <td width="8%" class="fixedHeader mobile">연체일수/<br>이자</td>
          <!-- <td scope="col" class="">연체이자</td> -->
          <td width="8%" class="fixedHeader mobile">증빙</td>
        </tr>
      </thead>
      <tbody id="schedule">
        <?php
        for ($i=0; $i < count($allRows); $i++) { ?>
        <tr>
          <td class=""><input type='checkbox' class='tbodycheckbox' name='csId' value='<?=$allRows[$i]['idcontractSchedule']?>'></td><!-- 체크박스 -->
          <td class="">
            <label class=""><?=$allRows[$i]['ordered']?></label>
            <?php $rowIndex = count($allRows) - (int)$allRows[$i]['ordered']; ?>
            <input type="hidden" name="rowid" value="<?=$rowIndex?>">
          </td><!-- 순번 -->
          <td class="">
            <label class=" mb-0"><?=$allRows[$i]['mStartDate']?></label>
          </td><!-- 시작일 -->
          <td class="">
            <label class=" mb-0"><?=$allRows[$i]['mEndDate']?></label>
          </td><!-- 종료일 -->
          <td class="">
            <?php
            if($allRows[$i]['payId']){
              echo "<label class='text-right numberComma mb-0'>".$allRows[$i]['mMamount']."</label><br><label class='text-right numberComma mb-0'>".$allRows[$i]['mVmAmount']."</label>";
              // echo "exists";
            } else {
              echo "<input type='text' size='10' class='form-control form-control-sm text-right amountNumber mb-0' name='mAmount' value='".$allRows[$i]['mMamount']."' numberOnly><input type='text' size='10' class='form-control form-control-sm text-right amountNumber mb-0' name='mAmount' value='".$allRows[$i]['mVmAmount']."' numberOnly>";
            }
             ?>
          </td><!-- 공급가액/세액 -->
          <td class="">
            <?php
            if($allRows[$i]['payId']){
              echo "<label class='text-right  numberComma'>".$allRows[$i]['mTmAmount']."</label>";
              // echo "exists";
            } else {
              echo "<input type='text' size='10' class='form-control form-control-sm text-right amountNumber' name='mAmount' value='".$allRows[$i]['mTmAmount']."' numberOnly>";
            }
            ?>
          </td><!-- 합계 -->
          <td class="mobile">
            <?php
            if($allRows[$i]['payId']){
              echo "<label class='text-center '>".$allRows[$i]['paySchedule2']['pExpectedDate']."</label>";
              // echo "exists";
            } else {
              echo "<input type='text' size='10' class='form-control form-control-sm text-center' name='expecteDay' value='".$allRows[$i]['mExpectedDate']."'>";
            }
            ?>
          </td><!-- 예정일 -->
          <td class="mobile">
            <?php
            if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
              if($allRows[$i]['paySchedule2']['executiveDate']){
                echo "<label class='text-center'>".$allRows[$i]['paySchedule2']['payKind']."</label>";
              } else { ?>
                <select class="form-control form-control-sm grey" name="payKind">
                  <option value="계좌"<?php if($allRows[$i]['paySchedule2']['payKind']=='계좌'){echo "selected";} ?>>계좌</option>
                  <option value="현금"<?php if($allRows[$i]['paySchedule2']['payKind']=='현금'){echo "selected";} ?>>현금</option>
                  <option value="카드"<?php if($allRows[$i]['paySchedule2']['payKind']=='카드'){echo "selected";} ?>>카드</option>
                </select>
              <?php }
             }
            ?>
          </td><!-- 입금구분 -->
          <td class="mobile">
            <?php
            if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
              echo "<label class='text-primary modalAsk mb-0' data-toggle='modal' data-target='#pPay'><u>".$allRows[$i]['payId']."</u></label></br><label class='mb-0'>(".$allRows[$i]['paySchedule2']['monthCount'].")"."</label>";
            }
            ?>
            <input type="hidden" name="monthCount" value="<?=$allRows[$i]['paySchedule2']['monthCount']?>">
          </td><!-- 청구번호,청구번호의 개월수 -->
          <td class="mobile">
            <?php
            if($allRows[$i]['payId']){
              if($allRows[$i]['paySchedule2']['getdiv2']==='geted') {
                echo "<label class='text-center green'>완납</label>";
              } elseif($allRows[$i]['paySchedule2']['getdiv2']==='get_delay') {
                echo "<label class='text-center green'>완납(연체)</label>";
              } elseif($allRows[$i]['paySchedule2']['getdiv2']==='not_get') {
                echo "<label class='text-center sky'>입금대기</label>";
            } else {
              echo "<label class='text-center pink'>미납</label>";
            }
          }
            ?>
          </td><!-- 수납구분-->
          <td class="mobile">
            <?php
            if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
              if($allRows[$i]['paySchedule2']['executiveDate']) {
                echo "<label class='mb-0 text-center green'>".$allRows[$i]['paySchedule2']['executiveDate']."</label><br>";
              } else {
                echo "<input type='text' class='form-control form-control-sm text-center grey' value='".$allRows[$i]['paySchedule2']['pExpectedDate']."'>";
              }
            }
             ?><!-- 입금일 -->
             <?php
             if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
               if($allRows[$i]['paySchedule2']['executiveDate']) {
                  echo "<label class='mb-0 text-center numberComma  green'>".$allRows[$i]['paySchedule2']['getAmount']."</label>";
               } else {
                 if($row3['pExpectedDate'] >= $currentDate){
                   echo "<label class='mb-0 text-center numberComma  sky'>"."&#40;".$allRows[$i]['paySchedule2']['ptAmount'].")"."</label>";
                 } else {
                   echo "<label class='mb-0 text-center  pink'>"."(".$allRows[$i]['paySchedule2']['ptAmount'].")"."</label>";
                 }
               }
             }
              ?><!-- 입금액 -->
          </td>
          <td class="mobile">
            <?php
            if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
              if($allRows[$i]['paySchedule2']['executiveDate']) {
                if(strtotime($allRows[$i]['paySchedule2']['executiveDate']) <= strtotime($allRows[$i]['paySchedule2']['pExpectedDate'])) {
                  echo "<label class='text-center green mb-0'>0</label><br>";
                } else {
                  echo "<label class='text-center numberComma green mb-0'>".$allRows[$i]['paySchedule2']['delaycount2']."</label><br>";
                }
              } else {
                if(strtotime($allRows[$i]['paySchedule2']['pExpectedDate']) >= strtotime($currentDate)) {
                  echo "<label class='text-center sky mb-0'>0</label><br>";
                } else {
                  echo "<label class='text-center numberComma  pink mb-0'>";echo $allRows[$i]['paySchedule2']['delaycount1']."</label><br>";
                }
              }
            }
            ?><!--연체일수-->
            <?php
            if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
              if($allRows[$i]['paySchedule2']['getdiv2']==='geted'){
                echo "<label class='text-center green mb-0'>0</label>";
              } else if($allRows[$i]['paySchedule2']['getdiv2']==='not_get'){
                echo "<label class='text-center sky mb-0'>0</label>";
              } else if($allRows[$i]['paySchedule2']['getdiv2']==='get_delay'){
                $ptAmount = (int)str_replace(',', '', $allRows[$i]['paySchedule2']['ptAmount']);
                // var_dump($ptAmount);
                $notGetDayCountAmount = $ptAmount * ($allRows[$i]['paySchedule2']['delaycount2'] / 365) * 0.27;
                echo "<label class='text-center numberComma green mb-0'>".$notGetDayCountAmount."</label>";
              } else if($allRows[$i]['paySchedule2']['getdiv2']==='not_get_delay'){
                $ptAmount = (int)str_replace(',', '', $allRows[$i]['paySchedule2']['ptAmount']);
                $notGetDayCountAmount = $ptAmount * ($allRows[$i]['paySchedule2']['delaycount1'] / 365) * 0.27;
                echo "<label class='text-center numberComma  pink mb-0'>".$notGetDayCountAmount."</label>";
              }
            }
            ?><!--연체이자-->
          </td><!-- 연체일수/이자 -->
          <td class="mobile">
            <?php
            if($allRows[$i]['payId'] && $allRows[$i]['payIdOrder']==='0'){
              if($allRows[$i]['paySchedule2']['taxDate']&&$allRows[$i]['paySchedule2']['mun']) {
                echo '<a onclick="taxInfo2('.$allRows[$i]['paySchedule2']['bid'].',\''.$allRows[$i]['paySchedule2']['mun'].'\',\''.$row['id'].'\');"><span class="badge badge-warning text-light" style="width: 1.5rem;">세</span><u>'.$allRows[$i]['paySchedule2']['taxDate'].'</u></a><input type="hidden" name="taxMun" value="'.$allRows[$i]['paySchedule2']['mun'].'">';
              } else if($allRows[$i]['paySchedule2']['taxDate']){
                echo '<span class="badge badge-warning text-light" style="width: 1.5rem;">세</span>'.$allRows[$i]['paySchedule2']['taxDate'];
              }
            }
            ?>
          </td><!-- 증빙 -->
        </tr>
        <?php
        }
         ?>
      </tbody>
    </table>
  </div>
</div>
