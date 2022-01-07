<?php
session_start();

if (!isset($_SESSION["userId"]))
{
    header("location: ../Webpages/login.php");
    exit();
}
else
{
    if (!isset($_POST["createproject"]))
    {
        header("location: ../Webpages/error.php");
        exit();
    }
    else 
    {
        //Data form
        $projectname = htmlspecialchars($_POST["projectname"]);
        $projectdate = date("Y-m-d H:i:s");

        //Connection
        $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
        if (!$conn) 
        {
            header("location: ../Webpages/error.php");
            exit();
        }

        //Invalid input
        function CheckInputA($input) 
        {
            return preg_match("/^[a-zA-Z -]*$/", $input);
        }
        function CheckInputB($input) 
        {
            return preg_match("/[^ -]/", $input);
        }

        if (empty($projectname)) 
        {
            header("location: ../Webpages/createproject.php?error=emptyField");
            exit();
        }
        else if (!CheckInputA($projectname)) 
        {
            header("location: ../Webpages/createproject.php?error=invalidInput");
            exit();
        }
        else if (!CheckInputB($projectname))
        {
            header("location: ../Webpages/createproject.php?error=invalidInput");
            exit();
        }

        //Add data to db
        $stmt = mysqli_prepare($conn, "INSERT INTO 
        projects(projectName, projectCreationDate, projectUserId) VALUES(?, ?, ?) ;");
        mysqli_stmt_bind_param($stmt, "ssi", $projectname, $projectdate, $_SESSION["userId"]);
        mysqli_stmt_execute($stmt);

        //Get data from db
        //Niet goed, maar ja
        $stmt = mysqli_prepare($conn, "SELECT MAX(projectId) FROM projects;");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $rProjectId);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_fetch($stmt);

        $stmt = mysqli_prepare($conn, "INSERT INTO projectmembers(memberProjectId, memberUserId) 
        VALUES(?, ?) ;");
        mysqli_stmt_bind_param($stmt, "ii", $rProjectId, $_SESSION["userId"]);
        mysqli_stmt_execute($stmt);

        //Creating session values
        $_SESSION["editProjectId"] = $rProjectId;

        header("location: ../Webpages/editproject.php");
    }
}