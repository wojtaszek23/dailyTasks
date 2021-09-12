<?php

  session_start();
  
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }

  if(!isset($_SESSION['creating_daily_task_name']) || !isset($_SESSION['nr_of_daily_task']))
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  $name = $_SESSION['nick_logged']."_daily_task_".$_SESSION['creating_daily_task_name'];
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
   
  $targets_query = $connection->query("SELECT * FROM `aaa1_daily_task_cósp` WHERE `remove_date` IS NULL");

  $data = [];

  while($row_target = mysqli_fetch_assoc($targets_query))
  {
    $data[] = $row_target;
  }

  $data = json_encode($data);

  $connection->close();

  echo $data;
?>