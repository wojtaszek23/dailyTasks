<?php
  //open access to session variables
  session_start();
  
  //if nick or password is not set in session
  if(!isset($_POST['nick']) || !isset($_POST['password']))
  {
    header('Location: login.php');
    exit();
  }
  
  //store nick provided by user to session and local variables
  $nick = $_SESSION['nick'] = $_POST['nick'];
  
  //if provided nick consists of empty string
  if($nick == "")
  {
    //create inform text and imidiately back with it to login page
    $_SESSION['header_text'] = "Nie podano nicku. Proszę go uzupełnić i ponownie wybrać akcję logowania.";
    header('location: login.php');
    exit();
  }
  
  //store password provided by user to local variables
  $password1 = $_POST['password'];
  
  //if provided password consists of empty string
  if($password1 == "")
  {
    //create inform text and imidiately back with it to login page
    $_SESSION['header_text'] = "Nie podano hasła. Proszę je uzupełnić i ponownie wybrać akcję logowania.";
    header('location: login.php');
    exit();
  }
  
  //convert quotes if occur to html entities
  $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
  
  //attach connection strings to Database
  require_once "../connection_strings.php";
  
  //create mysqli object and set connection strings throught constructor parameters,
  //that constructor opens a new connection with Database also
  $connection = new mysqli($host, $db_user, $password, $db_name_users);
  
  //if some error occured while try of access connection with Database
  if($connection->connect_errno != 0)
  {
    throw new Exception(mysqli_connect_errno());
  }
  //connection was established successfuly
  else
  {
    //find record with given user nick name
    $result = $connection->query("SELECT * from users where nick='$nick'");
    
    //successfuly there is some user with given nick name in Database
    if($result->num_rows > 0)
    {
      //group result to associative table and store it as row variable
      $row = $result->fetch_assoc();
      //check if given password suits to hashed version of password stored in Database
      if(password_verify($password1, $row['password']))
      {
        //release the resource
        $result->close();
        $connection->close();
        //will be used in main.php to validate that user is logged
        $_SESSION['logged'] = true;
        //will be used in main.php to store info about user nick name
        $_SESSION['nick_logged'] = $row['nick'];
        //move to the main chat (as logged user)

        header('location: main_panel.php');
        exit();  

        //TODO: approach to daily_challange_viewer was changed- i am going to add
        //possibility of creating few decission tables for each person and after login
        //main panel should avoid and user should have self own defined decissions to
        //choose or edit. This part of code can be used as help while writting select
        //daily tasks names for viewed person.
        /*
        $connection2 = new mysqli($host, $db_user, $password, $db_name_dailyTasks);

        if($connection2->connect_errno != 0)
        {
          throw new Exception(mysqli_connect_errno());
        }

        
        $resultsName = $nick."_challange_results";
        $targetsName = $nick."_challange";

        $resultResults = $connection2->query("SHOW TABLES LIKE '$resultsName'");
        $resultTargets = $connection2->query("SHOW TABLES LIKE '$targetsName'");

        if ($resultResults->num_rows == 0 && $resultTargets->num_rows == 0)
        {
          header('location: daily_challenge_creator.php');
          exit();  
        }
        else if ($resultResults->num_rows == 1 && $resultTargets-> num_rows == 1)
        {
          header('location: daily_challenge_viewer.php');
          exit();  
        }
        else
        {
          $_SESSION['header_text'] = "Wystąpił nieoczekiwany błąd podczas próby odnalezienia tabeli z zadaniami lub wynikami dla nicku '$nick', proszę o zgłoszenie problemu twórcy strony.";
        }
        */
      }
      else
      {
        $_SESSION['header_text'] = "Podane hasło jest nieprawidłowe.";
      }
    }
    else
    {
      $_SESSION['header_text'] = "Nie znaleziono podanego nicku w bazie danych.";
    }
    $connection->close();
    header('location: login.php');
    exit();
  }
  
?>
