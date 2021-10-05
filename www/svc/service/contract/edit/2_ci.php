<!-- customer_information의 약자로 파일명을 정함 -->

<!-- 계약정보세션 -->
<section class="container">
    <div class="form-row mb-0">
        <div class="form-group col-md-5">
            <label class="mb-0">고객정보</label><br>
            <a href="/svc/service/customer/m_c_edit.php?id=<?=$row[1]?>" data-toggle="modal" data-target="#eachpop"
                class="eachpop">
                <input type="text" class="form-control form-control-sm" name="" style="color:#2E9AFE;" value="<?php if($row['etc']) {
              echo $cName.', '.$cContact.', ('.$row['etc'].')';
            } else {
              echo $cName.', '.$cContact;
            }?>" disabled>
                <input type="hidden" name="customerId" value="<?=$row[1]?>">
            </a>
        </div>
        <div class="form-group col-md-3">
            <label class="mb-0">물건정보</label><br>
            <input type="text" class="form-control form-control-sm"
                value="<?=$row['bname'].','.$row['gname'].','.$row['rname']?>" disabled>
            <input type="hidden" name="building" value="<?=$row['building_id']?>">
        </div>
        <div class="form-group col-md-4">
            <label class="mb-0">기간정보
                <?php
          if(!($difference===0)) {
            echo "<span class='font-weight-light sky'>[최초 ".$row['monthCount']."개월, " .$row['startDate']."~".$row['endDate']."]</span>";
          }
          ?>
            </label><br>
            <input type="text" class="form-control form-control-sm"
                value="<?=$row['count2'].'개월, '.$row['startDate'].'~'.$row['endDate2']?>" disabled>
        </div>
    </div>
    <div class="form-row mb-2">
        <div class="form-group col-md-5">
            <label class="mb-0">월이용료</label>
            <input type="text" class="form-control form-control-sm" name=""
                value="공급가액 <?=$row['mAmount']?>원, 세액 <?=$row['mvAmount']?>원, 합계 <?=$row['mtAmount']?>원" disabled>
        </div>
        <div class="form-group col-md-5">
            <label class="mb-0">기타정보</label>
            <input type="text" class="form-control form-control-sm" name=""
                value="최초 계약일 <?=$row['contractDate']?>, 수납구분 <?=$row['payOrder']?>" disabled>
        </div>
        <div class="form-group col-md-2">
            <label class="mb-0">상태:&nbsp;
                <?php
          if($status==="현재"){
            echo '<div class="badge badge-info text-wrap mr-1" style="width: 3rem;">현재</div>';
          } elseif($status==="대기"){
            echo '<div class="badge badge-warning text-wrap mr-1" style="width: 3rem;">대기</div>';
          } elseif($status==="종료"){
            echo '<div class="badge badge-danger text-wrap mr-1" style="width: 3rem;">종료</div>';
          } elseif($status==="중간종료"){
            echo '<div class="badge badge-danger text-wrap mr-1" style="width: 8rem;">중간종료, '.$row['endDate3'].'</div>';
          }
          ?></label><br>
            <label class="mb-0">단계:&nbsp;
                <?php
          if($step === "clear"){
            echo "<div class='badge badge-warning text-light' style='width: 3rem;'>clear</div>";
          } elseif($step === "청구"){
            echo "<div class='badge badge-warning text-primary' style='width: 3rem;'>청구</div>";
          } elseif($step === "입금"){
            echo "<div class='badge badge-warning text-info' style='width: 3rem;'>입금</div>";
          }
          ?></label>
        </div>
    </div>
</section>