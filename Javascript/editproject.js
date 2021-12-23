//JavaScript for editproject page

function addCostProject() 
{
    //Variables
    var i = document.getElementById("counterAddCostId").value;
    var j = document.getElementById("tableAddCost");
    i++;

    //Creates new row
    j.insertRow(i).id = "costrow"+i;
    var m = document.getElementById("costrow"+i);
    m.innerHTML = document.getElementById("costrow0").innerHTML;
    document.getElementById("counterAddCostId").value = i;
}

function addMemberProject() 
{
    //Variables
    var i = document.getElementById("counterAddMemberId").value;
    var j = document.getElementById("tableAddMember");
    i++;

    //Creates new row
    j.insertRow(i).id = "memberrow"+i;
    var m = document.getElementById("memberrow"+i);
    m.innerHTML = document.getElementById("memberrow0").innerHTML;
    document.getElementById("counterAddMemberId").value = i;
}