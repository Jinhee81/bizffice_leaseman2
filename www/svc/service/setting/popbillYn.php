<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/svc/popbill_common.php';
$cnum = $_POST['cnum'];
$popbillYn = $TaxinvoiceService->CheckIsMember($cnum,'LEASEMANSOFT');
print_r($popbillYn -> message);
?>
