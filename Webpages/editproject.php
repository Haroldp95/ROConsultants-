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
    costs.costName, projectcosts.projectcostId, projectcosts.projectcostDate, users.userFirstName, users.userLastName, 
    projectcosts.projectcostAmount FROM projectcosts 
    INNER JOIN projects ON projectcosts.projectcostCodeId = projects.projectId
    INNER JOIN users ON projectcosts.projectcostUserId = users.userId
    INNER JOIN costs ON projectcosts.projectcostCostId = costs.costId
    WHERE projectcostCodeId = ? ;");
    mysqli_stmt_bind_param($stmt, 'i', $editProjectId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $vProjectId, $vProjectName, 
    $vCostId, $vCostName, $vProjectCostId, $vCostDate, $vFirstName, $vLastName, $vCostAmount);
    mysqli_stmt_store_result($stmt);

    //Creates table
    $i = 0;
    while (mysqli_stmt_fetch($stmt))
    {
        if ($i == 0)
        {
            //First row: project id, projectname, cost id, 
            //description, date, name person, cost amount
            $editProjectContent1 = '<form action="../Processpages/editprojecttoproject.php" method="post">
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
                <td>Kostenpost verwijderen</td>
            </tr>

            <tr>
                <td>'.$vProjectId.'</td>
                <td><input type="text" name="editProjectName" placeholder="Projectnaam" value="'.$vProjectName.'"></td>
                <td>'.$vCostId.'</td>
                <td>
                <select name="editProjectCostSelect">';

                $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
                $m = mysqli_prepare($conn, "SELECT costId, costName FROM costs;");
                mysqli_stmt_execute($m);
                mysqli_stmt_bind_result($m, $rCostId, $rCostName);
                mysqli_stmt_store_result($m);

                while (mysqli_stmt_fetch($m)) 
                {
                    $editProjectContent1 .= '<option value="'.$rCostId.'">'.
                    $rCostName.'</option>';
                }


                $editProjectContent1 .= '</select></td>
                <td><input type="text" name="editProjectDate" placeholder="DD-MM-YYYY" 
                value="'.strftime("%d-%m-%Y", strtotime($vCostDate)).'"></td>
                <td>
                <select name="editProjectMemberSelect">';

                $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
                $s = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName FROM users;");
                mysqli_stmt_execute($s);
                mysqli_stmt_bind_result($s, $rUserId, $rFirstName, $rLastName);
                mysqli_stmt_store_result($s);

                while (mysqli_stmt_fetch($s)) 
                {
                    $editProjectContent1 .= '<option value="'.$rUserId.'">'.
                    $rFirstName.' '.$rLastName.'</option>';
                }

                $editProjectContent1 .= '</select></td>
                <td><input type="number" step="0.01" value="'.$vCostAmount.'"></td>
                <td><input type="checkbox" name="cost'.$vProjectCostId.'" value="c'.$vProjectCostId.'"></td>
            </tr>';

            echo $editProjectContent1;

        }
        else
        {
            //Second row: empty, empty, cost id, 
            //description, date, name person, cost amount
            $editProjectContent2 = '<tr>
            <td></td>
            <td></td>
            <td>'.$vCostId.'</td>
            <td>
            <select name="editProjectCostSelect'.$i.'">';

            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $m = mysqli_prepare($conn, "SELECT costId, costName FROM costs;");
            mysqli_stmt_execute($m);
            mysqli_stmt_bind_result($m, $rCostId, $rCostName);
            mysqli_stmt_store_result($m);

            while (mysqli_stmt_fetch($m)) 
            {
                $editProjectContent2 .= '<option value="'.$rCostId.'">'.
                $rCostName.'</option>';
            }

            $editProjectContent2 .= '</select></td>
            <td><input type="text" name="editProjectDate" placeholder="DD-MM-YYYY" 
            value="'.strftime("%d-%m-%Y", strtotime($vCostDate)).'"></td>
            <td>
            <select name="editProjectMemberSelect'.$i.'">';

            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $s = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName FROM users;");
            mysqli_stmt_execute($s);
            mysqli_stmt_bind_result($s, $rUserId, $rFirstName, $rLastName);
            mysqli_stmt_store_result($s);

            while (mysqli_stmt_fetch($s)) 
            {
                $editProjectContent2 .= '<option value="'.$rUserId.'">'.
                $rFirstName.' '.$rLastName.'</option>';
            }

            $editProjectContent2 .= '</select></td>
            <td><input type="number" step="0.01" value="'.$vCostAmount.'"></td>
            <td><input type="checkbox" name="cost'.$vProjectCostId.'" value="c'.$vProjectCostId.'"></td>
            </tr>';

            echo $editProjectContent2;
        }
        $i++;
    }
    //Last row: empty, empty, empty, empty, empty, total:, sum(costs)
    /*
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
    </tr> */
    echo '</table>';

    //Add cost
    echo '<p>Toevoegen kosten</p>';
    $addCost = '<table id="tableAddCost">
        <input type="hidden" name="counterAddCost" value="0" id="counterAddCostId">
        <tr id="costrow0">
            <td>Kostencode(javascript)</td>
            <td>
            <select name="editProjectAddCostSelect" id="editProjectAddCostSelectId">';

            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $m = mysqli_prepare($conn, "SELECT costId, costName FROM costs;");
            mysqli_stmt_execute($m);
            mysqli_stmt_bind_result($m, $rCostId, $rCostName);
            mysqli_stmt_store_result($m);

            while (mysqli_stmt_fetch($m)) 
            {
                $addCost .= '<option value="'.$rCostId.'">'.
                $rCostName.'</option>';
            }

            $today = date("d-m-Y");
            $addCost .= '</select></td>
            <td><input type="text" name="editProjectDate" placeholder="DD-MM-YYYY" 
            value="'.strftime("%d-%m-%Y", strtotime($today)).'"></td>
            <td>
            <select name="editProjectAddMemberSelect">';

            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $s = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName FROM users;");
            mysqli_stmt_execute($s);
            mysqli_stmt_bind_result($s, $rUserId, $rFirstName, $rLastName);
            mysqli_stmt_store_result($s);

            while (mysqli_stmt_fetch($s)) 
            {
                $addCost .= '<option value="'.$rUserId.'">'.
                $rFirstName.' '.$rLastName.'</option>';
            }

            $addCost .= '</select></td>
            <td><input type="number" step="0.01" value="0"></td>
        </tr>
        <tr>
            <td>
                <input type="button" onclick="addCostProject()" value="Toevoegen kostenpost">
            </td>
            <td>
                <input type="button" onclick="removeCostProject()" value="Verwijderen kostenpost">
            </td>
        </tr>
        </table>';
    echo $addCost;
    //echo '<button onclick="addCostProject">Toevoegen kostenpost</button>';

    //Add projectmember
    echo '<p>Toevoegen projectleden</p>';
    $addMember = '<table id="tableAddMember">
        <input type="hidden" name="counterAddMember" value="0" id="counterAddMemberId">
        <tr id="memberrow0">
            <td>
            <select name="editProjectAddMember">';

            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
            $s = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName FROM users;");
            mysqli_stmt_execute($s);
            mysqli_stmt_bind_result($s, $rUserId, $rFirstName, $rLastName);
            mysqli_stmt_store_result($s);

            $addMember .= '<option value="0">Geen extra projectlid</option>';

            while (mysqli_stmt_fetch($s)) 
            {
                $addMember .= '<option value="'.$rUserId.'">'.
                $rFirstName.' '.$rLastName.'</option>';
            }
    $addMember .= '</select></td></tr>
        <tr>
            <td>
                <input type="button" onclick="addMemberProject()" value="Toevoegen projectlid">
            </td>
            <td>
                <input type="button" onclick="removeMemberProject()" value="Verwijderen projectlid">
            </td>
        </tr>
        </table>';

    echo $addMember;
    //echo '<button onclick="addMemberProject">Toevoegen projectlid</button>';

    //End of form
    echo '<input type="submit" name="editProject" value="Wijzigen opslaan">
    <input type="reset" value="Wijzigen resetten">
    </form>
    <form action="../Webpages/project.php" method="post">
    <input type="hidden" name="viewId" value="'.$vProjectId.'">
    <input type="submit" name="viewProject" value="Wijzigen verwerpen">
    </form>';
}
?>

<?php include_once '../Referencepages/footer.php' ?>