<?php
$sql_file = "
    select
      @num := @num + 1 as num,
      file_id,
      name_orig,
      size,
      reg_time
    FROM
      (select @num := 0)a,
      upload_file
    WHERE
      realContract_id = {$filtered_id}
    ORDER BY
      reg_time asc";
// echo $sql_file;
$result_file = mysqli_query($conn, $sql_file);

$fileRows = array();
while($row_file = mysqli_fetch_array($result_file)){
  $fileRows[]=$row_file;
}

for ($i=0; $i < count($fileRows); $i++) {
  if($fileRows[$i]['size'] >= 1073741824){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size'] / 1073741824, 2) . ' GB';
  } elseif($fileRows[$i]['size'] >= 1048576){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size'] / 1048576, 2) . ' MB';
  } elseif($fileRows[$i]['size'] >= 1024){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size'] / 1024, 2) . ' KB';
  } elseif($fileRows[$i]['size'] >= 1){
    $fileRows[$i]['bytes'] = number_format($fileRows[$i]['size']).' bytes';
  }
}
 ?>
