<?php
$file = file('data/무제.csv');

foreach ($file as $key) {
  $csv[] = explode(',', $key);
}

print_r($csv);
 ?>
