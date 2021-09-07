var dailies;

function get_dailies(){
    var url = "get_daily_tasks_for_user.php";
    $.get(url)
    .done(res => {
        dailies = jQuery.parseJSON(res);
        console.log(dailies[0]['calendar_1']);
        fill_dailies();
    })
    .fail(() => {
        alert("Przepraszamy, wystąpił problem z pobraniem nazw Codziennych założeń, Kalendarzy i Notatników dla użytkownika, więc strona nie załadowała się poprawnie.")
    });
}

function fill_dailies(){
    $("#daily_task_1_name_field").val(dailies[0]['daily_task_1']);
    $("#daily_task_2_name_field").val(dailies[0]['daily_task_2']);
    $("#daily_task_3_name_field").val(dailies[0]['daily_task_3']);

    $("#calendar_1_name_field").val(dailies[0]['calendar_1']);
    $("#calendar_2_name_field").val(dailies[0]['calendar_2']);
    $("#calendar_3_name_field").val(dailies[0]['calendar_3']);
    
    $("#diary_1_name_field").val(dailies[0]['diary_1']);
    $("#diary_2_name_field").val(dailies[0]['diary_2']);
    $("#diary_3_name_field").val(dailies[0]['diary_3']);
}

function load()
{
    get_dailies();
}



$(document).ready(
    load
);

function daily_task_edit_button_clicked(nr)
{
    var old_name = $("#daily_task_"+nr+"_name_field").val();
    var daily_task_name = prompt("Nazwa Twoich Codziennych Wyzwań: ", old_name);

    if(daily_task_name == null)
    {
        return;
    }

    var daily_task_name_field = $("#daily_task_"+nr+"_name_field");

    var daily_tasks_names = [];
    
    


}