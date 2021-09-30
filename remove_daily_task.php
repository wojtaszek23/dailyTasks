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

  if(!isset($_GET['contentType']) || !isset($_GET['name']))
  {
      throw new Exception();
  }

  $nr = $_GET['contentType'];
  $name = $_GET['name'];
  $kind;
  $nick = $_SESSION['nick_logged'];

  if($nr == 1)
    $kind = 'daily_task_1';
  else if($nr == 2)
    $kind = 'daily_task_2';
  else if($nr == 3)
    $kind = 'daily_task_3';
  else if($nr == 4)
    $kind = 'calendar_1';
  else if($nr == 5)
    $kind = 'calendar_2';
  else if($nr == 6)
    $kind = 'calendar_3';
  else if($nr == 7)
    $kind = 'diary_1';
  else if($nr == 8)
    $kind = 'diary_2';
  else if($nr == 9)
    $kind = 'diary_3';


  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $nick = $_SESSION['nick_logged'];
  $result = $connection->query("SELECT * FROM `__users` WHERE `user`='$nick' AND `$kind`='$name'");
  
  if($result->num_rows == 0)
  {
      throw new Exception();
      exit();
  }

  $table_name = $nick."_daily_task_".$name;

  $table_name_results = $table_name."_results";
  
  $connection->query("DROP TABLE `$table_name`");

  $connection->query("DROP TABLE `$table_name_results`");

  $connection->query("UPDATE `__users` SET `$kind`=NULL WHERE `user`='$nick'");

  $connection->close();

  echo "ok";
?>