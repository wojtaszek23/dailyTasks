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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

</head>
<body>

  <div id="logout_div">
    <a href="./logout.php">
      <input type="button" id="logout_button" value="Wylogowanie"></input>
    </a>
    <a href="./main_panel.php">
      <input type="button" id="logout_button" value="Powrót"></input>
    </a>
  </div>

  <div id="date_panel_div">
    <input type="date" id="date" onChange="date_changed()" value="<?php echo date('Y-m-d');?>" />
  </div>

  <div id="results_div">
    <table id="results_table">
    </table>
  </div>

  <div id="statistics_div">
    <span id="statistics_span"></span>
    <canvas id="myChart" style="width:100%; height: 100px;"></canvas>
  </div>

  <div id="targets_div">
    <table id="targets_table">
    </table>
  </div>

</body>
</html>
