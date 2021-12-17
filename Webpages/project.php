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
    $stmt = mysqli_prepare($conn, "SELECT * FROM projectcosts 
    INNER JOIN projects ON projectcosts.projectcostCodeId = projects.projectId
    INNER JOIN users ON projectcosts.projectcostUserId = users.userId
    INNER JOIN costs ON projectcosts.projectcostCostId = costs.costId
    WHERE projectcostCodeId = ? ;");
    mysqli_stmt_bind_param($stmt, 'i', $viewProjectId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, /* $projectid, $firstname, etc */);
    mysqli_stmt_store_result($stmt);
    $i = 0;
    while (mysqli_stmt_fetch($stmt))
    {
        if ($i == 0)
        {
            //eerste rij bevat alle informatie
            //projectnummer(id), projectnaam, kostencode, kostenomschrijving, datum gemaakte kosten,
            //persoon wie kosten heeft toegevoegd, bedrag kosten
        }
        else
        {
            //volgende rijen bevatten:
            //(leeg), (leeg), kostencode, kostenomschrijving, datum gemaakte kosten,
            //persoon wie kosten heeft toegevoegd, bedrag kosten
        }
        $i++;
    }

    //daarna sql querie met sum van alle kosten voor totaal. tabelstructuur:
    //(leeg), (leeg), (leeg), (leeg), (leeg), totaal:, sum(kosten).
    

    echo $_POST["viewId"];


        //print alle informatie in input elementen
        //informatie: projectkosten: datum project kost, datum invoering projectkost
        // hoeveelheid projectkost, het projectnummer(id), gebruiker die kosten toevoegde en kostencode.
        // projectmembers: projectnummer(id), userId

        //Pagina laadt alle kosten en projectmembers in (hetzelfde als project.php), 
        //Ingeladen kosten en projectmembers zijn aan te passen,
        //Knop onder aan pagina voor het opslaan van veranderingen,
        //En eventueel knop voor niet opslaan,
        //Vergeet niet dat kosten en projectmembers hier ook moeten kunnen worden verwijderd.

    
    /*
    //Gets project id's
    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    $stmt = mysqli_prepare($conn, $sql1);
    sql2();
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $project);
    mysqli_stmt_store_result($stmt);

    //Gets data by project
    while (mysqli_stmt_fetch($stmt)) 
    {
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
        $currentdate = date("Y-m-d H:i:s");
        sql3();
        $s = mysqli_prepare($conn, "SELECT projectId, projectName, projectCreationDate, projectUserId FROM projects WHERE projectId = ? ORDER BY projectCreationDate DESC ;");
        mysqli_stmt_bind_param($s, 'i', $project);
        mysqli_stmt_execute($s);
        mysqli_stmt_bind_result($s, $projectId, $projectName, $projectCreationDate, $projectUserId);
        mysqli_stmt_store_result($s);
        mysqli_stmt_fetch($s);

        $t = mysqli_prepare($conn, "SELECT SUM(projectcostAmount) FROM projectcosts WHERE projectcostCodeId = ? ;");
        mysqli_stmt_bind_param($t, 'i', $project);
        mysqli_stmt_execute($t);
        mysqli_stmt_bind_result($t, $totalcost);
        mysqli_stmt_store_result($t);
        mysqli_stmt_fetch($t);

        echo '<table style="color:white;border:1px solid white;padding:6px;">
        <td style="color:white;border:1px solid white;padding:6px;">'.$projectId.'</td>'.
        '<td style="color:white;border:1px solid white;padding:6px;">'.$projectName.'</td>'.
        '<td style="color:white;border:1px solid white;padding:6px;">'.$projectCreationDate.'</td>'.
        '<td style="color:white;border:1px solid white;padding:6px;">'.$totalcost.'</td></table>';
        echo '<p style="color:white">'.$newdate.'</p>';
        echo '<p style="color:white">'.$_POST["filterProjectsUsers"].'</p>';
        echo '<p style="color:white">'.$_POST["filterProjectsDate"].'</p>';
        echo '<p style="color:white">'.$_POST["filterUsers"].'</p>';
    }
    */
}
?>

<?php include_once '../Referencepages/footer.php' ?>