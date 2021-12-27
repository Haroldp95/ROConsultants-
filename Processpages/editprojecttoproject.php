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

        //Invalid input
    }
}