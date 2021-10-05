<?php
$sql_count = "select count(*)
              from realContract_memo
              where realContract_id={$filtered_id}";
// echo $sql_count;
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);

// print_r($row_count);echo '11';

$memoLength = $row_count[0] + 1;

// print_r($memoLength);


$sql_memoS = "select
                @num := @num - 1 as num,
                idrealContract_memo,
                memoCreator,
                memoContent,
                created,
                updated
              from
                (select @num :={$memoLength})a,
                realContract_memo
              where realContract_id={$filtered_id}
              order by
                created desc";
// echo $sql_memoS;
$result_memoS = mysqli_query($conn, $sql_memoS);

$memoRows = array();
while($row_memoS=mysqli_fetch_array($result_memoS)) {
  $memoRows[] = $row_memoS;
}
 ?>
