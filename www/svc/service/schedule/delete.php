<?php
session_start();
// include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";

if(isset($_POST['id']))
{
  $connect = new PDO('mysql:host=127.0.0.1;dbname=leaseman_svc','leaseman','leaseman!!22');
  $query = "
    DELETE from events where id=:id
  ";
  $statement = $connect -> prepare($query);
  $statement -> execute(
    array(
        ':id' => $_POST['id']
    )
  );
}
 ?>
