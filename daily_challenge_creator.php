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
    #creating_tasks_table{
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
    #add_row_button{
      width: 4%;
      float: right;
      margin-right: 1%;
    }
    #remove_row_button{
      float: right;
      width: 4%;
    }
    #ok_button{
      clear: both;
      float: right;
      margin-top: 1%;
      margin-right: 1%;
      width: 8%;
      text-align: center;
    }
    #logout_button{
      float: right;
    }
    #logout_div{
      margin: 0.5em;
    }
  </style>
  <script>
    var num_rows = 0;
    var dailyTasksName = "nazwa";
    function saveDailyTasks()
    {
    }
    function removeRowFromTable()
    {
      var table = document.getElementById("creating_tasks_table");
      if( table.rows.length > 1 )
      {
	      var row = table.deleteRow(-1);
	      num_rows = num_rows - 1;
	      document.getElementById('num_rows').value = num_rows;
      }
    }
    function changeScale(id)
    {
      var scale = document.getElementById('scale'+id);
      if(scale.value < 0)
      {
	      scale.value = 0;
      }
      else if(scale.value > 5)
      {
	      scale.value = 5;
      }
      
      var done1 = document.getElementById('done'+"1_"+id);
      var done2 = document.getElementById('done'+"2_"+id);
      var done3 = document.getElementById('done'+"3_"+id);
      var done4 = document.getElementById('done'+"4_"+id);
      var done5 = document.getElementById('done'+"5_"+id);
      
      done1.removeAttribute("disabled","");
      done2.removeAttribute("disabled","");
      done3.removeAttribute("disabled","");
      done4.removeAttribute("disabled","");
      done5.removeAttribute("disabled","");
      if(scale.value < 5)
      {
	      done5.setAttribute("disabled","");
      }
      if(scale.value < 4)
      {
	      done4.setAttribute("disabled","");
      }
      if(scale.value < 3)
      {
	      done3.setAttribute("disabled","");
      }
      if(scale.value < 2)
      {
	      done2.setAttribute("disabled","");
      }
      if(scale.value < 1)
      {
	      done1.setAttribute("disabled","");
      }
    }
    function addRowToTable()
    {
      var table = document.getElementById("creating_tasks_table");
      var row = table.insertRow(-1);
      var cellID = row.insertCell(0);
      var cellDecission = row.insertCell(1);
      var cellShortCut = row.insertCell(2);
      var cellScale = row.insertCell(3);
      var cellStatus = [];
      cellStatus[0] = row.insertCell(4);
      cellStatus[1] = row.insertCell(5);
      cellStatus[2] = row.insertCell(6);
      cellStatus[3] = row.insertCell(7);
      cellStatus[4] = row.insertCell(8);
      cellStatus[5] = row.insertCell(9);
      var id = table.rows.length-1;
      cellID.innerHTML = id;
      cellID.size = "3%";
      cellDecission.innerHTML = '<input text id="decission' + id + '" name="decission' + id + '" style="box-sizing: border-box; width: 100%;"/>';
      cellShortCut.innerHTML = '<input text id="shortcut' + id + '" name="shortcut' + id + '" style="box-sizing: border-box; width: 100%;"/>';
      cellScale.innerHTML = '<input type="number" id="scale' + id + '" name="scale' + id +  
      '" style="box-sizing: border-box; width: 100%;" min="1" max="5" value="1" onchange="changeScale('+id+')"/>';
      
      cellStatus[0].innerHTML = '<input text id="done' + "0_" + id + '" name="done' + "0_" + id +  '" style="box-sizing: border-box; width: 100%;"/>';
      cellStatus[1].innerHTML = '<input text id="done' + "1_" + id + '" name="done' + "1_" + id +  '" style="box-sizing: border-box; width: 100%;"/>';
      for(var i = 2; i < 6; i++)
      {
	      cellStatus[i].innerHTML = '<input text id="done' + i + "_" + id + '" name="done' + i + "_" + id +  '" style="box-sizing: border-box; width: 100%;" disabled/>';
      }
      
      num_rows = num_rows + 1;
      document.getElementById('num_rows').value = num_rows;
    }
  </script>
</head>
<body>
  <div id="logout_div">
    <a href="./logout.php">
      <input type="button" id="logout_button" value="Wylogowanie"></input>
    </a>
  </div>
  <div style="clear:both"></div>
  <h2 style="text-align: center;">Kreator Codziennych zadań "<?php echo $_SESSION['creating_daily_task_name']?>" 
  użytkownika <?php echo $_SESSION['nick_logged']?></h2>
  <form id="daily_tasks_form" action="./save.php" method="post">
    <table id="creating_tasks_table" name="creating_tasks_table">
      <tr>
        <th style="width: 3%;">ID</th>
        <th style="width: 24%;">TREŚĆ</th>
        <th style="width: 10%;">SKRÓT</th>
        <th style="width: 3%;">SKALA</th>
        <th style="width: 10%;">OPIS WYK. 0</th>
        <th style="width: 10%;">OPIS WYK. 1</th>
        <th style="width: 10%;">OPIS WYK. 2</th>
        <th style="width: 10%;">OPIS WYK. 3</th>
        <th style="width: 10%;">OPIS WYK. 4</th>
        <th style="width: 10%;">OPIS WYK. 5</th>
      </tr>
    </table>
    <button type="button" id="add_row_button" onclick="addRowToTable()">+</button>
    <button type="button" id="remove_row_button" onclick="removeRowFromTable()">-</button>
    <input type="submit" id="ok_button" value="ZAPIS"></input>
    <input type="hidden" name="num_rows" id="num_rows" value='0'/>
  </form>
</body>
</html>
