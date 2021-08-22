<?php

  session_start();
  
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Daily Challenge Viewer</title>
  <link rel="stylesheet" href="./css/daily_challenge_viewer.css" type="text/css" />
  <script type="text/javascript" src="./js/daily_challenge_viewer.js"></script>

</head>
<body>

  <div id="date_panel_div">
    <input type="date" id="date" onChange="date_changed()">
  </div>

  <div id="results_div">
    <table id="results_table">
    </table>
  </div>

  <div id="statistics_div">
  </div>

  <div id="targets_div">
    <table id="targets_table">
    </table>
  </div>

</body>
</html>
