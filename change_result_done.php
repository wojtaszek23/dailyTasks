<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "../connection_strings.php";
  
  //exit if type of http request is other than get, only get is expected.
  //exit if there is no nick set in session or user is no logged in session also.
  //exit if id of last message was not send from client side in a get http request.
  if($_SERVER['REQUEST_METHOD'] != "GET" || !isset($_SESSION['nick_logged']) || $_SESSION['logged']!=true)
  {
    throw new Exception();
  }
  else if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  {
    throw new Exception();
  }
  else if(!isset($_GET['value']) || !is_numeric($_GET['value']))
  {
    throw new Exception();
  }
  else if(!isset($_GET['res_id']) || !is_numeric($_GET['res_id']))
  {
    throw new Exception();
  }

  $id = $_GET['id'];
  $value = $_GET['value'];
  $res_id = $_GET['res_id'];

  $connection = new mysqli($host, $db_user, $password, $db_name_dailyTasks);

  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }

  $resultsName = $_SESSION['nick_logged']."_challange_results";
  $targetsName = $_SESSION['nick_logged']."_challange";

  $resultResults = $connection->query("SHOW TABLES LIKE '$resultsName'");
  $resultTargets = $connection->query("SHOW TABLES LIKE '$targetsName'");

  if ($resultResults->num_rows == 0 || $resultTargets->num_rows == 0)
  {
    $connection->close();
    $_SESSION['header_text'] = "Wystąpił nieoczekiwany błąd podczas próby odnalezienia tabeli z zadaniami lub wynikami dla nicku '$nick', proszę o zgłoszenie problemu twórcy strony.";
    exit();  
  }

  $target_id="target_id_".$id;

  $connection->query("UPDATE $resultsName SET $target_id=$value WHERE id=$res_id");
  $connection->close();

  echo 'target_id_'.$id.'='.$value;
?>