<?php

  session_start();
  
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] != "GET")
  {
    throw new Exception();
  }

  if(!isset($_GET['name']))
  {
    throw new Exception();
  }

  $name = $_GET['name'];

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $nick = $_SESSION['nick_logged'];
  $result = $connection->query("SELECT * FROM `__users` WHERE `user`='$nick' AND
  (`daily_task_1`='$name' OR `daily_task_2`='$name' OR `daily_task_3`='$name')
  ");
  
  $connection->close();

  if($result->num_rows > 0)
  {
      echo "yes";
      exit();
  }
  else
  {
      echo "no";
      exit();
  }
?>