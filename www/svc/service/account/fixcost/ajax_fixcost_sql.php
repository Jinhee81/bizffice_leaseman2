<?php
session_start();
$sql = "
        select
          @num := @num + 1 as num,
          fixcost.id,
          building_id,
          bName,
          title,
          amount1, amount2, amount3,
          vat
        from
          (select @num:=0)a,
          fixcost
        join building
          on fixcost.building_id = building.id
        where fixcost.user_id={$_SESSION['id']}
              and building_id = {$_POST['building']}
       ";
// echo $sql;
?>
