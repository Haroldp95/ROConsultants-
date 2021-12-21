<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<?php
session_start();

if (!isset($_SESSION["userId"]))
{
    header("location: ../Webpages/error.php");
    exit();
}
else 
{
    if (isset($_SESSION["editProjectId"]))
    {
        $editProjectId = $_SESSION["editProjectId"];
    }
    else if (isset($_POST["editId"]))
    {
        $editProjectId = $_POST["editId"];
    }
    else 
    {
        header("location: ../Webpages/error.php");
        exit();
    }

    //Check connection
    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    if (!$conn) 
    {
        header("location: ../Webpages/error.php");
        exit();
    }

    //Navigation
    $editprojectNavLinks1 = '<div>
    <a href="../Webpages/home.php">Home</a>
    <a href="../Processpages/deleteproject.php">Verwijder project</a>
    </div>';

    //Echo navigation
    echo $editprojectNavLinks1;

    //select projects.projectid, users.userFirstName etc
    $stmt = mysqli_prepare($conn, "SELECT projects.projectId, projects.projectName, costs.costId, 
    costs.costName, projectcosts.projectcostDate, users.userFirstName, users.userLastName, 
    projectcosts.projectcostAmount FROM projectcosts 
    INNER JOIN projects ON projectcosts.projectcostCodeId = projects.projectId
    INNER JOIN users ON projectcosts.projectcostUserId = users.userId
    INNER JOIN costs ON projectcosts.projectcostCostId = costs.costId
    WHERE projectcostCodeId = ? ;");
    mysqli_stmt_bind_param($stmt, 'i', $editProjectId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $vProjectId, $vProjectName, 
    $vCostId, $vCostName, $vCostDate, $vFirstName, $vLastName, $vCostAmount);
    mysqli_stmt_store_result($stmt);

    //Creates table
    $i = 0;
    while (mysqli_stmt_fetch($stmt))
    {
        if ($i == 0)
        {
            //First row: project id, projectname, cost id, 
            //description, date, name person, cost amount
            echo '<form action="../Processpages/editprojecttoproject.php" method="post">
            <input type="hidden" name="editId" value="'.$vProjectId.'">
            <table>
            <tr>
                <td>Projectnummer</td>
                <td>Projectnaam</td>
                <td>Kostencode</td>
                <td>Kostenomschrijving</td>
                <td>Datum</td>
                <td>Verantwoordelijke</td>
                <td>Bedrag</td>
            </tr>

            <tr>
                <td>'.$vProjectId.'</td>
                <td><input type="text" name="editProjectname" placeholder="'.$vProjectName.'"></td>
                <td>'.$vCostId.'</td>
                <td>'.$vCostName.'</td>
                <!--Hier moet <select> komen zie code hieronder-->

                <td>'.$vCostDate.'</td>
                <td>'.$vFirstName.' '.$vLastName.'</td>
                <td>'.$vCostAmount.'</td>
            </tr>';
            /*

            <input type="number" min="0" max="23.99" step="0.01">

            <label for="filterProjectsUsersOwn">Selecteer projecten medewerker</label>
            <select name="filterProjectsUsersSelect">';
            
            //Code for <select user>
            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $m = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName FROM users;");
            mysqli_stmt_execute($m);
            mysqli_stmt_bind_result($m, $rId, $rFirstName, $rLastName);
            mysqli_stmt_store_result($m);

            while (mysqli_stmt_fetch($m)) 
            {
                $homeNavFilter2 .= '<option value="'.$rId.'">'.
                $rFirstName.' '.$rLastName.'</option>';
            }
            
            $homeNavFilter2 .= '</select>
            */

        }
        else
        {
            //Second row: empty, empty, cost id, 
            //description, date, name person, cost amount
            echo '<tr>
                <td></td>
                <td></td>
                <td>'.$vCostId.'</td>
                <td>'.$vCostName.'</td>
                <td>'.$vCostDate.'</td>
                <td>'.$vFirstName.' '.$vLastName.'</td>
                <td>'.$vCostAmount.'</td>
            </tr>';
        }
        $i++;
    }
    //Last row: empty, empty, empty, empty, empty, total:, sum(costs)
    $t = mysqli_prepare($conn, "SELECT SUM(projectcostAmount) FROM projectcosts WHERE projectcostCodeId = ? ;");
    mysqli_stmt_bind_param($t, 'i', $editProjectId);
    mysqli_stmt_execute($t);
    mysqli_stmt_bind_result($t, $vSumCost);
    mysqli_stmt_store_result($t);
    mysqli_stmt_fetch($t);
    
    echo '<tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Totaal</td>
        <td>'.$vSumCost.'</td>
    </tr>
    </table>';

    //Add cost
    echo '<p>Toevoegen kosten</p>';

    //Add projectmember
    echo '<p>Toevoegen projectleden</p>';

    //End of form
    echo '<input type="submit" name="editProject" value="Wijzigen opslaan">
    </form>
    <form action="../Webpages/project.php" method="post">
    <input type="hidden" name="viewId" value="'.$vProjectId.'">
    <input type="submit" name="viewProject" value="Wijzigen verwerpen">
    </form>';
}
?>

<?php include_once '../Referencepages/footer.php' ?>