<?php
session_start();
// include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";

$connect = new PDO('mysql:host=127.0.0.1;dbname=leaseman_svc','leaseman','leaseman!!22');

if(isset($_POST['title']))
{
  $query = "insert into events
              (title, start_event, end_event, user_id)
            values
              (:title, :start_event, :end_event, {$_SESSION['id']})";
  $statement = $connect -> prepare($query);
  $statement -> execute(
    array(
        ':title' => $_POST['title'],
        ':start_event' => $_POST['start'],
        ':end_event' => $_POST['end']
    )
  );
}
 ?>
