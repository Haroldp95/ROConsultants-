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
    if (isset($_SESSION["viewProjectId"]))
    {
        $viewProjectId = $_SESSION["viewProjectId"];
    }
    else if (isset($_POST["viewId"]))
    {
        $viewProjectId = $_POST["viewId"];
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
            echo '<table>
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
                <td>'.$vProjectName.'</td>
                <td>'.$vCostId.'</td>
                <td>'.$vCostName.'</td>
                <td>'.$vCostDate.'</td>
                <td>'.$vFirstName.' '.$vLastName.'</td>
                <td>'.$vCostAmount.'</td>
            </tr>';

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
    mysqli_stmt_bind_param($t, 'i', $viewProjectId);
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
}
?>

<?php include_once '../Referencepages/footer.php' ?>