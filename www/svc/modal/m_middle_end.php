<!-- 중간종료일 -->
<div class="modal fade" id="modalEnd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">
                    중간종료
                    <?php 
                    if($row['rPayid']){
                        echo "청구번호 <span name=rPayid>".$row['rPayid']."</span>";
                    }
                ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-1">
                            <label>중간종료일</label>
                        </div>
                        <div class="form-group col-md-7 mb-1">
                            <input type="text" class="form-control form-control-sm text-center dateType pink"
                                id="enddate33" value="<?=$enddate3?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-1">
                            <label>환불 공급가액</label>
                        </div>
                        <div class="form-group col-md-7 mb-1">
                            <input type="text" class="form-control form-control-sm text-right amountNumber grey"
                                name="modalAmount11" numberOnly required value="<?=$rAmount?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-1">
                            <label>환불 세액</label>
                        </div>
                        <div class="form-group col-md-7 mb-1">
                            <input type="text" class="form-control form-control-sm text-right amountNumber grey"
                                name="modalAmount22" numberOnly required value="<?=$rvAmount?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-1">
                            <label>환불 합계</label>
                        </div>
                        <div class="form-group col-md-7 mb-1">
                            <input type="text" class="form-control form-control-sm text-right amountNumber grey"
                                name="modalAmount33" numberOnly required disabled value="<?=$rtAmount?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-1">
                            <label>환불수단</label>
                        </div>
                        <div class="form-group col-md-7 mb-1">
                            <select class="form-control form-control-sm" id="executiveDiv2">
                                <option value="계좌" <?php if($rKind==='계좌'){echo "selected";}?>>계좌</option>
                                <option value="현금" <?php if($rKind==='현금'){echo "selected";}?>>현금</option>
                                <option value="카드" <?php if($rKind==='카드'){echo "selected";}?>>카드</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 mb-1">
                            <label>환불일자</label>
                        </div>
                        <div class="form-group col-md-7 mb-1">
                            <input type="text" class="form-control form-control-sm text-center dateType pink"
                                id="enddate44" value="<?=$rDate?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                if(strlen($row['endDate3'])===0){
                    echo '<button type="button" class="btn btn-sm btn-primary" id="enddate3btn">입력하기</button>';
                } else {
                    echo '<button type="button" class="btn btn-sm btn-warning" id="enddateCansel">철회</button><button type="button" class="btn btn-sm btn-primary" id="enddate3btn">수정</button>';
                }
                ?>
            </div>
        </div>
    </div>
</div>