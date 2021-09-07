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

  if(!isset($_GET['nr']) || !isset($_GET['name']))
  {
      throw new Exception();
  }

  $nr = $_GET['nr'];
  $name = $_GET['name'];
  $kind;
  $nick = $_SESSION['nick_logged'];

  if($nr == 1)
    $kind = 'daily_task_1';
  else if($nr == 2)
    $kind = 'daily_task_2';
  else if($nr == 3)
    $kind = 'daily_task_3';

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $nick = $_SESSION['nick_logged'];
  $result = $connection->query("SELECT * FROM `__users` WHERE `user`='$nick'");
  
  if($result->num_rows == 0)
  {
      throw new Exception();
  }

  $result = $connection->query("SELECT * FROM `__users` WHERE `user`='$nick' AND `$kind`=''");
  $connection->close(); 
  if($result->num_rows != 1)
  {
      throw new Exception();
  }

  $_SESSION['creating_daily_task_name'] = $name;
  $_SESSION['nr_of_daily_task'] = $nr;
  
  //../ because this script was called by "get" method and got "/" character, then,
  //it was nessecarry to leave it and text after this.
  header('Location: ../daily_challenge_creator.php');
  exit();
?>
