<?php
include "ajax_etcContract_sql.php";


$result = mysqli_query($conn, $sql);
// $total_rows = mysqli_num_rows($result);
$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[]=$row;
}

for ($i=0; $i < count($allRows); $i++) {
  if($allRows[$i]['div3']==='주식회사'){
    $allRows[$i]['cdiv3'] = '(주)';
  } elseif($allRows[$i]['div3']==='유한회사'){
    $allRows[$i]['cdiv3'] = '(유)';
  } elseif($allRows[$i]['div3']==='합자회사'){
    $allRows[$i]['cdiv3'] = '(합)';
  } elseif($allRows[$i]['div3']==='기타'){
    $allRows[$i]['cdiv3'] = '(기타)';
  }

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['ccname'] = $allRows[$i]['cname'].'('.$allRows[$i]['companyname'].')';
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['ccname'] = $allRows[$i]['cdiv3'].$allRows[$i]['companyname'].'('.$allRows[$i]['cname'].')';
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['ccname'] = $allRows[$i]['cname'];
  }

  $allRows[$i]['cnamemb'] = mb_substr($allRows[$i]['ccname'],0,10, 'utf-8');

  $allRows[$i]['contact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];

  $allRows[$i]['etcmb'] = mb_substr($allRows[$i]['eetc'],0,10,'utf-8');


} //for문closing

echo json_encode($allRows);


?>
