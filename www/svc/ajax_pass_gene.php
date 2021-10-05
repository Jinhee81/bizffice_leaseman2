<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$email1 = json_decode($_POST['email1']);
$cellphone1 = json_decode($_POST['cellphone1']);
$temp = json_decode($_POST['temp']);

// print_r($email1);echo "<br>";
// print_r($cellphone1);echo "<br>";
// print_r($temp);echo "<br>";

$sql = "select count(*) 
        from user 
        where email = '{$email1}'
        ";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

if($row[0] < 1){
    $resultvalue = '<p class=font-italic>입력한 이메일이 조회되지 않습니다. 다시 확인해주세요.</p>';
    echo json_encode($resultvalue);
} else {
    $sql2 = "select count(*) 
            from user 
            where email = '{$email1}' and
                  cellphone = '{$cellphone1}'
            ";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    if($row2[0] < 1){
        $resultvalue = '<p class=font-italic>입력한 연락처가 조회되지 않습니다. 다시 확인하거나 회원가입해주세요.</p>';
        echo json_encode($resultvalue);
    } else {
        $sql3 = "update user set
                 password = '{$temp}'
                 where email='{$email1}'
                ";
        $result3 = mysqli_query($conn, $sql3);
        
        if($result3) {
            $resultvalue = "<p class=font-italic>새로운 임시비밀번호를 생성했습니다. 새로운 임시비밀번호는 <span class=blue>".$temp."</span> 입니다.</p><a class='btn btn-primary btn-sm' id='loginbtn' href='login.php'>로그인</a>";

            echo json_encode($resultvalue);
        }

    }
}

// echo $resultvalue;


?>