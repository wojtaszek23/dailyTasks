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

  $challange_name_results = $challange_name."_results";

  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  $decission = $_GET['decission'];
  $shortcut = $_GET['shortcut'];
  $scale = $_GET['scale'];
  $done0 = $_GET['done0'];
  $done1 = $_GET['done1'];
  $done2 = $_GET['done2'];
  $done3 = $_GET['done3'];
  $done4 = $_GET['done4'];
  $done5 = $_GET['done5'];
  $connection->query("INSERT INTO `$challange_name` (`decission`, `shortcut`, `scale`, `done0`, `done1`, `done2`, `done3`, `done4`, `done5`) VALUES
('$decission', '$shortcut', $scale, '$done0', '$done1', '$done2', '$done3', '$done4', '$done5');");

  $result = $connection->query("SELECT MAX(id) FROM `$challange_name`;");
  
  $id1;
  while ($row = $result->fetch_assoc()) {
    $id = $row['MAX(id)'];
  }

  $connection->query("ALTER TABLE `$challange_name_results` ADD COLUMN `daily_task_$id` int(11) DEFAULT 0;");

  $connection->close();
  
  echo $id;

  exit();
}
?>