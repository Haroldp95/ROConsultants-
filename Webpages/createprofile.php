<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<!-- ? Register Box -->
<div id="register">
      <div class="container">
        <div class="row">
          <div class="loginContainer col-md-6">
            <div class="col-md-12">
              <form action="" method="post">
                <h3 class="registerText"><i class="far fa-user"></i></h3>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-alt"></i> Naam:</label
                  ><br />
                  <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-alt"></i> Achter Naam:</label
                  ><br />
                  <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-tie"></i> Gebruikers Naam:</label
                  ><br />
                  <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-birthday-cake"></i> Geboorte Datum:</label
                  ><br />
                  <input
                    type="text"
                    name="day"
                    id="day"
                    class="form-control input"
                  />
                <select class="drowpdown" data-style="btn-inverse">
                  <option>Januari</option>
                  <option>Februari</option>
                  <option>Maart</option>
                  <option>April</option>
                  <option>Mei</option>
                  <option>Juni</option>
                  <option>Juli</option>
                  <option>Augustus</option>
                  <option>September</option>
                  <option>October</option>
                  <option>November</option>
                  <option>December</option>
              </select>
              <input
                    type="text"
                    name="year"
                    id="year"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-venus-mars"></i> Geslacht:</label
                  ><br />
                  <select class="drowpdown" data-style="btn-inverse">
                    <option>Man</option>
                    <option>Vrouw</option>
                    <option>Neutraal</option>
                </select>
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-envelope"></i> Email:</label
                  ><br />
                  <input
                    type="text"
                    name="password"
                    id="password"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-phone"></i> Telefoon Nummer:</label
                  ><br />
                  <input
                    type="text"
                    name="password"
                    id="password"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-lock"></i> Wachtwoord:</label
                  ><br />
                  <input
                    type="text"
                    name="password"
                    id="password"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-lock"></i> Herhaal Wachtwoord:</label
                  ><br />
                  <input
                    type="text"
                    name="password"
                    id="password"
                    class="form-control input"
                  />
                </div>

                  <br>
                  <input
                    type="submit"
                    name="aanmelden"
                    class="btn btn-info btn-md submitBtn"
                    value="Aanmelden"
                  />
                </div>
                <div id="aanmelden" class="text-right">
                  <a href="#" class="userText"
                    ><i class="fas fa-arrow-left"></i> Terug Naar Inloggen</a
                  >
                </div>
              </form>
            </div>
          </div>
        </div>
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