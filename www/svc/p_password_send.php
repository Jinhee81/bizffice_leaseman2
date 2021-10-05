<?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "password.php";

// $password = $_POST['password'];
// $hash = password_hash($password, PASSWORD_DEFAULT);

// print_r($_POST);

$email = $_POST['email'];
$cellphone = $_POST['cellphone'];
$newpassword = md5($_POST['newpassword']);

$sql1 = "select count(*) from user where email = '{$email}'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

if($row1[0] === 0) {
    echo "<script>
  alert('이메일이 조회되지 않습니다. 다시 확인해주세요.');
  history.back();
  </script>";
} else {
    $sql2 = "select id, cellphone from user where cellphone = '{$cellphone}' and email = '{$email}'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    if($row2['cellphone'] != $cellphone) {
        echo "<script>
        alert('연락처가 일치하지 않습니다. 다시 확인해주세요.');
        history.back();
        </script>";
    } else {
        
        $sql3 = "update user set password = '{$newpassword}' where id={$row2['id']}";

        // echo $sql3;echo "444";

        $result3 = mysqli_query($conn, $sql3);

        if($result3){
            echo "<script>
            alert('비밀번호를 변경하였습니다.');
            location.href='login.php';
            </script>";
            // echo 'success';
        } else {
            echo "<script>
            alert('오류가 발생했습니다. 관리자에게 문의하세요.');
            location.href='password_find.php';
            </script>";
            // echo 'fail';
        }
    }
}





?>