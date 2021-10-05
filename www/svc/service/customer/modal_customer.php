<!-- Modal -->
<div class="modal fade" id="eachpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <form method="post" action ="../customer/p_m_c_edit2.php">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">관계자보기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">

            <div class="form-row">
              <div class="form-group col-md-2">
                <p class="mb-1 grey"><span id='star' style='color:#F7BE81;'>* </span>구분</p>
              </div>
              <div class="form-group col-md-3">
                <select name="div2_m" class="form-control">
                  <option value="개인" name="kind1">개인</option>
                  <option value="개인사업자" name="kind2">개인사업자</option>
                  <option value="법인사업자" name="kind3">법인사업자</option>
                </select>
              </div>
            </div>
            <div>
              <div class="form-row">
                <div class="form-group col-md-5">
                  <p class="mb-1 grey"><span id='star' style='color:#F7BE81;'>* </span>성명</p>
                  <input type='text' name='name_m' class='form-control' required maxlength='9'>
                  <input type='hidden' name='id_m'>
                </div>
                <div class="form-group col-md-7">
                  <p class="mb-1 grey"><span id='star' style='color:#F7BE81;'>* </span>연락처</p>
                  <div class='form-row'>
                    <div class='form group col-md-4'>
                      <input type='text' name='contact1_m' class='form-control' maxlength='3' value="" required>
                    </div>
                    <div class='form group col-md-4'>
                      <input type='text' name='contact2_m' class='form-control' maxlength='4' required oninput='maxlengthCheck(this);' value="">
                    </div>
                    <div class='form group col-md-4'>
                      <input type='text' name='contact3_m' class='form-control' maxlength='4' required oninput='maxlengthCheck(this);' value="">
                    </div>
                  </div>
                </div>
              </div>
              <hr class="mt-0 mb-2">
              <div class="form-row">
                <div class="form-group col-md-3 mb-1">
                  <p class="mb-1 grey">사업자구분</p>
                  <select name="div3_m" class="form-control form-control-sm">
                    <option value="" name="a1"></option>
                    <option value="주식회사" name="a2">주식회사</option>
                    <option value="유한회사" name="a3">유한회사</option>
                    <option value="합자회사" name="a4">합자회사</option>
                    <option value="기타" name="a5">기타</option>
                  </select>
                </div>
                <div class="form-group col-md-4 mb-1">
                  <p class="mb-1 grey">사업자명</p>
                  <input type='text' name='companyname_m' class='form-control form-control-sm' maxlength='14'>
                </div>
                <div class="form-group col-md-5 mb-1">
                  <p class="mb-1 grey">사업자번호</p>
                  <div class='form-row'>
                    <div class='form group col-md-4'>
                      <input type='text' name='cNumber1_m' class='form-control form-control-sm' maxlength='3' oninput='maxlengthCheck(this);'>
                    </div>
                    <div class='form group col-md-3'>
                      <input type='text' name='cNumber2_m' class='form-control form-control-sm' maxlength='2' oninput='maxlengthCheck(this);'>
                    </div>
                    <div class='form group col-md-5'>
                      <input type='text' name='cNumber3_m' class='form-control form-control-sm' maxlength='5' oninput='maxlengthCheck(this);'>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-3">
                  <p class="mb-1 grey">업태</p>
                  <input type='text' name='div4_m' class='form-control form-control-sm' maxlength='9'>
                </div>
                <div class="form-group col-md-4">
                  <p class="mb-1 grey">종목</p>
                  <input type='text' name='div5_m' class='form-control form-control-sm' maxlength='15'>
                </div>
                <div class="form-group col-md-5">
                  <p class="mb-1 grey">이메일</p>
                  <input type='email' name='email_m' class='form-control form-control-sm' maxlength='40'>
                </div>
              </div>

              <hr class="mt-0 mb-2">

              <div class='form-group'>
                <div class='form-row'>
                  <div class="form-group col-md-12">
                    <p class="mb-1 grey">특이사항</p><textarea name="etc_m" rows="2" cols="80" class="form-control form-control-sm"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- 고객정보 -->
            <div class="mb-3">
              <section class="d-flex justify-content-center">
                 <small class="form-text text-muted text-center">고객번호[<span name='id_m'></span>] 등록일시[<span name='created_m'></span>] 수정일시[<span name='updated_m'></span>] </small>
              </section>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <a role="button" class="btn btn-warning btn-sm" href="/svc/service/customer/m_c_edit.php" target="_blank">더많은정보 수정</a> -->
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">닫기</button>
        <button type="submit" class="btn btn-primary btn-sm">수정</button>
      </div>
    </form>
    </div>
  </div>
</div>
