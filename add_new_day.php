<?php

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $tables = $connection->query(
"SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables WHERE TABLE_NAME LIKE '%_daily_task_%_results'");

foreach($table as $tables)
{
  $connection->query("INSERT INTO `$table`() VALUES();");
}

  $connection->close();

?>