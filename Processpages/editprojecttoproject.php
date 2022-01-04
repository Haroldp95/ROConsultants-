<?php
session_start();

if (!isset($_SESSION["userId"]))
{
    header("location: ../Webpages/error.php");
    exit();
}
else
{
    if (!isset($_POST["editProject"]))
    {
        header("location: ../Webpages/error.php");
        exit();
    }
    else
    {
        //Te doen:
        //  - Input moet anders, Projectnaam apart, kosten bijelkaar en projectleden bij elkaar
        //  - Bij input moeten alle inputs een unieke naam hebben, anders erg lastig.
        //  - De unieke input naam moet gebonden zijn aan tabel rij (costrow4 = costrowAmount4).
        //  - Pas als input goed is, dan data verwerking maken.
        
        //Data form
        $numberOfeRows = htmlspecialchars($_POST["editIdC"]);
        $numberOfCostRows = (htmlspecialchars($_POST["counterAddCost"])) + 1;
        $numberOfMemberRows = (htmlspecialchars($_POST["counterAddMember"])) + 1;

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
        //test

        //Invalid input
    }
}