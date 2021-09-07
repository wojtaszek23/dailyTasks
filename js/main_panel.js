var dailies;

function get_dailies(){
    var url = "get_daily_tasks_for_user.php";
    $.get(url)
    .done(res => {
        dailies = jQuery.parseJSON(res);
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

function daily_task_remove_button_clicked(nr)
{
    var daily_task_name_id;

    if(nr < 4 && nr > 0)
        daily_task_name_id = "#daily_task_"+nr+"_name_field";
    else if(nr < 7)
        daily_task_name_id = "#calendar_"+(nr-3).toString()+"_name_field";
    else if(nr < 10)
        daily_task_name_id = "#diary_"+(nr-6).toString()+"_name_field";

    var daily_task_name = $(daily_task_name_id).val();
    
    if(daily_task_name == "")
    {
        return;
    }

    if(!confirm("Czy na pewno chcesz usunąć Codzienne Wyzwania o nazwie"+daily_task_name+"? Administrator strony nie archiwizuje usuniętych informacji. Nie będzie możliwości przywrócenia ich."))
    {
        return;
    }

    var url = "remove_daily_task.php";
    const removeInfo = {
        contentType: nr,
        name: daily_task_name
    }

    $.get(url, removeInfo)
    .done(res => {
        $(daily_task_name_id).val("");
    })
    .fail(() => {
        alert("Przepraszamy, wystąpił problem podczas próby usunięcia.")
    });
}