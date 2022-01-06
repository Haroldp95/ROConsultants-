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

    //Edit project
    if (mysqli_stmt_num_rows($stmt) > 0)
    {
        $i = 0;
        while (mysqli_stmt_fetch($stmt))
        {
            if ($i == 0)
            {
                //Edit project name
                $editProjectContent1 = '<form action="../Processpages/editprojecttoproject.php" method="post">
                <input type="hidden" name="editId" value="'.$vProjectId.'">
                <p>Projectnaam</p>
                <input type="text" name="editProjectName" placeholder="Projectnaam" value="'.$vProjectName.'">';
                
                $editProjectContent1 .= '<p>Projectkosten</p>
                <table id="tableEditCostId">
                
                    <thead>
                        <tr>
                            <td>Kostencode</td>
                            <td>Kostenomschrijving</td>
                            <td>Datum</td>
                            <td>Bedrag</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="addCost0" style="display:none;">
                            <td>Kostencode(JavaScript)</td>
                            <td><select name="editProjectCostSelect'. $i .'" id="select0">';
    
                            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
                            $m = mysqli_prepare($conn, "SELECT costId, costName FROM costs;");
                            mysqli_stmt_execute($m);
                            mysqli_stmt_bind_result($m, $rCostId, $rCostName);
                            mysqli_stmt_store_result($m);
    
                            while (mysqli_stmt_fetch($m)) 
                            {
                                if ($rCostId == $vCostId)
                                {
                                    $editProjectContent1 .= '<option value="'.$rCostId.'">'.
                                    $rCostName.'</option>';
                                }
                                else
                                {
                                    $editProjectContent1 .= '<option value="'.$rCostId.'">'.
                                    $rCostName.'</option>';
                                }
                            }
    
                            $today = date("d-m-Y");
                            $editProjectContent1 .= '</td>
                            <td><input type="text" name="editProjectDate" placeholder="DD-MM-YYYY" 
                            value="'.strftime("%d-%m-%Y", strtotime($today)).'"></td>
                            <td><input type="number" step="0.01" value="0"></td>
    
                        </tr>
                        <tr id="addCost1">
                            <td>Kostencode(JavaScript)</td>
                            <td><select name="editProjectCostSelect'. $i + 1 .'">';
    
                            $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
                            $m = mysqli_prepare($conn, "SELECT costId, costName FROM costs;");
                            mysqli_stmt_execute($m);
                            mysqli_stmt_bind_result($m, $rCostId, $rCostName);
                            mysqli_stmt_store_result($m);
    
                            while (mysqli_stmt_fetch($m)) 
                            {
                                if ($rCostId == $vCostId)
                                {
                                    $editProjectContent1 .= '<option value="'.$rCostId.'" selected>'.
                                    $rCostName.'</option>';
                                }
                                else
                                {
                                    $editProjectContent1 .= '<option value="'.$rCostId.'">'.
                                    $rCostName.'</option>';
                                }
                            }
    
                            $editProjectContent1 .= '</td>
                            <td><input type="text" name="editProjectDate'. $i + 1 .'" placeholder="DD-MM-YYYY" 
                            value="'.strftime("%d-%m-%Y", strtotime($vCostDate)).'"></td>
                            <td><input name="editProjectAmount'. $i + 1 .'" type="number" step="0.01" value="'.$vCostAmount.'"></td>
                        </tr>';
                
                echo $editProjectContent1;
            }
            else
            {
                $editProjectContent2 = '
                    <tr id="addCost'. $i + 1 .'">
                        <td>Kostencode(JavaScript)</td>
                        <td><select name="editProjectCostSelect'. $i + 1 .'">';
    
                        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
                        $m = mysqli_prepare($conn, "SELECT costId, costName FROM costs;");
                        mysqli_stmt_execute($m);
                        mysqli_stmt_bind_result($m, $rCostId, $rCostName);
                        mysqli_stmt_store_result($m);
    
                        while (mysqli_stmt_fetch($m)) 
                        {
                            if ($rCostId == $vCostId)
                            {
                                $editProjectContent2 .= '<option value="'.$rCostId.'" selected>'.
                                $rCostName.'</option>';
                            }
                            else
                            {
                                $editProjectContent2 .= '<option value="'.$rCostId.'">'.
                                $rCostName.'</option>';
                            }
                        }
    
                        $editProjectContent2 .= '</td>
                        <td><input type="text" name="editProjectDate'. $i + 1 .'" placeholder="DD-MM-YYYY" 
                        value="'.strftime("%d-%m-%Y", strtotime($vCostDate)).'"></td>
                        <td><input name="editProjectAmount'. $i + 1 .'" type="number" step="0.01" value="'.$vCostAmount.'"></td>
                    </tr>
                    ';
                
                echo $editProjectContent2;
            }
            $i++;
        }
        echo '
            <input type="hidden" name="counterAddCost" value="'. $i + 1 .'" id="counterAddCostId">
            </tbody></table>
            <input type="button" onclick="addCostProject()" value="Toevoegen kostenpost">
            <input type="button" onclick="removeCostProject()" value="Verwijderen kostenpost">   
        ';
    }
    else 
    {
        $editProjectContent3 = ''
    }

    //Add projectmember
    /*
    $st = mysqli_prepare($conn, 'SELECT userId, userFirstName, userLastName FROM users ;');
    mysqli_stmt_execute($st);
    mysqli_stmt_bind_result($st, $rUserId, $rFirstName, $rLastName);
    mysqli_stmt_store_result($st);

    $j = 0;
    while (mysqli_stmt_fetch($st))
    {
        if ($j == 0)
        {
            echo '<p>Toevoegen projectleden</p>';
            $addMember1 = '<table id="tableAddMember">
                <input type="hidden" name="counterAddMember" value="0" id="counterAddMemberId">
                <tr style="display:none;" id="memberrow0">
                    <td>
                    <select name="editProjectAddMember" id="select00">';

                    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
                    $s = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName FROM users;");
                    mysqli_stmt_execute($s);
                    mysqli_stmt_bind_result($s, $rUserId2, $rFirstName2, $rLastName2);
                    mysqli_stmt_store_result($s);

                    $addMember1 .= '<option value="0">Geen extra projectlid</option>';

                    while (mysqli_stmt_fetch($s)) 
                    {
                        $addMember1 .= '<option value="'.$rUserId2.'">'.
                        $rFirstName2.' '.$rLastName2.'</option>';
                    }
            $addMember1 .= '</select></td></tr>';
            $addMember1 .=  '

                <input type="button" onclick="addMemberProject()" value="Toevoegen projectlid">
                <input type="button" onclick="removeMemberProject()" value="Verwijderen projectlid">
                ';
        }
    }
    echo '<p>Toevoegen projectleden</p>';
    $addMember = '<table id="tableAddMember">
        <input type="hidden" name="counterAddMember" value="0" id="counterAddMemberId">
        <tr style="display:none;" id="memberrow0">
            <td>
            <select name="editProjectAddMember" id="select00">';

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
    $addMember .= '</select></td></tr></table>
        <input type="button" onclick="addMemberProject()" value="Toevoegen projectlid">
        <input type="button" onclick="removeMemberProject()" value="Verwijderen projectlid">
        ';
    
    */
    //echo $addMember;
    //echo '<button onclick="addMemberProject">Toevoegen projectlid</button>';

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