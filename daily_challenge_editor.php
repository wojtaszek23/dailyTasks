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
  </style>
  <script>
    
  </script>
</head>
<body>
  
  <div id="logout_div">
    <a href="./logout.php">
      <input type="button" id="logout_button" value="Wylogowanie"></input>
    </a>
  </div>
  
  <div style="clear:both"></div>
  
  <h2 style="text-align: center;">Edytor Codziennych zadań "<?php echo $_SESSION['creating_daily_task_name']?>" 
  użytkownika <?php echo $_SESSION['nick_logged']?></h2>
  
  <div id="targets_div">
    <table id="targets_table">
    </table>
  </div>

  <h3>Panel do zarządzania danymi:</h3>
      
      <table id="panel">
        <tr>
          <th></th>
          <th>ID</th>
          <th>Treść</th>
          <th>Skrót</th>
          <th>Skala</th>
          <th>Opis wyk. 0</th>
          <th>Opis wyk. 1</th>
          <th>Opis wyk. 2</th>
          <th>Opis wyk. 3</th>
          <th>Opis wyk. 4</th>
          <th>Opis wyk. 5</th>
        </tr>
        <tr>
          <td><input type="button" onclick="addTask()" value="Dodaj"></input></td>
          <td><input type="number" disabled></input></td>
          <td><input type="text"></input></td>
          <td><input type="text"></input></td>
          <td><input type="number" value="1" min="0" max="5"></input></td>
          <td><input type="text"></input></td>
          <td><input type="text"></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
        </tr>
        <tr>
          <td><input type="button" onclick="deleteTask()" value="Usuń"></input></td>
          <td><input type="number" min="0"></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="number" min="0" max="5" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
          <td><input type="text" disabled></input></td>
        </tr>
      </table>

</body>
</html>
