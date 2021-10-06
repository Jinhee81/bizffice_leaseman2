<?php
// 계약등록화면에서 고객찾을때 쓰는 화면
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_SESSION);

if($_POST['query']){
  $sql = "
    select
      customer.id as cid,
      customer.name,
      customer.div2,
      customer.div3,
      customer.companyname as comname,
      customer.contact1 as c1,
      customer.contact2 as c2,
      customer.contact3 as c3,
      customer.cNumber1 as companyn1,
      customer.cNumber2 as companyn2,
      customer.cNumber3 as companyn3,
      building.id as bid,
      building.bName,
      building.pay
    from customer
    left join building
        on customer.building_id = building.id
    where
      customer.user_id={$_SESSION['id']} and
      div1 in('입주자', '기타', '거래처') and
      (customer.name like '%{$_POST['query']}%' or
      customer.companyname like '%{$_POST['query']}%')
      ";

    // echo $sql;

} else {
  $sql = "
    select
      customer.id as cid,
      customer.name,
      customer.div2,
      customer.div3,
      customer.companyname as comname,
      customer.contact1 as c1,
      customer.contact2 as c2,
      customer.contact3 as c3,
      customer.cNumber1 as companyn1,
      customer.cNumber2 as companyn2,
      customer.cNumber3 as companyn3,
      building.id as bid,
      building.bName,
      building.pay
    from customer
    left join building
        on customer.building_id = building.id
    where
      customer.user_id={$_SESSION['id']} and
      div1 in('입주자', '기타')
    order by customer.id desc
    limit 0,5
      ";
  // echo $sql;
}

$result = mysqli_query($conn, $sql);

$allRows = array();
if($result){
  while($row = mysqli_fetch_array($result)){
    $allRows[] = $row;
  }
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

  $allRows[$i]['companynumber'] = $allRows[$i]['companyn1'].'-'.$allRows[$i]['companyn2'].'-'.$allRows[$i]['companyn3'];


  $allRows[$i]['contact'] = $allRows[$i]['c1'].'-'.$allRows[$i]['c2'].'-'.$allRows[$i]['c3'];

  if($allRows[$i]['div2']==='개인사업자'){
    $allRows[$i]['ccnn'] = $allRows[$i]['bName'].", ".$allRows[$i]['name'].'('.$allRows[$i]['comname'].','.$allRows[$i]['companynumber'].'),'.$allRows[$i]['contact'];
  } else if($allRows[$i]['div2']==='법인사업자'){
    $allRows[$i]['ccnn'] = $allRows[$i]['bName'] . ", " . $allRows[$i]['cdiv3'].$allRows[$i]['comname'].'('.$allRows[$i]['name'].','.$allRows[$i]['comname'].'),'.$allRows[$i]['contact'];
  } else if($allRows[$i]['div2']==='개인'){
    $allRows[$i]['ccnn'] = $allRows[$i]['bName'] . ", " . $allRows[$i]['name'].','.$allRows[$i]['contact'];
  }


}


echo json_encode($allRows);
