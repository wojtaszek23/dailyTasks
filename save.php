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

if(!empty($_POST))
{
  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  $nick = $_SESSION['nick_logged'];

  $daily_task_name = $_SESSION['creating_daily_task_name'];

  $challange_name = $nick."_daily_task_".$daily_task_name;

  $challange_name_results = $challange_name."_results";

  $nr = $_SESSION['nr_of_daily_task'];

  $kind = "daily_task_".$nr;

  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $connection->query("UPDATE `__users` SET `$kind`='$daily_task_name' WHERE `user`='$nick';");

  unset($_SESSION['creating_daily_task_name']);
  unset($_SESSION['nr_of_daily_task']);

  $connection->query("CREATE TABLE `$challange_name` (
    `id` int(11) NOT NULL,
    `decission` text NOT NULL,
    `shortcut` text NOT NULL,
    `scale` int(11) NOT NULL,
    `done0` text NOT NULL,
    `done1` text NOT NULL,
    `done2` text NOT NULL,
    `done3` text NOT NULL,
    `done4` text NOT NULL,
    `done5` text NOT NULL,
    `provide_date` date NOT NULL DEFAULT current_timestamp(),
    `remove_date` date DEFAULT NULL,
    `mon` tinyint(1) NOT NULL DEFAULT 1,
    `tue` tinyint(1) NOT NULL DEFAULT 1,
    `wed` tinyint(1) NOT NULL DEFAULT 1,
    `thu` tinyint(1) NOT NULL DEFAULT 1,
    `fri` tinyint(1) NOT NULL DEFAULT 1,
    `sat` tinyint(1) NOT NULL DEFAULT 1,
    `sun` tinyint(1) NOT NULL DEFAULT 1
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
  
  $connection->query("ALTER TABLE `$challange_name`
    ADD PRIMARY KEY (`id`);");
     
  $connection->query("ALTER TABLE `$challange_name`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");
  
  for($i=1;$i<=$_POST['num_rows'];$i=$i+1)
  {
    $decission = $_POST['decission'.$i];
    $shortcut = $_POST['shortcut'.$i];
    $scale = $_POST['scale'.$i];
    $done0 = $_POST['done0_'.$i];
    $done1 = $_POST['done1_'.$i];
    $done2 = $_POST['done2_'.$i];
    $done3 = $_POST['done3_'.$i];
    $done4 = $_POST['done4_'.$i];
    $done5 = $_POST['done5_'.$i];
    $mon = 0;
    $tue = 0;
    $wed = 0;
    $thu = 0;
    $fri = 0;
    $sat = 0;
    $sun = 0;
    
    if($_POST['mon'.$i] == 'on') $mon = 1;
    if($_POST['tue'.$i] == 'on') $tue = 1;
    if($_POST['wed'.$i] == 'on') $wed = 1;
    if($_POST['thu'.$i] == 'on') $thu = 1;
    if($_POST['fri'.$i] == 'on') $fri = 1;
    if($_POST['sat'.$i] == 'on') $sat = 1;
    if($_POST['sun'.$i] == 'on') $sun = 1;
    
    $ending = 0;

    if($_POST['ending'.$i] == 'on') $ending = 1;

    $valid_since = $_POST['valid_since'.$i];
    
    if($ending == 1)
    {
      $valid_until = $_POST['valid_until'.$i];
    }
    else
    {
      $valid_until = null;
    }

    if($valid_until != null)
    {
      $connection->query
        ("INSERT INTO `$challange_name` 
      (`decission`, `shortcut`, `scale`, `done0`, `done1`, `done2`, `done3`, `done4`, `done5`, `provide_date`, `remove_date`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`) 
        VALUES
      ('$decission', '$shortcut', '$scale', '$done0', '$done1', '$done2', '$done3', '$done4', '$done5', '$valid_since', '$valid_until', '$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun');");
    }
    else
    {
      $connection->query
        ("INSERT INTO `$challange_name` 
      (`decission`, `shortcut`, `scale`, `done0`, `done1`, `done2`, `done3`, `done4`, `done5`, `provide_date`, `remove_date`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`) 
        VALUES
      ('$decission', '$shortcut', '$scale', '$done0', '$done1', '$done2', '$done3', '$done4', '$done5', '$valid_since', NULL, '$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun');");
    }
  }

  $creating_results_string = "CREATE TABLE `$challange_name_results` (
    `id` int(11) NOT NULL,
    `date` date NOT NULL DEFAULT current_timestamp()";

  for($i=1;$i<=$_POST['num_rows'];$i=$i+1)
  {
    $target_id_string = ",
    `target_id_".$i."`";
    $creating_results_string = $creating_results_string.$target_id_string." int(11) DEFAULT 0";
    
  }

  $creating_results_string = $creating_results_string.") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

  $connection->query("$creating_results_string");
  
  $connection->query("ALTER TABLE `$challange_name_results`
    ADD PRIMARY KEY (`id`);");
     
  $connection->query("ALTER TABLE `$challange_name_results`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");

  $insert_first_day_results_string = "INSERT INTO `$challange_name_results` (";

  if($_POST['num_rows']>0)
  {
    $insert_first_day_results_string = $insert_first_day_results_string."`target_id_1`";
  }

  for($i=2;$i<=$_POST['num_rows'];$i=$i+1)
  {
    $target_id_string = ", `target_id_".$i."`";
    $insert_first_day_results_string = $insert_first_day_results_string.$target_id_string;
  }

  $insert_first_day_results_string = $insert_first_day_results_string.") VALUES (";

  if($_POST['num_rows']>0)
  {
    $insert_first_day_results_string = $insert_first_day_results_string."0";
  }

  for($i=2;$i<=$_POST['num_rows'];$i=$i+1)
  {
    $insert_first_day_results_string = $insert_first_day_results_string.", 0";
  }

  $insert_first_day_results_string = $insert_first_day_results_string.");";

  $connection->query("$insert_first_day_results_string");  

  $connection->close();

  header('Location: ./main_panel.php');
}

?>
