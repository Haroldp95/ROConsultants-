<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<div>
    <p>Account aanmaken!</p>
    <form action="../Processpages/createprofiletohome.php" method="post">
        <input type="text" name="firstname" id="" placeholder="Voornaam">
        <input type="text" name="lastname" id="" placeholder="Achternaam">
        <input type="text" name="nickname" id="" placeholder="Roepnaam">
        <input type="radio" name="gender" value="men" id="genderMen">
        <label for="genderMen">Men</label>
        <input type="radio" name="gender" value="woman" id="genderWoman">
        <label for="genderMen">Woman</label>
        <input type="radio" name="gender" value="neutral" id="genderNeutral">
        <label for="genderMen">Neutral</label>
        <input type="date" name="dateOfBirth" id="">
        <input type="email" name="email" id="" placeholder="Emailadres">
        <input type="password" name="password" id="">
        <input type="password" name="passwordRepeat" id="">
        <input type="submit" name="createAccount" value="Create account">
    </form>
    <?php 
        //Errors
        if (isset($_GET["error"])) 
        {
            $error = $_GET["error"];
            if ($error == "emptyField") 
            {
                echo '<div class="error"><p>U moet alle velden invullen!</p></div>';
            } 
            else if ($error == "invalidInput") 
            {
                echo '<div class="error"><p>Ongeldige input!</p></div>';
            } 
            else if ($error == "invalidEmail") 
            {
                echo '<div class="error"><p>Ongeldige email!</p></div>';
            } 
            else if ($error == "invalidPassword") 
            {
                echo '<div class="error"><p>Wachtwoord verkeerd!</p></div>';
            } 
            else 
            {
                echo '<div class="error"><p>Error!</p></div>';
            }
        }
    ?>
</div>

<?php include_once '../Referencepages/footer.php' ?>