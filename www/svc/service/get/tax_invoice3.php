<?php
session_start();

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// print_r($_SESSION);echo "<br>";

include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
//$a = json_decode($_POST['taxArray']);
$sql4 = "SELECT id,
			user_name,
			companynumber,
			email,
			manager_name,
			cellphone,
			CURDATE() AS today
		FROM user
		WHERE id = ".$_SESSION['id']
		;

// echo $sql4;
// https://bizffice.cafe24.com/svc/service/get/tax_invoice2.php?building_idx=77&mun=-8502&id=4724&flag=finished

$result4 = mysqli_query($conn, $sql4);
$row4 = mysqli_fetch_array($result4);

print_r($row4);echo "<br>";

// echo "<br><br><br><br><br><br><br>";
// echo $sql4;
// echo  $_GET['mun'];
// exit();
//회사 번호
$cnum = $row4['companynumber'];

$sql5 = "SELECT *
FROM customer
WHERE id = ".$_GET['id'];

$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_array($result5);


header("Content-Type: text/html; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
// require_once $_SERVER['DOCUMENT_ROOT'].'/svc/pop/Popbill/PopbillTaxinvoice.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/svc/popbill_common2.php';

print_r($cnum);echo "<br>";
print_r($_GET['mun']);echo "<br>";


$result = $TaxinvoiceService->GetDetailInfo($cnum, 'SELL', $_GET['mun']);
// echo "<br><br><br><br><br><br>";
// print_r($result);
?>
<script type="text/javascript" src="/svc/inc/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/svc/inc/js/jquery-ui.min.js"></script>
<?php

if($result->invoicerMgtKey == null || $result->invoicerMgtKey == ''){
    if($_GET['flag']=='finished'){
		echo "<scrip>alert('요청한 고유번호에 해당하는 사용자정보가 존재하지 않습니다.');</scrip>";
		echo "<scrip>$('.pops_wrap,.pops_box,.popup_iframe',parent.document).hide();</scrip>";
        exit();
    }
    if($_GET['flag']=='expected'){
		echo "<scrip>alert('요청한 고유번호에 해당하는 사용자정보가 존재하지 않습니다.');</scrip>";
		echo "<scrip>$('.pops_wrap,.pops_box,.popup_iframe',parent.document).hide();</scrip>";
        exit();
    }
}

?>
<style type="text/css">
.j_w1 {
    width: 35px;
}
</style>

<body style='background-color:transparent'>
    <section class="pops_wrap">
        <div class="pops_box pops_21 one">
            <div class="pops_h">
                <h2>세금계산서</h2>
                <a href="#!" class="pops_close"><img src="/svc/inc/img/icon/pops_close.png" alt="닫기버튼"></a>
            </div>
            <div class="pops_con one" style="margin:0 auto">
                <!--
			<iframe style="width:0px;height:0px;" name="ifms"></iframe>
			-->
                <form name="billa" action="/svc/service/get/p_payScheduleTaxInput.php" method="post">
                    <!-- target="ifms" -->
                    <input type="hidden" name="callnum" id="callnum" value="" />

                    <!--
				<input type="hidden" name="max_cnt" id="max_cnt" value="<?=$max_cnt?>" />
				-->
                    <fieldset>


                        <div id="etax_area_form" class="border_red">

                            <table class="etax_table table_border_red text-center" summary="세금계산서"
                                style="border-bottom:none;">
                                <thead>
                                    <tr>
                                        <th class="al_c" colspan="46">
                                            <span class="ft_24 bold" id="taxName">세금계산서</span>
                                        </th>
                                        <th class="al_c" colspan="12"><span>공 급 자</span><br>(보 관 용)</th>
                                        <td colspan="42"></td>

                                    </tr>
                                </thead>
                                <tbody id="InvoiceList">
                                    <tr>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                    </tr>

                                    <!-- 등록번호 -->
                                    <tr>
                                        <!-- 공급자 -->
                                        <th class="al_c invoicer_bg noborder_l j_w1" colspan="3" rowspan="6"><span
                                                class="bold lh_30">공<br>급<br>자</span></th>

                                        <th class="al_c bold" colspan="8">등록번호</th>
                                        <td class="al_l pdl_3" colspan="39"><?= $cnum ?></td>

                                        <!-- 공급받는 자 -->
                                        <th class="al_c  invoicer_bg j_w1" colspan="3" rowspan="6"><span
                                                class="bold lh_16">공<br>급<br>받<br>는<br>자</span></th>

                                        <th class="al_c bold" colspan="8">등록번호</th>
                                        <td class="al_l pdl_3" colspan="39"><?= $result->invoiceeCorpNum ?></td>


                                    </tr>

                                    <!-- 상호 / 성명 -->
                                    <tr>
                                        <!-- 공급자 -->
                                        <th class="al_c bold" colspan="8"><span>상</span><span class="mgl_20">호</span>
                                        </th>
                                        <td class="al_l pdl_3" colspan="23"><?= $result->invoicerCorpName ?></td>

                                        <th class="al_c bold lh_14" colspan="4">성명</th>
                                        <td class="al_l pdl_3" colspan="12"><?= $row4['manager_name'] ?></td>


                                        <!-- 공급받는 자 -->
                                        <th class="al_c bold" colspan="8"><span>상</span><span class="mgl_20">호</span>
                                        </th>
                                        <td class="al_l pdl_3" colspan="23"><?= $result->invoiceeCorpName ?></td>

                                        <th class="al_c bold lh_14" colspan="4">성명</th>
                                        <td class="al_l pdl_3" colspan="12"><?= $row5['name'] ?></td>

                                    </tr>

                                    <!-- 사업장 주소 -->
                                    <tr>
                                        <!-- 공급자 -->
                                        <th class="al_c  lh_14" colspan="8">
                                            <p>주소</p>
                                        </th>

                                        <td class="al_l pdl_3" colspan="39"><?= $result->invoicerAddr ?></td>

                                        <!-- 공급받는 자 -->
                                        <th class="al_c lh_14" colspan="8">
                                            <p>주소</p>
                                        </th>

                                        <td class="al_l pdl_3" colspan="39"><?= $result->invoiceeAddr ?></td>

                                    </tr>

                                    <!-- 업태 / 종목 -->
                                    <tr>
                                        <!-- 공급자 -->
                                        <th class="al_c" colspan="8"><span>업</span><span class="mgl_20">태</span></th>
                                        <td class="al_l pdl_3" colspan="17"><?= $result->invoicerBizType ?></td>

                                        <th class="al_c lh_14" colspan="6">종목</th>
                                        <td class="al_l pdl_3" colspan="16"><?= $result->invoicerBizClass ?></td>

                                        <!-- 공급받는 자 -->
                                        <th class="al_c" colspan="8"><span>업</span><span class="mgl_20">태</span></th>
                                        <td class="al_l pdl_3" colspan="17"></td>

                                        <th class="al_c lh_14" colspan="6">종목</th>
                                        <td class="al_l pdl_3" colspan="16"></td>

                                    </tr>

                                    <!-- 담당자 / 연락처 -->
                                    <tr>
                                        <!-- 공급자 -->
                                        <th class="al_c" colspan="8"><span>담</span><span class="mgl_4">당</span><span
                                                class="mgl_4">자</span></th>
                                        <td class="al_l pdl_3" colspan="17"><?= $row4['manager_name'] ?></td>

                                        <th class="al_c" colspan="6">연락처</th>
                                        <td class="al_l pdl_3" colspan="16"><?= $row4['cellphone'] ?></td>

                                        <!-- 공급받는 자 -->
                                        <th class="al_c" colspan="8"><span>담</span><span class="mgl_4">당</span><span
                                                class="mgl_4">자</span></th>
                                        <td class="al_l pdl_3" colspan="17"><?= $row5['name'] ?></td>

                                        <th class="al_c" colspan="6">연락처</th>
                                        <td class="al_l pdl_3" colspan="16">
                                            <?= $row5['contact1'] ?><?= $row5['contact2'] ?><?= $row5['contact3'] ?>
                                        </td>
                                    </tr>

                                    <!-- 이메일 -->
                                    <tr>

                                        <!-- 공급자 -->
                                        <th class="al_c" colspan="8"><span>이</span><span class="mgl_4">메</span><span
                                                class="mgl_4">일</span></th>
                                        <td class="al_l pdl_3" colspan="39"><?= $row4['email'] ?></td>


                                        <!-- 공급받는 자 -->
                                        <th class="al_c" colspan="8"><span>이</span><span class="mgl_4">메</span><span
                                                class="mgl_4">일</span></th>

                                        <td class="al_l pdl_3" colspan="39"><?= $row5['email'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="etax_table table_border_red text-center" summary="세금계산서"
                                style="border-top:none;">

                                <tbody id="TotalList">
                                    <tr>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                    </tr>
                                    <tr>
                                        <th class="al_c noborder_l" colspan="11"><span class="bold">작성일자</span>&nbsp;
                                        </th>
                                        <th class="al_c pet0 gray_border_l" colspan="47"><span class="bold">공급가액</span>
                                        </th>
                                        <th class="al_c pet1 gray_border_l" colspan="42"><span
                                                class="bold">세&nbsp;&nbsp;&nbsp;&nbsp;액</span></th>
                                    </tr>
                                    <tr>
                                        <td class="al_c noborder_l gray_border_t" colspan="11">
                                            <input type="text"
                                                class="in_txt al_c dtpicker dp-applied calendar2 text-center"
                                                maxlength="10" style="width:85%;" tabindex="25" id="WriteDate"
                                                name="WriteDate"
                                                value="<?=date('Y-m-d', strtotime($result->writeDate)); //date("Y-m-d");?>">
                                        </td>

                                        <!-- <td class="al_l pet0 pdl_3 gray_border_t gray_border_l" colspan="47"><?= $result->supplyCostTotal ?></td> -->
                                        <td class="al_l pet0 pdl_3 gray_border_t gray_border_l" colspan="47">
                                            <?= number_format($result->supplyCostTotal) ?></td>

                                        <td class="al_l pet1 pdl_3 gray_border_t gray_border_l" colspan="42">
                                            <?= number_format($result->taxTotal) ?></td>
                                    </tr>
                                </tbody>
                                <tbody id="remarkList">
                                    <tr>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                    </tr>
                                    <tr>
                                        <th class="al_c noborder_l" colspan="11"><span class="bold">비고</span></th>
                                        <td class="al_l pdl_3 gray_border_l" colspan="47"><?= $result->remark1 ?></td>
                                        <td class="al_c item_l_border gray_border_l" colspan="42"></td>
                                    </tr>

                                </tbody>

                                <!-- <tbody id="taxList">

								<tr>
									<th class="al_c noborder_l" colspan="4"><span class="bold">월</span></th>
									<th class="al_c item_l_border" colspan="4"><span class="bold">일</span></th>
									<th class="al_c item_l_border" colspan="24"><span class="bold">품&nbsp;&nbsp;목</span></th>
									<th class="al_c item_l_border" colspan="14"><span class="bold">규&nbsp;&nbsp;격</span></th>
									<th class="al_c pet2 item_l_border" colspan="8"><span class="bold">수&nbsp;&nbsp;량</span></th>
									<th class="al_c pet3 item_l_border" colspan="8"><span class="bold">단&nbsp;&nbsp;가</span></th>
									<th class="al_c pet4 item_l_border" colspan="12"><span class="bold">공급가액</span></th>
									<th class="al_c pet5 item_l_border" colspan="10"><span class="bold">세&nbsp;&nbsp;액</span></th>
									<th class="al_c item_l_border" colspan="12"><span class="bold">비&nbsp;&nbsp;고</span></th>
									<th class="al_c item_l_border" colspan="4"></th>
								</tr>



								<tr id="item_0">
									<td class="al_l pdl_3 noborder_l item_t_border" colspan="4">

										<input class="in_txt al_c in_detail" maxlength="2" style="width:67%; height:25px;" tabindex="50" type="text" name="sss_month" id="detailList0.PurchaseDT1" value="<?=date('m', strtotime($result->writeDate)); //date('m')?>">
									</td>

									<td class="al_l pdl_3 item_border" colspan="4">
										<input class="in_txt al_c in_detail" maxlength="2" style="width:67%; height:25px;" tabindex="50" type="text" name="sss_day" id="detailList0.PurchaseDT2" value="<?=date('d', strtotime($result->writeDate)); //date('d')?>">
									</td>

									<td class="al_l pdl_3 item_border" colspan="24"></td>

									<td class="al_l pdl_3 item_border" colspan="14"></td>

									<td class="al_l pdl_3 item_border pet2" colspan="8"></td>

									<td class="al_l pdl_3 item_border pet3" colspan="8"><?= $result->supplyCostTotal ?></td>

									<td class="al_l pdl_3 item_border pet4" colspan="12"><?= $result->supplyCostTotal ?></td>

									<td class="al_l pdl_3 item_border pet5" colspan="10"><?= $result->taxTotal ?></td>

									<td class="al_l pdl_3 item_border" colspan="12"><?= $result->remark1 ?></td>

									<td class="al_c item_border" colspan="4"></td>
								</tr>



							</tbody> -->
                                <tbody id="taxTotalList">
                                    <tr>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                        <th class="splitline noborder_t" colspan="50"></th>
                                    </tr>
                                    <tr>
                                        <th class="al_c noborder_l" colspan="74"><span
                                                class="bold">합&nbsp;계&nbsp;금&nbsp;액</span></th>
                                        <th class="al_c" colspan="26" rowspan="2">
                                            <div class="PT fl_l" style="width:100%;">
                                                <span class="pt1 c_333">이 금액을</span>
                                                <!-- <span class="pt2 c_333">영수함</span> -->
                                                <span class="pt2 c_333"><?=$result->purposeType?>함</span>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <!-- <td class="al_l pdl_3 noborder_l" colspan="74"><?= $result->supplyCostTotal + $result->taxTotal ?></td> -->
                                        <td class="al_l pdl_3 noborder_l" colspan="74">
                                            <?= number_format($result->supplyCostTotal + $result->taxTotal) ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>



                        <!-- <div class="buttom_btnbox">
						<button type="button" class="blue mar_r one" onclick="fn_submit();" >발행</button>
						<button type="button" class="gray pops_close_sub" >닫기</button>
					</div> -->

                    </fieldset>
                </form>
            </div>
        </div>
        <div class="popbgClose"></div>
    </section>

    <script type="text/javascript">
    // function fn_submit(){

    // 	var frm = document.billa;

    // 	if(frm.callnum.value == ""){
    // 		alert("주문번호가 누락되었습니다.");
    // 		return false;
    // 	}

    // 	if(frm.WriteDate.value == ""){
    // 		alert("작성일자가 누락되었습니다.");
    // 		return false;
    // 	}

    // 	frm.submit();

    // }

    $(function() {
        $('.pops_close_sub').click(function() {
            $('.pops_wrap,.pops_box,.popup_iframe', parent.document).hide();
        });

        $('.pops_close').click(function() {
            $('.pops_wrap,.pops_box,.popup_iframe', parent.document).hide();
        });

        $('.pops_box').draggable();

    });
    </script>