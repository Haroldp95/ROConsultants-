<?php
session_start();

if (!isset($_POST["login"])) 
{
    header("location: ../Webpages/error.php");
    exit();
} 
else 
{
    //Data form
    $emailLogin = htmlspecialchars($_POST["emailLogin"]);
    $passwordLogin = htmlspecialchars($_POST["passwordLogin"]);

    //Connection
    $conn = mysqli_connect('localhost', 'root', '', 'roconsultants');
    if (!$conn) 
    {
        header("location: ../Webpages/error.php");
        exit();
    }

    //Invalid input
    if (empty($emailLogin) || empty($passwordLogin)) 
    {
        header("location: ../Webpages/login.php?error=emptyField");
        exit();
    }
    else if (!filter_var($emailLogin, FILTER_VALIDATE_EMAIL)) 
    {
        header("location: ../Webpages/login.php?error=invalidEmail");
        exit();
    }

    //Check password with db.
    $stmt = mysqli_prepare($conn, "SELECT userPassword FROM users WHERE userEmail = ? ;");
    mysqli_stmt_bind_param($stmt, 's', $emailLogin );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $rPassword);
    mysqli_stmt_fetch($stmt);
    $checkPassword = password_verify($passwordLogin, $rPassword);

    if ($checkPassword !== true) 
    {
        header("location: ../Webpages/login.php?error=invalidPassword");
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

        //Get data from db
        $stmt = mysqli_prepare($conn, "SELECT userId, userFirstName, userLastName, userNickName, 
        userGender, userDateOfBirth, userEmail, userProfileStatus, userAccountCreationDate 
        FROM users WHERE userEmail = ?;");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $rId, $rFirstName, $rLastName, $rNickName, 
        $rGender, $rDateOfBirth, $rEmail, $rProfileStatus, $rCreationDate);
        mysqli_stmt_fetch($stmt);

        //Creating session values
        $_SESSION["userId"] = $rId;
        $_SESSION["userFirstName"] = $rFirstName;
        $_SESSION["userLastName"] = $rLastName;
        $_SESSION["userNickName"] = $rNickName;
        $_SESSION["userGender"] = $rGender;
        $_SESSION["userDateOfBirth"] = $rDateOfBirth;
        $_SESSION["userEmail"] = $rEmail;
        $_SESSION["userProfileStatus"] = $rProfileStatus;
        $_SESSION["userAccountCreationDate"] = $rCreationDate;

        header("location: ../Webpages/home.php");
    }
}