<?php

  session_start();
  
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }

  if(!isset($_SESSION['daily_task_name']))
  {

    //return to chat initial screen
    echo "no daily_task_name";
    //stop reading this file to load url above imidiately
    exit();
  }

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  $name = $_SESSION['nick']."_daily_task_".$_SESSION['daily_task_name'];
  $name_results = $name."_results";
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $result = $connection->query("SHOW TABLES LIKE '$name'");
  
  //successfuly there is some table with given table name name in Database
  if($result->num_rows == 0)
  {
    header('location: daily_challenge_creator.php');
    exit();
  }
  
  
  $targets_query = $connection->query("SELECT * FROM $name");
  $results_query = $connection->query("SELECT * FROM $name_results");

  $data['targets'] = [];
  $data['results'] = [];

  while($row_target = mysqli_fetch_assoc($targets_query))
  {
    $data['targets'][] = $row_target;
  }
  while($row_result = mysqli_fetch_assoc($results_query))
  {
    $data['results'][] = $row_result;
  }

  $data = json_encode($data);

  $connection->close();

  echo $data;
?>