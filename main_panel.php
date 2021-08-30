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
  <script type="text/javascript" src="./js/daily_challenge_viewer.js"></script>

</head>
<body>

  <aside id="logout_div">
    <a href="./logout.php">
      <input type="button" id="logout_button" value="Wylogowanie"></input>
    </a>
  </aside>
  <article id="daily_tasks">
    <section class="daily_task_section" id="daily_task_1">
        <input type="text" id="daily_task_1_name_field"/>
        <input type="button" id="daily_task_1_edit_button"/>
        <input type="remove" id="daily_task_1_remove_button"/>
    </section>
    <section class="daily_task_section" id="daily_task_2">
        <input type="text" id="daily_task_2_name_field"/>
        <input type="button" id="daily_task_2_edit_button"/>
        <input type="remove" id="daily_task_2_remove_button"/>
    </section>
    <section class="daily_task_section" id="daily_task_3">
        <input type="text" id="daily_task_3_name_field"/>
        <input type="button" id="daily_task_3_edit_button"/>
        <input type="remove" id="daily_task_3_remove_button"/>
    </section>
  </article>
  <article id="calendars">
    <section class="calendar_section" id="calendar_1">
        <input type="text" id="calendar_1_name_field"/>
        <input type="button" id="calendar_1_edit_button"/>
        <input type="remove" id="calendar_1_remove_button"/>
    </section>
    <section class="calendar_section" id="calendar_2">
        <input type="text" id="calendar_2_name_field"/>
        <input type="button" id="calendar_2_edit_button"/>
        <input type="remove" id="calendar_2_remove_button"/>
    </section>
    <section class="calendar_section" id="calendar_3">
        <input type="text" id="calendar_3_name_field"/>
        <input type="button" id="calendar_3_edit_button"/>
        <input type="remove" id="calendar_3_remove_button"/>
    </section>
  </article>
  <article id="diaries">
    <section class="diary_section" id="daily_task_1">
        <input type="text" id="diary_1_name_field"/>
        <input type="button" id="diary_1_edit_button"/>
        <input type="remove" id="diary_1_remove_button"/>
    </section>
    <section class="diary_section" id="daily_task_2">
        <input type="text" id="diary_2_name_field"/>
        <input type="button" id="diary_2_edit_button"/>
        <input type="remove" id="diary_2_remove_button"/>
    </section>
    <section class="diary_section" id="daily_task_3">
        <input type="text" id="diary_3_name_field"/>
        <input type="button" id="diary_3_edit_button"/>
        <input type="remove" id="diary_3_remove_button"/>
    </section>
  </article>
</body>