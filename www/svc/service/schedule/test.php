<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";

$connect = new PDO('mysql:host=localhost;dbname=bizffice;charset=utf8','bizffice','wlsgml88^^');

echo $connect;echo "<br>";

if($connect){
    echo 'true';
} else {
    echo 'false';
}
?>