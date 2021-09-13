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

if(!empty($_GET))
{
  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  $nick = $_SESSION['nick_logged'];

  $daily_task_name = $_SESSION['creating_daily_task_name'];

  $challange_name = $nick."_daily_task_".$daily_task_name;

  $id = $_GET['id'];

  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  $connection->query("UPDATE `$challange_name` SET remove_date=current_timestamp() WHERE `id`='$id';");
  
  $connection->close();

  exit();
}

?>
