<?php

session_start();

if(!empty($_POST))
{
  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  $challange_name = $_SESSION['nick']."_challange";

  $challange_name_results = $challange_name."_results";

  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $tables = $connection->query(
"SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables WHERE TABLE_NAME LIKE '%_daily_task_%_results'");

foreach($table as $tables)
{
  $connection->query("INSERT INTO `$challange_name_results`() VALUES();");
}

  $connection->close();
}

?>