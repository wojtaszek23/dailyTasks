<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "connection_strings.php";
  
  //exit if type of http request is other than get, only get is expected.
  //exit if there is no nick set in session or user is no logged in session also.
  //exit if id of last message was not send from client side in a get http request.
  if($_SERVER['REQUEST_METHOD'] != "GET" || !isset($_SESSION['nick_logged']) || $_SESSION['logged']!=true)
  {
    throw new Exception();
  }
  else if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  {
    throw new Exception();
  }
  else if(!isset($_GET['value']) || !is_numeric($_GET['value']))
  {
    throw new Exception();
  }
  else if(!isset($_GET['res_id']) || !is_numeric($_GET['res_id']))
  {
    throw new Exception();
  }

  $id = $_GET['id'];
  $value = $_GET['value'];
  $res_id = $_GET['res_id'];

  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);

  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $target_id="target_id_".$id;

  $connection->query("UPDATE aaa1_challange_results SET $target_id=$value WHERE id=$res_id");
  $connection->close();

  echo 'target_id_'.$id.'='.$value;
?>