<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

header("Content-Type: text/html; charset=UTF-8");

require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/INIStdPayUtil.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/stdpay3/libs/HttpClient.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/sha256.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/stdpay3/libs/json_lib.php');

$util = new INIStdPayUtil();
// $KEY = 'xAEuCjrjqHsEAYNB';
$KEY = 'rKnPljRn5m6J9Mzz';

try {
    $authUrl = 'https://iniapi.inicis.com/api/v1/billing';

    $authMap["type"] 		= 'Billing';
    $authMap["paymethod"] 	= 'Card'; 		
    $authMap["timestamp"] 	= date('YmdHis');
    $authMap["clientIp"] 	= $_SERVER["REMOTE_ADDR"];
    $authMap["mid"] 	= 'INIBillTst';
    $authMap["url"] 	= $_SERVER["HTTP_HOST"];
    $authMap["moid"] 	= 'leaseman_'.date('YmdHis').rand(1000, 9999);
    $authMap["goodName"] 	= 'car';
    $authMap["buyerName"] 	= '유진희';
    $authMap["buyerEmail"] 	= 'info@leaseman.co.kr';
    $authMap["buyerTel"] 	= '01049442076';
    $authMap["price"] 	= '1000';
    $authMap["billKey"] 	= '2336d2e8affc4b5e811d762681cff9bafc27cdee';
    $authMap["authentification"] 	= '00';

    // hash(KEY+type+paymethod+timestamp+clientIp+mid+moid+price+billKey)
    $hashArr = array('type', 'paymethod', 'timestamp','clientIp','mid','moid','price','billKey');
    $hashData = $KEY;
    foreach($hashArr as $h){
        $hashData .= "{$authMap[$h]}";
    }

    $authMap["hashData"] 	= hash("sha512", $hashData);

    echo '<pre>';
    print_r(array($authMap["hashData"], $hashData));
    
    echo '</pre>';
    

    try {

        $httpUtil = new HttpClient();

        //#####################
        // 4.API 통신 시작
        //#####################

        $authResultString = "";
        if ($httpUtil->processHTTP($authUrl, $authMap)) {
            $authResultString = $httpUtil->body;
            echo "<p><b>RESULT DATA :</b> $authResultString</p>";			//PRINT DATA
        } else {
            echo "Http Connect Error\n";
            echo $httpUtil->errormsg;

            throw new Exception("Http Connect Error");
        }
    }
     catch (Exception $e) {
        //    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        //####################################
        // 실패시 처리(***가맹점 개발수정***)
        //####################################
        //---- db 저장 실패시 등 예외처리----//
        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        echo $s;

        //#####################
        // 망취소 API
        //#####################

        $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
        if ($httpUtil->processHTTP($netCancel, $authMap)) {
            $netcancelResultString = $httpUtil->body;
        } else {
            echo "Http Connect Error\n";
            echo $httpUtil->errormsg;

            throw new Exception("Http Connect Error");
        }

        echo "<br/>## 망취소 API 결과 ##<br/>";
        
        /*##XML output##*/
        
        // 취소 결과 확인
        echo "<p>". $netcancelResultString . "</p>";
    }

} catch (Exception $e) {
    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
    echo $s;
}
?>