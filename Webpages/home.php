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
        $sql1 = "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;";
        function sql2() {
            global $stmt;
            mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
        }
        function sql3() {
            global $newdate, $currentdate;
            $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
        }
        /*
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    $stmt = mysqli_prepare($conn, $sql1);
    sql2();
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $project);
    mysqli_stmt_store_result($stmt);

    while (mysqli_stmt_fetch($stmt)) 
    {

        $currentdate = date("Y-m-d H:i:s");
        global $newdate, $currentdate;
        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));

        //Data from projects
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
        $s = mysqli_prepare($conn, "SELECT * FROM projects WHERE projectId = ? AND 
        projectCreationDate BETWEEN ? AND ? ORDER BY projectCreationDate DESC ;");
        mysqli_stmt_bind_param($s, 'iss', $project, $currentdate, $newdate);
        mysqli_stmt_execute($s);
        mysqli_stmt_bind_result($s, $projectId, $projectName, $projectCreationDate, $projectUserId);
        mysqli_stmt_store_result($s);
        global $projectId, $projectName, $projectCreationDate, $projectUserId;

        echo $projectId." ".$projectName;


        while (mysqli_stmt_fetch($s)) 
        {
            global $projectId, $projectName, $projectCreationDate, $projectUserId;
            echo $projectId." ".$projectName;
            //Total cost project
            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $t = mysqli_prepare($conn, "SELECT SUM(projectcostAmount) FROM projectcosts WHERE projectcostCostId = ? ;");
            mysqli_stmt_bind_param($t, 'i', $projectId);
            mysqli_stmt_execute($t);
            mysqli_stmt_bind_result($t, $totalcost);
            mysqli_stmt_store_result($t);

            

            while (mysqli_stmt_fetch($t))
            {
                
                echo $totalcost;
                global $projectId, $projectName, $projectCreationDate, $projectUserId;
                $record = '<td>'.$projectId.'</td><td>'.
                $projectName.'</td><td>'.
                $projectCreationDate.'</td><td>'.
                $totalcost.'</td><td><a href="../Webpages/editproject.php?id="'.
                $projectId.'">Bewerk</a></td>';
                echo $record;
            }

            //Table with project data
            //$record = '<td>'.$projectId.'</td><td>'.
            //$projectName.'</td><td>'.
            //$projectCreationDate.'</td><td>'.
            //$totalcost.'</td><td><a href="../Webpages/editproject.php?id="'.
            //$projectId.'">Bewerk</a></td>';
            //echo $record;
        } 
    } */

    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    $stmt = mysqli_prepare($conn, "SELECT memberProjectId FROM projectmembers WHERE memberUserId = ? ;");
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION["userId"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $project);
    mysqli_stmt_store_result($stmt);
    while (mysqli_stmt_fetch($stmt)) 
    {
        $currentdate = date("Y-m-d H:i:s");
        $newdate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
        $s = mysqli_prepare($conn, "SELECT * FROM projects WHERE projectId = ? AND 
        projectCreationDate BETWEEN ? AND ? ORDER BY projectCreationDate DESC ;");
        mysqli_stmt_bind_param($s, 'iss', $project, $currentdate, $newdate);
        mysqli_stmt_execute($s);
        mysqli_stmt_bind_result($s, $projectId, $projectName, $projectCreationDate, $projectUserId);
        mysqli_stmt_store_result($s);

        echo "<td>".$projectId."</td><td>".$projectName."</td><td>".$projectCreationDate."</td>";
    }



    }
    else
    {
        if (empty(htmlspecialchars($_POST["filterProjectsUsers"])) || 
        empty(htmlspecialchars($_POST["filterProjectsDate"])) )
        {
            header("location: ../Webpages/home.php");
            exit();
        }
        else 
        {
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
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsers"]);
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
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsers"]);
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
                        mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsers"]);
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

    //Gets data for home, after deciding content
    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    $stmt = mysqli_prepare($conn, $sql1);
    sql2();
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $project);
    mysqli_stmt_store_result($stmt);

    while (mysqli_stmt_fetch($stmt)) 
    {

        $currentdate = date("Y-m-d H:i:s");
        sql3();

        //Data from projects
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
        $s = mysqli_prepare($conn, "SELECT * FROM projects WHERE projectId = ? AND 
        projectCreationDate BETWEEN ? AND ? ORDER BY projectCreationDate DESC ;");
        mysqli_stmt_bind_param($s, 'iss', $project, $currentdate, $newdate);
        mysqli_stmt_execute($s);
        mysqli_stmt_bind_result($s, $projectId, $projectName, $projectCreationDate, $projectUserId);
        mysqli_stmt_store_result($s);
        global $projectId, $projectName, $projectCreationDate, $projectUserId;

        echo $projectId." ".$projectName;


        while (mysqli_stmt_fetch($s)) 
        {
            global $projectId, $projectName, $projectCreationDate, $projectUserId;
            echo $projectId." ".$projectName;
            //Total cost project
            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $t = mysqli_prepare($conn, "SELECT SUM(projectcostAmount) FROM projectcosts WHERE projectcostCostId = ? ;");
            mysqli_stmt_bind_param($t, 'i', $projectId);
            mysqli_stmt_execute($t);
            mysqli_stmt_bind_result($t, $totalcost);
            mysqli_stmt_store_result($t);

            

            while (mysqli_stmt_fetch($t))
            {
                
                echo $totalcost;
                global $projectId, $projectName, $projectCreationDate, $projectUserId;
                $record = '<td>'.$projectId.'</td><td>'.
                $projectName.'</td><td>'.
                $projectCreationDate.'</td><td>'.
                $totalcost.'</td><td><a href="../Webpages/editproject.php?id="'.
                $projectId.'">Bewerk</a></td>';
                echo $record;
            }

            //Table with project data
            //$record = '<td>'.$projectId.'</td><td>'.
            //$projectName.'</td><td>'.
            //$projectCreationDate.'</td><td>'.
            //$totalcost.'</td><td><a href="../Webpages/editproject.php?id="'.
            //$projectId.'">Bewerk</a></td>';
            //echo $record;
        } 
    }
}
?>

<?php include_once '../Referencepages/footer.php' ?>