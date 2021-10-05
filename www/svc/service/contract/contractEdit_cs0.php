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
        <?php
        for ($i=0; $i < count($allRows); $i++) { ?>
          <?php
          // print_r($allRows[$i]['paySchedule2']['pStartDate']);
          $pStartDate = $allRows[$i]['paySchedule2']['pStartDate'];//시작일
          $pEndDate = $allRows[$i]['paySchedule2']['pEndDate'];//종료일
          $monthCount = $allRows[$i]['paySchedule2']['monthCount'];//개월수
          $mAmount = (int)str_replace(',', '', $allRows[$i]['mMamount']);//공급가액
          // print_r($mAmount);
          $mvAmount = (int)str_replace(',', '', $allRows[$i]['mVmAmount']);//세액
          $mtAmount = (int)str_replace(',', '', $allRows[$i]['mTmAmount']);//합계
          $ptAmount = (int)str_replace(',', '', $allRows[$i]['paySchedule2']['ptAmount']);//합계
          // $getAmount = number_format($allRows[$i]['paySchedule2']['getAmount']);
          $getAmount =(int)str_replace(',', '', $allRows[$i]['paySchedule2']['getAmount']);

          $mAmount = number_format($mAmount);
          // print_r($mAmount);
          $mvAmount = number_format($mvAmount);
          $mtAmount = number_format($mtAmount);
          $ptAmount = number_format($ptAmount);
          $getAmount = number_format($getAmount);
          $pExpectedDate = $allRows[$i]['paySchedule2']['pExpectedDate'];//입금예정일
          $executiveDate = $allRows[$i]['paySchedule2']['executiveDate'];//입금일
          $payId = (int)$allRows[$i]['payId'];//청구번호
          $payIdOrder = $allRows[$i]['payIdOrder'];
          $lastOrder = $allRows[$i]['paySchedule2']['monthCount'] - 1;
          $lastOrder = (string)$lastOrder;
          $payKind = $allRows[$i]['paySchedule2']['payKind'];

          $aa1 = "<span name=mStartDate>"
                 .$allRows[$i]['mStartDate']
                 ."</span>~<span name=mEndDate>"
                 .$allRows[$i]['mEndDate']
                 ."</span>";//시작일,종료일 청구번호 있을때

          $aa2 = "<table name=date><tr><td name='mStartDate'>"
                 ."<input type='text' name='mStartDate' class='form-control form-control-sm dateType' value='".$allRows[$i]['mStartDate']
                 ."'style='width:100px;'>"."</td><td>~</td><td name='mEndDate'>"."<input type='text' name='mEndDate' class='form-control form-control-sm dateType' value='".$allRows[$i]['mEndDate']
                 ."'style='width:100px;'>"."</td></tr></table>";
                //시작일종료일 청구번호 없을때
          $bb1 = "<span name=mAmount>"
                 .$mAmount
                 ."</span>원, <span name=mvAmount>"
                 .$mvAmount
                 ."</span>원, <span name=mtAmount>"
                 .$mtAmount
                 ."</span>원";//공급가액,세액,합계 청구번호 있을때
          $bb2 = "<table name=detail><tr><td name='mAmount'>"
                 ."<input type='text' name='mAmount'  class='form-control form-control-sm amountNumber numberComma' value='".$mAmount
                 ."'style='width:100px;'>"."</td><td name='mvAmount'><input type='text' name='mvAmount'  class='form-control form-control-sm amountNumber numberComma' value='".$mvAmount
                 ."'style='width:100px;'></td><td name='mtAmount'>"."<input type='text' name='mtAmount' class='form-control form-control-sm amountNumber numberComma' value='".$mtAmount
                 ."'style='width:100px;'>"."</td>"
                 ."<td name='mExpectedDate'><input type='text' name='mExpectedDate' class='form-control form-control-sm dateType' value='".$allRows[$i]['mExpectedDate']
                 ."'style='width:100px;'></td>"
                 ."<td name='payKind'><select class='form-control form-control-sm' name='payKind' style='width:100px;'><option value='계좌'>계좌</option><option value='현금'>현금</option><option value='카드'>카드</option></select></td>"
                 ."</tr></table>";

          if($allRows[$i]['paySchedule2']['mun']){
            if($allRows[$i]['paySchedule2']['taxSelect']==='세금계산서'){
              $taxDate = "세금계산서 <span name='taxDate' class=taxDate><u>".$allRows[$i]['paySchedule2']['taxDate']."</u></span> <input type=hidden name='taxMun' value=".$allRows[$i]['paySchedule2']['mun']."><input type=hidden name='customerId' value=".$row[1]."><input type=hidden name='buildingId' value=".$allRows[$i]['paySchedule2']['bid'].">";
            }
          } elseif($allRows[$i]['paySchedule2']['taxDate']||$allRows[$i]['paySchedule2']['mun']) {

            if($allRows[$i]['paySchedule2']['taxSelect']==='세금계산서'){
              $taxDate = "세금계산서 <span name='taxDate'>".$allRows[$i]['paySchedule2']['taxDate']."</span>, ";
            }

            if($allRows[$i]['paySchedule2']['taxSelect']==='현금영수증'){
              $taxDate = "현금영수증 <span name='taxDate'>".$allRows[$i]['paySchedule2']['taxDate']."</span>, ";
            }
          } else {
            $taxDate = "";
          }

           ?>
           <?php
           if($payId && ($payIdOrder==='0')){
             if($allRows[$i]['paySchedule2']['getdiv2']==='geted'){
               $getdiv2 = "완납";
               $delayCount = 0;
               $delayInterest = 0;
             } else if($allRows[$i]['paySchedule2']['getdiv2']==='get_delay'){
               $getdiv2 = "완납(연체)";
               $delayCount = $allRows[$i]['paySchedule2']['delaycount2'];
               $delayInterest = $ptAmount * ($allRows[$i]['paySchedule2']['delaycount2'] / 365) * 0.27;
               $delayInterest = number_format($delayInterest);
             } else if($allRows[$i]['paySchedule2']['getdiv2']==='not_get'){
               $getdiv2 = "입금대기";
               $delayCount = 0;
               $delayInterest = 0;
             } else {
               $getdiv2 = "미납";
               $delayCount = $allRows[$i]['paySchedule2']['delaycount1'];
               $delayInterest = $ptAmount * ($allRows[$i]['paySchedule2']['delaycount1'] / 365) * 0.27;
               $delayInterest = number_format($delayInterest);
             }

             // var_dump($monthCount);

             if($monthCount==='1'){
               if($getdiv2==='완납'||$getdiv2==='완납(연체)'){
                 $value1 ="입금예정일 <span name='pExpectedDate'>"
                          .$pExpectedDate."</span>, 입금일 <span name='executiveDate'>".$executiveDate
                          ."</span>(<span name='payKind'>".$payKind."</span>), "
                          ."연체 <span name='delayCount'>".$delayCount."</span>일/이자 "
                          .$delayInterest."원, "
                          .$taxDate
                          ."<span name='payDiv'>".$getdiv2."</span>"
                          .", 청구번호 <span class='modalpay' data-toggle='modal' data-target='#pPay'><u>".$payId.
                          "</u></span><input type='hidden' name='ptAmount' value='".$ptAmount."'><input type='hidden' name='getAmount' value='".$getAmount."'>";
               } elseif($getdiv2==='미납') {
                 $value1 ="입금예정일 <span name='pExpectedDate'>"
                          .$pExpectedDate."</span>(<span name='payKind'>".$payKind."</span>) ".$ptAmount."원"
                          .$taxDate
                          .", 연체 ".$delayCount."일/이자 "
                          .$delayInterest."원, "
                          ."<span name='payDiv'>".$getdiv2."</span>"
                          .", 청구번호 <span class='modalpay' data-toggle='modal' data-target='#pPay'><u>".$payId.
                          "</u></span><input type='hidden' name='ptAmount' value='".$ptAmount."'><input type='hidden' name='getAmount' value='".$getAmount."'>";
               } elseif($getdiv2==='입금대기') {
                 $value1 ="<span name='pExpectedDate'>"
                          .$pExpectedDate."</span>(<span name='payKind'>".$payKind."</span>) ".$ptAmount."원, "
                          .$taxDate
                          ."<span name='payDiv'>".$getdiv2."</span>"
                          .", 청구번호 <span class='modalpay' data-toggle='modal' data-target='#pPay'><u>".$payId.
                          "</u></span><input type='hidden' name='ptAmount' value='".$ptAmount."'><input type='hidden' name='getAmount' value='".$getAmount."'>";
               }
             } else {//when more than 2 month
               if($getdiv2==='완납'||$getdiv2==='완납(연체)'){
                 $value1 = "<span>"
                          .$monthCount."</span>개월치(".$pStartDate."~".$pEndDate.") "
                          .$getAmount."원, 입금예정일 <span name='pExpectedDate'>".$pExpectedDate."</span>, 입금일 <span name='executiveDate'>".$executiveDate
                          ."</span>(<span name='payKind'>".$payKind."</span>), "
                          ."연체 ".$delayCount."일/이자 "
                          .$delayInterest."원, "
                          .$taxDate
                          ."<span name='payDiv'>".$getdiv2."</span>"
                          .", 청구번호 <span class='modalpay' data-toggle='modal' data-target='#pPay'><u>".$payId.
                          "</u></span><input type='hidden' name='ptAmount' value='".$ptAmount."'><input type='hidden' name='getAmount' value='".$getAmount."'>";
               } elseif($getdiv2==='미납') {
                 $value1 = "<span>"
                          .$monthCount."</span>개월치(".$pStartDate."~".$pEndDate
                          .") 입금예정일 <span name='pExpectedDate'>"
                          .$pExpectedDate
                          ."</span>(<span name='payKind'>"
                          .$payKind."</span>) "
                          .$ptAmount."원 "
                          ."연체 ".$delayCount."일/이자 "
                          .$delayInterest."원, "
                          ."<span name='payDiv'>".$getdiv2."</span>"
                          .$taxDate
                          .", 청구번호 <span class='modalpay' data-toggle='modal' data-target='#pPay'><u>".$payId.
                          "</u></span><input type='hidden' name='ptAmount' value='".$ptAmount."'><input type='hidden' name='getAmount' value='".$getAmount."'>";
               } elseif($getdiv2==='입금대기') {
                 $value1 = "<span>"
                          .$monthCount."</span>개월치(".$pStartDate."~".$pEndDate.")
                          <span name='pExpectedDate'>".$pExpectedDate."</span>"
                          ."(<span name='payKind'>".$payKind."</span>) "
                          .$ptAmount."원 "
                          .$taxDate
                          ."<span name='payDiv'>".$getdiv2."</span>"
                          .", 청구번호 <span class='modalpay' data-toggle='modal' data-target='#pPay'><u>".$payId.
                          "</u></span><input type='hidden' name='ptAmount' value='".$ptAmount."'><input type='hidden' name='getAmount' value='".$getAmount."'>";
               }
             }

             // echo $value1;

           } ?>
        <?php
        if($payId){
          echo "<tr name=contractRow>";
        } else {
          echo "<tr name=contractRow style='border-bottom:solid 1px grey;'>";
        }
         ?>
          <td name="checkbox">
            <input type='checkbox' class='tbodycheckbox' name='csId' value='<?=$allRows[$i]['idcontractSchedule']?>'>
            <input type="hidden" name="payId" value="<?=$payId?>">
          </td><!-- 체크박스 -->
          <td colspan="" class="text-left" name="order">
            <span class="" name=ordered><?=$allRows[$i]['ordered']?></span>
            <?php $rowIndex = count($allRows) - (int)$allRows[$i]['ordered']; ?>
            <input type="hidden" name="rowid" value="<?=$rowIndex?>">
          </td>
          <td class="text-left" name="date">
            <?php
            // if($payId){
            //   echo $aa1;
            // } else {
            //   echo $aa2;
            // }

            echo $aa1;
             ?>
          </td><!--시작일~종료일-->
          <td class="text-left" name="detail">
            <?php
            if($payId){
              echo $bb1;
            } else {
              echo $bb2;
            }
             ?>
          </td><!--공급가액,세액,합계,입금예정일,입금구분-->
        </tr>
        <?php
        if($payId && $payIdOrder==='0'){
          if($getdiv2==='완납'||$getdiv2==='완납(연체)'){
            echo "<tr class='paySchedule' style='border-bottom:solid 1px grey;' name='paySchedule'><td colspan='5' class='text-right green'>".$value1."</td></tr>";
          } elseif($getdiv2==='입금대기'){
            echo "<tr class='paySchedule' style='border-bottom:solid 1px grey; name='paySchedule''><td colspan='5' class='text-right sky'>".$value1."</td></tr>";
          } elseif($getdiv2==='미납'){
            echo "<tr class='paySchedule' style='border-bottom:solid 1px grey;' name='paySchedule'><td colspan='5' class='text-right pink'>".$value1."</td></tr>";
          }
        }
        ?>
      <?php }//for }
         ?>
      </tbody>
    </table>
  </div>
</div>
