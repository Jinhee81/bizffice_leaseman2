<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/svc/main/INIStdPayUtil.php');
$SignatureUtil = new INIStdPayUtil();

$timestamp = $_GET['timestamp'];
$orderNumber = $_GET['orderNumber'];
$g_price = $_GET["price"];

$params = "oid=" . $orderNumber . "&price=" . $g_price . "&timestamp=" . $timestamp;
$sign = hash("sha256", $params);

echo $sign;
?>