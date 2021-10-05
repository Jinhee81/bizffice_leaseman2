<?php
$sql_deposit = "
      select
            inDate, inMoney,
            outDate, outMoney, remainMoney,
            saved
      from realContract_deposit where realContract_id={$filtered_id}";
// echo $sql_deposit;
$result_deposit = mysqli_query($conn, $sql_deposit);
$row_deposit = mysqli_fetch_array($result_deposit);
 ?>
