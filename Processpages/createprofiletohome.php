<?php
session_start();

if (!isset($_POST["createAccount"])) 
{
    header("location: ../Webpages/error.php");
    exit();
} 
else 
{
    //Data form
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $nickname = htmlspecialchars($_POST["nickname"]);
    $gender = htmlspecialchars($_POST["gender"]);
    $dateOfBirth = htmlspecialchars($_POST["dateOfBirth"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $passwordRepeat = htmlspecialchars($_POST["passwordRepeat"]);
    $profilestatus = 1;
    $creationdate = date("Y-m-d H:i:s");

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

    if (empty($firstname) || empty($lastname) || empty($nickname) || 
        empty($gender) || empty($dateOfBirth) || empty($email) || empty($password) || 
        empty($passwordRepeat)) 
    {
        header("location: ../Webpages/createprofile.php?error=emptyField");
        exit();
    }
    else if (!CheckInputA($firstname) || !CheckInputA($lastname) || !CheckInputA($nickname)) 
    {
        header("location: ../Webpages/createprofile.php?error=invalidInput");
        exit();
    }
    else if (!CheckInputB($firstname) || !CheckInputB($lastname) || !CheckInputB($nickname)) 
    {
        header("location: ../Webpages/createprofile.php?error=invalidInput");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        header("location: ../Webpages/createprofile.php?error=invalidEmail");
        exit();
    }
    else if ($password !== $passwordRepeat) 
    {
        header("location: ../Webpages/createprofile.php?error=invalidPassword");
        exit();
    }

    //Check email
    $stmt = mysqli_prepare($conn, "SELECT userEmail FROM users WHERE userEmail = ?;");
    mysqli_stmt_bind_param($stmt, 's', $email );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) 
    {
        header("location: ../Webpages/createprofile.php?error=invalidEmail");
        exit();
    }

    //Add data to db
    $stmt = mysqli_prepare($conn, "INSERT INTO 
    users(userFirstName, userLastName, userNickName, userGender, 
    userDateOfBirth, userEmail, userPassword, userProfileStatus, 
    userAccountCreationDate) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssssis", $firstname, $lastname, $nickname, $gender, 
    $dateOfBirth, $email, $hashedPassword, $profilestatus, $creationdate);
    mysqli_stmt_execute($stmt);

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