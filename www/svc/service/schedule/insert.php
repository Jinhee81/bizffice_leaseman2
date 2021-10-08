<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$connect = new PDO('mysql:host=127.0.0.1;dbname='.$schema_name,$user,$password);

if(isset($_POST['title']))
{
  $query = "insert into events
              (title, start_event, end_event, user_id)
            values
              (:title, :start_event, :end_event, {$_SESSION['id']})";
    echo $query;
    
  $statement = $connect -> prepare($query);
  $statement -> execute(
    array(
        ':title' => $_POST['title'],
        ':start_event' => $_POST['start'],
        ':end_event' => $_POST['end']
    )
  );
}


// if(isset($_POST['title']))
// {
//     $sql = "insert into events
//             (title, start_event, end_event, user_id)
//             values
//             ('${$_POST['title']}',
//             '${$_POST['start']}',
//             '${$_POST['end']}',
//              {$_SESSION['id']})
//              ";
//     $result = mysqli_query($conn, $sql);

// }

 ?>