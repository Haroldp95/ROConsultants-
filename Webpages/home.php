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

    //Standard input when form isn't filled in
    if (!isset($_POST["filterProjects"]))
    {
        $filterUsers = "ownProjects";
        $filterDate = "3month";
    }

    if (!isset($_POST["filterProjectsUsers"]))
    {
        $filterUsers = "ownProjects";
    }
    else
    {
        $filterUsers = $_POST["filterProjectsUsers"];
    }

    if (!isset($_POST["filterProjectsDate"]))
    {
        $filterDate = "3months";
    }
    else 
    {
        $filterDate = $_POST["filterProjectsDate"];
    }

    //Deciding content home page
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
                mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsersSelect"]);
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
                mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsersSelect"]);
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
                mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsersSelect"]);
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
                mysqli_stmt_bind_param($stmt, 'i', $_POST["filterProjectsUsersSelect"]);
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

    //Gets project id's
    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    $stmt = mysqli_prepare($conn, $sql1);
    sql2();
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $project);
    mysqli_stmt_store_result($stmt);

    //Gets data by project
    $i = 0;
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

        //Empty projects are skipped
        $t2 = mysqli_prepare($conn, "SELECT projectcostId FROM projectcosts WHERE projectcostCodeId = ? ; ");
        mysqli_stmt_bind_param($t2, 'i', $project);
        mysqli_stmt_execute($t2);
        mysqli_stmt_store_result($t2);
        if (mysqli_stmt_num_rows($t2) == 0) {
            continue;
        }

        $st = mysqli_prepare($conn, "SELECT userFirstName, userLastName, userNickName FROM users WHERE userId = ? ;");
        mysqli_stmt_bind_param($st, 'i', $projectUserId);
        mysqli_stmt_execute($st);
        mysqli_stmt_bind_result($st, $userFirstName, $userLastName, $userNickName);
        mysqli_stmt_store_result($st);
        mysqli_stmt_fetch($st);

        //creates table.
        if ($i == 0) 
        {
            echo '<table>
            <tr>
                <td>Projectnummer</td>
                <td>Projectnaam</td>
                <td>Datum</td>
                <td>Totale kosten</td>
                <td>Verantwoordelijke</td>
                <td>Project aanpassen</td>
            </tr>
            
            <tr>
                <td>'.$projectId.'</td>
                <td>
                    <form action="../Webpages/project.php" method="post">
                    <input type="hidden" name="viewId" value="'.$projectId.'">
                    <input type="submit" name="viewProject" value="'.$projectName.'"></form>
                </td>
                <td>'.$projectCreationDate.'</td>
                <td>'.$totalcost.'</td>
                <td>'.$userFirstName.' '.$userLastName.'</td>
                <td>
                    <form action="../Webpages/editproject.php" method="post">
                    <input type="hidden" name="editId" value="'.$projectId.'">
                    <input type="submit" name="editProject" value="Bewerk"></form>
                </td>
            </tr>';
        }
        else 
        {
            echo '<tr>
            <td>'.$projectId.'</td>
            <td>
                <form action="../Webpages/project.php" method="post">
                <input type="hidden" name="viewId" value="'.$projectId.'">
                <input type="submit" name="viewProject" value="'.$projectName.'"></form>
            </td>
            <td>'.$projectCreationDate.'</td>
            <td>'.$totalcost.'</td>
            <td>'.$userFirstName.' '.$userLastName.'</td>
            <td>
                <form action="../Webpages/editproject.php" method="post">
                <input type="hidden" name="editId" value="'.$projectId.'">
                <input type="submit" name="editProject" value="Bewerk"></form>
            </td>
            </tr>';
        }
        $i++;
    }
    if ($i > 0)
    {
        echo '</table>';
    }

    //Gets empty projects
    $stm = mysqli_prepare($conn, 'SELECT projectId, projectName, 
    projectCreationDate, projectUserId FROM projects WHERE projectUserId = ? ;');
    mysqli_stmt_bind_param($stm, 'i', $_SESSION["userId"]);
    mysqli_stmt_execute($stm);
    mysqli_stmt_bind_result($stm, $aId, $aName, $aDate, $aUserId);
    mysqli_stmt_store_result($stm);

    while (mysqli_stmt_fetch($stm))
    {
        $stm2 = mysqli_prepare($conn, 'SELECT projectcostId FROM projectcosts WHERE projectcostCodeId = ? ;');
        mysqli_stmt_bind_param($stm2, 'i', $aId);
        mysqli_stmt_execute($stm2);
        mysqli_stmt_store_result($stm2);
        
        if (mysqli_stmt_num_rows($stm2) == 0) {
            echo '<table>
                <tr>
                    <td>
                    '.$aName.'
                    </td>
                    <td>
                        <form action="../Webpages/editproject.php" method="post">
                        <input type="hidden" name="editId" value="'.$aId.'">
                        <input type="submit" name="editProject" value="Bewerk"></form>
                    </td>
                </tr>
            </table>';
        }
    }
}
?>

<?php include_once '../Referencepages/footer.php' ?>