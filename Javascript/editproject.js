//JavaScript for editproject page

//Adds cost to editproject form
function addCostProject() 
{
    var c = document.getElementById("counterAddCostId").value;
    var d = document.getElementById("tableEditCostId");
    var x = document.getElementById("select0");
    c++;

    d.insertRow(c).id = "addCost"+c;
    var m = document.getElementById("addCost"+c);
    //m.innerHTML = document.getElementById("addCost0").innerHTML;
    m.innerHTML = '<td>Kostencode(JavaScript)</td>'+
    '<td><select name="editProjectCostSelect'+c+'">'+
    x.innerHTML+'</select></td>'+
    '<td><input type="text" name="editProjectDate'+c+'" placeholder="DD-MM-YYYY"></td>'+
    '<td><input name="editProjectAmount'+c+'" type="number" step="0.01" value="0"></td>';

    document.getElementById("counterAddCostId").value = c;
}

//Removes cost to editproject form
function removeCostProject() 
{
    var e = document.getElementById("counterAddCostId").value;
    if (e >= 1)
    {
        var e = document.getElementById("counterAddCostId").value;
        var f = document.getElementById("addCost"+e);
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
    var y = document.getElementById("select00");
    i++;

    j.insertRow(i).id = "memberrow"+i;
    var m = document.getElementById("memberrow"+i);
    m.innerHTML = '<td><select name="editProjectAddMember'+i+'">'+
    y.innerHTML+'</select></td>';
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