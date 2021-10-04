<?php

  require_once "/home/eswuprod/domains/eswu.konin.pl/public_html/connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $tables = $connection->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables WHERE TABLE_NAME LIKE '%_daily_task_%_results'");

foreach($tables as $table)
{
  $t = $table['TABLE_NAME'];
  $connection->query("INSERT INTO `$t`() VALUES();");
}

  $connection->close();
?>
