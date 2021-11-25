<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<div>
    <p>Inloggen</p>
    <form action="../Processpages/logintohome.php" method="post">
        <input type="email" name="emailLogin" id="" placeholder="Emailadres">
        <input type="password" name="passwordLogin" id="" placeholder="Wachtwoord">
        <input type="submit" name="login" value="Inloggen">
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