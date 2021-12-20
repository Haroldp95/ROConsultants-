<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<!-- ? Register Box -->
<div id="register">
      <div class="container">
        <div class="row">
          <div class="loginContainer col-md-6">
            <div class="col-md-12">
              <form action="../Processpages/createprofiletohome.php" method="post">
                <h3 class="registerText"><i class="far fa-user"></i></h3>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-alt"></i> Voornaam:</label
                  ><br />
                  <input
                    type="text"
                    name="firstname"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-alt"></i> Achternaam:</label
                  ><br />
                  <input
                    type="text"
                    name="lastname"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-tie"></i> Roepnaam:</label
                  ><br />
                  <input
                    type="text"
                    name="nickname"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-birthday-cake"></i> Geboortedatum:</label
                  ><br />
                  <input
                    type="text"
                    name="dateOfBirthDay"
                    id="day"
                    class="form-control input"
                  />
                <select name="dateOfBirthMonth" class="drowpdown" data-style="btn-inverse">
                  <option value="1">Januari</option>
                  <option value="2">Februari</option>
                  <option value="3">Maart</option>
                  <option value="4">April</option>
                  <option value="5">Mei</option>
                  <option value="6">Juni</option>
                  <option value="7">Juli</option>
                  <option value="8">Augustus</option>
                  <option value="9">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
              </select>
              <input
                    type="text"
                    name="dateOfBirthYear"
                    id="year"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-venus-mars"></i> Geslacht:</label
                  ><br />
                  <select name="gender" class="drowpdown" data-style="btn-inverse">
                    <option value="men">Man</option>
                    <option value="woman">Vrouw</option>
                    <option value="neutral">Neutraal</option>
                </select>
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-envelope"></i> Email:</label
                  ><br />
                  <input
                    type="text"
                    name="email"
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
                    name="passwordRepeat"
                    id="password"
                    class="form-control input"
                  />
                </div>

                  <br>
                  <input
                    type="submit"
                    name="createAccount"
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