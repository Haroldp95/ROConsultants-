<?php
session_start();

if (!isset($_SESSION["userId"]))
{
    header("location: ../Webpages/error.php");
    exit();
}
else
{
    //Discard changes
    if (isset($_POST["viewProject"]))
    {
        $projectId = htmlspecialchars($_POST["viewId"]);
        $_SESSION["viewProjectId"] = $projectId;
        header("location: ../Webpages/project.php");
        exit();
    }

    //Save changes
    if (!isset($_POST["editProject"]))
    {
        header("location: ../Webpages/error.php");
        exit();
    }
    else
    {   
        //Connection
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
        if (!$conn) 
        {
            header("location: ../Webpages/error.php");
            exit();
        }

        //Data form
        $projectId = htmlspecialchars($_POST["editId"]);

        //Functions
        function CheckInputA($input) 
        {
            return preg_match("/^[a-zA-Z -]*$/", $input);
        }
        function CheckInputB($input) 
        {
            return preg_match("/[^ -]/", $input);
        }

        //Projectname
        $projectName = htmlspecialchars($_POST["editProjectName"]);

        
        if (empty($projectName))
        {
            $_SESSION["editProjectId"] = $projectId;
            header("location: ../Webpages/editproject.php?error=emptyField");
            exit();
        }
        else if (!CheckInputA($projectName))
        {
            $_SESSION["editProjectId"] = $projectId;
            header("location: ../Webpages/editproject.php?error=invalidInput");
            exit();
        }
        else if (!CheckInputB($projectName))
        {
            $_SESSION["editProjectId"] = $projectId;
            header("location: ../Webpages/editproject.php?error=invalidInput");
            exit();
        }

        $s1 = mysqli_prepare($conn, 'UPDATE projects SET projectName = ? ;');
        mysqli_stmt_bind_param($s1, "s", $projectName);
        mysqli_stmt_execute($s1);

        //Project costs
        //Delete all outdated costs
        $s2 = mysqli_prepare($conn, 'DELETE FROM projectcosts WHERE projectcostCodeId = ? ;');
        mysqli_stmt_bind_param($s2, "i", $projectId);
        mysqli_stmt_execute($s2);

        //Add new costs
        $countCost = htmlspecialchars($_POST["counterAddCost"]);
        $i = 0;
        while ($i < ($countCost + 1))
        {
            $costDesc = htmlspecialchars($_POST["editProjectCostSelect".$i]);
            if (!empty($costDesc))
            {
                $v1 = $costDesc;
            }


            $costDate = htmlspecialchars($_POST["editProjectDate".$i]);
            if (!empty($costDate))
            {
                $createDate = date_create_from_format("d-m-Y", $costDate);
                $costDate = date_format($createDate, "Y-m-d");
                $v2 = $costDate;
            }

            $costAmount = htmlspecialchars($_POST["editProjectAmount".$i]);
            if (!empty($costAmount))
            {
                $v3 = $costAmount;
            }

            if (isset($v1) && isset($v2) && isset($v3))
            {
                $v4 = date("Y-m-d H:i:s");

                $s3 = mysqli_prepare($conn, 'INSERT INTO projectcosts(projectcostDate, 
                projectcostCreationDate, projectcostAmount, projectcostCodeId, projectcostUserId, 
                projectcostCostId) VALUES(?, ?, ?, ?, ?, ?) ;');
                mysqli_stmt_bind_param($s3, "ssiiii", $v2, $v4, $v3, $projectId, $_SESSION["userId"], $v1);
                mysqli_stmt_execute($s3);
            }

            $v1 = NULL;
            $v2 = NULL;
            $v3 = NULL;

            $i++;
        }

        //Add new member
        

        $_SESSION["viewProjectId"] = $projectId;
        header("location: ../Webpages/project.php");
        exit();

        //Invalid input
    }
}