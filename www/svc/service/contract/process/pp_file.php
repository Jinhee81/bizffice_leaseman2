<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

// print_r($_POST);
// print_r($_FILES);
// print_r($_SESSION);

$filtered_id = mysqli_real_escape_string($conn, $_POST['contractId']);

if(isset($_FILES['upfile']) && $_FILES['upfile']['name'] !== ""){
  $file = $_FILES['upfile'];
  $upload_directory = '../data/';
  // $ext_str = "hwp,xls,xlsx,doc,docx,pdf,jpg,jpeg,gif,png,txt,ppt,pptx,tiff";
  // $allowed_extensions = explode(',', $ext_str);

  $max_file_size = 5242880;
  $ext = substr($file['name'], strrpos($file['name'],'.') + 1);

  // if(!in_array($ext, $allowed_extensions)){
  //   echo "업로드 할수없는 확장자 ".$ext." 입니다.";
  // }

  if($file['size'] >= $max_file_size){
    echo json_encode('logical');//5MB 까지만 업로드 가능합니다
  }

  $path = md5(microtime()).'.'.$ext;
  if(move_uploaded_file($file['tmp_name'],$upload_directory.$path)){
    $file_id = md5(uniqid(rand(),true));
    $name_orig = $file['name'];
    $name_save = $path;
    $size = $file['size'];
    // $query = "
    //         INSERT INTO upload_file(file_id, name_orig, name_save, size, reg_time, realContract_id) VALUES
    //         (?, ?, ?, ?, now(), {$filtered_id})";
    $query = "
            INSERT INTO upload_file(file_id, name_orig, name_save, size, reg_time, realContract_id) VALUES
            ('{$file_id}', '{$name_orig}', '{$name_save}', {$size}, now(), {$filtered_id})";
    // echo $query;
    $result = mysqli_query($conn, $query);
    // $stmt = mysqli_prepare($conn, $query);
    // $bind = mysqli_stmt_bind_param($stmt, "sss", $file_id, $name_orig, $name_save, $size);
    // $exec = mysqli_stmt_execute($stmt);
    //
    // mysqli_stmt_close($stmt);
    if($result){
        include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/condi/sql_file.php";

        //echo $sql_sum;
        echo json_encode($fileRows);
    } else {
      echo json_encode('input1');//입력오류
    }
  } else {
    echo json_encode('input2');//입력오류
  }
}
 ?>