 
function addRow(rowData)
{
    var table = document.getElementById("targets_table");
    console.log(table);
    var rows = table.rows;
    var lp = rows.length;
    var row = table.insertRow();

    var cell1 = row.insertCell(0);
    cell1.innerHTML = lp;
    var cell2 = row.insertCell(1);
    cell2.innerHTML = rowData.decission;
    var cell3 = row.insertCell(2);
    cell3.innerHTML = rowData.shortcut;
    var cell4 = row.insertCell(3);
    cell4.innerHTML = rowData.scale;
    var cell5 = row.insertCell(4);
    cell5.innerHTML = rowData.done0;
    var cell6 = row.insertCell(5);
    cell6.innerHTML = rowData.done1;
    var cell7 = row.insertCell(6);
    cell7.innerHTML = rowData.done2;
    var cell8 = row.insertCell(7);
    cell8.innerHTML = rowData.done3;
    var cell9 = row.insertCell(8);
    cell9.innerHTML = rowData.done4;
    var cell10 = row.insertCell(9);
    cell10.innerHTML = rowData.done5;
    var cell11 = row.insertCell(10);
    cell11.innerHTML = rowData.id;
    cell11.style="display: none;";
}

function fillTable(data)
{
    var i = 0;
    for(let row of data)
    {
        i = i + 1;
        addRow(row);
    }
}

function loadTable()
{
    var xmlhttp = new XMLHttpRequest();
    var url = "./get_targets.php";

    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200) 
        {
            if(this.responseText!="")
            {
                console.log(this.responseText);
              var data = JSON.parse(this.responseText);
              fillTable(data);
            }
        }
    };
  
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function addDailyTaskRow()
{
    var xmlhttp = new XMLHttpRequest();
    var url = "./add_daily_task_row.php";

    var table = document.getElementById("panel");
    var addingRow = table.rows[1];
    var cells = [];
    cells = addingRow.cells;
    
    var decission = cells[2].children[0].value;    
    var shortcut = cells[3].children[0].value;
    var scale = cells[4].children[0].value;
    var done0 = cells[5].children[0].value;
    var done1 = cells[6].children[0].value;        
    var done2 = cells[7].children[0].value;
    var done3 = cells[8].children[0].value;
    var done4 = cells[9].children[0].value;
    var done5 = cells[10].children[0].value;

    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200) 
        {
            if(this.responseText!="")
            {
                var id = this.responseText;             
                var table = document.getElementById("panel");
                var addingRow = table.rows[2];
                var cells = [];
                cells = addingRow.cells;
                var row = [];
                row['decission'] = cells[2].children[0].value;
                row['shortcut'] = cells[3].children[0].value;
                row['scale'] = cells[4].children[0].value;
                row['done0'] = cells[5].children[0].value;
                row['done1'] = cells[6].children[0].value;
                row['done2'] = cells[7].children[0].value;
                row['done3'] = cells[8].children[0].value;
                row['done4'] = cells[9].children[0].value;
                row['done5'] = cells[10].children[0].value;
                row['id'] = id;
                addRow(row);
            }
        }
    };

    xmlhttp.open("GET", url+"?decission="+decission+"&shortcut="+shortcut+"&scale="+scale+"&done0="+done0+"&done1="+done1+"&done2="+done2+"&done3="+done3+"&done4="+done4+"&done5="+done5, true);
    xmlhttp.send();
}

function deleteDailyTaskRow()
{
    var lp = document.getElementById("DeleteLp");
    lp = parseInt(1)+parseInt(lp.value);
    if(document.getElementById("targets_table").rows.length <= lp)
        return;
    var xmlhttp = new XMLHttpRequest();
    var url = "./delete_daily_task_row.php";
    var table = document.getElementById("targets_table");
    var id = table.rows[lp].cells[10].innerHTML;

    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200) 
        {
	        var deleteLp = parseInt(1)+parseInt(document.getElementById("deleteLp").value);
            var table = document.getElementById("targets_table");
            table.deleteRow(deleteLp);
            var unsetRow = document.getElementById("panel").rows[3];
            for(var i = 1; i < 12; i++)
            {
                unsetRow.cells[i].innerHTML = "";
            }
            var unsetValue = document.getElementById("deleteLp");
            unsetValue.value = 0;
            for(var i = 2; i < table.rows.length; i++)
            {
                table.rows[i].cells[0].innerHTML = i-1;
            }
        } 
    };

    xmlhttp.open("GET", url+"?id="+id, true);
    xmlhttp.send();
}

function changeDeleteLp()
{
  var lp = document.getElementById("deleteLp");
  lp = lp.value;
  var table = document.getElementById("targets_table");
  var panel = document.getElementById("panel");
  var panelRow = panel.rows[2];
  var panelCells = panelRow.cells;
  if(table.rows.length == 1)
  {
    document.getElementById("deleteLp").value = "";
    for(var i = 1; i < 11; i++)
    {
      panelCells[i+1].innerHTML = cells[i].innerHTML;
    }
    return;
  }
  else if(lp < 1)
  { 
    lp = document.getElementById("deleteLp").value = 1; 
  }
  else if(lp >= table.rows.length)
  {
    lp = document.getElementById("deleteLp").value = table.rows.length - 1;
  };
  var row = table.rows[parseInt(lp)];
  var cells = [];
  cells = row.cells;
  if(cells)
  {
    for(var i = 1; i < 11; i++)
    {
      panelCells[i+1].innerHTML = cells[i].innerHTML;
    }
  }
}

function scaleChanged()
{
  console.log("dupa");
  var scale = document.getElementById("scaleOfAddingRow").value;
  if(scale < 5)
  {
    document.getElementById("done5").value="";
    document.getElementById("done5").setAttribute("disabled", '');
  }
  if(scale < 4)
  {
    document.getElementById("done4").value="";
    document.getElementById("done4").setAttribute("disabled", '');
  }
  if(scale < 3)
  {
    document.getElementById("done3").value="";
    document.getElementById("done3").setAttribute("disabled", '');
  }
  if(scale < 2)
  {
    document.getElementById("done2").value="";
    document.getElementById("done2").setAttribute("disabled", '');
  }
  if(scale < 1)
  {
    document.getElementById("done1").value="";
    document.getElementById("done1").setAttribute("disabled", '');
  }

  if(scale > 4)
  {
    document.getElementById("done5").removeAttribute("disabled");
  }
  if(scale > 3)
  {
    document.getElementById("done4").removeAttribute("disabled");
  }
  if(scale > 2)
  {
    document.getElementById("done3").removeAttribute("disabled");
  }
  if(scale > 1)
  {
    document.getElementById("done2").removeAttribute("disabled");
  }
  if(scale > 0)
  {
    document.getElementById("done1").removeAttribute("disabled");
  }
}