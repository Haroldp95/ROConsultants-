<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<div>
    <form action="../Processpages/createprojecttoeditproject.php" method="post">
        <input type="text" name="projectname" id="" placeholder="Project naam">
        <input type="submit" name="createproject" value="Maak project">
    </form>
</div>
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
        else 
        {
            echo '<div class="error"><p>Error!</p></div>';
        }
    }
?>
</div>

<?php include_once '../Referencepages/footer.php' ?>