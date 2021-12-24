//JavaScript for editproject page

//Adds cost to editproject form
function addCostProject() 
{
    var c = document.getElementById("counterAddCostId").value;
    var d = document.getElementById("tableAddCost");
    c++;

    d.insertRow(c).id = "costrow"+c;
    var m = document.getElementById("costrow"+c);
    m.innerHTML = document.getElementById("costrow0").innerHTML;
    document.getElementById("counterAddCostId").value = c;
}

//Removes cost to editproject form
function removeCostProject() 
{
    var e = document.getElementById("counterAddCostId").value;
    if (e >= 1)
    {
        var e = document.getElementById("counterAddCostId").value;
        var f = document.getElementById("costrow"+e);
        f.remove();
        e--;
        document.getElementById("counterAddCostId").value = e;
    }
}

//Adds member to editproject form
function addMemberProject() 
{
    var i = document.getElementById("counterAddMemberId").value;
    var j = document.getElementById("tableAddMember");
    i++;

    j.insertRow(i).id = "memberrow"+i;
    var m = document.getElementById("memberrow"+i);
    m.innerHTML = document.getElementById("memberrow0").innerHTML;
    document.getElementById("counterAddMemberId").value = i;
}

//Removes member to editproject form
function removeMemberProject() 
{
    var g = document.getElementById("counterAddMemberId").value;
    if (g >= 1)
    {
        var g = document.getElementById("counterAddMemberId").value;
        var h = document.getElementById("memberrow"+g);
        h.remove();
        g--;
        document.getElementById("counterAddMemberId").value = g;
    }
}