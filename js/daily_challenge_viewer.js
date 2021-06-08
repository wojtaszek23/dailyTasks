window.onload = load;
var targets = [];
var results = [];

function next_date()
{
  var dateLabel = document.getElementById("show_date_p");
  dateLabelArray = dateLabel.innerHTML.split(".");
  var date = new Date(dateLabelArray[2], dateLabelArray[1]-1, dateLabelArray[0], 0, 0, 0, 0);
  date.setDate(date.getDate() + 1);
  show_results(date);
  show_targets(date);
  var month = date.getMonth() + 1;
  dateLabel.innerHTML = date.getDate() + "." + month + "." + date.getFullYear();
};

function previous_date()
{
  var dateLabel = document.getElementById("show_date_p");
  dateLabelArray = dateLabel.innerHTML.split(".");
  var date = new Date(dateLabelArray[2], dateLabelArray[1]-1, dateLabelArray[0], 0, 0, 0, 0);
  date.setDate(date.getDate() - 1);
  show_results(date);
  show_targets(date);
  var month = date.getMonth() + 1;
  dateLabel.innerHTML = date.getDate() + "." + month + "." + date.getFullYear();
};

function show_targets(date)
{
    var txt = `
        <table id="targets_table">
            <tr>
              <th style="width:3%;">NR</th>
              <th style="width:23%;">TREŚĆ</th>
              <th style="width:10%;">SKRÓT</th>
              <th style="width:4%;">SKALA</th>
              <th style="width:10%;">OPIS 0</th>
              <th style="width:10%;">OPIS 1</th>
              <th style="width:10%;">OPIS 2</th>
              <th style="width:10%;">OPIS 3</th>
              <th style="width:10%;">OPIS 4</th>
              <th style="width:10%;">OPIS 5</th>
            </tr>`;

    var i = 0;
    for(let target of targets){
        var provide_date = new Date(new Date(target.provide_date).setHours(0)).getTime();
        var remove_date = new Date(new Date(target.remove_date).setHours(0)).getTime();
        
        if( provide_date <= date && ( target.remove_data == null || target.remove_date >= date ) )
        {
        i=i+1;
        txt = txt + 
            `
            <tr>
              <td name="results_table_real_id_` + i + `" style="display: none;">` + target.id + `</td>
              <td name="results_table_id_` + i + `">` + i + `</td>
              <td name="targets_table_decission_` + i + `">` + target.decission +`</td>
              <td name="targets_table_shortcut_` + i + `">` + target.shortcut + `</td>
              <td name="targets_table_scale_` + i + `">0-` + target.scale + `</td>
              <td name="targets_table_done0_` + i + `">` + target.done0 + `</td>
              <td name="targets_table_done1_` + i + `">` + target.done1 + `</td>
              <td name="targets_table_done2_` + i + `">` + target.done2 + `</td>
              <td name="targets_table_done3_` + i + `">` + target.done3 + `</td>
              <td name="targets_table_done4_` + i + `">` + target.done4 + `</td>
              <td name="targets_table_done5_` + i + `">` + target.done5 + `</td>
            </tr>`;
        }
    }
    txt = txt + `
    </table>`;

    var targets_table = document.getElementById("targets_table");
    targets_table.innerHTML = txt;
}

function changeDone(value, id)
{
    console.log("enter changeDone function");
    var dateLabel = document.getElementById("show_date_p");
    dateLabelArray = dateLabel.innerHTML.split(".");
    var date = new Date(dateLabelArray[2], dateLabelArray[1]-1, dateLabelArray[0], 0, 0, 0, 0);
    var res_id=-1;
    for(let result of results)
    {    
        var res_date = new Date(new Date(result.date).setHours(0)).getTime();
                
        if(res_date == date.getTime())
        {
            res_id = result.id;
            break;
        }
    }

    console.log(res_id);
    var url = "change_result_done.php";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 || this.status == 200) 
        {
            //console.log("otrzymano odpowiedź: " + this.responseText);
            for(let res of results)
            {
                var res_date = new Date(new Date(res.date).setHours(0)).getTime();
                if(res_date == date.getTime())
                {
                    res['target_id_'+id] = value;
                }
            }
        }
    };

    xmlhttp.open("GET", url + "?res_id=" + res_id + "&id=" + id + "&value=" + value , true);
    xmlhttp.send();
};

function construct_results()
{
    var txt = `
        <table id="results_table">
        <tr name="results_table_row_0" id="results_table_row_id_0">
            <th style="width:4%;">NR</th>
            <th style="display: none;">REAL_NR</th>
            <th style="width:12%;">SKRÓT</th>
            <th style="width:14%;">REALIZACJA 0</th>
            <th style="width:14%;">REALIZACJA 1</th>
            <th style="width:14%;">REALIZACJA 2</th>
            <th style="width:14%;">REALIZACJA 3</th>
            <th style="width:14%;">REALIZACJA 4</th>
            <th style="width:14%;">REALIZACJA 5</th>
        </tr>`;

    for(let target of targets)
    {   
        var id = target.id;
        var radio_name = `results_table_radio_row_` + id;
        var radio_button = `<input type="radio" style="cursor: pointer;" name="` + radio_name + `" id="` + radio_name + `_done`;

        txt = txt + 
            `
            <tr name="results_table_row_`+id+`" id="results_table_row_`+id+`">
            <td name="results_table_row_`+id+`_real_id" id="results_table_row_"`+id+`_real_id" style="display: none;">` + id + `</td>
            <td name="results_table_row_`+id+`_id" id="results_table_row_`+id+`_id"></td>
            <td name="results_table_row_`+id+`_shortcut">`+target.shortcut+`</td>`;

        txt = txt + `<td name="results_table_row_`+id+`_done0" id="results_table_row_`+id+`_done0">`;    
            if(target.done0!="")  txt = txt + radio_button + `0" onclick="changeDone(0, ` + id + `)" value="0"/>`; 
                txt = txt + `<label style="cursor: pointer;" for="` + radio_name + `_done0">` + target.done0 + `</td>`;

        txt = txt + `<td name="results_table_row_`+id+`_done1" id="results_table_row_`+id+`_done1">`;
            if(target.done1!="") txt = txt + radio_button + `1" onclick="changeDone(1, ` + id + `)" value="1"/>`;
                txt = txt + `<label style="cursor: pointer;" for="` + radio_name + `_done1">` + target.done1 + `</td>`;
                
        txt = txt + `<td name="results_table_row_`+id+`_done2" id="results_table_row_`+id+`_done2">`;
            if(target.done2!="") txt = txt + radio_button + `2" onclick="changeDone(2, ` + id + `)" value="2"/>`;
                txt = txt + `<label style="cursor: pointer;" for="` + radio_name + `_done2">` + target.done2 + `</td>`;

        txt = txt + `<td name="results_table_row_`+id+`_done3" id="results_table_row_`+id+`_done3">`;
            if(target.done3!="") txt = txt + radio_button + `3" onclick="changeDone(3, ` + id + `)" value="3"/>`;
                txt = txt + `<label style="cursor: pointer;" for="` + radio_name + `_done3">` + target.done3 + `</td>`;

        txt = txt + `<td name="results_table_row_`+id+`_done4" id="results_table_row_`+id+`_done4">`;
            if(target.done4!="") txt = txt + radio_button + `4" onclick="changeDone(4, ` + id + `)" value="4"/>`;
                txt = txt + `<label style="cursor: pointer;" for="` + radio_name + `_done4">` + target.done4 + `</td>`;

        txt = txt + `<td name="results_table_row_`+id+`_done5" id="results_table_row_`+id+`_done5">`;
            if(target.done5!="") txt = txt + radio_button + `5" onclick="changeDone(5, ` + id + `)" value="5"/>`;
                txt = txt + `<label style="cursor: pointer;" for="` + radio_name + `_done5">` + target.done5 + `</td>`;
    }

    txt = txt + `</table>`;
    var results_table = document.getElementById("results_table");
    results_table.innerHTML = txt;
}

function show_results(date)
{    
    var results_table = document.getElementById("results_table");
    results_table.style.display = "none";
    var result_width_given_date_exsists = false;
    date = date.getTime();
    for(let result of results)
    {
        var res_date = new Date(new Date(result.date).setHours(0)).getTime();   
        if(res_date == date)
        {
            results_table.style.display = "flex";
            result_width_given_date_exsists = true;
        }
    }

    if(result_width_given_date_exsists == false)
    {
        return;
    }

    var i = 0;
    for(let target of targets){
        var provide_date = new Date(new Date(target.provide_date).setHours(0)).getTime();
        var remove_date = new Date(new Date(target.remove_date).setHours(0)).getTime();
        var id = target.id;
        
        if( provide_date <= date && ( target.remove_data == null || target.remove_date >= date ) )
        {
            i=i+1;
            var row = document.getElementById("results_table_row_"+id);
            row.style='display:"block";';
            var id_cell = document.getElementById("results_table_row_"+id+"_id");
            id_cell.innerHTML = i;

            for(let result of results)
            {    
                var res_date = new Date(new Date(result.date).setHours(0)).getTime();
                
                if(res_date == date)
                {
                    var j;
                    for(j=0; j<=target.scale; j=j+1)
                    {
                        var radio = document.getElementById(`results_table_radio_row_` + id + `_done`+j);
                        radio.checked = false;
                    }
                    var value = result['target_id_'+id];
                    radio = document.getElementById(`results_table_radio_row_` + id + `_done` + value);
                    radio.checked = true;
                }
            }
        }
        else
        {
            var row = document.getElementById("results_table_row_"+id);
            row.style="display: none;";
        }
    }
};

function show_statistics()
{
    var abc = document.getElementById("statistics_div");
    var i = 0;
    var percent = [];
    
    for(let target of targets)
    {
        var id = target.id;
        var scale = target.scale;
        var provide_date = new Date(target.provide_date).getTime();
        var remove_date = new Date(target.remove_date).getTime();
        
        for(let result of results)
        {
            var result_date = new Date(result.date).getTime();
            
            if(result_date >= provide_date && (result_date < remove_date || remove_date == 0))
            {
                i=i+1;
                if(scale!=0) percent[i] = result['target_id_'+id] / scale;
            }
        }
    }
    var sum=0;
    
    for(let element of percent)
    {
        if(element!=undefined) sum = sum + element;
    }
    
    sum = 100* sum / percent.length;
    abc.innerHTML = "Całościowy dotychczasowy stopień realizacji zadań: " + Math.floor(sum) +"%";
};

function load()
{
    var date = new Date();
    var dateLabel = document.getElementById("show_date_p");
    var month = date.getMonth() + 1;
    dateLabel.innerHTML = date.getDate() + "." + month + "." + date.getFullYear();
    var url = "get_targets_and_results.php";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200) 
        {
            if(this.responseText!="")
            {
                var data = JSON.parse(this.responseText);
                results = data.results;
                targets = data.targets;
                construct_results();
                show_targets(date);
                show_results(date);
                show_statistics();
            }
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
};