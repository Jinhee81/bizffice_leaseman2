<?php
//21.10.27 update

session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/svc/view/conn.php";
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/svc/pop/Popbill/PopbillTaxinvoice.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/svc/popbill_common2.php';
header("Content-Type: text/html; charset=UTF-8");

$TaxinvoiceService = new TaxinvoiceService($LinkID, $SecretKey);

// 연동환경 설정값, 개발용(true), 상업용(false)
$TaxinvoiceService->IsTest(false);

// 인증토큰에 대한 IP제한기능 사용여부, 권장(true)
$TaxinvoiceService->IPRestrictOnOff(true);

// 팝빌 API 서비스 고정 IP 사용여부, 기본값(false)
$TaxinvoiceService->UseStaticIP(false);

// 로컬시스템 시간 사용 여부 true(기본값) - 사용, false(미사용)
$TaxinvoiceService->UseLocalTimeYN(true);


$a = json_decode($_POST['taxArray']);
// print_r($a);
// $tdate = date('Y-m-d', strtotime($_POST['taxDate']));
// print_r($tdate);


if ($_POST['taxDiv'] === 'charge') {
  $tdiv = '청구';
} else {
  $tdiv = '영수';
} //에러를 최소화하려고 일부러 else만 했음, 원래 accept인 경우로 했어야 함.

$sql2 = "SELECT COUNT(*) AS count
FROM paySchedule2
WHERE (taxselect != ''
	OR taxselect != NULL)
	AND taxDATE = '" . $tdate . "'";

// echo $sql2;

$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2); //이게 왜 있지?




// $sql3 = "SELECT id,
// email,
// user_name,
// companynumber,
// popbillid,
// cellphone,
// CURDATE() AS today
// FROM user
// WHERE id = " . $_SESSION['id'] . "";

// // echo "<br><br><br>";
// // echo $sql3;

// $result3 = mysqli_query($conn, $sql3);
// $row3 = mysqli_fetch_array($result3);

// // print_r($row3);
// //공급받는자 사업자 번호
// $sa = str_replace('-', '', $a[0][2]->사업자번호);

// //공급받는자 휴대폰 번호
// $tel = str_replace('-', '', $a[0][8]->연락처);

// //문서번호에 카운트를 넣었으나 청구번호로 바뀌어서 현재는 안씀
// $count = $row2['count'];

// //공급자 사업자번호
// $cnum = $row3['companynumber'];

// //선택한 날짜
// // $idate = str_replace('-','', $_POST['taxDate']);
// // $idate = str_replace('-','', $tdate);

// //오늘날짜
// $today = str_replace('-', '', $row3['today']);
// $tdate = date('Y-n-j', strtotime($row3['today']));

// //공급자 사업자명
// $bname = $row3['user_name'];

// //공급자 이메일
// $bemail = $row3['email'];

// //공급자 팝빌아이디
// $popbillid = $row3['popbillid'];

// //공급자 작성자명
// $username = $row3['manager_name'];

// //공급자 휴대폰번호
// $phone = $row3['cellphone'];

// //아이디 체크
// $checkId = $TaxinvoiceService->CheckID($popbillid);
// // print_r($checkId);

// if ($checkId->code == 0) {
//   echo "<script>alert('팝빌 아이디를 확인해 주세요.');</script>";
//   // echo "<script>history.back();</script>";
//   exit();
// }

// //공급자 정보
// $corpinfo = $TaxinvoiceService->GetCorpInfo($cnum, $popbillid);

// if ($corpinfo->corpName == null || $corpinfo->corpName == '') {
//   echo "<script>alert('사업자 번호와 팝빌 아이디를 확인해 주세요.');history.back();</script>";
//   exit();
// }

// // 공인인증서 유효성 확인
// $gong = $TaxinvoiceService->checkCertValidation($cnum);

// if (!$gong) {
//   // 팝빌 공인인증서가 등록이 되어있지 않을 경우
//   if (strpos($gong, '-99910004')) {
//     echo "<script>alert('팝빌 사이트에 공인인증서를 등록해야 전자세금계산서 발행이 가능합니다.');history.back();</script>";
//     exit();
//   }
// }


// for ($i = 0; $i < count($a); $i++) {

//   $GLOBALS['count'] += 1;
//   // 팝빌회원 사업자번호, '-' 제외 10자리
//   // $testCorpNum = $cnum;

//   // 팝빌회원 아이디
//   $testUserID = '';

//   // 세금계산서 문서관리번호
//   // - 최대 24자리 숫자, 영문, '-', '_' 조합으로 사업자별로 중복되지 않도록 구성
//   $invoicerMgtKey = $idate . '-' . $a[$i][1]->청구번호;

//   // 지연발행 강제여부
//   $forceIssue = false;

//   // 즉시발행 메모
//   $memo = '즉시발행 메모';

//   // 안내메일 제목, 미기재시 기본제목으로 전송
//   $emailSubject = '';

//   // 거래명세서 동시작성 여부
//   $writeSpecification = false;

//   // 거래명세서 동시작성시 명세서 관리번호
//   // - 최대 24자리 숫자, 영문, '-', '_' 조합으로 사업자별로 중복되지 않도록 구성
//   $dealInvoiceMgtKey = '';



//   /************************************************************
//    *                        세금계산서 정보
//    ************************************************************/

//   // 세금계산서 객체 생성
//   $Taxinvoice = new Taxinvoice();

//   // [필수] 작성일자, 형식(yyyyMMdd) 예)20150101
//   $Taxinvoice->writeDate = $today;

//   // [필수] 발행형태, '정발행', '역발행', '위수탁' 중 기재
//   $Taxinvoice->issueType = '정발행';

//   // [필수] 과금방향,
//   // - '정과금'(공급자 과금), '역과금'(공급받는자 과금) 중 기재, 역과금은 역발행시에만 가능.
//   $Taxinvoice->chargeDirection = '정과금';

//   // [필수] '영수', '청구' 중 기재
//   // $Taxinvoice->purposeType = '영수';
//   $Taxinvoice->purposeType = $tdiv;

//   // [필수] 과세형태, '과세', '영세', '면세' 중 기재
//   $Taxinvoice->taxType = '과세';

//   // [필수] 발행시점
//   $Taxinvoice->issueTiming = '직접발행';


//   /************************************************************
//    *                         공급자 정보
//    ************************************************************/

//   // [필수] 공급자 사업자번호
//   $Taxinvoice->invoicerCorpNum = $cnum;

//   // 공급자 종사업장 식별번호, 4자리 숫자 문자열
//   $Taxinvoice->invoicerTaxRegID = '';

//   // [필수] 공급자 상호
//   $Taxinvoice->invoicerCorpName = $corpinfo->corpName;

//   // [필수] 공급자 문서관리번호, 최대 24자리 숫자, 영문, '-', '_' 조합으로 사업자별로 중복되지 않도록 구성
//   $Taxinvoice->invoicerMgtKey = $invoicerMgtKey;

//   // [필수] 공급자 대표자성명
//   $Taxinvoice->invoicerCEOName = $corpinfo->ceoname;

//   // 공급자 주소
//   $Taxinvoice->invoicerAddr = $corpinfo->addr;

//   // 공급자 종목
//   $Taxinvoice->invoicerBizClass = $corpinfo->bizClass;

//   // 공급자 업태
//   $Taxinvoice->invoicerBizType = $corpinfo->bizType;

//   // 공급자 담당자 성명
//   $Taxinvoice->invoicerContactName = $corpinfo->ceoname;

//   // 공급자 담당자 메일주소
//   $Taxinvoice->invoicerEmail = $bemail;

//   // 공급자 담당자 연락처
//   $Taxinvoice->invoicerTEL = $phone;

//   // 공급자 휴대폰 번호
//   $Taxinvoice->invoicerHP = $phone;

//   // 발행시 알림문자 전송여부 (정발행에서만 사용가능)
//   // - 공급받는자 주)담당자 휴대폰번호(invoiceeHP1)로 전송
//   // - 전송시 포인트가 차감되며 전송실패하는 경우 포인트 환불처리
//   $Taxinvoice->invoicerSMSSendYN = false;

//   /************************************************************
//    *                      공급받는자 정보
//    ************************************************************/

//   // [필수] 공급받는자 구분, '사업자', '개인', '외국인' 중 기재
//   $Taxinvoice->invoiceeType = '사업자';

//   // [필수] 공급받는자 사업자번호
//   $Taxinvoice->invoiceeCorpNum = $sa;

//   // 공급받는자 종사업장 식별번호, 4자리 숫자 문자열
//   $Taxinvoice->invoiceeTaxRegID = '';

//   // [필수] 공급자 상호
//   $Taxinvoice->invoiceeCorpName = $a[0][3]->사업자명;

//   // [역발행시 필수] 공급받는자 문서관리번호, 최대 24자리 숫자, 영문, '-', '_' 조합으로 사업자별로 중복되지 않도록 구성
//   $Taxinvoice->invoiceeMgtKey = $idate . '-' . $a[$i][1]->청구번호;

//   // [필수] 공급받는자 대표자성명
//   $Taxinvoice->invoiceeCEOName = $a[0][4]->성명;

//   // 공급받는자 주소
//   $Taxinvoice->invoiceeAddr = $a[0][5]->주소;

//   // 공급받는자 업태
//   $Taxinvoice->invoiceeBizType = $a[0][6]->업태;

//   // 공급받는자 종목
//   $Taxinvoice->invoiceeBizClass = $a[0][7]->종목;

//   // 공급받는자 담당자 성명
//   $Taxinvoice->invoiceeContactName1 = $a[0][4]->성명;

//   // 공급받는자 담당자 메일주소
//   $Taxinvoice->invoiceeEmail1 = $a[0][9]->이메일;

//   // 공급받는자 담당자 연락처
//   $Taxinvoice->invoiceeTEL1 = $tel;

//   // 공급받는자 담당자 휴대폰 번호
//   $Taxinvoice->invoiceeHP1 = $tel;


//   /************************************************************
//    *                       세금계산서 기재정보
//    ************************************************************/

//   // [필수] 공급가액 합계
//   $Taxinvoice->supplyCostTotal = $a[0][10]->공급가액;

//   // [필수] 세액 합계
//   $Taxinvoice->taxTotal = $a[0][11]->세액;

//   // [필수] 합계금액, (공급가액 합계 + 세액 합계)
//   $Taxinvoice->totalAmount = $a[0][12]->합계;

//   // 기재상 '일련번호'항목
//   $Taxinvoice->serialNum = $idate . '-' . $a[$i][1]->청구번호;

//   // 기재상 '현금'항목
//   $Taxinvoice->cash = '';

//   // 기재상 '수표'항목
//   $Taxinvoice->chkBill = '';
//   // 기재상 '어음'항목
//   $Taxinvoice->note = '';

//   // 기재상 '외상'항목
//   $Taxinvoice->credit = '';

//   // 기재상 '비고' 항목
//   $Taxinvoice->remark1 = $a[0][13]->비고;
//   $Taxinvoice->remark2 = '';
//   $Taxinvoice->remark3 = '';

//   // 기재상 '권' 항목, 최대값 32767
//   // 미기재시 $Taxinvoice->kwon = 'null';
//   $Taxinvoice->kwon = '1';

//   // 기재상 '호' 항목, 최대값 32767
//   // 미기재시 $Taxinvoice->ho = 'null';
//   $Taxinvoice->ho = '1';

//   // 사업자등록증 이미지파일 첨부여부
//   $Taxinvoice->businessLicenseYN = false;

//   // 통장사본 이미지파일 첨부여부
//   $Taxinvoice->bankBookYN = false;



//   /************************************************************
//    *                     수정 세금계산서 기재정보
//    * - 수정세금계산서 관련 정보는 연동매뉴얼 또는 개발가이드 링크 참조
//    * - [참고] 수정세금계산서 작성방법 안내 - http://blog.linkhub.co.kr/650
//    ************************************************************/

//   // [수정세금계산서 작성시 필수] 수정사유코드, 수정사유에 따라 1~6중 선택기재
//   //$Taxinvoice->modifyCode = '';

//   // [수정세금계산서 작성시 필수] 수정사유코드, 수정사유에 따라 1~6 중 선택기재.
//   //$Taxinvoice->orgNTSConfirmNum = '';


//   /************************************************************
//    *                       상세항목(품목) 정보
//    ************************************************************/

//   $Taxinvoice->detailList = array();

//   $Taxinvoice->detailList[] = new TaxinvoiceDetail();
//   $Taxinvoice->detailList[0]->serialNum = 1;  // [상세항목 배열이 있는 경우 필수] 일련번호 1~99까지 순차기재,
//   // $Taxinvoice->detailList[0]->purchaseDT = '20200325';  // 거래일자
//   $Taxinvoice->detailList[0]->purchaseDT = $today;  // 거래일자
//   $Taxinvoice->detailList[0]->itemName = '이용료';  // 품명
//   $Taxinvoice->detailList[0]->spec = '';  // 규격
//   $Taxinvoice->detailList[0]->qty = ''; // 수량
//   $Taxinvoice->detailList[0]->unitCost = '';  // 단가
//   $Taxinvoice->detailList[0]->supplyCost = $a[0][10]->공급가액;  // 공급가액
//   $Taxinvoice->detailList[0]->tax = $a[0][11]->세액;  // 세액
//   $Taxinvoice->detailList[0]->remark = '';  // 비고

//   // $Taxinvoice->detailList[] = new TaxinvoiceDetail();
//   // $Taxinvoice->detailList[1]->serialNum = 2;	// [상세항목 배열이 있는 경우 필수] 일련번호 1~99까지 순차기재,
//   // $Taxinvoice->detailList[1]->purchaseDT = '20190828';  // 거래일자
//   // $Taxinvoice->detailList[1]->itemName = '품목명2번'; // 품명
//   // $Taxinvoice->detailList[1]->spec = '';  // 규격
//   // $Taxinvoice->detailList[1]->qty = ''; // 수량
//   // $Taxinvoice->detailList[1]->unitCost = '';  // 단가
//   // $Taxinvoice->detailList[1]->supplyCost = '100000';  // 공급가액
//   // $Taxinvoice->detailList[1]->tax = '10000';  // 세액
//   // $Taxinvoice->detailList[1]->remark = '';  // 비고



//   /************************************************************
//    *                      추가담당자 정보
//    * - 세금계산서 발행안내 메일을 수신받을 공급받는자 담당자가 다수인 경우
//    * 추가 담당자 정보를 등록하여 발행안내메일을 다수에게 전송할 수 있습니다. (최대 5명)
//    ************************************************************/

//   $Taxinvoice->addContactList = array();

//   $Taxinvoice->addContactList[] = new TaxinvoiceAddContact();
//   $Taxinvoice->addContactList[0]->serialNum = 1;  // 일련번호 1부터 순차기재
//   $Taxinvoice->addContactList[0]->email = 'test@test.com';  // 이메일주소
//   $Taxinvoice->addContactList[0]->contactName  = '팝빌담당자';  // 담당자명

//   // $Taxinvoice->addContactList[] = new TaxinvoiceAddContact();
//   // $Taxinvoice->addContactList[1]->serialNum = 2;  // 일련번호 1부터 순차기재
//   // $Taxinvoice->addContactList[1]->email = 'test@test.com';  // 이메일주소
//   // $Taxinvoice->addContactList[1]->contactName	= '링크허브'; // 담당자명
//   //Issue('1908600646', 'SELL', '20200324-01', '', null, false, null);
//   //RegistIssue($cnum, $Taxinvoice, $testUserID,
//   //$writeSpecification, $forceIssue, $memo, $emailSubject, $dealInvoiceMgtKey);
//   try {
//     $result = $TaxinvoiceService->RegistIssue(
//       $cnum,
//       $Taxinvoice,
//       $testUserID,
//       $writeSpecification,
//       $forceIssue,
//       $memo,
//       $emailSubject,
//       $dealInvoiceMgtKey
//     );
//     $code = $result->code;
//     $message = $result->message;
//     $ntsConfirmNum = $result->ntsConfirmNum;
//   } catch (PopbillException $pe) {
//     $code = $pe->getCode();
//     $message = $pe->getMessage();
//   }


//   // print_r($_POST);
//   // print_r($_SESSION);

//   // print_r($a);

//   if ($code == 1) {
//     $sql = "update paySchedule2
// 	          set
// 	              taxSelect = '{$_POST['taxSelect']}',
// 	              taxDate = '{$tdate}',
// 	              invoicerMgtKey = '{$invoicerMgtKey}'
// 	          WHERE
// 	              idpaySchedule2 = {$a[$i][1]->청구번호}";
//     // echo $sql;


//     $result = mysqli_query($conn, $sql);
//     if (!$result) {
//       echo "<script>alert('발행과정에 문제가 생겼습니다. 관리자에게 문의하세요.');
// 	                  history.back();
// 	            </script>";
//       error_log(mysqli_error($conn));
//       exit();
//     }

//     echo "<script>alert('발행완료하였습니다.');
// 	  history.back();
// 	  </script>";
//     exit();
//   } else {

//     echo "<script>alert('" . $message . "');
// 		history.back();
// 		  </script>";
//     error_log(mysqli_error($conn));
//     exit();
//   }
// }//for end}
