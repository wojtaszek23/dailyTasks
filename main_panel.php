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
  <link rel="stylesheet" href="./css/main_panel.css" type="text/css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
  <aside id="logout_div">
    <a href="./logout.php">
      <input type="button" id="logout_button" value="Wylogowanie"></input>
    </a>
  </aside>
  <header id="title">
    <h2 style="padding:0; margin: 0;">Panel główny użytkownika <?php echo $_SESSION['nick_logged']?></h2>
  </header>
  <article id="daily_tasks">
    <header id="daily_tasks_title">
      <h3>Codzienne założenia</h3>
    </header>
    <section class="daily_task_section" id="daily_task_1">
        <input type="text" id="daily_task_1_name_field" class="daily_task_name_field" disabled/>
        <button type="button" id="daily_task_1_edit_button" class="daily_task_edit_button" onclick="daily_task_edit_button_clicked(1)">Wprowadź / Edytuj</button>
        <input type="button" id="daily_task_1_remove_button" class="daily_task_remove_botton" onclick="daily_task_remove_button_clicked(1)" value="Usuń"/>
    </section>
    <section class="daily_task_section" id="daily_task_2">
        <input type="text" id="daily_task_2_name_field" class="daily_task_name_field" disabled/>
        <button type="button" id="daily_task_2_edit_button" class="daily_task_edit_button" onclick="daily_task_edit_button_clicked(2)">Wprowadź / Edytuj</button>
        <input type="button" id="daily_task_2_remove_button" class="daily_task_remove_botton"  onclick="daily_task_remove_button_clicked(2)" value="Usuń"/>
    </section>
    <section class="daily_task_section" id="daily_task_3">
        <input type="text" id="daily_task_3_name_field" class="daily_task_name_field" disabled/>
        <button type="button" id="daily_task_3_edit_button" class="daily_task_edit_button" onclick="daily_task_edit_button_clicked(3)">Wprowadź / Edytuj</button>
        <input type="button" id="daily_task_3_remove_button" class="daily_task_remove_botton"  onclick="daily_task_remove_button_clicked(3)" value="Usuń"/>
    </section>
  </article>
  <article id="calendars">
    <header id="calendars_title">
      <h3>Kalendarze</h3>
    </header>
    <section class="calendar_section" id="calendar_1">
        <input type="text" id="calendar_1_name_field" class="calendar_name_field" disabled/>
        <button type="button" id="calendar_1_edit_button" class="calendar_edit_button">Wprowadź / Edytuj</button>
        <input type="button" id="calendar_1_remove_button" class="calendar_remove_botton" onclick="daily_task_remove_button_clicked(4)" value="Usuń"/>
    </section>
    <section class="calendar_section" id="calendar_2">
        <input type="text" id="calendar_2_name_field" class="calendar_name_field" disabled/>
        <button type="button" id="calendar_2_edit_button" class="calendar_edit_button">Wprowadź / Edytuj</button>
        <input type="button" id="calendar_2_remove_button" class="calendar_remove_botton" onclick="daily_task_remove_button_clicked(5)" value="Usuń"/>
    </section>
    <section class="calendar_section" id="calendar_3">
        <input type="text" id="calendar_3_name_field" class="calendar_name_field" disabled/>
        <button type="button" id="calendar_3_edit_button" class="calendar_edit_button">Wprowadź / Edytuj</button>
        <input type="button" id="calendar_3_remove_button" class="calendar_remove_botton" onclick="daily_task_remove_button_clicked(6)" value="Usuń"/>
    </section>
  </article>
  <article id="diaries">
    <header id="diaries_title">
      <h3>Notatniki/Pamiętniki</h3>
    </header>
    <section class="diary_section" id="daily_task_1">
        <input type="text" id="diary_1_name_field" class="diary_name_field" disabled/>
        <button type="button" id="diary_1_edit_button" class="diary_edit_button">Wprowadź / Edytuj</button>
        <input type="button" id="diary_1_remove_button" class="diary_remove_button" onclick="daily_task_remove_button_clicked(7)" value="Usuń"/>
    </section>
    <section class="diary_section" id="daily_task_2">
        <input type="text" id="diary_2_name_field" class="diary_name_field" disabled/>
        <button type="button" id="diary_2_edit_button" class="diary_edit_button">Wprowadź / Edytuj</button>
        <input type="button" id="diary_2_remove_button" class="diary_remove_button" onclick="daily_task_remove_button_clicked(8)" value="Usuń"/>
    </section>
    <section class="diary_section" id="daily_task_3">
        <input type="text" id="diary_3_name_field" class="diary_name_field" disabled/>
        <button type="button" id="diary_3_edit_button" class="diary_edit_button">Wprowadź / Edytuj</button>
        <input type="button" id="diary_3_remove_button" class="diary_remove_button" onclick="daily_task_remove_button_clicked(9)" value="Usuń"/>
    </section>
  </article>
  <script type="text/javascript" src="./js/main_panel.js"></script>
</body>