<?php

  session_start();
  
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
 
  $challange_name = $_SESSION['nick']."_challange";
  $challange_name_results = $challange_name."_results";
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $result = $connection->query("SHOW TABLES LIKE '$challange_name'");
  
  //successfuly there is some table with given table name name in Database
  if($result->num_rows == 0)
  {
    header('location: daily_challenge_creator.php');
    exit();
  }
  
  //TODO: 'provide_data' <=  STR_TO_DATE('10.6.2021', '%d.%m.%Y') // w przypadku customowej daty i wyjąć ją z id elementu na stronie
  // WHERE 'remove_data' = 0 AND 'provide_data' <= CURRENT_TIMESTAMP 
  $targets_query = $connection->query("SELECT * FROM $challange_name");
  //AND 'remove_data' = NULL
  $results_query = $connection->query("SELECT * FROM $challange_name_results");

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

  //echo $_SESSION['nick'];

  $data = json_encode($data);

  //echo $data;

  //$jsoned_data = json_encode($data);
  //$jsoned_results = json_encode($results);

  $connection->close();

  echo $data;
?>