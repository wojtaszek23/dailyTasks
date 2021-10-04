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

function daily_task_edit_button_clicked(nr)
{
    var old_name = $("#daily_task_"+nr+"_name_field").val();
    var daily_task_name = prompt("Nazwa Twoich Codziennych Wyzwań: ", old_name);

    if(daily_task_name == null)
    {
        return;
    }
    var a=0;

    var regex = /^[A-Za-z0-9ąĄćĆęĘłŁńŃóÓśŚźŹżŻ]+$/;
    if(!regex.test(daily_task_name))
    {
        alert("W nazwie dopuszczalnymi znakami są tylko litery (w tym również polskie) oraz cyfry.");
        return;
    }
    
    var url = "check_if_name_exsists.php";
    const dataToSend = {
        name: daily_task_name
    }
    $.get(url, dataToSend)
    .done(res => {
        if(res != "no" && res != "exists in daily_task_"+nr)
        {
            alert("Isnieją już w Twoim panelu Codzienne Wyzwania o tej samej nazwie. Wybierz inną nazwę.")
            return;
        }
        else
        {
            var daily_task_name_field = $("#daily_task_"+nr+"_name_field");
            daily_task_name_field.val(daily_task_name);
            if(old_name == "")
            {
                window.location.href = "go_to_daily_challenge_creator.php/q?nr="+nr+"&name="+daily_task_name+"&type=creator";
            }
            else
            {
                window.location.href = "go_to_daily_challenge_creator.php/q?nr="+nr+"&name="+daily_task_name+"&type=editor";
            }
        }
    })
    .fail(() => {
        alert("Przepraszamy, wystąpił problem podczas próby sprawdzenia dostępności wprowadzonej nazwy.");
        return;
    });
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

    if(!confirm("Czy na pewno chcesz usunąć zasób o nazwie "+daily_task_name+"? Administrator strony nie archiwizuje usuniętych informacji. Nie będzie możliwości przywrócenia ich."))
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

function go_to_daily_task(nr)
{
    url = 'go_to_daily_challenge_viewer.php'+'/?name='+$('#daily_task_'+nr+'_name_field').val();
    console.log(url);
    window.location.href = url;
}

function load()
{
    get_dailies();
}

$(document).ready(load);
