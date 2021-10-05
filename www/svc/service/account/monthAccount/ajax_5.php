<?php
include 'ajax_1234.php';

$diffArray = array(0,0,0);

// var_dump(str_replace(',', '', $leftTotalArray[1]));

$leftTotalArray[1] = str_replace(',', '', $leftTotalArray[1]);
$leftTotalArray[1] = (int)$leftTotalArray[1];
$leftTotalArray[2] = str_replace(',', '', $leftTotalArray[2]);
$leftTotalArray[2] = (int)$leftTotalArray[2];
$leftTotalArray[3] = str_replace(',', '', $leftTotalArray[3]);
$leftTotalArray[3] = (int)$leftTotalArray[3];
$rightTotalArray[1] = str_replace(',', '', $rightTotalArray[1]);
$rightTotalArray[1] = (int)$rightTotalArray[1];
$rightTotalArray[2] = str_replace(',', '', $rightTotalArray[2]);
$rightTotalArray[2] = (int)$rightTotalArray[2];
$rightTotalArray[3] = str_replace(',', '', $rightTotalArray[3]);
$rightTotalArray[3] = (int)$rightTotalArray[3];
$diffArray[0] = $leftTotalArray[1] - $rightTotalArray[1];
$diffArray[1] = $leftTotalArray[2] - $rightTotalArray[2];
$diffArray[2] = $leftTotalArray[3] - $rightTotalArray[3];

$diffArray[0] = number_format($diffArray[0]);
$diffArray[1] = number_format($diffArray[1]);
$diffArray[2] = number_format($diffArray[2]);

echo json_encode($diffArray);

?>
