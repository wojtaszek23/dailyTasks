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

  require_once "../connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $nick = $_SESSION['nick_logged'];
  $result = $connection->query("SELECT * FROM `__users` WHERE `user`='$nick'");
  
  if($result->num_rows == 0)
  {
      throw new Exception();
      exit();
  }

  while($row = mysqli_fetch_assoc($result))
  {
    $data[] = $row;
  }
  
  $jsoned_data = json_encode($data);

  $connection->close();

  echo $jsoned_data;
?>