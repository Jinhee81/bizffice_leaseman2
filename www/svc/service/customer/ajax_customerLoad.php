<?php
include "ajax_customerLoad_sql.php";

$result = mysqli_query($conn, $sql);

$allRows = array();
while($row = mysqli_fetch_array($result)){
  $allRows[] = $row;
}


for ($i=0; $i < count($allRows); $i++) {
  $allRows[$i]['count']= $row_count[0];

   $sql2 = "select count(*) from realContract where customer_id={$allRows[$i]['id']}";
   $result2 = mysqli_query($conn, $sql2);
   $row2 = mysqli_fetch_array($result2);


   $allRows[$i]['contractCount'] = (int)$row2[0];

  $allRows[$i]['cNumber'] = $allRows[$i]['cNumber1'].'-'.$allRows[$i]['cNumber2'].'-'.$allRows[$i]['cNumber3'];

  $allRows[$i]['cContact'] = $allRows[$i]['contact1'].'-'.$allRows[$i]['contact2'].'-'.$allRows[$i]['contact3'];

  if($allRows[$i]['div3']==='주식회사'){
    $allRows[$i]['cdiv3'] = '(주)';
  } elseif($allRows[$i]['div3']==='유한회사'){
    $allRows[$i]['cdiv3'] = '(유)';
  } elseif($allRows[$i]['div3']==='합자회사'){
    $allRows[$i]['cdiv3'] = '(합)';
  } elseif($allRows[$i]['div3']==='기타'){
    $allRows[$i]['cdiv3'] = '(기)';
  }


  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['cName'] = $allRows[$i]['name'].'('.$allRows[$i]['companyname'].','.$allRows[$i]['cNumber'].')';
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['cName'] = $allRows[$i]['cdiv3'].$allRows[$i]['companyname'].'('.$allRows[$i]['name'].','.$allRows[$i]['cNumber'].')';
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['cName'] = $allRows[$i]['name'];
  } else {
    $allRows[$i]['cName'] = $allRows[$i]['name'];
  }

  $allRows[$i]['companyname'] = $allRows[$i]['cdiv3'].$allRows[$i]['companyname'];


  if($allRows[$i]['div1']==='입주자'){
    $allRows[$i]['gothere'] = '임대계약';
  } else if($allRows[$i]['div1']==='기타'){
    $allRows[$i]['gothere'] = '기타계약';
  } else {
    $allRows[$i]['gothere'] = '';
  }

  $allRows[$i]['cNamemb'] = mb_substr($allRows[$i]['cName'],0,10,'utf-8');

  $allRows[$i]['emailmb'] = mb_substr($allRows[$i]['email'],0,8,'utf-8');

  $allRows[$i]['etc'] = mb_substr($allRows[$i]['etc'],0,10,'utf-8');

  $allRows[$i]['created'] = date('Y-n-j', strtotime($allRows[$i]['created']));

  if($allRows[$i]['updated']===null){
    $allRows[$i]['updated'] = '-';
  } else {
    $allRows[$i]['updated'] = date('Y-n-j', strtotime($allRows[$i]['updated']));
  }
  
}


echo json_encode($allRows);

?>
