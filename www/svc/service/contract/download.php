<?php
session_start();
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_REQUEST);

$file_id = $_REQUEST['file_id'];

$sql = "SELECT file_id, name_orig, name_save from upload_file where file_id='".$file_id."'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);

$name_orig = $row['name_orig'];
$name_save = $row['name_save'];
$fileDir = "data/";
$fullPath = $fileDir."/".$name_save;
$length = filesize($fullPath);

header("Content-type: application/octet-stream");
header("Content-length: $length");
header("Content-Disposition: attachment; filename=".iconv('utf-8', 'euc-kr', $name_orig));
header("Content-Transfer-Encoding: binary");
$fh = fopen($fullPath, "r");
fpassthru($fh);


exit;
 ?>
