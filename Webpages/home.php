<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<!-- Navigation -->
<?php
session_start();

if (!isset($_SESSION["userId"])) 
{
    header("location: ../Webpages/error.php");
    exit();
} 
else 
{
    if (!$_SESSION["userProfileStatus"] == 1) 
    {
        $homeNavLinks = '<div>
        <a href="../Webpages/createproject.php">Nieuw project</a>
        <a href="../Webpages/profile.php">Profiel</a>';
        echo $homeNavLinks;

        $homeNavFilter = '<form action="../Webpages/home.php" method="post">
        <p>Projecten van:</p>
        <input type="radio" name="filterProjectsDate" value="1month" id="filterProjects1Month">
        <label for="filterProjects1Month">Laatste maand</label>
        <input type="radio" name="filterProjectsDate" value="3months" id="filterProjects3Month">
        <label for="filterProjects3Month">Laatste 3 maanden</label>
        <input type="radio" name="filterProjectsDate" value="calendarYear" id="filterProjectsThisYear">
        <label for="filterProjects1Year">Dit kalenderjaar</label>
        <input type="radio" name="filterProjectsDate" value="year" id="filterProjects1Year">
        <label for="filterProjects1Year">Dit jaar</label>
        <input type="submit" name="filterProjects" value="Toon selectie">
        </form>
        </div>';
        echo $homeNavFilter;

    }
    else if ($_SESSION["userProfileStatus"] == 2)
    {
        $homeNavLinks = '<div>
        <a href="../Webpages/createproject.php">Nieuw project</a>
        <a href="../Webpages/profile.php">Profiel</a>';
        echo $homeNavLinks;

        $homeNavFilter = '<form action="../Webpages/home.php" method="post">
        <p>Projecten van:</p>
        <input type="radio" name="filterProjectsUsers" value="ownProjects" id="filterProjectsUsersOwn">
        <label for="filterProjectsUsersOwn">Eigen projecten</label>
        <input type="radio" name="filterProjectsUsers" value="allProjects" id="filterProjectsUsersAll">
        <label for="filterProjectsUsersOwn">Alle projecten</label>
        <input type="radio" name="filterProjectsUsers" value="empProjects" id="filterProjectsUsersEmp">
        <label for="filterProjectsUsersOwn">Selecteer projecten medewerker</label>
        <p>Projecten uit:</p>
        <input type="radio" name="filterProjectsDate" value="1month" id="filterProjects1Month">
        <label for="filterProjects1Month">Laatste maand</label>
        <input type="radio" name="filterProjectsDate" value="3months" id="filterProjects3Month">
        <label for="filterProjects3Month">Laatste 3 maanden</label>
        <input type="radio" name="filterProjectsDate" value="calendarYear" id="filterProjectsThisYear">
        <label for="filterProjects1Year">Dit kalenderjaar</label>
        <input type="radio" name="filterProjectsDate" value="year" id="filterProjects1Year">
        <label for="filterProjects1Year">Dit jaar</label>
        <input type="submit" name="filterProjects" value="Toon selectie">
        </form>
        </div>';
        echo $homeNavFilter;
    }
    else if ($_SESSION["userProfileStatus"] == 3)
    {
        $homeNavLinks = '<div>
        <a href="../Webpages/createproject.php">Nieuw project</a>
        <a href="../Webpages/profile.php">Profiel</a>
        <a href="">Admin-pagina</a>';
        echo $homeNavLinks;

        $homeNavFilter = '<form action="../Webpages/home.php" method="post">
        <p>Projecten van:</p>
        <input type="radio" name="filterProjectsUsers" value="ownProjects" id="filterProjectsUsersOwn">
        <label for="filterProjectsUsersOwn">Eigen projecten</label>
        <input type="radio" name="filterProjectsUsers" value="allProjects" id="filterProjectsUsersAll">
        <label for="filterProjectsUsersOwn">Alle projecten</label>
        <input type="radio" name="filterProjectsUsers" value="empProjects" id="filterProjectsUsersEmp">
        <label for="filterProjectsUsersOwn">Selecteer projecten medewerker</label>
        <p>Projecten uit:</p>
        <input type="radio" name="filterProjectsDate" value="1month" id="filterProjects1Month">
        <label for="filterProjects1Month">Laatste maand</label>
        <input type="radio" name="filterProjectsDate" value="3months" id="filterProjects3Month">
        <label for="filterProjects3Month">Laatste 3 maanden</label>
        <input type="radio" name="filterProjectsDate" value="calendarYear" id="filterProjectsThisYear">
        <label for="filterProjects1Year">Dit kalenderjaar</label>
        <input type="radio" name="filterProjectsDate" value="year" id="filterProjects1Year">
        <label for="filterProjects1Year">Dit jaar</label>
        <input type="submit" name="filterProjects" value="Toon selectie">
        </form>
        </div>';
        echo $homeNavFilter;
    }
    else 
    {
        header("location: ../Webpages/error.php");
        exit();
    }
}

?>

<!-- Overview projects -->
<?php
session_start();

if (!isset($_SESSION["userId"])) 
{
    header("location: ../Webpages/error.php");
    exit();
} 
else 
{
    if (!isset($_POST["filterProjects"])) 
    {
        //select: projectnummer, projectnaam, datum aanmaak project, 
        //totale kosten, knop project bewerken.
        //Projects from user
        $stmt = mysqli_prepare($conn, "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;");
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $project);
        mysqli_stmt_store_result($stmt);

        while (mysqli_stmt_fetch($stmt)) 
        {
            //Data from projects
            $s = mysqli_prepare($conn, "SELECT * FROM projects ORDER BY projectCreationDate DESC WHERE projectId = ? ;");
            mysqli_stmt_bind_param($s, 'i', $project);
            mysqli_stmt_execute($s);
            mysqli_stmt_bind_result($s, $projectId, $projectName, $projectCreationDate, $projectUserId);
            mysqli_stmt_store_result($s);

            while (mysqli_stmt_fetch($s)) 
            {
                //Total cost project
                $t = mysqli_prepare($conn, "SELECT SUM(projectcostAmount) FROM projectcosts WHERE projectcostCostId = ? ;");
                mysqli_stmt_bind_param($t, 'i', $projectId);
                mysqli_stmt_execute($t);
                //De volgende twee lijnen kunnen verkeerd zijn;
                //misschien vervangen door mysqli_stmt_fetch($t)
                mysqli_stmt_bind_result($t, $totalcost);
                mysqli_stmt_store_result($t);

                $record = '<td>'.$projectId.'</td><td>'.
                $projectName.'</td><td>'.
                $projectCreationDate.'</td><td>'.
                $totalcost.
            }
        }
    }
}
?>


<?php include_once '../Referencepages/footer.php' ?>