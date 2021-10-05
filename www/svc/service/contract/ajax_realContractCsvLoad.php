<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$sql = "select
          idgroup,
          idroom,
          idcustomer
        from room
        where idbuilding = {$_POST['buildingIdx']}";

// echo $sql;
$result = mysqli_query($conn, $sql);
?>

<table class='table table-bordered text-center' id="table1">
  <tr>
    <td>그룹명</td>
    <td>방번호</td>
    <td>세입자</td>
    <td>계약일자</td>
    <td>공급가액</td>
    <td>세액</td>
    <td>기간</td>
    <td>시작일</td>
    <td>보증금</td>
    <td>보증금입금일</td>
  </tr>
    <?php
       while($row = mysqli_fetch_array($result)){?>
  <tr>
     <td>
       <?php
         $sql3 = "select id, gName from group_in_building where id={$row[0]}";
         $result3 = mysqli_query($conn, $sql3);
         $row3 = mysqli_fetch_array($result3);
         echo $row3['gName'].';<style="font-color:#D0A9F5;">'.$row3['id'].'</style>';
        ?>
     </td>
     <td>
       <?php
         $sql4 = "select id, rName from r_g_in_building where id={$row[1]}";
         $result4 = mysqli_query($conn, $sql4);
         $row4 = mysqli_fetch_array($result4);
         echo $row4['rName'].';'.$row4['id'];
        ?>
     </td>
     <td>
      <?php
      $sql2 = "select id, div2, name, div3, companyname, cNumber1, cNumber2, cNumber3 from customer where id=$row[2]";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_array($result2);

      if($row2['div3']==='주식회사'){
        $cDiv3 = '(주)';
      } elseif($row2['div3']==='유한회사'){
        $cDiv3 = '(유)';
      } elseif($row2['div3']==='합자회사'){
        $cDiv3 = '(합)';
      } elseif($row2['div3']==='기타'){
        $cDiv3 = '(기타)';
      }

      $cNumber = $row2['cNumber1'].'-'.$row2['cNumber2'].'-'.$row2['cNumber3'];

      if($row2['div2']==='개인사업자'){
        $cName = $row2['name'].'('.$row2['companyname'].','.$cNumber.');'.$row2['id'];
      } else if($row2['div2']==='법인사업자'){
        $cName = $cDiv3.$row2['companyname'].'('.$row2['name'].','.$cNumber.');'.$row2['id'];
      } else if($row2['div2']==='개인'){
        $cName = $row2['name'].';'.$row2['id'];
      }

      echo $cName;
      ?>
     </td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
  </tr>
    <?php   }
     ?>
</table>
