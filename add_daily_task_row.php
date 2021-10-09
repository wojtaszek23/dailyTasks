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
  $valid_since = $_GET['valid_since'];
  $valid_until = $_GET['valid_until'];
  $mon = 0;
  $tue = 0;
  $wed = 0;
  $thu = 0;
  $fri = 0;
  $sat = 0;
  $sun = 0;
  
  if($_GET['mon'] == true) $mon = 1;
  if($_GET['tue'] == true) $tue = 1;
  if($_GET['wed'] == true) $wed = 1;
  if($_GET['thu'] == true) $thu = 1;
  if($_GET['fri'] == true) $fri = 1;
  if($_GET['sat'] == true) $sat = 1;
  if($_GET['sun'] == true) $sun = 1;

  if($valid_until == '')
  {
    $connection->query("INSERT INTO `$challange_name` (`decission`, `shortcut`, `scale`, 
  `done0`, `done1`, `done2`, `done3`, `done4`, `done5`, `provide_date`, `remove_date`,
  `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`) VALUES
  ('$decission', '$shortcut', '$scale', '$done0', '$done1', '$done2', '$done3', '$done4', '$done5',
  '$valid_since', NULL, '$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun');");
  }
  
  else
  {
    $connection->query("INSERT INTO `$challange_name` (`decission`, `shortcut`, `scale`, 
  `done0`, `done1`, `done2`, `done3`, `done4`, `done5`, `provide_date`, `remove_date`,
  `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`) VALUES
  ('$decission', '$shortcut', '$scale', '$done0', '$done1', '$done2', '$done3', '$done4', '$done5',
  '$valid_since', '$valid_until', '$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun');");
  }

  

  $result = $connection->query("SELECT MAX(id) FROM `$challange_name`;");
  
  $id1;
  while ($row = $result->fetch_assoc()) {
    $id = $row['MAX(id)'];
  }

  $connection->query("ALTER TABLE `$challange_name_results` ADD COLUMN `target_id_$id` int(11) DEFAULT 0;");

  $connection->close();
  
  echo $id;

  exit();
}
?>