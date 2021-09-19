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

  if(!isset($_GET['name']))
  {
      throw new Exception();
  }

  $_SESSION['daily_task_name'] = $_GET['name'];
  header('Location: ../daily_challenge_viewer.php');
  exit();
?>