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
    //Check connection
    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    if (!$conn) 
    {
        header("location: ../Webpages/error.php");
        exit();
    }

    //Navigation variables
    $homeNavLinks1 = '<div>
    <a href="../Webpages/createproject.php">Nieuw project</a>
    <a href="../Webpages/profile.php">Profiel</a>';
    $homeNavLinks2 = '<div>
    <a href="../Webpages/createproject.php">Nieuw project</a>
    <a href="../Webpages/profile.php">Profiel</a>
    <a href="">Admin-pagina</a>';
    $homeNavFilter1 = '<form action="../Webpages/home.php" method="post">
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
    $homeNavFilter2 = '<form action="../Webpages/home.php" method="post">
    <p>Projecten van:</p>
    <input type="radio" name="filterProjectsUsers" value="ownProjects" id="filterProjectsUsersOwn">
    <label for="filterProjectsUsersOwn">Eigen projecten</label>
    <input type="radio" name="filterProjectsUsers" value="allProjects" id="filterProjectsUsersAll">
    <label for="filterProjectsUsersOwn">Alle projecten</label>
    <input type="radio" name="filterProjectsUsers" value="empProjects" id="filterProjectsUsersEmp">
    <label for="filterProjectsUsersOwn">Selecteer projecten medewerker</label>
    '.
    '
    <select name="filterUsers">
        <option value="1">Arend</option>
        <option value="2">Jan</option>
    </select>
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

    //Echo home navigation.
    if ($_SESSION["userProfileStatus"] == 1) 
    {
        echo $homeNavLinks1.$homeNavFilter1;
    }
    else if ($_SESSION["userProfileStatus"] == 2)
    {
        echo $homeNavLinks1.$homeNavFilter2;
    }
    else if ($_SESSION["userProfileStatus"] == 3)
    {
        echo $homeNavLinks2.$homeNavFilter2;
    }
    else
    {
        header("location: ../Webpages/error.php");
        exit();
    }

    //Deciding content home overview.
    if (!isset($_POST["filterProjects"]))
    {
        //If user hasn't filled in filter
        $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
        function sql2() {
            global $stmt;
            mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
        }
        function sql3() {
            global $newdate, $currentdate;
            $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
        }
    }
    else
    {
        //If user filled in filter
        //Sets values for $filterUsers and $filterDate
        //nog steeds errors, code moet altijd waarde voor $filterUsers en $filterDate hebben.
        if ($_SESSION["userProfileStatus"] == 1)
        {
            $filterUsers = "ownProjects";
            if (empty(htmlspecialchars($_POST["filterProjectsDate"])))
            {
                $filterDate = "3months";
            }
            else
            {
                $filterDate = htmlspecialchars($_POST["filterProjectsDate"]);
            }
        }
        else if ($_SESSION["userProfileStatus"] == 2)
        {
            $filterUsers = htmlspecialchars($_POST["filterProjectsUsers"]);
            if (empty(htmlspecialchars($_POST["filterProjectsDate"])))
            {
                $filterDate = "3months";
            }
            else
            {
                $filterDate = htmlspecialchars($_POST["filterProjectsDate"]);
            }
        }
        else if ($_SESSION["userProfileStatus"] == 3)
        {
            $filterUsers = htmlspecialchars($_POST["filterProjectsUsers"]);
            if (empty(htmlspecialchars($_POST["filterProjectsDate"])))
            {
                $filterDate = "3months";
            }
            else 
            {
                $filterDate = htmlspecialchars($_POST["filterProjectsDate"]);
            }
        }


        //Checking for empty values
        if (($_SESSION["userProfileStatus"] == 1) && (empty($filterDate)))
        {
            $filterDate = "3months";
        }
        else if (($_SESSION["userProfileStatus"] == 2) && (empty($filterDate)) && (empty($filterUsers)))
        {
            $filterUsers = "ownProjects";
            $filterDate = "3months";
        }
        else if (($_SESSION["userProfileStatus"] == 3) && (empty($filterDate)) && (empty($filterUsers)))
        {
            $filterUsers = "ownProjects";
            $filterDate = "3months";
        }
        else 
        {
            //SQL queries decided on filter
            if ($filterUsers == "ownProjects")
            {
                if ($filterDate == "1month")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
                    }
                }
                else if ($filterDate == "3months")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
                    }
                }
                else if ($filterDate == "calendarYear")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
                    }
                    function sql3() {
                        global $newdate;
                        $newdate = date("Y-01-01 00:00:00");
                    }
                }
                else if ($filterDate == "year")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"),   date("Y")-1));
                    }
                }
                else 
                {
                    header("location: ../Webpages/error.php");
                    exit();
                }
            }
            else if ($filterUsers == "allProjects")
            {
                if ($filterDate == "1month")
                {
                    $sql1 = "SELECT DISTINCT memberProjectId FROM projectmembers ;";
                    function sql2() {
                        "";
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
                    }
                }
                else if ($filterDate == "3months")
                {
                    $sql1 = "SELECT DISTINCT memberProjectId FROM projectmembers ;";
                    function sql2() {
                        "";
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
                    }
                }
                else if ($filterDate == "calendarYear")
                {
                    $sql1 = "SELECT DISTINCT memberProjectId FROM projectmembers ;";
                    function sql2() {
                        "";
                    }
                    function sql3() {
                        global $newdate;
                        $newdate = date("Y-01-01 00:00:00");
                    }
                }
                else if ($filterDate == "year")
                {
                    $sql1 = "SELECT DISTINCT memberProjectId FROM projectmembers ;";
                    function sql2() {
                        "";
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"),   date("Y")-1));
                    }
                }
                else 
                {
                    header("location: ../Webpages/error.php");
                    exit();
                }
            }
            else if ($filterUsers == "empProjects")
            {
                if ($filterDate == "1month")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterUsers"]);
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
                    }
                }
                else if ($filterDate == "3months")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterUsers"]);
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
                    }
                }
                else if ($filterDate == "calendarYear")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterUsers"]);
                    }
                    function sql3() {
                        global $newdate;
                        $newdate = date("Y-01-01 00:00:00");
                    }
                }
                else if ($filterDate == "year")
                {
                    $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
                    function sql2() {
                        global $stmt;
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsers"]);
                    }
                    function sql3() {
                        global $newdate, $currentdate;
                        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"),   date("Y")-1));
                    }
                }
                else 
                {
                    header("location: ../Webpages/error.php");
                    exit();
                }
            }
            else 
            {
                header("location: ../Webpages/error.php");
                exit();
            }
        }
    }

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
}
?>

<?php include_once '../Referencepages/footer.php' ?>