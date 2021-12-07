<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<!-- ? Login Box -->
    <div id="login">
      <div class="container">
        <div class="row">
          <div class="loginContainer col-md-6">
            <div class="col-md-12">
              <form action="../Processpages/logintohome.php" method="post">
                <h3 class="loginText"><i class="fas fa-key"></i> Login</h3>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-alt"></i> Gebruikersnaam/email:</label
                  ><br />
                  <input
                    type="text"
                    name="emailLogin"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-unlock-alt"></i> Wachtwoord:</label
                  ><br />
                  <input
                    type="text"
                    name="passwordLogin"
                    id="password"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="remember" class="userText"
                    ><span><i class="fas fa-bookmark"></i> Onthoud Mij </span
                    > <span
                      ><input
                        id="remember"
                        name="remember"
                        type="checkbox" /></span></label
                  ><br /><br />
                  <input
                    type="submit"
                    name="login"
                    class="btn btn-info btn-md submitBtn"
                    value="Inloggen"
                  />
                </div>
                <div id="aanmelden" class="text-right">
                  <a href="#" class="userText">Aanmelden</a>
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
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


<?php include_once '../Referencepages/footer.php' ?>