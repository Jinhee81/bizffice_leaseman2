<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    hello world!
</body>

</html>

<?php
$today = '2021-4-7';

$date = date('j', strtotime($today));

print_r($date);

// phpinfo();

$date = date_create();

date_date_set($date, 2021, 4, 21);

echo date_format($date, 'Y-n-j');
?>