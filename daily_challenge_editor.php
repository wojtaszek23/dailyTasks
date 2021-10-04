<?php
  session_start();
  
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }
  if(!isset($_SESSION['creating_daily_task_name']) || !isset($_SESSION['nr_of_daily_task']))
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
  <title>Codziennie Wyzwania</title>
  <script type="text/javascript" src="./js/daily_challenge_editor.js"></script>
  <!--link rel="stylesheet" href="./style.css" type="text/css" /-->
  <style>
    html, body{
      width: 100%;
      background: #e0d4bb;
      margin: 0;
    }
    #edited_table{
      border: 1px solid black;
      border-collapse: collapse;
      width: 98%;
      margin-top: 1%;
      margin-right: 1%;
      margin-left: 1%;
    }
    th, td{
      border: 1px solid black;
    }
    #logout_button{
      float: right;
    }
    #logout_div{
      margin: 0.5em;
    }
    h3
    {
      text-align: center;
    }
    #panel{
      width: 100%;
    }
    input{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
  </style>
</head>
<body onload="loadTable()">
  
  <div id="logout_div">
    <a href="./logout.php">
      <input type="button" id="logout_button" value="Wylogowanie"></input>
    </a>
    <a href="./main_panel.php">
      <input type="button" id="logout_button" value="Powrót"></input>
    </a>
  </div>
  
  <div style="clear:both"></div>
  
  <h2 style="text-align: center;">Edytor Codziennych zadań "<?php echo $_SESSION['creating_daily_task_name']?>" 
  użytkownika <?php echo $_SESSION['nick_logged']?></h2>
  
  <div id="targets_div">
    <table id="targets_table">
    <tr>
        <th style="width: 3%;">LP</th>
        <th style="width: 24%;">TREŚĆ</th>
        <th style="width: 10%;">SKRÓT</th>
        <th style="width: 3%;">SKALA</th>
        <th style="width: 10%;">OPIS WYK. 0</th>
        <th style="width: 10%;">OPIS WYK. 1</th>
        <th style="width: 10%;">OPIS WYK. 2</th>
        <th style="width: 10%;">OPIS WYK. 3</th>
        <th style="width: 10%;">OPIS WYK. 4</th>
        <th style="width: 10%;">OPIS WYK. 5</th>
        <th style="display: none;"></th>
      </tr>
    </table>
  </div>

  <h3>Panel do zarządzania danymi:</h3>

  <div style="clear:both"></div>

    <div id="panel_div">
      <table id="panel" style="table-layout:fixed;">
        <tr>
          <th style="width: 4%; min-width: 40px;"></th>
          <th style="width: 4%; min-width: 40px;">ID</th>
          <th style="width: 20%;">Treść</th>
          <th style="width: 10%;">Skrót</th>
          <th style="width: 4%; min-width: 40px;">Skala</th>
          <th style="width: 10%;">Opis wyk. 0</th>
          <th style="width: 10%;">Opis wyk. 1</th>
          <th style="width: 10%;">Opis wyk. 2</th>
          <th style="width: 10%;">Opis wyk. 3</th>
          <th style="width: 10%;">Opis wyk. 4</th>
          <th style="width: 10%;">Opis wyk. 5</th>
          <th style="display:none;"></th>
        </tr>
        <tr>
          <td style="width: 4%;"><input type="button" style="width: 100%;" onclick="addDailyTaskRow()" value="Dodaj"></input></td>
          <td style="width: 4%;"><input type="number" style="width: 100%;" disabled></input></td>
          <td style="width: 20%;"><input type="text" style="width: 100%;"></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;"></input></td>
          <td style="width: 4%;"><input type="number" style="width: 100%;" value="1" min="0" max="5" onchange="scaleChanged()" id="scaleOfAddingRow"></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;" id="done0"></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;" id="done1"></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;" id="done2" disabled></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;" id="done3" disabled></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;" id="done4" disabled></input></td>
          <td style="width: 10%;"><input type="text" style="width: 100%;" id="done5" disabled></input></td>
          <td style="display:none;"></td>
        </tr>
        <tr>
          <td style="width: 4%;"><input type="button" style="width: 100%;" onclick="deleteDailyTaskRow()" value="Usuń"></input></td>
          <td style="width: 4%;"><input type="number" style="width: 100%; padding: 5%" min="1" id="deleteLp" onchange="changeDeleteLp()"></input></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="width: 10%;"></td>
          <td style="display:none;"></td>
        </tr>
      </table>
    </div>
</body>
</html>
