<?php
$sql_refund = "
      select
            endDate3,
            rAmount, rvAmount, rtAmount,
            rKind, rDate, rPayid
      from realContract where id={$filtered_id}";
// echo $sql_refund;

$result_refund = mysqli_query($conn, $sql_refund);
$row_refund = mysqli_fetch_array($result_refund);

// print_r($row_refund);
 ?>