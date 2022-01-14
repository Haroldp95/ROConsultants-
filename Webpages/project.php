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
    if (isset($_POST["viewId"]))
    {
        $viewProjectId = $_POST["viewId"];
    }
    else if (isset($_SESSION["viewProjectId"]))
    {
        $viewProjectId = $_SESSION["viewProjectId"];
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
    $editprojectNavLinks1 = '<div class="projectNavContainer">
    <a href="../Webpages/home.php">Home</a>
    <form action="../Webpages/editproject.php" method="post">
    <input type="hidden" name="editId" value="'.$viewProjectId.'">
    <input type="submit" name="editProject" value="Bewerk"></form>
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
    mysqli_stmt_bind_param($stmt, 'i', $viewProjectId);
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
            echo '<div class="projectContainer"><table class="homeProjectsTable">
            <tr>
                <td class="projectsTableTh">Projectnummer</td>
                <td class="projectsTableTh">Projectnaam</td>
                <td class="projectsTableTh">Kostencode</td>
                <td class="projectsTableTh">Kostenomschrijving</td>
                <td class="projectsTableTh">Datum</td>
                <td class="projectsTableTh">Verantwoordelijke</td>
                <td class="projectsTableTh">Bedrag</td>
            </tr>

            <tr>
                <td class="projectsTableTd2">'.$vProjectId.'</td>
                <td class="projectsTableTd2">'.$vProjectName.'</td>
                <td class="projectsTableTd2">'.$vCostId.'</td>
                <td class="projectsTableTd2">'.$vCostName.'</td>
                <td class="projectsTableTd2">'.$vCostDate.'</td>
                <td class="projectsTableTd2">'.$vFirstName.' '.$vLastName.'</td>
                <td class="projectsTableTd2">'.$vCostAmount.'</td>
            </tr>';

        }
        else
        {
            //Second row: empty, empty, cost id, 
            //description, date, name person, cost amount
            echo '<tr>
                <td class="projectsTableTd2"></td>
                <td class="projectsTableTd2"></td>
                <td class="projectsTableTd2">'.$vCostId.'</td>
                <td class="projectsTableTd2">'.$vCostName.'</td>
                <td class="projectsTableTd2">'.$vCostDate.'</td>
                <td class="projectsTableTd2">'.$vFirstName.' '.$vLastName.'</td>
                <td class="projectsTableTd2">'.$vCostAmount.'</td>
            </tr>';
        }
        $i++;
    }
    //Last row: empty, empty, empty, empty, empty, total:, sum(costs)
    $t = mysqli_prepare($conn, "SELECT SUM(projectcostAmount) FROM projectcosts WHERE projectcostCodeId = ? ;");
    mysqli_stmt_bind_param($t, 'i', $viewProjectId);
    mysqli_stmt_execute($t);
    mysqli_stmt_bind_result($t, $vSumCost);
    mysqli_stmt_store_result($t);
    mysqli_stmt_fetch($t);
    
    echo '<tr>
        <td class="projectsTableTd3"></td>
        <td class="projectsTableTd3"></td>
        <td class="projectsTableTd3"></td>
        <td class="projectsTableTd3"></td>
        <td class="projectsTableTd3"></td>
        <td class="projectsTableTd3">Totaal</td>
        <td class="projectsTableTd3">'.$vSumCost.'</td>
    </tr>
    </table></div>';
}
?>

<?php include_once '../Referencepages/footer.php' ?>