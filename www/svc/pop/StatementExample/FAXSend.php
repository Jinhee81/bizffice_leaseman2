<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/Example.css" media="screen" />
        <title>팝빌 SDK PHP 5.X Example.</title>
    </head>
<?php
    /**
     * 전자명세서를 팩스로 전송하는 함수로, 팝빌에 데이터를 저장하는 과정이 없습니다.

     * - 팩스 전송 요청시 포인트가 차감됩니다. (전송실패시 환불처리)
     * - 팝빌 사이트 [문자·팩스] > [팩스] > [전송내역] 메뉴에서 전송결과를 확인 할 수 있습니다.
     * - 팩스 전송결과를 확인하기 위해서는 선팩스 전송 요청 시 반환받은 접수번호를 이용하여
     *   팩스 API의 전송결과 확인 (GetFaxDetail) API를 이용하면 됩니다.
     * - https://docs.popbill.com/statement/php/api#FAXSend
     */

    include 'common.php';

    // 팝빌 회원 사업자번호, '-' 제외 10자리
    $testCorpNum = '1234567890';

    // 문서번호
    $mgtKey = '20210801-001';

    // 명세서 코드 - 121(거래명세서), 122(청구서), 123(견적서) 124(발주서), 125(입금표), 126(영수증)
    $itemCode = '121';

    // 팩스전송 발신번호
    $sendNum = '07043042991';

    // 팩스수신번호
    $receiveNum = '070111222';

    // 전자명세서 객체 생성
    $Statement = new Statement();

    /************************************************************
     *                       전자명세서 정보
     ************************************************************/
    // [필수] 기재상 작성일자
    $Statement->writeDate = '20210801';

    // [필수] (영수, 청구) 중 기재
    $Statement->purposeType = '영수';

    // [필수]  과세형태, (과세, 영세, 면세) 중 기재
    $Statement->taxType = '과세';

    // 맞춤양식코드, 미기재시 기본양식으로 처리
    $Statement->formCode = '';

    // 명세서 종류 코드
    $Statement->itemCode = $itemCode;

    // 전자명세서 문서번호
    $Statement->mgtKey = $mgtKey;


    /************************************************************
     *                         공급자 정보
     ************************************************************/
    $Statement->senderCorpNum = $testCorpNum;
    $Statement->senderTaxRegID = '';
    $Statement->senderCorpName = '공급자 상호';
    $Statement->senderCEOName = '공급자 대표자 성명';
    $Statement->senderAddr = ' 공급자 주소';
    $Statement->senderBizClass = '공급자 업종';
    $Statement->senderBizType = '공급자 업태';
    $Statement->senderContactName = '공급자 담당자명';
    $Statement->senderTEL = '070-7070-0707';
    $Statement->senderHP = '010-000-2222';
    $Statement->senderEmail = 'test@test.com';


    /************************************************************
     *                         공급받는자 정보
     ************************************************************/
    $Statement->receiverCorpNum = '8888888888';
    $Statement->receiverTaxRegID = '';						// 공급받는자 종사업장 식별번호, 필요시 기재. 형식은 숫자 4자리
    $Statement->receiverCorpName = '공급받는자 대표자 성명';
    $Statement->receiverCEOName = '공급받는자 대표자 성명';
    $Statement->receiverAddr = '공급받는자 주소';
    $Statement->receiverBizClass = '공급받는자 업종';
    $Statement->receiverBizType = '공급받는자 업태';
    $Statement->receiverContactName = '공급받는자 담당자명';
    $Statement->receiverTEL = '010-0000-1111';
    $Statement->receiverHP = '010-1111-2222';
    $Statement->receiverEmail = 'test@test.com';


    /************************************************************
     *                       전자명세서 기재정보
     ************************************************************/
    $Statement->supplyCostTotal = '200000' ;				// [필수] 공급가액 합계
    $Statement->taxTotal = '20000';							// [필수] 세액 합계
    $Statement->totalAmount = '220000';						// [필수] 합계금액 (공급가액 합계+세액합계)
    $Statement->serialNum = '123';							// 기재상 일련번호 항목
    $Statement->remark1 = '비고1';
    $Statement->remark2 = '비고2';
    $Statement->remark3 = '비고3';
    $Statement->businessLicenseYN = False;					//사업자등록증 첨부 여부
    $Statement->bankBookYN = False;							//통장사본 첨부 여부
    $Statement->smssendYN = False;							//발행시 안내문자 전송여부


    /************************************************************
     *                       상세항목(품목) 정보
     ************************************************************/
    $Statement->detailList = array();

    $Statement->detailList[0] = new StatementDetail();
    $Statement->detailList[0]->serialNum = '1';					//품목 일련번호 1부터 순차 기재
    $Statement->detailList[0]->purchaseDT = '20210801';			//거래일자 yyyyMMdd
    $Statement->detailList[0]->itemName = '품명';
    $Statement->detailList[0]->spec = '규격';
    $Statement->detailList[0]->unit = '단위';
    $Statement->detailList[0]->qty = '1';						//수량
    $Statement->detailList[0]->unitCost = '100000';
    $Statement->detailList[0]->supplyCost = '100000';
    $Statement->detailList[0]->tax = '10000';
    $Statement->detailList[0]->remark = '비고';
    $Statement->detailList[0]->spare1 = 'spare1';
    $Statement->detailList[0]->spare2 = 'spare2';
    $Statement->detailList[0]->spare3 = 'spare3';
    $Statement->detailList[0]->spare4 = 'spare4';
    $Statement->detailList[0]->spare5 = 'spare5';

    $Statement->detailList[1] = new StatementDetail();
    $Statement->detailList[1]->serialNum = '2';					//품목 일련번호 순차기재
    $Statement->detailList[1]->purchaseDT = '20210801';			//거래일자 yyyyMMdd
    $Statement->detailList[1]->itemName = '품명';
    $Statement->detailList[1]->spec = '규격';
    $Statement->detailList[1]->unit = '단위';
    $Statement->detailList[1]->qty = '1';
    $Statement->detailList[1]->unitCost = '100000';
    $Statement->detailList[1]->supplyCost = '100000';
    $Statement->detailList[1]->tax = '10000';
    $Statement->detailList[1]->remark = '비고';
    $Statement->detailList[1]->spare1 = 'spare1';
    $Statement->detailList[1]->spare2 = 'spare2';
    $Statement->detailList[1]->spare3 = 'spare3';
    $Statement->detailList[1]->spare4 = 'spare4';
    $Statement->detailList[1]->spare5 = 'spare5';

    /************************************************************
     * 전자명세서 추가속성
     * - 추가속성에 관한 자세한 사항은 "[전자명세서 API 연동매뉴얼] >
     *   5.2. 기본양식 추가속성 테이블"을 참조하시기 바랍니다.
     ************************************************************/

    $Statement->propertyBag = array(
        'Balance' => '50000',
        'Deposit' => '100000',
        'CBalance' => '150000'
    );

    try {
        $receiptNum = $StatementService->FAXSend($testCorpNum, $Statement, $sendNum, $receiveNum);
    }
    catch(PopbillException $pe) {
        $code = $pe->getCode();
        $message = $pe->getMessage();
    }
?>
    <body>
        <div id="content">
            <p class="heading1">Response</p>
            <br/>
            <fieldset class="fieldset1">
                <legend>전자명세서 선팩스전송</legend>
                    <ul>
                    <?php
                        if ( isset($receiptNum) ) {
                    ?>
                            <li>receiptNum(팩스전송 접수번호) : <?php echo $receiptNum?></li>
                    <?php
                        } else {
                    ?>
                            <li>Response.code : <?php echo $code ?> </li>
                            <li>Response.message : <?php echo $message ?></li>
                    <?php
                        }
                    ?>
                    </ul>
            </fieldset>
         </div>
    </body>
</html>
