<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header('Content-Type: text/html; charset=UTF-8');
require_once $_SERVER['DOCUMENT_ROOT'].'/svc/popbill_common2.php';

$ReceiptNum = $_POST['pbnum'];

try {
    $result = $MessagingService->GetMessages($testCorpNum, $ReceiptNum);
} catch (PopbillException $pe) {
    $code = $pe->getCode();
    $message = $pe->getMessage();
}

?>

<body>
    <div id="content">
        <p class="heading1">Response</p>
        <br />
        <fieldset class="fieldset1">
            <legend>문자전송 내역 및 전송상태 확인 </legend>
            <ul>
                <?php
                if (isset($code)) {
                ?>
                <li>Response.code : <?php echo $code ?> </li>
                <li>Response.message : <?php echo $message ?></li>

                <?php
                } else {
                    for ($i = 0; $i < Count($result); $i++) {
                    ?>
                <fieldset class="fieldset2">
                    <legend> 문자전송내역 조회 결과 [<?php echo $i + 1 ?>/<?php echo Count($result) ?>]</legend>
                    <ul>
                        <li> state (전송상태 코드) : <?php echo $result[$i]->state ?> </li>
                        <li> result (전송결과 코드) : <?php echo $result[$i]->result ?> </li>
                        <li> subject (제목) : <?php echo $result[$i]->subject ?> </li>
                        <li> type (메시지 유형) : <?php echo $result[$i]->type ?> </li>
                        <li> content (메시지 내용) : <?php echo $result[$i]->content ?> </li>
                        <li> sendNum (발신번호) : <?php echo $result[$i]->sendNum ?> </li>
                        <li> senderName (발신자명) : <?php echo $result[$i]->senderName ?> </li>
                        <li> receiveNum (수신번호) : <?php echo $result[$i]->receiveNum ?> </li>
                        <li> receiveName (수신자명) : <?php echo $result[$i]->receiveName ?> </li>
                        <li> receiptDT (접수일시) : <?php echo $result[$i]->receiptDT ?> </li>
                        <li> sendDT (전송일시) : <?php echo $result[$i]->sendDT ?> </li>
                        <li> resultDT (전송결과 수신일시) : <?php echo $result[$i]->resultDT ?> </li>
                        <li> reserveDT (예약일시) : <?php echo $result[$i]->reserveDT ?> </li>
                        <li> tranNet (전송처리 이동통신사명) : <?php echo $result[$i]->tranNet ?> </li>
                        <li> receiptNum (접수번호) : <?php echo $result[$i]->receiptNum ?> </li>
                        <li> requestNum (요청번호) : <?php echo $result[$i]->requestNum ?> </li>
                    </ul>
                </fieldset>
                <?php
                    }
                }
                ?>
            </ul>
        </fieldset>
    </div>
</body>