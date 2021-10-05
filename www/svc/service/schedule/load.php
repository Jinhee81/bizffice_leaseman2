<?php
session_start();
// include $_SERVER['DOCUMENT_ROOT']."/view/conn.php";

$connect = new PDO('mysql:host=127.0.0.1;dbname=leaseman_svc','leaseman','leaseman!!22');

$data = array();
$query = "select *
          from events
          where user_id={$_SESSION['id']}
          order by id asc";
$statement = $connect -> prepare($query);
$statement -> execute();

$result = $statement ->fetchAll();

foreach ($result as $row) {
  $data[] = array(
    'id' => $row['id'],
    'title' => $row['title'],
    'start' => $row['start_event'],
    'end' => $row['end_event']
  );
}
echo json_encode($data);

 ?>
