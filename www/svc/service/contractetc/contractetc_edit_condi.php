<?php
settype($filtered_id, 'integer');

$sql = "
    select
      etcContract.id as eid,
      customer.id as cid,
      customer.name,
      customer.companyname,
      customer.div2,
      customer.div3,
      customer.contact1,
      customer.contact2,
      customer.contact3,
      customer.etc,
      etcContract.building_id,
      (select bName from building where id=etcContract.building_id),
      good_in_building_id,
      (select name from good_in_building where
      id=good_in_building_id),
      etcContract.startTime,
      etcContract.endTime,
      paySchedule2.payKind,
      paySchedule2.executiveDate,
      paySchedule2.pAmount,
      paySchedule2.pvAmount,
      paySchedule2.ptAmount,
      etcContract.etc,
      etcContract.createTime,
      etcContract.createPerson,
      etcContract.updateTime,
      etcContract.updatePerson,
      etcContract.user_id
    from etcContract
    left join customer
        on etcContract.customer_id = customer.id
    left join paySchedule2
        on etcContract.paySchedule2_id = paySchedule2.idpaySchedule2
    where
      etcContract.id = {$filtered_id} and
      etcContract.user_id = {$_SESSION['id']}
    ";

// echo $sql;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
// print_r($row);

if ($result->num_rows === 0) {
    echo "<script>
          alert('세션에 포함된 계약이 아니어서 조회 불가합니다.');
          location.href = 'contractetc.php';
        </script>";
    error_log(mysqli_error($conn));
}

$cContact = $row['contact1'] . '-' . $row['contact2'] . '-' . $row['contact3'];

if ($row['div3'] === '주식회사') {
    $cDiv3 = '(주)';
} elseif ($row['div3'] === '유한회사') {
    $cDiv3 = '(유)';
} elseif ($row['div3'] === '합자회사') {
    $cDiv3 = '(합)';
} elseif ($row['div3'] === '기타') {
    $cDiv3 = '(기타)';
}

if ($row['div2'] === '개인사업자') {
    $cName = $row['name'] . '(' . $row['companyname'] . ')';
} else if ($row['div2'] === '법인사업자') {
    $cName = $cDiv3 . $row['companyname'] . '(' . $row['name'] . ')';
} else if ($row['div2'] === '개인') {
    $cName = $row['name'];
}
